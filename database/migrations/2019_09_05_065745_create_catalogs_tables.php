<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TS_ESTADO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('estado',16)->nullable($value = false);
            $table->string('observaciones',128);
            $table->timestamps();
        });
        Schema::create('TC_USUARIO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usuario',32);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->timestamps();
        });

        Schema::create('TC_TIPO_PRODUCTO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_producto',32);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });

        Schema::create('TC_TAMANIO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tamanio',32);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });
        Schema::create('TC_SABOR', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sabor',32);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });
        Schema::create('TC_CLIENTE', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cliente',32);
            $table->string('correo',32);
            $table->string('telefono',16);
            $table->string('dpi',16);
            $table->string('nit',16);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });
        Schema::create('TC_COMPRA', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('compra',32);
            $table->dateTime('fecha_compra');
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TS_ESTADO');
        Schema::dropIfExists('TC_USUARIO');
        Schema::dropIfExists('TC_TIPO_PRODUCTO');
        Schema::dropIfExists('TC_TAMANIO');
        Schema::dropIfExists('TC_SABOR');
        Schema::dropIfExists('TC_CLIENTE');
        Schema::dropIfExists('TC_COMPRA');
    }
}
