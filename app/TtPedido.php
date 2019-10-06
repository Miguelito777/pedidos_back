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
        'hora_entrega',
        'id_estado',
        'id_usuario_crea',
        'id_usuario_modifica',
        'id_direccion_pedido'
    ];
    public function detPedido()
    {
        return $this->hasMany('App\TtDetPedido','id_pedido','id');
    }
    public function cliente()
    {
        return $this->hasOne('App\TcCliente','id','id_cliente');
    }
    public function direccion()
    {
        return $this->hasOne('App\TtDireccionPedido','id','id_direccion_pedido');
    }
    protected $hidden = [
        'created_at',
        'updated_at',
        'id_usuario_crea',
        'id_usuario_modifica'
    ];
}
