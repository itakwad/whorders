<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Extra extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'price',
        'image'
    ];

    // الإضافة تتبع متجر معين
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    // الإضافة يمكن أن تظهر في عدة منتجات
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
