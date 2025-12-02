<?php



namespace Controllers;

use Exception;
use Model\Caja;
use Model\Cliente;
use Model\Cuota;
use Model\PagoCuota;
use Model\Payment;
use Model\Producto;
use Model\ProductosVenta;
use Model\Usuario;
use Model\Venta;
use TCPDF;

class ApiVentas
{
    public static function imprimirVenta()
    {

        $id = $_GET['id'];
        $venta = Venta::find($id);
        $vendedor = Usuario::find($venta->vendedor_id);
        $importe = 0;
        // echo "<pre>";
        //     var_dump($venta);
        //     echo "</pre>";

        $productos = ProductosVenta::whereArray(['venta_id' => $venta->id]);
        // echo "<pre>";
        // var_dump($productos);
        // echo "</pre>";
        // foreach($productos as $producto_venta){
        //     $producto = Producto::find($producto_venta->producto_id);
        //     echo "<pre>";
        //     $valor_unitario = number_format($producto_venta->precio);
        //     var_dump($valor_unitario);
        //     $total = number_format( $valor_unitario*$producto_venta->cantidad);

        //     echo "</pre>";
        // }

        // echo "<pre>";
        // var_dump($productos);
        // echo "</pre>";
        $pdf  = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $fecha = substr($venta->fecha, 0, -8);


        $pdf = new TCPDF('P', 'mm', array(80, 190), true, 'UTF-8', false);
        //$pdf = new TCPDF('P', 'mm', 'A7', true, 'UTF-8', false);
        $altura_personalizada = 190; // Altura en mm
        $pdf->setPrintHeader(false); //quitamos el header
        $pdf->setPrintFooter(false);

        // Agregar una página al PDF con la altura personalizada
        $pdf->SetMargins(0, 0, 10, 0);
        $pdf->AddPage();

        // Agregar contenido al PDF
        $pdf->SetFont('helvetica', '', 12);

        $bloque_1 = <<<EOF
           
            <div  style="font-size:10px;width:160px; height:500px; text-align:center; font-size:8px margin-bottom:0;">
                <strong style="font-size:11px">PRODUCTOS TECNOLÓGICOS</strong>
                <br>
                Nit: 98395261-7
                <br>
                Cel: 3104624214, 3175881174
                <br>
                Atendido por: $vendedor->nombre
                <br>
                VEREDA LA VICTORIA
           
            </div>
            EOF;
        $pdf->writeHTML($bloque_1, false, false, false, false, '');
        $bloque_salto = <<<EOF
               
         <span  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
             ************************************************************
            <br>
         </span>
     EOF;

        $pdf->writeHTML($bloque_salto, false, false, false, false, '');
        $pdf->write1DBarcode($venta->codigo, 'C39', 34, '', '', 7, 0.3);
        $bloque_2 = <<<EOF
         
                <div  style="font-size:10px;width:160px; height:500px; text-align:left; font-size:8px margin-bottom:0;"> 
                
               
                    Ticket No: $venta->codigo  
                    <br>
                     Fecha : $fecha
                   
                    <br>
                    Cliente: $venta->nombre_cliente
                    <br>
                    Cedula No: <span style="font-size:7px">$venta->cedula_cliente </span> 
                    <br>
                     Celular <span style="font-size:7px">$venta->celular_cliente </span> 
            
                  
                 
                    <br>
                    Dirección: $venta->direccion_cliente
                    <br>
                    Vendedor: $vendedor->nombre
         
            </div>    
               

        EOF;

        $pdf->writeHTML($bloque_2, false, false, false, false, '');

        $bloque_salto = <<<EOF
               
        <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
            ************************************************************
            <br>
            <strong>Productos</strong>
           
           
        </div>
    EOF;
        $pdf->writeHTML($bloque_salto, false, false, false, false, '');

        foreach ($productos as $producto_venta) {
            // $total_producto = number_format($producto['precio_producto']*$producto['cantidad'],2);
            // $valor_unitario = number_format($producto['precio_producto'],2);
            // $description = substr($producto['descripcion'], 0 , 15);

            $valor_unitario = number_format($producto_venta->precio);
            $total = number_format($producto_venta->precio * $producto_venta->cantidad);

            $producto = Producto::find($producto_venta->producto_id);
            $importe = $importe + $producto->precio_venta * $producto_venta->cantidad; //aqui calculamos el valor al precio original (sin descuetno)


            $bloque_productos = <<<EOF
      
        <div  style="font-size:10px;width:160px; text-align:left; font-size:8px">
       
            {$producto->nombre}  : {$valor_unitario}X{$producto_venta->cantidad} = {$total}         
        </div>


    EOF;

            $pdf->writeHTML($bloque_productos, false, false, false, false, '');
        }
        $bloque_salto = <<<EOF
               
        <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
             
            ************************************************************
    
        </div>
    EOF;
        $pdf->writeHTML($bloque_salto, false, false, false, false, '');


        if ($venta->metodo_pago == 1) {
            $descuento = number_format($importe - $venta->total_factura);
            $importe = number_format($importe);
            $total = number_format($venta->total_factura);
            $bloque_correo = <<<EOF
            
                <div  style="font-size:10px;width:160px; text-align:right; font-size:8px margin-bottom:0;">
                    <strong>Metodo de pago </strong> Efectivo  
                   
                    <br>
                    <strong>Importe:</strong> $importe
                    <br>
                    <strong>Descuento :</strong> {$venta->descuento}% = {$descuento}
                    <br>
                 
                        <strong style="font-size:9px">Total:</strong> $total
                 
                 
                    
                </div>
        EOF;
            $pdf->writeHTML($bloque_correo, false, false, false, false, '');
        } else {
            $descuento = number_format($importe - $venta->total_factura);
            $importe = number_format($importe);
            $total = number_format($venta->total_factura);
            $saldo = number_format($venta->total_factura - $venta->recaudo);
            $recaudo = number_format($venta->recaudo);
            $bloque_correo = <<<EOF
            
                <div  style="font-size:10px;width:160px; text-align:right; font-size:8px margin-bottom:0;">
                    <strong>Metodo de pago </strong> Credito  
                    <br>
                    <br>
                    <strong>Importe:</strong> $importe
                    <br>
                    <strong>Descuento :</strong> {$venta->descuento}% = {$descuento}
                    <br>
                    <strong>Total:</strong> $total
                    <br>
                    <strong>Abono:</strong> $recaudo
                    <br>
                    <strong>Saldo Pendiente:</strong> $saldo
                </div>
            EOF;
            $pdf->writeHTML($bloque_correo, false, false, false, false, '');
        }

        $bloque_salto = <<<EOF
               
        <span  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-left:0;">
     
            **************************************************************
            <br>
            GRACIAS POR SU VISITA, VUELVA PRONTO 
            <br> 
            **************************************************************
           
        </span>
    EOF;
        $pdf->writeHTML($bloque_salto, false, false, false, false, '');


        $garantias = <<<EOF
       

            <div  style="font-size:4px; width:160px; height:500px; text-align:center; font-size:6px margin-bottom:0;">
         
            
        
            <span>
                <strong style="font-size:8px">PARA TENER EN CUENTA</strong>
            </span>
            <br>
            <span >
                NO HAY CAMBIOS DE MERCANCIA NI DEVOLUCIÓN DE DINERO 
            </span> 
            <br>
            <span >
                DESPUES DE SALIR DE NUESTRO ALMACEN
            </span> 
            <br>
          
                
                
              
            </div>    
               

        EOF;

        $pdf->writeHTML($garantias, false, false, false, false, '');





        $pdf->Output('example_001.pdf', 'I');
    }
    // public static function ventas()
    // {
    //     $ventas = Venta::all();

