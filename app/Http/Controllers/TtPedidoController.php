<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
        //$pedidos=TtPedido::with('cliente')->get();
        /*$pedido = TtPedido::with('cliente','detPedido')->where('id_estado',1)->get();
        foreach($pedido as $value){
            //$value['det_pedido'];
            foreach($value['det_pedido'] as $valueTwo){
                //$value = 8;
            }
        }*/
        return response()->json(TtPedido::with('cliente','detPedido')->where('id_estado',1)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pedido = TtPedido::create($request->all());
        foreach ($request->productos as $i => $det) {
            $det['id_pedido'] = $pedido->id;
            $det['id_estado'] = 1;
            $det['id_usuario_crea']=1;
            $det['id_usuario_modifica']=1;
            $det = TtDetPedido::create($det);
        }
        $pedido->detalle = $request->productos;
        return response()->json($pedido, 201);
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
