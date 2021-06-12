<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\TtPedido;
use App\TtProducto;
use App\TtDetPedido;
use App\TtDireccionPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TtPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = TtPedido::with('cliente','detPedido', 'direccion')->where('id_estado',1)->orderBy('id', 'DESC')->get();
        foreach( $pedidos as $pedido ) {
            $pedido->nombre_cliente = $pedido->cliente->cliente;
            /*echo $order->id;
            echo $order->customer_id;
            echo $order->order_total;
            for( $order->orderDetails as $orderDetails ) {
                echo $orderDetails->product_name;
                echo $orderDetails->product_id;
                echo $orderDetails->quantity;
                echo $orderDetails->price;
            }*/
        }
        return response()->json($pedidos);
        //return response()->json(TtPedido::with('cliente','detPedido', 'direccion')->where('id_estado',1)->orderBy('id', 'DESC')->get());
    }
    public function pedidosVentas()
    {
        $pedidos = TtPedido::with('cliente','detPedido', 'direccion')->where('id_estado',1)->orderBy('id', 'DESC')->get();
        foreach( $pedidos as $pedido ) {
            $pedido->nombre_cliente = $pedido->cliente->cliente;
            $pedido->fecha_entrega = date("d/m/Y", strtotime($pedido->fecha_entrega));
            $pedido->direccion_entrega = $pedido->direccion->direccion_pedido;
            $pedido->total_pedido = 0;
            $detPedido=TtDetPedido::where([['id_pedido','=',$pedido->id]])->get();
            foreach( $detPedido as $det_pedido ) {
                $det_pedido->subtotal = $det_pedido->cantidad * $det_pedido->precio;
                $pedido->total_pedido = $pedido->total_pedido + $det_pedido->subtotal;
            }
            $pedido->saldo = $pedido->total_pedido - $pedido->anticipo;
        }
        return response()->json($pedidos);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pedido = $request->all();
        if($pedido['id_direccion_pedido'] > 0){
        }else{
            $direccionDesc = TtDireccionPedido::where('direccion_pedido', '=', $pedido['direccion_pedido'])->get();
            if($direccionDesc->count() == 0){
                $direccion = array("direccion_pedido"=>$pedido['direccion_pedido'], "id_estado"=>$pedido['id_estado'],"id_usuario_crea"=>$pedido['id_usuario_crea'],"id_usuario_modifica"=>$pedido['id_usuario_modifica'],"observaciones"=>"Ninguna");
                $element = TtDireccionPedido::create($direccion);
                $pedido['id_direccion_pedido'] = $element->id;
            }else{
                $value = $direccionDesc->first();
                $pedido['id_direccion_pedido'] = $value->id;
            }
        }
        $pedido = TtPedido::create($pedido);
        foreach ($request->productos as $i => $det) {
            $det['id_pedido'] = $pedido->id;
            $det['id_estado'] = 1;
            $det['id_usuario_crea']=1;
            $det['id_usuario_modifica']=1;
            $det = TtDetPedido::create($det);
        }
        $pedido->productos = $request->productos;
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

    public function testPDF(){
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
        //return "Hola mundito";
    } 
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pedidoPDF($id){
        $pedido='Pedido no.: ';
        $dompdf = app('dompdf.wrapper');
        //$detPedido;
        $pedido=TtPedido::with('cliente','detPedido', 'direccion')->where([['id_estado','=',1],['id','=',$id]])->get();
        //echo print_r($pedido);
        foreach($pedido as $key => $value){
            $detPedido=TtDetPedido::where([['id_pedido','=',$value['id']]])->get();
            $html = '<html><head>' 
            .'<div style="text-align: center">'
            .'' 
            .'</div>'
            .' <style>table, th, td {border: 1px solid black; border-collapse: collapse;} table#t01 tr:nth-child(even) {background-color: #eee;}table#t01 tr:nth-child(odd) {background-color: #fff;}table#t01 th {background-color: #02370D;color: white;}</style></head><body>'
            . '<p class="lead" style="text-align:center;"><b>CONSTANCIA DE PEDIDO</b></p><br>'
            . '<p class="lead"><b>NO. DE PEDIDO:</b> '.$value['id'].', <b>FECHA: </b>'.date("d/m/Y", strtotime($value['created_at'])).'</p>'
            . '<p class="lead"><b>CLIENTE:</b> '.$value['cliente']->cliente.', <b>TEL. </b>'.$value['cliente']->telefono.'</p>'
            . '<p class="lead"><b>DIRECCION DE ENTREGA: </b> '.$value['direccion']->direccion_pedido.'</p>'
            . '<p class="lead"><b>FECHA DE ENTREGA:</b> '.date("d/m/Y", strtotime($value['fecha_entrega'])).', <b>HORA: </b>'.$value['hora_entrega'].'</p><br>'
            . '<table style="width:100%" id="t01">'
            . '<tr><th>Cantidad</th><th>Producto</th><th>Observaciones o leyenda</th><th>Precio</th><th>Sub total</th></tr>';           
            $htmlBody='';
            $total=0;
            foreach($detPedido as $keyTwo => $valueTwo){
                $subTotal = $valueTwo['cantidad'] * $valueTwo['precio'];
                $total = $total+$subTotal;

                // $productos = TtProducto::with('tipo_producto','tamanio', 'sabor')->where([['id_estado','=',1],['id','=',$valueTwo['id_producto']]]);
                // $desc_producto=$valueTwo['id_producto'];
                // foreach( $productos as $producto ) {
                //     $desc_producto = "des of product";
                // }
                $subTotal = $valueTwo['cantidad'] * $valueTwo['precio'];
                    $htmlBody .= ''
                .'<tr><td>'.$valueTwo['cantidad'].'</td><td>'.$valueTwo['det_pedido'].'</td><td>'.$valueTwo['observaciones'].'</td><td>Q. '.number_format($valueTwo['precio'],2).'</td><td>Q. '.number_format($subTotal,2).'</td></tr>';
            }
            $saldo = $total - $value['anticipo'];
            $htmlFooter = ''
            .'</table>'
            .' <p class="lead">Resumen:</p>'
            .' <table id="t01">'
            . '<tr><td width="70">TOTAL: </td><td width="88" align="right">Q. '.number_format($total,2).'</td></tr>'
            . '<tr><td width="70">ANTICIPO: </td><td width="88" align="right">Q. '.number_format($value['anticipo'],2).'</td></tr>'
            . '<tr><td width="70">SALDO: </td><td width="88" align="right"><b>Q. '.number_format($saldo,2).'</b></td></tr>'
            .' </table> <br><br><br>'
            .' Fecha de impresión: '.date("d/m/Y").''
            . '</body></html>';
            $html = $html.$htmlBody.$htmlFooter;
        }

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        //$dompdf->render();
        return $dompdf->stream('Pedido numero '.$id,[
            'compress' => 1,
            'Attachment' => 0
        ]);
        //$type = ' application/pdf';
        //$headers = ['Content-Type' => $type];
        //$response = new BinaryFileResponse($path, 200 , $headers);

        //return $response;
        //return response()->json($pedido);
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
     * @param  \App\TtPedido  
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $item = TtPedido::findOrFail($id);
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