    //     $i = 0;

    //     $datoJson = '{
    //      "data": [';
    //     foreach ($ventas as $key => $venta) {
    //         $i++;
    //         $caja = Caja::where('id', $venta->caja_id);

    //         $acciones = "<div class='d-flex' >";
    //         $acciones .= "<button data-venta-id ='" . $venta->id . "' id='info'  type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Ver</span><i class='fas fa-search'></i></button>";

    //         if ($caja->estado == 0) {
    //             $acciones .= "<button data-venta-id ='" . $venta->id . "' id='editar'  type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Editar</span><i class='fas fa-pen'></i></button>";
    //             $acciones .= "<button data-venta-id ='" . $venta->id . "' id='eliminar'  type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio' ><span class='toolMio-text'>Eliminar</span><i class='fas fa-trash' ></i></button>";
    //         }
    //         $acciones .= "<button data-venta-id ='" . $venta->id . "' id='imprimir'  type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Imprimir</span><i class='fas fa-print'></i></button>";
    //         $acciones .= "</div>";




    //         $pagado = '';
    //         if ($venta->pagado == 0) {
    //             $pagado = "<div class='d-flex justify-content-center' >";
    //             $pagado .= "<button   type='button' class='btn  w-65 btn-inline btn-danger btn-sm ' style='min-width:70px'>Pendiente</button>";
    //             $pagado .= "</div >";
    //         } else {
    //             $pagado = "<div class='d-flex justify-content-center'>";
    //             $pagado .= "<button   type='button' class='btn w-65 btn-inline bg-success text-white btn-sm' style='min-width:70px'>Pagado</button>";
    //             $pagado .= "</div >";
    //         }





