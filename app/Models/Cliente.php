<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion'
    ];

    // Relación muchos a muchos con Producto (Ventas)
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'venta')
                    ->withPivot('cantidad', 'precio_venta')
                    ->withTimestamps();
    }
}