<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    // علاقة المنتج بالمتجر
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    // علاقة المنتج بالتصنيف
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة المنتج بالأحجام والأسعار (One-to-Many)
    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    // علاقة المنتج بالإضافات (Many-to-Many)
    public function extras(): BelongsToMany
    {
        return $this->belongsToMany(Extra::class);
    }

}
