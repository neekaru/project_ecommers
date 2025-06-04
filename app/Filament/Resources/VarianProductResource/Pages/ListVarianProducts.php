<?php

namespace App\Filament\Resources\VarianProductResource\Pages;

use App\Filament\Resources\VarianProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVarianProducts extends ListRecords
{
    protected static string $resource = VarianProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
