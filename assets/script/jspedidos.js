/*function DoAction(codproducto, producto, principioactivo, descripcion, presentacion, codcategoria) {
    addItem(codproducto, 1, producto, principioactivo, descripcion, presentacion, codcategoria, '+=');
}*/

function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

            $('#AgregaP').click(function() {
                AgregaPedido();
            });

            $('.agregap').keypress(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                  AgregaPedido();
                e.preventDefault();
                return false;
             }
          });

      function AgregaPedido () {

            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var princ = $('input#principioactivo').val();
            var descrip = $('input#descripcion').val();
            var pres = $('select#codpresentacion').val();
            var cantp = $('input#cantidad').val();
            var tip = $('select#codmedida').val();
            var er_num = /^([0-9])*[.]?[0-9]*$/;
            cantp = parseInt(cantp);
            //exist = parseInt(exist);
            cantp = cantp;

            if (code == "") {
                $("#codproducto").focus();
                $("#codproducto").css('border-color', '#f0ad4e');
                alert("INGRESE CODIGO DE PRODUCTO");
                return false;

            } else if (prod == "") {
                $("#producto").focus();
                $("#producto").css('border-color', '#f0ad4e');
                alert("INGRESE NOMBRE DE PRODUCTO");
                return false;

            } else if (princ == "") {
                $("#principioactivo").focus();
                $("#principioactivo").css('border-color', '#f0ad4e');
                alert("INGRESE PRINCIPIO ACTIVO DE PRODUCTO");
                return false;

            } else if (descrip == "") {
                $("#descripcion").focus();
                $("#descripcion").css('border-color', '#f0ad4e');
                alert("INGRESE DESCRIPCION DE PRODUCTO");
                return false;

            } else if (pres == "") {
                $("#codpresentacion").focus();
                $("#codpresentacion").css('border-color', '#f0ad4e');
                alert("SELECCIONE PRESENTACION DE PRODUCTO");
                return false;

            } else if (tip == "") {
                $("#codmedida").focus();
                $("#codmedida").css('border-color', '#f0ad4e');
                alert("SELECCIONE UNIDAD DE MEDIDA DE PRODUCTO");
                return false;

            } else if ($('#cantidad').val() == "") {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                alert("INGRESE CANTIDAD DE PEDIDO");
                return false;

            } else if (isNaN($('#cantidad').val())) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                alert("INGRESE SOLO NUMEROS PARA CANTIDAD");
                return false;

            } else {

                var Carrito = new Object();
                Carrito.Codigo = $('input#codproducto').val();
                Carrito.Producto = $('input#producto').val();
                Carrito.Presentacion = $('select#codpresentacion').val();
                Carrito.Presentacion2 = $('input#presentacion').val();
                Carrito.Principioactivo = $('input#principioactivo').val();
                Carrito.Descripcion = $('input#descripcion').val();
                Carrito.Tipo = $('select#codmedida').val();
                Carrito.Medida = $('input#medida').val();
                Carrito.Laboratorio = $('select#codlaboratorio').val();
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritopedidos.php', {
                        MiCarrito: DatosJson
                    },
                    function(data, textStatus) {
                        $("#carrito tbody").html("");
                        var contador = 0;

                        $.each(data, function(i, item) {
                            var cantsincero = item.cantidad;
                            cantsincero = parseInt(cantsincero);
                            if (cantsincero != 0) {
                                contador = contador + 1;

                var nuevaFila =
                    "<tr>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.presentacion2 + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.medida + "', " +
                        "'" + item.laboratorio + "', " +
                        "'-'" +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' style='width:25px;height:24px;border:#FF0000;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.presentacion2 + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.medida + "', " +
                        "'" + item.laboratorio + "', " +
                        "'+'" +
                        ')"' +
                       " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'>" + item.txtCodigo + "<input type='hidden' value='" + item.tipo + "'><input type='hidden' value='" + item.descripcion + "'></div></td>" +
                        "<td><div align='center'>" + item.producto + " - " + item.presentacion2 + " - " + item.medida + "<input type='hidden' value='" + item.presentacion + "'></div></td>" +
                        "<td><div align='center'>" + item.principioactivo + "<input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.laboratorio + "'></div></td>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;color:#fff;" ' +
                        'onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.presentacion2 + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.medida + "', " +
                        "'" + item.laboratorio + "', " +
                        "'='" +
                        ')"' +
                        ' type="button"><span class="fa fa-trash"></span></button>' +
                                    "</div></td>" +
                                    "</tr>";
                                $(nuevaFila).appendTo("#carrito tbody");

                            }

                        });


                        LimpiarTexto();
                    },
                    "json"
                );
                return false;
        }
    }

    $("#vaciarp").click(function() {
        var Carrito = new Object();
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Presentacion2 = "vaciar";
        Carrito.Principioactivo = "vaciar";
        Carrito.Descripcion = "vaciar";
        Carrito.Tipo = "vaciar";
        Carrito.Medida = "vaciar";
        Carrito.Laboratorio = "vaciar";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritopedidos.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
         "<tr>"+"<td colspan=5><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });

$(document).ready(function() {
    $('#vaciarp').click(function() {
    $("#carrito tbody").html("");
    var nuevaFila =
    "<tr>"+"<td colspan=7><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
    $(nuevaFila).appendTo("#carrito tbody");
    $("#pedidos")[0].reset();
   });
});

    $("#carrito tbody").on('keydown', 'input', function(e) {
        var element = $(this);
        var pvalue = element.val();
        var code = e.charCode || e.keyCode;
        var avalue = String.fromCharCode(code);
        var action = element.siblings('button').first().attr('onclick');
        var params;
        if (code !== 9 && /[^\d]/ig.test(avalue)) {
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
                    '='
                );
                element.attr('data-proc', '0');
            }
        }, 500);
    });
});

