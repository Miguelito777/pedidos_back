<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'PEDIDOS'], function () use ($router) {
    //TC_CLIENTES
    $router->group(['prefix' => 'clientes'], function () use ($router) {
        $router->get('',  ['uses' => 'TcClienteController@index']);
    });


    //TC_PRODUCTO
    $router->group(['prefix' => 'productos'], function () use ($router) {
        $router->get('',  ['uses' => 'TtProductoController@index']);
    });

    //TC_PRODUCTO
    $router->group(['prefix' => 'catalogo'], function () use ($router) {
        $router->get('',  ['uses' => 'CatalogoController@index']);
    });

        //TT_PEDIDO
        $router->group(['prefix' => 'pedidos'], function () use ($router) {
            $router->post('',  ['uses' => 'TtPedidoController@create']);
            $router->get('',  ['uses' => 'TtPedidoController@index']);
        });
});