<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TypeAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['type_assignments_type', 'type_assignments_id', 'type_id', 'my_bonus_field'];

    public function assignable()
    {
        return $this->morphTo('type_assignments');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }
}

