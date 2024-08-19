<?php

namespace App\Models;

use App\Models\Component;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    
    protected $fillable = [
        "title",
        "position",
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
    public function hasComponents(): BelongsToMany{
        return $this->belongsToMany(Component::class, "product_has_component", "product_id" ,"component_id");
    }
}
