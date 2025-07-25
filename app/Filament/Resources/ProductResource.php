<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\RelationManagers\TypesRelationManager;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Services\AsmorphicApiService;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use App\Jobs\ProcessProductJob;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('product_category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->required()
                    ->preload(),

                Forms\Components\Select::make('product_color_id')
                    ->relationship('color', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('address')
                    ->label('Address')
                    ->suffixAction(
                        fn($state, $livewire) => Forms\Components\Actions\Action::make('validateAddress')
                            ->label('Validate')
                            ->action(function () use ($state, $livewire) {
                                $service = app(AsmorphicApiService::class);
                                $response = $service->findAddress([
                                    'address' => $state
                                ], config('app.asmorphic.username'),
                                    config('app.asmorphic.username'));;
                                if ($response->successful() && !empty($response->json('data'))) {
                                    Notification::make()
                                        ->title('Address validated!')
                                        ->success()
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title('Address not found or invalid.')
                                        ->danger()
                                        ->send();
                                }
                            })
                    ),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_proceed')
                    ->boolean()
                    ->label('Processed')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('status_bar')
                    ->label('Status')
                    ->html()
                    ->getStateUsing(function (Product $record): string {
                        $hexCode = $record->color?->hex_code ?? '#000000';
                        return "
                            <div style='
                                background-color: {$hexCode};
                                color: white;
                                padding: 8px;
                                border-radius: 4px;
                                text-align: center;
                                width: 100%;
                            '>
                                Hello
                            </div>
                        ";
                    }),

                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('color.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('process')
                    ->label('Process')
                    ->icon('heroicon-o-cog')
                    ->requiresConfirmation()
                    ->action(function (Product $record) {
                        ProcessProductJob::dispatch($record);
                        Notification::make()
                            ->title('Processing Started')
                            ->body('The product is being processed in the background.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('color')
                    ->relationship('color', 'name'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TypesRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

}
