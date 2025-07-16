// FUNCION PARA PERMITIR CAMPOS NUMEROS
function NumberFormat(num, numDec, decSep, thousandSep) {
  var arg;
  var Dec;
  Dec = Math.pow(10, numDec);
  if (typeof (num) == 'undefined') return;
  if (typeof (decSep) == 'undefined') decSep = ',';
  if (typeof (thousandSep) == 'undefined') thousandSep = '.';
  if (thousandSep == '.')
    arg = /./g;
  else
    if (thousandSep == ',') arg = /,/g;
  if (typeof (arg) != 'undefined') num = num.toString().replace(arg, '');
  num = num.toString().replace(/,/g, '.');
  if (isNaN(num)) num = "0";
  sign = (num == (num = Math.abs(num)));
  num = Math.floor(num * Dec + 0.50000000001);
  cents = num % Dec;
  num = Math.floor(num / Dec).toString();
  if (cents < (Dec / 10)) cents = "0" + cents;
  for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
    num = num.substring(0, num.length - (4 * i + 3)) + thousandSep + num.substring(num.length - (4 * i + 3));
  if (Dec == 1)
    return (((sign) ? '' : '-') + num);
  else
    return (((sign) ? '' : '-') + num + decSep + cents);
}

function EvaluateText(cadena, obj) {
  opc = false;
  if (cadena == "%d")
    if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
  if (cadena == "%f") {
    if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
    if (obj.value.search("[.*]") == -1 && obj.value.length != 0)
      if (event.keyCode == 46)
        opc = true;
  }
  if (opc == false)
    event.returnValue = false;
}

$(document).ready(function () {
  $(".number").keydown(function (event) {
    if (event.shiftKey) {
      event.preventDefault();
    }

    if (event.keyCode == 46 || event.keyCode == 8) {
    }
    else {
      if (event.keyCode < 95) {
        if (event.keyCode < 48 || event.keyCode > 57) {
          event.preventDefault();
        }
      }
      else {
        if (event.keyCode < 96 || event.keyCode > 105) {
          event.preventDefault();
        }
      }
    }
  });
});


function getTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  var num = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
  var mt = "AM";

  // Pongo el formato 12 horas
  if (h > 12) {
    mt = "PM";
    h = h - 12;
  }
  if (h == 0) h = 12;
  // Pongo minutos y segundos con dos digitos
  //if (m <= 9) m = "0" + m;
  //if (s <= 9) s = "0" + s;

  // add a zero in front of numbers<10
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('fecharegistro').value = today.getDate() + "-" + num[today.getMonth()] + "-" + today.getFullYear() + " " + h + ":" + m + ":" + s;
  $('#result3').html(today.getDate() + "-" + num[today.getMonth()] + "-" + today.getFullYear() + " " + h + ":" + m + ":" + s);
  t = setTimeout(function () { getTime() }, 500);
}

function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}

function muestraReloj() {
  // Compruebo si se puede ejecutar el script en el navegador del usuario
  if (!document.layers && !document.all && !document.getElementById) return;
  // Obtengo la hora actual y la divido en sus partes
  var num = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
  var fechacompleta = new Date();
  var horas = fechacompleta.getHours();
  var minutos = fechacompleta.getMinutes();
  var segundos = fechacompleta.getSeconds();

  var day = fechacompleta.getDate();
  var mes = fechacompleta.getMonth();
  var year = fechacompleta.getFullYear();

  var mt = "AM";

  // Pongo el formato 12 horas
  if (horas > 12) {
    mt = "PM";
    horas = horas - 12;
  }
  if (horas == 0) horas = 12;
  // Pongo minutos y segundos con dos digitos
  if (minutos <= 9) minutos = "0" + minutos;
  if (segundos <= 9) segundos = "0" + segundos;
  // En la variable 'cadenareloj' puedes cambiar los colores y el tipo de fuente
  //cadenareloj = "<font size='-1' face='verdana'>" + horas + ":" + minutos + ":" + segundos + " " + mt + "</font>";
  cadenareloj = "<i class='fa fa-calendar'></i> " + day + "-" + num[mes] + "-" + year + "     " + horas + ":" + minutos + ":" + segundos + " " + mt;

  // Escribo el reloj de una manera u otra, segun el navegador del usuario
  if (document.layers) {
    document.layers.spanreloj.document.write(cadenareloj);
    document.layers.spanreloj.document.close();
  }
  else if (document.all) spanreloj.innerHTML = cadenareloj;
  else if (document.getElementById) document.getElementById("spanreloj").innerHTML = cadenareloj;
  // Ejecuto la funcion con un intervalo de un segundo
  setTimeout("muestraReloj()", 1000);
}


//////// FUNCIONES PARA MOSTRAR MENSAJES DE ALERTA DE ACTUALIZAR, ELIMINAR Y PAGAR REGISTROS
function actualizar(url) {
  if (confirm('ESTA SEGURO DE ACTUALIZAR ESTE REGISTRO ?')) {
    window.location = url;
  }
}

function eliminar(url) {
  if (confirm('ESTA SEGURO DE ELIMINAR ESTE REGISTRO ?')) {
    window.location = url;
  }
}




function actualizarp(url) {
  if (confirm('ESTA SEGURO DE ACTUALIZAR ESTE PEDIDO ?')) {
    window.location = url;
  }
}

function eliminarp(url) {
  if (confirm('ESTA SEGURO DE ELIMINAR ESTE PEDIDO ?')) {
    window.location = url;
  }
}






function actualizardp(url) {
  if (confirm('ESTA SEGURO DE ACTUALIZAR ESTE DETALLE DE PEDIDO ?')) {
    window.location = url;
  }
}

function eliminardp(url) {
  if (confirm('ESTA SEGURO DE ELIMINAR ESTE DETALLE DE PEDIDO ?')) {
    window.location = url;
  }
}


function actualizarc(url) {
  if (confirm('ESTA SEGURO DE ACTUALIZAR ESTE DETALLE DE COMPRA ?')) {
    window.location = url;
  }
}

function eliminarc(url) {
  if (confirm('ESTA SEGURO DE ELIMINAR ESTE DETALLE DE COMPRA ?')) {
    window.location = url;
  }
}


function actualizarv(url) {
  if (confirm('ESTA SEGURO DE ACTUALIZAR ESTE DETALLE DE VENTA ?')) {
    window.location = url;
  }
}

function eliminarv(url) {
  if (confirm('ESTA SEGURO DE ELIMINAR ESTE DETALLE DE VENTA ?')) {
    window.location = url;
  }
}

function VerificaMovimiento() {
  alert('ESTE MOVIMIENTO EN CAJA NO PUEDE ELIMINARSE,\nLA FECHA DE MOVIMIENTO ES DIFERENTE A LA ACTUAL ');
}

function VerificaVenta() {
  alert('ESTE DETALLE DE VENTA NO PUEDE ELIMINARSE,\nLA FECHA DE VENTA ES DIFERENTE A LA ACTUAL ');
}



function pagar(url) {
  if (confirm('ESTA SEGURO DE REALIZAR EL PAGO DE FACTURA DE COMPRA ?')) {
    window.location = url;
  }
}

function cerrarcaja(url) {
  if (confirm('ESTA SEGURO DE REALIZAR EL CIERRE DE ESTA CAJA ?')) {
    window.location = url;
  }
}

function entregas(url) {
  if (confirm('ESTA SEGURO DE REALIZAR LA ENTREGA DE ESTE PEDIDO ?')) {
    window.location = url;
  }
}


