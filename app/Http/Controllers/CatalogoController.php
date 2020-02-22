<?php

namespace App\Http\Controllers;
use App\TtProducto;
use App\TcCliente;
use App\TcSabor;
use App\TcTamanio;
use App\TcTipoProducto;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clientes = TcCliente::where('id_estado', 1)->get();
        $productos = TtProducto::with('sabor', 'tipo_producto', 'tamanio')->where('id_estado','=',1)->get();
        foreach ($productos as $i => $producto) {
            $producto->producto = $producto->producto .': '. $producto->tipo_producto->tipo_producto.' '.$producto->sabor->sabor.' '. $producto->tamanio->tamanio;
            unset($productos[$i]->sabor); 
            unset($productos[$i]->tipo_producto); 
            unset($productos[$i]->tamanio); 
        }
        $direcciones = new TtDireccionPedidoController();
        $direcciones = $direcciones->index();
        $data = collect(["clientes" => $clientes, "productos" => $productos, "direcciones" => $direcciones]);
        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSabores(){
        $sabores = TcSabor::where('id_estado','=',1)->get();
        return $sabores;
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setSabor(Request $request)
    {
        $element = TcSabor::create($request->all());
        return response()->json($element, 201);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TcSabor  $ttDireccionPedido
     * @return \Illuminate\Http\Response
     */

    public function updateSabor(Request $request, $id)
    {
        $item = TcSabor::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TcTamanio  $ttDireccionPedido
     * @return \Illuminate\Http\Response
     */

    public function updateTamanio(Request $request, $id)
    {
        $item = TcTamanio::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TcTipoProducto  $ttDireccionPedido
     * @return \Illuminate\Http\Response
     */

    public function updateTcTipoProducto(Request $request, $id)
    {
        $item = TcTipoProducto::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTamanios(){
        $items = TcTamanio::where('id_estado','=',1)->get();
        return $items;
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function setTamanio(Request $request)
    {
        $element = TcTamanio::create($request->all());
        return response()->json($element, 201);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTipoProducto(){
        $items = TcTipoProducto::where('id_estado','=',1)->get();
        return $items;
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function setTipoProducto(Request $request)
    {
        $element = TcTipoProducto::create($request->all());
        return response()->json($element, 201);
    }    
}
