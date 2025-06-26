<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KomentarResource\Pages;
use App\Filament\Resources\KomentarResource\RelationManagers;
use App\Models\Komentar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KomentarResource extends Resource
{
    protected static ?string $model = Komentar::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';
    protected static ?string $navigationGroup = 'Komentar & Rating';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()->schema([

                Forms\Components\Select::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'nama_produk')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'nama')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('parent_id')
                    ->label('Komentar Induk')
                    ->relationship('induk', 'isi') // relasi ke induk komentar
                    ->searchable()
                    ->placeholder('Komentar utama (jika tidak membalas)')
                    ->nullable(),

                Forms\Components\Textarea::make('isi')
                    ->label('Isi Komentar')
                    ->required()
                    ->rows(4),

            ])
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('product.nama_produk')
                ->label('Produk')
                ->searchable(),

            Tables\Columns\TextColumn::make('customer.nama')
                ->label('Customer')
                ->searchable(),

            Tables\Columns\TextColumn::make('induk.isi')
                ->label('Balasan dari')
                ->limit(30)
                ->placeholder('-'),

            Tables\Columns\TextColumn::make('isi')
                ->label('Isi Komentar')
                ->limit(50),
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
            'index' => Pages\ListKomentars::route('/'),
            'create' => Pages\CreateKomentar::route('/create'),
            'edit' => Pages\EditKomentar::route('/{record}/edit'),
        ];
    }
}
