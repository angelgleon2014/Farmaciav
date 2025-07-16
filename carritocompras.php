<?php

//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo == "vaciar") {
    unset($_SESSION["CarritoC"]);
} else {
    if (isset($_SESSION['CarritoC'])) {
        $carrito_compra = $_SESSION['CarritoC'];
        if (isset($ObjetoCarrito->Codigo)) {
            $txtCodigo = $ObjetoCarrito->Codigo;
            $producto = $ObjetoCarrito->Producto;
            $presentacion = $ObjetoCarrito->Presentacion;
            $principioactivo = $ObjetoCarrito->Principioactivo;
            $descripcion = $ObjetoCarrito->Descripcion;
            $tipo = $ObjetoCarrito->Tipo;
            $lote = $ObjetoCarrito->Lote;
            $cantidad2 = $ObjetoCarrito->Cantidad2;
            $tipoProd = $ObjetoCarrito->tipoProd;
            $unidades = $ObjetoCarrito->Unidades;
            $precio = $ObjetoCarrito->Precio;
            $precio2 = $ObjetoCarrito->Precio2;
            $precio3 = $ObjetoCarrito->Precio3;
            $descproductofact = $ObjetoCarrito->DescproductoFact;
            $descproducto = $ObjetoCarrito->Descproducto;
            $ivaproducto = $ObjetoCarrito->Ivaproducto;
            $fechaelaboracion = $ObjetoCarrito->Fechaelaboracion;
            $fechaexpiracion = $ObjetoCarrito->Fechaexpiracion;
            $codigobarra = $ObjetoCarrito->Codigobarra;
            $codlaboratorio = $ObjetoCarrito->Codlaboratorio;
            $precioconiva = $ObjetoCarrito->Precioconiva;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;
            
            //es regalo?
            $is_shift = $ObjetoCarrito->is_shift;

            //nuevos campos
            $precioventablisterdesc = $ObjetoCarrito->precioventablisterdesc;
            $precioventacajadesc = $ObjetoCarrito->precioventacajadesc;
            $precioventaunidaddesc = $ObjetoCarrito->precioventaunidaddesc;

            //array_search("prueba", array_column(array_column($response, "codigo"), 0));
            $donde = false;
            $position = 0;
            foreach ($carrito_compra as $item) {
                if ($item['txtCodigo'] == $txtCodigo && $item['tipoProd'] == $tipoProd) {
                    $donde = $position;
                }
                $position += 1;
            }

            // $donde  = array_search($txtCodigo, array_column($carrito_compra, 'txtCodigo'));

            //$donde = array_column("txtCodigo" => $txtCodigo, "producto" => $producto);

            if ($donde !== false) {
                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito_compra[$donde]['cantidad'] + $cantidad;
                }
                $carrito_compra[$donde] = array(
                    "txtCodigo" => $txtCodigo,
                    "producto" => $producto,
                    "presentacion" => $presentacion,
                    "principioactivo" => $principioactivo,
                    "descripcion" => $descripcion,
                    "tipo" => $tipo,
                    "lote" => $lote,
                    "cantidad2" => $cantidad2,
                    "unidades" => $unidades,
                    "precio" => $precio,
                    "precio2" => $precio2,
                    "precio3" => $precio3,
                    "descproductofact" => $descproductofact,
                    "descproducto" => $descproducto,
                    "ivaproducto" => $ivaproducto,
                    "fechaelaboracion" => $fechaelaboracion,
                    "fechaexpiracion" => $fechaexpiracion,
                    "codigobarra" => $codigobarra,
                    "codlaboratorio" => $codlaboratorio,
                    "precioconiva" => $precioconiva,
                    "cantidad" => $cuanto,
                    "tipoProd" => $tipoProd,
                    "precioventablisterdesc" => $precioventablisterdesc,
                    "precioventacajadesc" => $precioventacajadesc,
                    "precioventaunidaddesc" => $precioventaunidaddesc
                );
            } else {
                $carrito_compra[] = array(
                    "txtCodigo" => $txtCodigo,
                    "producto" => $producto,
                    "presentacion" => $presentacion,
                    "principioactivo" => $principioactivo,
                    "descripcion" => $descripcion,
                    "tipo" => $tipo,
                    "lote" => $lote,
                    "cantidad2" => $cantidad2,
                    "unidades" => $unidades,
                    "precio" => $precio,
                    "precio2" => $precio2,
                    "precio3" => $precio3,
                    "descproductofact" => $descproductofact,
                    "descproducto" => $descproducto,
                    "ivaproducto" => $ivaproducto,
                    "fechaelaboracion" => $fechaelaboracion,
                    "fechaexpiracion" => $fechaexpiracion,
                    "codigobarra" => $codigobarra,
                    "codlaboratorio" => $codlaboratorio,
                    "precioconiva" => $precioconiva,
                    "cantidad" => $cantidad,
                    "tipoProd" => $tipoProd,
                    "precioventablisterdesc" => $precioventablisterdesc,
                    "precioventacajadesc" => $precioventacajadesc,
                    "precioventaunidaddesc" => $precioventaunidaddesc
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
        $tipoProd = $ObjetoCarrito->tipoProd;
        $lote = $ObjetoCarrito->Lote;
        $cantidad2 = $ObjetoCarrito->Cantidad2;
        $unidades = $ObjetoCarrito->Unidades;
        $precio = $ObjetoCarrito->Precio;
        $precio2 = $ObjetoCarrito->Precio2;
        $precio3 = $ObjetoCarrito->Precio3;
        $descproductofact = $ObjetoCarrito->DescproductoFact;
        $descproducto = $ObjetoCarrito->Descproducto;
        $ivaproducto = $ObjetoCarrito->Ivaproducto;
        $codlaboratorio = $ObjetoCarrito->Codlaboratorio;
        $codigobarra = $ObjetoCarrito->Codigobarra;
        $fechaelaboracion = $ObjetoCarrito->Fechaelaboracion;
        $fechaexpiracion = $ObjetoCarrito->Fechaexpiracion;
        $precioconiva = $ObjetoCarrito->Precioconiva;
        $cantidad = $ObjetoCarrito->Cantidad;
        //nuevos campos
        $precioventablisterdesc = $ObjetoCarrito->precioventablisterdesc;
        $precioventacajadesc = $ObjetoCarrito->precioventacajadesc;
        $precioventaunidaddesc = $ObjetoCarrito->precioventaunidaddesc;

        $carrito_compra[] = array(
            "txtCodigo" => $txtCodigo,
            "producto" => $producto,
            "presentacion" => $presentacion,
            "principioactivo" => $principioactivo,
            "descripcion" => $descripcion,
            "tipo" => $tipo,
            "lote" => $lote,
            "cantidad2" => $cantidad2,
            "unidades" => $unidades,
            "precio" => $precio,
            "precio2" => $precio2,
            "precio3" => $precio3,
            "descproductofact" => $descproductofact,
            "descproducto" => $descproducto,
            "ivaproducto" => $ivaproducto,
            "fechaelaboracion" => $fechaelaboracion,
            "fechaexpiracion" => $fechaexpiracion,
            "codigobarra" => $codigobarra,
            "codlaboratorio" => $codlaboratorio,
            "precioconiva" => $precioconiva,
            "cantidad" => $cantidad,
            "tipoProd" => $tipoProd,
            "precioventablisterdesc" => $precioventablisterdesc,
            "precioventacajadesc" => $precioventacajadesc,
            "precioventaunidaddesc" => $precioventaunidaddesc
        );
    }
    $carrito_compra = array_values(
        array_filter($carrito_compra, function ($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoC'] = $carrito_compra;
    echo json_encode($_SESSION['CarritoC']);
}
