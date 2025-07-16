// FUNCION AUTOCOMPLETE PARA PRODUCTOS, SERVICIOS Y CLIENTES
var _stockTotal;
var _stockCaja;
var _stockBlister;

const alreadySearching = [];

const tryUntilVisible = (el, fn) => {
    if ($(el).is(':visible')) {
        fn(el);
    } else {
        setTimeout(() => tryUntilVisible(el, fn), 0);
    }
}

window.terminoDeBuscar = true;

const barcodeSearcher = elem => () => {
    const myval = parseInt($(elem).val());
    setTimeout(
        () => {
            if (!isNaN(myval)) {
                elem.autocomplete('search', myval);
                tryUntilVisible(elem.autocomplete('widget'), el => {
                    el.children().first().click();
                    window.terminoDeBuscar = true;
                });
            } else {
                window.terminoDeBuscar = true;
            }
            
        },
        0);
}

const appendFocusoutBarcodeSearcher = (elem) => {
    if (!alreadySearching.some(searching => elem.is(searching))) {
        elem.click(function() {
            window.terminoDeBuscar = false;
        });
        elem.on('keypress',function(e) {
            if(e.which == 13 && !window.terminoDeBuscar) {
                barcodeSearcher(elem)();
            }
        });
        elem.focusout(barcodeSearcher(elem));
        alreadySearching.push(elem);
    }
}

$.prototype.scannerAutocomplete = function () {
    appendFocusoutBarcodeSearcher(this);
    return $.prototype.autocomplete.apply(this, arguments);;
}

$(function() {
    $("#producto").autocomplete({
        source: "class/buscaproductos.php",
        minLength: 2,
        select: function(event, ui) {
            $('#descripcion').val(ui.item.descripcion ?? '');
            $('#principioactivo').val(ui.item.principioactivo ?? '');
            $('#codpresentacion').val(ui.item.codpresentacion ?? '');
            $('#codmedida').val(ui.item.codmedida ?? '');
            $('#codproducto').val(ui.item.codproducto ?? '');
            $('#codmedida').val(ui.item.codmedida ?? '');
            $('#nommedida').val(ui.item.nommedida ?? '');
            $('#codpresentacion').val(ui.item.codpresentacion ?? '');
            $('#ivaproductov').val(ui.item.ivaproducto ?? '');

            let precioUnitario;
            switch ($('#tipocantidad').val()) {
                case 'unidad':
                    precioUnitario = ui.item.precioventaunidad;
                    break;
                case 'unidaddescuento':
                    precioUnitario = ui.item.precioventaunidaddesc;
                    break;
                case 'blister':
                    precioUnitario = ui.item.precioventablister;
                    break;
                case 'blisterdescuento':
                    precioUnitario = ui.item.precioventablisterdesc;
                    break;
                case 'caja':
                    precioUnitario = ui.item.precioventacaja;
                    break;
                case 'cajadescuento':
                    precioUnitario = ui.item.precioventacajadesc;
                    break;
            }

            $('#preciounitario').val(precioUnitario);
            $('#cantventa').keyup();
        }
    });
});