$(document).ready(function () {
  $(".precio").keydown(function (event) {
    if (event.shiftKey) {
      event.preventDefault();
    }

    if (event.keyCode == 46 || event.keyCode == 8) {
    }
    else {
      if (event.keyCode < 95) {
        if (event.keyCode < 48 || event.keyCode > 57) {
          event.preventDefault();
        }
      }
      else {
        if (event.keyCode < 96 || event.keyCode > 105) {
          event.preventDefault();
        }
      }
    }
  });
});


//FUNCIONES PARA ACTIVAR-DESACTIVAR CAMPO
function Cambio(nivel) {

  $("#nivel").on("change", function () {

    var valor = $("#nivel").val();

    if (valor == "ADMINISTRADOR(A) SUCURSAL" || valor == "BODEGA" || valor == "CAJERO(A)" || valor === true) {

      $("#codsucursal").attr('disabled', false);

    } else {

      // deshabilitamos
      $("#codsucursal").attr('disabled', true);
    }
  });
}


////FUNCION MUESTRA CAMPO PARA NUEVOS PRODUCTOS
function mostrar() {

  var botonAccion = document.getElementById('boton');
  var div = document.getElementById('nuevoproducto');


  if (div.style.display === 'block') {

    div.style.display = "none";

    //Actualizamos el nombre del botón

    botonAccion.value = "SI";

  } else {

    div.style.display = "block";

    //Actualizamos el nombre del botón

    botonAccion.value = "NO";

  }
}

//FUNCION PARA CALCULAR PRECIO VENTA UNIDAD

$(document).ready(function () {
  $('.calculounidad').keyup(function () {

    var preciocaja = $('input#precioventacaja').val();
    var unidad = $('input#unidades').val();

    //REALIZO EL CALCULO
    preciounidad = preciocaja / unidad;
    $("#precioventaunidad").val((unidad == "0") ? "0.00" : preciounidad.toFixed(2));
  });
});

//FUNCION PARA CALCULAR PRECIO VENTA UNIDAD

$(document).ready(function () {
  $('.calculostock').keyup(function () {

    calcularCantidades(1);

  });
});



//FUNCION PARA CALCULAR PRECIO VENTA UNIDAD
$(document).ready(function () {
  $('.calculounidadnew').keyup(function () {

    var preciocaja = $('input#precioventacaja').val();
    var unidad = $('input#unidades').val();
    var preciocompra = $('#preciocompra').val();
    var unidadesblister2 = $('#unidadesblister').val();


    var tot = parseFloat(unidad) / parseFloat(unidadesblister2);


    $('#stockblister').val(tot.toFixed(2));

    //preciocompraunidad

    // stockblister2 
    // precio compra caja / unidades
    var total_precio = parseFloat(preciocompra) / unidad;
    $('#preciocompraunidad').val(total_precio.toFixed(2));


    //REALIZO EL CALCULO
    preciounidad = preciocaja / unidad;
    // $("#precioventaunidad2").val((unidad == "0") ? "0.00" : preciounidad.toFixed(2));

    var stockcajas = $('input#stockcajas').val();
    var unidades = $('input#unidades').val();
    var stockunidad = $('input#stockunidad').val();
    var stockblister = $('input#blistercaja').val();
    var stkb = $('#stockblister').val();
    var unidadblister = $('input#unidadesblister').val();

    var total_precio_compra_blister = parseFloat(preciocompra) / parseFloat(stkb);

    console.log(stkb);
    console.log(preciocompra);
    console.log(total_precio_compra_blister);

    $('input#preciocomprablister').val(total_precio_compra_blister.toFixed(2));

    //REALIZO EL CALCULO
    var calculo = parseFloat(stockcajas) * parseFloat(unidades);
    total = (parseFloat(calculo) + parseFloat(stockunidad));

    $("#stocktotal").val((unidades == "0") ? "0" : total);

    //alert("stock total");
    //alert(unidades / unidadblister);

    $('input#stockblister').val(parseFloat(unidades) / parseFloat(unidadblister));


    $("#totalBlister").val(($("#stocktotal").val() > 0 && unidadblister > 0) ? Math.floor($("#stocktotal").val() / unidadblister) : 0);

  });

  $('.calculounidad2').keyup(function () {

    var preciocaja = $('input#precioventacaja2').val();
    var unidad = $('input#unidades2').val();
    var preciocompra = $('#preciocompra2').val();
    var unidadesblister2 = $('#unidadesblister2').val();


    var tot = parseFloat(unidad) / parseFloat(unidadesblister2);


    $('#stockblister2').val(tot.toFixed(2));

    //preciocompraunidad

    // stockblister2 
    // precio compra caja / unidades
    var total_precio = parseFloat(preciocompra) / unidad;
    $('#preciocompraunidad2').val(total_precio.toFixed(2));


    //REALIZO EL CALCULO
    preciounidad = preciocaja / unidad;
    // $("#precioventaunidad2").val((unidad == "0") ? "0.00" : preciounidad.toFixed(2));
  });

  $('.calculopreciocompra').keyup(function () {


    var unidad = $('input#unidades2').val();
    var preciocompra = $('#preciocompra2').val();
    var stockblister = $('#stockblister2').val();

    //preciocompraunidad

    // precio compra caja / unidades
    var total_precio = parseFloat(preciocompra) / parseFloat(unidad);
    var total_preciocompra_blisster = parseFloat(preciocompra) / parseFloat(stockblister);
    console.log(preciocompra);
    console.log(unidad);
    console.log(total_precio);
    $('#preciocompraunidad2').val(total_precio.toFixed(2));
    $('#preciocomprablister2').val(total_preciocompra_blisster.toFixed(2))

    //REALIZO EL CALCULO
    //preciounidad = preciocaja / unidad;
    // $("#precioventaunidad2").val((unidad == "0") ? "0.00" : preciounidad.toFixed(2));
  });
});


//FUNCION PARA CALCULAR PRECIO VENTA UNIDAD
$(document).ready(function () {


  $('.calculostock2').keyup(function () {

    calcularCantidades(2);

  });
});

////////////////////////////////////////////// FUNCIONES PARA PROCESAR DATOS ///////////////////////////////////////////

