<?php

//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo == "vaciar") {
    unset($_SESSION["CarritoP"]);
} else {
    if (isset($_SESSION['CarritoP'])) {
        $carrito_pedido = $_SESSION['CarritoP'];
        if (isset($ObjetoCarrito->Codigo)) {
            $txtCodigo = $ObjetoCarrito->Codigo;
            $producto = $ObjetoCarrito->Producto;
            $presentacion = $ObjetoCarrito->Presentacion;
            $presentacion2 = $ObjetoCarrito->Presentacion2;
            $principioactivo = $ObjetoCarrito->Principioactivo;
            $descripcion = $ObjetoCarrito->Descripcion;
            $tipo = $ObjetoCarrito->Tipo;
            $medida = $ObjetoCarrito->Medida;
            $laboratorio = $ObjetoCarrito->Laboratorio;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;

            $donde  = array_search($txtCodigo, array_column($carrito_pedido, 'txtCodigo'));

            if ($donde !== false) {
                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito_pedido[$donde]['cantidad'] + $cantidad;
                }
                $carrito_pedido[$donde] = array(
                    "txtCodigo" => $txtCodigo,
                    "producto" => $producto,
                    "presentacion" => $presentacion,
                    "presentacion2" => $presentacion2,
                    "principioactivo" => $principioactivo,
                    "descripcion" => $descripcion,
                    "tipo" => $tipo,
                    "medida" => $medida,
                    "laboratorio" => $laboratorio,
                    "cantidad" => $cuanto
                );
            } else {
                $carrito_pedido[] = array(
                    "txtCodigo" => $txtCodigo,
                    "producto" => $producto,
                    "presentacion" => $presentacion,
                    "presentacion2" => $presentacion2,
                    "principioactivo" => $principioactivo,
                    "descripcion" => $descripcion,
                    "tipo" => $tipo,
                    "medida" => $medida,
                    "laboratorio" => $laboratorio,
                    "cantidad" => $cantidad
                );
            }
        }
    } else {
        $txtCodigo = $ObjetoCarrito->Codigo;
        $producto = $ObjetoCarrito->Producto;
        $presentacion = $ObjetoCarrito->Presentacion;
        $presentacion2 = $ObjetoCarrito->Presentacion2;
        $principioactivo = $ObjetoCarrito->Principioactivo;
        $descripcion = $ObjetoCarrito->Descripcion;
        $tipo = $ObjetoCarrito->Tipo;
        $medida = $ObjetoCarrito->Medida;
        $laboratorio = $ObjetoCarrito->Laboratorio;
        $cantidad = $ObjetoCarrito->Cantidad;
        $carrito_pedido[] = array(
            "txtCodigo" => $txtCodigo,
            "producto" => $producto,
            "presentacion" => $presentacion,
            "presentacion2" => $presentacion2,
            "principioactivo" => $principioactivo,
            "descripcion" => $descripcion,
            "tipo" => $tipo,
            "medida" => $medida,
            "laboratorio" => $laboratorio,
            "cantidad" => $cantidad
        );
    }
    $carrito_pedido = array_values(
        array_filter($carrito_pedido, function ($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoP'] = $carrito_pedido;
    echo json_encode($_SESSION['CarritoP']);
}
