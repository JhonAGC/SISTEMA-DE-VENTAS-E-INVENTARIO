<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'ruc', 'direccion', 'telefono', 'telefono', 'correo', 'pagWeb', 'observaciones'];

    public function proveedors()
    {
        return $this->hasMany(Compra::class);
    }
}
