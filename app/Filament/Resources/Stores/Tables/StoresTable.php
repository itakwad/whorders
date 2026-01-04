<?php

namespace App\Filament\Resources\Stores\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables;

class StoresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')->label('اللوجو')->circular(),
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('البائع'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('نشط'),
                Tables\Columns\TextColumn::make('open_time')->label('يفتح') ->time('H:i'),
                Tables\Columns\TextColumn::make('close_time')->label('يغلق') ->time('H:i'),
                Tables\Columns\TextColumn::make('created_at')->since()->label('أُنشئ'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('نشط'),

            ])

            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
