<?php

namespace App\Filament\Resources\VarianProductResource\Pages;

use App\Filament\Resources\VarianProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVarianProduct extends EditRecord
{
    protected static string $resource = VarianProductResource::class;

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
