<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TtPedido extends Model
{
    protected $table = "TT_PEDIDO";
    protected $fillable = [
        'pedido',
        'fecha_entrega',
        'anticipo',
        'observaciones',
        'id_cliente',
        'id_estado',
        'id_usuario_crea',
        'id_usuario_modifica'
    ];
}
