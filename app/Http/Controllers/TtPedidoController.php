<?php

namespace App\Http\Controllers;
use App\TtPedido;
use App\TtDetPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TtPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $pedido = $request->get('productos');
        foreach($pedido as $key => $value)
        {
            $pedido[$key]->get('producto');
        }
        //$pedido = $request->productos[0]->producto;
    //$pedido = TtPedido::create($request->all(/*['pedido', 'fecha_entrega', 'anticipo','observaciones','id_estado','id_cliente','id_usuario_crea','id_usuario_modifica']*/));
        //$i = 0;
        //$prod = $request->only(['pedido');
        //foreach ($request->productos as $i => $det) {
            //$request->productos[$i]->cantidad = 8;
            //$det->cantidad;
            //$det->cantidad=8;
            //$det->id_pedido = $pedido->id;
            /*$det->det_pedido = $det->producto;
            $det->observaciones = "NINGUNA";
            $det->observaciones = "NINGUNA";
            $det->id_estado = 1;
            $det->id_usuario_crea = 1;
            $det->id_usuario_modifica = 1;*/
            //$det = TtDetPedido::create($det);
        //}
        //$pedido->sizee = $i;
        //$pedido->productos = $request->productos;
        return response()->json($pedido, 201);
        //return "Llego al servicio";
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
        //
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
