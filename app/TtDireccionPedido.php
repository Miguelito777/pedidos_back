<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TtDireccionPedido extends Model
{
    protected $table = "TT_DIRECCION_PEDIDO";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'direccion_pedido',
        'id_estado',
        'id_usuario_crea',
        'id_usuario_modifica',
        'observaciones'
    ];
    /*public function detPedido()
    {
        return $this->hasMany('App\TtDetPedido','id_pedido','id');
    }
    public function cliente()
    {
        return $this->hasOne('App\TcCliente','id','id_cliente');
    }*/
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
