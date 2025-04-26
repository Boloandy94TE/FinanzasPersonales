<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'tipo',
    ];
    
    //Relacion de muchos a uno con el modelo user
    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }
}
