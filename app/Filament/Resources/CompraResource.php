<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompraResource\Pages;
use App\Filament\Resources\CompraResource\RelationManagers;
use App\Models\Compra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class CompraResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('proveedor_id')
            ->relationship('proveedor', 'nombre')  // Relación con el modelo Proveedor
            ->required(),
        
        Forms\Components\Select::make('producto_id')
            ->relationship('producto', 'nombre')  // Relación con el modelo Producto
            ->required(),
        
            Forms\Components\TextInput::make('cantidad')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('precio_compra')
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
            TextColumn::make('proveedor.nombre')->label('Proveedor')->sortable()->searchable(),
            TextColumn::make('producto.nombre')->label('Producto')->sortable()->searchable(),
            TextColumn::make('cantidad')->sortable(),
            TextColumn::make('precio_compra')->sortable(),
                //
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
            'index' => Pages\ListCompras::route('/'),
            'create' => Pages\CreateCompra::route('/create'),
            'edit' => Pages\EditCompra::route('/{record}/edit'),
        ];
    }
}
