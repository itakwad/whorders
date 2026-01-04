<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static ?string $pluralModelLabel = 'المستخدمين';
    protected static ?string $modelLabel = 'مستخدم';
    protected static ?string $navigationLabel = 'المستخدمين'; // label عربي للقائمة
    protected static ?string $recordTitleAttribute = 'user';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // عرض المستخدمين الذين ليسوا "أدمن" فقط
        // أو عرض كل المستخدمين ما عدا المستخدم الحالي
        return parent::getEloquentQuery()
            ->where('role', '!=', 'admin');
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
