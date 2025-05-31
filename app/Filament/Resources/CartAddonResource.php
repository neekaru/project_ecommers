<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartAddonResource\Pages;
use App\Filament\Resources\CartAddonResource\RelationManagers;
use App\Models\CartAddon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CartAddonResource extends Resource
{
    protected static ?string $model = CartAddon::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([

                    // Cart ID (bisa jadi dropdown jika relasi)
                    Forms\Components\Select::make('cart_id')
                        ->label('Cart')
                        ->relationship('cart', 'id') // jika relasi cart tersedia
                        ->searchable()
                        ->required(),

                    // Product Addon ID (dropdown relasi juga)
                    Forms\Components\Select::make('product_addon_id')
                        ->label('Product Addon')
                        ->relationship('productAddon', 'name') // pastikan model ada relasi
                        ->searchable()
                        ->required(),

                    // Name (bisa auto dari relasi atau manual)
                    Forms\Components\TextInput::make('name')
                        ->label('Addon Name')
                        ->required(),

                    // Price
                    Forms\Components\TextInput::make('price')
                        ->label('Addon Price')
                        ->numeric()
                        ->required(),

                    // Quantity
                    Forms\Components\TextInput::make('quantity')
                        ->label('Quantity')
                        ->numeric()
                        ->required(),

                ]),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Kolom relasi Cart
            Tables\Columns\TextColumn::make('cart.id')
                ->label('Cart ID')
                ->sortable()
                ->searchable(),

            // Kolom relasi ProductAddon
            Tables\Columns\TextColumn::make('productAddon.name')
                ->label('Product Addon')
                ->sortable()
                ->searchable(),

            // Nama addon (disimpan manual)
            Tables\Columns\TextColumn::make('name')
                ->label('Addon Name')
                ->sortable()
                ->searchable(),

            // Harga
            Tables\Columns\TextColumn::make('price')
                ->label('Price')
                ->money('IDR', true)
                ->sortable(),

            // Jumlah
            Tables\Columns\TextColumn::make('quantity')
                ->label('Quantity')
                ->sortable(),
        ])
        ->filters([
            // tambahkan filter jika diperlukan
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCartAddons::route('/'),
            'create' => Pages\CreateCartAddon::route('/create'),
            'edit' => Pages\EditCartAddon::route('/{record}/edit'),
        ];
    }
}
