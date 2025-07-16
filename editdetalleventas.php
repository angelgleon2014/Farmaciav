<?php

if (
    isset($_SESSION['acceso']) &&
    !(
        $_SESSION['acceso'] == "administradorG" ||
        $_SESSION["acceso"] == "administradorS" ||
        $_SESSION["acceso"] == "bodega"
    )
) {

    die('Sin acceso');
}

require_once('class/class.php');
require_once('class/model/DetalleVenta.php');
require_once('class/model/Producto.php');


$login = new Login();
$login->ExpiraSession();


$coddetalleventa = $_POST['coddetalleventa'];

$detalleVenta = DetalleVenta::findOne([['coddetalleventa', '=', $coddetalleventa]]);
$detalleVenta['codproductov'] = $_POST['codproducto'];
$detalleVenta['productov'] = $_POST['producto'];
$detalleVenta['principioactivov'] = $_POST['principioactivo'];
$detalleVenta['descripcionv'] = $_POST['descripcion'];
$detalleVenta['codmedidav'] = $_POST['codmedida'];
$detalleVenta['codpresentacionv'] = $_POST['codmedida'];
$detalleVenta['tipocantidad'] = $_POST['tipocantidad'];
$detalleVenta['preciounitario'] = $_POST['preciounitario'];
$detalleVenta['valortotalv'] = $_POST['valortotalv'];
$detalleVenta['valornetov'] = $_POST['valornetov'];
$detalleVenta['ivaproductov'] = $_POST['ivaproductov'];

$detalleVenta->cambiarCantidad($_POST['cantventa'], $_POST['cantbonificv']);
$detalleVenta->save();
$detalleVenta->getVenta()->addUpDetails();
$detalleVenta->getVenta()->save();

$producto = $detalleVenta->getProducto();
$producto['producto'] = $_POST['producto'];
$producto['codpresentacion'] = $_POST['codpresentacion'] ?: $producto['codpresentacion'];
$producto->save();