    //         $datoJson .= '[
    //                      "' . $i . '",
    //                      "' . $venta->codigo . '",
    //                      "' . number_format($venta->total_factura) . '",
    //                      "' . number_format($venta->recaudo) . '",
    //                      "' . $pagado . '",
    //                       "' . $venta->caja_id + 3000000 . '",
    //                      "' . $venta->fecha . '",
    //                      "' . $acciones . '"
    //              ]';
    //         if ($key != count($ventas) - 1) {
    //             $datoJson .= ",";
    //         }
    //     }

    //     $datoJson .=  ']}';


    //     echo $datoJson;
    // }

    public static function ventas()
    {
        $start = $_GET['start'] ?? 0;
        $length = $_GET['length'] ?? 10;
        $search = $_GET['search']['value'] ?? '';
        $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
        $orderDir = $_GET['order'][0]['dir'] ?? 'asc';

        // Columnas en orden visual (ajusta según tu tabla HTML)
        $columnas = ['id', 'codigo', 'total_factura', 'recaudo', 'pagado', 'caja_id', 'fecha'];
        $orderColumn = $columnas[$orderColumnIndex] ?? 'id';

        $ventas = Venta::all();

        // Búsqueda
        if ($search !== '') {
            $ventas = array_filter($ventas, function ($venta) use ($search) {
                return stripos($venta->codigo, $search) !== false ||
                    stripos($venta->fecha, $search) !== false;
            });
        }

        // Ordenar
        usort($ventas, function ($a, $b) use ($orderColumn, $orderDir) {
            $valorA = strtolower((string) $a->{$orderColumn});
            $valorB = strtolower((string) $b->{$orderColumn});
            return $orderDir === 'asc' ? $valorA <=> $valorB : $valorB <=> $valorA;
        });

        $totalRegistros = count($ventas);
        $ventas = array_slice($ventas, $start, $length);

        $data = [];
        foreach ($ventas as $index => $venta) {
            $i = $start + $index + 1;

            $caja = Caja::where('id', $venta->caja_id);

            // Botones de acción
            $acciones = "<div class='d-flex'>";
            $acciones .= "<button data-venta-id='{$venta->id}' id='info' type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Ver</span><i class='fas fa-search'></i></button>";
            if ($caja && $caja->estado == 0) {
                $acciones .= "<button data-venta-id='{$venta->id}' id='editar' type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Editar</span><i class='fas fa-pen'></i></button>";
                $acciones .= "<button data-venta-id='{$venta->id}' id='eliminar' type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Eliminar</span><i class='fas fa-trash'></i></button>";
            }
            $acciones .= "<button data-venta-id='{$venta->id}' id='imprimir' type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Imprimir</span><i class='fas fa-print'></i></button>";
            $acciones .= "</div>";

            // Estado de pago
            $pagado = "<div class='d-flex justify-content-center'>";
            $pagado .= $venta->pagado == 0
                ? "<button type='button' class='btn w-65 btn-inline btn-danger btn-sm' style='min-width:70px'>Pendiente</button>"
                : "<button type='button' class='btn w-65 btn-inline bg-success text-white btn-sm' style='min-width:70px'>Pagado</button>";
            $pagado .= "</div>";

            $data[] = [
                $i,
                $venta->codigo,
                number_format($venta->total_factura),
                number_format($venta->recaudo),
                $pagado,
                $venta->caja_id + 3000000,
                $venta->fecha,
                $acciones
            ];
        }

        echo json_encode([
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $totalRegistros,
            "recordsFiltered" => $totalRegistros,
            "data" => $data
        ], JSON_UNESCAPED_UNICODE);
    }


