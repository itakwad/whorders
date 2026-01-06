<?php

namespace App\Filament\Seller\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Forms;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema ->components([
                        Tabs::make('المنتج')
                            ->tabs([
                                // التبويب الأول: معلومات المنتج الأساسية
                                Tabs\Tab::make('المعلومات الأساسية')
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->relationship('category', 'name') // علاقة المنتج بالتصنيف
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->label('التصنيف'),

                                        Forms\Components\TextInput::make('name')
                                            ->label('اسم المنتج')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Set $set) =>
                                            $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('الرابط المختصر (Slug)')
                                            ->required()
                                            ->unique(Product::class, 'slug', ignoreRecord: true),

                                        Forms\Components\Textarea::make('description')
                                            ->label('الوصف')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('image')
                                            ->label('صورة المنتج')
                                            ->image()
                                            ->disk('public')
                                            ->directory('products')
                                            ->visibility('public'),


                                        Forms\Components\Toggle::make('is_active')
                                            ->label('نشط')
                                            ->default(true),
                                    ])->columns(2),

                                // التبويب الثاني: الأحجام والأسعار (Variations)
                                Tabs\Tab::make('الأحجام والأسعار')
                                    ->schema([
                                        Forms\Components\Repeater::make('variations') // علاقة ProductVariation
                                        ->relationship('variations')
                                            ->schema([
                                                Forms\Components\TextInput::make('size_name')
                                                    ->label('اسم الحجم (مثلاً: كبير)')
                                                    ->required(),
                                                Forms\Components\TextInput::make('price')
                                                    ->label('السعر')
                                                    ->numeric()
                                                    ->prefix('SAR')
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->itemLabel(fn (array $state): ?string => $state['size_name'] ?? null)
                                            ->addActionLabel('إضافة حجم جديد'),
                                    ]),

                                // التبويب الثالث: الإضافات المتاحة لهذا المنتج
                                Tabs\Tab::make('الإضافات')
                                    ->schema([
                                        Forms\Components\Select::make('extras') // علاقة Many-to-Many مع Extra
                                        ->relationship('extras', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->label('اختر الإضافات المتاحة لهذا المنتج'),
                                    ]),
                            ])->columnSpanFull(),

            ]);
    }
}
