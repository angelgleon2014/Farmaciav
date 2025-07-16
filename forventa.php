<?php
require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();
        $caja = $tra->VerificaCaja();


        if(isset($_POST['btn-submit'])) {
            $reg = $tra->RegistrarVentas();
            exit;
        } elseif(isset($_POST['btn-cliente'])) {
            $reg = $tra->RegistrarClientes();
            exit;
        } elseif(isset($_POST['btn-update'])) {
            $reg = $tra->ActualizarClientes();
            exit;
        }
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
    <script type="text/javascript" src="assets/script/ruc_jquery_validator.min.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/jsventas.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <script type="text/javascript">
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#celcliente").mask("999 9999 999");
        $("#tlfcliente").mask("9999 999");
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#cedcliente").validarCedulaEC({
            onValid: function() {
                $("#cedcliente").focus();
                $('#cedcliente').css('border-color', '#66afe9');
                return true;
            },
            onInvalid: function() {
                $("#cedcliente").val("");
                $("#cedcliente").focus();
                $('#cedcliente').css('border-color', '#f8ca4e');
                alert("La Cedula o Ruc ingresada es Invalida");
                return false;
            }
        });
    });
    </script>
    <!-- script jquery -->

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <!-- Calendario -->

</head>

<body onLoad="muestraReloj(); getTime();" class="fixed-left">

    <!-- Modal para mostrar detalles del producto-->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                src="assets/images/close.png" /></button>
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Búsqueda de Clientes</h3>
                    </div>
                    <form class="form" method="post" action="#" name="buscaclientes" id="buscaclientes">
                        <div class="panel-body">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Realice la Búsqueda de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input class="form-control" type="text" name="buscacliente" id="buscacliente"
                                            onKeyUp="this.value=this.value.toUpperCase(); BusquedaClientes();"
                                            autocomplete="off"
                                            placeholder="Ingrese Cédula o Nombre para Búsqueda de Cliente"
                                            required="required">
                                        <i class="fa fa-search form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="resultado"></div>


                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="reset" class="close" data-dismiss="modal"
                                aria-hidden="true"><i class="fa fa-times-circle"></i> Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                src="assets/images/close.png" /></button>
                        <h3 class="panel-title">Nuevo Cliente</h3>
                    </div>
                    <form class="form" method="post" action="#" name="ventaclientes" id="ventaclientes">
                        <div class="panel-body">
                            <div id="read">
                                <!-- error will be shown here ! -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Cédula de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="cedcliente" id="cedcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Cédula de Cliente" tabindex="1" required=""
                                            aria-required="true">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Nombre de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="nomcliente" id="nomcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Nombre de Cliente" tabindex="2" required=""
                                            aria-required="true">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Dirección de Cliente: <span
                                                class="symbol required"></span></label>
                                        <textarea name="direccliente" class="form-control" id="direccliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" tabindex="3"
                                            autocomplete="off" placeholder="Ingrese Dirección de Cliente" required=""
                                            aria-required="true"></textarea>
                                        <i class="fa fa-map-marker form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Correo de Cliente:</label>
                                        <input type="text" class="form-control" name="emailcliente" id="emailcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Correo de Cliente" tabindex="4">
                                        <i class="fa fa-envelope-o form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">N° Teléfono de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="tlfcliente" id="tlfcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Telefono de Cliente" tabindex="5">
                                        <i class="fa fa-phone form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">N° Celular de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="celcliente" id="celcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese N° de Celular de Cliente" tabindex="6" required=""
                                            aria-required="true">
                                        <i class="fa fa-mobile form-control-feedback"></i>
                                    </div>
                                </div>

                            </div><br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" tabindex="7" name="btn-cliente" id="btn-cliente"
                                class="btn btn-primary"><span class="fa fa-save"></span> Guardar</button>
                            <button class="btn btn-danger" type="reset"><i class="fa fa-trash-o"></i> Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="myModall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                src="assets/images/close.png" /></button>
                        <h3 class="panel-title"><i class="fa fa-edit"></i> Actualizar Cliente</h3>
                    </div>
                    <form class="form" name="updateventaclientes" id="updateventaclientes" method="post" action="#">
                        <div class="panel-body">
                            <div id="update">
                                <!-- error will be shown here ! -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">RUC/DNI de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="hidden" name="codcliente" id="codcliente">
                                        <input type="hidden" name="busqueda" id="busqueda">
                                        <input type="text" class="form-control" name="cedcliente" id="cedcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese RUC/DNI  de Cliente" tabindex="1" required=""
                                            aria-required="true">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Nombre de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="nomcliente" id="nomcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Nombre de Cliente" tabindex="2" required=""
                                            aria-required="true">
                                        <i class="fa fa-pencil form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Dirección de Cliente: <span
                                                class="symbol required"></span></label>
                                        <textarea name="direccliente" class="form-control" id="direccliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" tabindex="3"
                                            autocomplete="off" placeholder="Ingrese Dirección de Cliente" required=""
                                            aria-required="true"></textarea>
                                        <i class="fa fa-map-marker form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Correo de Cliente:</label>
                                        <input type="text" class="form-control" name="emailcliente" id="emailcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Correo de Cliente" tabindex="4">
                                        <i class="fa fa-envelope-o form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">N° Teléfono de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="tlfcliente" id="tlfcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese Telefono de Cliente" tabindex="5">
                                        <i class="fa fa-phone form-control-feedback"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">N° Celular de Cliente: <span
                                                class="symbol required"></span></label>
                                        <input type="text" class="form-control" name="celcliente" id="celcliente"
                                            onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                            placeholder="Ingrese N° de Celular de Cliente" tabindex="6" required=""
                                            aria-required="true">
                                        <i class="fa fa-mobile form-control-feedback"></i>
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
                                        if (file_exists("fotos/" . $_SESSION['cedula'] . ".jpg")) {
                                            echo "<img src='fotos/" . $_SESSION['cedula'] . ".jpg?' class='img-circle'>";
                                        } else {
                                            echo "<img src='fotos/avatar.jpg' class='img-circle'>";
                                        }
                                    } else {
                                        echo "<img src='fotos/avatar.jpg' class='img-circle'>";
                                    }
        ?></div>
                    <div class="user-info">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php
                echo estado($_SESSION['acceso']);
        ?></a>
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
                <!--- INICIO DE MENU -->
                <?php include('menu.php'); ?>
                <!--- FIN DE MENU -->
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
                            <h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Gestión de Ventas</h4>
                            <ol class="breadcrumb pull-right">
                                <li><a href="panel">Inicio</a></li>
                                <li><a href="ventas">Control</a></li>
                                <li class="active">Ventas</li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <form class="form" method="post" action="#" name="ventas" id="ventas">
                        <div class="col-sm-8">
                            <div class="panel panel-primary">
                                    <?php if ($con[0]['productosvencidos'] > 0) { ?>
                                        <div class="panel-heading panel-heading-productos-vencidos">
                                            <h3 class="panel-title"><i class="fa fa-clock-o"></i> Hay productos vencidos o por vencer, favor ver notificaciones</h3>
                                        </div>
                                    <?php } ?>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Detalles de Productos
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="box-body">
                                                <div id="error">
                                                    <!-- error will be shown here ! -->
                                                </div>

                                                <?php
