<?php

namespace App\Http\Controllers;

use App\TtDireccionPedido;
use Illuminate\Http\Request;

class TtDireccionPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $direcciones = TtDireccionPedido::where('id_estado','=',1)->get();
        return $direcciones;
        //return response()->json($direcciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $element = TtDireccionPedido::create($request->all());
        return response()->json($element, 201);    
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
     * @param  \App\TtDireccionPedido  $ttDireccionPedido
     * @return \Illuminate\Http\Response
     */
    public function show(TtDireccionPedido $ttDireccionPedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TtDireccionPedido  $ttDireccionPedido
     * @return \Illuminate\Http\Response
     */
    public function edit(TtDireccionPedido $ttDireccionPedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TtDireccionPedido  $ttDireccionPedido
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $direccion = TtDireccionPedido::findOrFail($id);
        $direccion->update($request->all());
        return response()->json($direccion, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TtDireccionPedido  $ttDireccionPedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(TtDireccionPedido $ttDireccionPedido)
    {
        //
    }
}
