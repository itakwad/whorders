<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
// الحقول المسموح بتعبئتها
    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'sort_order',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
}
}
