<?php

namespace App\Filament\Resources\OrderMethodResource\Pages;

use App\Filament\Resources\OrderMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderMethod extends CreateRecord
{
    protected static string $resource = OrderMethodResource::class;
            protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
