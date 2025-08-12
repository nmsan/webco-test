<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FilamentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('secret123'), // change to a secure password
            ]
        );

        // If your users table has is_admin column
        if (schemaHasColumn('users', 'is_admin')) {
            $user->is_admin = true;
            $user->save();
        }

        // If you’re using Spatie permissions or Filament Shield
        // $user->assignRole('super_admin');

        $this->command->info("Filament admin user created: admin@test.com / secret123");
    }
}

/**
 * Helper to check if a DB column exists.
 */
function schemaHasColumn(string $table, string $column): bool
{
    return \Schema::hasColumn($table, $column);
}
