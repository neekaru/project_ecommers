<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderMethodResource\Pages;
use App\Filament\Resources\OrderMethodResource\RelationManagers;
use App\Models\OrderMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderMethodResource extends Resource
{
    protected static ?string $model = OrderMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Carts & Orders';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

public static function form(Form $form): Form
{
    return $form
        ->schema([

            Forms\Components\Select::make('metode_pesanan')
                ->options([
                    'langsung' => 'Langsung',
                    'dijadwalkan' => 'Dijadwalkan',
                ])
                ->required()
                ->label('Metode Pesanan'),

            Forms\Components\Toggle::make('dijadwalkan')
                ->label('Apakah Dijadwalkan?')
                ->required(),

            Forms\Components\DatePicker::make('tanggal_pengambilan')
                ->label('Tanggal Pengambilan')
                ->required()
                ->native(false),

            Forms\Components\TimePicker::make('waktu_pengambilan')
                ->label('Waktu Pengambilan')
                ->required()
                ->seconds(false),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            
            Tables\Columns\TextColumn::make('metode_pesanan')
                ->label('Metode Pesanan')
                ->badge(),

            Tables\Columns\IconColumn::make('dijadwalkan')
                ->label('Dijadwalkan')
                ->boolean(),

            Tables\Columns\TextColumn::make('tanggal_pengambilan')
                ->label('Tanggal Pengambilan')
                ->date(),

            Tables\Columns\TextColumn::make('waktu_pengambilan')
                ->label('Waktu Pengambilan')
                ->dateTime(),
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
            'index' => Pages\ListOrderMethods::route('/'),
            'create' => Pages\CreateOrderMethod::route('/create'),
            'edit' => Pages\EditOrderMethod::route('/{record}/edit'),
        ];
    }
}
