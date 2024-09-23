<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;

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