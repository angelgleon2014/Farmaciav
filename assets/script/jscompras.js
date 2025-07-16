/*function DoAction(codproducto, producto, principioactivo, descripcion, presentacion, codcategoria) {
    addItem(codproducto, 1, producto, principioactivo, descripcion, presentacion, codcategoria, '+=');
}*/

/*$(window).bind( 'beforeunload', function() {
    return false;
} );*/

function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}


$(document).ready(function() {

            $('#AgregaC').click(function() {
                console.log("AGREGANDO");
                AgregaCompra();
            });

            $('.agregac').keypress(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13' && !$("#busquedaproductoc").is(":focus")) {
                  AgregaCompra();
                e.preventDefault();
                return false;
             }
          });

    /*$(".agregac").keypress(function(e){

        if (e.charCode == 13 || e.keyCode == 13) { //ENTER*/

      function AgregaCompra () {

            var tipoProd = "";

            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var princ = $('input#principioactivo').val();
            var descrip = $('input#descripcion').val();
            var pres = $('select#codpresentacion').val();
            var cantp = $('input#cantidad').val();
            var unid = $('input#unidades').val();
            var prec = $('input#preciocompra').val();
            var prec2 = $('input#precioventacaja').val();
            var prec3 = $('input#precioventaunidad').val();
            var descuenfact = $('input#descfactura').val();
            var descuen = $('input#descproducto').val();
            var ivgprod = $('select#ivaproducto').val();
            var tip = $('select#codmedida').val();
            var lote = $('input#lote').val();
            var blisterunidad = $('input#blisterunidad').val();
            var er_num = /^([0-9])*[.]?[0-9]*$/;

            // nuevos campos
            var precioventablisterdesc = $('#precioventablisterdesc').val();
            var precioventacajadesc = $('#precioventacajadesc').val();
            var precioventaunidaddesc = $('#precioventaunidaddesc').val();

            var is_shift = $('#is_shift').val();
            
            tipoProd = $('#tipo-select').find(":selected").val();            
            cantp = parseInt(cantp);
            //exist = parseInt(exist);
            cantp = cantp;
            if(!window.terminoDeBuscar) return false;
            else if (code == "") {
                $("#codproducto").focus();
                $("#codproducto").css('border-color', '#f0ad4e');
                alert("INGRESE CODIGO DE PRODUCTO");
                return false;

           } else if (prod == "") {
                $("#producto").focus();
                $("#producto").css('border-color', '#f0ad4e');
                alert("INGRESE NOMBRE DE PRODUCTO");
                return false;

            }  else if (descrip == "") {
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
                alert("SELECCIONE UNIDAD MEDIDA DE PRODUCTO");
                return false;

            } else if (lote == "") {
                $("#lote").focus();
                $("#lote").css('border-color', '#f0ad4e');
                alert("INGRESE LOTE DE PRODUCTO");
                return false;
                
            } else if(prec=="" || prec=="0.00"){
                $("#preciocompra").focus();
                $('#preciocompra').css('border-color','#f0ad4e');
                alert("INGRESE PRECIO DE COMPRA VALIDO PARA PRODUCTO");
                return false;
                
            } else if(!er_num.test($('#preciocompra').val())){
                $("#preciocompra").focus();
                $('#preciocompra').css('border-color','#f0ad4e');
                $("#preciocompra").val("");
                alert("INGRESE SOLO NUMEROS POSITIVOS EN PRECIO COMPRA");
                return false;
                
            } else if(prec2=="" || prec2=="0.00"){
                $("#precioventacaja").focus();
                $('#precioventacaja').css('border-color','#f0ad4e');
                alert("INGRESE PRECIO VENTA DE CAJA DE PRODUCTO VALIDO");
                return false;
                
            } else if(!er_num.test($('#precioventacaja').val())){
                $("#precioventacaja").focus();
                $('#precioventacaja').css('border-color','#f0ad4e');
                $("#precioventacaja").val("");
                alert("INGRESE SOLO NUMEROS POSITIVOS EN PRECIO VENTA DE CAJA");
                return false;

            } else if (parseFloat(prec) > parseFloat(prec2)) {
                
                $("#precioventacaja").focus();
                $("#preciocompra").focus();
                $('#precioventacaja').css('border-color','#f0ad4e');
                $('#preciocompra').css('border-color','#f0ad4e');
                alert('EL PRECIO DE COMPRA NO PUEDE SER MAYOR AL PRECIO VENTA DE CAJA');
                return false;
                
            } else if(prec3=="" || prec3=="0.00"){
                $("#precioventaunidad").focus();
                $('#precioventaunidad').css('border-color','#f0ad4e');
                alert("INGRESE PRECIO VENTA DE UNIDAD DE PRODUCTO VALIDO");
                return false;
                
            } else if(!er_num.test($('#precioventaunidad').val())){
                $("#precioventaunidad").focus();
                $('#precioventaunidad').css('border-color','#f0ad4e');
                $("#precioventaunidad").val("");
                alert("INGRESE SOLO NUMEROS POSITIVOS EN PRECIO VENTA DE UNIDAD");
                return false;

            } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                alert("INGRESE UNA CANTIDAD VALIDA PARA COMPRA");
                return false;

            } else if (isNaN($('#cantidad').val())) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                alert("INGRESE SOLO NUMEROS EN CANTIDAD DE COMPRA");
                return false;

            } else if(unid=="" || unid=="0"){
                $("#unidades").focus();
                $('#unidades').css('border-color','#f0ad4e');
                alert("INGRESE UNIDADES VALIDA");
                return false;

            }  else if(ivgprod==""){
                $("#ivaproducto").focus();
                $('#ivaproducto').css('border-color','#f0ad4e');
                alert("SELECCIONE SI TIENE IVA EL PRODUCTO");
                return false;

            } else {
                var precioventablister = $("#preciocomprablister").val();
                var precioventacaja = $("#preciocompra").val();
                var precioPrev = 0;
                var totalPrecio = 0;


                if (tipoProd === 'unidad') { 
                    precioPrev = $('input#preciocompraunidad').val();
                } else if (tipoProd === 'blister') {
                    precioPrev = precioventablister;
                } else if(tipoProd === 'caja') {
                    precioPrev = precioventacaja;
                }
                console.log(precioPrev);
                    // ES UN PRODUCTO DE REGALO? SI SELECCIONAS SI = 1 
                    // EL PRECIO DE LA VENTA DE ESE PRODUCTO SE DEJA EN 0
                    if(is_shift == '1')
                    {
                        totalPrecio = 0;
                    }else{
                        totalPrecio = precioPrev;
                    }

              

                var Carrito = new Object();
                Carrito.Codigo = $('input#codproducto').val();
                Carrito.Producto = $('input#producto').val();
                Carrito.Presentacion = $('select#codpresentacion').val();
                Carrito.Principioactivo = $('input#principioactivo').val();
                Carrito.Descripcion = $('input#descripcion').val();
                Carrito.Tipo = $('select#codmedida').val();
                Carrito.Lote = $('input#lote').val();
                Carrito.Cantidad2 = $('input#cantidad2').val();
                Carrito.Unidades = $('input#unidades').val();
                Carrito.Precio = $('input#preciocompra').val();
                Carrito.Precio2 = $('input#precioventacaja').val();
                //Carrito.Precio3      = totalPrecio;
                Carrito.Precio3 = $('input#precioventaunidad').val();
                Carrito.Precio4 = $('input#preciocompraunidad').val();
                Carrito.DescproductoFact      = $('input#descfactura').val();
                Carrito.Descproducto      = $('input#descproducto').val();
                Carrito.Ivaproducto = $('select#ivaproducto').val();
                Carrito.Fechaelaboracion = $('input#fechaelaboracion').val();
                Carrito.Fechaexpiracion = $('input#fechaexpiracion').val();
                Carrito.Codigobarra = $('input#codigobarra').val();
                Carrito.Codlaboratorio = $('select#codlaboratorio').val();
                Carrito.BlisterUnidad = $('input#blisterunidad').val(); 
                Carrito.Precioconiva = totalPrecio;
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.tipoProd = tipoProd;
                Carrito.precioventablisterdesc = $('input#precioventablisterdesc').val();
                Carrito.precioventacajadesc = $('input#precioventacajadesc').val();
                Carrito.precioventaunidaddesc = $('input#precioventaunidaddesc').val();

                Carrito.is_shift = $('#is_shift').val();

                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritocompras.php', {
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
                            console.log(item);
                            var cantsincero = item.cantidad;
                            cantsincero = parseInt(cantsincero);
                            if (cantsincero != 0) {
                                contador = contador + 1;

//##################################################################################//
//cantidad de blister
var ValorTotal = 0;
var BlisterUnidad = item.blisterunidad;               
//CALCULO DEL VALOR TOTAL
//var ValorTotal= parseFloat(item.precio3) * parseFloat(item.cantidad);
ValorTotal = parseFloat(item.precioconiva) * parseFloat(item.cantidad);
//var PrecioUnitario = parseFloat(item.precio3) - parseFloat(DescuentoGeneral);

//CALCULO DEL TOTAL DEL DESCUENTO %
var Descuento = ValorTotal * item.descproductofact / 100;
TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

//CALCULO DEL TOTAL DEL BONIFICACION
var Bonificacion= parseFloat(item.precio) * parseFloat(item.cantidad2);
TotalBonificacion = parseFloat(TotalBonificacion) + parseFloat(Bonificacion);

//CALCULO DE VALOR NETO
var Neto = parseFloat(ValorTotal) - parseFloat(Descuento);
var ValorNeto = parseFloat(Neto) + parseFloat(Bonificacion);

//##################################################################################//

//CALCULO DEL VALOR TOTAL
var ValorTotal2= parseFloat(item.precioconiva) * parseFloat(item.cantidad);

//CALCULO DEL TOTAL DEL DESCUENTO %
var Descuento2 = ValorTotal2 * item.descproductofact / 100;
TotalDescuento2 = parseFloat(TotalDescuento2) + parseFloat(Descuento2);

//CALCULO DEL TOTAL DEL BONIFICACION
var Bonificacion2= parseFloat(item.precioconiva) * parseFloat(item.cantidad2);
TotalBonificacion2 = parseFloat(TotalBonificacion2) + parseFloat(Bonificacion2);

//CALCULO DE VALOR NETO
var Neto2 = parseFloat(ValorTotal2) - parseFloat(Descuento2);
var ValorNeto2 = parseFloat(Neto2) + parseFloat(Bonificacion2);

//##################################################################################//


//CALCULO DEL SUBTOTAL GENERAL
var Subto = parseFloat(ValorNeto) + parseFloat(Descuento);
Subtotal = parseFloat(Subtotal) + parseFloat(Subto);

//CALCULO DEL TOTAL IMPUESTOS
Impuestos = parseFloat(Impuestos) + parseFloat(ValorNeto);


//SUBTOTAL TARIFA CERO %
//SubtotalTarifaNo = parseFloat(SubtotalTarifaNo) + parseFloat(ValorNeto);
SubtotalTarifaNo = (item.ivaproducto == "NO" ? parseFloat(SubtotalTarifaNo) + parseFloat(ValorNeto) - parseFloat(Bonificacion) : parseFloat(SubtotalTarifaNo));

//SUBTOTAL TARIFA 12 %
//SubtotalTarifaSi = parseFloat(SubtotalTarifaSi) + parseFloat(ValorNeto2);
SubtotalTarifaSi = (item.ivaproducto == "SI" ? parseFloat(SubtotalTarifaSi) + parseFloat(ValorNeto2) - parseFloat(Bonificacion2) : parseFloat(SubtotalTarifaSi));


//CALCULO GENERAL DE IVA CON BASE IVA * IVA %
var ivg = $('input#iva').val();
ivg2  = ivg/100;
//TotalIvaGeneral = parseFloat(SubtotalTarifaSi) * parseFloat(ivg2.toFixed(2));
TotalIvaGeneral = parseFloat(Subtotal) * parseFloat(ivg2.toFixed(2));;


 //CALCULO DEL TOTAL GENERAL DE FACTURA
resto = parseFloat(TotalDescuento) + parseFloat(TotalBonificacion);
totalresto = parseFloat(Subtotal) - parseFloat(resto);
//TotalGeneral = parseFloat(totalresto) + parseFloat(TotalIvaGeneral);
TotalGeneral = parseFloat(totalresto);

tipoProdStr = item.tipoProd == "unidad" ? "Unidad" : item.tipoProd == "blister" ? "Blister" : "Caja";


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
                        "'" + item.lote + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.unidades + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.codigobarra + "', " +
                        "'" + item.codlaboratorio + "', " +
                        "'" + item.precioconiva + "', " +
                        "'-'" + ", " +
                        "'" + item.tipoProd + "'" +
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
                        "'" + item.lote + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.unidades + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.codigobarra + "', " +
                        "'" + item.codlaboratorio + "', " +
                        "'" + item.precioconiva + "', " +
                        "'+'" + ", " +
                        "'" + item.tipoProd + "'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'><abbr title='" + item.principioactivo + " - " + item.descripcion + "'>" + item.producto + "</abbr><input type='hidden' value='" + item.txtCodigo + "'><input type='hidden' value='" + item.presentacion + "'></div></td>" +
                        "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.descproducto + "'><input type='hidden' value='" + item.descripcion + "'><input type='hidden' value='" + item.codlaboratorio + "'></div></td>" +
                        "<td><div align='center'>" + item.precioconiva + "<input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.tipo + "'><input type='hidden' value='" + item.codigobarra + "'></div></td>" +
                        "<td><div align='center'>" + ValorTotal.toFixed(2) + "<input type='hidden' value='" + item.lote + "'><input type='hidden' value='" + item.cantidad2 + "'></div></td>" +
                        "<td><div align='center'>" + Descuento.toFixed(2) + "<sup>" + item.descproductofact + "%</sup><input type='hidden' value='" + item.unidades + "'><input type='hidden' value='" + item.precio2 + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                        "<td><div align='center'>" + Bonificacion.toFixed(2) + "<sup>" + item.cantidad2 + "</sup><input type='hidden' value='" + item.descproductofact + "'><input type='hidden' value='" + item.fechaelaboracion + "'></div></td>" +
                        "<td><div align='center'>" + ValorNeto.toFixed(2) + "<input type='hidden' value='" + item.precioconiva + "'><input type='hidden' value='" + item.fechaexpiracion + "'></div></td>" +
                        "<td><div align='center'>" + tipoProdStr +"</div></td>" +
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
                        "'" + item.lote + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.unidades + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.codigobarra + "', " +
                        "'" + item.codlaboratorio + "', " +
                        "'" + item.precioconiva + "', " +
                        "'='" + ", " +
                        "'" + item.tipoProd  + "'" +
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

                            }

                        });


                        LimpiarTexto();
                    },
                    "json"
                );
                return false;
            //}
        }
    }

    $("#vaciarc").click(function() {
        var Carrito = new Object();
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Principioactivo = "vaciar";
        Carrito.Descripcion = "vaciar";
        Carrito.Tipo = "vaciar";
        Carrito.Lote = "vaciar";
        Carrito.Cantidad2 = "0";
        Carrito.Unidades = "0";
        Carrito.Precio      = "0";
        Carrito.Precio2      = "0";
        Carrito.Precio3      = "0";
        Carrito.DescproductoFact      = "0.00";
        Carrito.Descproducto      = "0.00";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Fechaelaboracion = "vaciar";
        Carrito.Fechaexpiracion = "vaciar";
        Carrito.Codigobarra = "vaciar";
        Carrito.Codlaboratorio = "vaciar";
        Carrito.Precioconiva      = "0";
        Carrito.Cantidad = "0";
        Carrito.BlisterUnidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritocompras.php', {
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
    $('#vaciarc').click(function() {
    $("#compras")[0].reset();
    $("#carrito tbody").html("");
    var nuevaFila =
    "<tr>"+"<td colspan=9><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
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
   });
});

