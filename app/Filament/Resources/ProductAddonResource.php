<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductAddonResource\Pages;
use App\Filament\Resources\ProductAddonResource\RelationManagers;
use App\Models\ProductAddon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductAddonResource extends Resource
{
    protected static ?string $model = ProductAddon::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
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

                    // Relasi ke Makanan
                    Forms\Components\Select::make('product_id')
                        ->label('Nama makanan')
                        ->relationship('product', 'nama_produk') // Sesuaikan dengan nama relasi dan field
                        ->searchable()
                        ->required(),

                    // Nama addon
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Tambahan')
                        ->required()
                        ->maxLength(255),

                    // Harga addon
                    Forms\Components\TextInput::make('price')
                        ->label('Harga Addons')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    // Deskripsi addon
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(4)
                ])
        ]);
}


 public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Menampilkan nama produk dari relasi
            Tables\Columns\TextColumn::make('product.nama_produk')
                ->label('Nama Makanan')
                ->searchable(),

            // Nama addon
            Tables\Columns\TextColumn::make('name')
                ->label('Nama Tambahan')
                ->searchable(),

            // Harga addon
            Tables\Columns\TextColumn::make('price')
                ->label('Harga')
                ->money('IDR', locale: 'id'),

            // Deskripsi addon
            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi')
                ->limit(50),
        ])
        ->filters([
            // Tambahkan filter jika diperlukan
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
            'index' => Pages\ListProductAddons::route('/'),
            'create' => Pages\CreateProductAddon::route('/create'),
            'edit' => Pages\EditProductAddon::route('/{record}/edit'),
        ];
    }
}
