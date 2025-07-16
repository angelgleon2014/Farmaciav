<?php

require_once('Model.php');

class Kardex extends Model
{
    protected static $table_name = 'kardexproductos';
    protected $primary_key = 'codkardex';

    function __construct($data)
    {
        parent::__construct($data);
        $this['fechakardex'] = date("Y-m-d");
    }

    /**
     * @param DetalleVenta $detalle
     */
    static public function crearLineaDeCorreccionDetalle($detalle)
    {
        $k = new Kardex([
            "movimiento" => "AJUSTE",
            "documento" => "EDICION MANUAL DE VENTAS",
            "entradacaja" => 0,
            "entradaunidad" => 0,
            "entradacajano" => 0,
            "entradabonif" => 0,
            "salidacaja" => 0,
            "salidaunidad" => 0,
            "salidabonif" => 0,
            "devolucioncaja" => 0,
            "stocktotalcaja" => 0

        ]);

        $k->setearCamposDeProducto($detalle->getProducto());
        $k->setearCamposDeVenta($detalle->getVenta());

        $k['devolucionunidad'] = $detalle['cantventa'];
        $k['devolucionbonif'] = $detalle['cantbonificv'];
        $k['stocktotalunidad'] = ($detalle->getProducto())['stocktotal'];

        return $k;
    }


    /**
     * @param Producto $producto
     */
    public function setearCamposDeProducto($producto)
    {
        $this['codproductom'] = $producto["codproducto"];
        $this['preciocompram'] = $producto['preciocompra'];
        $this['precioventacajam'] = $producto['precioventacaja'];
        $this['precioventaunidadm'] = $producto['precioventaunidad'];
        $this['ivaproductom'] = $producto['ivaproducto'];
        $this['descproductom'] = $producto['descproducto'];

    }

    /**
     * @param Venta $venta
     */
    public function setearCamposDeVenta($venta)
    {
        $this['codproceso'] = $venta['codventa'];
        $this['codresponsable'] = $venta['codcliente'];
        $this['codsucursalm'] = $venta['codsucursal'];
    }
}

?>
