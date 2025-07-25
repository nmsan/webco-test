<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'external_url'];

    public function types()
    {
        return $this->morphToMany(ProductType::class, 'type_assignments');
    }
}
