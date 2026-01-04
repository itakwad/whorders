<?php

namespace App\Filament\Seller\Resources\Extras\Pages;

use App\Filament\Seller\Resources\Extras\ExtraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExtra extends CreateRecord
{
    protected static string $resource = ExtraResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
