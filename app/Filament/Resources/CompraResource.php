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
use Filament\Tables\Columns\BadgeColumn;

class CompraResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $modelLabel = "compras de la empresa";

    protected static ?string $navigationGroup = 'Pagina de enlaces ';

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
            BadgeColumn::make('created_at')
            ->date('d/m/Y')
            ->label('Fecha de Creación'),
                //
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
            'index' => Pages\ListCompras::route('/'),
            'create' => Pages\CreateCompra::route('/create'),
            'edit' => Pages\EditCompra::route('/{record}/edit'),
        ];
    }
}
