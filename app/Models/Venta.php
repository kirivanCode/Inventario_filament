<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'venta';

    protected $fillable = [
        'producto_id',
        'cliente_id',
        'cantidad',
        'precio_venta',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    protected static function booted()
    {
        // Evento que se dispara cuando se crea una venta
        static::created(function ($venta) {
            // Disminuir el stock del producto asociado
            $producto = $venta->producto;
            
            if ($producto->stock >= $venta->cantidad) {
                $producto->stock -= $venta->cantidad;
                $producto->save();
            } else {
                // Aquí puedes manejar un error si no hay suficiente stock
                throw new \Exception("No hay suficiente stock para el producto.");
            }
        });
    }
}
