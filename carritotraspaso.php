<?php

//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo == "vaciar") {
    unset($_SESSION["CarritoT"]);
} else {
    if (isset($_SESSION['CarritoT'])) {
        $carrito_traspaso = $_SESSION['CarritoT'];
        if (isset($ObjetoCarrito->Codigo)) {
            $txtCodigo = $ObjetoCarrito->Codigo;
            $producto = $ObjetoCarrito->Producto;
            $presentacion = $ObjetoCarrito->Presentacion;
            $principioactivo = $ObjetoCarrito->Principioactivo;
            $descripcion = $ObjetoCarrito->Descripcion;
            $tipo = $ObjetoCarrito->Tipo;
            $cantidad2 = $ObjetoCarrito->Cantidad2;
            $precio = $ObjetoCarrito->Precio;
            $precio2 = $ObjetoCarrito->Precio2;
            $precio3 = $ObjetoCarrito->Precio3;
            $descproducto = $ObjetoCarrito->Descproducto;
            $desclaboratorio = $ObjetoCarrito->Desclaboratorio;
            $descgeneral = $ObjetoCarrito->Descgeneral;
            $ivaproducto = $ObjetoCarrito->Ivaproducto;
            $precioconiva = $ObjetoCarrito->Precioconiva;
            $fechaexpiracion = $ObjetoCarrito->FechaExpiracion;
            $unidades = $ObjetoCarrito->Unidades;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;

            //array_search("prueba", array_column(array_column($response, "codigo"), 0));

            $donde  = array_search($txtCodigo, array_column($carrito_traspaso, 'txtCodigo'));
            //$donde = array_column("txtCodigo" => $txtCodigo, "producto" => $producto);

            if ($donde !== false) {
                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito_traspaso[$donde]['cantidad'] + $cantidad;
                }
                $carrito_traspaso[$donde] = array(
                    "txtCodigo" => $txtCodigo,
                    "producto" => $producto,
                    "presentacion" => $presentacion,
                    "principioactivo" => $principioactivo,
                    "descripcion" => $descripcion,
                    "tipo" => $tipo,
                    "cantidad2" => $cantidad2,
                    "precio" => $precio,
                    "precio2" => $precio2,
                    "precio3" => $precio3,
                    "descproducto" => $descproducto,
                    "desclaboratorio" => $desclaboratorio,
                    "descgeneral" => $descgeneral,
                    "ivaproducto" => $ivaproducto,
                    "precioconiva" => $precioconiva,
                    "fechaexpiracion" => $fechaexpiracion,
                    "unidades" => $unidades,
                    "cantidad" => $cuanto
                );
            } else {
                $carrito_traspaso[] = array(
                    "txtCodigo" => $txtCodigo,
                    "producto" => $producto,
                    "presentacion" => $presentacion,
                    "principioactivo" => $principioactivo,
                    "descripcion" => $descripcion,
                    "tipo" => $tipo,
                    "cantidad2" => $cantidad2,
                    "precio" => $precio,
                    "precio2" => $precio2,
                    "precio3" => $precio3,
                    "descproducto" => $descproducto,
                    "desclaboratorio" => $desclaboratorio,
                    "descgeneral" => $descgeneral,
                    "ivaproducto" => $ivaproducto,
                    "precioconiva" => $precioconiva,
                    "fechaexpiracion" => $fechaexpiracion,
                    "unidades" => $unidades,
                    "cantidad" => $cantidad
                );
            }
        }
    } else {
        $txtCodigo = $ObjetoCarrito->Codigo;
        $producto = $ObjetoCarrito->Producto;
        $presentacion = $ObjetoCarrito->Presentacion;
        $principioactivo = $ObjetoCarrito->Principioactivo;
        $descripcion = $ObjetoCarrito->Descripcion;
        $tipo = $ObjetoCarrito->Tipo;
        $cantidad2 = $ObjetoCarrito->Cantidad2;
        $precio = $ObjetoCarrito->Precio;
        $precio2 = $ObjetoCarrito->Precio2;
        $precio3 = $ObjetoCarrito->Precio3;
        $descproducto = $ObjetoCarrito->Descproducto;
        $desclaboratorio = $ObjetoCarrito->Desclaboratorio;
        $descgeneral = $ObjetoCarrito->Descgeneral;
        $ivaproducto = $ObjetoCarrito->Ivaproducto;
        $precioconiva = $ObjetoCarrito->Precioconiva;
        $fechaexpiracion = $ObjetoCarrito->FechaExpiracion;
        $unidades = $ObjetoCarrito->Unidades;
        $cantidad = $ObjetoCarrito->Cantidad;
        $carrito_traspaso[] = array(
            "txtCodigo" => $txtCodigo,
            "producto" => $producto,
            "presentacion" => $presentacion,
            "principioactivo" => $principioactivo,
            "descripcion" => $descripcion,
            "tipo" => $tipo,
            "cantidad2" => $cantidad2,
            "precio" => $precio,
            "precio2" => $precio2,
            "precio3" => $precio3,
            "descproducto" => $descproducto,
            "desclaboratorio" => $desclaboratorio,
            "descgeneral" => $descgeneral,
            "ivaproducto" => $ivaproducto,
            "precioconiva" => $precioconiva,
            "fechaexpiracion" => $fechaexpiracion,
            "unidades" => $unidades,
            "cantidad" => $cantidad
        );
    }
    $carrito_traspaso = array_values(
        array_filter($carrito_traspaso, function ($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoT'] = $carrito_traspaso;
    echo json_encode($_SESSION['CarritoT']);
}
