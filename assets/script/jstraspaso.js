
function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

 $(".agregar").keypress(function(e) {
        if (e.charCode == 13 || e.keyCode == 13) { //ENTER*/
            
        //$("#AgregaC").click(function(){
            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var princ = $('input#principioactivo').val();
            var descrip = $('input#descripcion').val();
            var pres = $('input#codpresentacion').val();
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
            cantidad = cantp+cantp2;
            stock = parseInt(stock);
            //exist = parseInt(exist);

        if (cantidad > stock) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                $("#cantidad2").focus();
                $("#cantidad2").css('border-color', '#f0ad4e');
                $("#stocktotal").focus();
                $("#stocktotal").css('border-color', '#f0ad4e');
                alert("NO EXISTE LA CANTIDAD SOLICITADA PARA EL PRODUCTO "+ prod);
                return false;

           } else if (code == "") {
                $("#codproducto").focus();
                $("#codproducto").css('border-color', '#f0ad4e');
                alert("REALICE LA BUSQUEDA DEL PRODUCTO CORRECTAMENTE");
                return false;
                
            } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
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

                var Carrito = new Object();
                Carrito.Codigo = $('input#codproducto').val();
                Carrito.Producto = $('input#producto').val();
                Carrito.Presentacion = $('input#codpresentacion').val();
                Carrito.Principioactivo = $('input#principioactivo').val();
                Carrito.Descripcion = $('input#descripcion').val();
                Carrito.Tipo = $('input#codmedida').val();
                Carrito.Cantidad2 = $('input#cantidad2').val();
                Carrito.Precio      = $('input#preciocompra').val();
                Carrito.Precio2      = $('input#precioventacaja').val();
                Carrito.Precio3      = $('input#precioventaunidad').val();
                Carrito.Descproducto      = $('input#descproducto').val();
                Carrito.Desclaboratorio      = $('input#desclaboratorio').val();
                Carrito.Descgeneral      = $('input#descgeneral').val();
                Carrito.Ivaproducto = $('input#ivaproducto').val();
                Carrito.Precioconiva = $('input#precioconiva').val();
                Carrito.FechaExpiracion = $('input#fechaexpiracion').val();
                Carrito.Unidades = $('input#unidades').val();
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritotraspaso.php', {
                        MiCarrito: DatosJson
                    },
                    function(data, textStatus) {
                        $("#carrito tbody").html("");
                        var TotalDescuento = 0;
                        var TotalDescuento2 = 0;
                        var TotalBonificacion = 0;
                        var TotalBonificacion2 = 0;
                        var Subtotal = 0;
                        var Impuestos = 0;
                        var SubtotalTarifaNo = 0;
                        var SubtotalTarifaSi = 0;

                        var contador = 0;

                        $.each(data, function(i, item) {
                            var cantsincero = item.cantidad;
                            cantsincero = parseInt(cantsincero);
                            if (cantsincero != 0) {
                                contador = contador + 1;

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
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.unidades + "', " +
                        "'-'" +
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
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.unidades + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'><abbr title='" + item.principioactivo + " - " + item.descripcion + "'>" + item.producto + "</abbr><input type='hidden' value='" + item.txtCodigo + "'><input type='hidden' value='" + item.presentacion + "'></div></td>" +
                        "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.descproducto + "'><input type='hidden' value='" + item.descripcion + "'></div></td>" +
                        "<td><div align='center'>" + item.descproducto + "<sup>%</sup><input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.tipo + "'></div></td>" +
                        "<td><div align='center'>" + item.precio + "<input type='hidden' value='" + item.cantidad2 + "'></div></td>" +
                        "<td><div align='center'>" + item.precio2 + "<input type='hidden' value='" + item.precio + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                        "<td><div align='center'>" + item.precio3 + "<input type='hidden' value='" + item.unidades + "'></div></td>" +
                        "<td><div align='center'>" + item.fechaexpiracion + "<input type='hidden' value='" + item.precioconiva + "'></div></td>" +
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
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.unidades + "', " +
                        "'='" +
                        ')"' +
                        ' type="button"><span class="fa fa-trash"></span></button>' +
                                    "</div></td>" +
                                    "</tr>";
                                $(nuevaFila).appendTo("#carrito tbody");

                            }

                        });

                       $("#busquedaproductot").focus();
                        LimpiarTexto();
                    },
                    "json"
                );
                return false;
            }
        }
    });

    $("#vaciart").click(function() {
        var Carrito = new Object();
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Principioactivo = "vaciar";
        Carrito.Descripcion = "vaciar";
        Carrito.Tipo = "vaciar";
        Carrito.Cantidad2 = "0";
        Carrito.Precio      = "0";
        Carrito.Precio2      = "0";
        Carrito.Precio3      = "0";
        Carrito.Descproducto      = "0.00";
        Carrito.Desclaboratorio      = "0.00";
        Carrito.Descgeneral      = "0.00";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Precioconiva      = "0";
        Carrito.FechaExpiracion      = "vaciar";
        Carrito.Unidades      = "0";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritotraspaso.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
         "<tr>"+"<td colspan=9><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });

$(document).ready(function() {
    $('#vaciart').click(function() {
    $("#traspasoproductos")[0].reset();
    $("#carrito tbody").html("");
    var nuevaFila =
    "<tr>"+"<td colspan=9><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
    $(nuevaFila).appendTo("#carrito tbody");
   });
});


    $("#carrito tbody").on('keydown', 'input', function(e) {
        var element = $(this);
        var pvalue = element.val();
        var code = e.charCode || e.keyCode;
        var avalue = String.fromCharCode(code);
        var action = element.siblings('button').first().attr('onclick');
        var params;
        if (code !== 17 && /[^\d]/ig.test(avalue)) {
            e.preventDefault();
            return;
        }
        if (element.attr('data-proc') == '1') {
            return true;
        }
        element.attr('data-proc', '1');
        params = action.match(/\'([^\']+)\'/g).map(function(v) {
            return v.replace(/\'/g, '');
        });
        setTimeout(function() {
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
                    params[16],
                    params[17],
                    '='
                );
                element.attr('data-proc', '0');
            }
        }, 500);
    });
});

