<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TcTamanio extends Model
{
    protected $table = "TC_TAMANIO";
    
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'tamanio',
        'id_estado',
        'id_usuario_crea',
        'id_usuario_modifica',
        'observaciones'
    ];
    //
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