//FUNCION PARA CARGAR PRECIO CON IVA
$(document).ready(function() {
        $('#ivaproducto').on('change', function() {
        var valor = $("#ivaproducto").val();
        var precio = $("#preciocompra").val();
        var precioiva = $("#precioconiva").val();

       if (valor === "SI" || valor === true) {

           $("#precioconiva").val(precio); 
} else {
           $("#precioconiva").val("0.00"); 
             } 
       });
});


//FUNCION PARA CARGAR PRECIO CON IVA
$(document).ready(function (){
        
        $('#preciocompra').keyup(function (){
            var precio = $('input#preciocompra').val();
            var precioconiva = $("input#precioconiva").val();
            let precioiva = $("#precioconiva").val(precio); 
        });

        $('#preciocompra').change(function() {
             var precioconiva = $("input#precioconiva").val();
             let unidades = $('#unidades').val();
             let total = precioconiva / unidades;
             let precio = $('#preciocompraunidad').val(total);

             let cantidad = $('#blisterunidad').val()
             let totalcompra = $(this).val() / cantidad;

             let preciocomprablister = $('#preciocomprablister').val(totalcompra)

        });
 });


    $("#carrito tbody").on('keydown', 'input', function(e) {
        var element = $(this);
        var pvalue = element.val();
        var code = e.charCode || e.keyCode;
        var avalue = String.fromCharCode(code);
        var action = element.siblings('button').first().attr('onclick');
        var params;
        if (code !== 20 && /[^\d]/ig.test(avalue)) {
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
                    params[18],
                    params[19],
                    params[20],
                    '='
                );
                element.attr('data-proc', '0');
            }
        }, 500);
    });
});

