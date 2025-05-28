<?php

namespace App\Filament\Resources\CartAddonResource\Pages;

use App\Filament\Resources\CartAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCartAddon extends EditRecord
{
    protected static string $resource = CartAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
        protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
