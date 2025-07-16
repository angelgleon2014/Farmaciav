<?php
require_once("class/model/DetalleVenta.php");

require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();



        ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="assets/images/favicon.png" rel="icon" type="image">
    <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- script jquery -->
    <script src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <!-- script jquery -->

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <!-- Calendario -->

</head>

<body onLoad="muestraReloj()" class="fixed-left">


    <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                src="assets/images/close.png" /></button>
                        <h3 class="panel-title"><i class="fa fa-align-justify"></i> Detalle de Venta</h3>
                    </div>
                    <div class="panel-body">
                        <div id="muestradetalleventamodal"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                class="fa fa-times-circle"></span> Aceptar</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->







    <!-- Modal para Registro de detalleventas-->
    <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none">

        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                src="assets/images/close.png" /></button>
                        <h3 class="panel-title"><i class="fa fa-edit"></i> Actualizar Detalle de Ventas</h3>
                    </div>
                    <form class="form" name="updatedetallesventas" id="updatedetallesventas" method="post" action="#">
                        <div class="panel-body">

                            <div id="error">
                                <!-- error will be shown here ! -->
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Código Venta: <span
                                                class="symbol required"></span></label>
                                        <input type="hidden" name="coddetalleventa" id="coddetalleventa">
                                        <input type="hidden" name="codsucursal" id="codsucursal">
                                        <input type="hidden" name="ivave" id="ivave">
                                        <input type="hidden" name="tipodocumento" id="tipodocumento">
                                        <input type="hidden" name="tipobusquedad2" id="tipobusquedad2">
                                        <input type="hidden" name="codcaja2" id="codcaja2">
                                        <input type="hidden" name="fecha2" id="fecha2">
                                        <input type="hidden" name="codmedida" id="codmedida">
                                        <input type="hidden" name="codpresentacion" id="codpresentacion">
                                        <input type="text" class="form-control" name="codigoventa" id="codigoventa"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Código de Venta" readonly="readonly">
                                        <i class="fa fa-flash form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Código Producto: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="codproducto" id="codproducto"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Código de Producto" readonly="readonly">
                                        <i class="fa fa-flash form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Nombre de Producto: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="producto" id="producto"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Nombre">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Principio Activo: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="principioactivo"
                                            id="principioactivo" onKeyUp="this.value=this.value.toUpperCase();"
                                            autocomplete="off" placeholder="Ingrese Principio Activo"
                                            readonly="readonly">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Descripción: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Descripción de Producto" readonly="readonly">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Unidad de Medida: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="nommedida" id="nommedida"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Unidad de Medida" readonly="readonly">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>



                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Presentación: <span
                                                class="symbol required"></span></label>
                                                <select name="codpresentacion" id="codpresentacion" tabindex="5"
                                                                    class="form-control" aria-required="true" required
                                                                    <?php if(isset($_SESSION) && $_SESSION["acceso"] != "administradorS") {
                                                                        echo "readonly=readonly";
                                                                    } ?>>
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                                $pre = new Login();
        $pre = $pre->ListarPresentacion();
        for ($i = 0; $i < sizeof($pre); $i++) {
            ?>
                                                                            <option value="<?php echo $pre[$i]['codpresentacion'] ?>">
                                                                                <?php echo $pre[$i]['nompresentacion'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group has-feedback">
                                        <label class="control-label">Tipo Cantidad: <span
                                                class="symbol required"></span></label>
                                                <select name="tipocantidad" id="tipocantidad" tabindex="5"
                                                class="form-control" aria-required="true" required
                                                <?php if(isset($_SESSION) && $_SESSION["acceso"] != "administradorS") {
                                                    echo "readonly=readonly";
                                                } ?>>                                                    
                                                    <?php foreach(DetalleVenta::getTipoCantidad() as $tipo) {
                                                        $TIPO = strtoupper($tipo);
                                                        echo "<option value=$tipo> $TIPO </option>";
                                                    }
                                                    ?>
                                                </select>
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Cant. de Venta: <span
                                                class="symbol required"></span></label>
                                        <div id="cargaventainput"><input type="hidden" class="form-control"
                                                name="cantidadventadb" id="cantidadventadb"></div><input type="text"
                                            class="form-control calculoventaunidad" name="cantventa" id="cantventa"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Cantidad" required="" aria-required="true">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Cantidad de Bonif: <span
                                                class="symbol required"></span></label>
                                        <div id="cargabonifventainput"><input type="hidden" class="form-control"
                                                name="cantidadbonifventadb" id="cantidadbonifventadb"></div><input
                                            type="text" class="form-control calculoventaunidad" name="cantbonificv"
                                            id="cantbonificv" onKeyUp="this.value=this.value.toUpperCase();"
                                            autocomplete="off" placeholder="Ingrese Cantidad Bonif" required=""
                                            aria-required="true">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Descuento %: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="descproductov" id="descproductov"
                                            onKeyPress="EvaluateText('%f', this);"
                                            onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Descuento en Farmacia" readonly="readonly">
                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Precio Unitario: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="preciounitario"
                                            id="preciounitario" onKeyPress="EvaluateText('%f', this);"
                                            onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Precio Unitario" readonly="readonly">
                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Valor Total: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="valortotalv" id="valortotalv"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Valor Total" readonly="readonly">
                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Descuento/Porcentaje: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="descporc" id="descporc"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese % Descuento" readonly="readonly">
                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Dcto Bonificación: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="descbonificv" id="descbonificv"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Dcto de Bonificación" readonly="readonly">
                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Valor Neto: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="valornetov" id="valornetov"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Valor Neto" readonly="readonly">

                                        <input type="hidden" name="baseimponible" id="baseimponible"
                                            readonly="readonly">

                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">IGV de Producto: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="ivaproductov" id="ivaproductov"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese IGV de Producto" readonly="readonly">
                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Fecha de Venta: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="fechadetalleventa"
                                            id="fechadetalleventa" onKeyUp="this.value=this.value.toUpperCase();"
                                            autocomplete="off" placeholder="Ingrese Fecha de Compra"
                                            readonly="readonly">
                                        <i class="fa fa-calendar form-control-feedback"></i>
                                    </div>
                                </div>
                            </div><br>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="btn-update" id="btn-update" class="btn btn-primary"><span
                                    class="fa fa-edit"></span> Actualizar</button>
                            <button class="btn btn-danger" type="reset" class="close" data-dismiss="modal"
                                aria-hidden="true"><i class="fa fa-trash-o"></i> Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="wrapper">
        <div class="topbar">
            <div class="topbar-left">
                <div class="text-center">
                    <?php if (isset($_SESSION['rucsucursal'])) {

                        if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                            echo "<a href='panel' class='logo'><img src='fotos/".$_SESSION['rucsucursal'].".png?' height='50'></a>";
                        } else {

                            echo "<a href='panel' class='logo'><img src='assets/images/logo_white_2.png' height='50'></a>";
                        }

                    } else {

                        echo "<a href='panel' class='logo'><img src='assets/images/logo_white_2.png' height='50'></a>";

                    }
        ?>
                    <a href="panel" class="logo-sm"><img src="assets/images/logo_sm.png" height="50"></a>
                </div>
            </div>
            <div class="navbar navbar-default" role="navigation">
                <div class="container">
                    <div class="">
                        <div class="pull-left">
                            <button type="button" class="button-menu-mobile open-left waves-effect waves-light"><i
                                    class="ion-navicon"></i> </button>
                            <span class="clearfix"></span></div>
                        <form class="navbar-form pull-left" role="search">
                            <div class="form-group">
                                <input class="form-control search-bar" placeholder="Búsqueda..." type="text">
                            </div>
                            <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                        </form>
                        <ul class="nav navbar-nav navbar-right pull-right">

                            <!--- MEJORAR DE AQUI ---->
                            <!-- Reloj start-->
                            <li id="header_inbox_bar" class="dropdown hidden-xs">
                                <a data-toggle="dropdown" class="hour" href="#">
                                    <span id="spanreloj"></span>
                                </a>
                            </li>
                            <!-- Reloj end -->

                            <li class="dropdown hidden-xs">
                                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light"
                                    data-toggle="dropdown" title="Notificaciones de Pedidos" aria-expanded="true">
                                    <i class="fa fa-bell"></i>
                                    <span
                                        class="badge badge-xs badge-danger"><?php echo $con[0]['stockproductos'] + $con[0]['productosvencidos'] + $con[0]['creditoscomprasvencidos'] + $con[0]['creditosventasvencidos']; ?></span>
                                </a>

                                 <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="text-center notifi-title">Notificaciones</li>
                                        <li class="list-group">
                                           <!-- list item-->
    <a href="buscastockminimo" class="dropdown-toggle waves-effect list-group-item">
                                              <div class="media">
                                                 <div class="pull-left">
                                                    <em class="fa fa-cube fa-2x text-danger"></em>
                                                 </div>
                                                 <div class="media-body clearfix">
                                <div class="media-heading">Productos en Stock Minimo</div>
                                                    <p class="m-0">
<small>Existen <span class="text-primary"><?php echo $con[0]['stockproductos']; ?></span> Productos en Stock</small>
                           </p>
                                                 </div>
                                              </div>
                                           </a>
                                           <!-- list item-->
    <a href="productosvencidos" class="dropdown-toggle waves-effect list-group-item">
                                              <div class="media">
                                                 <div class="pull-left">
                                                    <em class="fa fa-calendar fa-2x text-warning"></em>
                                                 </div>
                                                 <div class="media-body clearfix">
                                        <div class="media-heading">Productos Vencidos</div>
                                                    <p class="m-0">
<small>Existen <span class="text-primary"><?php echo $con[0]['productosvencidos']; ?></span> Productos Vencidos</small>
                           </p>
                                                 </div>
                                              </div>
                                           </a>
                                           <!-- list item-->
    <a href="comprasxpagar" class="list-group-item">
                                 <div class="media">
                                                 <div class="pull-left">
                                                    <em class="fa fa-truck fa-2x text-info"></em>
                                                </div>
                           <div class="media-body clearfix">
                                <div class="media-heading">Créditos de Compras</div>
                                                    <p class="m-0">
<small>Existen <span class="text-primary"><?php echo $con[0]['creditoscomprasvencidos']; ?></span> Créditos Vencidos</small>                                                    </p>
                                                 </div>
                                              </div>
                                            </a>
                                            <!-- list item-->
    <a href="creditofecha" class="list-group-item">
                                              <div class="media">
                                                 <div class="pull-left">
                                    <em class="fa fa-cart-plus fa-2x text-success"></em>
                                                </div>
                                                 <div class="media-body clearfix">
                                        <div class="media-heading">Créditos de Ventas</div>
                                                    <p class="m-0">
<small>Existen <span class="text-primary"><?php echo $con[0]['creditosventasvencidos']; ?></span> Créditos Vencidos</small>                                                    </p>
                                                 </div>
                                              </div>
                                            </a>
                                           <!-- last list item -->
                             </li>
                    </ul>
                            </li>
                            <!--- MEJORAR DE AQUI ---->

                            <li class="hidden-xs">
                                <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i
                                        class="fa fa-crosshairs"></i></a> </li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle profile waves-effect waves-light"
                                    data-toggle="dropdown" aria-expanded="true">

                                    <span class="dropdown hidden-xs"><abbr
                                            title="<?php echo estado($_SESSION['acceso']); ?>"><?php echo $_SESSION['nombres']; ?></abbr></span>
                                    <?php
                                if (isset($_SESSION['cedula'])) {
                                    if (file_exists("fotos/".$_SESSION['cedula'].".jpg")) {
                                        echo "<img src='fotos/".$_SESSION['cedula'].".jpg?' class='img-circle'>";
                                    } else {
                                        echo "<img src='fotos/avatar.jpg' class='img-circle'>";
                                    }
                                } else {
                                    echo "<img src='fotos/avatar.jpg' class='img-circle'>";
                                }
        ?> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="perfil"><i class="fa fa-user"></i> Mi Perfil</a></li>
                                    <li><a href="password"><i class="fa fa-edit"></i> Actualizar Password </a></li>
                                    <li><a href="bloqueo"><i class="fa fa-clock-o"></i> Bloquear Sesión</a></li>
                                    <li class="divider"></li>
                                    <li><a href="logout"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="left side-menu">
            <div class="sidebar-inner slimscrollleft" style="overflow: hidden; width: auto; height: 566px;">

                <div class="user-details">
                    <div class="text-center"> <?php
                                if (isset($_SESSION['cedula'])) {
                                    if (file_exists("fotos/".$_SESSION['cedula'].".jpg")) {
                                        echo "<img src='fotos/".$_SESSION['cedula'].".jpg?' class='img-circle'>";
                                    } else {
                                        echo "<img src='fotos/avatar.jpg' class='img-circle'>";
                                    }
                                } else {
                                    echo "<img src='fotos/avatar.jpg' class='img-circle'>";
                                }
        ?></div>
                    <div class="user-info">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false"><?php echo estado($_SESSION['acceso']); ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="perfil"><i class="fa fa-user"></i> Mi Perfil</a></li>
                                <li><a href="password"><i class="fa fa-edit"></i> Actualizar Password </a></li>
                                <li><a href="bloqueo"><i class="fa fa-clock-o"></i> Bloquear Sesión</a></li>
                                <li class="divider"></li>
                                <li><a href="logout"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
                            </ul>
                        </div>
                        <p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i> Online</p>
                    </div>
                </div>



                <!----- INICIO DE MENU ----->
                <?php include('menu.php'); ?>
                <!----- FIN DE MENU ----->


                <div class="clearfix"></div>

            </div>
        </div>
    </div>

    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-header-title">
                            <h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Control Detalles de Ventas</h4>
                            <ol class="breadcrumb pull-right">
                                <li><a href="panel">Inicio</a></li>
                                <li class="active">Control Detalles de Ventas</li>
                            </ol>

                            <div class="clearfix"></div>

                        </div>
                    </div>
                </div>

                <div>
                    <?php if ($con[0]['productosvencidos'] > 0) { ?>
                        <div class="panel-heading panel-heading-productos-vencidos">
                            <h3 class="panel-title"><i class="fa fa-clock-o"></i> Hay productos vencidos o por vencer, favor ver notificaciones</h3>
                        </div>
                    <?php } ?>
                </div>

                <div class="row">
                    <div class="col-sm-12" style="display:none">
                        <form class="form" method="post" action="#" name="buscardetallesventas"
                            id="buscardetallesventas">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-tasks"></i> Búsqueda Detalles de Ventas</h3>
                                </div>
                                <div class="panel-body">
                                  
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="box-body">

                                                <div id="delete-ok"></div>

                                                <div class="row">


                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Tipo de Búsqueda: <span
                                                                    class="symbol required"></span></label>
                                                            <select name="tipobusquedad" id="tipobusquedad"
                                                                class="form-control" onchange="ff()" required=""
                                                                aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="1">POR FACTURA</option>
                                                                <option value="2">POR CAJA</option>
                                                                <option value="3">POR FECHA</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Ingrese Nº de Factura: <span
                                                                    class="symbol required"></span></label>
                                                            <input class="form-control" type="text" name="codventa"
                                                                id="codventa"
                                                                onKeyUp="this.value=this.value.toUpperCase();"
                                                                autocomplete="off" placeholder="Ingrese Nº de Factura"
                                                                required="required">
                                                            <i class="fa fa-search form-control-feedback"></i>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Seleccione Caja: <span
                                                                    class="symbol required"></span></label>
                                                            <select name="codcaja" id="codcaja" class="form-control"
                                                                required="" aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                    $caja = new Login();
        $caja = $caja->ListarCajas();
        for($i = 0;$i < sizeof($caja);$i++) {
            ?>
                                                                <option value="<?php echo $caja[$i]['codcaja']; ?>">
                                                                    <?php echo $caja[$i]['nrocaja']."-".$caja[$i]['nombrecaja']; ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Ingrese Fecha de Venta: <span
                                                                    class="symbol required"></span></label>
                                                            <input class="form-control calendario" type="text"
                                                                name="fecha" id="fecha"
                                                                onKeyUp="this.value=this.value.toUpperCase();"
                                                                autocomplete="off" placeholder="Ingrese Fecha de Venta"
                                                                tabindex="2" required="" aria-required="true">
                                                            <i class="fa fa-calendar form-control-feedback"></i>
                                                        </div>
                                                    </div>



                                                </div><br>
                                                <div class="modal-footer">
                                                    <button type="button" onClick="BuscarDetallesVentas()"
                                                        class="btn btn-primary"><span class="fa fa-search"></span>
                                                        Realizar Búsqueda</button>
                                                </div>



                                            </div><!-- /.box-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="muestradetallesventas"></div>
                        </form>


                    </div>

                    <div class="col-md-12">
					<div class="table-responsive">
                    <div id="">
                               
                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline collapsed" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Nº Factura</th>
                                                <th>Descripción de Producto</th>
                                                <th>Presentación</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                    $tra1 = new Login();

        $reg = $tra1->ListarDetallesVentas();

        if($reg == "") {

            echo "";

        } else {

            $a = 1;
            for($i = 0;$i < sizeof($reg);$i++) {
                ?>
                <script>
                window[<?php echo "'precios-detalle-".$reg[$i]['coddetalleventa']."'"; ?>] =
                <?php echo json_encode(
                    DetalleVenta::findOne([['coddetalleventa', '=', $reg[$i]['coddetalleventa']]])
                        ->getProducto()->preciosPorTipo()
                    );
                ?>
                </script>
                                                                <tr>
                                                                    <td><?php echo $a++; ?></td>
                                                                    <td><abbr
                                                                            title="TIPO DOCUMENTO: <?php echo $reg[$i]['tipodocumento']; ?>"><?php echo $reg[$i]['codventa']; ?></abbr>
                                                                    </td>
                                                                    <td><abbr
                                                                            title="<?php echo "Nº ".$reg[$i]['codproductov']; ?>"><?php echo $reg[$i]['productov']." ".$reg[$i]['nommedida']; ?></abbr>
                                                                    </td>
                                                                    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                                                    <td><?php echo number_format($reg[$i]['preciounitario'], 2, '.', ','); ?>
                                                                    </td>
                                                                    <td><?php echo $cantidad = ($reg[$i]['cantbonificv'] == '0' ? $reg[$i]['cantventa'] : $reg[$i]['cantventa']."+".$reg[$i]['cantbonificv']); ?>
                                                                    </td>
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
                                                        <?php
            }
        } ?>
                                        </tbody>
                                    </table>
                                <br />
                            </div>
						</div>
                    </div>
                </div>
            </div>

            <footer class="footer"> <i class="fa fa-copyright"></i> <span class="current-year"></span>. </footer>
        </div>
    </div>


    <script>
    var resizefunc = [];
    </script>

    <!-- jQuery  
        <script src="assets/js/jquery.min.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <script src="assets/js/jquery.app.js"></script>

    <!-- jQuery  -->
    <script src="assets/plugins/moment/moment.js"></script>

    <!-- jQuery  -->
    <script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
    <script src="assets/plugins/counterup/jquery.counterup.min.js"></script>

    <!-- Datatables-->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="assets/plugins/datatables/jszip.min.js"></script>
    <script src="assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>

    <!-- jQuery  -->
    <script src="assets/pages/jquery.todo.js"></script>

    <!-- jQuery  -->
    <script src="assets/pages/jquery.dashboard.js"></script>

    <script type="text/javascript">
    /* ==============================================
            Counter Up
            =============================================== */
    jQuery(document).ready(function($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });
    });
    </script>


    <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
            keys: true
        });
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({
            ajax: "assets/plugins/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });
    });
    TableManageButtons.init();
    </script>


</body>

</html>
<?php } else { ?>
<script type='text/javascript' language='javascript'>
alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')
document.location.href = 'panel'
</script>
<?php }
} else { ?>
<script type='text/javascript' language='javascript'>
alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')
document.location.href = 'logout'
</script>
<?php } ?>