    public static function venta()
    {


        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
        $venta = Venta::find($id);
        // $venta->cliente = Cliente::find($venta->cliente_id);
        // $venta->vendedor = Usuario::find($venta->vendedor_id);

        $productos = ProductosVenta::whereArrayJoin(['productos_venta.venta_id' => $venta->id], 'productos', 'id', 'producto_id');
        if ($venta->metodo_pago == 2) {
            $cliente = Cliente::find($venta->cliente_id);
            $venta->cliente = $cliente;
        }
        echo json_encode(['productos_venta' => $productos, 'venta' => $venta]);
    }
    public static function crear()
    {
        session_start();
        date_default_timezone_set('America/Bogota');


        $caja = Caja::get(1);
        if (!$caja) {
            echo json_encode(['type' => 'error', 'msg' => 'Para realizar ventas debe abrir una caja']);
            return;
        }
        if ($caja->estado == 1) {
            echo json_encode(['type' => 'error', 'msg' => 'Para realizar ventas debe abrir una caja']);
            return;
        }

        $caja->numero_transacciones = $caja->numero_transacciones + 1;

        $venta = new Venta();
        $venta->sincronizar($_POST);




        $venta->formatearDatosFloat();
        $venta->caja_id = $caja->id;

        $venta->fecha = date('Y-m-d H:i:s');
        $venta->vendedor_id = $_SESSION['id'];

        $venta_anterior = Venta::get(1);

        if (!$venta_anterior) {
            $venta->codigo = 1000000;
        } else {
            $venta->codigo = $venta_anterior->codigo + 1;
        }

        $db = Venta::getDB();
        $db->begin_transaction();


        try {

            $venta_saved = $venta->guardar(); //venta almacenada



            $caja->guardar();


            $productos = json_decode($_POST['productosArray']);
            $cont = 0;
            foreach ($productos as $producto) {
                $producto_actual = Producto::find($producto->id);
                $producto_actual->stock = $producto->stock - $producto->cantidad;
                $producto_actual->ventas = $producto_actual->ventas + $producto->cantidad;
                $producto_actual->guardar();

                $datos = ['cantidad' => $producto->cantidad, 'precio' => $producto->precio_original, 'precio_factura' => $producto->precio_venta, 'producto_id' => $producto->id, 'venta_id' => $venta_saved['id']];
                $productos_venta = new ProductosVenta($datos);

                $productos_venta->guardar();
                $cont = $cont + 1;
            }



            /* si el pago es 2 significa que es a credito si es a uno significa que es de contado */

            if ($venta->metodo_pago == 2 && $venta->recaudo > 0) {

                $payment_number = 2000000;
                $last_payment = Payment::get(1);
                if ($last_payment) {
                    $payment_number = $last_payment->payment_number + 1;
                }


                $payment = new Payment();
                $payment->payment_number = $payment_number;
                $payment->payment_amount = $venta->recaudo ?? 0;
                $payment->remaining_balance = $venta->total - $venta->recaudo;
                $payment->date = date('Y-m-d H:i:s');
                $payment->sale_id = $venta_saved['id'];
                $payment->sale_box_id = $caja->id;
                $payment->user_id = $_SESSION['id'];
                $payment->first_payment = 1;

                $payment->guardar();
            }

            $db->commit();
            echo json_encode(['type' => 'success', 'msg' => 'Venta guardada con Exito']);
            return;
        } catch (Exception $e) {
            debuguear($e);
            $db->rollback();
            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
    }

    //antes de editar revisamos que no hayan pagos asociados de lo contrario no se podra editar la venta


    public static function revisarPagosAsociados()
    {


        if (!is_auth()) {
            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, porfavor intente nuevamente']);
            return;
        }



        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);


        if (!$id) {

            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }

        /* revisamos si hay pagos asocados a la venta con el $id del $_POST['id] de lo contrario no ponermos eliminar */
        $payments = Payment::where('sale_id', $id);
        if ($payments) {
            echo json_encode(['type' => 'error', 'msg' => 'Tiene pagos asociados por lo que no puede editar la venta']);
            return;
        }
        echo json_encode(['type' => 'success', 'msg' => 'redireccionando']);
        return;
    }

