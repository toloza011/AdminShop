<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table="pedidos";
    protected $fillable=['id_producto','nombre','entrega','estado'];
    public $timestamps=false;
}
