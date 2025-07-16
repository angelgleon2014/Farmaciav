<?php

require_once("class/class.php");
require_once("class/model/DetalleVenta.php");

$tra = new Login();
$tipo = base64_decode($_GET['tipo']);
switch ($tipo) {
    /*case 'USUARIOS':
    $tra->EliminarUsuarios();
    exit;
    break;*/

    case 'SUCURSALES':
        $tra->EliminarSucursal();
        exit;
        break;

    case 'MEDIOPAGO':
        $tra->EliminarMediosPagos();
        exit;
        break;

    case 'BANCOS':
        $tra->EliminarBancos();
        exit;
        break;

    case 'TARJETAS':
        $tra->EliminarTarjetas();
        exit;
        break;

    case 'INTERESES':
        $tra->EliminarIntereses();
        exit;
        break;

    case 'MEDIDAS':
        $tra->EliminarMedidas();
        exit;
        break;

    case 'PRESENTACIONES':
        $tra->EliminarPresentacion();
        exit;
        break;

    case 'CAJAS':
        $tra->EliminarCaja();
        exit;
        break;

    case 'LABORATORIOS':
        $tra->EliminarLaboratorios();
        exit;
        break;

    case 'PROVEEDORES':
        $tra->EliminarProveedores();
        exit;
        break;

    case 'CLIENTES':
        $tra->EliminarClientes();
        exit;
        break;

    case 'CHOFER':
        $tra->EliminarTransporte();
        exit;
        break;

    case 'PRODUCTOS':
        $tra->EliminarProductos();
        exit;
        break;

    case 'PEDIDOS':
        $tra->EliminarPedidos();
        exit;
        break;

    case 'DETALLEPEDIDO':
        $tra->EliminarDetallesPedidos();
        exit;
        break;

    case 'PAGARFACTURA':
        $tra->PagarCompras();
        exit;
        break;

    case 'DETALLESCOMPRAS':
        $tra->EliminarDetallesCompras();
        exit;
        break;

    case 'ARQUEOCAJA':
        $tra->EliminarArqueoCaja();
        exit;
        break;

    case 'MOVIMIENTOCAJA':
        $tra->EliminarMovimientoCajas();
        exit;
        break;

    case 'DETALLESVENTAS':
        DetalleVenta::findOne([['coddetalleventa', '=', base64_decode($_GET["coddetalleventa"])]])->delete();
        exit;
        break;


}
