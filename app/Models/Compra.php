<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use SoftDeletes;
    protected $table = 'compras';  // Nombre de la tabla

    protected $fillable = [
        'proveedor_id',
        'producto_id',
        'cantidad',
        'precio_compra',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    protected static function booted()
    {
        // Evento que se dispara cuando se crea una compra
        static::created(function ($compra) {
            // Aumentar el stock del producto asociado
            $producto = $compra->producto;
            $producto->stock += $compra->cantidad;
            $producto->save();
        });
    }
}
