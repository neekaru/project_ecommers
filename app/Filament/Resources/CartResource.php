<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Filament\Resources\CartResource\RelationManagers;
use App\Models\Cart;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
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
                    // User (relasi ke users)
                    Forms\Components\Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')  // asumsikan model User punya kolom name
                        ->searchable()
                        ->required(),

                    // Product (relasi ke products)
                    Forms\Components\Select::make('product_id')
                        ->label('Product')
                        ->relationship('product', 'name') // asumsikan model Product punya kolom name
                        ->searchable()
                        ->required(),

                    // Quantity
                    Forms\Components\TextInput::make('quantity')
                        ->label('Quantity')
                        ->numeric()
                        ->required()
                        ->minValue(1),

                    // Price
                    Forms\Components\TextInput::make('price')
                        ->label('Price')
                        ->numeric()
                        ->required()
                        ->minValue(0),

                    // Notes (opsional)
                    Forms\Components\Textarea::make('notes')
                        ->label('Notes')
                        ->placeholder('Additional notes or instructions')
                        ->rows(3)
                        ->nullable(),
                ]),
        ]);
}

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('product.name')
                ->label('Product')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('quantity')
                ->label('Quantity')
                ->sortable(),

            Tables\Columns\TextColumn::make('price')
                ->label('Price')
                ->money('IDR', true)  // format mata uang Rupiah
                ->sortable(),

            Tables\Columns\TextColumn::make('notes')
                ->label('Notes')
                ->limit(50)  // batasi tampilan maksimal 50 karakter
                ->wrap(),
        ])
        ->filters([
            // tambahkan filter jika perlu
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
            'index' => Pages\ListCarts::route('/'),
            'create' => Pages\CreateCart::route('/create'),
            'edit' => Pages\EditCart::route('/{record}/edit'),
        ];
    }
}
