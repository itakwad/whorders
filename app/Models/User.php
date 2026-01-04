<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Filament\Panel;

class User extends Authenticatable  implements FilamentUser, HasTenants ,HasDefaultTenant
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // أضف هنا عشان يسمح بتعبئته تلقائيًا
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'user_id');
    }

    // إرجاع المتاجر للـ Filament
    public function getTenants(Panel $panel): Collection
    {
        return $this->stores;
    }

    // التحقق من الصلاحية
    public function canAccessTenant(\Illuminate\Database\Eloquent\Model $tenant): bool
    {
        // تأكد أن الـ user_id في جدول المتاجر يطابق id المستخدم
        return $this->stores->contains($tenant);
    }

    public function canAccessPanel(Panel $panel): bool
    {
       //dd($this->role);

        return match ($panel->getId()) {
            'superadmin'    => $this->role === 'admin',
            'seller' => $this->role === 'seller',
            default    => false,
        };
    }
    public function getDefaultTenant(Panel $panel): ?Model
    {
        return null; // عدم اختيار تلقائي، للسماح بالـ middleware بالتحكم
    }



}