function LimpiarTexto() {
    $("#busquedaproductot").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codpresentacion").val("");
    $("#principioactivo").val("");
    $("#descripcion").val("");
    $("#codmedida").val("");
    $("#unidades").val("");
    $("#preciocompra").val("");
    $("#precioventacaja").val("");
    $("#precioventaunidad").val("");
    $("#stocktotal").val("");
    $("#ivaproducto").val("");
    $("#descproducto").val("0.00");
    $("#fechaexpiracion").val("");
    $("#desclaboratorio").val("0.00");
    $("#precioconiva").val("");
    $("#cantidad").val("");
    $("#cantidad2").val("0");
}


function addItem(codigo, cantidad, producto, presentacion, principioactivo, descripcion, tipo, cantidad2, precio, precio2, precio3, descproducto, desclaboratorio, descgeneral, ivaproducto, precioconiva, fechaexpiracion, unidades, opCantidad) {
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
    Carrito.Descproducto = descproducto;
    Carrito.Desclaboratorio = desclaboratorio;
    Carrito.Descgeneral = descgeneral;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Precioconiva      = precioconiva;
    Carrito.FechaExpiracion      = fechaexpiracion;
    Carrito.Unidades      = unidades;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritotraspaso.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
                        var TotalDescuento = 0;
                        var TotalDescuento2 = 0;
                        var TotalBonificacion = 0;
                        var TotalBonificacion2 = 0;
                        var Subtotal = 0;
                        var Impuestos = 0;
                        var SubtotalTarifaNo = 0;
                        var SubtotalTarifaSi = 0;

                        var contador = 0;

                        $.each(data, function(i, item) {
                            var cantsincero = item.cantidad;
                            cantsincero = parseInt(cantsincero);
                            if (cantsincero != 0) {
                                contador = contador + 1;


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
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.unidades + "', " +
                        "'-'" +
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
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.unidades + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'><abbr title='" + item.principioactivo + " - " + item.descripcion + "'>" + item.producto + "</abbr><input type='hidden' value='" + item.txtCodigo + "'><input type='hidden' value='" + item.presentacion + "'></div></td>" +
                        "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.descproducto + "'><input type='hidden' value='" + item.descripcion + "'></div></td>" +
                        "<td><div align='center'>" + item.descproducto + "<sup>%</sup><input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.tipo + "'></div></td>" +
                        "<td><div align='center'>" + item.precio + "<input type='hidden' value='" + item.cantidad2 + "'></div></td>" +
                        "<td><div align='center'>" + item.precio2 + "<input type='hidden' value='" + item.precio + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                        "<td><div align='center'>" + item.precio3 + "<input type='hidden' value='" + item.unidades + "'></div></td>" +
                        "<td><div align='center'>" + item.fechaexpiracion + "<input type='hidden' value='" + item.precioconiva + "'></div></td>" +
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
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.unidades + "', " +
                        "'='" +
                        ')"' +
                        ' type="button"><span class="fa fa-trash"></span></button>' +
                                    "</div></td>" +
                                    "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");

                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
            "<tr>"+"<td colspan=9><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#traspasoproductos")[0].reset();

            }
            $("#busquedaproductot").focus();
            LimpiarTexto();
        },
        "json"
    );
    return false;
}