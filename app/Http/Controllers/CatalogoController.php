<?php

namespace App\Http\Controllers;
use App\TtProducto;
use App\TcCliente;
use Illuminate\Support\Collection;
//use Illuminate\Http\Request;

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
        $productos = TtProducto::with('sabor', 'tipo_producto', 'tamanio')->where('id','=',1)->get();
        foreach ($productos as $i => $producto) {
            $producto->producto = $producto->producto .': '. $producto->tipo_producto->tipo_producto.' '.$producto->sabor->sabor.' '. $producto->tamanio->tamanio;
            unset($productos[$i]->sabor); 
            unset($productos[$i]->tipo_producto); 
            unset($productos[$i]->tamanio); 
        }
        $data = collect(["clientes" => $clientes, "productos" => $productos]);
        return response()->json($data);
    }
}
