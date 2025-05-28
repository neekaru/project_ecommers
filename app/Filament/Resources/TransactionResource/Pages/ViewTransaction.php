<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Card;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Card::make([
                    TextEntry::make('customer.name')
                        ->label('Nama Customer')
                        ->placeholder('-'),

                    TextEntry::make('total_harga')
                        ->label('Total Harga')
                        ->numeric()
                        ->money('IDR', locale: 'id'),

                    TextEntry::make('metode_pembayaran')
                        ->label('Metode Pembayaran')
                        ->placeholder('-'),

                    TextEntry::make('catatan')
                        ->label('Catatan')
                        ->placeholder('-')
                        ->wrap(),
                ])->columns(2),
            ]);
    }
}
