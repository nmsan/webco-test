<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['name', 'product_category_id', 'product_color_id', 'description', 'is_proceed'];

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

public function types()
{
    return $this->morphToMany(ProductType::class, 'type_assignments')
        ->withPivot('my_bonus_field')
        ->withTimestamps();
}


    /**
     * Override the category assignment to enforce the business rule
     *
     * @throws \InvalidArgumentException when the category is invalid or doesn't share types with the product
     */
    public function setProductCategoryIdAttribute($value)
    {
        if ($value === null) {
            $this->attributes['product_category_id'] = null;
            return;
        }

        $category = ProductCategory::find($value);

        if (!$category) {
            throw new \InvalidArgumentException('Invalid category ID');
        }


        // If product has no types yet (new product being created), allow the category
        if (empty($productTypeIds)) {
            $this->attributes['product_category_id'] = $value;
            return;
        }

        if (!$this->isValidCategory($category)) {
            throw new \InvalidArgumentException('Selected category must share at least one product type with the product');
        }

        $this->attributes['product_category_id'] = $value;
    }
}
