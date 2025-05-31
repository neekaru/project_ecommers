<?php

namespace App\Filament\Resources\OrderMethodResource\Pages;

use App\Filament\Resources\OrderMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderMethods extends ListRecords
{
    protected static string $resource = OrderMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
