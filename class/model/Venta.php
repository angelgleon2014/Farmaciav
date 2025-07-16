<?php

require_once('Model.php');
require_once('DetalleVenta.php');

class Venta extends Model
{
    protected static $table_name = 'ventas';
    protected $primary_key = 'codventa';

    public function addUpDetails()
    {
        // query iluminadora:
        // select tarifasive, tarifasive - tarifasive*0.18, totalsinimpuestosve, tarifasive/1.18, subtotalve from ventas;

        $this['descuentove'] = 0;
        $this['descbonificve'] = 0;
        $this['codserie'] = 0;
        $this['subtotalve'] = 0;
        $this['totalsinimpuestosve'] = 0;
        $this['tarifanove'] = 0;
        $this['tarifasive'] = 0;
        $this['totalivave'] = 0;
        $this['totalpago'] = 0;
        $this['totalpago2'] = 0;
        $this['ganancia'] = 0;

        foreach ($this->getDetalles() as $detalle) {
            // actualizar la data de la venta correspondiente (tiene en cuenta si el producto tiene iva?). Actualizar:

            $txtIncrements = $this->detalleToTxtIncrements($detalle);

            $this['descuentove'] += $txtIncrements["txtDescuento"];
            $this['descbonificve'] += $txtIncrements["txtDescbonif"];
            $this['subtotalve'] += $txtIncrements["txtsubtotal"];
            $this['totalsinimpuestosve'] += $txtIncrements["txtimpuestos"];
            $this['tarifanove'] += $txtIncrements["txttarifano"];
            $this['tarifasive'] += $txtIncrements["txttarifasi"];
            $this['totalivave'] += $txtIncrements["txtIva"];
            $this['totalpago'] += $txtIncrements["txtTotal"];
            $this['totalpago2'] += $txtIncrements["txtTotal"];

            $this['ganancia'] += $detalle->getProducto()->getGanancia($detalle['tipocantidad']);
        
        }

        $this['montodevuelto'] = $this['montopagado'] - $this['totalpago'];

        foreach ($this as $k =>$v) if(is_numeric($v)) $this[$k] = round($v, 2);

    }

