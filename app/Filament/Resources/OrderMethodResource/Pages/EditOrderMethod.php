<?php

namespace App\Filament\Resources\OrderMethodResource\Pages;

use App\Filament\Resources\OrderMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderMethod extends EditRecord
{
    protected static string $resource = OrderMethodResource::class;

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
