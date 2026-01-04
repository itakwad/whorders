<?php

namespace App\Filament\Seller\Resources\Extras\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Schemas\Components\Section;
class ExtraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الاضافة')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الإضافة')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->label('السعر الإضافي')
                            ->numeric()
                            ->prefix('جنية')
                            ->required(),
                    ])
                    ->columns(2),
            ]);

    }
}