function LimpiarTexto() {
    $("#busquedaproductoc").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codpresentacion").val("");
    $("#principioactivo").val("");
    $("#descripcion").val("");
    $("#codmedida").val("");
    $("#preciocompra").val("");
    $("#precioventaunidad").val("");
    $("#precioventacaja").val("");
    $("#descfactura").val("0.00");
    $("#descproducto").val("0.00");
    $("#ivaproducto").val("");
    $("#lote").val("");
    $("#fechaelaboracion").val("");
    $("#fechaexpiracion").val("");
    $("#codigobarra").val("");
    $("#codlaboratorio").val("");
    $("#precioconiva").val("");
    $("#cantidad").val("0");
    $("#cantidad2").val("0");
    $("#unidades").val("0");

    
    $('#is_shift').val("0");
}

function addItem(codigo, cantidad, producto, presentacion, principioactivo, descripcion, tipo, lote, cantidad2, unidades, precio, precio2, precio3, descproductofact, descproducto, ivaproducto, fechaelaboracion, fechaexpiracion, codigobarra, codlaboratorio, precioconiva, opCantidad,tipoProd, blisterunidad) {
    var Carrito = new Object();
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Presentacion = presentacion;
    Carrito.Principioactivo = principioactivo;
    Carrito.Descripcion = descripcion;
    Carrito.Tipo = tipo;
    Carrito.Lote = lote;
    Carrito.Cantidad2 = cantidad2;
    Carrito.Unidades = unidades;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.Precio3 = precio3;
    Carrito.DescproductoFact = descproductofact;
    Carrito.Descproducto = descproducto;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Fechaelaboracion = fechaelaboracion;
    Carrito.Fechaexpiracion = fechaexpiracion;
    Carrito.Codigobarra = codigobarra;
    Carrito.Codlaboratorio = codlaboratorio;
    Carrito.Precioconiva      = precioconiva;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    Carrito.tipoProd = tipoProd;
    Carrito.BlisterUnidad = blisterunidad;

    console.log(Carrito);

    var DatosJson = JSON.stringify(Carrito);
    $.post('carritocompras.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            console.log("aca")
            console.log(data);
            
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

               
              //CALCULO DEL VALOR TOTAL
var ValorTotal= parseFloat(item.precio) * parseFloat(item.cantidad);

//CALCULO DEL TOTAL DEL DESCUENTO %
var Descuento = ValorTotal * item.descproductofact / 100;
TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

//CALCULO DEL TOTAL DEL BONIFICACION
var Bonificacion= parseFloat(item.precio) * parseFloat(item.cantidad2);
TotalBonificacion = parseFloat(TotalBonificacion) + parseFloat(Bonificacion);

//CALCULO DE VALOR NETO
var Neto = parseFloat(ValorTotal) - parseFloat(Descuento);
var ValorNeto = parseFloat(Neto) + parseFloat(Bonificacion);

//##################################################################################//

//CALCULO DEL VALOR TOTAL
var ValorTotal2= parseFloat(item.precioconiva) * parseFloat(item.cantidad);

//CALCULO DEL TOTAL DEL DESCUENTO %
var Descuento2 = ValorTotal2 * item.descproductofact / 100;
TotalDescuento2 = parseFloat(TotalDescuento2) + parseFloat(Descuento2);

//CALCULO DEL TOTAL DEL BONIFICACION
var Bonificacion2= parseFloat(item.precioconiva) * parseFloat(item.cantidad2);
TotalBonificacion2 = parseFloat(TotalBonificacion2) + parseFloat(Bonificacion2);

//CALCULO DE VALOR NETO
var Neto2 = parseFloat(ValorTotal2) - parseFloat(Descuento2);
var ValorNeto2 = parseFloat(Neto2) + parseFloat(Bonificacion2);

//##################################################################################//


//CALCULO DEL SUBTOTAL GENERAL
var Subto = parseFloat(ValorNeto) + parseFloat(Descuento);
Subtotal = parseFloat(Subtotal) + parseFloat(Subto);

//CALCULO DEL TOTAL IMPUESTOS
Impuestos = parseFloat(Impuestos) + parseFloat(ValorNeto);


//SUBTOTAL TARIFA CERO %
//SubtotalTarifaNo = parseFloat(SubtotalTarifaNo) + parseFloat(ValorNeto);
SubtotalTarifaNo = (item.ivaproducto == "NO" ? parseFloat(SubtotalTarifaNo) + parseFloat(ValorNeto) - parseFloat(Bonificacion) : parseFloat(SubtotalTarifaNo));

//SUBTOTAL TARIFA 12 %
//SubtotalTarifaSi = parseFloat(SubtotalTarifaSi) + parseFloat(ValorNeto2);
SubtotalTarifaSi = (item.ivaproducto == "SI" ? parseFloat(SubtotalTarifaSi) + parseFloat(ValorNeto2) - parseFloat(Bonificacion2) : parseFloat(SubtotalTarifaSi));


//CALCULO GENERAL DE IVA CON BASE IVA * IVA %
var ivg = $('input#iva').val();
ivg2  = ivg/100;
//TotalIvaGeneral = parseFloat(SubtotalTarifaSi) * parseFloat(ivg2.toFixed(2));
TotalIvaGeneral = parseFloat(SubtotalTarifaSi);

 //CALCULO DEL TOTAL GENERAL DE FACTURA
resto = parseFloat(TotalDescuento) + parseFloat(TotalBonificacion);
totalresto = parseFloat(Subtotal) - parseFloat(resto);
TotalGeneral = parseFloat(totalresto) + parseFloat(TotalIvaGeneral);

tipoProdStr = item.tipoProd == 1 ? "Unidad" : item.tipoProd == 2 ? "Blister" : "Caja";

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
                        "'" + item.lote + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.unidades + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.codigobarra + "', " +
                        "'" + item.codlaboratorio + "', " +
                        "'" + item.precioconiva + "', " +
                        "'-'" + ", " +
                        "'" + item.tipoProd + "'" +
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
                        "'" + item.lote + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.unidades + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.codigobarra + "', " +
                        "'" + item.codlaboratorio + "', " +
                        "'" + item.precioconiva + "', " +
                        "'+'" + ", " +
                        "'" + item.tipoProd + "'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'><abbr title='" + item.principioactivo + " - " + item.descripcion + "'>" + item.producto + "</abbr><input type='hidden' value='" + item.txtCodigo + "'><input type='hidden' value='" + item.presentacion + "'></div></td>" +
                        "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.descproducto + "'><input type='hidden' value='" + item.descripcion + "'><input type='hidden' value='" + item.codlaboratorio + "'></div></td>" +
                        "<td><div align='center'>" + item.precio + "<input type='hidden' value='" + item.principioactivo + "'><input type='hidden' value='" + item.tipo + "'><input type='hidden' value='" + item.codigobarra + "'></div></td>" +
                        "<td><div align='center'>" + ValorTotal.toFixed(2) + "<input type='hidden' value='" + item.lote + "'><input type='hidden' value='" + item.cantidad2 + "'></div></td>" +
                        "<td><div align='center'>" + Descuento.toFixed(2) + "<sup>" + item.descproductofact + "%</sup><input type='hidden' value='" + item.unidades + "'><input type='hidden' value='" + item.precio2 + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                        "<td><div align='center'>" + Bonificacion.toFixed(2) + "<sup>" + item.cantidad2 + "</sup><input type='hidden' value='" + item.descproductofact + "'><input type='hidden' value='" + item.fechaelaboracion + "'></div></td>" +
                        "<td><div align='center'>" + ValorNeto.toFixed(2) + "<input type='hidden' value='" + item.precioconiva + "'><input type='hidden' value='" + item.fechaexpiracion + "'></div></td>" +
                        "<td><div align='center'>" + tipoProdStr +"</div></td>" +
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
                        "'" + item.lote + "', " +
                        "'" + item.cantidad2 + "', " +
                        "'" + item.unidades + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.codigobarra + "', " +
                        "'" + item.codlaboratorio + "', " +
                        "'" + item.precioconiva + "', " +
                        "'='" + ", " +
                        "'" + item.tipoProd  + "'" +
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

                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
            "<tr>"+"<td colspan=9><center><label>No hay Productos agregados</label></center></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#compras")[0].reset();
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

            }
            LimpiarTexto();
        },
        "json"
    );
    return false;
}