//FUNCION LIMPIAR INPUT
function LimpiarTexto() {
    $("#busquedaproductoc").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codpresentacion").val("");
    $("#presentacion").val("");
    $("#principioactivo").val("");
    $("#descripcion").val("");
    $("#codmedida").val("");
    $("#medida").val("");
    $("#codlaboratorio").val("");
    $("#cantidad").val("1");
}

// FUNCION CARGA PRESENTACION
function CargaPresentacion(codpresentacion){

var dataString = 'CargaPresentacionInput=si&codpresentacion='+btoa(codpresentacion);
$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#cargainputpresentacion').empty();
                $('#cargainputpresentacion').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION CARGA UNIDAD DE MEDIDA
function CargaMedida(codmedida){

var dataString = 'CargaMedidaInput=si&codmedida='+btoa(codmedida);
$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#cargainputmedida').empty();
                $('#cargainputmedida').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

function addItem(codigo, cantidad, producto, presentacion, presentacion2, principioactivo, descripcion, tipo, medida, laboratorio, opCantidad) {
    var Carrito = new Object();
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Presentacion = presentacion;
    Carrito.Presentacion2 = presentacion2;
    Carrito.Principioactivo = principioactivo;
    Carrito.Descripcion = descripcion;
    Carrito.Tipo = tipo;
    Carrito.Medida = medida;
    Carrito.Laboratorio = laboratorio;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritopedidos.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var contador = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseInt(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;


                   var nuevaFila =
                    "<tr>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.presentacion2 + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.medida + "', " +
                        "'" + item.laboratorio + "', " +
                        "'-'" +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' style='width:25px;height:24px;border:#FF0000;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.presentacion2 + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.medida + "', " +
                        "'" + item.laboratorio + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'>" + item.txtCodigo + "<input type='hidden' value='" + item.tipo + "'><input type='hidden' value='" + item.descripcion + "'></div></td>" +
                        "<td><div align='center'>" + item.producto + " - " + item.presentacion2 + " - " + item.medida + "<input type='hidden' value='" + item.presentacion + "'></div></td>" +
                        "<td><div align='center'>" + item.principioactivo + "<input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.laboratorio + "'></div></td>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;color:#fff;" ' +
                        'onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.presentacion2 + "'," +
                        "'" + item.principioactivo + "'," +
                        "'" + item.descripcion + "'," +
                        "'" + item.tipo + "', " +
                        "'" + item.medida + "', " +
                        "'" + item.laboratorio + "', " +
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
            "<tr>"+"<td colspan=5><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#pedidos")[0].reset();

            }
            LimpiarTexto();
        },
        "json"
    );
    return false;
}