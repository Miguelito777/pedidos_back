<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TT_PRODUCTO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('producto',32);
            $table->float('precio', 8, 2);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_sabor');
            $table->foreign('id_sabor')->references('id')->on('TC_SABOR');
            $table->unsignedBigInteger('id_tipo_producto');
            $table->foreign('id_tipo_producto')->references('id')->on('TC_TIPO_PRODUCTO');
            $table->unsignedBigInteger('id_tamanio');
            $table->foreign('id_tamanio')->references('id')->on('TC_TAMANIO');
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });

        Schema::create('TT_PEDIDO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pedido',32);
            $table->dateTime('fecha_entrega');
            $table->float('anticipo', 8, 2);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('TC_CLIENTE');
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });

        Schema::create('TT_DET_PEDIDO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('det_pedido',32);
            $table->float('cantidad', 8, 2);
            $table->float('precio', 8, 2);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id')->on('TT_PEDIDO');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_producto')->references('id')->on('TT_PRODUCTO');
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });
        Schema::create('TT_DET_COMPRA', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('det_compra',32);
            $table->float('cantidad', 8, 2);
            $table->float('precio', 8, 2);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_compra');
            $table->foreign('id_compra')->references('id')->on('TC_COMPRA');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_producto')->references('id')->on('TT_PRODUCTO');
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });

        Schema::create('TT_VENTA', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('venta',32);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('TC_CLIENTE');
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });
        Schema::create('TT_DET_VENTA', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('det_venta',32);
            $table->float('cantidad', 8, 2);
            $table->float('precio', 8, 2);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_venta')->references('id')->on('TT_VENTA');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_producto')->references('id')->on('TT_PRODUCTO');
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
        Schema::dropIfExists('TT_PRODUCTO');
        Schema::dropIfExists('TT_PEDIDO');
        Schema::dropIfExists('TT_DET_PEDIDO');
        Schema::dropIfExists('TT_DET_COMPRA');
        Schema::dropIfExists('TT_VENTA');
        Schema::dropIfExists('TT_DET_VENTA');

    }
}
