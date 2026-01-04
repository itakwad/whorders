<?php

namespace App\Filament\Seller\Resources\Products;

use App\Filament\Seller\Resources\Products\Pages\CreateProduct;
use App\Filament\Seller\Resources\Products\Pages\EditProduct;
use App\Filament\Seller\Resources\Products\Pages\ListProducts;
use App\Filament\Seller\Resources\Products\Schemas\ProductForm;
use App\Filament\Seller\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $tenantOwnershipRelationshipName = 'store';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cube;
    protected static string|null|\UnitEnum $navigationGroup = 'المنتجات';
    protected static ?string $recordTitleAttribute = 'product';

    protected static ?string $pluralModelLabel = 'المنتجات';
    protected static ?string $modelLabel = 'منتج';
    protected static ?string $navigationLabel = 'المنتجات'; // label عربي للقائمة

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
