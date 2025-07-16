<?php

require_once('Model.php');
require_once('Laboratorio.php');

class Producto extends Model
{
    protected static $table_name = 'productos';
    protected $primary_key = 'codalmacen';

    public static function tipoVentaToTipoCantidad($tipoVenta)
    {
        switch ($tipoVenta) {
            case "unidad":
            case "unidaddescuento":
                return "unidad";
            case "blister":
            case "blisterdescuento":
                return "blister";
            case "caja":
            case "cajadescuento":
                return "caja";
        }
    }

    /**
     * @param int $stockDiff La diferencia de stock, positiva o negativa
     * @param string $tipoVenta blisterdescuento, unidad, etc
     */
    public function actualizarStock($stockDiff, $tipoVenta)
    {
        switch ($tipoVenta) {
            case "unidad":
            case "unidaddescuento":
                $this['stocktotal'] += $stockDiff;
                $this['stockunidad'] += $stockDiff;
                break;
            case "blister":
            case "blisterdescuento":
                $this['stocktotal'] += $stockDiff * $this['blisterunidad'];
                $this['stockblister'] += $stockDiff;
                break;
            case "caja":
            case "cajadescuento":
                $this['stocktotal'] += $stockDiff * $this['unidades'];
                $this['stockcajas'] += $stockDiff;
                break;
        }

    }
    
    public function getGanancia($tipoVenta)
    {
        $precioVenta = $this->getPrecioVenta($tipoVenta);
        switch (strtolower($tipoVenta)) {
            case "unidad":
            case "unidaddescuento":
                return $precioVenta - $this['preciocompraunidad'];
            case "blister":
            case "blisterdescuento":
                return $precioVenta - $this['preciocomprablister'];
            case "caja":
            case "cajadescuento":
                return $precioVenta - $this['preciocompra'];
        }
    }

    public function getPrecioVenta($tipoVenta)
    {
        switch (strtolower($tipoVenta)) {
            case "unidad":
                return $this['precioventaunidad'];
            case "unidaddescuento":
                return $this['precioventaunidaddesc'];
            case "blister":
                return $this['precioventablister'];
            case "blisterdescuento":
                return $this['precioventablisterdesc'];
            case "caja":
                return $this['precioventacaja'];
            case "cajadescuento":
                return $this['precioventacajadesc'];
        }
    }

    public function preciosPorTipo()
    {
        return [
            "unidad" => $this['precioventaunidad'],
            "unidaddescuento" => $this['precioventaunidaddesc'],
            "blister" => $this['precioventablister'],
            "blisterdescuento" => $this['precioventablisterdesc'],
            "caja" => $this['precioventacaja'],
            "cajadescuento" => $this['precioventacajadesc'],
        ];
    }

    public function getLaboratorio()
    {
        return Laboratorio::findOne([['codlaboratorio', '=', $this['codlaboratorio']]]);
    }
}

?>