<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Product;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "amount",
        "source",
        "welding",
        "assembly",
        "electro"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function hasProducts(): BelongsToMany {
        return $this->belongsToMany(Product::class, "product_has_component", "component_id", "product_id");
    }
}