$(function() {
    $("#busquedaproductoc").scannerAutocomplete({
        source: "class/buscaproductos.php",
        minLength: 1,
        autoFocus: true,
        select: function(event, ui) {
            console.log('EVENTO: CLICK BUSQUEDA PRODUCTOx');
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#descripcion').val(ui.item.descripcion);
            $('#principioactivo').val(ui.item.principioactivo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val(ui.item.nompresentacion);
            $('#codmedida').val(ui.item.codmedida);
            $('#medida').val(ui.item.nommedida);
            $('#unidades').val(ui.item.unidades);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventacaja').val(ui.item.precioventacaja);
            $('#precioventaunidad').val(ui.item.precioventaunidad);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#codlaboratorio').val(ui.item.codlaboratorio);
            $('#codigobarra').val(ui.item.codigobarra);
            $('#fechaelaboracion').val(ui.item.fechaelaboracion);
            $('#fechaexpiracion').val(ui.item.fechaexpiracion);
            $('#lote').val(ui.item.loteproducto);

            $('#preciocompraunidad').val(ui.item.preciocompraunidad);
            $('#preciocomprablister').val(ui.item.preciocomprablister);
            $('#precioventablister').val(ui.item.precioventablister);
            $('#blisterunidad').val(ui.item.blisterunidad);
            $('#precioventablisterdesc').val(ui.item.precioventablisterdesc);
            $('#precioventacajadesc').val(ui.item.precioventacajadesc);
            $('#precioventaunidaddesc').val(ui.item.precioventaunidaddesc);

            console.log(ui.item)
            
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
        }
    });
});


$(function() {
    $("#busquedaproductov").scannerAutocomplete({
        source: "class/buscaproductosv.php",
        minLength: 1,
        autoFocus: true,
        select: function(event, ui) {
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#descripcion').val(ui.item.descripcion);
            $('#principioactivo').val(ui.item.principioactivo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val(ui.item.nompresentacion);
            $('#codmedida').val(ui.item.codmedida);
            $('#medida').val(ui.item.nommedida);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventacaja').val(ui.item.precioventacaja);
            $('#precioventaunidad').val(ui.item.precioventaunidad);
            $('#precioventablister').val(ui.item.precioventablister);
            $('#precioventablisterdesc').val(ui.item.precioventablisterdesc);
            $('#precioventacajadesc').val(ui.item.precioventacajadesc);
            $('#precioventaunidaddesc').val(ui.item.precioventaunidaddesc);

            _stockCaja = Math.trunc(ui.item.stocktotal / ui.item.unidades);
            _stockBlister =  ui.item.stockblister;
            _stockTotal = ui.item.stocktotal;
            
            var tipoVenta = $("#tipoVenta").val();
        
            if (tipoVenta == 'Unidad') { 
                $('#stocktotal').val(_stockTotal);
            } else if (tipoVenta == 'Blister') {
                $('#stocktotal').val(_stockBlister);
            } else if(tipoVenta == 'Caja') {
                $('#stocktotal').val(_stockCaja);
            }

            $('#unidadcaja').val(ui.item.unidades);
            $('#unidadblister').val(ui.item.blisterunidad);



            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#fechaexpiracion').val(ui.item.fechaexpiracion);
            $('#desclaboratorio').val(ui.item.desclaboratorio);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventaunidad : "0.00");
            $("#cantidad").focus();
        }
    });
});

$(function() {
    $("#busquedaproductot").autocomplete({
        source: "class/buscaproductosv.php",
        minLength: 1,
        select: function(event, ui) {
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#descripcion').val(ui.item.descripcion);
            $('#principioactivo').val(ui.item.principioactivo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val(ui.item.nompresentacion);
            $('#codmedida').val(ui.item.codmedida);
            $('#medida').val(ui.item.nommedida);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventacaja').val(ui.item.precioventacaja);
            $('#precioventaunidad').val(ui.item.precioventaunidad);
            $('#stocktotal').val(ui.item.stockcajas);
            $('#unidades').val(ui.item.unidades);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#fechaexpiracion').val(ui.item.fechaexpiracion);
            $('#desclaboratorio').val(ui.item.desclaboratorio);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventacaja : "0.00");
            $("#cantidad").focus();
        }
    });
});


$(function() {
    $("#busquedacliente").autocomplete({
        source: "class/buscacliente.php",
        minLength: 5,
        select: function(event, ui) {
            $('#codcliente').val(ui.item.codcliente);
        }
    });
});


$(function() {
    $("#codventa").autocomplete({
        source: "class/buscacodventa.php",
        minLength: 2,
        select: function(event, ui) {
            $('#codventa').val(ui.item.codventa);
        }
    });
});