    public static function editar()
    {
        session_start();
        date_default_timezone_set('America/Bogota');



        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {

            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }

        $venta_actual = Venta::find($id);
        if (!$venta_actual) {

            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
        $db = Venta::getDB();



        // $productosVenta = new ProductosVenta();

        $productos_venta = ProductosVenta::whereArray(['venta_id' => $id]);

        if (!$productos_venta) {
            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
        $db->begin_transaction();
        try {
            foreach ($productos_venta as $producto_venta) {
                $producto = Producto::find($producto_venta->producto_id);
                $producto->stock = intval($producto->stock) + intval($producto_venta->cantidad);
                $producto->ventas = $producto->ventas - $producto_venta->cantidad;
                $producto->guardar();
            }



            $productos_venta = new ProductosVenta();
            $productos_venta->eliminarWhere('venta_id', $id);


            $venta = new Venta();
            $venta->sincronizar($_POST);


            $venta->fecha = date('Y-m-d H:i:s');
            $venta->vendedor_id = $_SESSION['id'];
            $venta->codigo = $venta_actual->codigo;
            $venta->caja_id = $venta_actual->caja_id;
            $venta->formatearDatosFloat();
            $venta->guardar();





            $productos = json_decode($_POST['productosArray']);
            foreach ($productos as $producto) {
                $producto_actual = Producto::find($producto->id);
                $producto_actual->stock = $producto->stock - $producto->cantidad;
                $producto_actual->ventas = $producto_actual->ventas + $producto->cantidad;
                $producto_actual->guardar();

                $datos = ['cantidad' => $producto->cantidad, 'precio' => $producto->precio_original, 'precio_factura' => $producto->precio_venta, 'producto_id' => $producto->id, 'venta_id' => $id];
                $productos_venta = new ProductosVenta($datos);


                $productos_venta->guardar();
            }





            if ($venta->metodo_pago == 2 && $venta->recaudo > 0) {

                $payment_number = 2000000;
                $last_payment = Payment::get(1);
                if ($last_payment) {
                    $payment_number = $last_payment->payment_number + 1;
                }

                $payment = new Payment();
                $payment->payment_number = $payment_number;
                $payment->payment_amount = $venta->recaudo ?? 0;
                $payment->remaining_balance = $venta->total - $venta->recaudo;
                $payment->date = date('Y-m-d H:i:s');
                $payment->sale_id = $venta_actual->id;
                $payment->sale_box_id =  $venta_actual->caja_id;
                $payment->user_id = $_SESSION['id'];
                $payment->first_payment = 1;

                $payment->guardar();
            }

            $db->commit();
            echo json_encode(['type' => 'success', 'msg' => 'Venta guardada con Exito']);
            return;
        } catch (Exception $e) {
            debuguear($e);
            $db->rollback();
            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
    }



    public static function eliminar()
    {
        session_start();
        date_default_timezone_set('America/Bogota');


        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {

            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
        $venta = Venta::find($id);

        if (!$venta) {

            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }

        if ($venta->metodo_pago == 2) {

            $payments = Payment::where('sale_id', $venta->id);
            if ($payments) {
                echo json_encode(['type' => 'error', 'msg' => 'No es posible eliminar esta venta porque tiene pagos asociados']);
                return;
            }
        }


        $db = Venta::getDB();

        // $productosVenta = new ProductosVenta();

        $productos_venta = ProductosVenta::whereArray(['venta_id' => $id]);
        if (!$productos_venta) {
            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
        $db->begin_transaction();
        try {
            foreach ($productos_venta as $producto_venta) {
                $producto = Producto::find($producto_venta->producto_id);
                $producto->stock = intval($producto->stock) + intval($producto_venta->cantidad);
                $producto->ventas = $producto->ventas - $producto_venta->cantidad;
                $producto->guardar();
            }
            $productos_venta = new ProductosVenta();
            $productos_venta->eliminarWhere('venta_id', $id);



            $caja = Caja::find($venta->caja_id);
            $caja->numero_transacciones =  $caja->numero_transacciones - 1;
            $caja->guardar();

            $venta->eliminar();

            $db->commit();
            echo json_encode(['type' => 'success', 'msg' => 'Venta eliminada con Exito']);
            return;
        } catch (Exception $e) {
            $db->rollback();
            echo json_encode(['type' => 'error', 'msg' => 'Hubo un error, Intenta nuevamente']);
            return;
        }
    }


    public static  function productos()
    {
        $productos = Producto::all();
        echo json_encode($productos);
    }
    public static  function clientes()
    {
        $clientes_all = Cliente::all();



        echo json_encode($clientes_all);
    }

    public static function clientesFiados()
    {
        $clientes = Cliente::all();


        echo json_encode($clientes);
    }

    public static function codigoVenta()
    {
        $venta = Venta::get(1);

        if (!$venta) {
            echo json_encode(1000);
        } else {
            $venta->codigo = $venta->codigo + 1;
            echo json_encode($venta->codigo);
        }
    }
}



/* 
 pago_cuotas
    id
    venta_id
    pago_id
    cliente_id

*/

/*  cuotas

    id 
    monto
    fecha_pago
    cuotas_id
    caja_id

*/