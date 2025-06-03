<?php

namespace App\Filament\Resources\VarianProductResource\Pages;

use App\Filament\Resources\VarianProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVarianProduct extends CreateRecord
{
    protected static string $resource = VarianProductResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
