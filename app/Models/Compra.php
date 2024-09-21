<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
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
}
