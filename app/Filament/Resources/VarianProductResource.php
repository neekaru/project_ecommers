<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VarianProductResource\Pages;
use App\Models\VarianProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VarianProductResource extends Resource
{
    protected static ?string $model = VarianProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Card::make()
                    ->schema([
                        // Select Product
                        Components\Select::make('product_id')
                            ->label('Nama Makanan')
                            ->relationship('product', 'nama_produk')
                            ->searchable()
                            ->required(),

                        // Nama Varian
                        Components\TextInput::make('nama_varian')
                            ->label('Nama Varian')
                            ->placeholder('Contoh: Dada, Paha, Panas, Dingin')
                            ->required(),

                        // Harga (Price) dengan format IDR
                        Components\TextInput::make('price')
                            ->label('Harga')
                            ->prefix('IDR')
                            ->numeric()
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Nama produk dari relasi
                TextColumn::make('product.nama_produk')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),


                // Nama varian
                TextColumn::make('nama_varian')
                    ->label('Varian')
                    ->searchable()
                    ->sortable(),
                
                // Harga (Price) dengan format IDR
                TextColumn::make('price')
                    ->label('Harga')
                    ->prefix('IDR')
                    ->sortable(),

                // Waktu dibuat
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
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
            'index' => Pages\ListVarianProducts::route('/'),
            'create' => Pages\CreateVarianProduct::route('/create'),
            'edit' => Pages\EditVarianProduct::route('/{record}/edit'),
        ];
    }
}

