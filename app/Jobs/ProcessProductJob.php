<?php

namespace App\Jobs;

use App\Models\Product;
use App\Notifications\ProductProcessedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Product $product
    ) {}

    public function handle(): void
    {
        $this->product->update([
            'is_proceed' => true,
        ]);

        $this->product->notify(new ProductProcessedNotification($this->product));
    }
}
