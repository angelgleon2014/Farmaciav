
let getInput;
const makeGetInput = modalName => inputName => $(`#${modalName} [name="${inputName}"]`);
const getInputValue = inputName => parseInt(getInput(inputName).val());

class AbstractUpdaters {
    constructor(stockTotalInput) {
        this.stockTotalInput = stockTotalInput;
    }
    updateGuarded(inputName, value) {

        const updater = this[inputName];
        const input = getInput(inputName);
        const oldValue = input.attr('old-value');

        if (oldValue != value && !isNaN(parseInt(value))) {

            console.log("updating", inputName);

            if (updater) updater.call(this, parseInt(value), parseInt(oldValue));
            input.attr('old-value', value);
            input.val(value);

        }

    }
    stocktotal(value) {
        this.updateGuarded(this.stockBlisterName, Math.floor(value / getInputValue('unidadesblister')));
    }
    getStockTotal() {
        return parseInt(this.stockTotalInput.val());
    }
    stockunidad(value, oldValue) {

        this.updateGuarded(
            'stocktotal',
            this.getStockTotal() - oldValue + value);

    }
    _blistercaja(value) {

        // this.updateGuarded('totalBlister2', Math.floor(this.getStockTotal() / value));
        this.updateGuarded('preciocomprablister', getInputValue('preciocompra') / value);

    }
    stockcajas(value) {
        this.updateGuarded('stocktotal', value * getInputValue('unidades') + getInputValue('stockunidad'));
    }
    // unidades por caja
    unidades(value) {

        this.updateGuarded(this.blistercajaName, value / getInputValue('unidadesblister'))

        this.updateGuarded('stocktotal', getInputValue('stockcajas') * value + getInputValue('stockunidad'));

        this.updateGuarded('preciocompraunidad', getInputValue('preciocompra') / value);
        // this.updateGuarded('preciocomprablister', getInputValue('blistercaja') / value);
    }
    unidadesblister(value) {
        this.updateGuarded(this.stockBlisterName, Math.floor(this.getStockTotal() / value));
    }
    preciocompra(value) {

        this.updateGuarded('preciocompraunidad', value / getInputValue('unidades'));
        this.updateGuarded('preciocomprablister', value / getInputValue(this.blistercajaName));

    }
}

class ExistingProductUpdaters extends AbstractUpdaters {
    constructor(stockTotalInput) {
        super(stockTotalInput);
        this.stockBlisterName = 'totalBlister2';
        this.blistercajaName = 'blistercaja';
    }
    blistercaja(value, oldValue) {
        return this._blistercaja(value, oldValue);
    }
}

class NewProductUpdaters extends AbstractUpdaters {
    constructor(stockTotalInput) {
        super(stockTotalInput);
        this.stockBlisterName = 'totalBlister';
        this.blistercajaName = 'stockblister';
    }
    stockblister(value, oldValue) {
        this._blistercaja(value, oldValue);
    }
}

/*

// portar calculo stock/calculostock2, calculopreciocompra, calculounidad2

// .calculounidad2
function func1 () {

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

}

// .calculopreciocompra
function func2 () {


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
}

// calculostock
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
*/

let debug_updaters;
$(function () {
    $('#update-product-modal, #record-product-modal').on('show.bs.modal', function (e) {

        const modalId = e.currentTarget.id;

        getInput = makeGetInput(modalId);

        const stockTotalInput = getInput('stocktotal');

        if (modalId === 'update-product-modal') {
            updaters = debug_updaters = new ExistingProductUpdaters(stockTotalInput);
            updaters.blistercaja(getInputValue('blistercaja')); // CargaProductos would set this with bad calculation
        } else {
            updaters = debug_updaters = new NewProductUpdaters(stockTotalInput);
        }

        for (const input of Array.from($(`#${modalId} input`)).map($)) {

            input.on('focus', function (e) { console.log('onFocus'); e.target.setAttribute('old-value', e.target.value) });

            input.on('keyup', function (e) { updaters.updateGuarded(e.target.name, e.target.value) });
        }
    });
});

