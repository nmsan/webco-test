<?php

namespace App\Actions;

use App\Models\ProductType;

class FetchApiUniqueNumber
{
    public function __invoke(ProductType $productType): string
    {
        // Here you would implement the actual API call logic
        // For demonstration, we're using a placeholder implementation
        $uniqueNumber = sprintf(
            'API-%s-%s',
            strtoupper(substr(str_replace(' ', '', $productType->name), 0, 3)),
            uniqid()
        );

        return $uniqueNumber;
    }
}
