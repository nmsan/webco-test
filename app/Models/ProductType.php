<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'api_unique_number'];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'type_assignments');
    }

    public function categories()
    {
        return $this->morphedByMany(ProductCategory::class, 'type_assignments');
    }

    /**
     * Fetch the API unique number from the external service
     */
    public function fetchApiUniqueNumber(): void
    {
        // Here you would implement the actual API call
        // For now, we'll use a placeholder
        $uniqueNumber = sprintf('API-%s-%s', strtoupper(substr(str_replace(' ', '', $this->name), 0, 3)), uniqid());
        $this->api_unique_number = $uniqueNumber;
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($productType) {
            if (empty($productType->api_unique_number)) {
                $productType->fetchApiUniqueNumber();
            }
        });
    }
}
