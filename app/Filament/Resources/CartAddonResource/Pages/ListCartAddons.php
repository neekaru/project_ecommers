<?php

namespace App\Filament\Resources\CartAddonResource\Pages;

use App\Filament\Resources\CartAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCartAddons extends ListRecords
{
    protected static string $resource = CartAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
