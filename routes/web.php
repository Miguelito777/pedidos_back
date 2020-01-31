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
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    //TC_CLIENTES
    $router->group(['prefix' => 'clientes'], function () use ($router) {
        $router->get('',  ['uses' => 'TcClienteController@index']);
        $router->post('',  ['uses' => 'TcClienteController@create']);
    });

    //TC_PRODUCTO
    $router->group(['prefix' => 'productos'], function () use ($router) {
        $router->get('',  ['uses' => 'TtProductoController@index']);
    });

    //TC_PRODUCTO
    $router->group(['prefix' => 'catalogo'], function () use ($router) {
        $router->get('',  ['uses' => 'CatalogoController@index']);
        $router->get('clientes',  ['uses' => 'TcClienteController@index']);
    });

        //TT_PEDIDO
        $router->group(['prefix' => 'pedidos'], function () use ($router) {
            $router->post('',  ['uses' => 'TtPedidoController@create']);
            $router->get('',  ['uses' => 'TtPedidoController@index']);
            $router->get('ventas',  ['uses' => 'TtPedidoController@pedidosVentas']);
            $router->get('pedidoPDF/{id}',  ['uses' => 'TtPedidoController@pedidoPDF']);
            $router->get('testPDF',  ['uses' => 'TtPedidoController@testPDF']);
        });

        //TT_DIRECCION_PEDIDO
        $router->group(['prefix' => 'direccion'], function () use ($router) {
            $router->post('',  ['uses' => 'TtDireccionPedidoController@create']);
            $router->get('',  ['uses' => 'TtDireccionPedidoController@index']);
            //$router->get('pedidoPDF/{id}',  ['uses' => 'TtPedidoController@pedidoPDF']);
        });
});