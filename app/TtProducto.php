<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TtProducto extends Model
{
    protected $table = "TT_PRODUCTO";
    protected $fillable = [
        'producto',
        'precio',
        'observaciones',
        'id_sabor',
        'id_tipo_producto',
        'id_tamanio',
        'id_estado'
    ];
    public function sabor(){
        return $this->hasOne('App\TcSabor','id','id_sabor');
    }
    public function tipo_producto(){
        return $this->hasOne('App\TcTipoProducto','id','id_tipo_producto');
    }
    public function tamanio(){
        return $this->hasOne('App\TcTamanio','id','id_tamanio');
    }
        /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'id_usuario_crea',
        'id_usuario_modifica',
        'id_sabor',
        'id_tipo_producto',
        'id_tamanio'
    ];
}
