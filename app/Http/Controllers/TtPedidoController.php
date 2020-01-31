<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\TtPedido;
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
        $dompdf = new Dompdf();
        //$detPedido;
        $pedido=TtPedido::with('cliente','detPedido', 'direccion')->where([['id_estado','=',1],['id','=',$id]])->get();
        //echo print_r($pedido);
        foreach($pedido as $key => $value){
            $detPedido=TtDetPedido::where([['id_pedido','=',$value['id']]])->get();
            $html = '<html><head><style>table, th, td {border: 1px solid black; border-collapse: collapse;} table#t01 tr:nth-child(even) {background-color: #eee;}table#t01 tr:nth-child(odd) {background-color: #fff;}table#t01 th {background-color: #02370D;color: white;}</style></head><body>'
            . '<p class="lead" style="text-align:center;"><b>PANADERIA Y PASTELERIA CAPRICE</b><br><b>Tel. 77663236</b> <br> '
            . '<b>Correo: pypcaprice28@gmail.com</b> <br> '
            . '<br> CONSTANCIA DE PEDIDO </p> <br>'
            . '<p class="lead"><b>NO. DE PEDIDO:</b> '.$value['id'].', <b>FECHA: </b>'.date("d/m/Y", strtotime($value['created_at'])).'</p>'
            . '<p class="lead"><b>CLIENTE:</b> '.$value['cliente']->cliente.', <b>TEL. </b>'.$value['cliente']->telefono.'</p>'
            . '<p class="lead"><b>DIRECCION DE ENTREGA: </b> '.$value['direccion']->direccion_pedido.'</p>'
            . '<p class="lead"><b>FECHA DE ENTREGA:</b> '.date("d/m/Y", strtotime($value['fecha_entrega'])).', <b>HORA: </b>'.$value['hora_entrega'].'</p><br>'
            . '<table style="width:100%" id="t01">'
            . '<tr><th>Cantidad</th><th>Producto</th><th>Observaciones o leyenda</th><th>Precio</th><th>Sub total</th></tr>';           
            $htmlBody='';
            foreach($detPedido as $keyTwo => $valueTwo){
                $subTotal = $valueTwo['cantidad'] * $valueTwo['precio'];
                $htmlBody .= ''
                .'<tr><td>'.$valueTwo['cantidad'].'</td><td>'.$valueTwo['det_pedido'].'</td><td>'.$valueTwo['observaciones'].'</td><td>'.$valueTwo['precio'].'</td><td>'.$subTotal.'</td></tr>';
            }
            $htmlFooter = ''
            .'</table>'
            . '</body></html>';
            $html = $html.$htmlBody.$htmlFooter;
        }

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        $dompdf->stream('myDocument',[
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
