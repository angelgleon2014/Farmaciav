function AgregaVenta() {
    console.log("Dispara agrega venta");

    var code = $('input#codproducto').val();
    var prod = $('input#producto').val();
    var princ = $('input#principioactivo').val();
    var descrip = $('input#descripcion').val();
    var pres = $('input#codpresentacion').val();
    var cantidadprev = $("#cantidadprev").val();

    var cantp = $('input#cantidad').val();
    var cantp2 = $('input#cantidad2').val();
    var stock = $('input#stocktotal').val();
    var prec = $('input#preciocompra').val();
    var prec2 = $('input#precioventaunidad').val();
    var prec3 = $('input#precioventacaja').val();
    var descuen = $('input#descproducto').val();
    var ivgprod = $('input#ivaproducto').val();
    var tip = $('input#codmedida').val();
    var er_num = /^([0-9])*[.]?[0-9]*$/;
    cantp = parseInt(cantp);
    cantp2 = parseInt(cantp2);
    cantidad = cantp + cantp2;
    stock = parseInt(stock);

    if (code == "") {
        $("#busquedaproductov").focus();
        $("#busquedaproductov").css('border-color', '#f0ad4e');
        alert("REALICE LA BUSQUEDA DEL PRODUCTO CORRECTAMENTE");
        return false;

    }
    else if ($('#cantidad').val() == "" || $('#cantidadprev').val() == "0") {
        $("#cantidad").focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        alert("INGRESE UNA CANTIDAD VALIDA PARA VENTA");
        return false;

    } else if (isNaN($('#cantidad').val())) {
        $("#cantidad").focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        alert("INGRESE SOLO NUMEROS POSITIVOS EN CANTIDAD DE VENTA");
        return false;

    } else {

        var unidadcaja = $("#unidadcaja").val();
        var unidadblister = $("#unidadblister").val();
        var precioventablister = $("#precioventablister").val();
        var precioventacaja = $("#precioventacaja").val();
        var precioventablisterdesc = $("#precioventablisterdesc").val();
        var precioventacajadesc = $("#precioventacajadesc").val();
        var precioventaunidaddesc = $("#precioventaunidaddesc").val();
        var tipoVenta = $("#tipoVenta").val();
        var cantidadprev = $("#cantidadprev").val();
        var precioPrev;
        var totalPrecio;


        if (tipoVenta == 'Unidad') {
            precioPrev = $('input#precioventaunidad').val();
        } else if (tipoVenta == 'Blister') {
            precioPrev = precioventablister;
        } else if (tipoVenta == 'Caja') {
            precioPrev = precioventacaja;
        } else if (tipoVenta == 'BlisterDescuento') {
            precioPrev = precioventablisterdesc;
        } else if (tipoVenta == 'CajaDescuento') {
            precioPrev = precioventacajadesc;
        } else if (tipoVenta == 'UnidadDescuento') {
            precioPrev = precioventaunidaddesc;
        }
        totalPrecio = precioPrev;



        var Carrito = new Object();
        Carrito.Codigo = $('input#codproducto').val();
        Carrito.Producto = $('input#producto').val() + ' (' + tipoVenta + ')';
        Carrito.Presentacion = $('input#codpresentacion').val();
        Carrito.Principioactivo = $('input#principioactivo').val();
        Carrito.Descripcion = $('input#descripcion').val();
        Carrito.Tipo = $('input#codmedida').val();
        Carrito.Cantidad2 = $('input#cantidad2').val();
        Carrito.Precio = $('input#preciocompra').val();
        Carrito.Precio2 = $('input#precioventacaja').val();
        Carrito.Precio3 = precioPrev;
        Carrito.tipoventa = tipoVenta;
        Carrito.Descproducto = $('input#descproducto').val();
        Carrito.Desclaboratorio = $('input#desclaboratorio').val();
        Carrito.Descgeneral = $('input#descgeneral').val();
        Carrito.Ivaproducto = $('input#ivaproducto').val();
        //Carrito.Precioconiva = $('input#precioconiva').val();
        Carrito.Precioconiva = totalPrecio;
        //Carrito.Cantidad = $('input#cantidad').val();
        Carrito.Cantidad = cantidadprev;
        Carrito.opCantidad = '+=';
        Carrito.code_producto = Carrito.Codigo + '_' + Carrito.tipoventa;
        Carrito.precioventablisterdesc = precioventablisterdesc;
        Carrito.precioventacajadesc = precioventacajadesc;
        Carrito.precioventaunidaddesc = precioventaunidaddesc;

        var DatosJson = JSON.stringify(Carrito);
        $.post('carritoventas.php', {
            MiCarrito: DatosJson
        },
            function (data, textStatus) {
                $("#carrito tbody").html("");
                var TotalDescuento = 0;
                var TotalDescuento2 = 0;
                var TotalBonificacion = 0;
                var TotalBonificacion2 = 0;
                var BaseImponible = 0;
                var BaseImponible2 = 0;
                var Subtotal = 0;
                var Impuestos = 0;
                var SubtotalTarifaNo = 0;
                var SubtotalTarifaSi = 0;
                var TotalIvaGeneral = 0;

                var contador = 0;

                $.each(data, function (i, item) {
                    console.debug(item)
                    var cantsincero = item.cantidad;
                    cantsincero = parseInt(cantsincero);
                    if (cantsincero != 0) {
                        contador = contador + 1;

                        //##################################################################################//

                        //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                        var ivg = $('input#iva').val();
                        iv = ivg / 100;
                        igvMultiplier = 1 + ivg / 100;

                        // precio 3 es el precioprev, el precio de venta de unidad, blisterdescuento, etc, segun el tipo de venta
                        // descgeneral es $_SESSION['descsucursal'];

                        // desclaboratorio es el descuento del laboratorio del producto

                        // precio con iva tambien es precioprev

                        //CALCULO DEL PRECIO UNITARIO SIN IVA
                        var DescuentoGeneral = item.precio3 * item.descgeneral / 100; 
                        var PrecioUnitario = parseFloat(item.precio3) - parseFloat(DescuentoGeneral);

                        //CALCULO DEL VALOR TOTAL SIN IVA
                        var ValorTotal = parseFloat(PrecioUnitario) * parseFloat(item.cantidad);

                        //CALCULO DEL DESC % SIN IVA
                        var SumaDesc = parseFloat(item.descproducto) + parseFloat(item.desclaboratorio);

                        //CALCULO DEL DESC/BONIFICACION SIN IVA
                        //var Bonificacion= parseFloat(PrecioUnitario) * parseFloat(item.cantidad2)-parseFloat(PrecioUnitario) * parseFloat(item.cantidad2) * parseFloat(SumaDesc)/100;
                        var Bonificacion = parseFloat(PrecioUnitario) * parseFloat(item.cantidad2) * parseFloat(SumaDesc) / 100;
                        TotalBonificacion = parseFloat(TotalBonificacion) + parseFloat(Bonificacion);

                        //CALCULO DEL DESC/PORC SIN IVA
                        var CalcD = PrecioUnitario * SumaDesc / 100;
                        var DescPorc = CalcD * parseFloat(item.cantidad);
                        TotalDescuento = parseFloat(TotalDescuento) + parseFloat(DescPorc);

                        //CALCULO DE VALOR NETO SIN IVA
                        var ValorNeto = parseFloat(ValorTotal) - parseFloat(DescPorc) + parseFloat(Bonificacion);

                        //CALCULO DE BASE IMPONIBLE
                        var BaseImponible = (item.ivaproducto == "NO" ? parseFloat(ValorNeto) : parseFloat(ValorNeto) / igvMultiplier);

                        //##################################################################################//

                        //CALCULO DEL PRECIO UNITARIO CON IVA
                        var DescuentoGeneral2 = item.precioconiva * item.descgeneral / 100;
                        var PrecioUnitario2 = parseFloat(item.precioconiva) - parseFloat(DescuentoGeneral2);

                        //CALCULO DEL VALOR TOTAL CON IVA
                        var ValorTotal2 = parseFloat(PrecioUnitario2) * parseFloat(item.cantidad);

                        //CALCULO DEL DESC % CON IVA
                        var SumaDesc2 = parseFloat(item.descproducto) + parseFloat(item.desclaboratorio);

                        //CALCULO DEL DESC/BONIFICACION CON IVA
                        //var Bonificacion2= parseFloat(PrecioUnitario2) * parseFloat(item.cantidad2);
                        var Bonificacion2 = parseFloat(PrecioUnitario2) * parseFloat(item.cantidad2) * parseFloat(SumaDesc2) / 100;
                        TotalBonificacion2 = parseFloat(TotalBonificacion2) + parseFloat(Bonificacion2);

                        //CALCULO DEL DESC/PORC CON IVA
                        var CalcD2 = PrecioUnitario2 * SumaDesc2 / 100;
                        var DescPorc2 = CalcD2 * parseFloat(item.cantidad);
                        TotalDescuento2 = parseFloat(TotalDescuento2) + parseFloat(DescPorc2);

                        //CALCULO DEL IVA 12%
                        var CalculoIva = (PrecioUnitario2) / igvMultiplier;

                        //CalculIva2 almacenala el precio unitario menos el descuento menos el iva por las cantidades necesarias
                        var CalculoIva2 = parseFloat(CalculoIva) * parseFloat(item.cantidad) - parseFloat(DescPorc2);
                        var TotalIva = (parseFloat(PrecioUnitario2.toFixed(2)) - parseFloat(DescPorc2.toFixed(2))) - parseFloat(CalculoIva2.toFixed(2));// - parseFloat(DescPorc2.toFixed(2));

                        //CALCULO DE VALOR NETO CON IVA
                        //var ValorNeto2 = parseFloat(ValorTotal2) - parseFloat(DescPorc2);
                        var ValorNeto2 = parseFloat(ValorTotal2) - parseFloat(DescPorc2) + parseFloat(Bonificacion2);

                        //CALCULO DE BASE IMPONIBLE CON IVA
                        var BaseImponible2 = (item.ivaproducto == "NO" ? parseFloat(ValorNeto2) : parseFloat(ValorNeto2) / igvMultiplier);

                        //##################################################################################//


                        //CALCULO DEL SUBTOTAL GENERAL
                        Subtotal = parseFloat(Subtotal) + parseFloat(BaseImponible) + parseFloat(DescPorc);

                        //CALCULO DEL TOTAL IMPUESTOS
                        Impuestos = parseFloat(Impuestos) + (parseFloat(ValorNeto) - (parseFloat(ValorNeto) * 0.18));
                        //SUBTOTAL TARIFA CERO %
                        SubtotalTarifaNo = (item.ivaproducto == "NO" ? parseFloat(SubtotalTarifaNo) + parseFloat(ValorNeto) : parseFloat(SubtotalTarifaNo));

                        //SUBTOTAL TARIFA 12 %
                        SubtotalTarifaSi = (item.ivaproducto == "SI" ? parseFloat(SubtotalTarifaSi) + parseFloat(ValorNeto2) : parseFloat(SubtotalTarifaSi));

                        //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                        TotalIvaGeneral = parseFloat(SubtotalTarifaSi) * 0.18;

                        //CALCULO DEL TOTAL GENERAL DE FACTURA
                        TotalGeneral = parseFloat(SubtotalTarifaSi) - parseFloat(TotalDescuento) - parseFloat(TotalBonificacion);
                        //TotalGeneral = (parseFloat(Impuestos) * 1.18)- ( parseFloat(TotalDescuento) + parseFloat(TotalBonificacion));

                        $("#lbldescuento").text(TotalDescuento.toFixed(2));
                        $("#lbldescbonif").text(TotalBonificacion.toFixed(2));
                        $("#lblsubtotal").text(Subtotal.toFixed(2));
                        $("#lblimpuestos").text(Impuestos.toFixed(2));
                        $("#lbltarifano").text(SubtotalTarifaNo.toFixed(2));
                        $("#lbltarifasi").text(SubtotalTarifaSi.toFixed(2));
                        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                        $("#lbltotal").text(TotalGeneral.toFixed(2));
                        $("#lblGrande").text(TotalGeneral.toFixed(2));

                        $("#txtDescuento").val(TotalDescuento.toFixed(2));
                        $("#txtDescbonif").val(TotalBonificacion.toFixed(2));
                        $("#txtsubtotal").val(Subtotal.toFixed(2));
                        $("#txtimpuestos").val(Impuestos.toFixed(2));
                        $("#txttarifano").val(SubtotalTarifaNo.toFixed(2));
                        $("#txttarifasi").val(SubtotalTarifaSi.toFixed(2));
                        $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                        $("#txtTotal").val(TotalGeneral.toFixed(2));
                        $("#Calculo").val(TotalGeneral.toFixed(2));

                    }

                });

                $("#busquedaproductov").focus();
                LimpiarTexto();
            },
            "json"
        );
        return false;
    }
}