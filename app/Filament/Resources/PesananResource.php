<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
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
                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->placeholder('Category Image')
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Category Name')
                            ->placeholder('Category Name')
                            ->required(),
                    ])
            ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Kolom waktu pesanan
            Tables\Columns\TextColumn::make('created_at')
                ->label('Waktu')
                ->dateTime('d M Y H:i')
                ->sortable(),

            // Kolom nama customer
            Tables\Columns\TextColumn::make('customer.nama')
                ->label('Pelanggan')
                ->searchable()
                ->sortable(),

            // Kolom total harga
            Tables\Columns\TextColumn::make('total')
                ->label('Total')
                ->money('IDR', locale: 'id')
                ->sortable(),

            // Kolom status pesanan
            Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'warning' => 'menunggu',
                    'info' => 'dikonfirmasi',
                    'danger' => 'ditolak',
                    'success' => 'selesai',
                ])
                ->formatStateUsing(fn (string $state) => ucfirst($state))
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label('Filter Status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'dikonfirmasi' => 'Dikonfirmasi',
                    'ditolak' => 'Ditolak',
                    'selesai' => 'Selesai',
                ]),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}
