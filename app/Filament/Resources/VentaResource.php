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
use Filament\Tables\Columns\BadgeColumn;


class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = "ventas de la empresa";

    protected static ?string $navigationGroup = 'Pagina de enlaces ';


    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('cliente_id')
                ->relationship('Cliente', 'nombre')
                ->required(),
            Forms\Components\Select::make('producto_id')
                ->relationship('Producto', 'nombre')
                ->required()
                ->reactive()  // Para actualizar dinámicamente al cambiar de producto
                ->afterStateUpdated(function (callable $set, $state) {
                    $producto = \App\Models\Producto::find($state);
                    if ($producto) {
                        $set('stock_disponible', $producto->stock);
                    }
                }),
            Forms\Components\TextInput::make('cantidad')
                ->required()
                ->numeric()
                ->rule(function ($get) {
                    return 'max:' . $get('stock_disponible');  // Limitar la cantidad al stock disponible
                }),
            Forms\Components\TextInput::make('stock_disponible')
                ->disabled()
                ->numeric()
                ->label('Stock disponible'),
            Forms\Components\TextInput::make('precio_venta')
                ->required()
                ->numeric(),
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
            BadgeColumn::make('created_at')
            ->date('d/m/Y')
            ->label('Fecha de Creación'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(), // Filtro para ventas eliminadas
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),  // Acción para restaurar registros eliminados
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\RestoreBulkAction::make(), // Restaurar en masa
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(), // Eliminar permanentemente
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
