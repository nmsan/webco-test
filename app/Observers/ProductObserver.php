<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function saving(Product $product)
    {
        if ($product->product_category_id !== null) {
            $category = $product->category;
//            if (!$product->isValidCategory($category)) {
//                throw new \InvalidArgumentException('Category must share at least one product type with the product');
//            }
        }
    }
}
