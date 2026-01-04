<?php

namespace App\Filament\Seller\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\ImageColumn::make('image')
                        ->label('الصورة'),

                    Tables\Columns\TextColumn::make('name')
                        ->label('المنتج')
                        ->searchable(),

                    Tables\Columns\TextColumn::make('category.name')
                        ->label('التصنيف')
                        ->sortable(),

                    Tables\Columns\IconColumn::make('is_active')
                        ->label('نشط')
                        ->boolean(),

                    Tables\Columns\TextColumn::make('variations_count')
                        ->label('عدد الأحجام')
                        ->counts('variations'),
                ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('تصفية حسب التصنيف'),
            ])


            ->filters([
                //
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
