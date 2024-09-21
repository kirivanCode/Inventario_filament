<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';

    protected $fillable = [
        'email',
        'telefono',
        'nombre'
    ];

    // Relación muchos a muchos con Producto
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'compras', 'proveedor_id', 'producto_id')
                ->withPivot('cantidad', 'precio_compra')
                ->withTimestamps();
    }
}