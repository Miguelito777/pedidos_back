<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TcCliente extends Model
{
    //
    protected $table = "TC_CLIENTE";
    protected $fillable = [
        'cliente',
        'correo',
        'telefono',
        'dpi',
        'nit',
        'observaciones',
        'id_estado',
        'id_usuario_crea',
        'id_usuario_modifica'
    ];
        /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'id_usuario_crea',
        'id_usuario_modifica'
    ];
}
