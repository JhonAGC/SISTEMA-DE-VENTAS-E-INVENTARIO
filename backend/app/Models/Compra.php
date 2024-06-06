<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class Compra extends Model
{
    use HasFactory;
    public function CompraInventarios()
    {
        return $this->hasMany(CompraInventario::class);
    }

    public function Proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
