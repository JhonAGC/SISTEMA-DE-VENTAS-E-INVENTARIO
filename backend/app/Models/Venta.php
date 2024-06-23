<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    public function VentaInventarios()
    {
        return $this->hasMany(VentaInventario::class);
    }

    public function boletas()
    {
        return $this->hasMany(Boleta::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }

    public function CajaVenta()
    {
        return $this->hasOne(CajaVenta::class);
    }

    public function Cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Metodo()
    {
        return $this->belongsTo(Metodo::class);
    }
}
