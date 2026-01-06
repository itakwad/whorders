<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'cover_image',
        'address',
        'phone',
        'facebook',
        'whatsapp',
        'is_active',
        'open_time',
        'close_time',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i',
    ];

    // البائع صاحب المتجر
    public function user()
    {
        // يجب أن يكون المفتاح الأجنبي هو user_id
        return $this->belongsTo(User::class, 'user_id');
    }

// أضف هذه الدالة لكي يظهر اسم المتجر في صفحة الاختيار
    public function getTenantName(): string
    {
        return $this->name;
    }

    // هل المتجر مفتوح الآن
    public function isOpenNow(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->open_time || !$this->close_time) {
            return true; // 24 ساعة
        }

        $now = now()->format('H:i');

        return $now >= $this->open_time && $now <= $this->close_time;
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }


    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

    public function extras(): HasMany {
        return $this->hasMany(Extra::class);
    }



}
