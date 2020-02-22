<?php

namespace App\Http\Controllers;
use App\TtProducto;
use App\TcTamanio;
use App\TcTipoProducto;
use App\TcSabor;
use Illuminate\Http\Request;

class TtProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producto = TtProducto::with('sabor', 'tipo_producto', 'tamanio')->where('id_estado','=',1)->get();
        foreach($producto as $value){
            $value->producto = $value->tipo_producto->tipo_producto.' '.$value->tamanio->tamanio.' '.$value->sabor->sabor;
        }
        return response()->json($producto);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $element = TtProducto::create($request->all());
        return response()->json($element);    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = TtProducto::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
