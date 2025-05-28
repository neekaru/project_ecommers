<?php

namespace App\Filament\Resources\CartAddonResource\Pages;

use App\Filament\Resources\CartAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCartAddon extends CreateRecord
{
    protected static string $resource = CartAddonResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

