<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TtDetPedido extends Model
{
    //
    protected $table = "TT_DET_PEDIDO";
    protected $fillable = [
        'det_pedido',
        'cantidad',
        'precio',
        'observaciones',
        'id_pedido',
        'id_producto',
        'id_estado',
        'id_usuario_crea',
        'id_usuario_modifica'
    ];
    protected $hidden = [
        'updated_at',
        'id_usuario_crea',
        'id_usuario_modifica'
    ];
}
