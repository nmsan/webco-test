<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'hex_code'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
