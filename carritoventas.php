<?php

//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo == "vaciar") {
    unset($_SESSION["CarritoV"]);
} else {
    if (isset($_SESSION['CarritoV'])) {
        // Esto se ejecuta cuando sumamos o restamos un producto al carrito
        $carrito_venta = $_SESSION['CarritoV'];
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
            $tipoventa = $ObjetoCarrito->tipoventa;
            $descproducto = $ObjetoCarrito->Descproducto;
            $desclaboratorio = $ObjetoCarrito->Desclaboratorio;
            $descgeneral = $ObjetoCarrito->Descgeneral;
            $ivaproducto = $ObjetoCarrito->Ivaproducto;
            $precioconiva = $ObjetoCarrito->Precioconiva;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;
            $code_producto = $ObjetoCarrito->Codigo . '_' . $ObjetoCarrito->tipoventa;
            $precioventablisterdesc = $ObjetoCarrito->precioventablisterdesc;
            $precioventacajadesc = $ObjetoCarrito->precioventacajadesc;
            $precioventaunidaddesc = $ObjetoCarrito->precioventaunidaddesc;

            // $carrito_venta_json = json_encode($_SESSION['CarritoV']);
            //            $logFile = fopen("log.txt", 'a') or die("Error creando archivo");
            //            fwrite($logFile, "\n". "dale: $carrito_venta_json") or die("Error escribiendo en el archivo");
            //            fclose($logFile);

            //array_search("prueba", array_column(array_column($response, "codigo"), 0));

            $donde  = array_search($code_producto, array_column($carrito_venta, 'code_producto'));
            //$donde = array_column("txtCodigo" => $txtCodigo, "producto" => $producto);

            if ($donde !== false) {
                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito_venta[$donde]['cantidad'] + $cantidad;
                }
                $carrito_venta[$donde] = array(
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
                    "tipoventa" => $tipoventa,
                    "descproducto" => $descproducto,
                    "desclaboratorio" => $desclaboratorio,
                    "descgeneral" => $descgeneral,
                    "ivaproducto" => $ivaproducto,
                    "precioconiva" => $precioconiva,
                    "cantidad" => $cuanto,
                    "code_producto" => $code_producto,
                    "precioventablisterdesc" => $precioventablisterdesc,
                    "precioventacajadesc" => $precioventacajadesc,
                    "precioventaunidaddesc" => $precioventaunidaddesc
                );
            } else {
                $carrito_venta[] = array(
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
                    "tipoventa" => $tipoventa,
                    "descproducto" => $descproducto,
                    "desclaboratorio" => $desclaboratorio,
                    "descgeneral" => $descgeneral,
                    "ivaproducto" => $ivaproducto,
                    "precioconiva" => $precioconiva,
                    "cantidad" => $cantidad,
                    "code_producto" => $code_producto,
                    "precioventablisterdesc" => $precioventablisterdesc,
                    "precioventacajadesc" => $precioventacajadesc,
                    "precioventaunidaddesc" => $precioventaunidaddesc,
                );
            }
        }
    } else {
        // Esto se ejecuta cuando agregamos el primer producto al carrito
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
        $tipoventa = $ObjetoCarrito->tipoventa;
        $descproducto = $ObjetoCarrito->Descproducto;
        $desclaboratorio = $ObjetoCarrito->Desclaboratorio;
        $descgeneral = $ObjetoCarrito->Descgeneral;
        $ivaproducto = $ObjetoCarrito->Ivaproducto;
        $precioconiva = $ObjetoCarrito->Precioconiva;
        $cantidad = $ObjetoCarrito->Cantidad;
        $code_producto = $ObjetoCarrito->Codigo . '_' . $ObjetoCarrito->tipoventa;
        $precioventablisterdesc = $ObjetoCarrito->precioventablisterdesc;
        $precioventacajadesc = $ObjetoCarrito->precioventacajadesc;
        $precioventaunidaddesc = $ObjetoCarrito->precioventaunidaddesc;
        $carrito_venta[] = array(
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
            "tipoventa" => $tipoventa,
            "descproducto" => $descproducto,
            "desclaboratorio" => $desclaboratorio,
            "descgeneral" => $descgeneral,
            "ivaproducto" => $ivaproducto,
            "precioconiva" => $precioconiva,
            "cantidad" => $cantidad,
            "code_producto" => $code_producto,
            "precioventablisterdesc" => $precioventablisterdesc,
            "precioventacajadesc" => $precioventacajadesc,
            "precioventaunidaddesc" => $precioventaunidaddesc
        );
    }
    $carrito_venta = array_values(
        array_filter($carrito_venta, function ($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoV'] = $carrito_venta;
    echo json_encode($_SESSION['CarritoV']);
}
