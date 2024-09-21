<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';

    protected $fillable = [
        'producto_id',
        'cliente_id',
        'cantidad',
        'precio_venta'
    ];

    public function cliente()
    {
        return $this->belongsTo(cliente::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}