    private function detalleToTxtIncrements($detalle) // Logica adaptada de lo que sea que este pasando en jsventas.js
    {
        //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
        $ivg = 18;
        $iv = $ivg / 100;
        $igvMultiplier = 1 + $ivg / 100;

        // precio 3 es el precioprev, el precio de venta de unidad, blisterdescuento, etc, segun el tipo de venta
        $precio3 = $detalle->getProducto()->getPrecioVenta($detalle['tipocantidad']);
        // descgeneral es $_SESSION['descsucursal'];
        $descgeneral = intval($_SESSION['descsucursal'] ?? 0);

        // desclaboratorio es el descuento del laboratorio del producto
        $desclaboratorio = $detalle->getProducto()->getLaboratorio()['desclaboratorio'];

        // precio con iva tambien es precioprev
        $precioConIva = $precio3;

        $descproducto = $detalle->getProducto()['descproducto'];

        $cantventa = $detalle['cantventa'];
        $cantbonif = $detalle['cantbonificv'];

        $ivaproducto = $detalle['ivaproductov'];

        //CALCULO DEL PRECIO UNITARIO SIN IVA
        $DescuentoGeneral = $precio3 * $descgeneral / 100;
        $PrecioUnitario = $precio3 - $DescuentoGeneral;

        //CALCULO DEL VALOR TOTAL SIN IVA
        $ValorTotal = $PrecioUnitario * $cantventa;

        //CALCULO DEL DESC % SIN IVA
        $SumaDesc = $descproducto + $desclaboratorio;

        //CALCULO DEL DESC/BONIFICACION SIN IVA
        //$Bonificacion=$PrecioUnitario *$cantbonif-$PrecioUnitario *$cantbonif *$SumaDesc/100;
        $Bonificacion = $PrecioUnitario * $cantbonif * $SumaDesc / 100;
        $TotalBonificacion = $Bonificacion;

        //CALCULO DEL DESC/PORC SIN IVA
        $CalcD = $PrecioUnitario * $SumaDesc / 100;
        $DescPorc = $CalcD * $cantventa;
        $TotalDescuento = $DescPorc;

        //CALCULO DE VALOR NETO SIN IVA
        $ValorNeto = $ValorTotal - $DescPorc + $Bonificacion;

        //CALCULO DE BASE IMPONIBLE
        $BaseImponible = ($ivaproducto == "NO" ? $ValorNeto : $ValorNeto / $igvMultiplier);

        //##################################################################################//

        //CALCULO DEL PRECIO UNITARIO CON IVA
        $DescuentoGeneral2 = $precioConIva * $descgeneral / 100;
        $PrecioUnitario2 = $precioConIva - $DescuentoGeneral2;

        //CALCULO DEL VALOR TOTAL CON IVA
        $ValorTotal2 = $PrecioUnitario2 * $cantventa;

        //CALCULO DEL DESC % CON IVA
        $SumaDesc2 = $descproducto + $desclaboratorio;

        //CALCULO DEL DESC/BONIFICACION CON IVA
        //$Bonificacion2=$PrecioUnitario2 *$cantbonif;
        $Bonificacion2 = $PrecioUnitario2 * $cantbonif * $SumaDesc2 / 100;
        $TotalBonificacion2 = $Bonificacion2;

        //CALCULO DEL DESC/PORC CON IVA
        $CalcD2 = $PrecioUnitario2 * $SumaDesc2 / 100;
        $DescPorc2 = $CalcD2 * $cantventa;
        $TotalDescuento2 = $DescPorc2;

        //CALCULO DEL IVA 12%
        $CalculoIva = ($PrecioUnitario2) / $igvMultiplier;

        //CalculIva2 almacenala el precio unitario menos el descuento menos el iva por las cantidades necesarias
        $CalculoIva2 = $CalculoIva * $cantventa - $DescPorc2;
        $TotalIva = ($PrecioUnitario2 - $DescPorc2) - $CalculoIva2;

        //CALCULO DE VALOR NETO CON IVA
        //$ValorNeto2 =$ValorTotal2 -$DescPorc2;
        $ValorNeto2 = $ValorTotal2 - $DescPorc2 + $Bonificacion2;

        //CALCULO DE BASE IMPONIBLE CON IVA
        $BaseImponible2 = ($ivaproducto == "NO" ? $ValorNeto2 : $ValorNeto2 / $igvMultiplier);

        //##################################################################################//


        //CALCULO DEL SUBTOTAL GENERAL
        $Subtotal = $BaseImponible + $DescPorc;

        //CALCULO DEL TOTAL IMPUESTOS
        $Impuestos = ($ValorNeto - ($ValorNeto * 0.18));
        //SUBTOTAL TARIFA CERO %
        $SubtotalTarifaNo = ($ivaproducto == "NO" ?  $ValorNeto : 0);

        //SUBTOTAL TARIFA 12 %
        $SubtotalTarifaSi = ($ivaproducto == "SI" ?  $ValorNeto2 : 0);

        //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
        $TotalIvaGeneral = $SubtotalTarifaSi * 0.18;

        //CALCULO DEL TOTAL GENERAL DE FACTURA
        $TotalGeneral = $SubtotalTarifaSi - $TotalDescuento - $TotalBonificacion;
        //TotalGeneral = ($Impuestos * 1.18)- ($TotalDescuento +$TotalBonificacion);

        $res = [];
        $res["txtDescuento"] = $TotalDescuento;
        $res["txtDescbonif"] = $TotalBonificacion;
        $res["txtsubtotal"] = $Subtotal;
        $res["txtimpuestos"] = $Impuestos;
        $res["txttarifano"] = $SubtotalTarifaNo;
        $res["txttarifasi"] = $SubtotalTarifaSi;
        $res["txtIva"] = $TotalIvaGeneral;
        $res["txtTotal"] = $TotalGeneral;
        return $res;
    }

    public function getDetalles()
    {
        return DetalleVenta::findAll([['codventa', '=', $this['codventa']]]);
    }
}
?>
