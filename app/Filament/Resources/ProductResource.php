<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    // Upload gambar produk
                    Forms\Components\FileUpload::make('gambar_produk')
                        ->label('Gambar Produk')
                        ->image()
                        ->required(),

                    // Nama produk
                    Forms\Components\TextInput::make('nama_produk')
                        ->label('Nama Produk')
                        ->required()
                        ->maxLength(255),

                    // Deskripsi produk
                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(5)
                        ->required(),

                    // Harga dasar
                    Forms\Components\TextInput::make('harga_dasar')
                        ->label('Harga Dasar')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    // Kategori
                    Forms\Components\Select::make('kategori_id')
                        ->label('Kategori')
                        ->relationship('kategori', 'nama') // Pastikan relasi dan nama field benar
                        ->searchable()
                        ->required(),
                ])
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('gambar_produk')
                ->label('Gambar')
                ->circular(),

            Tables\Columns\TextColumn::make('nama_produk')
                ->label('Nama Produk')
                ->searchable(),

            Tables\Columns\TextColumn::make('deskripsi')
                ->label('Deskripsi')
                ->limit(50)
                ->html(),

            Tables\Columns\TextColumn::make('harga_dasar')
                ->label('Harga Dasar')
                ->numeric(decimalPlaces: 0)
                ->money('IDR', locale: 'id'),

            Tables\Columns\TextColumn::make('kategori.nama')
                ->label('Kategori')
                ->searchable(),
        ])
        ->filters([
            // Tambahkan filter jika perlu
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
