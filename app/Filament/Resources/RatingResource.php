<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Rating;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\TransactionDetail;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\RatingResource\Pages;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Komentar & Rating';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('transaction_detail_id')
                    ->label('Transaksi')
                    ->options(function (): array {
                        return TransactionDetail::with('product')->get()->mapWithKeys(function ($item) {
                            // Gunakan id sebagai key, dan label yang informatif, misal: "ID:1 - Product Title"
                            $productTitle = $item->product ? $item->product->title : 'Produk tidak diketahui';
                            return [$item->id => "Transaksi #{$item->id} - {$productTitle}"];
                        })->toArray();
                    })
                    ->searchable()
                    ->required(),

                Select::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '⭐ 1',
                        2 => '⭐⭐ 2',
                        3 => '⭐⭐⭐ 3',
                        4 => '⭐⭐⭐⭐ 4',
                        5 => '⭐⭐⭐⭐⭐ 5',
                    ])
                    ->required(),

                Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name') // Pastikan relasi customer di model Rating sudah benar
                    ->searchable()
                    ->required(),

                Select::make('product_id')
                    ->label('Product')
                    ->options(function (): array {
                        // Only include products with a non-null title
                        return Product::query()
                            ->whereNotNull('nama_produk')
                            ->get()
                            ->pluck('nama_produk', 'id')
                            ->filter(function ($title) {
                                return $title !== null && $title !== '';
                            })
                            ->all();
                    })
                    ->searchable()
                    ->required(),

                Textarea::make('review')
                    ->label('Review')
                    ->placeholder('Tulis komentar Anda (opsional)')
                    ->rows(4),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')->searchable(),
                Tables\Columns\TextColumn::make('product.title')->searchable(),
                Tables\Columns\TextColumn::make('rating'),
                Tables\Columns\TextColumn::make('review'),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListRatings::route('/'),
            'create' => Pages\CreateRating::route('/create'),
            'edit' => Pages\EditRating::route('/{record}/edit'),
        ];
    }
}
