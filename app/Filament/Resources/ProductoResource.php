<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'tablas ';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('nombre')
                ->required(),
            Forms\Components\Select::make('estado')
                ->options([
                    'disponible' => 'Disponible',
                    'agotado' => 'Agotado',
                    'descontinuado' => 'Descontinuado',
                ])
                ->required(),
            Forms\Components\TextInput::make('stock')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('precio')
                ->required()
                ->numeric(),
        ]);
        
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')->sortable(),
            TextColumn::make('nombre')->sortable()->searchable(),
            TextColumn::make('estado')->sortable(),
            TextColumn::make('stock')->sortable(),
            TextColumn::make('precio')->sortable(),
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
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
