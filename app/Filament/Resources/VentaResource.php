<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Models\Venta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('cliente_id')
                ->relationship('Cliente', 'nombre')
                ->required(),
            Forms\Components\Select::make('producto_id')
                ->relationship('Producto', 'nombre')
                ->required(),
            Forms\Components\TextInput::make('cantidad')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('precio_venta')
                ->required()
                ->numeric(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')->sortable(),
            TextColumn::make('cliente.nombre')->label('Cliente')->sortable()->searchable(),
            TextColumn::make('producto.nombre')->label('Producto')->sortable()->searchable(),
            TextColumn::make('cantidad')->sortable(),
            TextColumn::make('precio_venta')->sortable(),
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
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
