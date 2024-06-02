<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apePaterno', 'apeMaterno', 'dni'];

    public function clientes()
    {
        return $this->hasMany(Venta::class);
    }
}