$arqueo = new Login();
        $arqueo = $arqueo->VerificaArqueo();
        ?>

                                                <div class="table-responsive" data-pattern="priority-columns">
                                                    <table id="carrito" class="table table-small-font table-striped">
                                                        <thead>
                                                            <tr style="background:#FFCC66;font-size:14px;">
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Cantidad</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Nombre de Producto</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">IGV</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Precio Unitario</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Valor Total</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Desc %</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Desc/Bonif</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Desc/Porc</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Valor Neto</div>
                                                                </th>
                                                                <th style="color:#FFFFFF;">
                                                                    <div align="center">Acción
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan=10>
                                                                    <center><label>No hay Productos agregados</label>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <hr>

                                                    <table id="carritototal">
                                                        <tr>
                                                            <td width="30"></td>
                                                            <td width="160"><label class="control-label">Descuento %:
                                                                </label></td>
                                                            <td width="200"><label class="control-label">Descuento
                                                                    Bonif: </label></td>
                                                            <td width="140"><label class="control-label">
                                                                </label style="display:none;">
                                                                <label class="control-label">IGV:
                                                                    <?php echo $iva = ($_SESSION['acceso'] == 'administradorG' ? $config[0]['ivavsucursal'] : $_SESSION['ivavsucursal']); ?>
                                                                    <input type="hidden" name="iva" id="iva"
                                                                        value="<?php echo $iva = ($_SESSION['acceso'] == 'administradorG' ? $config[0]['ivavsucursal'] : $_SESSION['ivavsucursal']); ?>">%:</label>
                                                            </td>
                                                            <td width="160"><label class="control-label">Total Sin
                                                                    Impuestos: </label></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><label id="lbldescuento"
                                                                    name="lbldescuento">0.00</label><input type="hidden"
                                                                    name="txtDescuento" id="txtDescuento"
                                                                    value="0.00" /></td>
                                                            <td><label id="lbldescbonif"
                                                                    name="lbldescbonif">0.00</label><input type="hidden"
                                                                    name="txtDescbonif" id="txtDescbonif"
                                                                    value="0.00" /></td>
                                                            <td><label id="lblsubtotal"
                                                                    name="lblsubtotal" style="display:none;">0.00</label><input type="hidden"
                                                                    name="txtsubtotal" id="txtsubtotal" value="0.00" />
                                                                    <label id="lbliva" name="lbliva">0.00</label><input
                                                                    type="hidden" name="txtIva" id="txtIva"
                                                                    value="0.00" />
                                                            </td>
                                                            <td><label id="lblimpuestos"
                                                                    name="lblimpuestos">0.00</label><input type="hidden"
                                                                    name="txtimpuestos" id="txtimpuestos"
                                                                    value="0.00"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td><label class="control-label" style="display:none;">Subtotal Tarifa 0%:</label>
                                                            </td>
                                                            <td><label class="control-label" style="display:none;">Subtotal Tarifa
                                                                    <?php echo $iva = ($_SESSION['acceso'] == 'administradorG' ? $config[0]['ivavsucursal'] : $_SESSION['ivavsucursal']); ?>%:</label>
                                                            </td>
                                                            <td></td>
                                                            <td><label class="control-label"
                                                                    style="font-size:18px;">Total Venta: </label></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td><label id="lbltarifano"
                                                                    name="lbltarifano" style="display:none;">0.00</label><input type="hidden"
                                                                    name="txttarifano" id="txttarifano" value="0.00" />
                                                            </td>
                                                            <td><label id="lbltarifasi"
                                                                    name="lbltarifasi" style="display:none;">0.00</label><input type="hidden"
                                                                    name="txttarifasi" id="txttarifasi" value="0.00" />
                                                            </td>
                                                            <td></td>
                                                            <td><label style="font-size:18px;" id="lbltotal"
                                                                    name="lbltotal">0.00</label>
                                                                <input type="hidden" name="txtTotal" id="txtTotal"
                                                                    value="0.00" /></td>
                                                        </tr>
                                                    </table><br>


                                                    <div class="modal-footer">
                                                        <button type="submit" name="btn-submit" id="btn-submit"
                                                            class="btn btn-primary"><span class="fa fa-save"></span>
                                                            Guardar</button>
                                                        <button class="btn btn-danger" type="button" id="vaciarv"><i
                                                                class="fa fa-trash-o"></i> Limpiar</button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-file-text"></i> Detalle de Factura</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="box-body">
                                                <div align="center" style="color:#000000;font-size:27px;">
                                                    <label>TOTAL:</label> <label id="lblGrande"
                                                        name="lblGrande">0.00</label></div>

                                                    <hr>

                                                    <div class="row">
                                                    <input type="hidden" name="codcaja" id="codcaja"
                                                        value="<?php echo $caja[0]['codcaja']; ?>">
                                                    <input type="hidden" name="codsucursal" id="codsucursal"
                                                        value="<?php echo $_SESSION["codsucursal"]; ?>">
                                                    <input type="hidden" name="cliente" id="cliente" value="0">
                                                    <div class="col-md-12">
                                                        <div class="pull-left">
                                                            <address>
                                                                <abbr title="Nº de Caja"><strong>Nº DE CAJA: </strong>
                                                                    <?php echo $caja[0]["nrocaja"].":".$caja[0]["nombrecaja"]; ?></abbr><br>

                                                                <abbr title="Vendedor"><strong>VENDEDOR:
                                                                    </strong></abbr>
                                                                <?php echo $_SESSION['nombres']; ?><br />

                                                                <abbr title="Búsqueda de Cliente"><strong>BÚSQUEDA DE
                                                                        CLIENTE: </strong> </abbr>

                                                                <img src="assets/images/buscar.png"
                                                                    style="cursor: pointer;" width="20" height="20"
                                                                    title="Búsqueda de Cliente" data-toggle="modal"
                                                                    data-target=".bs-example-modal-lg"
                                                                    data-backdrop="static" data-keyboard="false">

                                                                <img src="assets/images/nuevo.png"
                                                                    style="cursor: pointer;" width="24" height="24"
                                                                    title="Nuevo Cliente" data-toggle="modal"
                                                                    data-target="#myModal" data-backdrop="static"
                                                                    data-keyboard="false"><br />

                                                                <abbr title="Cédula de Cliente"><strong>RUC/DNI:
                                                                    </strong></abbr> <label id="cedcliente"
                                                                    name="cedcliente">SIN ASIGNAR</label><br />

                                                                <abbr title="Nombre de Cliente"><strong>NOMBRE:
                                                                    </strong></abbr> <label id="nomcliente"
                                                                    name="nomcliente">SIN ASIGNAR</label><br />

                                                                <abbr title="Dirección de Cliente"><strong>DIRECCIÓN:
                                                                    </strong></abbr> <label id="direccliente"
                                                                    name="direccliente">SIN ASIGNAR</label><br />

                                                                <abbr title="Fecha de Venta"><strong>FECHA DE
                                                                        VENTA:</strong></abbr> <span
                                                                    id="result3"></span>
                                                                <input type="hidden" name="fecharegistro"
                                                                    id="fecharegistro">
                                                            </address>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Tipo Documento: <span
                                                                    class="symbol required"></span></label>
                                                            <select name="tipodocumento" id="tipodocumento"
                                                                class="form-control" required="" aria-required="true">
                                                                <option value="">SELECCIONE</option>

                                                                <!--<option selected="selected" value="TICKET">TICKET</option>
                           <option value="FACTURA">FACTURA</option>-->
                                                                <?php
                                        $tipo = new Login();
        $tipo = $tipo->ListarTiposDocumento();
        for($i = 0;$i < sizeof($tipo);$i++) {
            ?>
                                                                <option value="<?php echo $tipo[$i]['tipo']; ?>">
                                                                    <?php echo $tipo[$i]['tipo']; ?></option>
                                                                <?php
        }
        ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Tipo de Pago: <span
                                                                    class="symbol required"></span></label>
                                                            <select name="tipopagove" id="tipopagove"
                                                                class="form-control" disabled="disabled"
                                                                onChange="BuscaFormaPagosVentas()" required=""
                                                                aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <option selected="selected" value="CONTADO">CONTADO
                                                                </option>
                                                                <option value="CREDITO">CRÉDITO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <div class="row">

                                                    <div id="muestraformapagoventas">
                                                        <div class="col-md-12">
                                                            <div class="form-group has-feedback">
                                                                <label class="control-label">Medio de Pago: <span
                                                                        class="symbol required"></span></label>
                                                                <select name="codmediopago" id="codmediopago"
                                                                    class="form-control" disabled="disabled"
                                                                    onChange="MuestraCambiosVentas()" required=""
                                                                    aria-required="true">
                                                                    <option value="">SELECCIONE</option>
                                                                    <?php
       $pago = new Login();
        $pago = $pago->ListarMediosPagos();
        for($i = 0;$i < sizeof($pago);$i++) {
            ?>
                                                                    <option
                                                                        value="<?php echo base64_encode($pago[$i]['codmediopago']) ?>"
                                                                        <?php if (!(strcmp('1', $pago[$i]['codmediopago']))) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>>
                                                                        <?php echo $pago[$i]['mediopago'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                    <div id="muestracambiospagos">
                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label class="control-label">Monto Pagado: <span
                                                                        class="symbol required"></span></label>
                                                                <input class="form-control calculodevolucion"
                                                                    type="text" name="montopagado" id="montopagado"
                                                                    onKeyPress="EvaluateText('%f', this);"
                                                                    onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                    onKeyUp="this.value=this.value.toUpperCase();"
                                                                    autocomplete="off"
                                                                    placeholder="Monto Pagado por Cliente"
                                                                    disabled="disabled" required=""
                                                                    aria-required="true">
                                                                <i class="fa fa-usd form-control-feedback"></i>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group has-feedback">
                                                                <label class="control-label">Cambio Devuelto: <span
                                                                        class="symbol required"></span></label>
                                                                <input class="form-control number" type="text"
                                                                    name="montodevuelto" id="montodevuelto"
                                                                    onKeyPress="EvaluateText('%f', this);"
                                                                    onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                    onKeyUp="this.value=this.value.toUpperCase();"
                                                                    autocomplete="off"
                                                                    placeholder="Ingrese Cambio Devuelto a Cliente"
                                                                    disabled="disabled" readonly="readonly" value="0.00"
                                                                    aria-required="true">
                                                                <i class="fa fa-usd form-control-feedback"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>

                                                    <!-- ENVIAR POR CORREO  -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Enviar por correo a:</label>
                                                            <input class="form-control" type="email"
                                                                    name="correo_cliente_to_send" id="correo_cliente_to_send"
                                                                    placeholder="Ingrese Correo del cliente">
                                                        </div>
                                                    </div>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script>
            var resizefunc = [];
            </script>
            <!-- jQuery  -->
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
            <script src="assets/pages/jquery.dashboard.js"></script>
            <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>

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