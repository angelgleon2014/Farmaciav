//#######################################################################
function round(value, exp) {
    if (typeof exp === 'undefined' || +exp === 0)
        return Math.round(value);

    value = +value;
    exp = +exp;

    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
        return NaN;

    // Shift
    value = value.toString().split('e');
    value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}

function floorFigure(figure, decimals) {
    if (!decimals) decimals = 2;
    var d = Math.pow(10, decimals);
    return ((figure * d) / d).toFixed(decimals);
}
//########################################################################

function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function () {

    $('#AgregaV').click(function () {
        AgregaVenta();
    });

    $('.agregar').keypress(function (e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13' && !$("#busquedaproductov").is(":focus")) {
            AgregaVenta();
            e.preventDefault();
            return false;
        }
    });

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
             
        if(!window.terminoDeBuscar) return false;
        else if (code == "") {
            $("#busquedaproductov").focus();
            $("#busquedaproductov").css('border-color', '#f0ad4e');
            alert("REALICE LA BUSQUEDA DEL PRODUCTO CORRECTAMENTE");
            return false;
        }
        //comentado
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
                            ivg2 = 1 + ivg / 100;


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
                            var BaseImponible = (item.ivaproducto == "NO" ? parseFloat(ValorNeto) : parseFloat(ValorNeto) / ivg2);

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
                            var CalculoIva = (PrecioUnitario2) / ivg2;

                            //CalculIva2 almacenala el precio unitario menos el descuento menos el iva por las cantidades necesarias
                            var CalculoIva2 = parseFloat(CalculoIva) * parseFloat(item.cantidad) - parseFloat(DescPorc2);
                            var TotalIva = (parseFloat(PrecioUnitario2.toFixed(2)) - parseFloat(DescPorc2.toFixed(2))) - parseFloat(CalculoIva2.toFixed(2));// - parseFloat(DescPorc2.toFixed(2));

                            //CALCULO DE VALOR NETO CON IVA
                            //var ValorNeto2 = parseFloat(ValorTotal2) - parseFloat(DescPorc2);
                            var ValorNeto2 = parseFloat(ValorTotal2) - parseFloat(DescPorc2) + parseFloat(Bonificacion2);

                            //CALCULO DE BASE IMPONIBLE CON IVA
                            var BaseImponible2 = (item.ivaproducto == "NO" ? parseFloat(ValorNeto2) : parseFloat(ValorNeto2) / ivg2);

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


                            var nuevaFila =
                                "<tr>" +
                                "<td><div align='center'>" +
                                '<button class="btn btn-info btn-xss" style="cursor:pointer;" onclick="addItem(' +
                                "'" + item.txtCodigo + "'," +
                                "'-1'," +
                                "'" + item.producto + "'," +
                                "'" + item.presentacion + "'," +
                                "'" + item.principioactivo + "'," +
                                "'" + item.descripcion + "'," +
                                "'" + item.tipo + "', " +
                                "'" + item.cantidad2 + "', " +
                                "'" + item.precio + "', " +
                                "'" + item.precio2 + "', " +
                                "'" + item.precio3 + "', " +
                                "'" + item.descproducto + "', " +
                                "'" + item.desclaboratorio + "', " +
                                "'" + item.descgeneral + "', " +
                                "'" + item.ivaproducto + "', " +
                                "'" + item.precioconiva + "', " +
                                "'-'," +
                                "'" + item.tipoventa + "', " +
                                "'" + item.precioventablisterdesc + "', " +
                                "'" + item.precioventacajadesc + "', " +
                                "'" + item.precioventaunidaddesc + "', " +
                                ')"' +
                                " type='button'><span class='fa fa-minus'></span></button>" +
                                "<input type='text' id='" + item.cantidad + "' style='width:25px;height:24px;border:#FF0000;' value='" + item.cantidad + "'>" +
                                '<button class="btn btn-info btn-xss" style="cursor:pointer;" onclick="addItem(' +
                                "'" + item.txtCodigo + "'," +
                                "'+1'," +
                                "'" + item.producto + "'," +
                                "'" + item.presentacion + "'," +
                                "'" + item.principioactivo + "'," +
                                "'" + item.descripcion + "'," +
                                "'" + item.tipo + "', " +
                                "'" + item.cantidad2 + "', " +
                                "'" + item.precio + "', " +
                                "'" + item.precio2 + "', " +
                                "'" + item.precio3 + "', " +
                                "'" + item.descproducto + "', " +
                                "'" + item.desclaboratorio + "', " +
                                "'" + item.descgeneral + "', " +
                                "'" + item.ivaproducto + "', " +
                                "'" + item.precioconiva + "', " +
                                "'+'," +
                                "'" + item.tipoventa + "', " +
                                "'" + item.precioventablisterdesc + "', " +
                                "'" + item.precioventacajadesc + "', " +
                                "'" + item.precioventaunidaddesc + "', " +
                                ')"' +
                                " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                                "<td><div align='center'><abbr title='" + item.principioactivo + " - " + item.descripcion + "'>" + item.producto + "</abbr><input type='hidden' value='" + item.txtCodigo + "'><input type='hidden' value='" + item.presentacion + "'></div></td>" +
                                "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.descproducto + "'><input type='hidden' value='" + item.descripcion + "'></div></td>" +
                                "<td><div align='center'>" + PrecioUnitario.toFixed(2) + "<input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.tipo + "'></div></td>" +
                                "<td><div align='center'>" + ValorTotal.toFixed(2) + "<input type='hidden' value='" + item.cantidad2 + "'></div></td>" +
                                "<td><div align='center'>" + SumaDesc.toFixed(2) + "<sup>%</sup><input type='hidden' value='" + item.precio + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                                "<td><div align='center'>" + Bonificacion.toFixed(2) + "<sup>" + item.cantidad2 + "</sup><input type='hidden' value='" + item.desclaboratorio + "'></div></td>" +
                                "<td><div align='center'>" + DescPorc.toFixed(2) + "</div></td>" +
                                "<td><div align='center'>" + ValorNeto.toFixed(2) + "<input type='hidden' value='" + item.precioconiva + "'><input type='hidden' value='" + item.descgeneral + "'></div></td>" +
                                "<td><div align='center'>" +
                                '<button class="btn btn-info btn-xss" style="cursor:pointer;color:#fff;" ' +
                                'onclick="addItem(' +
                                "'" + item.txtCodigo + "'," +
                                "'0'," +
                                "'" + item.producto + "'," +
                                "'" + item.presentacion + "'," +
                                "'" + item.principioactivo + "'," +
                                "'" + item.descripcion + "'," +
                                "'" + item.tipo + "', " +
                                "'" + item.cantidad2 + "', " +
                                "'" + item.precio + "', " +
                                "'" + item.precio2 + "', " +
                                "'" + item.precio3 + "', " +
                                "'" + item.descproducto + "', " +
                                "'" + item.desclaboratorio + "', " +
                                "'" + item.descgeneral + "', " +
                                "'" + item.ivaproducto + "', " +
                                "'" + item.precioconiva + "', " +
                                "'='," +
                                "'" + item.tipoventa + "', " +
                                "'" + item.precioventablisterdesc + "', " +
                                "'" + item.precioventacajadesc + "', " +
                                "'" + item.precioventaunidaddesc + "', " +
                                ')"' +
                                ' type="button"><span class="fa fa-trash"></span></button>' +
                                "</div></td>" +
                                "</tr>";
                            $(nuevaFila).appendTo("#carrito tbody");

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

                            /*####### ACTIVO CAMPOS DE FACTURA DE VENTA #######*/
                            $("#tipodocumento").attr('disabled', false);
                            $("#tipopagove").attr('disabled', false);
                            $("#codmediopago").attr('disabled', false);
                            $("#montopagado").attr('disabled', false);
                            $("#montodevuelto").attr('disabled', false);

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

    $("#vaciarv").click(function () {
        var Carrito = new Object();
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Principioactivo = "vaciar";
        Carrito.Descripcion = "vaciar";
        Carrito.Tipo = "vaciar";
        Carrito.Cantidad2 = "0";
        Carrito.Precio = "0";
        Carrito.Precio2 = "0";
        Carrito.Precio3 = "0";
        Carrito.tipoventa = "";
        Carrito.Descproducto = "0.00";
        Carrito.Desclaboratorio = "0.00";
        Carrito.Descgeneral = "0.00";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Precioconiva = "0";
        Carrito.Cantidad = "0";
        Carrito.code_producto = 'vaciar';
        Carrito.precioventablisterdesc = 0;
        Carrito.precioventacajadesc = 0;
        Carrito.precioventaunidaddesc = 0;


        var DatosJson = JSON.stringify(Carrito);
        $.post('carritoventas.php', {
            MiCarrito: DatosJson
        },
            function (data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
                    "<tr>" + "<td colspan=10><center><label>No hay Productos agregados</label></center></td>" + "</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                /*####### ACTIVO CAMPOS DE FACTURA DE VENTA #######*/
                $("#tipodocumento").attr('disabled', true);
                $("#tipopagove").attr('disabled', true);
                $("#codmediopago").attr('disabled', true);
                $("#montopagado").attr('disabled', true);
                $("#montodevuelto").attr('disabled', true);
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });



    $(document).ready(function () {
        $('#vaciarv').click(function () {
            $("#ventas")[0].reset();
            $("#cliente").val("0");
            $('label[id*="cedcliente"]').text('SIN ASIGNAR');
            $('label[id*="nomcliente"]').text('SIN ASIGNAR');
            $('label[id*="direccliente"]').text('SIN ASIGNAR');
            $("#carrito tbody").html("");
            var nuevaFila =
                "<tr>" + "<td colspan=10><center><label>No hay Productos agregados</label></center></td>" + "</tr>";
            $(nuevaFila).appendTo("#carrito tbody");
            $("#lbldescuento").text("0.00");
            $("#lbldescbonif").text("0.00");
            $("#lblsubtotal").text("0.00");
            $("#lblimpuestos").text("0.00");
            $("#lbltarifano").text("0.00");
            $("#lbltarifasi").text("0.00");
            $("#lbliva").text("0.00");
            $("#lbltotal").text("0.00");
            $("#lblGrande").text("0.00");

            $("#txtDescuento").val("0.00");
            $("#txtDescbonif").val("0.00");
            $("#txtsubtotal").val("0.00");
            $("#txtimpuestos").val("0.00");
            $("#txttarifano").val("0.00");
            $("#txttarifasi").val("0.00");
            $("#txtIva").val("0.00");
            $("#txtTotal").val("0.00");

            /*####### ACTIVO CAMPOS DE FACTURA DE VENTA #######*/
            $("#tipodocumento").attr('disabled', true);
            $("#tipopagove").attr('disabled', true);
            $("#codmediopago").attr('disabled', true);
            $("#montopagado").attr('disabled', true);
            $("#montodevuelto").attr('disabled', true);

            //$("#muestracambiospagos").html('<div class="row"><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Monto Pagado: <span class="symbol required"></span></label><input class="form-control calculodevolucion" type="text" name="montopagado" id="montopagado" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Monto Pagado por Cliente" disabled="disabled" required="" aria-required="true"><i class="fa fa-usd form-control-feedback"></i></div></div><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Cambio Devuelto: <span class="symbol required"></span></label><input class="form-control number" type="text" name="montodevuelto" id="montodevuelto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cambio Devuelto a Cliente" disabled="disabled" readonly="readonly" value="0.00" aria-required="true"><i class="fa fa-usd form-control-feedback"></i></div></div></div>');

        });
    });


    //FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE VENTA DE PRODUCTOS
    $(document).ready(function () {
        $('.calculodevolucion').keyup(function () {

            var montototal = $('input#txtTotal').val();
            var montopagado = $('input#montopagado').val();
            var montodevuelto = $('input#montodevuelto').val();

            //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
            total = montopagado - montototal;
            var original = parseFloat(total.toFixed(2));
            $("#montodevuelto").val(original.toFixed(2));/**/

        });
    });


    $("#carrito tbody").on('keydown', 'input', function (e) {
        var element = $(this);
        var pvalue = element.val();
        var code = e.charCode || e.keyCode;
        var avalue = String.fromCharCode(code);
        var action = element.siblings('button').first().attr('onclick');
        var params;
        if (code !== 15 && /[^\d]/ig.test(avalue)) {
            e.preventDefault();
            return;
        }
        if (element.attr('data-proc') == '1') {
            return true;
        }
        element.attr('data-proc', '1');
        params = action.match(/\'([^\']+)\'/g).map(function (v) {
            return v.replace(/\'/g, '');
        });
        setTimeout(function () {
            if (element.attr('data-proc') == '1') {
                var value = element.val() || 0;
                addItem(
                    params[0],
                    value,
                    params[2],
                    params[3],
                    params[4],
                    params[5],
                    params[6],
                    params[7],
                    params[8],
                    params[9],
                    params[10],
                    params[11],
                    params[12],
                    params[13],
                    params[14],
                    params[15],
                    '='
                );
                element.attr('data-proc', '0');
            }
        }, 500);
    });
});

