<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'producto';

    protected $fillable = [
        'nombre',
        'estado',
        'stock',
        'precio'
    ];

    // Relación muchos a muchos con Proveedor (Compras)
    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'compras',)
        ->withPivot('cantidad', 'precio_compra')
        ->withTimestamps();
    }

    // Relación muchos a muchos con Cliente (Ventas)
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'venta', )
                    ->withPivot('cantidad', 'precio_venta')
                    ->withTimestamps();
    }
}