// FUNCION PARA MOSTRAR USUARIOS EN VENTANA MODAL
function VerUsuario(codigo) {
  $('#muestrausuariomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaUsuarioModal=si&codigo=' + codigo;
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestrausuariomodal').empty();
      $('#muestrausuariomodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA MOSTRAR SUCURSAL EN VENTANA MODAL
function VerSucursal(codsucursal) {
  $('#muestrasucursalmodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaSucursalModal=si&codsucursal=' + codsucursal;
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestrasucursalmodal').empty();
      $('#muestrasucursalmodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR LABORATORIOS EN VENTANA MODAL
function VerLaboratorio(codlaboratorio) {
  $('#muestralaboratoriomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaLaboratorioModal=si&codlaboratorio=' + codlaboratorio;
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestralaboratoriomodal').empty();
      $('#muestralaboratoriomodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA MOSTRAR PROVEEDOR EN VENTANA MODAL
function VerProveedor(codproveedor) {

  $('#muestraproveedormodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaProveedorModal=si&codproveedor=' + codproveedor;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestraproveedormodal').empty();
      $('#muestraproveedormodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}




// FUNCION PARA BUSQUEDA DE CLIENTES PARA PROCESOS
function BuscarClientes() {

  $('#resultadocliente').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var buscacliente = $("#buscacliente").val();
  var num = $("#buscacliente").val().length;
  var dataString = $("#buscaclientes").serialize();
  var url = 'funciones.php?BusquedaClientes=si';

  if (buscacliente == "" || buscacliente == " " || num <= 2) {

    $("#resultadocliente").html('<br><center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE CRITERIO PARA TU B&Uacute;SQUEDA DE CLIENTES !</div></center>');

    return false;

  } else {

    $.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function (response) {
        $('#resultadocliente').empty();
        $('#resultadocliente').append('' + response + '').fadeIn("slow");
        $('#' + parent).remove();
      }
    });

  }
}

// FUNCION PARA MOSTRAR CLIENTES EN VENTANA MODAL
function VerCliente(codcliente) {

  $('#muestraclientemodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaClienteModal=si&codcliente=' + codcliente;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestraclientemodal').empty();
      $('#muestraclientemodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

/////FUNCION PARA ELIMINAR CLIENTES
function EliminarCliente(codcliente, tipo, busqueda) {

  var dataString = 'codcliente=' + codcliente + '&tipo=' + tipo;
  var eliminar = confirm("ESTA SEGURO DE ELIMINAR ESTE CLIENTE?")

  if (eliminar) {

    $.ajax({
      type: "GET",
      url: "eliminar.php",
      data: dataString,
      success: function (response) {
        $('#delete-ok').empty();
        $('#delete-ok').append('<center>' + response + '</center>').fadeIn("slow");
        $("#resultadocliente").load("funciones.php?BusquedaClientes=si&buscacliente=" + busqueda);
        setTimeout(function () { $("#delete-ok").html(""); }, 5000);
        $('#' + parent).remove();
      }
    });
  }
}

// FUNCION PARA CARGAR LOS DATOS DE CLIENTES
function CargaCampos(codcliente, cedcliente, nomcliente, direccliente, tlfcliente, celcliente, emailcliente, busqueda) {
  // aqui asigno cada valor a los campos correspondientes
  $("#updateclientes #codcliente").val(codcliente);
  $("#updateclientes #cedcliente").val(cedcliente);
  $("#updateclientes #nomcliente").val(nomcliente);
  $("#updateclientes #direccliente").val(direccliente);
  $("#updateclientes #tlfcliente").val(tlfcliente);
  $("#updateclientes #celcliente").val(celcliente);
  $("#updateclientes #emailcliente").val(emailcliente);
  $("#updateclientes #busqueda").val(busqueda);
}

// FUNCION PARA CARGAR LOS DATOS DE CLIENTES
function EditCampos(codcliente, cedcliente, nomcliente, direccliente, tlfcliente, celcliente, emailcliente, busqueda) {
  // aqui asigno cada valor a los campos correspondientes
  $("#updateventaclientes #codcliente").val(codcliente);
  $("#updateventaclientes #cedcliente").val(cedcliente);
  $("#updateventaclientes #nomcliente").val(nomcliente);
  $("#updateventaclientes #direccliente").val(direccliente);
  $("#updateventaclientes #tlfcliente").val(tlfcliente);
  $("#updateventaclientes #celcliente").val(celcliente);
  $("#updateventaclientes #emailcliente").val(emailcliente);
  $("#updateventaclientes #busqueda").val(busqueda);
}

// FUNCION PARA MOSTRAR CHOFER EN VENTANA MODAL
function VerChofer(codchofer) {

  $('#muestrachofermodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaChoferModal=si&codchofer=' + codchofer;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestrachofermodal').empty();
      $('#muestrachofermodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}





// FUNCION PARA BUSQUEDA DE PRODUCTOS PARA PROCESOS
function BuscarProductos() {

  $('#resultadoproducto').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var buscaproducto = $("#buscaproducto").val();
  var num = $("#buscaproducto").val().length;
  var dataString = $("#busquedaproductos").serialize();
  var url = 'funciones.php?BusquedaProductos=si';

  if (buscaproducto === "" || buscaproducto === " " || num <= 2) {

    $("#resultadoproducto").html(`<br>
                        <center>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span>
                             POR FAVOR INGRESE CRITERIO PARA TU B&Uacute;SQUEDA DE PRODUCTOS !
                        </div>
                        </center>`);

    return false;

  } else {

    $.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function (response) {
        console.log(response);
        $('#resultadoproducto').empty();
        $('#resultadoproducto').append('' + response + '').fadeIn("slow");
        $('#' + parent).remove();
      }
    });

  }
}

// FUNCION PARA MOSTRAR PRODUCTOS EN VENTANA MODAL
function VerProducto2(codproducto, codsucursal) {

  $('#muestraproductomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaProductoModal2=si&codproducto=' + codproducto + '&codsucursal=' + codsucursal;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestraproductomodal').empty();
      $('#muestraproductomodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

function VerProducto(codproducto, codsucursal) {

  $('#muestraproductomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaProductoModal=si&codproducto=' + codproducto + '&codsucursal=' + codsucursal;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestraproductomodal').empty();
      $('#muestraproductomodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR FOTO DE PRODUCTOS EN VENTANA MODAL
function VerImagen(codproducto, codsucursal) {

  $('#muestrafotoproductomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaFotoProductoModal=si&codproducto=' + codproducto + '&codsucursal=' + codsucursal;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestrafotoproductomodal').empty();
      $('#muestrafotoproductomodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

/////FUNCION PARA ELIMINAR CLIENTES
function EliminarProducto(codproducto, codsucursal, tipo, busqueda) {

  var dataString = 'codproducto=' + codproducto + '&codsucursal=' + codsucursal + '&tipo=' + tipo;
  var eliminar = confirm("ESTA SEGURO DE ELIMINAR ESTE PRODUCTO?")

  if (eliminar) {

    $.ajax({
      type: "GET",
      url: "eliminar.php",
      data: dataString,
      success: function (response) {
          console.log("ELIOMINANDO PRODUTO");
          console.log(response);

        $('#delete-ok').empty();
        $('#delete-ok').append('<center>' + response + '</center>').fadeIn("slow");
        $("#resultadoproducto").load("funciones.php?BusquedaProductos=si&buscaproducto=" + busqueda);
        setTimeout(function () { $("#delete-ok").html(""); }, 10000);
        
       // $('#' + parent).remove();
      }
    });
  }
}

// FUNCION PARA DESACTIVAR EL PRODUCTO
function deshabilitarProducto(codproducto, codsucursal)
{
  console.log(codproducto)
  
  var dataString = 'codproducto=' + codproducto + '&codsucursal=' + codsucursal;
  var deshabilitar = confirm('Esta seguro de deshabilitar el producto?');

  if(deshabilitar)
  {
    $.ajax({
      type: "GET",
      url: "deshabilitar.php",
      data: dataString,
      success: function(response) {
        console.log(response);
        $('#delete-ok').empty();
        $('#delete-ok').append('<center>' + response + '</center>').fadeIn("slow");
        setTimeout(function () { $("#delete-ok").html(""); }, 10000);
      }
    });

  }
}

// FUNCION PARA CARGAR LOS DATOS DE CLIENTES
function CargaProductos(codalmacen, codproducto, producto, principioactivo, descripcion, codpresentacion, codmedida, preciocompra, precioventacaja, precioventaunidad, stockcajas, unidades, stockunidad, stocktotal, stockminimo, ivaproducto, descproducto, fechaelaboracion, fechaexpiracion, codigobarra, codlaboratorio, codproveedor, codsucursal, loteproducto, ubicacion, statusp, busqueda = "", precioventablister = 0, blisterunidad = 0, stockblister = 0, preciocompraunidad = 0, preciocomprablister = 0, registrosanitario = "", blistercaja = 0, precioventablisterdesc = "", precioventacajadesc = "", precioventaunidaddesc = "", noCalcularCantidades=false) {
  console.log('EVENTO: CARGAR INFO DE LOS PRODUCTOS 1')
  console.log(blistercaja)
  console.log("Esto no se ve en el navegador.... donde esta tomando el valor")
  // aqui asigno cada valor a los campos correspondientes
  $("#updateproducto #codalmacen").val(codalmacen);
  $("#updateproducto #codproducto").val(codproducto);
  $("#updateproducto #producto").val(producto);
  $("#updateproducto #principioactivo").val(principioactivo);
  $("#updateproducto #descripcion").val(descripcion);
  $("#updateproducto #codpresentacion").val(codpresentacion);
  $("#updateproducto #codmedida").val(codmedida);
  $("#updateproducto #preciocompra2").val(preciocompra);
  $("#updateproducto #precioventacaja2").val(precioventacaja);
  $("#updateproducto #precioventaunidad2").val(precioventaunidad);
  $("#updateproducto #stockcajas2").val(stockcajas);
  $("#updateproducto #unidades2").val(unidades);
  $("#updateproducto #stockunidad2").val(stockunidad);
  $("#updateproducto #stocktotal2").val(stocktotal);
  $("#updateproducto #stockminimo").val(stockminimo);
  $("#updateproducto #ivaproducto").val(ivaproducto);
  $("#updateproducto #descproducto").val(descproducto);
  $("#updateproducto #fechaelaboracion").val(fechaelaboracion);
  $("#updateproducto #fechaexpiracion").val(fechaexpiracion);
  $("#updateproducto #codigobarra").val(codigobarra);
  $("#updateproducto #codlaboratorio").val(codlaboratorio);
  $("#updateproducto #codproveedor").val(codproveedor);
  $("#updateproducto #codsucursal").val(codsucursal);
  $("#updateproducto #loteproducto").val(loteproducto);
  $("#updateproducto #ubicacion").val(ubicacion);
  $("#updateproducto #statusp").val(statusp);
  $("#updateproducto #busqueda").val(busqueda);

  $("#updateproducto #precioventablister2").val(precioventablister);
  $("#updateproducto #unidadesblister2").val(blisterunidad);
  $("#updateproducto #stockblister2").val(blistercaja);
  $("#updateproducto #preciocompraunidad2").val(preciocompraunidad);
  $("#updateproducto #preciocomprablister2").val(preciocomprablister);
  $("#updateproducto #totalBlister2").val(stockblister);

  $("#updateproducto #rsanitario2").val(registrosanitario);

  $("#updateproducto #precioventablisterdesc").val(precioventablisterdesc);
  $("#updateproducto #precioventacajadesc").val(precioventacajadesc);
  $("#updateproducto #precioventaunidaddesc").val(precioventaunidaddesc);

  if (!noCalcularCantidades) calcularCantidades(2);


}


// FUNCION PARA MOSTRAR DETALLE DEL KARDEX DE PRODUCTO EN VENTANA MODAL
function VerDetalleKardex(codkardex) {

  $('#muestradetallekardexmodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaDetalleKardexModal=si&codkardex=' + codkardex;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestradetallekardexmodal').empty();
      $('#muestradetallekardexmodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}





// FUNCION PARA MOSTRAR ARQUEO DE CAJA EN VENTANA MODAL
function VerArqueo(codarqueo) {

  $('#muestraarqueomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaArqueoCajaModal=si&codarqueo=' + codarqueo;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestraarqueomodal').empty();
      $('#muestraarqueomodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR MOVIMIENTO DE CAJA EN VENTANA MODAL
function VerMovimientoCaja(codmovimientocaja) {

  $('#muestramovimientocajamodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaMovimientoCajaModal=si&codmovimientocaja=' + codmovimientocaja;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestramovimientocajamodal').empty();
      $('#muestramovimientocajamodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

//FUNCION PARA CALCULAR LA DIFERENCIA EN CIERRE DE CAJA
$(document).ready(function () {
  $('.cierrecaja').keyup(function () {

    var efectivo = $('input#dineroefectivo').val();
    var estimado = $('input#estimado').val();

    //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
    total = efectivo - estimado;
    var original = parseFloat(total.toFixed(2));
    $("#diferencia").val(original.toFixed(2));/**/

  });
});


// FUNCION PARA MOSTRAR CAJAS POR SUCURSAL
function CargaCajas(codsucursal) {

  $('#codcaja').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaCajas=si&codsucursal=' + codsucursal;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#codcaja').empty();
      $('#codcaja').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE PRODUCTOS POR SUCURSAL
function BuscaProductosSucursal() {

  $('#muestraproductossucursal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("#codsucursal").val();
  var dataString = $("#buscaproductos").serialize();
  var url = 'funciones.php?BuscaProductosSucursal=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraproductossucursal').empty();
      $('#muestraproductossucursal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

//FUNCION PARA BUSQUEDA DE PRODUCTOS POR SUCURSAL Y LABORATORIOS
function BuscaProductosLaboratorios() {

  $('#muestraproductoslaboratorios').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("#codsucursal").val();
  var codlaboratorio = $("#codlaboratorio").val();
  var dataString = $("#buscaproductoslaboratorio").serialize();
  var url = 'funciones.php?BuscaProductosLaboratorios=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraproductoslaboratorios').empty();
      $('#muestraproductoslaboratorios').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE PRODUCTOS EN STOCK MINIMO
function BuscaProductosStock() {

  $('#muestraproductosstock').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("#codsucursal").val();
  var tiempovence = $("#tiempovence").val();
  var dataString = $("#buscaproductosstock").serialize();
  var url = 'funciones.php?BuscaProductosStock=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraproductosstock').empty();
      $('#muestraproductosstock').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE PRODUCTOS VENCIDOS POR FECHAS PARA REPORTES
function BuscaProductoVencidos() {

  $('#muestraproductosvencidos').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("select[name='codsucursal']").val();
  var dataString = $("#buscaproductosvencidos").serialize();
  var url = 'funciones.php?BuscaProductosVencidos=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraproductosvencidos').empty();
      $('#muestraproductosvencidos').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS
function BuscaKardexProductos() {

  $('#muestrakardexproducto').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var codproducto = $("#codproducto").val();
  var codsucursal = $("#codsucursal").val();
  var dataString = $("#buscakardex").serialize();
  var url = 'funciones.php?BuscaKardexProducto=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestrakardexproducto').empty();
      $('#muestrakardexproducto').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}



// FUNCION PARA MOSTRAR SUCURSALES PARA TRASPASO
function CargaSucursales(envio) {

  //$('#recibe').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaSucursales=si&envio=' + envio;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#recibe').empty();
      $('#recibe').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}



//FUNCION PARA MUESTRA DE PRODUCTOS PARA TRASPASO
function BuscaProductosTraspaso() {

  $('#muestraproductostraspaso').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var envio = $("#envio").val();
  var recibe = $("#recibe").val();
  var codlaboratorio = $("#codlaboratorio").val();
  var dataString = $("#traspasoproductos").serialize();
  var url = 'funciones.php?BuscaProductosTraspaso=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraproductostraspaso').empty();
      $('#muestraproductostraspaso').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA MUESTRA DE PRODUCTOS PARA TRASPASO
function BuscaTraspasos() {

  $('#muestratraspasosproductos').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var envio = $("#envio").val();
  var recibe = $("#recibe").val();
  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscartraspasos").serialize();
  var url = 'funciones.php?BuscaTraspasoProductos=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestratraspasosproductos').empty();
      $('#muestratraspasosproductos').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}



// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PRODUCTOS
function CargaDivProductos() {

  $('#divproducto').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaDivProducto=si';

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#divproducto').empty();
      $('#divproducto').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}



//FUNCIONES PARA ACTIVAR-DESACTIVAR CAMPOS PARA INTERESES EN TARJETAS
function Verifica() {

  //$("#tipotarjeta").on("change", function() {

  var valor = $("#tipotarjeta").val();

  if (valor === "" || valor === true) {

    $("#codbanco").attr('disabled', true);
    $("#codtarjeta").attr('disabled', true);
    $("#meses").attr('disabled', true);
    $("#tasasi").attr('disabled', true);
    $("#tasano").attr('disabled', true);

  } else if (valor === "DEBITO" || valor === true) {

    $("#codbanco").attr('disabled', false);
    $("#codtarjeta").attr('disabled', false);
    $("#meses").attr('disabled', true);
    $("#tasasi").attr('disabled', false);
    $("#tasano").attr('disabled', true);

  } else if (valor === "CREDITO" || valor === true) {

    // deshabilitamos
    $("#codbanco").attr('disabled', false);
    $("#codtarjeta").attr('disabled', false);
    $("#meses").attr('disabled', false);
    $("#tasasi").attr('disabled', false);
    $("#tasano").attr('disabled', false);
  }
  //});
}


// FUNCION PARA CARGAR TARJETAS POR BANCOS Y TIPO D ETARJETA
function CargaTarjetasxBancos(codbanco, tipotarjeta) {

  var dataString = 'BuscaTarjetasxBancos=si&codbanco=' + codbanco + '&tipotarjeta=' + tipotarjeta;
  $("#codtarjeta").attr('disabled', false);
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#codtarjeta').empty();
      $('#codtarjeta').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

















//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR PEDIDOS DE PRODUCTOS /////////////////////////////////////////////////////////////

// FUNCION PARA MOSTRAR COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerPedido(codpedido) {

  $('#muestrapedidosmodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaPedidosModal=si&codpedido=' + codpedido;
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestrapedidosmodal').empty();
      $('#muestrapedidosmodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA MOSTRAR DETALLES DE PEDIDOS DE PRODUCTOS EN VENTANA MODAL
function VerDetallePedido(coddetallepedido) {

  $('#muestradetallepedidomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaDetallePedidoModal=si&coddetallepedido=' + coddetallepedido;
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestradetallepedidomodal').empty();
      $('#muestradetallepedidomodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS DE PRODUCTOS POR PROVEDORES
function BuscaPedidosProveedor() {

  $('#muestracompraproveedor').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var codproveedor = $("#codproveedor").val();
  var dataString = $("#buscacomprasproveedor").serialize();
  var url = 'funciones.php?BuscaComprasPoveedor=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestracompraproveedor').empty();
      $('#muestracompraproveedor').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}












































//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR COMPRAS DE PRODUCTOS /////////////////////////////////////////////////////////////


//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE COMPRA DE PRODUCTOS
$(document).ready(function () {
  $('.calculocompra').keyup(function () {
    var precio = $('input#preciocompra').val();
    //var cantidad = $('input#cantcompra').val();
    //var cantbonif = $('input#cantbonif').val();
    var cantidad = ($('input#cantcompra').val() == "" ? "0" : $('input#cantcompra').val());
    var cantbonif = ($('input#cantbonif').val() == "" ? "0" : $('input#cantbonif').val());
    var descfactura = $('input#descfactura').val();
    var calculovalor = $('input#valortotal').val();

    //REALIZO EL CALCULO
    var valortotal = parseFloat(precio) * parseFloat(cantidad);
    var totaldescuentoc = parseFloat(valortotal) * descfactura / 100;
    var descbonific = parseFloat(precio) * parseFloat(cantbonif);
    var neto = parseFloat(valortotal) - parseFloat(totaldescuentoc);
    var valorneto = parseFloat(neto) + parseFloat(descbonific);
    $("#valortotal").val(valortotal.toFixed(2));
    $("#totaldescuentoc").val(totaldescuentoc.toFixed(2));
    $("#descbonific").val(descbonific.toFixed(2));
    $("#valorneto").val(valorneto.toFixed(2));
  });
});


// FUNCION PARA MOSTRAR FORMA DE PAGO
function BuscaFormaPagosCompras() {

  //'#muestraformapagocompras').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var tipocompra = $("#tipocompra").val();
  var dataString = $("#compras").serialize();
  var url = 'funciones.php?BuscaFormaPagoCompras=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraformapagocompras').empty();
      $('#muestraformapagocompras').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerCompra(codcompra) {

  $('#muestracomprasmodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaComprasModal=si&codcompra=' + codcompra;
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestracomprasmodal').empty();
      $('#muestracomprasmodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA MOSTRAR DETALLES DE COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerDetalleCompra(coddetallecompra) {

  $('#muestradetallecompramodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaDetallesComprasModal=si&coddetallecompra=' + coddetallecompra;
  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestradetallecompramodal').empty();
      $('#muestradetallecompramodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}



//FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS DE PRODUCTOS POR PROVEDORES
function BuscaComprasProveedor() {

  $('#muestracompraproveedor').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("#codsucursal").val();
  var codproveedor = $("#codproveedor").val();
  var dataString = $("#buscacomprasproveedor").serialize();
  var url = 'funciones.php?BuscaComprasProveedor=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestracompraproveedor').empty();
      $('#muestracompraproveedor').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

//FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS DE PRODUCTOS POR FECHAS
function BuscaComprasFechas() {

  $('#muestracomprafechas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("#codsucursal").val();
  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscacomprasfechas").serialize();
  var url = 'funciones.php?BuscaComprasFechas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestracomprafechas').empty();
      $('#muestracomprafechas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS POR PAGAR
function BuscaComprasxPagar() {

  $('#muestracompraxpagar').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("#codsucursal").val();
  var dataString = $("#buscacomprasxpagar").serialize();
  var url = 'funciones.php?BuscaComprasxPagar=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestracompraxpagar').empty();
      $('#muestracompraxpagar').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}
































//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR VENTAS DE PRODUCTOS ////////////////////////////////////////////////////////

// FUNCION PARA BUSQUEDA DE CLIENTES
function BusquedaClientes() {

  $('#resultado').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var buscacliente = $("#buscacliente").val();
  var num = $("#buscacliente").val().length;
  var dataString = $("#buscaclientes").serialize();
  var url = 'funciones.php?BuscaClientes=si';

  if (buscacliente == "" || buscacliente == " " || num <= 2) {

    $("#resultado").html('<br><center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE CRITERIO PARA TU B&Uacute;SQUEDA !</div></center>');

    return false;

  } else {

    $.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function (response) {
        $('#resultado').empty();
        $('#resultado').append('' + response + '').fadeIn("slow");
        $('#' + parent).remove();
      }
    });

  }
}


// FUNCION PARA MOSTRAR FORMA DE PAGO
function BuscaFormaPagosVentas() {

  var tipopagove = $("#tipopagove").val();
  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?BuscaFormaPagoVentas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraformapagoventas').empty();
      $('#muestraformapagoventas').append('' + response + '').fadeIn("slow");
      $('#muestracambiospagos').html("");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR FORMA DE PAGO PARA VENTAS
function MuestraCambiosVentas() {

  var tipopagove = $("#tipopagove").val();
  var codmediopago = $("#codmediopago").val();
  var TotalFactura = $('input#txtTotal').val();
  $("#lblGrande").text($('input#txtTotal').val());
  $("#lbltotal").text($('input#txtTotal').val());
  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?MuestraCambiosVentas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestracambiospagos').empty();
      $('#muestracambiospagos').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

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





/*#####################################################################################*/

// FUNCION PARA CARGAR TARJETAS DE DEBITO
function CargaTarjetaDebito() {

  var codbanco = $("#codbanco").val();
  var tipotarjeta = $("#tipotarjeta").val();
  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?CargaTarjetasDebito=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#interesdebito').html("");
      $('#coddebito').empty();
      $('#coddebito').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA CARGAR INTERES EN TARJETAS DE DEBITO
function CargaInteresDebito() {

  var codbanco = $("#codbanco").val();
  var codtarjeta = $("#codtarjeta").val();
  var meses = $("#meses").val();
  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?CargaInteresDebito=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#interesdebito').empty();
      $('#interesdebito').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA DESACTIVAR BOTONES EN TARJETAS DE DEBITO
function DesactivaBotonDebito() {

  $("#buttondebito").attr('disabled', false);
  $("#buttondebito2").attr('disabled', false);
}

// FUNCION PARA CALCULAR TASA EN TARJETAS DE DEBITO
function SumarInteresDebito() {

  var Intereses = ($('input#tasasi').val() == "" ? "0.00" : $('input#tasasi').val());
  var TotalFactura = $('input#txtTotal').val();

  //REALIZO EL CALCULO
  var ValorTasa = TotalFactura * Intereses / 100;
  var ValorTotal = parseFloat(TotalFactura) + parseFloat(ValorTasa);

  $("#lblGrande").text(ValorTotal.toFixed(2));
  $("#lbltotal").text(ValorTotal.toFixed(2));
  $("#buttondebito").attr('disabled', false);
  $("#buttondebito2").attr('disabled', false);
}

// FUNCION PARA QUITAR TASA EN TARJETAS DE DEBITO
function RestarInteresDebito() {

  var TotalFactura = $('input#txtTotal').val();

  $("#lblGrande").text($('input#txtTotal').val());
  $("#lbltotal").text($('input#txtTotal').val());
}

/*#####################################################################################*/







/*#####################################################################################*/

// FUNCION PARA CARGAR TARJETAS DE CREDITO
function CargaTarjetaCredito() {

  var codbanco = $("#codbanco").val();
  var tipotarjeta = $("#tipotarjeta").val();
  $("#buttondebito").attr('disabled', true);
  $("#buttondebito2").attr('disabled', true);
  $("#meses").val("");
  $('#muestrameses').html("");
  $("#muestraintereses").html("");
  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?CargaTarjetasCredito=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#codcredito').empty();
      $('#codcredito').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA CARGAR MESES TARJETAS DE CREDITO
function CargaMesesTarjetaCredito() {

  var codbanco = $("#codbanco").val();
  var codtarjeta = $("#codtarjeta").val();


  $("#muestraintereses").html("");
  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?CargaMesesTarjetasCredito=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestrameses').empty();
      $('#muestrameses').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA CARGAR TASA MESES TARJETAS DE CREDITO
function CargaInteresesCredito() {

  var codbanco = $("#codbanco").val();
  var codtarjeta = $("#codtarjeta").val();
  var interes = $("#interes").val();
  var meses = $("#meses").val();
  $("#buttondebito").attr('disabled', false);
  $("#buttondebito2").attr('disabled', false);

  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?CargaInteresCredito=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraintereses').empty();
      $('#muestraintereses').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA DESACTIVAR BOTONES EN TARJETAS DE CREDITO
function CargaInteres() {

  var codbanco = $("#codbanco").val();
  var codtarjeta = $("#codtarjeta").val();
  var interes = $("#interes").val();
  var meses = $("#meses").val();
  var dataString = $("#ventas").serialize();
  var url = 'funciones.php?CargaInteresRadio=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#corrije').empty();
      $('#corrije').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA CALCULAR TASA EN TARJETAS DE CREDITO
function SumarInteresCredito() {

  var Intereses = ($('input#tasa').val() == "" ? "0.00" : $('input#tasa').val());
  var TotalFactura = $('input#txtTotal').val();

  //REALIZO EL CALCULO
  var ValorTasa = TotalFactura * Intereses / 100;
  var ValorTotal = parseFloat(TotalFactura) + parseFloat(ValorTasa);

  $("#lblGrande").text(ValorTotal.toFixed(2));
  $("#lbltotal").text(ValorTotal.toFixed(2));
  $("#buttondebito").attr('disabled', false);
  $("#buttondebito2").attr('disabled', false);
}

// FUNCION PARA QUITAR TASA EN TARJETAS DE CREDITO
function RestarInteresCredito() {

  var TotalFactura = $('input#txtTotal').val();

  $("#lblGrande").text($('input#txtTotal').val());
  $("#lbltotal").text($('input#txtTotal').val());
}

/*#####################################################################################*/





//FUNCIONES PARA LIMPIAR BUSQUEDA DE VENTAS
$(document).ready(function () {

  $("#tipobusqueda").on("change", function () {

    var valor = $("#tipobusqueda").val();

    if (valor === "" || valor === true) {

      $("#codcliente").val('');
      $("#busquedacliente").val('');
      $("#codcaja").val('');
      $("#fecha").val('');

    } else if (valor === "1" || valor === true) {

      $("#codcaja").val('');
      $("#fecha").val('');

    } else if (valor === "2" || valor === true) {

      // deshabilitamos
      $("#codcliente").val('');
      $("#busquedacliente").val('');
      $("#fecha").val('');

    } else if (valor === "3" || valor === true) {

      // deshabilitamos
      $("#codcliente").val('');
      $("#busquedacliente").val('');
      $("#codcaja").val('');
      //$("#fecha").attr('disabled', true);
    }
  });
});

//FUNCION PARA BUSQUEDA DE VENTAS POR CRITERIOS
function BuscarVentas() {

  $('#muestraventas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var tipobusqueda = $("#tipobusqueda").val();
  var codcliente = $("#codcliente").val();
  var codcaja = $("#codcaja").val();
  var fecha = $("#fecha").val();
  var fechah = $('#fechah').val();

  var dataString = $("#buscarventas").serialize();
  var url = 'funciones.php?BuscarVentas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraventas').empty();
      $('#muestraventas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA MOSTRAR VENTAS DE PRODUCTOS EN VENTANA MODAL
function VerVentas(codventa) {

  $('#muestraventasmodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaVentasModal=si&codventa=' + codventa;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestraventasmodal').empty();
      $('#muestraventasmodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCIONES PARA LIMPIAR BUSQUEDA DETALLES DE VENTAS
$(document).ready(function () {

  $("#tipobusquedad").on("change", function () {

    var valor = $("#tipobusquedad").val();

    if (valor === "" || valor === true) {

      $("#codventa").val('');
      $("#codcaja").val('');
      $("#fecha").val('');

    } else if (valor === "1" || valor === true) {

      $("#codcaja").val('');
      $("#fecha").val('');

    } else if (valor === "2" || valor === true) {

      // deshabilitamos
      $("#codventa").val('');
      $("#fecha").val('');

    } else if (valor === "3" || valor === true) {

      // deshabilitamos
      $("#codventa").val('');
      $("#codcaja").val('');
    }
  });
});

//FUNCION PARA BUSQUEDA DETALLES DE VENTAS POR CRITERIOS
function BuscarDetallesVentas() {

  $('#muestradetallesventas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var tipobusqueda = $("#tipobusquedad").val();
  var codventa = $("#codventa").val();
  var codcaja = $("#codcaja").val();
  var fecha = $("#fecha").val();
  var fechah = $("#fechah").val();

  var dataString = $("#buscardetallesventas").serialize();
  var url = 'funciones.php?BuscarDetallesVentas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestradetallesventas').empty();
      $('#muestradetallesventas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR DETALLES DE VENTA DE PRODUCTOS EN VENTANA MODAL
function VerDetalleVentas(coddetalleventa) {

  $('#muestradetalleventamodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var dataString = 'BuscaDetallesVentasModal=si&coddetalleventa=' + coddetalleventa;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestradetalleventamodal').empty();
      $('#muestradetalleventamodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA CARGAR LOS DATOS DE CLIENTES
function CargaDetalleVenta(coddetalleventa, tipodocumento, codigoventa, codsucursal, ivave, codproducto, producto, principioactivo, descripcion,
  nommedida, codpresentacion, preciocomprav, precioventacajav, precioventaunidadv, preciounitario, cantventa, cantbonificv, valortotalv, descproductov, descporc, descbonificv, valornetov, baseimponible, ivaproductov, fechadetalleventa, tipobusquedad, codcaja, fecha, tipocantidad) {
  // aqui asigno cada valor a los campos correspondientes
  $("#updatedetallesventas #coddetalleventa").val(coddetalleventa);
  $("#updatedetallesventas #tipodocumento").val(tipodocumento);
  $("#updatedetallesventas #codigoventa").val(codigoventa);
  $("#updatedetallesventas #codsucursal").val(codsucursal);
  $("#updatedetallesventas #ivave").val(ivave);
  $("#updatedetallesventas #codproducto").val(codproducto);
  $("#updatedetallesventas #producto").val(producto);
  $("#updatedetallesventas #principioactivo").val(principioactivo);
  $("#updatedetallesventas #descripcion").val(descripcion);
  $("#updatedetallesventas #nommedida").val(nommedida);
  $("#updatedetallesventas #codpresentacion").val(codpresentacion);
  $("#updatedetallesventas #preciocomprav").val(preciocomprav);
  $("#updatedetallesventas #precioventacajav").val(precioventacajav);
  $("#updatedetallesventas #precioventaunidadv").val(precioventaunidadv);
  $("#updatedetallesventas #preciounitario").val(preciounitario);
  $("#updatedetallesventas #cantidadventadb").val(cantventa);
  $("#updatedetallesventas #cantventa").val(cantventa);
  $("#updatedetallesventas #cantidadbonifventadb").val(cantbonificv);
  $("#updatedetallesventas #cantbonificv").val(cantbonificv);
  $("#updatedetallesventas #valortotalv").val(valortotalv);
  $("#updatedetallesventas #descproductov").val(descproductov);
  $("#updatedetallesventas #descporc").val(descporc);
  $("#updatedetallesventas #descbonificv").val(descbonificv);
  $("#updatedetallesventas #valornetov").val(valornetov);
  $("#updatedetallesventas #baseimponible").val(baseimponible);
  $("#updatedetallesventas #ivaproductov").val(ivaproductov);
  $("#updatedetallesventas #fechadetalleventa").val(fechadetalleventa);
  $("#updatedetallesventas #tipobusquedad2").val(tipobusquedad);
  $("#updatedetallesventas #codcaja2").val(codcaja);
  $("#updatedetallesventas #fecha2").val(fecha);
  $("#updatedetallesventas #tipocantidad").val(tipocantidad);

}

//FUNCION PARA ACTUALIZAR DETALLE DE PRODUCTOS POR UNIDAD
$(document).ready(function () {
  $('.calculoventaunidad').keyup(function () {
    var precio = $('input#preciounitario').val();
    var descproducto = $('input#descproductov').val();
    var cantidad = ($('input#cantventa').val() == "" ? "0" : $('input#cantventa').val());
    var cantbonif = ($('input#cantbonificv').val() == "" ? "0" : $('input#cantbonificv').val());
    var ivaproducto = $('input#ivaproductov').val();
    var ivg = $('input#ivave').val();
    var ivg2 = 1 + ivg / 100;

    //REALIZO EL CALCULO
    var ValorTotal = parseFloat(precio) * parseFloat(cantidad);
    var CalcD = precio * descproducto / 100;
    var DescPorc = CalcD * parseFloat(cantidad);
    var DescBonificv = parseFloat(precio) * parseFloat(cantbonif) * parseFloat(descproducto) / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(DescPorc) + parseFloat(DescBonificv);
    var BaseImponible = (ivaproducto == "NO" ? parseFloat(ValorNeto) : parseFloat(ValorNeto) / ivg2);

    $("#valortotalv").val(ValorTotal.toFixed(2));
    $("#descporc").val(DescPorc.toFixed(2));
    $("#descbonificv").val(DescBonificv.toFixed(2));
    $("#valornetov").val(ValorNeto.toFixed(2));
    $("#baseimponible").val(BaseImponible.toFixed(2));
  });

  $('#tipocantidad').change(function() {
    const id = $("#updatedetallesventas #coddetalleventa").val();
    $('#preciounitario').val(window[`precios-detalle-${id}`][this.value]);
    $('.calculoventaunidad').keyup();
  })
});


//FUNCION PARA ACTUALIZAR DETALLE DE PRODUCTOS POR CAJA
/*$(document).ready(function (){
          $('.calculoventacaja').keyup(function (){
            var precio = $('input#precioventacajav').val();
            var cantidad = ($('input#cantventa').val() == "" ? "0" : $('input#cantventa').val());
            var cantbonif = ($('input#cantbonificv').val() == "" ? "0" : $('input#cantbonificv').val());
            var descproducto = $('input#descproductov').val();
            var calculovalor = $('input#valortotalv').val();

            //REALIZO EL CALCULO
            var valortotalv = parseFloat(precio) * parseFloat(cantidad) ;
            var totaldescuentov = parseFloat(valortotalv) * descproducto / 100;
            var descbonificv = parseFloat(precio) * parseFloat(cantbonif) ;
            var neto = parseFloat(valortotalv) - parseFloat(totaldescuentov);
            var valornetov = parseFloat(neto) + parseFloat(descbonificv);
            $("#valortotalv").val(valortotalv.toFixed(2));
            $("#totaldescuentov").val(totaldescuentov.toFixed(2));
            $("#descbonificv").val(descbonificv.toFixed(2));
            $("#valornetov").val(valornetov.toFixed(2));
         });
 });*/


//FUNCIONES PARA ACTIVAR-DESACTIVAR CAMPOS PARA BUSQUEDA DE REPORTES DE VENTAS
/*$(document).ready(function() {

            $("#tipo").on("change", function() {

               var valor = $("#tipo").val();

               if (valor === "1" || valor === true) {

                $("#desde").attr('disabled', false);
                $("#hasta").attr('disabled', false);
                $("#busqueda").attr('disabled', true);

              } else if (valor === "2" || valor === true) {

                  // deshabilitamos
                  $("#desde").attr('disabled', false);
                  $("#hasta").attr('disabled', false);
                  $("#busqueda").attr('disabled', false);

                } else if (valor === "3" || valor === true) {

                  // deshabilitamos
                  $("#desde").attr('disabled', true);
                  $("#hasta").attr('disabled', true);
                  $("#busqueda").attr('disabled', false);
             }
       });
 });*/



function verificaeliminar() {
  alert('ESTE DETALLE DE VENTA NO PUEDE ELIMINARSE,\nLA FECHA DE VENTA ES DIFERENTE A LA ACTUAL ');
}

/////FUNCION PARA ELIMINAR DETALLES DE VENTAS
function EliminarDetalleVenta(coddetalleventa, codcaja, tipopagove, codventa, codcliente, codsucursal, codproductov, cantventa, cantbonificv, preciocomprav, precioventaunidadv, precioventacajav, ivaproductov, descproductov, tipo, tipobusquedad, fecha) {

  var dataString = 'coddetalleventa=' + coddetalleventa + '&codcaja=' + codcaja + '&tipopagove=' + tipopagove + '&codventa=' + codventa + '&codcliente=' + codcliente + '&codsucursal=' + codsucursal + '&codproductov=' + codproductov + '&cantventa=' + cantventa + '&cantbonificv=' + cantbonificv + '&preciocomprav=' + preciocomprav + '&precioventaunidadv=' + precioventaunidadv + '&precioventacajav=' + precioventacajav + '&ivaproductov=' + ivaproductov + '&descproductov=' + descproductov + '&tipo=' + tipo;
  var eliminar = confirm("ESTA SEGURO DE ELIMINAR ESTE DETALLE DE VENTA?")

  if (eliminar) {

    $.ajax({
      type: "GET",
      url: "eliminar.php",
      data: dataString,
      success: function (response) {
        $('#delete-ok').empty();
        $('#delete-ok').append('<center>' + response + '</center>').fadeIn("slow");
        $("#muestradetallesventas").load("funciones.php?BuscarDetallesVentas=si&tipobusquedad=" + tipobusquedad + '&codventa=' + codventa + '&codcaja=' + codcaja + '&fecha=' + fecha);
        setTimeout(function () { $("#delete-ok").html(""); }, 5000);
        $('#' + parent).remove();
      }
    });
  }
}

//FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS Y CAJAS DE VENTAS PARA REPORTES
function BuscaVentasCajas() {

  $('#muestraventascajas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var codcaja = $("select[name='codcaja']").val();
  var dataString = $("#buscaventascajas").serialize();
  var url = 'funciones.php?BuscaVentasCajas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraventascajas').empty();
      $('#muestraventascajas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

//FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS PARA REPORTES
function BuscaVentasFechas() {

  $('#muestraventasfechas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscaventasfechas").serialize();
  var url = 'funciones.php?BuscaVentasFechas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraventasfechas').empty();
      $('#muestraventasfechas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS POR FECHAS PARA REPORTES
function BuscaProductoVendidos() {

  $('#muestraproductosvendidos').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codsucursal = $("select[name='codsucursal']").val();
  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscaproductosvendidos").serialize();
  var url = 'funciones.php?BuscaProductosVendidosFechas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraproductosvendidos').empty();
      $('#muestraproductosvendidos').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}



//FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR FECHAS PARA REPORTES
function BuscaArqueosFechas() {

  $('#muestraarqueosfechas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscaarqueosfechas").serialize();
  var url = 'funciones.php?BuscaArqueosFechas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraarqueosfechas').empty();
      $('#muestraarqueosfechas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

//FUNCION PARA BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS PARA REPORTES
function BuscaMovimientosCajas() {

  $('#muestramovimientoscajas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codcaja = $("select[name='codcaja']").val();
  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscamovimientoscajas").serialize();
  var url = 'funciones.php?BuscaMovimientosCajas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestramovimientoscajas').empty();
      $('#muestramovimientoscajas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE INFORMES DE VENTAS POR FECHAS PARA REPORTES
function BuscaInformeVentasFechas() {

  $('#muestrainformeventasfechas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscainformeventasfechas").serialize();
  var url = 'funciones.php?BuscaInformeVentasFechas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestrainformeventasfechas').empty();
      $('#muestrainformeventasfechas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


//FUNCION PARA BUSQUEDA DE INFORMES GENERAL DE CAJAS POR FECHAS PARA REPORTES
function BuscaInformesCajasFechas() {

  $('#muestrainformescajasfechas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');

  var codcaja = $("select[name='codcaja']").val();
  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#buscainformescajasfechas").serialize();
  var url = 'funciones.php?BuscaInformeCajasFechas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestrainformescajasfechas').empty();
      $('#muestrainformescajasfechas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


///////////////////////////////////////////////// FUNCIONES PARA PROCESAR ABONOS A CREDITOS DE PRODUCTOS /////////////////////////////////////////////////////

// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES
function BuscaClientesAbonos() {

  $('#muestraclientesabonos').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var codcliente = $("#codcliente").val();
  var dataString = $("#abonoscreditos").serialize();
  var url = 'funciones.php?BuscaAbonosClientes=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestraformularioabonos').html("");
      $('#muestraclientesabonos').empty();
      $('#muestraclientesabonos').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR FOMRULARIO DE NUEVOS ABONOS
function NuevoAbono(cedcliente, codventa) {

  $('#muestraformularioabonos').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'MuestraFormularioAbonos=si&cedcliente=' + btoa(cedcliente) + '&codventa=' + btoa(codventa);

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestraformularioabonos').empty();
      $('#muestraformularioabonos').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA MOSTRAR CREDITOS DE VENTAS DE PRODUCTOS EN VENTANA MODAL
function VerCreditos(codventa) {

  $('#muestracreditosmodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var dataString = 'BuscaCreditosModal=si&codventa=' + codventa;

  $.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function (response) {
      $('#muestracreditosmodal').empty();
      $('#muestracreditosmodal').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}

// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES PARA REPORTES
function BuscaCreditosClientes() {

  $('#muestracreditosclientes').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var codcliente = $("#codcliente").val();
  var dataString = $("#creditosclientes").serialize();
  var url = 'funciones.php?BuscaCreditosClientes=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestracreditosclientes').empty();
      $('#muestracreditosclientes').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES PARA REPORTES
function BuscaCreditosFechas() {

  $('#muestracreditosfechas').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var dataString = $("#creditosfechas").serialize();
  var url = 'funciones.php?BuscaCreditosFechas=si';

  $.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function (response) {
      $('#muestracreditosfechas').empty();
      $('#muestracreditosfechas').append('' + response + '').fadeIn("slow");
      $('#' + parent).remove();
    }
  });
}


function calcularCantidades(type) {

  if (type == 1) {
    var stockcajas = $('input#stockcajas').val();
    var unidades = $('input#unidades').val();
    var stockunidad = $('input#stockunidad').val();
    var stockblister = $('input#blistercaja').val();
    var unidadblister = $('input#unidadesblister').val();

    //REALIZO EL CALCULO
    var calculo = parseFloat(stockcajas) * parseFloat(unidades);
    total = (parseFloat(calculo) + parseFloat(stockunidad));

    $("#stocktotal").val((unidades == "0") ? "0" : total);

    //alert("stock total");
    //alert(unidades / unidadblister);

    $('input#stockblister').val(parseFloat(unidades) / parseFloat(unidadblister));


    $("#totalBlister").val(($("#stocktotal").val() > 0 && unidadblister > 0) ? Math.floor($("#stocktotal").val() / unidadblister) : 0);

  } else {
    var stockcajas = $('input#stockcajas2').val();
    var unidades = $('input#unidades2').val();
    var stockunidad = $('input#stockunidad2').val();
    var stockblister = $('input#stockblister2').val();
    var unidadblister = $('input#unidadesblister2').val();
    var preciocompraa = $('input#preciocompra2').val(); // preciocompracaja / unidades

    //REALIZO EL CALCULO
    var calculo = parseFloat(stockcajas) * parseFloat(unidades);
    total = (parseFloat(calculo) + parseFloat(stockunidad));
    var totalnew = parseFloat(preciocompraa) / parseFloat(unidades);

    //preciocompraunidad

    $("#stocktotal2").val((unidades == "0") ? "0" : total);
    $("#preciocompraunidad2").val(totalnew.toFixed(2));


    $("#totalBlister2").val(($("#stocktotal2").val() > 0 && unidadblister > 0) ? Math.floor($("#stocktotal2").val() / unidadblister) : 0);

  }

}