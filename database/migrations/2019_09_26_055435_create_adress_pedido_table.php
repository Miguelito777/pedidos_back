<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdressPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TT_DIRECCION_PEDIDO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direccion_pedido',128);
            $table->string('observaciones',128);
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('TS_ESTADO');
            $table->unsignedBigInteger('id_usuario_crea');
            $table->foreign('id_usuario_crea')->references('id')->on('TC_USUARIO');
            $table->unsignedBigInteger('id_usuario_modifica');
            $table->foreign('id_usuario_modifica')->references('id')->on('TC_USUARIO');
            $table->timestamps();
        });
        Schema::table('TT_PEDIDO', function($table) {
            $table->unsignedBigInteger('id_direccion_pedido')->nullable($value = true);
            $table->foreign('id_direccion_pedido')->references('id')->on('TT_DIRECCION_PEDIDO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TT_DIRECCION_PEDIDO');
        Schema::table('TT_PEDIDO', function($table) {
            $table->dropColumn('id_direccion_pedido');
        });
    }
}
