<?php

namespace App\Filament\Seller\Resources\Extras;

use App\Filament\Seller\Resources\Extras\Pages\CreateExtra;
use App\Filament\Seller\Resources\Extras\Pages\EditExtra;
use App\Filament\Seller\Resources\Extras\Pages\ListExtras;
use App\Filament\Seller\Resources\Extras\Schemas\ExtraForm;
use App\Filament\Seller\Resources\Extras\Tables\ExtrasTable;
use App\Models\Extra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExtraResource extends Resource
{
    protected static ?string $tenantOwnershipRelationshipName = 'store';

    protected static ?string $model = Extra::class;
    protected static ?string $pluralModelLabel = 'الاضافات';
    protected static ?string $modelLabel = 'اضافة';
    protected static ?string $navigationLabel = 'الاضافات'; // label عربي للقائمة

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartPie;
    protected static string|null|\UnitEnum $navigationGroup = 'المنتجات';
    protected static ?string $recordTitleAttribute = 'extra';

    public static function form(Schema $schema): Schema
    {
        return ExtraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExtrasTable::configure($table);
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
            'index' => ListExtras::route('/'),
            'create' => CreateExtra::route('/create'),
            'edit' => EditExtra::route('/{record}/edit'),
        ];
    }
}