function LimpiarTexto() {
    $("#buscacliente").val("");
    $("#resultado").html("");
    $("#busquedaproductov").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codpresentacion").val("");
    $("#principioactivo").val("");
    $("#descripcion").val("");
    $("#codmedida").val("");
    $("#preciocompra").val("");
    $("#precioventaunidad").val("");
    $("#precioventacaja").val("");
    $("#stocktotal").val("");
    $("#descproducto").val("0.00");
    $("#desclaboratorio").val("0.00");
    $("#ivaproducto").val("");
    $("#precioconiva").val("");
    $("#cantidad").val("");
    $("#cantidad2").val("0");
    $("#cantidadprev").val("0");
    $("#precioventablister").val("");
    //$("#tipoVenta").val("Unidad");

}

function AgregaCliente(codcliente, cedcliente, nomcliente, direccliente, tlfcliente) {
    $("#ventas #cliente").val(codcliente);
    $("#ventas #cedcliente").text(cedcliente);
    $("#ventas #nomcliente").text(nomcliente);
    $("#ventas #direccliente").text(direccliente);
    $("#ventas #tlfcliente").text(tlfcliente);
    setTimeout(function () {
        $("#buscacliente").val("");
        $("#resultado").html("");
    }, 100);
}

function addItem(codigo, cantidad, producto, presentacion, principioactivo, descripcion, tipo, cantidad2, precio, precio2, precio3, descproducto, desclaboratorio, descgeneral, ivaproducto, precioconiva, opCantidad, tipoventa = ", ", precioventablisterdesc, precioventacajadesc, precioventaunidaddesc) {
    console.log("Dispara addItem");
    var Carrito = new Object();
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Presentacion = presentacion;
    Carrito.Principioactivo = principioactivo;
    Carrito.Descripcion = descripcion;
    Carrito.Tipo = tipo;
    Carrito.Cantidad2 = cantidad2;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.Precio3 = precio3;
    Carrito.tipoventa = tipoventa;
    Carrito.Descproducto = descproducto;
    Carrito.Desclaboratorio = desclaboratorio;
    Carrito.Descgeneral = descgeneral;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Precioconiva = precioconiva;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    Carrito.code_producto = codigo + '_' + tipoventa;
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
                var cantsincero = item.cantidad;
                cantsincero = parseInt(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;


                    //##################################################################################//

                    //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                    var ivg = $('input#iva').val();
                    iv = ivg / 100;
                    ivg2 = 1 + ivg / 100;


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
                    var BaseImponible = (item.ivaproducto == "NO" ? parseFloat(ValorNeto) : parseFloat(ValorNeto) / ivg2);

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
                    var CalculoIva = (PrecioUnitario2) / ivg2;

                    //CalculIva2 almacenala el precio unitario menos el descuento menos el iva por las cantidades necesarias
                    var CalculoIva2 = parseFloat(CalculoIva) * parseFloat(item.cantidad) - parseFloat(DescPorc2);
                    var TotalIva = (parseFloat(PrecioUnitario2.toFixed(2)) - parseFloat(DescPorc2.toFixed(2))) - parseFloat(CalculoIva2.toFixed(2));// - parseFloat(DescPorc2.toFixed(2));

                    //CALCULO DE VALOR NETO CON IVA
                    //var ValorNeto2 = parseFloat(ValorTotal2) - parseFloat(DescPorc2);
                    var ValorNeto2 = parseFloat(ValorTotal2) - parseFloat(DescPorc2) + parseFloat(Bonificacion2);

                    //CALCULO DE BASE IMPONIBLE CON IVA
                    var BaseImponible2 = (item.ivaproducto == "NO" ? parseFloat(ValorNeto2) : parseFloat(ValorNeto2) / ivg2);

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


                    var nuevaFila =
                        "<tr>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xss" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.desclaboratorio + "', " +
                        "'" + item.descgeneral + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'-'," +
                        "'" + item.tipoventa + "', " +
                        "'" + item.precioventablisterdesc + "', " +
                        "'" + item.precioventacajadesc + "', " +
                        "'" + item.precioventaunidaddesc + "', " +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' style='width:25px;height:24px;border:#FF0000;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-xss" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.desclaboratorio + "', " +
                        "'" + item.descgeneral + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'+'," +
                        "'" + item.tipoventa + "', " +
                        "'" + item.precioventablisterdesc + "', " +
                        "'" + item.precioventacajadesc + "', " +
                        "'" + item.precioventaunidaddesc + "', " +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'><abbr title='" + item.principioactivo + " - " + item.descripcion + "'>" + item.producto + "</abbr><input type='hidden' value='" + item.txtCodigo + "'><input type='hidden' value='" + item.presentacion + "'></div></td>" +
                        "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.descproducto + "'><input type='hidden' value='" + item.descripcion + "'></div></td>" +
                        "<td><div align='center'>" + PrecioUnitario.toFixed(2) + "<input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.tipo + "'></div></td>" +
                        "<td><div align='center'>" + ValorTotal.toFixed(2) + "<input type='hidden' value='" + item.cantidad2 + "'></div></td>" +
                        "<td><div align='center'>" + SumaDesc.toFixed(2) + "<sup>%</sup><input type='hidden' value='" + item.precio + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                        "<td><div align='center'>" + Bonificacion.toFixed(2) + "<sup>" + item.cantidad2 + "</sup><input type='hidden' value='" + item.desclaboratorio + "'></div></td>" +
                        "<td><div align='center'>" + DescPorc.toFixed(2) + "</div></td>" +
                        "<td><div align='center'>" + ValorNeto.toFixed(2) + "<input type='hidden' value='" + item.precioconiva + "'><input type='hidden' value='" + item.descgeneral + "'></div></td>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xss" style="cursor:pointer;color:#fff;" ' +
                        'onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.desclaboratorio + "', " +
                        "'" + item.descgeneral + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'='," +
                        "'" + item.tipoventa + "', " +
                        "'" + item.precioventablisterdesc + "', " +
                        "'" + item.precioventacajadesc + "', " +
                        "'" + item.precioventaunidaddesc + "', " +
                        ')"' +
                        ' type="button"><span class="fa fa-trash"></span></button>' +
                        "</div></td>" +
                        "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");

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

                    /*####### ACTIVO CAMPOS DE FACTURA DE VENTA #######*/
                    $("#tipodocumento").attr('disabled', false);
                    $("#tipopagove").attr('disabled', false);
                    $("#codmediopago").attr('disabled', false);
                    $("#montopagado").attr('disabled', false);
                    $("#montodevuelto").attr('disabled', false);

                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
                    "<tr>" + "<td colspan=10><center><label>No hay Productos agregados</label></center></td>" + "</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#ventas")[0].reset();
                $("#lbldescuento").text("0.00");
                $("#lbldescbonif").text("0.00");
                $("#lblsubtotal").text("0.00");
                $("#lblimpuestos").text("0.00");
                $("#lbltarifano").text("0.00");
                $("#lbltarifasi").text("0.00");
                $("#lbliva").text("0.00");
                $("#lbltotal").text("0.00");
                $("#lblGrande").text("0.00");

                $("#txtDescuento").val("0.00");
                $("#txtDescbonif").val("0.00");
                $("#txtsubtotal").val("0.00");
                $("#txtimpuestos").val("0.00");
                $("#txttarifano").val("0.00");
                $("#txttarifasi").val("0.00");
                $("#txtIva").val("0.00");
                $("#txtTotal").val("0.00");

                /*####### ACTIVO CAMPOS DE FACTURA DE VENTA #######*/
                $("#tipodocumento").attr('disabled', true);
                $("#tipopagove").attr('disabled', true);
                $("#codmediopago").attr('disabled', true);
                $("#montopagado").attr('disabled', true);
                $("#montodevuelto").attr('disabled', true);

            }
            $("#busquedaproductov").focus();
            LimpiarTexto();
        },
        "json"
    );
    return false;
}


