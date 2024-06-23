<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function metodos()
    {
        return $this->hasMany(Venta::class);
    }
}
