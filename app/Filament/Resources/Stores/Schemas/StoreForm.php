<?php

namespace App\Filament\Resources\Stores\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Forms\Components\{
    Select,
    TextInput,
    Textarea,
    FileUpload,
    Toggle,
    TimePicker
};

class StoreForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Grid::make(2)->schema([

                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('البائع')
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->label('اسم المتجر')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('الرابط')
                    ->required()
                    ->unique(ignoreRecord: true),

                Textarea::make('description')
                    ->label('الوصف')
                    ->columnSpanFull(),

            ]),

            Grid::make(2)->schema([

                FileUpload::make('logo')
                    ->label('اللوجو')
                    ->image()
                    ->directory('stores/logos'),

                FileUpload::make('cover_image')
                    ->label('صورة الغلاف')
                    ->image()
                    ->directory('stores/covers'),

            ]),

            Grid::make(2)->schema([

                TextInput::make('address')->label('العنوان'),
                TextInput::make('phone')->label('الهاتف'),
                TextInput::make('whatsapp')->label('واتساب'),
                TextInput::make('facebook')->label('فيسبوك'),

            ]),

            Grid::make(3)->schema([

                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true),

                TimePicker::make('open_time')
                    ->label('وقت الفتح'),

                TimePicker::make('close_time')
                    ->label('وقت الإغلاق'),

            ]),

        ]);
    }
}
