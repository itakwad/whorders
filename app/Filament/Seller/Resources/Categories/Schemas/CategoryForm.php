<?php

namespace App\Filament\Seller\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms;
use Filament\Schemas\Components\Section;

use Filament\Schemas\Schema;
use Illuminate\Support\Str;
class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات التصنيف')
                    ->schema([
                        // ربط المتجر (سيتم فلترته لاحقاً حسب المستخدم المسجل)


                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('الاسم')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state,  $set) =>
                            $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->label('الرابط')
                            ->dehydrated()
                            ->required()
                            ->unique(Category::class, 'slug', ignoreRecord: true),


                        Forms\Components\TextInput::make('sort_order')
                            ->label('التريب في العرض')
                            ->numeric()
                            ->default(0),
                    ])->columns(2)
            ]);
    }
}