function calculaUnidadCosto() {
    var unidadcaja = $("#unidadcaja").val();
    var unidadblister = $("#unidadblister").val();
    var precioventablister = $("#precioventablister").val();
    var precioventacaja = $("#precioventacaja").val();
    var precioventacajadesc = $("#precioventacajadesc").val();
    var precioventaunidaddesc = $("#precioventaunidaddesc").val();
    var precioventablisterdesc = $("#precioventablisterdesc").val();
    var tipoVenta = $("#tipoVenta").val();
    var cantidadprev = $("#cantidadprev").val();
    var totalCantidad;
    $('#AgregaV').show();

    if (tipoVenta == 'Unidad') {
        totalCantidad = cantidadprev;
        $('#stocktotal').val(_stockTotal);

    } else if (tipoVenta == 'Blister') {
        totalCantidad = parseFloat(cantidadprev) * parseFloat(unidadblister);
        $('#stocktotal').val(_stockBlister);

        if (!precioventablister) {
            $('#AgregaV').hide();
            alert('Este producto no tiene precio por blister registrado');
        }
    } else if (tipoVenta == 'Caja') {
        totalCantidad = parseFloat(cantidadprev) * parseFloat(unidadcaja);
        $('#stocktotal').val(_stockCaja);

        if (!precioventacaja) {
            $('#AgregaV').hide();
            alert('Este producto no tiene precio por caja registrado');
        }
    } else if (tipoVenta == 'BlisterDescuento') {
        totalCantidad = parseFloat(cantidadprev) * parseFloat(unidadblister);
        $('#stocktotal').val(_stockBlister);

        if (!precioventablisterdesc) {
            $('#AgregaV').hide();
            alert('Este producto no tiene precio por blister con descuento registrado');
        }
    } else if (tipoVenta == 'CajaDescuento') {
        totalCantidad = parseFloat(cantidadprev) * parseFloat(unidadcaja);
        $('#stocktotal').val(_stockCaja);

        if (!precioventacajadesc) {
            $('#AgregaV').hide();
            alert('Este producto no tiene precio por caja con descuento registrado');
        }
    } else if (tipoVenta == 'UnidadDescuento') {
        totalCantidad = cantidadprev;
        $('#stocktotal').val(_stockTotal);
    }
    $("#cantidad").val(totalCantidad);

}