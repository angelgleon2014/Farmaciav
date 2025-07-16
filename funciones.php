<?php
require_once("class/class.php");
?>
<script type="text/javascript" src="assets/script/script2.js"></script>
<script src="assets/script/jscalendario.js"></script>
<script src="assets/script/autocompleto.js"></script>
<!-- Calendario -->

<?php
$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

$tra = new Login();
?>

<?php
############################# CARGAR USUARIOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaUsuarioModal']) && isset($_GET['codigo'])) {

    $reg = $tra->UsuariosPorId();
    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Cédula:</strong> <?php echo $reg[0]['cedula']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombres:</strong> <?php echo $reg[0]['nombres']; ?></td>
            </tr>
            <tr>
                <td><strong>Genero:</strong> <?php echo $reg[0]['genero']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Nacimiento:</strong> <?php echo $reg[0]['fnac']; ?></td>
            </tr>
            <tr>
                <td><strong>Lugar de Nacimiento:</strong> <?php echo $reg[0]['lugnac']; ?></td>
            </tr>
            <tr>
                <td><strong>Dirección Domiciliaria:</strong> <?php echo $reg[0]['direcdomic']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Celular:</strong> <?php echo $reg[0]['nrotelefono']; ?></td>
            </tr>
            <tr>
                <td><strong>Cargo: </strong> <?php echo $reg[0]['cargo']; ?></td>
            </tr>
            <tr>
                <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['email']; ?></td>
            </tr>
            <tr>
                <td><strong>Usuario: </strong> <?php echo $reg[0]['usuario']; ?></td>
            </tr>
            <tr>
                <td><strong>Nivel: </strong> <?php echo $reg[0]['nivel']; ?></td>
            </tr>
            <?php if ($reg[0]['nivel'] == "CAJERO") { ?>
                <tr>
                    <td><strong>C.I/RUC Sucursal: </strong> <?php echo $reg[0]['rucsucursal']; ?></td>
                </tr>
                <tr>
                    <td><strong>Razón Social: </strong> <?php echo $reg[0]['razonsocial']; ?></td>
                </tr>
                <tr>
                    <td><strong>Nº Teléfono de Sucursal:</strong> <?php echo $reg[0]['tlfsucursal']; ?></td>
                </tr>
                <tr>
                    <td><strong>Nº Celular de Sucursal:</strong> <?php echo $reg[0]['celsucursal']; ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td><strong>Status: </strong>
                    <?php echo $status = ($reg[0]['status'] == 'ACTIVO' ? "<span class='label label-success'><i class='fa fa-check'></i> " . $reg[0]['status'] . "</span>" : "<span class='label label-warning'><i class='fa fa-times'></i> " . $reg[0]['status'] . "</span>"); ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR USUARIOS EN VENTANA MODAL ############################
?>



<?php
############################# CARGAR SUCURSAL EN VENTANA MODAL ############################
if (isset($_GET['BuscaSucursalModal']) && isset($_GET['codsucursal'])) {

    $reg = $tra->SucursalPorId();
    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Nº de Sucursal:</strong> <?php echo $reg[0]['nrosucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>RUC/DNI de Responsable:</strong> <?php echo $reg[0]['cedresponsable']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombres de Responsable:</strong> <?php echo $reg[0]['nomresponsable']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Celular de Responsable:</strong> <?php echo $reg[0]['celresponsable']; ?></td>
            </tr>
            <tr>
                <td><strong>Ruc de Sucursal:</strong> <?php echo $reg[0]['rucsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>Razón Social:</strong> <?php echo $reg[0]['razonsocial']; ?></td>
            </tr>

            <tr>
                <td><strong>Nº de Teléfono de Sucursal:</strong> <?php echo $reg[0]['tlfsucursal']; ?></td>
            </tr>

            <tr>
                <td><strong>Nº de Celular de Sucursal:</strong> <?php echo $reg[0]['celsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>Email de Sucursal:</strong> <?php echo $reg[0]['emailsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>Dirección de Sucursal:</strong> <?php echo $reg[0]['direcsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Actividad:</strong> <?php echo $reg[0]['nroactividadsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº Inicio de Factura:</strong> <?php echo $reg[0]['nroiniciofactura']; ?></td>
            </tr>
            </tr>
            <tr>
                <td><strong>Fecha de Autorización:</strong>
                    <?php echo date("d-m-Y", strtotime($reg[0]['fechaautorsucursal'])); ?></td>
            </tr>
            <tr>
                <td><strong>IGV de Compras: </strong> <?php echo $reg[0]['ivacsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>IGV de Ventas: </strong> <?php echo $reg[0]['ivavsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento de Ventas: </strong> <?php echo $reg[0]['descsucursal']; ?></td>
            </tr>
            <tr>
                <td><strong>Lleva Contabilidad: </strong> <?php echo $reg[0]['llevacontabilidad']; ?></td>
            </tr>
            <tr>
                <td><strong>Simbolo de Precios: </strong> <?php echo $reg[0]['simbolo']; ?></td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR SUCURSAL EN VENTANA MODAL ############################
?>







<?php
############################# CARGAR LABORATORIOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaLaboratorioModal']) && isset($_GET['codlaboratorio'])) {

    $reg = $tra->LaboratoriosPorId();

    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Nº de Laboratorio:</strong> <?php echo $reg[0]['codlaboratorio']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Laboratorio:</strong> <?php echo $reg[0]['nomlaboratorio']; ?></td>
            </tr>
            <tr>
                <td><strong>Aplica Descuento %:</strong> <?php echo $reg[0]['aplicadescuento']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento %:</strong> <?php echo $reg[0]['desclaboratorio']; ?></td>
            </tr>
            <tr>
                <td><strong>Recarga de TDC:</strong> <?php echo $reg[0]['recargotc']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Registro:</strong> <?php echo date("d-m-Y", strtotime($reg[0]['fecharegistro'])); ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR LABORATORIOS EN VENTANA MODAL ############################
?>





<?php
############################# CARGAR PROVEEDOR EN VENTANA MODAL ############################
if (isset($_GET['BuscaProveedorModal']) && isset($_GET['codproveedor'])) {

    $reg = $tra->ProveedoresPorId();

    ?>

    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>RUC/DNI Proveedor:</strong> <?php echo $reg[0]['rucproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Proveedor:</strong> <?php echo $reg[0]['nomproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Dirección de Proveedor:</strong> <?php echo $reg[0]['direcproveedor']; ?></td>
            </tr>

            <tr>
                <td><strong>Nº de Teléfono de Proveedor:</strong> <?php echo $reg[0]['tlfproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Celular de Proveedor:</strong> <?php echo $reg[0]['celproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Email de Proveedor:</strong> <?php echo $reg[0]['emailproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Persona de Contacto:</strong> <?php echo $reg[0]['contactoproveedor']; ?></td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR PROVEEDOR EN VENTANA MODAL ############################
?>





<?php
############################# BUSQUEDA DE CLIENTES ############################
if (isset($_GET['BusquedaClientes']) && isset($_GET['buscacliente'])) {

    $busqueda = $_GET['buscacliente'];

    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-tasks"></i> Control de Clientes </h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div id="div1">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="tech-companies-1"
                                            class="table table-small-font table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>RUC/DNI</th>
                                                    <th>Nombres</th>
                                                    <th>N° de Teléfono</th>
                                                    <th>N° de Celular</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ci = new Login();
    $reg = $ci->BusquedaClientes();

    if ($reg == "") {

        echo "";

    } else {

        $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1" tabindex="0"><?php echo $a++; ?></td>
                                                            <td><?php echo $reg[$i]['nrocliente']; ?></td>
                                                            <td><?php echo $reg[$i]['cedcliente']; ?></td>
                                                            <td><?php echo $reg[$i]['nomcliente']; ?></td>
                                                            <td><?php echo $reg[$i]['tlfcliente']; ?></td>
                                                            <td><?php echo $reg[$i]['celcliente']; ?></td>
                                                            <td>

                                                                <a href="#" class="btn btn-success btn-xs" data-placement="left"
                                                                    title="Ver" data-original-title="" data-href="#"
                                                                    data-toggle="modal" data-target="#panel-modal"
                                                                    data-backdrop="static" data-keyboard="false"
                                                                    onClick="VerCliente('<?php echo base64_encode($reg[$i]["codcliente"]); ?>')"><i
                                                                        class="fa fa-search-plus"></i></a>

                                                                <a href="#" class="btn btn-primary btn-xs" title="Editar"
                                                                    data-toggle="modal" data-target="#myModal2"
                                                                    data-backdrop="static" data-keyboard="false"
                                                                    onClick="CargaCampos('<?php echo $reg[$i]["codcliente"]; ?>','<?php echo $reg[$i]["cedcliente"]; ?>','<?php echo $reg[$i]["nomcliente"]; ?>','<?php echo $reg[$i]["direccliente"]; ?>','<?php echo $reg[$i]["tlfcliente"]; ?>','<?php echo $reg[$i]["celcliente"]; ?>','<?php echo $reg[$i]["emailcliente"]; ?>','<?php echo $busqueda; ?>')"><i
                                                                        class="fa fa-pencil"></i></a>

                                                                <a class="btn btn-danger btn-xs" title="Eliminar"
                                                                    onClick="EliminarCliente('<?php echo base64_encode($reg[$i]["codcliente"]); ?>','<?php echo base64_encode("CLIENTES") ?>','<?php echo $busqueda ?>')"><i
                                                                        class="fa fa-trash-o"></i></a> </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div><br />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
        </div>
    <?php
    }
}
############################# BUSQUEDA DE CLIENTES ############################
?>


<?php
############################# CARGAR CLIENTES EN VENTANA MODAL ############################
if (isset($_GET['BuscaClienteModal']) && isset($_GET['codcliente'])) {

    $reg = $tra->ClientesPorId();

    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Nº de Cliente:</strong> <?php echo $reg[0]['nrocliente']; ?></td>
            </tr>
            <tr>
                <td><strong>RUC/DNI de Cliente:</strong> <?php echo $reg[0]['cedcliente']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Cliente:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
            </tr>
            <tr>
                <td><strong>Dirección de Cliente:</strong> <?php echo $reg[0]['direccliente']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Teléfono de Cliente:</strong> <?php echo $reg[0]['tlfcliente']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Celular de Cliente:</strong> <?php echo $reg[0]['celcliente']; ?></td>
            </tr>
            <tr>
                <td><strong>Email de Cliente:</strong> <?php echo $reg[0]['emailcliente']; ?></td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR CLIENTES EN VENTANA MODAL ############################
?>



<?php
############################# CARGAR CHOFER EN VENTANA MODAL ############################
if (isset($_GET['BuscaChoferModal']) && isset($_GET['codchofer'])) {

    $reg = $tra->TransportePorId();
    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>RUC/DNI:</strong> <?php echo $reg[0]['rucchofer']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombres:</strong> <?php echo $reg[0]['nomchofer']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Telefono:</strong> <?php echo $reg[0]['tlfchofer']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Bultos:</strong> <?php echo $reg[0]['numbultos']; ?></td>
            </tr>
            <tr>
                <td><strong>Ruta:</strong> <?php echo $reg[0]['ruta']; ?></td>
            </tr>
            <tr>
                <td><strong>Ciudad de Ruta:</strong> <?php echo $reg[0]['ciudadruta']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº Placa de Vehiculo:</strong> <?php echo $reg[0]['placavehiculo']; ?></td>
            </tr>
            <tr>
                <td><strong>Punto de Llegada:</strong> <?php echo $reg[0]['llegada']; ?></td>
            </tr>
            <tr>
                <td><strong>Motivo de Traslado:</strong> <?php echo $reg[0]['motivotraslado']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha Inicio de Transporte:</strong>
                    <?php echo date("d-m-Y", strtotime($reg[0]['iniciotransporte'])); ?></td>
            </tr>
            <tr>
                <td><strong>Fecha Fin de Transporte: </strong>
                    <?php echo date("d-m-Y", strtotime($reg[0]['fintransporte'])); ?></td>
            </tr>
            <tr>
                <td><strong>Status de Taransporte: </strong>
                    <?php echo $status = ($reg[0]['statuschofer'] == '0' ? "<span class='label label-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='label label-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR CHOFER EN VENTANA MODAL ############################
?>



<?php
############################# MUESTRA NUMERO DE CAJA ######################################
if (isset($_GET['muestracodigocaja'])) {

    $tra = new Login();
    ?>
    <input type="text" class="form-control" name="nrocaja" id="nrocaja" onKeyUp="this.value=this.value.toUpperCase();"
        autocomplete="off" placeholder="N° de Caja" <?php if (isset($reg[0]['nrocaja'])) { ?>
            value="<?php echo $reg[0]['nrocaja']; ?>" <?php } else { ?> value="<?php echo $reg = $tra->CodigoCaja(); ?>"
        <?php } ?> readonly="readonly">
<?php
}
############################# MUESTRA NUMERO DE CAJA ######################################
?>

<?php
############################# MUESTRA CODIGO DE SUCURSALES ###########################
if (isset($_GET['muestranumerosucursal'])) {

    $tra = new Login();
    ?>
    <input type="text" class="form-control" name="nrosucursal" id="nrosucursal"
        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Sucursal"
        <?php if (isset($reg[0]['nrosucursal'])) { ?> value="<?php echo $reg[0]['nrosucursal']; ?>" readonly="readonly"
        <?php } else { ?> value="<?php echo $reg = $tra->NumeroSucursal(); ?>" <?php } ?> tabindex="1" required=""
        aria-required="true">
<?php
}
############################# MUESTRA CODIGO DE SUCURSALES ###########################
?>





<?php
############################# BUSQUEDA DE PRODUCTOS ############################
if (isset($_GET['BusquedaProductos']) && isset($_GET['buscaproducto'])) {

    $busqueda = $_GET['buscaproducto'];

    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-tasks"></i> Control de Productos </h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div id="div">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="tech-companies-1"
                                            class="table table-small-font table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th>N°</th>
                                                    <th>Imagen</th>
                                                    <th>Producto</th>
                                                    <th>Laboratorio</th>
                                                    <th>Ubicación</th>
                                                    <th>PVP Unid</th>
                                                    <th>PVP Caja</th>
                                                    <th>Exist</th>
                                                    <?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Sucursal</th>
                                                    <?php } ?>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ci = new Login();
    $reg = $ci->BusquedaProductos();

    if ($reg == "") {

        echo "";

    } else {

        $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1" tabindex="0"><?php echo $a++; ?></td>
                                                            <td><a href="#" data-placement="left" title="Ver Imagen"
                                                                    data-original-title="" data-href="#" data-toggle="modal"
                                                                    data-target=".bs-example-modal-sm" data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    onClick="VerImagen('<?php echo base64_encode($reg[$i]["codproducto"]); ?>','<?php echo base64_encode($reg[$i]['codsucursal']) ?>')"><?php if (file_exists("fotos/" . $reg[$i]["codproducto"] . ".jpg")) {
                                                                        echo "<img src='fotos/" . $reg[$i]["codproducto"] . ".jpg?' class='img-rounded' style='margin:0px;' width='50' height='45'>";
                                                                    } else {
                                                                        echo "<img src='fotos/producto.png' class='img-rounded' style='margin:0px;' width='50' height='45'>";
                                                                    }
            ?></a></td>

                                                            <td><abbr
                                                                    title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " : " . $reg[$i]['nommedida'] . " " . $reg[$i]['nompresentacion']; ?></abbr>
                                                            </td>

                                                            <td><?php echo $reg[$i]['nomlaboratorio']; ?></td>
                                                            <td><?php echo $ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"]); ?>
                                                            </td>
                                                            <td><?php echo "<strong>" . $_SESSION["simbolo"] . "</strong>" . number_format($reg[$i]['precioventaunidad'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo "<strong>" . $_SESSION["simbolo"] . "</strong>" . number_format($reg[$i]['precioventacaja'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $reg[$i]['stocktotal']; ?></td>
                                                            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td>
                                                                    <?php echo $reg[$i]['razonsocial']; ?></td><?php } ?>
                                                            <td>
                                                                <a href="#" class="btn btn-success btn-xs"
                                                                    onClick="VerProducto('<?php echo base64_encode($reg[$i]['codproducto']) ?>','<?php echo base64_encode($reg[$i]['codsucursal']) ?>')"
                                                                    data-href="#" data-toggle="modal"
                                                                    data-target=".bs-example-modal-lgg" data-placement="left"
                                                                    data-backdrop="static" data-keyboard="false" data-id=""
                                                                    rel="tooltip" data-original-title="Ver Producto"
                                                                    title="Ver Producto"><i class="fa fa-search-plus"></i></a>


                                                                <a class="btn btn-primary btn-xs" title="Editar" data-toggle="modal"
                                                                    data-target="#update-product-modal" data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    onClick="CargaProductos('<?php echo $reg[$i]["codalmacen"]; ?>',
                                                        '<?php echo $reg[$i]["codproducto"]; ?>',
                                                        '<?php echo $reg[$i]["producto"]; ?>',
                                                        '<?php echo $reg[$i]["principioactivo"]; ?>',
                                                        '<?php echo $reg[$i]["descripcion"]; ?>',
                                                        '<?php echo $reg[$i]["codpresentacion"]; ?>',
                                                        '<?php echo $reg[$i]["codmedida"]; ?>',
                                                        '<?php echo $reg[$i]["preciocompra"]; ?>',
                                                        '<?php echo $reg[$i]["precioventacaja"]; ?>',
                                                        '<?php echo $reg[$i]["precioventaunidad"]; ?>',
                                                        '<?php echo $reg[$i]["stockcajas"]; ?>',
                                                        '<?php echo $reg[$i]["unidades"]; ?>',
                                                        '<?php echo $reg[$i]["stockunidad"]; ?>',
                                                        '<?php echo $reg[$i]["stocktotal"]; ?>',
                                                        '<?php echo $reg[$i]["stockminimo"]; ?>',
                                                        '<?php echo $reg[$i]["ivaproducto"]; ?>',
                                                        '<?php echo $reg[$i]["descproducto"]; ?>',
                                                        '<?php echo date("d-m-Y", strtotime($reg[$i]["fechaelaboracion"])); ?>',
                                                        '<?php echo date("d-m-Y", strtotime($reg[$i]["fechaexpiracion"])); ?>',
                                                        '<?php echo $reg[$i]["codigobarra"]; ?>',
                                                        '<?php echo $reg[$i]["codlaboratorio"]; ?>',
                                                        '<?php echo $reg[$i]["codproveedor"]; ?>',
                                                        '<?php echo $reg[$i]["codsucursal"]; ?>',
                                                        '<?php echo $reg[$i]["loteproducto"]; ?>',
                                                        '<?php echo $reg[$i]["ubicacion"]; ?>',
                                                        '<?php echo $reg[$i]["statusp"]; ?>',
                                                        '<?php echo $busqueda; ?>',

                                                        '<?php echo $reg[$i]["precioventablister"]; ?>',
                                                        '<?php echo $reg[$i]["blisterunidad"]; ?>',
                                                        '<?php echo $reg[$i]["stockblister"]; ?>',
                                                        '<?php echo $reg[$i]["preciocompraunidad"]; ?>',
                                                        '<?php echo $reg[$i]["preciocomprablister"]; ?>',
                                                         '<?php echo $reg[$i]["registrosanitario"]; ?>',
                                                         '<?php echo $reg[$i]["blistercaja"]; ?>',
                                                         '<?php echo $reg[$i]["precioventablisterdesc"]; ?>',
                                                         '<?php echo $reg[$i]["precioventacajadesc"]; ?>',
                                                         '<?php echo $reg[$i]["precioventaunidaddesc"]; ?>',
                                                         true)">
                                                                    <i class="fa fa-pencil"></i></a>
                                                                <a class="btn btn-danger btn-xs" title="Eliminar"
                                                                    onClick="EliminarProducto('<?php echo base64_encode($reg[$i]["codproducto"]); ?>','<?php echo base64_encode($reg[$i]["codsucursal"]); ?>','<?php echo base64_encode("PRODUCTOS") ?>','<?php echo $busqueda ?>')"><i
                                                                        class="fa fa-trash-o"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
        </div>
        <?php

    }
}
############################# BUSQUEDA DE PRODUCTOS ############################
?>


<?php
############################# MUESTRA NUMERO DE PRODUCTOS #############################
if (isset($_GET['muestranroproducto'])) {

    $tra = new Login();
    ?>
    <input type="hidden" name="codproceso" id="codproceso" value="<?php echo GenerateRandomString(); ?>">
<?php
}
############################# MUESTRA NUMERO DE PRODUCTOS #############################
?>

<?php
############################# MUESTRA CODIGO DE PRODUCTOS ################################
if (isset($_GET['muestracodigoproducto'])) {

    $tra = new Login();
    ?>
    <input type="text" class="form-control" name="codproducto" id="codproducto"
        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Producto"
        <?php if (isset($reg[0]['codproducto'])) { ?> value="<?php echo $reg[0]['codproducto']; ?>" readonly="readonly"
        <?php } else { ?> value="<?php echo $reg = $tra->CodigoProducto(); ?>" <?php } ?> tabindex="1" required=""
        aria-required="true">
<?php
}
############################# MUESTRA CODIGO DE PRODUCTOS ################################
?>


<?php
############################# CARGAR PRODUCTOS2 EN VENTANA MODAL ############################
if (isset($_GET['BuscaProductoModal2']) && isset($_GET['codproducto'])) {

    $codproducto = $_GET['codproducto'];

    $reg = $tra->DetalleProductosPorId();
    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Código de Producto: </strong><?php echo $reg[0]['codproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
            </tr>
            <tr>
                <td><strong>Principio Activo: </strong> <?php echo $reg[0]['principioactivo']; ?></td>
            </tr>
            <tr>
                <td><strong>Descripción de Producto: </strong> <?php echo $reg[0]['descripcion']; ?></td>
            </tr>
            <tr>
                <td><strong>Presentación de Producto: </strong> <?php echo $reg[0]['nompresentacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidad de Medida: </strong> <?php echo $reg[0]['nommedida']; ?></td>
            </tr>
            <tr>
                <td><strong>Laboratorio: </strong> <?php echo $reg[0]['nomlaboratorio']; ?></td>
            </tr>

            <tr>
                <td><strong>Proveedor: </strong> <?php echo $reg[0]['nomproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Lote: </strong> <?php echo $reg[0]['loteproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Ubicación en Estanteria: </strong> <?php echo $reg[0]['ubicacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta Unidad: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventaunidad'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta Caja: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventacaja'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta Blister Descuento: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventablisterdesc'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta Caja Descuento: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventacajadesc'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta unidad Descuento: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventaunidaddesc'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Stock por Cajas: </strong> <?php echo $reg[0]['stockcajas']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidades: </strong> <?php echo $reg[0]['unidades']; ?></td>
            </tr>
            <tr>
                <td><strong>Stock por Unidad: </strong> <?php echo $reg[0]['stockunidad']; ?></td>
            </tr>
            <tr>
                <td><strong>Stock Total: </strong> <?php echo $reg[0]['stocktotal']; ?></td>
            </tr>
            <tr>
                <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento: </strong> <?php echo $reg[0]['descproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Tiene IGV: </strong> <?php echo $reg[0]['ivaproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Elaboracion: </strong>
                    <?php echo date("d-m-Y", strtotime($reg[0]['fechaelaboracion'])); ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Expiracion: </strong>
                    <?php echo date("d-m-Y", strtotime($reg[0]['fechaexpiracion'])); ?></td>
            </tr>
            <tr>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong>Sucursal: </strong>
                        <?php echo $reg[0]['razonsocial']; ?></td><?php } ?>
            </tr>
            <tr>
                <td><strong>Status: </strong>
                    <?php echo $status = ($reg[0]['statusp'] == '0' ? "<span class='label label-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='label label-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?>
                </td>
            </tr>
        </table>
    </div>
    <hr />


    <?php
}

############################# CARGAR PRODUCTOS2 EN VENTANA MODAL ############################
?>

<?php
############################# CARGAR PRODUCTOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaProductoModal']) && isset($_GET['codproducto'])) {

    $codproducto = $_GET['codproducto'];

    $reg = $tra->DetalleProductosPorId();
    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>sCódigo de Producto: </strong><?php echo $reg[0]['codproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
            </tr>
            <tr>
                <td><strong>Principio Activo: </strong> <?php echo $reg[0]['principioactivo']; ?></td>
            </tr>
            <tr>
                <td><strong>Descripción de Producto: </strong> <?php echo $reg[0]['descripcion']; ?></td>
            </tr>
            <tr>
                <td><strong>Presentación de Producto: </strong> <?php echo $reg[0]['nompresentacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidad de Medida: </strong> <?php echo $reg[0]['nommedida']; ?></td>
            </tr>
            <tr>
                <td><strong>Laboratorio: </strong> <?php echo $reg[0]['nomlaboratorio']; ?></td>
            </tr>

            <tr>
                <td><strong>Proveedor: </strong> <?php echo $reg[0]['nomproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Nº de Lote: </strong> <?php echo $reg[0]['loteproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Ubicación en Estanteria: </strong> <?php echo $reg[0]['ubicacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta Unidad: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventaunidad'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta Caja: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventacaja'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Stock por Cajas: </strong> <?php echo $reg[0]['stockcajas']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidades: </strong> <?php echo $reg[0]['unidades']; ?></td>
            </tr>
            <tr>
                <td><strong>Stock por Unidad: </strong> <?php echo $reg[0]['stockunidad']; ?></td>
            </tr>
            <tr>
                <td><strong>Stock Total: </strong> <?php echo $reg[0]['stocktotal']; ?></td>
            </tr>
            <tr>
                <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento: </strong> <?php echo $reg[0]['descproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Tiene IGV: </strong> <?php echo $reg[0]['ivaproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Elaboracion: </strong>
                    <?php echo date("d-m-Y", strtotime($reg[0]['fechaelaboracion'])); ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Expiracion: </strong>
                    <?php echo date("d-m-Y", strtotime($reg[0]['fechaexpiracion'])); ?></td>
            </tr>
            <tr>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong>Sucursal: </strong>
                        <?php echo $reg[0]['razonsocial']; ?></td><?php } ?>
            </tr>
            <tr>
                <td><strong>Status: </strong>
                    <?php echo $status = ($reg[0]['statusp'] == '0' ? "<span class='label label-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='label label-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?>
                </td>
            </tr>
        </table>
    </div>
    <hr />

    <div id="div1">
        <div class="table-responsive" data-pattern="priority-columns">
            <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="9" data-priority="1">
                            <center>Movimientos del Producto</center>
                        </th>
                    </tr>
                    <tr>
                        <!--<th data-priority="2">Laboratorio</th>
                              <th data-priority="2">Provedor</th>
                              <th data-priority="2">Sucursal</th>--->
                    <th data-priority="3">Movimiento</th>
                    <th data-priority="4">Ent</th>
                    <th data-priority="3">Sal</th>
                    <th data-priority="3">Dev</th>
                    <th data-priority="2">Costo Unidad</th>
                    <th data-priority="2">Costo Caja</th>
                    <th data-priority="3">Costo Mov. Unidad</th>
                    <th data-priority="3">Costo Mov. Caja</th>
                    <th data-priority="5">Stock x Cajas</th>
                    <th data-priority="5">Stock x Unidad</th>
                    <th data-priority="3">Fecha</th>
                    <th data-priority="3">Documento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tru = new Login();
    $busq = $tru->VerDetallesKardexProducto();

    if (sizeof($busq) > 0) {

        for ($i = 0; $i < sizeof($busq); $i++) {

            ?>
                <tr>
                    <!--<td><?php echo $busq[$i]["laboratorio"]; ?></td>
          <td><?php if ($busq[$i]["codresponsable"] == "0") {
              echo "INVENTARIO INICIAL";
          } elseif ($busq[$i]["movimiento"] == "ENTRADAS") {
              echo $busq[$i]["proveedor"];
          } elseif ($busq[$i]["movimiento"] == "SALIDAS") {
              echo $busq[$i]["clientes"];
          } ?></td>
                                <td><?php echo $busq[$i]["razonsocial"]; ?></td>-->

                                <td><?php echo $busq[$i]["movimiento"]; ?></td>



                                <td><?php echo $entradas = ($busq[$i]['entradabonif'] == '0' ? $busq[$i]['entradacaja'] : $busq[$i]['entradacaja'] . "+" . $busq[$i]['entradabonif']); ?>
                                </td>

                                <td><?php echo $salidas = ($busq[$i]['salidabonif'] == '0' ? $busq[$i]['salidaunidad'] : $busq[$i]['salidaunidad'] . "+" . $busq[$i]['salidabonif']); ?>
                                </td>

                                <td><?php echo $devolucion = ($busq[$i]['devolucionbonif'] == '0' ? $busq[$i]['devolucionunidad'] : $busq[$i]['devolucionunidad'] . "+" . $busq[$i]['devolucionbonif']); ?>
                                </td>



                                <td><?php echo $simbolo . number_format($busq[$i]['precioventaunidadm'], 2, '.', ','); ?></td>

                                <td><?php echo $simbolo . number_format($busq[$i]['precioventacajam'], 2, '.', ','); ?></td>



                                <?php if ($busq[$i]["movimiento"] == "ENTRADAS") { ?>

                                    <td><?php echo $simbolo . number_format($busq[$i]['precioventaunidadm'] * $busq[$i]['entradaunidad'], 2, '.', ','); ?>
                                    </td>

                                    <td><?php echo $simbolo . number_format($busq[$i]['entradacaja'] * $busq[$i]['entradaunidad'], 2, '.', ','); ?>
                                    </td>

                                <?php } elseif ($busq[$i]["movimiento"] == "SALIDAS") { ?>

                                    <td><?php echo $simbolo . number_format($busq[$i]['precioventaunidadm'] * $busq[$i]['salidaunidad'], 2, '.', ','); ?>
                                    </td>

                                    <td><?php echo $simbolo . number_format($busq[$i]['salidacaja'] * $busq[$i]['salidaunidad'], 2, '.', ','); ?>
                                    </td>

                                <?php } else { ?>

                                    <td><?php echo $simbolo . number_format($busq[$i]['precioventaunidadm'] * $busq[$i]['devolucionunidad'], 2, '.', ','); ?>
                                    </td>

                                    <td><?php echo $simbolo . number_format($busq[$i]['devolucioncaja'] * $busq[$i]['devolucionunidad'], 2, '.', ','); ?>
                                    </td>

                                <?php } ?>



                                <td><?php echo $busq[$i]['stocktotalcaja']; ?></td>
                                <td><?php echo $busq[$i]['stocktotalunidad']; ?></td>
                                <td><?php echo $busq[$i]["fechakardex"]; ?></td>
                                <td><?php echo $busq[$i]["documento"]; ?></td>
                            </tr>
                        <?php
        }
    }

    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
############################# CARGAR PRODUCTOS EN VENTANA MODAL ############################
?>



<?php
############################# CARGAR FOTO DE PRODUCTO EN VENTANA MODAL ############################
if (isset($_GET['BuscaFotoProductoModal']) && isset($_GET['codproducto'])) {

    $codproducto = $_GET['codproducto'];

    $reg = $tra->DetalleProductosPorId();
    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Foto del Producto</strong>
                    <div align="center"><?php
                    if (isset($reg[0]['codproducto'])) {
                        if (file_exists("fotos/" . $reg[0]['codproducto'] . ".jpg")) {
                            echo "<img src='fotos/" . $reg[0]['codproducto'] . ".jpg?" . date('h:i:s') . "' border='0' width='100' height='120' title='" . $reg[0]['producto'] . "' data-rel='tooltip'>";
                        } else {
                            echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>";
                        }
                    } else {
                        echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>";
                    }
    ?><br /><strong>Código de Barra</strong><br /><strong><?php  //Mostramos la imagen
        echo "<img src='codigoBarras_img.php?numero=" . $reg[0]['codigobarra'] . "' title='Codigo de Barra'>"; ?></strong>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR FOTO DE PRODUCTO EN VENTANA MODAL ############################
?>



<?php
############################# CARGAR KARDEX EN VENTANA MODAL ############################
if (isset($_GET['BuscaDetalleKardexModal']) && isset($_GET['codkardex'])) {

    $reg = $tra->VerDetalleKardexModal();

    ?>

    <div class="row">
        <table border="0" align="center">


            <?php if ($reg[0]["codresponsable"] == "0" && $reg[0]["movimiento"] == "ENTRADAS") { ?>
                <tr>
                    <td><strong>Proveedor: </strong><?php echo "INVENTARIO INICIAL"; ?></td>
                </tr>

            <?php } elseif ($reg[0]["codresponsable"] != "0" && $reg[0]["movimiento"] == "ENTRADAS") { ?>
                <tr>
                    <td><strong>Proveedor: </strong><?php echo $reg[0]["proveedor"]; ?></td>
                </tr>

            <?php } elseif ($reg[0]["codresponsable"] == "0" && $reg[0]["movimiento"] == "SALIDAS") { ?>
                <tr>
                    <td><strong>Cliente: </strong><?php echo "CONSUMIDOR FINAL"; ?></td>
                </tr>

            <?php } elseif ($reg[0]["codresponsable"] != "0" && $reg[0]["movimiento"] == "SALIDAS") { ?>
                <tr>
                    <td><strong>Cliente: </strong><?php echo $reg[0]["clientes"]; ?></td>
                </tr>

            <?php } elseif ($reg[0]["movimiento"] == "DEVOLUCION") { ?>
                <tr>
                    <td><strong>Responsable: </strong><?php echo "DEVOLUCIÓN"; ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td><strong>Código de Producto: </strong><?php echo $reg[0]['codproductom']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
            </tr>
            <tr>
                <td><strong>Principio Activo: </strong> <?php echo $reg[0]['principioactivo']; ?></td>
            </tr>
            <tr>
                <td><strong>Descripción de Producto: </strong> <?php echo $reg[0]['descripcion']; ?></td>
            </tr>
            <tr>
                <td><strong>Presentación de Producto: </strong> <?php echo $reg[0]['nompresentacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidad de Medida: </strong> <?php echo $reg[0]['nommedida']; ?></td>
            </tr>
            <tr>
                <td><strong>Sucursal: </strong> <?php echo $reg[0]['razonsocial']; ?></td>
            </tr>
            <tr>
                <td><strong>Movimiento: </strong> <?php echo $reg[0]['movimiento']; ?></td>
            </tr>
            <tr>
                <td><strong>Entradas: </strong>
                    <?php echo $entradas = ($reg[0]['entradabonif'] == '0' ? $reg[0]['entradacaja'] : $reg[0]['entradacaja'] . "+" . $reg[0]['entradabonif']); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Salidas: </strong>
                    <?php echo $salidas = ($reg[0]['salidabonif'] == '0' ? $reg[0]['salidaunidad'] : $reg[0]['salidaunidad'] . "+" . $reg[0]['salidabonif']); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Devolución: </strong>
                    <?php echo $devolucion = ($reg[0]['devolucionbonif'] == '0' ? $reg[0]['devolucionunidad'] : $reg[0]['devolucionunidad'] . "+" . $reg[0]['devolucionbonif']); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Stock Actual: </strong> <?php echo $reg[0]['stocktotalunidad']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento: </strong> <?php echo $reg[0]['descproductom']; ?></td>
            </tr>
            <tr>
                <td><strong>Tiene IGV: </strong> <?php echo $reg[0]['ivaproductom']; ?></td>
            </tr>

            <?php if ($reg[0]['movimiento'] == "ENTRADAS") {
                $entradas = ($reg[0]['entradabonif'] == '0' ? $reg[0]['entradacaja'] : $reg[0]['entradacaja'] . "+" . $reg[0]['entradabonif']); ?>
                <tr>
                    <td><strong>Precio Unidad: </strong>
                        <?php echo $simbolo . number_format($reg[0]['precioventaunidadm'] * $entradas, 2, '.', ','); ?></td>
                </tr>
                <tr>
                    <td><strong>Precio Caja: </strong>
                        <?php echo $simbolo . number_format($reg[0]['precioventacajam'] * $entradas, 2, '.', ','); ?></td>
                </tr>
            <?php } elseif ($reg[0]['movimiento'] == "SALIDAS") {
                $salidas = ($reg[0]['salidabonif'] == '0' ? $reg[0]['salidaunidad'] : $reg[0]['salidaunidad'] . "+" . $reg[0]['salidabonif']); ?>

                <tr>
                    <td><strong>Precio Unidad: </strong>
                        <?php echo $simbolo . number_format($reg[0]['precioventaunidadm'] * $salidas, 2, '.', ','); ?></td>
                </tr>
                <tr>
                    <td><strong>Precio Caja: </strong>
                        <?php echo $simbolo . number_format($reg[0]['precioventacajam'] * $salidas, 2, '.', ','); ?></td>
                </tr>

            <?php } elseif ($reg[0]['movimiento'] == "DEVOLUCION") {
                $devolucion = ($reg[0]['devolucionbonif'] == '0' ? $reg[0]['devolucionunidad'] : $reg[0]['devolucionunidad'] . "+" . $reg[0]['devolucionbonif']); ?>

                    <tr>
                        <td><strong>Precio Unidad: </strong>
                        <?php echo $simbolo . number_format($reg[0]['precioventaunidadm'] * $devolucion, 2, '.', ','); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Precio Caja: </strong>
                        <?php echo $simbolo . number_format($reg[0]['precioventacajam'] * $devolucion, 2, '.', ','); ?></td>
                    </tr>

            <?php } ?>
            <tr>
                <td><strong>Costo Total Unidad: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventaunidadm'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Costo Total Caja: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventacajam'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Documento: </strong> <?php echo $reg[0]['documento']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Movimiento: </strong> <?php echo date("d-m-Y", strtotime($reg[0]['fechakardex'])); ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR KARDEX EN VENTANA MODAL ############################
?>





<?php
############################# CARGAR ARQUEO DE CAJA EN VENTANA MODAL ############################
if (isset($_GET['BuscaArqueoCajaModal']) && isset($_GET['codarqueo'])) {

    $reg = $tra->ArqueoCajaPorId();

    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Nº de Caja:</strong> <?php echo $reg[0]['nrocaja']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nombrecaja']; ?></td>
            </tr>
            <tr>
                <td><strong>Monto Inicial:</strong> <?php echo number_format($reg[0]['montoinicial'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Ingresos:</strong> <?php echo $simbolo . number_format($reg[0]['ingresos'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Egresos:</strong> <?php echo $simbolo . number_format($reg[0]['egresos'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Dinero en Efectivo:</strong>
                    <?php echo $simbolo . number_format($reg[0]['dineroefectivo'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Diferencia:</strong> <?php echo $simbolo . number_format($reg[0]['diferencia'], 2, '.', ','); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Comentario:</strong>
                    <?php if ($reg[0]['comentarios'] == "") {
                        echo "SIN COMENTARIOS";
                    } else {
                        echo $reg[0]['comentarios'];
                    } ?>
                </td>
            </tr>
            <tr>
                <td><strong>Hora Apertura:</strong> <?php echo date("d-m-Y h:i:s", strtotime($reg[0]['fechaapertura'])); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Hora Cierre:</strong>
                    <?php echo $cierre = ($reg[0]['statusarqueo'] == '1' ? $reg[0]['fechacierre'] : date("d-m-Y h:i:s", strtotime($reg[0]['fechacierre']))); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Responsable:</strong> <?php echo $reg[0]['nombres']; ?></td>
            </tr>
        </table>
    </div>

    <?php
}
############################# CARGAR ARQUEO DE CAJA EN VENTANA MODAL ############################
?>


<?php
############################# CARGAR MOVIMIENTO EN VENTANA MODAL ############################
if (isset($_GET['BuscaMovimientoCajaModal']) && isset($_GET['codmovimientocaja'])) {

    $reg = $tra->MovimientoCajasPorId();

    ?>

    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Tipo de Movimiento:</strong> <?php echo $reg[0]['tipomovimientocaja']; ?></td>
            </tr>
            <tr>
                <td><strong>Monto de Movimiento:</strong>
                    <?php echo $simbolo . number_format($reg[0]['montomovimientocaja'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Medio de Pago:</strong> <?php echo $reg[0]['mediopago']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nombrecaja']; ?></td>
            </tr>
            <tr>
                <td><strong>Descripción de Movimiento:</strong> <?php echo $reg[0]['descripcionmovimientocaja']; ?></td>
            </tr>
            <tr>
                <td><strong>Persona de Contacto:</strong>
                    <?php echo date("d-m-Y h:i:s", strtotime($reg[0]['fechamovimientocaja'])); ?></td>
            </tr>
            <tr>
                <td><strong>Persona que Registro:</strong> <?php echo $reg[0]['nombres']; ?></td>
            </tr>
        </table>
    </div>

    <?php
}
############################# CARGAR MOVIMIENTO EN VENTANA MODAL ############################
?>










<?php
############################# BUSQUEDA DE PRODUCTOS POR SUCURSALES ###############################
if (isset($_GET['BuscaProductosSucursal']) && isset($_GET['codsucursal'])) {

    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $ve = new Login();
        $reg = $ve->BuscarProductosSucursal();

        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks"></i> Productos de Sucursal <?php echo $reg[0]['razonsocial']; ?>
                </h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div1">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="tech-companies-1"
                                                class="table table-small-font table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nº</th>
                                                        <th>Descripción de Producto</th>
                                                        <th>Presentación</th>
                                                        <th>Laboratorio</th>
                                                        <th>Ubicación</th>
                                                        <th>Precio Caja</th>
                                                        <th>Precio Unidad</th>
                                                        <th>Descuento</th>
                                                        <th>Stock Actual</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                        <tr>
                                                            <td><?php echo $a++; ?></td>
                                                            <td><abbr
                                                                    title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                            <td><?php echo getSubString($reg[$i]["nomlaboratorio"], 12); ?></td>
                                                            <td><?php echo $ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"]); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventacaja'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventaunidad'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $reg[$i]["descproducto"]; ?></td>
                                                            <td><?php echo $reg[$i]['stocktotal']; ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div align="center"><a
                                                    href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("PRODUCTOSXSUCURSAL") ?>"
                                                    target="_blank" rel="noopener noreferrer"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                <a
                                                    href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("PRODUCTOSXSUCURSAL") ?>"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                            </div><br />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
}
############################# BUSQUEDA DE PRODUCTOS POR SUCURSALES ###############################
?>


<?php
############################# BUSQUEDA DE PRODUCTOS POR LABORATORIOS ###############################
if (isset($_GET['BuscaProductosLaboratorios']) && isset($_GET['codsucursal']) && isset($_GET['codlaboratorio'])) {

    $codsucursal = $_GET['codsucursal'];
    $codlaboratorio = $_GET['codlaboratorio'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($codlaboratorio == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE LABORATORIO PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $ve = new Login();
        $reg = $ve->BuscarProductosLaboratorios();

        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks"></i> Productos de Sucursal <?php echo $reg[0]['razonsocial']; ?>
                    y Laboratorio <?php echo $reg[0]['nomlaboratorio']; ?></h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div1">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="tech-companies-1"
                                                class="table table-small-font table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nº</th>
                                                        <th>Descripción de Producto</th>
                                                        <th>Presentación</th>
                                                        <th>Ubicación</th>
                                                        <th>Precio Caja</th>
                                                        <th>Precio Unidad</th>
                                                        <th>Descuento</th>
                                                        <th>Stock Actual</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                        <tr>
                                                            <td><?php echo $a++; ?></td>
                                                            <td><abbr
                                                                    title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                            <td><?php echo $ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"]); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventacaja'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventaunidad'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $reg[$i]["descproducto"]; ?></td>
                                                            <td><?php echo $reg[$i]['stocktotal']; ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div align="center"><a
                                                    href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codlaboratorio=<?php echo $codlaboratorio; ?>&tipo=<?php echo base64_encode("PRODUCTOSXLABORATORIO") ?>"
                                                    target="_blank" rel="noopener noreferrer"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                <a
                                                    href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codlaboratorio=<?php echo $codlaboratorio; ?>&tipo=<?php echo base64_encode("PRODUCTOSXLABORATORIO") ?>"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                            </div><br />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
############################# BUSQUEDA DE PRODUCTOS POR LABORATORIOS ###############################
?>

<?php
############################# BUSQUEDA DE PRODUCTOS EN STOCK MINIMO ###############################
if (isset($_GET['BuscaProductosStock']) && isset($_GET['codsucursal'])) {

    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $ve = new Login();
        $reg = $ve->BuscarProductosStockMinimo();

        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks"></i> Productos de Sucursal <?php echo $reg[0]['razonsocial']; ?>
                </h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div1">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="tech-companies-1"
                                                class="table table-small-font table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nº</th>
                                                        <th>Descripción de Producto</th>
                                                        <th>Presentación</th>
                                                        <th>Laboratorio</th>
                                                        <th>Ubicación</th>
                                                        <th>Precio Caja</th>
                                                        <th>Precio Unidad</th>
                                                        <th>Stock Actual</th>
                                                        <th>Stock Minimo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                        <tr>
                                                            <td><?php echo $a++; ?></td>
                                                            <td><abbr
                                                                    title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                            <td><?php echo getSubString($reg[$i]["nomlaboratorio"], 12); ?></td>
                                                            <td><?php echo $ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"]); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventacaja'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventaunidad'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $reg[$i]['stocktotal']; ?></td>
                                                            <td><?php echo $reg[$i]["stockminimo"]; ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div align="center"><a
                                                    href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("PRODUCTOSSTOCK") ?>"
                                                    target="_blank" rel="noopener noreferrer"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                <a
                                                    href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("PRODUCTOSSTOCK") ?>"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                            </div><br />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
}
############################# BUSQUEDA DE PRODUCTOS EN STOCK MINIMO ###############################
?>

<?php
############################# BUSQUEDA DE PRODUCTOS VENCIDOS POR FECHAS #####################
if (isset($_GET['BuscaProductosVencidos']) && isset($_GET['codsucursal']) && isset($_GET['tiempovence'])) {

    $codsucursal = $_GET['codsucursal'];
    $tiempovence = $_GET['tiempovence'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($tiempovence == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE BÚSQUEDA</div></center>";
        exit;

    } else {

        $ve = new Login();
        $reg = $ve->BuscarProductosVencidos();

        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks"></i> Productos Vencidos</h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div1">
                                        <div class="" data-pattern="priority-columns" >
                                            <table id="tech-companies-1"
                                                class="table table-small-font table-bordered table-responsive" style="overflow-x: auto; width=100%; white-space: nowrap;">
                                                <thead>
                                                    <tr>
                                                        <th>Nº</th>
                                                        <th>Descripción de Producto</th>
                                                        <th>Presentación</th>
                                                        <th>Laboratorio</th>
                                                        <th>Ubicación</th>
                                                        <th>PVP Caja</th>
                                                        <th>PVP unidad</th>
                                                        <th>Fecha Expiración</th>
                                                        <th>Stock Actual</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                        <tr>
                                                            <td><?php echo $a++; ?></td>
                                                            <td><abbr
                                                                    title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                            <td><?php echo getSubString($reg[$i]["nomlaboratorio"], 12); ?></td>
                                                            <td><?php echo $ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"]); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventacaja'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['precioventaunidad'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $reg[$i]["fechaexpiracion"]; ?></td>
                                                            <td><?php echo $reg[$i]['stocktotal']; ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div align="center"><a
                                                    href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tiempovence=<?php echo $tiempovence; ?>&tipo=<?php echo base64_encode("PRODUCTOSVENCIDOS") ?>"
                                                    target="_blank" rel="noopener noreferrer"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                <a
                                                    href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tiempovence=<?php echo $tiempovence; ?>&tipo=<?php echo base64_encode("PRODUCTOSVENCIDOS") ?>"><button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                            </div><br />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
}
############################# BUSQUEDA DE PRODUCTOS VENCIDOS POR FECHAS #########################
?>



<?php
############################# BUSQUEDA KARDEX POR PRODUCTOS ###############################
if (isset($_GET['BuscaKardexProducto']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) {

    $codproducto = $_GET['codproducto'];
    $codsucursal = $_GET['codsucursal'];

    if ($codproducto == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE</div></center>";
        exit;

    } elseif ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $kardex = new Login();
        $kardex = $kardex->BuscarKardexProducto();

        ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-tasks"></i> Movimientos del Producto
                    <?php echo "<strong><font color='red'> " . $kardex[0]['producto'] . " - " . $kardex[0]['principioactivo'] . "</font color></strong>"; ?>
                    </h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div id="div1">
                                            <div class="table-responsive" data-pattern="priority-columns">
                                                <table id="tech-companies-1"
                                                    class="table table-small-font table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº</th>
                                                            <th>Movimiento</th>
                                                            <th>Entradas</th>
                                                            <th>Salidas</th>
                                                            <th>Devolución</th>
                                                            <th>Precio Caja</th>
                                                            <th>Precio Unidad</th>
                                                            <th>Stock Actual</th>
                                                            <th>Documento</th>
                                                            <th>Fecha</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $TotalEntradas = 0;
        $TotalSalidas = 0;
        $TotalDevolucion = 0;
        $a = 1;
        for ($i = 0; $i < sizeof($kardex); $i++) {
            $TotalEntradas += $entradas = ($kardex[$i]['entradabonif'] == '0' ? $kardex[$i]['entradacaja'] : $kardex[$i]['entradacaja'] . "+" . $kardex[$i]['entradabonif']);
            $TotalSalidas += $salidas = ($kardex[$i]['salidabonif'] == '0' ? $kardex[$i]['salidaunidad'] : $kardex[$i]['salidaunidad'] . "+" . $kardex[$i]['salidabonif']);
            $TotalDevolucion += $devolucion = ($kardex[$i]['devolucionbonif'] == '0' ? $kardex[$i]['devolucionunidad'] : $kardex[$i]['devolucionunidad'] . "+" . $kardex[$i]['devolucionbonif']);
            ?>
                                                            <tr>
                                                                <td><?php echo $a++; ?></td>
                                                                <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                                                <td><?php echo $entradas = ($kardex[$i]['entradabonif'] == '0' ? $kardex[$i]['entradacaja'] : $kardex[$i]['entradacaja'] . "+" . $kardex[$i]['entradabonif']); ?>
                                                                </td>

                                                                <td><?php echo $salidas = ($kardex[$i]['salidabonif'] == '0' ? $kardex[$i]['salidaunidad'] : $kardex[$i]['salidaunidad'] . "+" . $kardex[$i]['salidabonif']); ?>
                                                                </td>

                                                                <td><?php echo $devolucion = ($kardex[$i]['devolucionbonif'] == '0' ? $kardex[$i]['devolucionunidad'] : $kardex[$i]['devolucionunidad'] . "+" . $kardex[$i]['devolucionbonif']); ?>
                                                                </td>

                                                                <td><?php echo $simbolo . number_format($kardex[$i]['precioventaunidadm'], 2, '.', ','); ?>
                                                                </td>

                                                                <td><?php echo $simbolo . number_format($kardex[$i]['precioventacajam'], 2, '.', ','); ?>
                                                                </td>

                                                                <td><?php echo $kardex[$i]['stocktotalunidad']; ?></td>
                                                                <td><?php echo $kardex[$i]['documento']; ?></td>
                                                                <td><?php echo date("d-m-Y", strtotime($kardex[$i]['fechakardex'])); ?>
                                                                </td>
                                                            </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <strong>Detalles de Producto</strong><br>
                                                <strong>Código : <?php echo $kardex[0]['codproducto']; ?></strong><br>
                                                <strong>Producto :
                                                <?php echo $kardex[0]['producto'] . " - " . $kardex[0]['principioactivo']; ?></strong><br>
                                                <strong>Unidad de Medida : <?php echo $kardex[0]['nommedida']; ?></strong><br>
                                                <strong>Presentación : <?php echo $kardex[0]['nompresentacion']; ?></strong><br>
                                                <strong>Total Entradas : <?php echo $TotalEntradas; ?></strong><br>
                                                <strong>Total Salidas : <?php echo $TotalSalidas; ?></strong><br>
                                                <strong>Total Devolución : <?php echo $TotalDevolucion; ?></strong><br>
                                                <strong>Existencia : <?php echo $kardex[0]['stocktotal']; ?></strong><br>
                                                <strong>Precio Compra : <?php echo $kardex[0]['preciocompra']; ?></strong><br>
                                                <strong>Precio Venta (Unidad) :
                                                <?php echo $kardex[0]['precioventaunidad']; ?></strong><br>
                                                <strong>Precio Venta (Caja):
                                                <?php echo $kardex[0]['precioventacaja']; ?></strong><br><br>


                                                <div align="center"><a
                                                        href="reportepdf?codproducto=<?php echo $codproducto; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("KARDEXPRODUCTOS") ?>"
                                                        target="_blank" rel="noopener noreferrer"><button
                                                            class="btn btn-success btn-lg" type="button"><span
                                                                class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                    <a
                                                        href="reporteexcel?codproducto=<?php echo $codproducto; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("KARDEXPRODUCTOS") ?>"><button
                                                            class="btn btn-success btn-lg" type="button"><span
                                                                class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                                </div><br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        <?php

    }
}
############################# BUSQUEDA KARDEX POR PRODUCTOS ###############################
?>



<?php
############################# BUSCA TARJETAS POR BANCOS ######################################
if (isset($_GET['BuscaTarjetasxBancos']) && isset($_GET['codbanco']) && isset($_GET['tipotarjeta'])) {

    $rag = $tra->ListarTarjetasxBancos();
    ?>
    <option value="">SELECCIONE</option>
    <?php
    for ($i = 0; $i < sizeof($rag); $i++) {
        ?>
        <option value="<?php echo $rag[$i]['codtarjeta']; ?>"><?php echo $rag[$i]['nomtarjeta']; ?></option>
    <?php
    }
}
############################# BUSCA TARJETAS POR BANCOS ######################################
?>









<?php
############################# BUSCA SUCURSALES #############################################
if (isset($_GET['BuscaSucursales']) && isset($_GET['envio'])) {

    $rag = $tra->ListarSucursalTraspaso();
    ?>
    <option value="">SELECCIONE</option>
    <?php
    for ($i = 0; $i < sizeof($rag); $i++) {
        ?>
        <option value="<?php echo base64_encode($rag[$i]['codsucursal']); ?>"><?php echo $rag[$i]['razonsocial']; ?></option>
    <?php
    }
}
############################# BUSCA SUCURSALES #############################################
?>

<?php
############################# BUSQUEDA DE PRODUCTOS PARA TRASPASO ###############################
if (isset($_GET['BuscaProductosTraspaso']) && isset($_GET['envio']) && isset($_GET['recibe']) && isset($_GET['codlaboratorio'])) {

    $envio = $_GET['envio'];
    $recibe = $_GET['recibe'];
    $codlaboratorio = $_GET['codlaboratorio'];

    if ($envio == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL DE EMISIÓN</div></center>";
        exit;

    } elseif ($recibe == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL DE RECEPCIÓN</div></center>";
        exit;

    } elseif ($codlaboratorio == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE LABORATORIO PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $ve = new Login();
        $reg = $ve->BuscarProductosTraspasos();

        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks"></i> Productos de Sucursal <?php echo $reg[0]['razonsocial']; ?>
                    y Laboratorio <?php echo $reg[0]['nomlaboratorio']; ?></h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div2">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="datatable-responsive"
                                                class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><input name="jscheckall" type="checkbox" class="checkbox"
                                                                onClick="if (this.checked) {putOn()} else {putOff()}" value="">
                                                        </th>
                                                        <th>Nº</th>
                                                        <th>Descripcion de Producto</th>
                                                        <th>Presentación</th>
                                                        <th>Precio Unidad</th>
                                                        <th>Stock Actual</th>
                                                        <th>Cant. Envio</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $c = 1;
        $i = 1;
        $a = 1;
        for ($a = 0; $a < sizeof($reg); $a++) {
            ?>
                                                        <tr>
                                                            <td><input type="checkbox" name="checkbox[]"
                                                                    id="checkbox_<?php echo $i; ?>"
                                                                    value="<?php echo $reg[$a]["codproducto"] ?>"
                                                                    onClick="activarCombo(<?php echo $i; ?>);"></td>
                                                            <td><?php echo $c++; ?><input type="hidden" name="codproducto[]"
                                                                    id="codproducto" value="<?php echo $reg[$a]["codproducto"]; ?>">
                                                            </td>
                                                            <td><abbr
                                                                    title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $reg[$a]['nompresentacion']; ?></td>
                                                            <td>
                                                                <input type="hidden" name="preciocajat[]" id="preciocajat"
                                                                    value="<?php echo $reg[$a]["precioventacaja"]; ?>">
                                                                <input type="hidden" name="preciounidadt[]" id="preciounidadt"
                                                                    value="<?php echo $reg[$a]["precioventaunidad"]; ?>">

                                                                <?php echo $simbolo . number_format($reg[$a]['precioventaunidad'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $reg[$a]['stocktotal']; ?></td>
                                                            <td><input type="text" class="form-control" name="cantenvio[]"
                                                                    id="cantenvio_<?php echo $i; ?>" disabled="disabled"
                                                                    onKeyUp="this.value=this.value.toUpperCase();" min="1"
                                                                    autocomplete="off" placeholder="Envio" style="width: 90px;">
                                                            </td>

                                                        </tr>

                                                        <?php
            $i = $i + 1;
        }
        ?>
                                                </tbody>
                                            </table>
                                            <input type="hidden" name="total_registros" id="total_registros"
                                                value="<?php echo $i; ?>">
                                            <br />

                                            <div class="modal-footer">
                                                <button type="submit" tabindex="26" name="btn-submit" id="btn-submit"
                                                    class="btn btn-primary"><span class="fa fa-save"></span> Traspasar</button>
                                                <button class="btn btn-danger" type="reset"><i class="fa fa-times-circle"></i>
                                                    Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
}
############################# BUSQUEDA DE PRODUCTOS PARA TRASPASO ###############################
?>




<?php
############################# BUSQUEDA DE TRASPASOS DE PRODUCTOS ###############################
if (isset($_GET['BuscaTraspasoProductos']) && isset($_GET['envio']) && isset($_GET['recibe']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $envio = $_GET['envio'];
    $recibe = $_GET['recibe'];
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];

    if ($envio == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL DE EMISIÓN</div></center>";
        exit;

    } elseif ($recibe == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL DE RECEPCIÓN</div></center>";
        exit;

    } elseif ($desde == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $ve = new Login();
        $reg = $ve->BuscarTraspasosFechas();

        ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Productos Enviados de Sucursal
                    <?php echo $reg[0]['enviado']; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div2">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="datatable-responsive"
                                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Descripción de Producto</th>
                                                                <th>Presentación</th>
                                                                <th>PVP Caja</th>
                                                                <th>PVP Unidad</th>
                                                                <th>Cant. Envio</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                                <tr>
                                                                    <td><?php echo $a++; ?></td>
                                                                    <td><abbr
                                                                            title="<?php echo "Nº " . $reg[$i]['codproductot']; ?>"><?php echo $reg[$i]['producto'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['preciocajat'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['preciounidadt'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['cantenvio']; ?></td>

                                                                </tr>
                                                    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div align="center"><a
                                                            href="reportepdf?envio=<?php echo $envio; ?>&recibe=<?php echo $recibe; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("TRASPASO") ?>"
                                                            title="Ventas por Cajas (Pdf)" target="_blank"
                                                            rel="noopener noreferrer"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-pdf-o"></span> Exportar
                                                                Pdf</button></a>

                                                        <a href="reporteexcel?envio=<?php echo $envio; ?>&recibe=<?php echo $recibe; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("TRASPASO") ?>"
                                                            title="Ventas por Cajas (Excel)"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-excel-o"></span> Exportar
                                                                Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php

    }
}
############################# BUSQUEDA DE TRASPASOS DE PRODUCTOS ###############################
?>






<?php
############################# MUESTRA DIV PRODUCTOS #############################################
if (isset($_GET['BuscaDivProducto'])) {

    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-align-justify"></i> Detalle de Campos</h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <font color="red"><strong> Para poder realizar la Carga Masiva de Productos, el archivo
                                        Excel, debe estar estructurado de 25 columnas, la cuales tendrán las siguientes
                                        especificaciones:</strong></font><br><br>

                                1. Código de Producto (Campo numerico).<br>
                                2. Nombre de Producto.<br>
                                3. Principio Activo de Producto.<br>
                                4. Descripción de Producto.<br>
                                5. Presentación de Producto. (Debe de colocar el Código de Presentación, consultarlos en el
                                <a href="presentaciones" target="_blank">Módulo de Presentaciones</a>).<br>
                                6. Unidad de Medida de Producto. (Debe de colocar el Código de Unidad de Medida,
                                consultarlos en el <a href="medidas" target="_blank">Módulo de Unidad de Medida</a>).<br>
                                7. Precio Compra. (Digitos con 2 decimales).<br>
                                8. Precio Venta (Caja). (Digitos con 2 decimales).<br>
                                9. Precio Venta (Unidad). (Digitos con 2 decimales).<br>
                                10. Stock en Cajas. (Debe de ser solo numeros enteros).<br>
                                11. Unidades en Cajas. (Debe de ser solo numeros enteros).<br>
                                12. Unidades sin Caja (Sueltas). (Debe de ser solo numeros enteros).<br>
                                13. Stock Total. (Debe de ser solo numeros enteros).<br>
                                14. Stock Minimo. (Debe de ser solo numeros enteros).<br>
                                15. IGV de Producto. (Ejem. SI o NO).<br>
                                16. Descuento de Producto. (Digitos con 2 decimales).<br>
                                17. Fecha de Elaboracion. (Formato: 0000-00-00).<br>
                                18. Fecha de Expiracion. (Formato: 0000-00-00).<br>
                                19. Codigo de Barra. (En caso de no tener colocar Cero 0).<br>
                                20. Laboratorio. (Debe de colocar el Código de Laboratorio, consultarlos en el <a
                                    href="laboratorios" target="_blank">Módulo de Laboratorios</a>).<br>
                                21. Proveedor. (Debe de colocar el Código de Proveedor, consultarlos en el <a
                                    href="proveedores" target="_blank">Módulo de Proveedores</a>).<br>
                                22. Sucursal. (Debe de colocar el Código de Sucursal, consultarlos en el <a
                                    href="sucursales" target="_blank">Módulo de Sucursales</a>).<br>
                                23. N° de Lote. (En caso de no tener colocar Cero 0).<br>
                                24. Ubicación en Estanteria.<br>
                                25. Satus de Productos. (Cero = ACTIVO - Uno = INACTIVO).<br><br>

                                <font color="red"><strong> NOTA:</strong></font><br><br>
                                a) No debe de tener cabecera, solo deben estar los registros a grabar.<br>
                                b) Se debe de guardar como archivo .CSV (delimitado por comas)(*.csv).<br>
                                c) Al existir columnas sin datos para los productos, dejarlos en blanco o con valor a
                                cero.<br>
                                d) Todos los datos deberán escribirse en mayú para mejor orden y visibilidad en los
                                reportes.<br>
                                e) Deben de tener en cuenta que la carga masiva de Productos, deben de ser cargados como se
                                explica, para evitar problemas de datos del cliente dentro del Sistema.<br>
                                f) El realizar la Carga Masiva de Productos, el Sistema automaticamente realizará el calculo
                                del Precio Venta Unidad, tomando como valores el Precio Venta Caja / Unidades.<br>
                                f) Importa las plantillas que son de muestra para poder rellenar los nuevos datos.<br>
                                g) Descarga los Productos existentes dando clic <a
                                    href="reporteexcel?&tipo=<?php echo base64_encode("PRODUCTOSEXCEL") ?>"
                                    target="_blank">AQUI</a>.<br><br>

                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
    </div>
<?php
}
############################# MUESTRA DIV PRODUCTOS #############################################
?>












































<?php
############################# MUESTRA INPUT DE PRESENTACION EN PEDIDOS ###########################
if (isset($_GET['CargaPresentacionInput']) && isset($_GET['codpresentacion'])) {

    $pres = new Login();
    $pres = $pres->PresentacionPorId();

    ?>
    <input type="hidden" name="presentacion" id="presentacion" value="<?php echo $pres[0]['nompresentacion'] ?>">
<?php
}
############################# MUESTRA INPUT DE PRESENTACION EN PEDIDOS ###########################
?>

<?php
############################# MUESTRA INPUT DE MEDIDA EN PEDIDOS ###########################
if (isset($_GET['CargaMedidaInput']) && isset($_GET['codmedida'])) {

    $med = new Login();
    $med = $med->MedidasPorId();

    ?>
    <input type="hidden" name="medida" id="medida" value="<?php echo $med[0]['nommedida'] ?>">
<?php
}
############################# MUESTRA INPUT DE MEDIDA EN PEDIDOS ###########################
?>

<?php
############################# MUESTRA CODIGO DE PEDIDOS DE PRODUCTOS ###########################
if (isset($_GET['muestracodigopedido'])) {

    $tra = new Login();
    ?>
    <input class="form-control" type="text" name="codpedido" id="codpedido" onKeyUp="this.value=this.value.toUpperCase();"
        autocomplete="off" placeholder="Ingrese Codigo Pedido" value="<?php echo $reg = $tra->CodigoPedidos(); ?>"
        readonly="readonly">
<?php
}
############################# MUESTRA CODIGO DE PEDIDOS DE PRODUCTOS ###########################
?>

<?php
############################# CARGAR PEDIDOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaPedidosModal']) && isset($_GET['codpedido'])) {

    $tra = new Login();
    $co = $tra->PedidosPorId();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <address>
                    <abbr title="N° de Factura"><strong>Nº DE FACTURA: </strong>
                        <?php echo $co[0]["codpedido"]; ?></abbr><br>
                    <abbr title="Nombre de Sucursal"><strong>SUCURSAL: </strong>
                        <?php echo $co[0]["razonsocial"]; ?></abbr><br>
                    <abbr
                        title="<?php echo $co[0]["contactoproveedor"]; ?>"><strong><?php echo $co[0]["rucproveedor"] . ": " . $co[0]["nomproveedor"]; ?></strong></abbr><br>
                    <abbr title="Dirección de Proveedor"><?php echo $co[0]["direcproveedor"]; ?></abbr><br>
                    <abbr title="Email de Proveedor"><?php echo $co[0]["emailproveedor"]; ?></abbr> <abbr
                        title="Telefono"><strong>TLF:</strong></abbr> <?php echo $co[0]["tlfproveedor"]; ?><br />
                    <abbr title="Fecha de Pedido"><strong>FECHA DE PEDIDO:</strong></abbr>
                    <?php echo date("d-m-Y h:i:s", strtotime($co[0]["fechapedido"])); ?><br />
                    <abbr title="Registrado por"><strong>REGISTRADO POR: </strong>
                        <?php echo $co[0]["nombres"]; ?></abbr><br>
                </address>
            </div>
        </div>
    </div>



    <div id="div1">
        <div class="table-responsive" data-pattern="priority-columns">
            <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Principio Activo</th>
                        <th>Descripción</th>
                        <th>Presentación</th>
                        <th>Unidad Medida</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tru = new Login();
    $busq = $tru->VerDetallesPedidos();
    for ($i = 0; $i < sizeof($busq); $i++) {
        ?>
                        <tr>
                            <td><?php echo $busq[$i]["codproducto"]; ?></td>
                            <td><?php echo $busq[$i]["producto"]; ?></td>
                            <td><?php echo $busq[$i]["principioactivo"]; ?></td>
                            <td><?php echo $busq[$i]["descripcion"]; ?></td>
                            <td><?php echo $busq[$i]["nompresentacion"]; ?></td>
                            <td><?php echo $busq[$i]["nommedida"]; ?></td>
                            <td><?php echo $busq[$i]["cantpedido"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
############################# CARGAR PEDIDOS EN VENTANA MODAL ############################
?>

<?php
############################# CARGAR DETALLE PEDIDOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaDetallePedidoModal']) && isset($_GET['coddetallepedido'])) {

    $reg = $tra->DetallesPedidosPorId();

    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Nº de Factura: </strong><?php echo $reg[0]['codpedido']; ?></td>
            </tr>
            <tr>
                <td><strong>Código de Producto: </strong><?php echo $reg[0]['codproducto']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
            </tr>
            <tr>
                <td><strong>Principio Activo: </strong> <?php echo $reg[0]['principioactivo']; ?></td>
            </tr>
            <tr>
                <td><strong>Descripción de Producto: </strong> <?php echo $reg[0]['descripcion']; ?></td>
            </tr>
            <tr>
                <td><strong>Presentación de Producto: </strong> <?php echo $reg[0]['nompresentacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidad de Medida: </strong> <?php echo $reg[0]['nommedida']; ?></td>
            </tr>
            <tr>
                <td><strong>Laboratorio: </strong> <?php echo $reg[0]['nomlaboratorio']; ?></td>
            </tr>

            <tr>
                <td><strong>Proveedor: </strong> <?php echo $reg[0]['nomproveedor']; ?></td>
            </tr>
            <tr>
                <td><strong>Sucursal: </strong> <?php echo $reg[0]['razonsocial']; ?></td>
            </tr>
            <tr>
                <td><strong>Cantidad Pedido: </strong> <?php echo $reg[0]['cantpedido']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha Pedido: </strong>
                    <?php echo date("d-m-Y h:i:s", strtotime($reg[0]['fechadetallepedido'])); ?></td>
            </tr>
            <tr>
                <td><strong>Registrado por: </strong> <?php echo $reg[0]['nombres']; ?></td>
            </tr>
        </table>
    </div>
    <?php
}
############################# CARGAR DETALLES PEDIDOS EN VENTANA MODAL ############################
?>












































<?php
############################# MUESTRA CANTIDAD COMPRA DB #############################
if (isset($_GET['muestracantcompradb']) && isset($_GET['coddetallecompra'])) {

    $tra = new Login();
    $reg = $tra->DetallesComprasPorId();

    ?>
    <input type="hidden" name="cantidadcompradb" id="cantidadcompradb" value="<?php echo $reg[0]['cantcompra']; ?>">
<?php
}
############################# MUESTRA CANTIDAD COMPRA DB ############################
?>

<?php
############################# MUESTRA CANTIDAD BONIFICACION DB ###################################
if (isset($_GET['muestrabonifdb']) && isset($_GET['coddetallecompra'])) {

    $tra = new Login();
    $reg = $tra->DetallesComprasPorId();

    ?>
    <input type="hidden" name="cantidadbonifdb" id="cantidadbonifdb" value="<?php echo $reg[0]['cantbonif']; ?>"></div>
<?php
}
############################# MUESTRA CANTIDAD BONIFICACION DB ###################################
?>

<?php
############################# MUESTRA FORMA DE PAGO PARA COMPRAS ######################
if (isset($_GET['BuscaFormaPagoCompras']) && isset($_GET['tipocompra'])) {

    $tra = new Login();

    if ($_GET['tipocompra'] == "") {

    } elseif ($_GET['tipocompra'] == "CONTADO") { ?>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">Forma de Compra: <span class="symbol required"></span></label>
                <select name="formacompra" id="formacompra" tabindex="7" class="form-control" required="" aria-required="true">
                    <option value="">SELECCIONE</option>
                    <?php
                    $pago = new Login();
        $pago = $pago->ListarMediosPagos();
        for ($i = 0; $i < sizeof($pago); $i++) {
            ?>
                        <option value="<?php echo $pago[$i]['codmediopago'] ?>"><?php echo $pago[$i]['mediopago'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

    <?php } elseif ($_GET['tipocompra'] == "CREDITO") { ?>

            <!-- four Action -->
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Vence Crédito: <span class="symbol required"></span></label>
                    <input class="form-control calendario" type="text" name="fechavencecredito" id="fechavencecredito"
                        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Fecha Vence Cr&eacute;dito"
                        tabindex="7" required="required">
                    <i class="fa fa-calendar form-control-feedback"></i>
                </div>
            </div>

    <?php }
    }
############################# MUESTRA FORMA DE PAGO PARA COMPRAS ######################
?>

<?php
############################# CARGAR COMPRAS EN VENTANA MODAL ############################
if (isset($_GET['BuscaComprasModal']) && isset($_GET['codcompra'])) {

    $tra = new Login();
    $co = $tra->ComprasPorId();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <address>
                    <abbr title="N° de Factura"><strong>Nº DE FACTURA: </strong>
                        <?php echo $co[0]["codcompra"]; ?></abbr><br>
                    <abbr title="Sucursal"><strong>SUCURSAL: </strong> <?php echo $co[0]["razonsocial"]; ?></abbr><br>
                    <abbr
                        title="<?php echo $co[0]["contactoproveedor"]; ?>"><strong><?php echo $co[0]["rucproveedor"] . ": " . $co[0]["nomproveedor"]; ?></strong></abbr><br>
                    <abbr title="Dirección de Proveedor"><?php echo $co[0]["direcproveedor"]; ?></abbr><br>
                    <abbr title="Email de Proveedor"><?php echo $co[0]["emailproveedor"]; ?></abbr> <abbr
                        title="Telefono"><strong>TLF:</strong></abbr> <?php echo $co[0]["tlfproveedor"]; ?><br />
                    <abbr title="Fecha de Compra"><strong>FECHA DE COMPRA:</strong></abbr>
                    <?php echo date("d-m-Y h:i:s", strtotime($co[0]["fechacompra"])); ?><br />
                    <abbr title="Tipo de Compra"><strong>TIPO DE COMPRA:</strong></abbr>
                    <?php echo $co[0]["tipocompra"]; ?><br />
                    <abbr title="Forma de Compra"><strong>FORMA DE PAGO:</strong></abbr>
                    <?php echo $variable = ($co[0]['tipocompra'] == 'CONTADO' ? $co[0]['mediopago'] : $co[0]['formacompra']); ?><br />
                    <abbr title="Fecha de Vencimiento de Crédito"><strong>FECHA DE VENCIMIENTO:</strong></abbr>
                    <?php echo $vence = ($co[0]['fechavencecredito'] == null ? "0" : date("d-m-Y", strtotime($co[0]['fechavencecredito']))); ?><br />

                    <abbr title="Dias Vencidos de Crédito"><strong>DIAS VENCIDOS:</strong></abbr>
                    <?php
                    if ($co[0]['fechavencecredito'] == null) {
                        echo "0";
                    } elseif ($co[0]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "0";
                    } elseif ($co[0]['fechavencecredito'] < date("Y-m-d")) {
                        echo Dias_Transcurridos(date("Y-m-d"), $co[0]['fechavencecredito']);
                    } ?><br />

                    <abbr title="Status de Compra"><strong>STATUS DE COMPRA:</strong></abbr> <?php
                    if ($co[0]['fechavencecredito'] == null) {
                        echo "<span class='label label-success'>" . $co[0]["statuscompra"] . "</span>";
                    } elseif ($co[0]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "<span class='label label-success'>" . $co[0]["statuscompra"] . "</span>";
                    } elseif ($co[0]['fechavencecredito'] < date("Y-m-d")) {
                        echo "<span class='label label-danger'>VENCIDA</span>";
                    } ?>
                </address>
            </div>
        </div>
    </div>



    <div id="div1">
        <div class="table-responsive" data-pattern="priority-columns">
            <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                <thead>
                    <tr align="center">
                        <th>Código</th>
                        <th>Descripción Producto</th>
                        <th>Cant</th>
                        <th>Unidad Medida</th>
                        <th>Precio Un</th>
                        <th>V. Total</th>
                        <th>Desc</th>
                        <th>Desc/Bon</th>
                        <th>V. Neto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tru = new Login();
    $busq = $tru->VerDetallesCompras();
    for ($i = 0; $i < sizeof($busq); $i++) {
        $valortotal = $busq[$i]["preciocomprac"] * $busq[$i]["cantcompra"];
        $DescBonif = $busq[$i]["preciocomprac"] * $busq[$i]["cantbonif"];
        ?>
                        <tr align="center">
                            <td><?php echo $busq[$i]["codproductoc"]; ?></td>
                            <td><?php echo $busq[$i]["productoc"] . " " . $busq[$i]["nompresentacion"]; ?></td>
                            <td><?php echo $busq[$i]["cantcompra"]; ?></td>
                            <td><?php echo $busq[$i]['nommedida']; ?></td>
                            <td><?php echo $simbolo . number_format($busq[$i]["preciocomprac"], 2, '.', ','); ?></td>
                            <td><?php echo $simbolo . number_format($valortotal, 2, '.', ','); ?></td>
                            <td><?php echo $simbolo . number_format($busq[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo $busq[$i]['descfactura']; ?>%</sup>
                            </td>
                            <td><?php echo $simbolo . number_format($DescBonif, 2, '.', ','); ?><sup><?php echo $busq[$i]['cantbonif']; ?></sup>
                            </td>
                            <td><?php echo $simbolo . number_format($busq[$i]["valorneto"], 2, '.', ','); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="6" rowspan="9">&nbsp;</td>
                        <td colspan="2">
                            <div align="right"><strong>Descuento:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($co[0]["descuentoc"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="right"><strong>Descuento Bonif:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($co[0]["descbonific"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="right"><strong>SubTotal:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($co[0]["subtotalc"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="right"><strong>Total Sin Impuestos:</strong></div>
                        </td>
                        <td>
                            <div align="center">
                                <?php echo $simbolo . number_format($co[0]["totalsinimpuestosc"], 2, '.', ','); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="right"><strong>SubTotal Tarifa 0%:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($co[0]["tarifano"], 2, '.', ','); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="right"><strong>SubTotal Tarifa <?php echo $co[0]["ivac"] . "(%)"; ?>:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($co[0]["tarifasi"], 2, '.', ','); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="right"><strong>IGV <?php echo $co[0]["ivac"] . "(%)"; ?>:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($co[0]["totalivac"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="right"><strong>Total Pago :</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($co[0]["totalc"], 2, '.', ','); ?></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
############################# CARGAR COMPRAS EN VENTANA MODAL ############################
?>

<?php
############################# CARGAR DETALLE COMPRAS EN VENTANA MODAL ############################
if (isset($_GET['BuscaDetallesComprasModal']) && isset($_GET['coddetallecompra'])) {

    $reg = $tra->DetallesComprasPorId();

    ?>
    <div class="row">
        <table border="0" align="center">
            <tr>
                <td><strong>Nº de Factura: </strong><?php echo $reg[0]['codcompra']; ?></td>
            </tr>
            <tr>
                <td><strong>Código de Producto: </strong><?php echo $reg[0]['codproductoc']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['productoc']; ?></td>
            </tr>
            <tr>
                <td><strong>Principio Activo: </strong> <?php echo $reg[0]['principioactivoc']; ?></td>
            </tr>
            <tr>
                <td><strong>Descripción de Producto: </strong> <?php echo $reg[0]['descripcionc']; ?></td>
            </tr>
            <tr>
                <td><strong>Presentación de Producto: </strong> <?php echo $reg[0]['nompresentacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidad de Medida: </strong> <?php echo $reg[0]['nommedida']; ?></td>
            </tr>
            <tr>
                <td><strong>Precio Compra: </strong>
                    <?php echo $simbolo . number_format($reg[0]['preciocomprac'], 2, '.', ','); ?></td>
            </tr>
            <td><strong>Precio Venta Unidad: </strong>
                <?php echo $simbolo . number_format($reg[0]['precioventaunidadc'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Precio Venta Caja: </strong>
                    <?php echo $simbolo . number_format($reg[0]['precioventacajac'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Tiene IGV: </strong> <?php echo $reg[0]['ivaproductoc']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento en Farmacia: </strong> <?php echo $reg[0]['descproductoc']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento en Factura: </strong> <?php echo $reg[0]['descfactura']; ?></td>
            </tr>
            <tr>
                <td><strong>Cantidad de Compra: </strong> <?php echo $reg[0]['cantcompra']; ?></td>
            </tr>
            <tr>
                <td><strong>Cantidad de Bonificación: </strong> <?php echo $reg[0]['cantbonif']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidades: </strong> <?php echo $reg[0]['unidadesc']; ?></td>
            </tr>
            <tr>
                <td><strong>Valor Total: </strong> <?php echo $reg[0]['valortotal']; ?></td>
            </tr>
            <tr>
                <td><strong>Total Descuento: </strong> <?php echo $reg[0]['totaldescuentoc']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento Bonificación: </strong> <?php echo $reg[0]['descbonific']; ?></td>
            </tr>
            <tr>
                <td><strong>Valor Neto: </strong> <?php echo $reg[0]['valorneto']; ?></td>
            </tr>
            <tr>
                <td><strong>Lote: </strong> <?php echo $reg[0]['lote']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Elaboración: </strong> <?php echo $reg[0]['fechaelaboracionc']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha de Expiración: </strong> <?php echo $reg[0]['fechaexpiracionc']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha Registro: </strong>
                    <?php echo date("d-m-Y h:i:s", strtotime($reg[0]['fechadetallecompra'])); ?></td>
            </tr>
        </table>
    </div>

    <?php
}
############################# CARGAR DETALLE COMPRAS EN VENTANA MODAL ############################
?>

<?php
############################# BUSQUEDA COMPRA POR PROVEEDOR ############################
if (isset($_GET['BuscaComprasProveedor']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {

    $codsucursal = $_GET['codsucursal'];
    $codproveedor = $_GET['codproveedor'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($codproveedor == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE EL PROVEEDOR PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $ci = new Login();
        $reg = $ci->BuscarComprasProveedor();

        ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-tasks"></i> Compras del Proveedor <?php echo $reg[0]['nomproveedor']; ?>
                    </h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div id="div1">
                                            <div class="table-responsive" data-pattern="priority-columns">
                                                <table id="tech-companies-1"
                                                    class="table table-small-font table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº</th>
                                                            <th>Nº Factura</th>
                                                            <th>Fecha Recepción</th>
                                                            <th>Dcto</th>
                                                            <th>Dcto Bonif</th>
                                                            <th>Subtotal</th>
                                                            <th>Total Iva</th>
                                                            <th>Total</th>
                                                            <th>Imprimir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $a = 1;
        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;

        for ($i = 0; $i < sizeof($reg); $i++) {

            $TotalArticulos += $reg[$i]['articulos'];
            $TotalDescuento += $reg[$i]['descuentoc'];
            $TotalBonificiacion += $reg[$i]['descbonific'];
            $TotalSubtotal += $reg[$i]['subtotalc'];
            $TotalTarifano += $reg[$i]['tarifano'];
            $TotalTarifasi += $reg[$i]['tarifasi'];
            $Totaliva += $reg[$i]['totalivac'];
            $TotalPago += $reg[$i]['totalc'];
            ?>
                                                            <tr>
                                                                <td><?php echo $a++; ?></td>
                                                                <td><?php echo $reg[$i]['codcompra']; ?></td>
                                                                <td><?php echo date("d-m-Y", strtotime($reg[$i]['fecharecepcion'])); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($reg[$i]['descbonific'], 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($reg[$i]['subtotalc'], 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($reg[$i]['totalivac'], 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($reg[$i]['totalc'], 2, '.', ','); ?>
                                                                </td>
                                                                <td class="actions"><a
                                                                        href="reportepdf?codcompra=<?php echo base64_encode($reg[$i]['codcompra']); ?>&tipo=<?php echo base64_encode("FACTURACOMPRAS") ?>"
                                                                        target="_black" class="btn btn-info btn-xs"
                                                                        title="Factura de Compra"><i class="fa fa-print"></i></a></td>
                                                            </tr>
                                                    <?php } ?>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td><strong>Total General</strong></td>
                                                            <td><?php echo $simbolo . number_format($TotalDescuento, 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($TotalBonificiacion, 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($TotalSubtotal, 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($Totaliva, 2, '.', ','); ?></td>
                                                            <td><?php echo $simbolo . number_format($TotalPago, 2, '.', ','); ?></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center"><a
                                                        href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo base64_encode("COMPRASXPROVEEDOR") ?>"
                                                        title="Compras por Proveedores (Pdf)" target="_blank"
                                                        rel="noopener noreferrer"><button class="btn btn-success btn-lg"
                                                            type="button"><span class="fa fa-file-pdf-o"></span> Exportar
                                                            Pdf</button></a>

                                                    <a href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo base64_encode("COMPRASXPROVEEDOR") ?>"
                                                        title="Compras por Proveedores (Excel)"><button
                                                            class="btn btn-success btn-lg" type="button"><span
                                                                class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                                </div><br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        <?php

    }
}
############################# BUSQUEDA COMPRA POR PROVEEDOR ############################
?>


<?php
############################# BUSQUEDA COMPRA POR FECHAS ############################
if (isset($_GET['BuscaComprasFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $codsucursal = $_GET['codsucursal'];
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($desde == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Compras Desde
                    <?php echo $_GET["desde"] . " hasta " . $_GET["hasta"]; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div1">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="tech-companies-1"
                                                        class="table table-small-font table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Nº Factura</th>
                                                                <th>Proveedor</th>
                                                                <th>Fecha Recepción</th>
                                                                <th>Dcto</th>
                                                                <th>Dcto Bonif</th>
                                                                <th>Subtotal</th>
                                                                <th>Total Iva</th>
                                                                <th>Total</th>
                                                                <th>Imprimir</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    $a = 1;
        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;

        $ci = new Login();
        $reg = $ci->BuscarComprasFechas();

        for ($i = 0; $i < sizeof($reg); $i++) {

            $TotalArticulos += $reg[$i]['articulos'];
            $TotalDescuento += $reg[$i]['descuentoc'];
            $TotalBonificiacion += $reg[$i]['descbonific'];
            $TotalSubtotal += $reg[$i]['subtotalc'];
            $TotalTarifano += $reg[$i]['tarifano'];
            $TotalTarifasi += $reg[$i]['tarifasi'];
            $Totaliva += $reg[$i]['totalivac'];
            $TotalPago += $reg[$i]['totalc'];
            ?>
                                                                <tr>
                                                                    <td><?php echo $a++; ?></td>
                                                                    <td><?php echo $reg[$i]['codcompra']; ?></td>
                                                                    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
                                                                    <td><?php echo date("d-m-Y", strtotime($reg[$i]['fecharecepcion'])); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['descbonific'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['subtotalc'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['totalivac'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['totalc'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td class="actions"><a
                                                                            href="reportepdf?codcompra=<?php echo base64_encode($reg[$i]['codcompra']); ?>&tipo=<?php echo base64_encode("FACTURACOMPRAS") ?>"
                                                                            target="_black" rel="noopener noreferrer"
                                                                            class="btn btn-info btn-xs" title="Factura de Compra"><i
                                                                                class="fa fa-print"></i></a></td>
                                                                </tr>
                                                    <?php } ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td><strong>Total General</strong></td>
                                                                <td><?php echo $simbolo . number_format($TotalDescuento, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($TotalBonificiacion, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($TotalSubtotal, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($Totaliva, 2, '.', ','); ?></td>
                                                                <td><?php echo $simbolo . number_format($TotalPago, 2, '.', ','); ?></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div align="center"><a
                                                            href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("COMPRASXFECHAS") ?>"
                                                            title="Compras por Fechas (Pdf)" target="_blank"
                                                            rel="noopener noreferrer"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-pdf-o"></span> Exportar
                                                                Pdf</button></a>

                                                        <a href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("COMPRASXFECHAS") ?>"
                                                            title="Compras por Fechas (Excel)"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-excel-o"></span> Exportar
                                                                Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php

    }
}
############################# BUSQUEDA COMPRA POR FECHAS ############################
?>


<?php
############################# BUSQUEDA COMPRA POR PAGAR ############################
if (isset($_GET['BuscaComprasxPagar']) && isset($_GET['codsucursal'])) {

    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $ci = new Login();
        $reg = $ci->BuscarComprasxPagar();

        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks"></i> Compras por Pagar de Sucursal
                    <?php echo $reg[0]['razonsocial']; ?></h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div1">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="tech-companies-1"
                                                class="table table-small-font table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nº</th>
                                                        <th>Proveedor</th>
                                                        <th>Nº Factura</th>
                                                        <th>Dcto</th>
                                                        <th>Dcto Bonif</th>
                                                        <th>Subtotal</th>
                                                        <th>Total Iva</th>
                                                        <th>Total</th>
                                                        <th>Imprimir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $a = 1;
        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;

        for ($i = 0; $i < sizeof($reg); $i++) {

            $TotalArticulos += $reg[$i]['articulos'];
            $TotalDescuento += $reg[$i]['descuentoc'];
            $TotalBonificiacion += $reg[$i]['descbonific'];
            $TotalSubtotal += $reg[$i]['subtotalc'];
            $TotalTarifano += $reg[$i]['tarifano'];
            $TotalTarifasi += $reg[$i]['tarifasi'];
            $Totaliva += $reg[$i]['totalivac'];
            $TotalPago += $reg[$i]['totalc'];
            ?>
                                                        <tr>
                                                            <td><?php echo $a++; ?></td>
                                                            <td><?php echo $reg[$i]['nomproveedor']; ?></td>
                                                            <td><?php echo $reg[$i]['codcompra']; ?></td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['descbonific'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['subtotalc'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['totalivac'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($reg[$i]['totalc'], 2, '.', ','); ?>
                                                            </td>
                                                            <td class="actions"><a
                                                                    href="reportepdf?codcompra=<?php echo base64_encode($reg[$i]['codcompra']); ?>&tipo=<?php echo base64_encode("FACTURACOMPRAS") ?>"
                                                                    target="_black" class="btn btn-info btn-xs"
                                                                    title="Factura de Compra"><i class="fa fa-print"></i></a></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Total General</strong></td>
                                                        <td><?php echo $simbolo . number_format($TotalDescuento, 2, '.', ','); ?>
                                                        </td>
                                                        <td><?php echo $simbolo . number_format($TotalBonificiacion, 2, '.', ','); ?>
                                                        </td>
                                                        <td><?php echo $simbolo . number_format($TotalSubtotal, 2, '.', ','); ?>
                                                        </td>
                                                        <td><?php echo $simbolo . number_format($Totaliva, 2, '.', ','); ?></td>
                                                        <td><?php echo $simbolo . number_format($TotalPago, 2, '.', ','); ?></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div align="center"><a
                                                    href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("COMPRASXPAGAR") ?>"
                                                    title="Compras por Pagar (Pdf)" target="_blank"
                                                    rel="noopener noreferrer"><button class="btn btn-success btn-lg"
                                                        type="button"><span class="fa fa-file-pdf-o"></span> Exportar
                                                        Pdf</button></a>

                                                <a href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo base64_encode("COMPRASXPAGAR") ?>"
                                                    title="Compras por Pagar (Excel)"><button class="btn btn-success btn-lg"
                                                        type="button"><span class="fa fa-file-excel-o"></span> Exportar
                                                        Excel</button> </a>
                                            </div><br />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
}
############################# BUSQUEDA COMPRA POR PAGAR ############################
?>



























<?php
############################# MUESTRA MOVIMIENTO DB #############################################
if (isset($_GET['muestramovimeintodb']) && isset($_GET['codmovimientocaja'])) {

    $tra = new Login();
    $reg = $tra->MovimientoCajasPorId();

    ?>
    <input type="hidden" name="montomovimientocajadb" id="montomovimientocajadb"
        <?php if (isset($reg[0]['montomovimientocaja'])) { ?> value="<?php echo $reg[0]['montomovimientocaja']; ?>"
        <?php } ?>>
<?php
}
############################# MUESTRA MOVIMIENTO DB #############################################
?>


<?php
############################# CARGA CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajas']) && isset($_GET['codsucursal'])) {

    $rag = $tra->ListarCajasSucursal();
    ?>
    <option value="">SELECCIONE</option>
    <?php
    for ($i = 0; $i < sizeof($rag); $i++) {
        ?>
        <option value="<?php echo base64_encode($rag[$i]['codcaja']); ?>"><?php echo $rag[$i]['nombrecaja']; ?></option>
    <?php
    }
}
############################# CARGA CAJAS POR SUCURSALES ##########################
?>


<?php
############################# BUSCA CLIENTES PARA VENTAS ###########################
if (isset($_GET['BuscaClientes']) && isset($_GET['buscacliente'])) {

    $busqueda = $_GET['buscacliente'];

    ?>

    <hr>
    <div id="div">
        <div class="table-responsive" data-pattern="priority-columns">
            <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                <thead>
                    <tr role="row">
                        <th>N°</th>
                        <th>Código</th>
                        <th>RUC/DNI</th>
                        <th>Nombres</th>
                        <th>N° de Teléfono</th>
                        <th>N° de Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cliente = new Login();
    $cliente = $cliente->ListarClientesVentas();
    $a = 1;
    for ($i = 0; $i < sizeof($cliente); $i++) {
        ?>
                        <tr role="row" class="odd">
                            <td class="sorting_1" tabindex="0"><?php echo $a++; ?></td>
                            <td><?php echo $cliente[$i]['nrocliente']; ?></td>
                            <td><?php echo $cliente[$i]['cedcliente']; ?></td>
                            <td><?php echo $cliente[$i]['nomcliente']; ?></td>
                            <td><?php echo $cliente[$i]['tlfcliente']; ?></td>
                            <td><?php echo $cliente[$i]['celcliente']; ?></td>
                            <td>
                                <button class="btn btn-icon btn-primary btn-xs" data-dismiss="modal" title="Agregar Cliente"
                                    onClick="AgregaCliente('<?php echo $cliente[$i]['codcliente']; ?>','<?php echo $cliente[$i]['cedcliente']; ?>','<?php echo $cliente[$i]['nomcliente']; ?>','<?php echo $cliente[$i]['direccliente']; ?>','<?php echo $cliente[$i]['tlfcliente']; ?>');">
                                    <i class="fa fa-shopping-cart"></i> </button>

                                <a href="#" class="btn btn-success btn-xs" title="Editar" data-toggle="modal"
                                    data-target="#myModall" data-backdrop="static" data-keyboard="false"
                                    onClick="EditCampos('<?php echo $cliente[$i]["codcliente"]; ?>','<?php echo $cliente[$i]["cedcliente"]; ?>','<?php echo $cliente[$i]["nomcliente"]; ?>','<?php echo $cliente[$i]["direccliente"]; ?>','<?php echo $cliente[$i]["tlfcliente"]; ?>','<?php echo $cliente[$i]["celcliente"]; ?>','<?php echo $cliente[$i]["emailcliente"]; ?>','<?php echo $busqueda; ?>')"><i
                                        class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <hr>
    <?php
}
############################# BUSCA CLIENTES PARA VENTAS ###########################
?>


    <?php
    ############################# MUESTRA CANTIDAD VENTA DB #############################
    if (isset($_GET['muestracantventadb']) && isset($_GET['coddetalleventa'])) {

        $tra = new Login();
        $reg = $tra->DetallesVentasPorId();

        ?>
        <input type="hidden" name="cantidadventadb" id="cantidadventadb" value="<?php echo $reg[0]['cantventa']; ?>">
    <?php
    }
    ############################# MUESTRA CANTIDAD VENTA DB #############################
?>

    <?php
########################### MUESTRA CANTIDAD BONIFICACION VENTA DB ###########################
if (isset($_GET['muestrabonifventadb']) && isset($_GET['coddetalleventa'])) {

    $tra = new Login();
    $reg = $tra->DetallesVentasPorId();

    ?>
        <input type="hidden" name="cantidadbonifventadb" id="cantidadbonifventadb"
            value="<?php echo $reg[0]['cantbonificv']; ?>">
    <?php
}
########################### MUESTRA CANTIDAD BONIFICACION VENTA DB ############################
?>

    <?php
############################# MUESTRA CAMBIO DE VUELTO PARA VENTAS ##############################
if (isset($_GET['CargaCampos'])) {
    ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Monto Pagado: <span class="symbol required"></span></label>
                    <input class="form-control calculodevolucion" type="text" name="montopagado" id="montopagado"
                        onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                        placeholder="Monto Pagado por Cliente" disabled="disabled" required="" aria-required="true">
                    <i class="fa fa-usd form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Cambio Devuelto: <span class="symbol required"></span></label>
                    <input class="form-control" type="text" name="montodevuelto" id="montodevuelto"
                        onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                        placeholder="Ingrese Cambio Devuelto a Cliente" disabled="disabled" readonly="readonly" value="0.00"
                        aria-required="true">
                    <i class="fa fa-usd form-control-feedback"></i>
                </div>
            </div>
        </div>

    <?php }

############################# MUESTRA CAMBIO DE VUELTO PARA VENTAS ##############################
?>

    <?php
############################# MUESTRA FORMA DE PAGO PARA VENTAS ########################
if (isset($_GET['BuscaFormaPagoVentas']) && isset($_GET['tipopagove'])) {

    $tra = new Login();

    if ($_GET['tipopagove'] == "") { ?>

            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label">Medio de Venta: <span class="symbol required"></span></label>
                    <select name="codmediopago" id="codmediopago" class="form-control" required="" aria-required="true">
                        <option value="">SELECCIONE</option>
                    </select>
                </div>
            </div>
            <?php

    } elseif ($_GET['tipopagove'] == "CONTADO") { ?>

            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label">Medio de Pago: <span class="symbol required"></span></label>
                    <select name="codmediopago" id="codmediopago" class="form-control" onChange="MuestraCambiosVentas()"
                        required="" aria-required="true">
                        <option value="">SELECCIONE</option>
                        <?php
                    $pago = new Login();
        $pago = $pago->ListarMediosPagos();
        for ($i = 0; $i < sizeof($pago); $i++) {
            ?>
                            <option value="<?php echo base64_encode($pago[$i]['codmediopago']) ?>">
                                <?php echo $pago[$i]['mediopago'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

        <?php } elseif ($_GET['tipopagove'] == "CREDITO") { ?>

                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label>
                        <input class="form-control calendario" type="text" name="fechavencecredito" id="fechavencecredito"
                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                            placeholder="Ingrese Fecha Vence Cr&eacute;dito" required="required">
                        <i class="fa fa-calendar form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <label class="control-label">Monto de Abono: <span class="symbol required"></span></label>
                        <input class="form-control" type="text" name="montoabono" id="montoabono"
                            onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                            onKeyUp="this.value=this.value.toUpperCase();" value="0.00" autocomplete="off"
                            placeholder="Ingrese Monto de Abono" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                    </div>
                </div>
            </div>

    <?php }
        }
############################# MUESTRA FORMA DE PAGO PARA VENTAS ########################
?>


<?php
############################# MUESTRA CAMBIO DE VUELTO PARA VENTAS ##############################
if (isset($_GET['MuestraCambiosVentas']) && isset($_GET['tipopagove']) && isset($_GET['codmediopago'])) {

    $reg = $tra->MediosPagosPorId();

    if ($_GET['tipopagove'] == "CONTADO" && $reg[0]['mediopago'] == "EFECTIVO") { ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Monto Pagado: <span class="symbol required"></span></label>
                    <input class="form-control calculodevolucion" type="text" name="montopagado" id="montopagado"
                        onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Monto Pagado por Cliente"
                        required="" aria-required="true">
                    <i class="fa fa-usd form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Cambio Devuelto: <span class="symbol required"></span></label>
                    <input class="form-control" type="text" name="montodevuelto" id="montodevuelto"
                        onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                        placeholder="Ingrese Cambio Devuelto a Cliente" readonly="readonly" value="0.00" aria-required="true">
                    <i class="fa fa-usd form-control-feedback"></i>
                </div>
            </div>
        </div>

    <?php } elseif ($_GET['tipopagove'] == "CONTADO" && $reg[0]['mediopago'] == "TARJETA DE CREDITO") { ?>
            <input type="hidden" name="tipotarjeta" id="tipotarjeta" value="CREDITO">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombre de Banco: <span class="symbol required"></span></label>
                        <select name="codbanco" id="codbanco" class="form-control" onChange="CargaTarjetaCredito();" required=""
                            aria-required="true">
                            <option value="">SELECCIONE</option>
                            <?php
                            $banco = new Login();
        $banco = $banco->ListarBancos();
        for ($i = 0; $i < sizeof($banco); $i++) {
            ?>
                                <option value="<?php echo $banco[$i]['codbanco'] ?>"><?php echo $banco[$i]['nombanco'] ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tarjetas de Crédito: <span class="symbol required"></span></label>
                        <div id="codcredito"><select name="codtarjeta" id="codtarjeta" class="form-control" disabled="disabled"
                                required="" aria-required="true">
                                <option value="">SELECCIOsNE</option>
                            </select></div>
                    </div>
                </div>
            </div>

            <div id="muestrameses"></div>

            <div id="muestraintereses"></div>

    <?php } elseif ($_GET['tipopagove'] == "CONTADO" && $reg[0]['mediopago'] == "TARJETA DE DEBITO") { ?>

                <input type="hidden" name="tipotarjeta" id="tipotarjeta" value="DEBITO">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Banco: <span class="symbol required"></span></label>
                            <select name="codbanco" id="codbanco" class="form-control" onChange="CargaTarjetaDebito();" required=""
                                aria-required="true">
                                <option value="">SELECCIONE</option>
                            <?php
                            $banco = new Login();
        $banco = $banco->ListarBancos();
        for ($i = 0; $i < sizeof($banco); $i++) {
            ?>
                                    <option value="<?php echo $banco[$i]['codbanco'] ?>"><?php echo $banco[$i]['nombanco'] ?></option>
                        <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Tarjetas de Débito: <span class="symbol required"></span></label>
                            <div id="coddebito"><select name="codtarjeta" id="codtarjeta" class="form-control" disabled="disabled"
                                    required="" aria-required="true">
                                    <option value="">SELECCIONE</option>
                                </select></div>
                        </div>
                    </div>
                </div>

                <div id="interesdebito"></div>

    <?php }
    }
############################# MUESTRA CAMBIO DE VUELTO PARA VENTAS ##############################
?>






<?php
############################# CARGAR TARJETAS DEBITO ##################################
if (isset($_GET['CargaTarjetasDebito']) && isset($_GET['codbanco']) && isset($_GET['tipotarjeta'])) {

    $rag = $tra->ListarTarjetasBancos();
    ?>
    <input type="hidden" name="meses" id="meses" value="0">
    <select name="codtarjeta" id="codtarjeta" class="form-control" onChange="CargaInteresDebito();" required=""
        aria-required="true">
        <option value="">SELECCIrrrONE</option>
        <?php
        for ($i = 0; $i < sizeof($rag); $i++) {
            ?>
            <option value="<?php echo $rag[$i]['codtarjeta']; ?>"><?php echo $rag[$i]['nomtarjeta']; ?></option>
        <?php } ?>
    </select>
<?php
}
############################# CARGAR TARJETAS DEBITO ##################################
?>

<?php
############################# MUESTRA INTERESES DE TARJETAS DEBITO ############################
if (isset($_GET['CargaInteresDebito']) && isset($_GET['codbanco']) && isset($_GET['codtarjeta']) && isset($_GET['meses'])) {

    $tasa = $tra->CargaInteresesId();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">Diferido con Intereses: <span class="symbol required"></span></label>
                <input type="text" class="form-control" name="tasasi" id="tasasi" autocomplete="off"
                    placeholder="Ingrese Diferido con Intereses" value="<?php echo $tasa[0]['tasasi']; ?>"
                    readonly="readonly" required="" aria-required="true">
                <i class="fa fa-pencil form-control-feedback"></i>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-info" type="button" id="buttondebito" onClick="SumarInteresDebito();"><i
                class="fa fa-plus"></i> Sumar Intéreses</button>
        <button class="btn btn-info" type="button" id="buttondebito2" onClick="RestarInteresDebito();"><i
                class="fa fa-minus"></i> Quitar Intéreses</button>
    </div>

<?php
}
############################# MUESTRA INTERESES DE TARJETAS DEBITO ############################
?>












<?php
############################# CARGAR TARJETAS CREDITO ##################################
if (isset($_GET['CargaTarjetasCredito']) && isset($_GET['codbanco']) && isset($_GET['tipotarjeta'])) {

    $rag = $tra->ListarTarjetasBancos();
    ?>
    <input type="hidden" name="meses" id="meses" value="0">
    <select name="codtarjeta" id="codtarjeta" class="form-control" onChange="CargaMesesTarjetaCredito();" required=""
        aria-required="true">
        <option value="">SELECCIONE</option>
        <?php
        for ($i = 0; $i < sizeof($rag); $i++) {
            ?>
            <option value="<?php echo $rag[$i]['codtarjeta']; ?>"><?php echo $rag[$i]['nomtarjeta']; ?></option>
        <?php } ?>
    </select>
<?php
}
############################# CARGAR TARJETAS CREDITO ##################################
?>

<?php
############################# CARGAR MESES EN TARJETA DE CREDITO #############################
if (isset($_GET['CargaMesesTarjetasCredito']) && isset($_GET['codbanco']) && isset($_GET['codtarjeta'])) {

    $rag = $tra->CargarMesesTarjetas();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <div class="radio radio-info radio-inline">
                    <input id="evento1" value="1" name="interes" checked="checked" onClick="CargaInteres();" type="radio">
                    <label for="evento1"> <strong>CON INTERESES</strong> </label>
                </div>

                <div class="radio radio-danger radio-inline">
                    <input id="evento2" value="0" name="interes" onClick="CargaInteres();" type="radio">
                    <label for="evento2"> <strong>SIN INTERESES</strong> </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Mes: <span class="symbol required"></span></label>
                <select name="meses" id="meses" class="form-control" onChange="CargaInteresesCredito();" required=""
                    aria-required="true">
                    <option value="">SELECCIONE</option>
                    <?php
                    for ($i = 0; $i < sizeof($rag); $i++) {
                        ?>
                        <option value="<?php echo $rag[$i]['meses']; ?>"><?php echo $rag[$i]['meses']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>


<?php
}
############################# CARGAR MESES EN TARJETA DE CREDITO #############################
?>

<?php
############################# MUESTRA INTERESES DE TARJETAS CREDITO ############################
if (isset($_GET['CargaInteresCredito']) && isset($_GET['codbanco']) && isset($_GET['codtarjeta']) && isset($_GET['tipotarjeta']) && isset($_GET['meses'])) {

    $tasa = $tra->CargaInteresesId();

    if ($_GET['meses'] == "") {
        echo "";
    }
    ?>

    <div class="row">

        <?php if ($_GET['interes'] == "1") { ?>

            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label">Diferido con Intereses: <span class="symbol required"></span></label>
                    <div id="corrije"><input type="text" class="form-control" name="tasa" id="tasa" autocomplete="off"
                            value="<?php echo $tasa[0]['tasasi']; ?>" readonly="readonly" required="" aria-required="true">
                    </div>
                    <i class="fa fa-pencil form-control-feedback"></i>
                </div>
            </div>

        <?php } else { ?>

            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label">Diferido sin Intereses: <span class="symbol required"></span></label>
                    <div id="corrije"><input type="text" class="form-control" name="tasa" id="tasa" autocomplete="off"
                            value="<?php echo $tasa[0]['tasano']; ?>" readonly="readonly" required="" aria-required="true">
                    </div>
                    <i class="fa fa-pencil form-control-feedback"></i>
                </div>
            </div>
        <?php } ?>

    </div>

    <div class="modal-footer">
        <button class="btn btn-info" type="button" id="buttondebito" onClick="SumarInteresCredito();"><i
                class="fa fa-plus"></i> Sumar Intéreses</button>
        <button class="btn btn-info" type="button" id="buttondebito2" onClick="RestarInteresCredito();"><i
                class="fa fa-minus"></i> Quitar Intéreses</button>
    </div>

<?php
}
############################# MUESTRA INTERESES DE TARJETAS CREDITO ############################
?>

<?php
############################# CARGAR TASA DE TARJETAS CREDITO ##################################
if (isset($_GET['CargaInteresRadio']) && isset($_GET['codbanco']) && isset($_GET['codtarjeta']) && isset($_GET['tipotarjeta']) && isset($_GET['meses'])) {

    $tasa = $tra->CargaInteresesId();

    if ($_GET['interes'] == "1") {
        ?>
        <input type="text" class="form-control" name="tasa" id="tasa" autocomplete="off"
            value="<?php echo $tasa[0]['tasasi']; ?>" readonly="readonly" required="" aria-required="true">
    <?php
    } else {
        ?>
        <input type="text" class="form-control" name="tasa" id="tasa" autocomplete="off"
            value="<?php echo $tasa[0]['tasano']; ?>" readonly="readonly" required="" aria-required="true">
        <?php
    }
}
############################# CARGAR TASA DE TARJETAS CREDITO ##################################
?>


<?php
############################# BUSQUEDA DE VENTAS ############################
if (isset($_GET['BuscarVentas']) && isset($_GET['tipobusqueda']) && isset($_GET['codcliente']) && isset($_GET['codcaja']) && isset($_GET['fecha'])) {

    $tipobusqueda = $_GET['tipobusqueda'];
    $codcliente = $_GET['codcliente'];
    $codcaja = $_GET['codcaja'];
    $fecha = $_GET['fecha'];
    $fechah = $_GET['fechah'];

    $venta = new Login();
    $reg = $venta->BusquedaVentas();
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-edit"></i> Ventas <?php
            if ($tipobusqueda == "1") {
                echo "del Cliente " . $reg[0]['nomcliente'];
            } elseif ($tipobusqueda == "2") {
                echo "de Caja Nº " . $reg[0]['nrocaja'] . " : " . $reg[0]['nombrecaja'];
            } else {
                echo "de Fecha " . $fecha;
            } ?> </h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div id="div1">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="tech-companies-1"
                                            class="table table-small-font table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>N° Caja</th>
                                                    <th>Clientes</th>
                                                    <th>Dcto</th>
                                                    <th>Dcto Bonif</th>
                                                    <th>Subtotal</th>
                                                    <th>Total IGV</th>
                                                    <th>Total Pago</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($reg == "") {

                                                    echo "";

                                                } else {

                                                    $a = 1;
                                                    for ($i = 0; $i < sizeof($reg); $i++) {
                                                        $tasa = $reg[$i]["totalpago"] * $reg[$i]["intereses"] / 100;
                                                        ?>
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1" tabindex="0"><?php echo $a++; ?></td>
                                                            <td><abbr
                                                                    title="TIPO DOCUMENTO: <?php echo $reg[$i]['tipodocumento']; ?>"><?php echo $reg[$i]['codventa']; ?></abbr>
                                                            </td>
                                                            <td><abbr
                                                                    title="<?php echo $reg[$i]['nombrecaja']; ?>"><?php echo $reg[$i]['nrocaja']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $cliente = ($reg[$i]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']); ?>
                                                            </td>
                                                            <td><?php echo number_format($reg[$i]['descuentove'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo number_format($reg[$i]['descbonificve'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo number_format($reg[$i]['subtotalve'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo number_format($reg[$i]['tarifasive'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo number_format($reg[$i]["totalpago"] + $tasa, 2, '.', ','); ?>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="btn btn-success btn-xs"
                                                                    onClick="VerVentas('<?php echo base64_encode($reg[$i]['codventa']) ?>')"
                                                                    data-href="#" data-toggle="modal"
                                                                    data-target=".bs-example-modal-lg" data-placement="left"
                                                                    data-backdrop="static" data-keyboard="false" data-id=""
                                                                    rel="tooltip" title="Ver Venta"><i
                                                                        class="fa fa-search-plus"></i></a>

                                                                <?php if ($reg[$i]['tipodocumento'] == "TICKET") { ?>
                                                                    <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKET") ?>"
                                                                        target="_black" class="btn btn-info btn-xs"
                                                                        data-toggle="tooltip" data-placement="left" title=""
                                                                        data-original-title="Ticket de Venta"><i
                                                                            class="fa fa-print"></i></a>
                                                                <?php } else { ?>
                                                                    <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("FACTURAVENTAS") ?>"
                                                                        target="_black" class="btn btn-info btn-xs"
                                                                        data-toggle="tooltip" data-placement="left" title=""
                                                                        data-original-title="Factura de Venta"><i
                                                                            class="fa fa-print"></i></a>

                                                                <?php } ?>

                                                                <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("GUIAREMISION") ?>"
                                                                    target="_black" class="btn btn-warning btn-xs"
                                                                    data-toggle="tooltip" data-placement="left" title=""
                                                                    data-original-title="Guia de Remisión"><i
                                                                        class="fa fa-print"></i></a>

                                                            </td>
                                                        </tr>
                                                    <?php }
                                                    } ?>
                                            </tbody>
                                        </table>
                                    </div><br />
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    <?php

}
############################# BUSQUEDA DE VENTAS ############################
?>


<?php
######################## CARGA DE VENTAS DE EN VENTAS MODAL ###########################
if (isset($_GET['BuscaVentasModal']) && isset($_GET['codventa'])) {

    $codventa = $_GET['codventa'];

    $tra = new Login();
    $ve = $tra->VentasPorId();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <address>
                    <abbr title="N° de Factura"><strong>Nº DE FACTURA: </strong>
                        <?php echo $ve[0]["codventa"]; ?></abbr><br>
                    <abbr title="N° de Serie"><strong>Nº DE SERIE: </strong> <?php echo $ve[0]["codserie"]; ?></abbr><br>
                    <abbr title="N° de Autorizacion"><strong>Nº DE AUTORIZACI&Oacute;N: </strong>
                        <?php echo $ve[0]["codautorizacion"]; ?></abbr><br>
                    <abbr title="Nº de Caja"><strong>Nº DE CAJA: </strong>
                        <?php echo $ve[0]["nrocaja"] . ":" . $ve[0]["nombrecaja"]; ?></abbr><br>

                    <?php if ($ve[0]['codcliente'] == '') { ?>
                        <abbr title="Nombre de Cliente"><strong>CLIENTE:</strong> <?php echo "CONSUMIDOR FINAL"; ?></abbr><br>
                    <?php } else { ?>
                        <abbr title="Nombre de Cliente"><strong>CLIENTE:
                            </strong><?php echo $ve[0]["cedcliente"] . ": " . $ve[0]["nomcliente"]; ?></abbr><br>
                        <abbr title="Direcci&oacute;n de Cliente"><?php echo $ve[0]["direccliente"]; ?></abbr><br>
                        <abbr title="Email de Cliente"><strong>EMAIL: </strong> <?php echo $ve[0]["emailcliente"]; ?></abbr><br>
                        <abbr title="Telefono"><strong>N&deg; DE TLF:</strong></abbr> <?php echo $ve[0]["tlfcliente"]; ?><br />
                    <?php } ?>

                    <abbr title="Tipo de Pago"><strong>TIPO DE PAGO:</strong></abbr>
                    <?php echo $ve[0]["tipopagove"]; ?><br />
                    <abbr title="Forma de Pago"><strong>FORMA DE PAGO:</strong></abbr>
                    <?php echo $variable = ($ve[0]['tipopagove'] == 'CONTADO' ? $ve[0]['mediopago'] : $ve[0]['formapagove']); ?><br />
                    <abbr title="Fecha de Vencimiento de Cr&eacute;dito"><strong>FECHA DE VENCIMIENTO:</strong></abbr>
                    <?php echo $vence = ($ve[0]['fechavencecredito'] == null ? "0" : date("d-m-Y", strtotime($ve[0]['fechavencecredito']))); ?><br />
                    <abbr title="Dias Vencidos de Cr&eacute;dito"><strong>DIAS VENCIDOS:</strong></abbr>
                    <?php
                    if ($ve[0]['fechavencecredito'] == null) {
                        echo "0";
                    } elseif ($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "0";
                    } elseif ($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                        echo Dias_Transcurridos(date("Y-m-d"), $ve[0]['fechavencecredito']);
                    } ?><br />
                    <abbr title="Fecha de Venta"><strong>FECHA DE VENTA:</strong></abbr>
                    <?php echo date("d-m-Y h:i:s", strtotime($ve[0]['fechaventa'])); ?><br />
                    <abbr title="Status de Venta"><strong>STATUS DE VENTA:</strong></abbr>
                    <?php
                    if ($ve[0]['fechavencecredito'] == null) {
                        echo "<span class='label label-success'>" . $ve[0]["statusventa"] . "</span>";
                    } elseif ($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "<span class='label label-success'>" . $ve[0]["statusventa"] . "</span>";
                    } elseif ($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                        echo "<span class='label label-danger'>VENCIDA</span>";
                    } ?><br />
                    <abbr title="Registrado por"><strong>REGISTRADO POR:</strong></abbr>
                    <?php echo $ve[0]['nombres']; ?><br />
                </address>
            </div>
        </div>
    </div>



    <div id="div1">
        <div class="table-responsive" data-pattern="priority-columns">
            <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                <thead>
                    <tr align="center">
                        <th>Código</th>
                        <th>Descripción Producto</th>
                        <th>Cant</th>
                        <th>Unidad Medida</th>
                        <th>Precio Un</th>
                        <th>V. Total</th>
                        <th>Desc</th>
                        <th>Desc/Bon</th>
                        <th>V. Neto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tru = new Login();
    $busq = $tru->VerDetallesVentas();
    for ($i = 0; $i < sizeof($busq); $i++) {
        $valortotal = $busq[$i]["valortotalv"];
        $DescBonif = $busq[$i]["precioventaunidadv"] * $busq[$i]["cantbonificv"];
        $tasa = $ve[0]["totalpago"] * $ve[0]["intereses"] / 100;
        ?>
                        <tr align="center">
                            <td><?php echo $busq[$i]["codproductov"]; ?></td>
                            <td><?php echo $busq[$i]["productov"] . " " . $busq[$i]["nompresentacion"]; ?></td>
                            <td><?php echo $cantidad = ($busq[$i]['cantbonificv'] == '0' ? $busq[$i]['cantventa'] : $busq[$i]['cantventa'] . "+" . $busq[$i]['cantbonificv']); ?>
                            </td>
                            <td><?php echo $busq[$i]['nommedida']; ?></td>
                            <td><?php echo $simbolo . number_format($busq[$i]["preciounitario"], 2, '.', ','); ?></td>
                            <td><?php echo $simbolo . number_format($valortotal, 2, '.', ','); ?></td>
                            <td><?php echo $simbolo . number_format($busq[$i]['descporc'], 2, '.', ','); ?><sup><?php echo $busq[$i]['descproductov']; ?>%</sup>
                            </td>
                            <td><?php echo $simbolo . number_format($DescBonif, 2, '.', ','); ?><sup><?php echo $busq[$i]['cantbonificv']; ?></sup>
                            </td>
                            <td><?php echo $simbolo . number_format($busq[$i]["valornetov"], 2, '.', ','); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="5" rowspan="9">&nbsp;</td>
                        <td colspan="3">
                            <div align="right"><strong>Descuento:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($ve[0]["descuentove"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right"><strong>Descuento Bonif:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($ve[0]["descbonificve"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right"><strong>SubTotal:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($ve[0]["subtotalve"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right"><strong>Total Sin Impuestos:</strong></div>
                        </td>
                        <td>
                            <div align="center">
                                <?php echo $simbolo . number_format($ve[0]["totalsinimpuestosve"], 2, '.', ','); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right"><strong>SubTotal Tarifa 0%:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($ve[0]["tarifanove"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right"><strong>SubTotal Tarifa <?php echo $ve[0]["ivave"] . "(%)"; ?>:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($ve[0]["tarifasive"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right"><strong>IGV <?php echo $ve[0]["ivave"] . "(%)"; ?>:</strong></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $simbolo . number_format($ve[0]["totalivave"], 2, '.', ','); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right"><strong>Total Pago :</strong></div>
                        </td>
                        <td>
                            <div align="center">
                                <?php echo $simbolo . number_format($ve[0]["totalpago"] + $tasa, 2, '.', ','); ?></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
######################## CARGA DE VENTAS DE EN VENTAS MODAL ###########################
?>


<?php
############################# BUSQUEDA DE DETALLES DE VENTAS #############################
if (isset($_GET['BuscarDetallesVentas']) && isset($_GET['tipobusquedad']) && isset($_GET['codventa']) && isset($_GET['codcaja']) && isset($_GET['fecha'])) {

    $tipobusquedad = $_GET['tipobusquedad'];
    $codventa = $_GET['codventa'];
    $codcaja = $_GET['codcaja'];
    $fecha = $_GET['fecha'];
    $fechah = $_GET['fechah'];

    $venta = new Login();
    $reg = $venta->BusquedaDetallesVentas();
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-edit"></i> Detalles de Ventas <?php if ($tipobusquedad == "1") {
                echo "de Factura Nº " . $reg[0]['codventa'];
            } elseif ($tipobusquedad == "2") {
                echo "de Caja Nº " . $reg[0]['nrocaja'] . " : " . $reg[0]['nombrecaja'];
            } else {
                echo "de Fecha " . $fecha;
            } ?> </h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div id="div1">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="tech-companies-1"
                                            class="table table-small-font table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Nº Factura</th>
                                                    <th>Descripción de Producto</th>
                                                    <th>Presentación</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Total</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($reg == "") {

                                                    echo "";

                                                } else {

                                                    $a = 1;
                                                    for ($i = 0; $i < sizeof($reg); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $a++; ?></td>
                                                            <td><abbr
                                                                    title="TIPO DOCUMENTO: <?php echo $reg[$i]['tipodocumento']; ?>"><?php echo $reg[$i]['codventa']; ?></abbr>
                                                            </td>
                                                            <td><abbr
                                                                    title="<?php echo "Nº " . $reg[$i]['codproductov']; ?>"><?php echo $reg[$i]['productov'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                            <td><?php echo number_format($reg[$i]['precioventaunidadv'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $cantidad = ($reg[$i]['cantbonificv'] == '0' ? $reg[$i]['cantventa'] : $reg[$i]['cantventa'] . "+" . $reg[$i]['cantbonificv']); ?>
                                                            </td>
                                                            <td><?php echo $reg[$i]['valornetov']; ?></td>
                                                            <td><a href="#" class="btn btn-success btn-xs" data-placement="left"
                                                                    title="Ver Detalle Venta" data-original-title="" data-href="#"
                                                                    data-toggle="modal" data-target="#panel-modal"
                                                                    data-backdrop="static" data-keyboard="false"
                                                                    onClick="VerDetalleVentas('<?php echo base64_encode($reg[$i]["coddetalleventa"]); ?>')"><i
                                                                        class="fa fa-search-plus"></i></a>

                                                                <a class="btn btn-primary btn-xs" title="Editar" data-toggle="modal"
                                                                    data-target="#myModal" data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    onClick="CargaDetalleVenta('<?php echo $reg[$i]["coddetalleventa"]; ?>','<?php echo $reg[$i]["tipodocumento"]; ?>','<?php echo $reg[$i]["codventa"]; ?>','<?php echo $reg[$i]["codsucursal"]; ?>','<?php echo $reg[$i]["ivave"]; ?>','<?php echo $reg[$i]["codproductov"]; ?>','<?php echo $reg[$i]["productov"]; ?>','<?php echo $reg[$i]["principioactivov"]; ?>','<?php echo $reg[$i]["descripcionv"]; ?>','<?php echo $reg[$i]["nommedida"]; ?>','<?php echo $reg[$i]["codpresentacionv"]; ?>','<?php echo $reg[$i]["preciocomprav"]; ?>','<?php echo $reg[$i]["precioventacajav"]; ?>','<?php echo $reg[$i]["precioventaunidadv"]; ?>','<?php echo $reg[$i]["preciounitario"]; ?>','<?php echo $reg[$i]["cantventa"]; ?>','<?php echo $reg[$i]["cantbonificv"]; ?>','<?php echo $reg[$i]["valortotalv"]; ?>','<?php echo $reg[$i]["descproductov"]; ?>','<?php echo $reg[$i]["descporc"]; ?>','<?php echo $reg[$i]["descbonificv"]; ?>','<?php echo $reg[$i]["valornetov"]; ?>','<?php echo $reg[$i]["baseimponible"]; ?>','<?php echo $reg[$i]["ivaproductov"]; ?>','<?php echo date("d-m-Y h:i:s", strtotime($reg[$i]['fechadetalleventa'])); ?>','<?php echo $tipobusquedad; ?>','<?php echo $reg[$i]["codcaja"]; ?>','<?php echo $fecha; ?>', '<?php echo $reg[$i]["tipocantidad"]; ?>')"><i
                                                                        class="fa fa-pencil"></i></a>

                                                                <a class="btn btn-danger btn-xs"
                                                                    onClick="EliminarDetalleVenta('<?php echo base64_encode($reg[$i]["coddetalleventa"]) ?>','<?php echo $reg[$i]["codcaja"] ?>','<?php echo base64_encode($reg[$i]["tipopagove"]) ?>','<?php echo $reg[$i]["codventa"] ?>','<?php echo base64_encode($reg[$i]["codcliente"]) ?>','<?php echo base64_encode($reg[$i]["codsucursal"]) ?>','<?php echo base64_encode($reg[$i]["codproductov"]) ?>','<?php echo base64_encode($reg[$i]["cantventa"]) ?>','<?php echo base64_encode($reg[$i]["cantbonificv"]) ?>','<?php echo base64_encode($reg[$i]["preciocomprav"]) ?>','<?php echo base64_encode($reg[$i]["precioventaunidadv"]) ?>','<?php echo base64_encode($reg[$i]["precioventacajav"]) ?>','<?php echo base64_encode($reg[$i]["ivaproductov"]) ?>','<?php echo base64_encode($reg[$i]["descproductov"]) ?>','<?php echo base64_encode("DETALLESVENTAS") ?>','<?php echo $tipobusquedad; ?>','<?php echo $fecha; ?>')"
                                                                    title="Eliminar"><i class="fa fa-trash-o"></i></a>

                                                                <?php //if(date("Y-m-d",strtotime($reg[$i]['fechadetalleventa']))==date("Y-m-d")){?>
                                                                <!--<a class="btn btn-danger btn-xs" onClick="verificaeliminar()" title="Eliminar" ><i class="fa fa-trash-o"></i></a>-->
                                                            </td>



                                                        </tr>
                                                    <?php }
                                                    } ?>
                                            </tbody>
                                        </table>
                                    </div><br />
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
<?php
}
############################# BUSQUEDA DE DETALLES DE VENTAS #############################
?>

<?php
########################### CARGA DETALLE DE VENTAS EN VENTANA MODAL ###########################
if (isset($_GET['BuscaDetallesVentasModal']) && isset($_GET['coddetalleventa'])) {

    $reg = $tra->DetallesVentasPorId();
    ?>
    <div class="row">
        <table border="0" align="center">

            <?php if ($reg[0]['codcliente'] == "") { ?>
                <tr>
                    <td><strong>Nombre de Cliente: </strong>CONSUMIDOR FINAL</td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td><strong>RUC/DNI: </strong><?php echo $reg[0]['cedcliente']; ?></td>
                </tr>
                <tr>
                    <td><strong>Nombre de Cliente:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td><strong>Código de Producto: </strong><?php echo $reg[0]['codproductov']; ?></td>
            </tr>
            <tr>
                <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['productov']; ?></td>
            </tr>
            <tr>
                <td><strong>Principio Activo: </strong> <?php echo $reg[0]['principioactivov']; ?></td>
            </tr>
            <tr>
                <td><strong>Descripción de Producto: </strong> <?php echo $reg[0]['descripcionv']; ?></td>
            </tr>
            <tr>
                <td><strong>Presentación de Producto: </strong> <?php echo $reg[0]['nompresentacion']; ?></td>
            </tr>
            <tr>
                <td><strong>Unidad de Medida: </strong> <?php echo $reg[0]['nommedida']; ?></td>
            </tr>
            <tr>
                <td><strong>Precio Compra: </strong>
                    <?php echo $simbolo . number_format($reg[0]['preciocomprav'], 2, '.', ','); ?></td>
            </tr>
            <td><strong>PVP (Caja): </strong>
                <?php echo $simbolo . number_format($reg[0]['precioventacajav'], 2, '.', ','); ?></td>
            </tr>
            <td><strong>PVP (Unidad): </strong>
                <?php echo $simbolo . number_format($reg[0]['precioventaunidadv'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Precio Unitario: </strong>
                    <?php echo $simbolo . number_format($reg[0]['preciounitario'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Cantidad de Venta: </strong> <?php echo $reg[0]['cantventa']; ?></td>
            </tr>
            <tr>
                <td><strong>Cantidad de Bonificación: </strong> <?php echo $reg[0]['cantbonificv']; ?></td>
            </tr>
            <tr>
                <td><strong>Valor Total: </strong>
                    <?php echo $simbolo . number_format($reg[0]['valortotalv'], 2, '.', ','); ?></td>
            </tr>
            <tr>
                <td><strong>Descuento: </strong> <?php echo $reg[0]['descproductov'] . " %"; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento Porcentaje: </strong> <?php echo $reg[0]['descporc']; ?></td>
            </tr>
            <tr>
                <td><strong>Descuento Bonificación: </strong> <?php echo $reg[0]['descbonificv']; ?></td>
            </tr>
            <tr>
                <td><strong>Valor Neto: </strong> <?php echo $simbolo . number_format($reg[0]['valornetov'], 2, '.', ','); ?>
                </td>
            </tr>
            <tr>
                <td><strong>Tiene IGV: </strong> <?php echo $reg[0]['ivaproductov']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha Venta: </strong>
                    <?php echo date("d-m-Y h:i:s", strtotime($reg[0]['fechadetalleventa'])); ?></td>
            </tr>
        </table>
    </div>
    <?php
}
########################### CARGA DETALLE DE VENTAS EN VENTANA MODAL ###########################
?>

<?php
############################# BUSQUEDA VENTAS POR CAJAS Y FECHAS ############################
if (isset($_GET['BuscaVentasCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $codcaja = $_GET['codcaja'];
    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($codcaja == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA DE VENTA PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($desde == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</div></center>";
        exit;


    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</div></center>";
        exit;


    } elseif ($desde > $hasta) {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</div></center>";
        exit;

    } else {

        $ci = new Login();
        $reg = $ci->BuscarVentasCajas();
        ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Ventas de Sucursal <?php echo $reg[0]['razonsocial']; ?> en
                            Caja <?php echo "N&deg; " . $reg[0]['nrocaja']; ?> - Fecha desde <?php echo $desde; ?> hasta
                    <?php echo $hasta; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div1">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="tech-companies-1"
                                                        class="table table-small-font table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Nº Factura</th>
                                                                <th>Clientes</th>
                                                                <th>Fecha Venta</th>
                                                                <th>Dcto</th>
                                                                <th>Dcto Bonif</th>
                                                                <th>Subtotal</th>
                                                                <th>Total IGV</th>
                                                                <th>Total</th>
                                                                <th>Imprimir</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    $a = 1;
        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;

        for ($i = 0; $i < sizeof($reg); $i++) {
            $tasa = $reg[$i]["totalpago"] * $reg[$i]["intereses"] / 100;

            $TotalArticulos += $reg[$i]['articulos'];
            $TotalDescuento += $reg[$i]['descuentove'];
            $TotalBonificiacion += $reg[$i]['descbonificve'];
            $TotalSubtotal += $reg[$i]['subtotalve'];
            $TotalTarifano += $reg[$i]['subtotalve'];
            $TotalTarifasi += $reg[$i]['tarifasive'];
            $Totaliva += $reg[$i]['totalivave'];
            $TotalPago += $reg[$i]['totalpago'] + $tasa;

            ?>
                                                                <tr>
                                                                    <td><?php echo $a++; ?></td>
                                                                    <td><abbr
                                                                            title="TIPO DOCUMENTO: <?php echo $reg[$i]['tipodocumento']; ?>"><?php echo $reg[$i]['codventa']; ?></abbr>
                                                                    </td>
                                                                    <td><?php echo $cliente = ($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']); ?>
                                                                    </td>
                                                                    <td><?php echo date("d-m-Y", strtotime($reg[$i]['fechaventa'])); ?></td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['descuentove'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['descbonificve'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['subtotalve'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['totalivave'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['totalpago'] + $tasa, 2, '.', ','); ?>
                                                                    </td>
                                                                    <td class="actions">
                                                                <?php if ($reg[$i]['tipodocumento'] == "TICKET") { ?>
                                                                            <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKET") ?>"
                                                                                target="_black" rel="noopener noreferrer"
                                                                                class="btn btn-info btn-xs" data-toggle="tooltip"
                                                                                data-placement="left" title=""
                                                                                data-original-title="Ticket de Venta"><i
                                                                                    class="fa fa-print"></i></a>
                                                                <?php } else { ?>
                                                                            <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("FACTURAVENTAS") ?>"
                                                                                target="_black" rel="noopener noreferrer"
                                                                                class="btn btn-info btn-xs" data-toggle="tooltip"
                                                                                data-placement="left" title=""
                                                                                data-original-title="Factura de Venta"><i
                                                                                    class="fa fa-print"></i></a>
                                                                <?php } ?>

                                                                        <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("GUIAREMISION") ?>"
                                                                            target="_black" rel="noopener noreferrer"
                                                                            class="btn btn-warning btn-xs" data-toggle="tooltip"
                                                                            data-placement="left" title=""
                                                                            data-original-title="Guia de Remisión"><i
                                                                                class="fa fa-print"></i></a>

                                                                    </td>
                                                                </tr>
                                                    <?php } ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td><strong>Total General</strong></td>
                                                                <td><?php echo $simbolo . number_format($TotalDescuento, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($TotalBonificiacion, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($TotalSubtotal, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($Totaliva, 2, '.', ','); ?></td>
                                                                <td><?php echo $simbolo . number_format($TotalPago, 2, '.', ','); ?></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div align="center"><a
                                                            href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("VENTASXCAJAS") ?>"
                                                            title="Ventas por Cajas (Pdf)" target="_blank"
                                                            rel="noopener noreferrer"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-pdf-o"></span> Exportar
                                                                Pdf</button></a>

                                                        <a href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("VENTASXCAJAS") ?>"
                                                            title="Ventas por Cajas (Excel)"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-excel-o"></span> Exportar
                                                                Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php

    }
}
############################# BUSQUEDA VENTAS POR CAJAS Y FECHAS ############################
?>

<?php
############################# BUSQUEDA VENTAS POR FECHAS ############################
if (isset($_GET['BuscaVentasFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($desde == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</div></center>";
        exit;


    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</div></center>";
        exit;


    } else {

        $ci = new Login();
        $reg = $ci->BuscarVentasFechas();
        //var_dump($reg);

        ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Ventas de Sucursal <?php echo $reg[0]['razonsocial']; ?> -
                            Fecha desde <?php echo $desde; ?> hasta <?php echo $hasta; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div1">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="tech-companies-1"
                                                        class="table table-small-font table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Nº Factura</th>
                                                                <th>N° Caja</th>
                                                                <th>Clientes</th>
                                                                <th>Fecha Venta</th>
                                                                <th>Dcto</th>
                                                                <th>Dcto Bonif</th>
                                                                <th>Subtotal</th>
                                                                <th>Total IGV</th>
                                                                <th>Ganancia</th>
                                                                <th>Total</th>
                                                                <th>Imprimir</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    $a = 1;
        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;
        $Totalganancia = 0;


        for ($i = 0; $i < sizeof($reg); $i++) {
            $tasa = $reg[$i]["totalpago"] * $reg[$i]["intereses"] / 100;

            $TotalArticulos += $reg[$i]['articulos'];
            $TotalDescuento += $reg[$i]['descuentove'];
            $TotalBonificiacion += $reg[$i]['descbonificve'];
            $TotalSubtotal += $reg[$i]['subtotalve'];
            $TotalTarifano += $reg[$i]['subtotalve'];
            $TotalTarifasi += $reg[$i]['tarifasive'];
            $Totaliva += $reg[$i]['totalivave'];
            $Totalganancia += $reg[$i]['totalganancia'];
            $TotalPago += $reg[$i]['totalpago'] + $tasa;
            ?>
                                                                <tr>
                                                                    <td><?php echo $a++; ?></td>
                                                                    <td><abbr
                                                                            title="TIPO DOCUMENTO: <?php echo $reg[$i]['tipodocumento']; ?>"><?php echo $reg[$i]['codventa']; ?></abbr>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['nrocaja']; ?></td>
                                                                    <td><?php echo $cliente = ($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']); ?>
                                                                    </td>
                                                                    <td><?php echo date("d-m-Y", strtotime($reg[$i]['fechaventa'])); ?></td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['descuentove'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['descbonificve'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['subtotalve'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['totalivave'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['totalganancia']; ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['totalpago'] + $tasa, 2, '.', ','); ?>
                                                                    </td>
                                                                    <td class="actions">
                                                                <?php if ($reg[$i]['tipodocumento'] == "TICKET") { ?>
                                                                            <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKET") ?>"
                                                                                target="_black" rel="noopener noreferrer"
                                                                                class="btn btn-info btn-xs" data-toggle="tooltip"
                                                                                data-placement="left" title=""
                                                                                data-original-title="Ticket de Venta"><i
                                                                                    class="fa fa-print"></i></a>
                                                                <?php } else { ?>
                                                                            <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("FACTURAVENTAS") ?>"
                                                                                target="_black" rel="noopener noreferrer"
                                                                                class="btn btn-info btn-xs" data-toggle="tooltip"
                                                                                data-placement="left" title=""
                                                                                data-original-title="Factura de Venta"><i
                                                                                    class="fa fa-print"></i></a>
                                                                <?php } ?>

                                                                        <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("GUIAREMISION") ?>"
                                                                            target="_black" rel="noopener noreferrer"
                                                                            class="btn btn-warning btn-xs" data-toggle="tooltip"
                                                                            data-placement="left" title=""
                                                                            data-original-title="Guia de Remisión"><i
                                                                                class="fa fa-print"></i></a>
                                                                    </td>
                                                                </tr>
                                                    <?php } ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td><strong>Total General</strong></td>
                                                                <td><?php echo $simbolo . number_format($TotalDescuento, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($TotalBonificiacion, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($TotalSubtotal, 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($Totaliva, 2, '.', ','); ?></td>
                                                                <td><?php echo $simbolo . number_format($Totalganancia, 2, '.', ','); ?></td>
                                                                <td><?php echo $simbolo . number_format($TotalPago, 2, '.', ','); ?></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div align="center"><a
                                                            href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("VENTASXFECHAS") ?>"
                                                            title="Ventas por Fechas (Pdf)" target="_blank"
                                                            rel="noopener noreferrer"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-pdf-o"></span> Exportar
                                                                Pdf</button></a>

                                                        <a href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("VENTASXFECHAS") ?>"
                                                            title="Ventas por Fechas (Excel)"><button class="btn btn-success btn-lg"
                                                                type="button"><span class="fa fa-file-excel-o"></span> Exportar
                                                                Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php

    }
}
############################# BUSQUEDA VENTAS POR FECHAS ############################
?>

<?php
###################### BUSQUEDA DE PRODUCTOS VENDIDOS POR FECHAS ######################
if (isset($_GET['BuscaProductosVendidosFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($desde == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</div></center>";
        exit;


    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Productos Vendidos desde
                    <?php echo $_GET["desde"] . " hasta " . $_GET["hasta"]; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div1">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="tech-companies-1"
                                                        class="table table-small-font table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Descripcion de Producto</th>
                                                                <th>Presentación</th>
                                                                <th>Laboratorito</th>
                                                                <th>Precio</th>
                                                                <th>Vendido</th>
                                                                <th>Valor Neto</th>
                                                                <th>Stock Actual</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    $ve = new Login();
        $reg = $ve->BuscarVentasProductos();
        $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                                <tr>
                                                                    <td><?php echo $a++; ?></td>
                                                                    <td><abbr
                                                                            title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " " . $reg[$i]['nommedida']; ?></abbr>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                                    <td><?php echo getSubString($reg[$i]["nomlaboratorio"], 12); ?></td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['precioventaunidadv'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos'] . "+" . $reg[$i]['articulos2']); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]["valornetov"], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['stocktotal']; ?></td>

                                                                </tr>
                                                    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div align="center"><a
                                                            href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("PRODUCTOSVENDIDOS") ?>"
                                                            target="_blank" rel="noopener noreferrer"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                        <a
                                                            href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("PRODUCTOSVENDIDOS") ?>"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php

    }
}
######################### BUSQUEDA DE PRODUCTOS VENDIDOS POR FECHAS #########################
?>

<?php
############################# BUSQUEDA ARQUEOS DE CAJAS POR FECHAS ##############################
if (isset($_GET['BuscaArqueosFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($desde == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</div></center>";
        exit;


    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Arqueos de Cajas desde
                    <?php echo $_GET["desde"] . " hasta " . $_GET["hasta"]; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div1">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="tech-companies-1"
                                                        class="table table-small-font table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Caja</th>
                                                                <th>Hora de Apertura</th>
                                                                <th>Hora de Cierre</th>
                                                                <th>Estimado</th>
                                                                <th>Real</th>
                                                                <th>Diferencia</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    $arqueo = new Login();
        $reg = $arqueo->BuscarArqueosFechas();
        $a = 1;
        for ($i = 0; $i < sizeof($reg); $i++) {
            ?>
                                                                <tr role="row" class="odd">
                                                                    <td class="sorting_1" tabindex="0"><?php echo $a++; ?></td>
                                                                    <td><?php echo $reg[$i]['nombrecaja']; ?></td>
                                                                    <td><?php echo $reg[$i]['fechaapertura']; ?></td>
                                                                    <td><?php echo $reg[$i]['fechacierre']; ?></td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['montoinicial'] + $reg[$i]['ingresos'] - $reg[$i]['egresos'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['diferencia'], 2, '.', ','); ?>
                                                                    </td>

                                                                </tr>
                                                    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div align="center"><a
                                                            href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("ARQUEOSFECHAS") ?>"
                                                            target="_blank" rel="noopener noreferrer"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                        <a
                                                            href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("ARQUEOSFECHAS") ?>"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php

    }
}
############################# BUSQUEDA ARQUEOS DE CAJAS POR FECHAS ##############################
?>


<?php
############################# BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS ##########################
if (isset($_GET['BuscaMovimientosCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $codcaja = $_GET['codcaja'];
    $codsucursal = $_GET['codsucursal'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($codcaja == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA DE VENTA PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($desde == "") {


        echo "<br><center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
        echo "</div>";
        exit;


    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
        echo "</div>";
        exit;

    } else {

        $movim = new Login();
        $reg = $movim->BuscarMovimientosCajasFechas();

        ?>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Movimientos de <?php echo $reg[0]['nombrecaja']; ?> desde
                    <?php echo $_GET["desde"] . " hasta " . $_GET["hasta"]; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="div1">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="tech-companies-1"
                                                        class="table table-small-font table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Responsable</th>
                                                                <th>Fecha Movimiento</th>
                                                                <th>Tipo Movimiento</th>
                                                                <th>Descripción</th>
                                                                <th>Monto</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                    $a = 1;
        $TotalIngresos = 0;
        $TotalEgresos = 0;
        for ($i = 0; $i < sizeof($reg); $i++) {
            $TotalIngresos += $ingresos = ($reg[$i]['tipomovimientocaja'] == 'INGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
            $TotalEgresos += $egresos = ($reg[$i]['tipomovimientocaja'] == 'EGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
            ?>
                                                                <tr role="row" class="odd">
                                                                    <td class="sorting_1" tabindex="0"><?php echo $a++; ?></td>
                                                                    <td><?php echo $reg[$i]['nombres']; ?></td>
                                                                    <td><?php echo $reg[$i]['fechamovimientocaja']; ?></td>
                                                                    <td><?php echo $status = ($reg[$i]['tipomovimientocaja'] == 'INGRESO' ? "<span class='label label-info'><i class='fa fa-check'></i> " . $reg[$i]['tipomovimientocaja'] . "</span>" : "<span class='label label-danger'><i class='fa fa-times'></i> " . $reg[$i]['tipomovimientocaja'] . "</span>"); ?>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['descripcionmovimientocaja']; ?></td>
                                                                    <td><?php echo $simbolo . number_format($reg[$i]['montomovimientocaja'], 2, '.', ','); ?>
                                                                    </td>

                                                                </tr>
                                                    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <strong>Total Ingresos</strong>
                                            <?php echo $simbolo . number_format($TotalIngresos, 2, '.', ','); ?><br>
                                                    <strong>Total Egresos: </strong>
                                            <?php echo $simbolo . number_format($TotalEgresos, 2, '.', ','); ?><br>
                                                    <strong>Total General: </strong>
                                            <?php echo $simbolo . number_format($TotalIngresos - $TotalEgresos, 2, '.', ','); ?><br>

                                                    <div align="center"><a
                                                            href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("MOVIMIENTOSCAJAS") ?>"
                                                            target="_blank" rel="noopener noreferrer"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                        <a
                                                            href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("MOVIMIENTOSFECHAS") ?>"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php

    }
}
############################# BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS ##########################
?>









































<?php
###################### MUESTRA BUSQUEDA DE ABONOS DE CREDITOS ##########################
if (isset($_GET['BuscaAbonosClientes']) && isset($_GET['codcliente'])) {

    $codcliente = $_GET['codcliente'];

    if ($codcliente == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DE CLIENTE CORRECTAMENTE</div></center>";
        exit;

    } else {

        $bon = new Login();
        $bon = $bon->BuscarClientesAbonos();
        ?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks"></i> Creditos de Ventas del Cliente
                    <?php echo $bon[0]['nomcliente']; ?></h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div1">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="tech-companies-1"
                                                class="table table-small-font table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nº</th>
                                                        <th>Nº Factura</th>
                                                        <th>Total Factura</th>
                                                        <th>Monto Abono</th>
                                                        <th>Total Debe</th>
                                                        <th>Status Crédito</th>
                                                        <th>Dias Vencidos</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $a = 1;
        $TotalFactura = 0;
        $TotalCredito = 0;
        $TotalDebe = 0;
        for ($i = 0; $i < sizeof($bon); $i++) {
            $TotalFactura += $bon[$i]['totalpago'];
            $TotalCredito += $bon[$i]['abonototal'];
            $TotalDebe += $bon[$i]['totalpago'] - $bon[$i]['abonototal'];
            ?>
                                                        <tr>
                                                            <td><?php echo $a++; ?></td>
                                                            <td><abbr
                                                                    title="Fecha Venta: <?php echo date("d-m-Y h:i:s", strtotime($bon[$i]['fechaventa'])); ?>"><?php echo $bon[$i]['codventa']; ?></abbr>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($bon[$i]['totalpago'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($bon[$i]['abonototal'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php echo $simbolo . number_format($bon[$i]['totalpago'] - $bon[$i]['abonototal'], 2, '.', ','); ?>
                                                            </td>
                                                            <td><?php
                if ($bon[$i]['fechavencecredito'] == null) {
                    echo "<span class='label label-success'>" . $bon[$i]["statusventa"] . "</span>";
                } elseif ($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
                    echo "<span class='label label-success'>" . $bon[$i]["statusventa"] . "</span>";
                } elseif ($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
                    echo "<span class='label label-danger'>VENCIDA</span>";
                } ?>
                                                            </td>
                                                            <td><?php
                if ($bon[$i]['fechavencecredito'] == null) {
                    echo "0";
                } elseif ($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
                    echo "0";
                } elseif ($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
                    echo Dias_Transcurridos(date("Y-m-d"), $bon[$i]['fechavencecredito']);
                } ?>
                                                            </td>
                                                            <td>
                                                                <a href="reportepdf?codventa=<?php echo base64_encode($bon[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKETCREDITOS") ?>"
                                                                    target="_black" class="btn btn-info" title="Ticket de Abono"><i
                                                                        class="fa fa-print"></i></a>

                                                                <?php if ($bon[$i]['statusventa'] == 'PAGADA') {
                                                                    echo "<span class='label label-success'> CR&Eacute;DITO PAGADO</span>";
                                                                } else { ?><button
                                                                        type="button"
                                                                        onclick="NuevoAbono('<?php echo $bon[$i]['cedcliente'] ?>','<?php echo $bon[$i]['codventa'] ?>')"
                                                                        class="btn btn-primary"><span class="fa fa-save"></span>
                                                                        Abonar</button><?php } ?> </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Total General</strong></td>
                                                        <td><?php echo $simbolo . number_format($TotalFactura, 2, '.', ','); ?>
                                                        </td>
                                                        <td><?php echo $simbolo . number_format($TotalCredito, 2, '.', ','); ?>
                                                        </td>
                                                        <td><?php echo $simbolo . number_format($TotalDebe, 2, '.', ','); ?></td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
############################# FIN DE BUSQUEDA DE ABONOS DE CREDITOS ######################################
?>


<?php
###################### MUESTRA MUESTRA FORMULARIO PARA PAGOS DE ABONOS DE CREDITOS #######################
if (isset($_GET['MuestraFormularioAbonos']) && isset($_GET['cedcliente']) && isset($_GET['codventa'])) {

    $cedcliente = $_GET['cedcliente'];
    $codventa = $_GET['codventa'];

    $forbon = new Login();
    $forbon = $forbon->BuscaAbonosCreditos();
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-edit"></i> Gestión de Pagos a Créditos de Factura Nº
                <?php echo base64_decode($codventa); ?></h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label class="control-label">RUC/DNI: <span class="symbol required"></span></label>
                                    <input type="text" class="form-control" name="cedcliente" id="cedcliente"
                                        value="<?php echo $forbon[0]['cedcliente']; ?>" readonly="readonly">
                                    <input type="hidden" name="codcliente" id="codcliente"
                                        value="<?php echo $forbon[0]['codcliente']; ?>" readonly="readonly">
                                    <input type="hidden" name="codventa" id="codventa"
                                        value="<?php echo $forbon[0]['codventa']; ?>" readonly="readonly">
                                    <i class="fa fa-pencil form-control-feedback"></i>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Nombre de Cliente: <span
                                            class="symbol required"></span></label>
                                    <input type="text" class="form-control" name="nomcliente" id="nomcliente"
                                        value="<?php echo $forbon[0]['nomcliente']; ?>" readonly="readonly">
                                    <i class="fa fa-pencil form-control-feedback"></i>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Total Factura Cr&eacute;dito: <span
                                            class="symbol required"></span></label>
                                    <input type="text" class="form-control" name="totalpago" id="totalpago"
                                        value="<?php echo $forbon[0]['totalpago']; ?>" readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Total Factura Abono: <span
                                            class="symbol required"></span></label>
                                    <input type="text" class="form-control" name="abonado" id="abonado"
                                        value="<?php echo $total = ($forbon[0]['abonototal'] == '' ? "0.00" : $forbon[0]['abonototal']); ?>"
                                        readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Total Debe: <span class="symbol required"></span></label>
                                    <input type="text" class="form-control" name="totaldebe" id="totaldebe"
                                        value="<?php echo number_format($forbon[0]['totalpago'] - $forbon[0]['abonototal'], 2, '.', ''); ?>"
                                        readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Monto a Pagar: <span
                                            class="symbol required"></span></label>
                                    <input class="form-control" type="text" name="montoabono" id="montoabono"
                                        onKeyPress="EvaluateText('%f', this);"
                                        onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                        onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                        placeholder="Ingrese Monto a Abonar" required="" aria-required="true">
                                    <i class="fa fa-money form-control-feedback"></i>
                                </div>
                            </div>
                        </div><br>


                        <div class="modal-footer">
                            <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span
                                    class="fa fa-save"></span> Registrar Pago</button>
                            <button class="btn btn-danger" type="button"
                                onclick="document.getElementById('montoabono').value = ''"><i
                                    class="fa fa-times-circle"></i> Cancelar</button>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    <?php
}
###################### FIN DE MUESTRA FORMULARIO PARA PAGOS DE ABONOS DE CREDITOS #######################
?>


<?php
############################# BUSQUEDA DE CREDITOS Y DETALLES DE CREDITOS ############################
if (isset($_GET['BuscaCreditosModal']) && isset($_GET['codventa'])) {

    $codventa = $_GET['codventa'];

    $tra = new Login();
    $ve = $tra->CreditosPorId();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <address>
                    <abbr title="N° de Factura"><strong>Nº DE FACTURA: </strong>
                        <?php echo $ve[0]["codventa"]; ?></abbr><br>
                    <abbr title="N° de Serie"><strong>Nº DE SERIE: </strong> <?php echo $ve[0]["codserie"]; ?></abbr><br>
                    <abbr title="N° de Autorizacion"><strong>Nº DE AUTORIZACI&Oacute;N: </strong>
                        <?php echo $ve[0]["codautorizacion"]; ?></abbr><br>
                    <abbr title="Nº de Caja"><strong>Nº DE CAJA: </strong>
                        <?php echo $ve[0]["nrocaja"] . ":" . $ve[0]["nombrecaja"]; ?></abbr><br>

                    <?php if ($ve[0]['codcliente'] == '') { ?>
                        <abbr title="Nombre de Cliente"><strong>CLIENTE:</strong> <?php echo "CONSUMIDOR FINAL"; ?></abbr><br>
                    <?php } else { ?>
                        <abbr title="Nombre de Cliente"><strong>CLIENTE:
                            </strong><?php echo $ve[0]["cedcliente"] . ": " . $ve[0]["nomcliente"]; ?></abbr><br>
                        <abbr title="Direcci&oacute;n de Cliente"><?php echo $ve[0]["direccliente"]; ?></abbr><br>
                        <abbr title="Email de Cliente"><strong>EMAIL: </strong> <?php echo $ve[0]["emailcliente"]; ?></abbr><br>
                        <abbr title="Telefono"><strong>N&deg; DE TLF:</strong></abbr> <?php echo $ve[0]["tlfcliente"]; ?><br />
                    <?php } ?>

                    <abbr title="Tipo de Pago"><strong>TIPO DE PAGO:</strong></abbr>
                    <?php echo $ve[0]["tipopagove"]; ?><br />
                    <abbr title="Forma de Pago"><strong>FORMA DE PAGO:</strong></abbr>
                    <?php echo $variable = ($ve[0]['tipopagove'] == 'CONTADO' ? $ve[0]['mediopago'] : $ve[0]['formapagove']); ?><br />
                    <abbr title="Fecha de Vencimiento de Cr&eacute;dito"><strong>FECHA DE VENCIMIENTO:</strong></abbr>
                    <?php echo $vence = ($ve[0]['fechavencecredito'] == null ? "0" : date("d-m-Y", strtotime($ve[0]['fechavencecredito']))); ?><br />
                    <abbr title="Dias Vencidos de Cr&eacute;dito"><strong>DIAS VENCIDOS:</strong></abbr>
                    <?php
                    if ($ve[0]['fechavencecredito'] == null) {
                        echo "0";
                    } elseif ($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "0";
                    } elseif ($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                        echo Dias_Transcurridos(date("Y-m-d"), $ve[0]['fechavencecredito']);
                    } ?><br />
                    <abbr title="Total Factura"><strong>TOTAL FACTURA:</strong></abbr>
                    <?php echo $simbolo . number_format($ve[0]["totalpago"], 2, '.', ','); ?><br />
                    <abbr title="Total Abono"><strong>TOTAL ABONO:</strong></abbr>
                    <?php echo $simbolo . $total = ($ve[0]['abonototal'] == '' ? "0.00" : $ve[0]['abonototal']); ?><br />
                    <abbr title="Total Debe"><strong>TOTAL DEBE:</strong></abbr>
                    <?php echo $simbolo . number_format($ve[0]['totalpago'] - $ve[0]['abonototal'], 2, '.', ','); ?><br />

                    <abbr title="Fecha de Venta"><strong>FECHA DE VENTA:</strong></abbr>
                    <?php echo date("d-m-Y h:i:s", strtotime($ve[0]['fechaventa'])); ?><br />
                    <abbr title="Status de Venta"><strong>STATUS DE VENTA:</strong></abbr>
                    <?php
                    if ($ve[0]['fechavencecredito'] == null) {
                        echo "<span class='label label-success'>" . $ve[0]["statusventa"] . "</span>";
                    } elseif ($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "<span class='label label-success'>" . $ve[0]["statusventa"] . "</span>";
                    } elseif ($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                        echo "<span class='label label-danger'>VENCIDA</span>";
                    } ?><br />
                    <abbr title="Registrado por"><strong>REGISTRADO POR:</strong></abbr>
                    <?php echo $ve[0]['nombres']; ?><br />
                </address>
            </div>
        </div>
    </div>





    <div class="table-responsive" data-pattern="priority-columns">
        <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="3">Detalles de Abonos</th>
                </tr>
                <tr>
                    <th>C&oacute;digo</th>
                    <th>Monto de Abono</th>
                    <th>Fecha de Abono</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tru = new Login();
    $busq = $tru->VerDetallesCreditos();
    $a = 1;
    for ($i = 0; $i < sizeof($busq); $i++) {
        ?>
                    <tr>
                        <td><?php echo $a++; ?></td>
                        <td><?php echo $simbolo . number_format($busq[$i]["montoabono"], 2, '.', ','); ?></td>
                        <td><?php echo $busq[$i]["fechaabono"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}
############################# FIN DE BUSQUEDA DE CREDITOS Y DETALLES DE CREDITOS ###########################
?>


<?php
######################### MUESTRA BUSQUEDA DE CREDITOS POR CLIENTES PARA REPORTES ##########################
if (isset($_GET['BuscaCreditosClientes']) && isset($_GET['codsucursal']) && isset($_GET['codcliente'])) {

    $codsucursal = $_GET['codsucursal'];
    $codcliente = $_GET['codcliente'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($codcliente == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DE CLIENTE CORRECTAMENTE</div></center>";
        exit;

    } else {

        $bon = new Login();
        $bon = $bon->BuscarClientesAbonos();
        ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-tasks"></i> Créditos de Ventas del Cliente
                    <?php echo $bon[0]['nomcliente']; ?></h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div id="div1">
                                            <div class="table-responsive" data-pattern="priority-columns">
                                                <table id="tech-companies-1"
                                                    class="table table-small-font table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº</th>
                                                            <th>Nº Factura</th>
                                                            <th>Nº de Caja</th>
                                                            <th>Status Crédito</th>
                                                            <th>Dias Vencidos</th>
                                                            <th>Total Factura</th>
                                                            <th>Total Abono</th>
                                                            <th>Total Debe</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $a = 1;
        $TotalFactura = 0;
        $TotalCredito = 0;
        $TotalDebe = 0;
        for ($i = 0; $i < sizeof($bon); $i++) {
            $TotalFactura += $bon[$i]['totalpago'];
            $TotalCredito += $bon[$i]['abonototal'];
            $TotalDebe += $bon[$i]['totalpago'] - $bon[$i]['abonototal'];
            ?>
                                                            <tr>
                                                                <td><?php echo $a++; ?></td>
                                                                <td><?php echo $bon[$i]['codventa']; ?></td>
                                                                <td><?php echo $bon[$i]['nrocaja']; ?></td>
                                                                <td><?php
                if ($bon[$i]['fechavencecredito'] == null) {
                    echo "<span class='label label-success'>" . $bon[$i]["statusventa"] . "</span>";
                } elseif ($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
                    echo "<span class='label label-success'>" . $bon[$i]["statusventa"] . "</span>";
                } elseif ($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
                    echo "<span class='label label-danger'>VENCIDA</span>";
                } ?>
                                                                </td>
                                                                <td><?php
                if ($bon[$i]['fechavencecredito'] == null) {
                    echo "0";
                } elseif ($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
                    echo "0";
                } elseif ($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
                    echo Dias_Transcurridos(date("Y-m-d"), $bon[$i]['fechavencecredito']);
                } ?>
                                                                </td>

                                                                <td><?php echo $simbolo . number_format($bon[$i]['totalpago'], 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($bon[$i]['abonototal'], 2, '.', ','); ?>
                                                                </td>
                                                                <td><?php echo $simbolo . number_format($bon[$i]['totalpago'] - $bon[$i]['abonototal'], 2, '.', ','); ?>
                                                                </td>
                                                                <td>
                                                                    <a href="reportepdf?codventa=<?php echo base64_encode($bon[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKETCREDITOS") ?>"
                                                                        target="_black" class="btn btn-info btn-xs"
                                                                        title="Ticket de Abono"><i class="fa fa-print"></i></a> </td>
                                                            </tr>
                                                    <?php } ?>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td><strong>Total General</strong></td>
                                                            <td><strong><?php echo $simbolo . number_format($TotalFactura, 2, '.', ','); ?></strong>
                                                            </td>
                                                            <td><strong><?php echo $simbolo . number_format($TotalCredito, 2, '.', ','); ?></strong>
                                                            </td>
                                                            <td><strong><?php echo $simbolo . number_format($TotalDebe, 2, '.', ','); ?></strong>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center"><a
                                                        href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo base64_encode("CREDITOSCLIENTES") ?>"
                                                        target="_blank" rel="noopener noreferrer"><button
                                                            class="btn btn-success btn-lg" type="button"><span
                                                                class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                    <a
                                                        href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo base64_encode("CREDITOSCLIENTES") ?>"><button
                                                            class="btn btn-success btn-lg" type="button"><span
                                                                class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                                </div><br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}
########################## FIN DE BUSQUEDA DE CREDITOS POR CLIENTES PARA REPORTES #######################
?>


<?php
######################## MUESTRA BUSQUEDA DE CREDITOS POR FECHAS PARA REPORTES ############################
if (isset($_GET['BuscaCreditosFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

    $codsucursal = $_GET['codsucursal'];
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];

    if ($codsucursal == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($desde == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</div></center>";
        exit;

    } elseif ($hasta == "") {

        echo "<center><div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</div></center>";
        exit;

    } else {

        $bon = new Login();
        $bon = $bon->BuscarCreditosFechas();
        ?>


                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Crèditos por Fechas Desde
                    <?php echo $_GET["desde"] . " hasta " . $_GET["hasta"]; ?></h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="div1">
                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="tech-companies-1"
                                                        class="table table-small-font table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nº</th>
                                                                <th>Nombre Cliente</th>
                                                                <th>Status</th>
                                                                <th>Dias Vencidos</th>
                                                                <th>Nº Factura</th>
                                                                <th>Total Factura</th>
                                                                <th>Total Abono</th>
                                                                <th>Total Debe</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $a = 1;
        $TotalFactura = 0;
        $TotalCredito = 0;
        $TotalDebe = 0;
        for ($i = 0; $i < sizeof($bon); $i++) {
            $TotalFactura += $bon[$i]['totalpago'];
            $TotalCredito += $bon[$i]['abonototal'];
            $TotalDebe += $bon[$i]['totalpago'] - $bon[$i]['abonototal'];
            ?>
                                                                <tr>
                                                                    <td><?php echo $a++; ?></td>
                                                                    <td><abbr
                                                                            title="<?php echo $bon[$i]['cedcliente']; ?>"><?php echo $bon[$i]['nomcliente']; ?></abbr>
                                                                    </td>
                                                                    <td><?php
                    if ($bon[$i]['fechavencecredito'] == null) {
                        echo "<span class='label label-success'>" . $bon[$i]["statusventa"] . "</span>";
                    } elseif ($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "<span class='label label-success'>" . $bon[$i]["statusventa"] . "</span>";
                    } elseif ($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
                        echo "<span class='label label-danger'>VENCIDA</span>";
                    } ?>
                                                                    </td>
                                                                    <td><?php
                    if ($bon[$i]['fechavencecredito'] == null) {
                        echo "0";
                    } elseif ($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
                        echo "0";
                    } elseif ($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
                        echo Dias_Transcurridos(date("Y-m-d"), $bon[$i]['fechavencecredito']);
                    } ?>
                                                                    </td>

                                                                    <td><?php echo $bon[$i]['codventa']; ?></td>
                                                                    <td><?php echo $simbolo . number_format($bon[$i]['totalpago'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($bon[$i]['abonototal'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $simbolo . number_format($bon[$i]['totalpago'] - $bon[$i]['abonototal'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="reportepdf?codventa=<?php echo base64_encode($bon[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKETCREDITOS") ?>"
                                                                            target="_black" rel="noopener noreferrer"
                                                                            class="btn btn-info btn-xs" title="Ticket de Abono"><i
                                                                                class="fa fa-print"></i></a> </td>

                                                                </tr>
                                                    <?php } ?>
                                                            <tr>
                                                                <td colspan="5"><strong>Total General</strong></td>
                                                                <td><strong><?php echo $simbolo . number_format($TotalFactura, 2, '.', ','); ?></strong>
                                                                </td>
                                                                <td><strong><?php echo $simbolo . number_format($TotalCredito, 2, '.', ','); ?></strong>
                                                                </td>
                                                                <td><strong><?php echo $simbolo . number_format($TotalDebe, 2, '.', ','); ?></strong>
                                                                </td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div align="center">
                                                        <a href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("CREDITOSFECHAS") ?>"
                                                            target="_blank" rel="noopener noreferrer"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>

                                                        <a
                                                            href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("CREDITOSFECHAS") ?>"><button
                                                                class="btn btn-success btn-lg" type="button"><span
                                                                    class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>
                                                    </div><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
        <?php
    }
}
########################## FIN DE BUSQUEDA DE CREDITOS POR FECHAS PARA REPORTES #########################
?>