<?php

namespace App\Filament\Seller\Resources\Categories;

use App\Filament\Seller\Resources\Categories\Pages\CreateCategory;
use App\Filament\Seller\Resources\Categories\Pages\EditCategory;
use App\Filament\Seller\Resources\Categories\Pages\ListCategories;
use App\Filament\Seller\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Seller\Resources\Categories\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $tenantOwnershipRelationshipName = 'store';
    protected static ?string $model = Category::class;
    protected static ?string $pluralModelLabel = 'التصنيفات';
    protected static ?string $modelLabel = 'تصنيف';
    protected static ?string $navigationLabel = 'التصنيفات'; // label عربي للقائمة
    protected static string|BackedEnum|null $navigationIcon = Heroicon::RectangleGroup;

    protected static ?string $recordTitleAttribute = 'category';

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
