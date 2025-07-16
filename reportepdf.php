<?php

ob_start();
include_once('fpdf/pdf.php');

require_once("class/class.php");
ob_start();

$casos = array(

                  'SUCURSALES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarSucursales',

                                    'output' => array('Listado de Sucursales.pdf', 'I')

                                  ),

                  'TIPOSTARJETAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarTarjetas',

                                    'output' => array('Listado General de Tarjetas.pdf', 'I')

                                  ),

                  'INTERESESTARJETAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarInteresesTarjetas',

                                    'output' => array('Listado General de Intereses en Tarjetas.pdf', 'I')

                                  ),

                  'USUARIOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarUsuarios',

                                    'output' => array('Listado de Usuarios.pdf', 'I')

                                  ),

                  'LOGS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarLogs',

                                    'output' => array('Listado Logs de Acceso.pdf', 'I')

                                  ),

                  'LABORATORIOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarLaboratorios',

                                    'output' => array('Listado General de Laboratorios.pdf', 'I')

                                  ),

                  'PROVEEDORES' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaListarProveedores',

                                    'output' => array('Listado General de Proveedores.pdf', 'I')

                                  ),

                  'CLIENTES' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaListarClientes',

                                    'output' => array('Listado General de Clientes.pdf', 'I')

                                  ),

                          'CAJAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarCajas',

                                    'output' => array('Listado de Cajas de Ventas.pdf', 'I')

                                  ),

                  'PRODUCTOSACTIVOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosAct',

                                    'output' => array('Listado de Productos Activos.pdf', 'I')

                                  ),

                  'PRODUCTOSINACTIVOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosInact',

                                    'output' => array('Listado de Productos Inactivos.pdf', 'I')

                                  ),


                  'PRODUCTOSXSUCURSAL' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosSucursal',

                                    'output' => array('Listado de Productos por Sucursal.pdf', 'I')

                                  ),


                  'PRODUCTOSXLABORATORIO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosLaboratorio',

                                    'output' => array('Listado de Productos por Laboratorios.pdf', 'I')

                                  ),

                  'PRODUCTOSSTOCK' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'ListarProductosStockMinimo',

                                    'output' => array('Listado de Productos en Stock Minimo.pdf', 'I')

                                  ),

                  'PRODUCTOSVENDIDOS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaListarProductosVendidos',

                                    'output' => array('Listado de Productos Vendidos.pdf', 'I')

                                  ),

                  'PRODUCTOSVENCIDOS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaListarProductosVencidos',

                                    'output' => array('Listado de Productos Vencidos.pdf', 'I')

                                  ),

              'KARDEXPRODUCTOS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaKardexProductos',

                                    'output' => array('Kardex por Producto.pdf', 'I')

                                  ),


                  'TRASPASO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarTraspasos',

                                    'output' => array('Listado de Traspaso de Productos.pdf', 'I')

                                  ),

                  'PEDIDOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaPedidosProductos',

                                    'output' => array('Factura de Pedidos.pdf', 'I')

                                  ),

                  'FACTURACOMPRAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaFacturaCompra',

                                    'output' => array('Factura de Compras.pdf', 'I')

                                  ),

              'COMPRASXPROVEEDOR' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaComprasProveedor',

                                    'output' => array('Compras por Proveedor.pdf', 'I')

                                  ),

              'COMPRASXFECHAS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaComprasFechas',

                                    'output' => array('Compras por Fechas.pdf', 'I')

                                  ),

        'COMPRASXPAGAR' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaComprasxPagar',

                                    'output' => array('Listado de Compras por Pagar.pdf', 'I')

                                  ),

                 'VENTAS' => array(
                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaVentasProductos',

                                    'output' => array('Factura de Venta.pdf', 'I')

                                  ),

                  'FACTURAVENTAS' => array(

                                    //'medidas' => array('P', 'mm', 'A4'),
                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaFacturaVenta',

                                    'output' => array('Factura de Ventas.pdf', 'I')

                                  ),

                  'GUIAREMISION' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaGuiaRemision',

                                    'output' => array('Guia de Remision.pdf', 'I')

                                  ),

                'TICKET' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TablaTicketProductos',

                                    'output' => array('Ticket de Venta.pdf', 'I')

                                  ),

              'VENTASGENERAL' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasGeneral',

                                    'output' => array('Listado de Ventas.pdf', 'I')

                                  ),

        'VENTASXCAJAS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasCajas',

                                    'output' => array('Ventas por Cajas y Fechas.pdf', 'I')

                                  ),

              'VENTASXFECHAS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasFechas',

                                    'output' => array('Ventas por Fechas.pdf', 'I')

                                  ),


                  'INFORMECAJAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarInformeCajas',

                                    'output' => array('Informe de Cajas.pdf', 'I')

                                  ),


                  'ARQUEOSGENERAL' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarArqueosGeneral',

                                    'output' => array('Listado de Arqueo General de Cajas.pdf', 'I')

                                  ),


                  'ARQUEOSFECHAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarArqueosFechas',

                                    'output' => array('Listado de Arqueo de Cajas por Fechas.pdf', 'I')

                                  ),


                  'MOVIMIENTOSGENERAL' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMovimientosGeneral',

                                    'output' => array('Listado de Movimientos General de Cajas.pdf', 'I')

                                  ),


                  'MOVIMIENTOSCAJAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMovimientosCajas',

                                    'output' => array('Listado de Movimientos de Cajas.pdf', 'I')

                                  ),

              'VENTASDIARIASADMINISTRADOR' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasDiariasAdmin',

                                    'output' => array('Ventas Diarias General.pdf', 'I')

                                  ),

              'VENTASDIARIASVENDEDOR' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasDiariasVendedor',

                                    'output' => array('Ventas Diarias por Caja.pdf', 'I')

                                  ),

                'TICKETCREDITOS' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TablaTicketCreditos',

                                    'output' => array('Ticket de Venta.pdf', 'I')

                                  ),

              'CREDITOSCLIENTES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaCreditosClientes',

                                    'output' => array('Creditos por Clientes.pdf', 'I')

                                  ),

              'CREDITOSFECHAS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaCreditosFechas',

                                    'output' => array('Creditos por Fechas.pdf', 'I')

                                  ),

                'DEVOLUCIONES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaDevolucionesProductos',

                                    'output' => array('Factura de DEvolucion.pdf', 'I')

                                  ),


                  'ESTADISTICAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'MuestraGrafica',

                                    'output' => array('Grafico de Ventas Anual.pdf', 'I')

                                  ),

                );


$tipo = base64_decode($_GET['tipo']);
//var_dump($tipo);
$caso_data = $casos[$tipo];
$pdf = new PDF($caso_data['medidas'][0], $caso_data['medidas'][1], $caso_data['medidas'][2]);
$pdf->AddPage();
$pdf->{$caso_data['func']}();
// envio de correo
$pdfdoc = $pdf->Output('S');
$pdf->send_factura_mail($pdfdoc);
$pdf->Output($caso_data['output'][0], $caso_data['output'][1]);
ob_end_flush();
