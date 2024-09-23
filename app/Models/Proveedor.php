<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory;
    use SoftDeletes;
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