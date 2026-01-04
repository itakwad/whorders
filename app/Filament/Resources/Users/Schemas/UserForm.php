<?php

namespace App\Filament\Resources\Users\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Forms\Components\TextInput::make('name')
                    ->label('الاسم') // label عربي
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    // مطلوب فقط عند الإنشاء
                    ->required(fn (string $context): bool => $context === 'create')
                    // لا يتم إرسال الحقل لقاعدة البيانات إذا كان فارغاً (عند التعديل مثلاً)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    // التشفير يتم فقط إذا كان هناك قيمة مدخلة
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null),

                Forms\Components\Select::make('role')
                    ->label('الدور')
                    ->options([
                        'admin' => 'مدير عام',
                        'seller' => 'بائع', // غيرت store_owner إلى seller بناءً على جدولك الجديد
                        'user' => 'مستخدم عادي',
                    ])
                    ->default('user')
                    ->required()
                    ->native(false),
            ]);
    }
}
