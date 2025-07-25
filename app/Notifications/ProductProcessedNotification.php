<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ProductProcessedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Product $product
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'message' => "Product '{$this->product->name}' has been processed",
            'product_id' => $this->product->id,
        ]);
    }
}
