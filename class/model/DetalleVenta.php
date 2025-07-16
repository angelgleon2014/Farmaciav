<?php
require_once('Model.php');
require_once('Producto.php');
require_once('Venta.php');
require_once('Kardex.php');
require_once('Arqueo.php');


class DetalleVenta extends Model
{
    protected static $table_name = 'detalleventas';
    protected $primary_key = 'coddetalleventa';
    private $producto = null;
    private $venta = null;

    public function delete()
    {

        $this->cambiarCantidad(0, 0);

        if (count($this->getVenta()->getDetalles()) == 1) {
            $venta = $this->getVenta();
            if (isset($venta['codventa'])) $venta->delete();
        }

        parent::delete();
    }

    public function cambiarCantidad($cantidad, $cantidadBonificada)
    {
        $diffCantidad = $cantidad - $this['cantventa'];
        $diffCantidadBonificada = $cantidadBonificada - $this['cantbonificv'];

        if (($diffCantidad == 0) && ($diffCantidadBonificada == 0)) return;

        $this->getProducto()->getPrecioVenta($this['tipocantidad']);

        $this['cantventa'] = $cantidad;
        $this['cantbonificv'] = $cantidadBonificada;
        $this['valortotalv'] = $this['valornetov'] = ($cantidad + $cantidadBonificada) *
            $this->getProducto()->getPrecioVenta($this['tipocantidad']);
        $this->save();

        $producto = $this->getProducto();
        $producto->actualizarStock(
            - ($diffCantidad + $diffCantidadBonificada),
            $this['tipocantidad']
        );
        $producto->save();
        $this->refresh();

        $k = Kardex::crearLineaDeCorreccionDetalle($this);
        $k->save();

        $v = $this->getVenta();
        $totalPagoOriginal = $v['totalpago'];
        $v->addUpDetails();
        $v->save();
        $this->refresh();

        if ($v['tipopagove'] == 'CONTADO') {
            $arqueo = Arqueo::findCurrent();
            $arqueo['ingresos'] -= $totalPagoOriginal;
            $arqueo['ingresos'] += $v['totalpago'];
            $arqueo->save();
        }
    }

    public function getGanancia()
    {
        $gananciaSingular = null;
        switch (strtolower($this['tipocantidad'])) {
            case "unidad":
            case "unidaddescuento":
                $gananciaSingular = $this['precioventaunidadv'] - $this['preciocompraunidadv'];
                break;
            case "blister":
            case "blisterdescuento":
                $gananciaSingular = $this['precioventablisterv'] - $this['preciocomprablisterv'];
                break;
            case "caja":
            case "cajadescuento":
                $gananciaSingular = $this['precioventacajav'] - $this['preciocomprav'];
                break;
        }
        return ($this['cantventa'] + $this['cantbonificv']) * $gananciaSingular;
    }

    public function getProducto()
    {
        if (!$this->producto) $this->producto = Producto::findOne([['codproducto', '=', $this['codproductov']]]);

        return $this->producto;
    }

    public function getVenta()
    {
        if (!$this->venta) $this->venta = Venta::findOne([['codventa', '=', $this['codventa']]]);

        return $this->venta;
    }

    public function refresh()
    {
        $this->producto = null;
        $this->venta = null;
    }

    public static function getTipoCantidad()
    {
        return ["unidad", "unidaddescuento", "blister", "blisterdescuento", "caja", "cajadescuento"];
    }
}
