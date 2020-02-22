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

    $router->post('testSendMails', 'AuthController@sendMail');
    //TC_CLIENTES
    $router->group(['prefix' => 'clientes'], function () use ($router) {
        $router->get('',  ['uses' => 'TcClienteController@index']);
        $router->post('',  ['uses' => 'TcClienteController@create']);
        $router->put('{id}',  ['uses' => 'TcClienteController@update']);
        
    });

    //TC_PRODUCTO
    $router->group(['prefix' => 'productos'], function () use ($router) {
        $router->get('',  ['uses' => 'TtProductoController@index']);
        $router->post('',  ['uses' => 'TtProductoController@create']); 
        $router->put('{id}',  ['uses' => 'TtProductoController@update']);


    });

    //CATALOGO
    $router->group(['prefix' => 'catalogo'], function () use ($router) {
        $router->get('',  ['uses' => 'CatalogoController@index']);
        $router->get('sabores',  ['uses' => 'CatalogoController@getSabores']);
        $router->post('sabor',  ['uses' => 'CatalogoController@setSabor']); 
        $router->post('tamanio',  ['uses' => 'CatalogoController@setTamanio']);
        $router->post('tipoProducto',  ['uses' => 'CatalogoController@setTipoProducto']); 
        $router->put('sabor/{id}',  ['uses' => 'CatalogoController@updateSabor']); 
        $router->put('tamanio/{id}',  ['uses' => 'CatalogoController@updateTamanio']);
        $router->put('tipoProducto/{id}',  ['uses' => 'CatalogoController@updateTcTipoProducto']); 
        $router->get('tamanios',  ['uses' => 'CatalogoController@getTamanios']);
        $router->get('tipoProducto',  ['uses' => 'CatalogoController@getTipoProducto']);
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
            $router->put('{id}',  ['uses' => 'TtDireccionPedidoController@update']);
            //$router->get('pedidoPDF/{id}',  ['uses' => 'TtPedidoController@pedidoPDF']);
        });
});