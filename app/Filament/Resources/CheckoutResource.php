<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckoutResource\Pages;
use App\Filament\Resources\CheckoutResource\RelationManagers;
use App\Models\Checkout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckoutResource extends Resource
{
    protected static ?string $model = Checkout::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Carts & Orders';

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('customer_id')
                ->label('Customer')
                ->relationship('customer', 'name') // 👈 Cek baris ini!
                ->searchable()
                ->required(),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('customer.name')
                ->label('Customer')
                ->searchable(),

            Tables\Columns\TextColumn::make('total_harga')
                ->label('Total Harga')
                ->numeric(decimalPlaces: 0)
                ->money('IDR', locale: 'id'),

            Tables\Columns\TextColumn::make('catatan')
                ->label('Catatan')
                ->limit(30),

            Tables\Columns\TextColumn::make('metode_pembayaran')
                ->label('Metode Pembayaran')
                ->badge(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

public static function getPages(): array
{
    return [
        'index' => Pages\ListCheckouts::route('/'),
        'view'  => Pages\ViewCheckout::route('/{record}'),
    ];
}
        public static function canCreate(): bool
    {
        return false;
    }
}

