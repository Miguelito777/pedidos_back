<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TcCliente extends Model
{
    //
    protected $table = "TC_CLIENTE";
    protected $fillable = [
        'cliente'
    ];
}
