<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();
        $config = $tra->ConfiguracionPorId();

        if (isset($_POST['btn-submit'])) {
            $reg = $tra->RegistrarCompras();
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
            <script type="text/javascript" src="assets/script/titulos.js"></script>
            <script type="text/javascript" src="assets/script/script2.js"></script>
            <script type="text/javascript" src="assets/script/jscompras.js"></script>
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
            <div id="wrapper">
                <div class="topbar">
                    <div class="topbar-left">
                        <div class="text-center">
                            <?php if (isset($_SESSION['rucsucursal'])) {

                                if (file_exists("fotos/" . $_SESSION['rucsucursal'] . ".png")) {

                                    echo "<a href='panel' class='logo'><img src='fotos/" . $_SESSION['rucsucursal'] . ".png?' height='50'></a>";
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
                                    <button type="button" class="button-menu-mobile open-left waves-effect waves-light"><i class="ion-navicon"></i></button>
                                    <span class="clearfix"></span>
                                </div>
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
                                        <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" title="Notificaciones de Pedidos" aria-expanded="true">
                                            <i class="fa fa-bell"></i>
                                            <span class="badge badge-xs badge-danger"><?php echo $con[0]['stockproductos'] + $con[0]['productosvencidos'] + $con[0]['creditoscomprasvencidos'] + $con[0]['creditosventasvencidos']; ?></span>
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
                                                                <small>Existen <span class="text-primary"><?php echo $con[0]['stockproductos']; ?></span>
                                                                    Productos en Stock</small>
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
                                                                <small>Existen <span class="text-primary"><?php echo $con[0]['productosvencidos']; ?></span>
                                                                    Productos Vencidos</small>
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
                                                                <small>Existen <span class="text-primary"><?php echo $con[0]['creditoscomprasvencidos']; ?></span>
                                                                    Créditos Vencidos</small>
                                                            </p>
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
                                                                <small>Existen <span class="text-primary"><?php echo $con[0]['creditosventasvencidos']; ?></span>
                                                                    Créditos Vencidos</small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- last list item -->
                                            </li>
                                        </ul>
                                    </li>
                                    <!--- MEJORAR DE AQUI ---->

                                    <li class="hidden-xs">
                                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="fa fa-crosshairs"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">

                                            <span class="dropdown hidden-xs"><abbr title="<?php echo estado($_SESSION['acceso']); ?>"><?php echo $_SESSION['nombres']; ?></abbr></span>
                                            <?php
                        if (isset($_SESSION['cedula'])) {
                            if (file_exists("fotos/" . $_SESSION['cedula'] . ".jpg")) {
                                echo "<img src='fotos/" . $_SESSION['cedula'] . ".jpg?' class='img-circle'>";
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
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo estado($_SESSION['acceso']); ?></a>
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
                                    <h4 class="pull-left page-title"><i class="fa fa-tasks"></i>
                                        Gestión de Compras</h4>
                                    <ol class="breadcrumb pull-right">
                                        <li><a href="panel">Inicio</a></li>
                                        <li><a href="compras">Control</a></li>
                                        <li class="active">Compras</li>
                                    </ol>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <form class="form" method="post" action="#" name="compras" id="compras">
                                <div class="col-sm-8">
                                    <div class="panel panel-primary">
                                        <?php if ($con[0]['productosvencidos'] > 0) { ?>
                                            <div class="panel-heading panel-heading-productos-vencidos">
                                                <h3 class="panel-title"><i class="fa fa-clock-o"></i> Hay productos vencidos o por vencer, favor ver notificaciones</h3>
                                            </div>
                                        <?php } ?>
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-edit"></i> Gestión de Compras
                                                <!--<SUB>Texto Indice</SUB> - Texto normal - <SUP>Texto Exponente</SUP>-->
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <div class="box-body">
                                                        <div id="error">
                                                            <!-- error will be shown here ! -->
                                                        </div>


                                                        <div class="row">

                                                            <div class="col-md-12">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Búsqueda de Productos: </label>
                                                                    <input type="text" class="form-control agregac" name="busquedaproductoc" id="busquedaproductoc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="8" placeholder="Búsqueda de Productos Existentes">
                                                                    <i class="fa fa-search form-control-feedback"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Código Producto: <span class="symbol required"></span></label>
                                                                    <input type="text" class="form-control agregac" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="9" placeholder="Ingrese Código">
                                                                    <i class="fa fa-pencil form-control-feedback"></i>

                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Nombre de Producto: <span class="symbol required"></span></label>
                                                                    <input type="text" class="form-control agregac" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="10" placeholder="Ingrese Nombre">
                                                                    <i class="fa fa-pencil form-control-feedback"></i>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Cant Compra: <span class="symbol required"></span></label>
                                                                    <input type="text" class="form-control agregac" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="11" placeholder="Ingrese Cantidad Compra" value="0">
                                                                    <i class="fa fa-pencil form-control-feedback"></i>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Tipo: <span class="symbol required"></span> </label>
                                                                    <select class="form-control" id="tipo-select" name="tipo_pre">
                                                                        <option value="unidad">Unidad</option>
                                                                        <option value="blister">Blister</option>
                                                                        <option value="caja">Caja</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Cant Bonif: <span class=""></span></label>
                                                                    <input type="text" class="form-control agregac" name="cantidad2" id="cantidad2" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="12" placeholder="Ingrese Cantidad Bonif" value="0">
                                                                    <i class="fa fa-pencil form-control-feedback"></i>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">


                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Dcto en Factura: <span class=""></span></label>
                                                                    <input class="form-control agregac" type="text" name="descfactura" id="descfactura" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="13" placeholder="Ingrese Descuento en Factura" value="0.00">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Dcto en Farmacia: <span class=""></span></label>
                                                                    <input class="form-control agregac" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="14" placeholder="Ingrese Descuento en Farmacia" value="0.00">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">IGV de Producto: <span class="symbol required"></span></label>
                                                                    <select name="ivaproducto" id="ivaproducto" tabindex="15" class="form-control agregac">
                                                                        <option value="">SELECCIONE</option>
                                                                        <option value="SI">SI</option>
                                                                        <option value="NO">NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">N° de Lote: <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac" type="text" name="lote" id="lote" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="16" placeholder="N° Lote">
                                                                    <i class="fa fa-flash form-control-feedback"></i>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Precio Compra Caja: <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac" type="text" name="preciocompra" id="preciocompra" tabindex="17" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Precio de Compra">
                                                                    <input class="form-control" type="hidden" name="precioconiva" id="precioconiva" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" value="0.00">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Precio Venta (Caja): <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac calculounidad" type="text" name="precioventacaja" id="precioventacaja" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="18" placeholder="Precio de Venta (Cajas)">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Unidades por Cajas: <span class="symbol required"></span></label>
                                                                    <input type="text" class="form-control agregac calculounidad" name="unidades" id="unidades" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="19" placeholder="Ingrese Cantidad Bonif" value="0">
                                                                    <i class="fa fa-pencil form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Precio Venta (Unid): <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac" type="text" name="precioventaunidad" id="precioventaunidad" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="20" placeholder="Precio de Venta (Unidad)">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Precio Compra Unidad: <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac" type="text" name="preciocompraunidad" id="preciocompraunidad" tabindex="17" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Precio de Compra">
                                                                    <input class="form-control" type="hidden" name="precioconiva" id="precioconiva" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" value="0.00">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Precio Compra Blister: <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac" type="text" name="preciocomprablister" id="preciocomprablister" tabindex="17" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Precio de Compra">
                                                                    <input class="form-control" type="hidden" name="precioconiva" id="precioconiva" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" value="0.00">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Cantidad Blister: <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac" type="text" name="blisterunidad" id="blisterunidad" tabindex="17" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad Blister">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Precio Venta Blister: <span class="symbol required"></span></label>
                                                                    <input class="form-control agregac" type="text" name="precioventablister" id="precioventablister" tabindex="17" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Precio de Compra">
                                                                    <input class="form-control" type="hidden" name="precioconiva" id="precioconiva" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" value="0.00">
                                                                    <i class="fa fa-money form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Fecha de Expiración:
                                                                            <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac calendario" name="fechaexpiracion" id="fechaexpiracion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="28" placeholder="Ingrese Fecha de Expiración">
                                                                        <i class="fa fa-calendar form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                    <label class="control-label">Precio Venta Blis. Desc :
                                                                            <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac" name="precioventablisterdesc" id="precioventablisterdesc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="28" placeholder="0">
                                                                        <i class="fa fa-money form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                    <label class="control-label">Precio Venta Caja. Desc :
                                                                            <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac" name="precioventacajadesc" id="precioventacajadesc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="28" placeholder="0">
                                                                        <i class="fa fa-money form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                    <label class="control-label">Precio Venta Unidad. Desc :
                                                                            <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac" name="precioventaunidaddesc" id="precioventaunidaddesc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="28" placeholder="0">
                                                                        <i class="fa fa-money form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">Producto Obsequiado?</label>
                                                                        <select name="is_shift" id="is_shift" class="form-control">
                                                                            <option value="0">NO</option>
                                                                            <option value="1">SI</option>
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                                

                                                                
                                                        </div>


                                                        <div id="nuevoproducto" style="display: none;">

                                                            <div class="row">

                                                                <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Principio Activo: <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac" name="principioactivo" id="principioactivo" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="21" placeholder="Ingrese Principio Activo">
                                                                        <i class="fa fa-pencil form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Descripción: <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac" name="descripcion" id="descripcion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="22" placeholder="Ingrese Descripción">
                                                                        <i class="fa fa-pencil form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Presentación: <span class="symbol required"></span></label>
                                                                        <select name="codpresentacion" id="codpresentacion" tabindex="23" class="form-control agregac">
                                                                            <option value="">SELECCIONE</option>
                                                                            <?php
                            $pre = new Login();
        $pre = $pre->ListarPresentacion();
        for ($i = 0; $i < sizeof($pre); $i++) {
            ?>
                                                                                <option value="<?php echo $pre[$i]['codpresentacion']; ?>"><?php echo $pre[$i]['nompresentacion']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Unidad de Medida: <span class="symbol required"></span></label>
                                                                        <select name="codmedida" id="codmedida" tabindex="24" class="form-control agregac">
                                                                            <option value="">SELECCIONE</option>
                                                                            <?php
            $med = new Login();
        $med = $med->ListarMedidas();
        for ($i = 0; $i < sizeof($med); $i++) {
            ?>
                                                                                <option value="<?php echo $med[$i]['codmedida'] ?>"><?php echo $med[$i]['nommedida'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Laboratorio: </label>
                                                                        <select name="codlaboratorio" id="codlaboratorio" tabindex="25" class="form-control agregac">
                                                                            <option value="">SELECCIONE</option>
                                                                            <?php
            $lab = new Login();
        $lab = $lab->ListarLaboratorios();
        for ($i = 0; $i < sizeof($lab); $i++) {
            ?>
                                                                                <option value="<?php echo $lab[$i]['codlaboratorio'] ?>"><?php echo $lab[$i]['nomlaboratorio'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Código de
                                                                            Barra: </label>
                                                                        <input type="text" class="form-control agregac" name="codigobarra" id="codigobarra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra" tabindex="26">
                                                                        <i class="fa fa-barcode form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Fecha de Elaboración:
                                                                            <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac calendario" name="fechaelaboracion" id="fechaelaboracion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="27" placeholder="Ingrese Fecha de Elaboración">
                                                                        <i class="fa fa-calendar form-control-feedback"></i>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-3">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Fecha de Expiración:
                                                                            <span class="symbol required"></span></label>
                                                                        <input type="text" class="form-control agregac calendario" name="fechaexpiracion" id="fechaexpiracion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="28" placeholder="Ingrese Fecha de Expiración">
                                                                        <i class="fa fa-calendar form-control-feedback"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <div align="right">
                                                            <button type="button" id="AgregaC" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar
                                                            </button>

                                                            <button type="button" id="boton" onClick="mostrar();" style="cursor: pointer;" class="btn btn-success"><span class="fa fa-edit"></span> Editar
                                                            </button>
                                                        </div>
                                                        <hr>


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
                                                                            <div align="center">Precio Unit</div>
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
                                                                            <div align="center">Valor Neto</div>
                                                                        </th>
                                                                        <th style="color:#FFFFFF;">
                                                                            <div align="center">Tipo</div>
                                                                        </th>
                                                                        <th style="color:#FFFFFF;">
                                                                            <div align="center">Acción
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan=9>
                                                                            <center><label>No hay Productos agregados</label>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <table id="carritototal">
                                                                <tr>
                                                                    <td width="30"></td>
                                                                    <td width="160"><label class="control-label">Descuento
                                                                            %: </label></td>
                                                                    <td width="200"><label class="control-label">Descuento
                                                                            Bonif: </label></td>
                                                                    <td width="140"><label class="control-label">Subtotal: </label>
                                                                    </td>
                                                                    <td width="160"><label class="control-label">Total Sin
                                                                            Impuestos: </label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><label id="lbldescuento" name="lbldescuento">0.00</label><input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00" /></td>
                                                                    <td><label id="lbldescbonif" name="lbldescbonif">0.00</label><input type="hidden" name="txtDescbonif" id="txtDescbonif" value="0.00" /></td>
                                                                    <td><label id="lblsubtotal" name="lblsubtotal">0.00</label><input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00" /></td>
                                                                    <td><label id="lblimpuestos" name="lblimpuestos">0.00</label><input type="hidden" name="txtimpuestos" id="txtimpuestos" value="0.00" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td><label class="control-label">Subtotal Tarifa
                                                                            0%:</label></td>
                                                                    <td><label class="control-label">Subtotal
                                                                            Tarifa <?php echo $iva = ($_SESSION['acceso'] == 'administradorG' ? $config[0]['ivacsucursal'] : $_SESSION['ivacsucursal']); ?>
                                                                            %:</label></td>
                                                                    <td>
                                                                        <label class="control-label">IGV: <?php echo $iva = ($_SESSION['acceso'] == 'administradorG' ? $config[0]['ivacsucursal'] : $_SESSION['ivacsucursal']); ?>
                                                                            <input type="hidden" name="iva" id="iva" value="<?php echo $iva = ($_SESSION['acceso'] == 'administradorG' ? $config[0]['ivacsucursal'] : $_SESSION['ivacsucursal']); ?>">%:</label>
                                                                    </td>
                                                                    <td><label class="control-label" style="font-size:18px;">Total
                                                                            Factura: </label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td><label id="lbltarifano" name="lbltarifano">0.00</label><input type="hidden" name="txttarifano" id="txttarifano" value="0.00" /></td>
                                                                    <td><label id="lbltarifasi" name="lbltarifasi">0.00</label><input type="hidden" name="txttarifasi" id="txttarifasi" value="0.00" /></td>
                                                                    <td><label id="lbliva" name="lbliva">0.00</label><input type="hidden" name="txtIva" id="txtIva" value="0.00" /></td>
                                                                    <td><label style="font-size:18px;" id="lbltotal" name="lbltotal">0.00</label>
                                                                        <input type="hidden" class="calculodevolucion" name="txtTotal" id="txtTotal" value="0.00" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <br>


                                                        <div class="modal-footer">
                                                            <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span>
                                                                Guardar
                                                            </button>
                                                            <button class="btn btn-danger" id="vaciarc" type="reset"><i class="fa fa-trash-o"></i> Limpiar
                                                            </button>
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


                                                        <div align="center" style="color:#000000;font-size:27px;"><label>TOTAL:</label>
                                                            <label id="lblGrande" name="lblGrande">0.00</label>
                                                        </div>

                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">N° de Compra: <span class="symbol required"></span></label>
                                                                    <input class="form-control" type="text" name="codcompra" id="codcompra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="N° Compra" tabindex="1" required="" aria-required="true">
                                                                    <i class="fa fa-flash form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Fecha de Emisión: </label>
                                                                    <input type="text" class="form-control expira" name="fechaemision" id="fechaemision" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha de Emisión" tabindex="2">
                                                                    <i class="fa fa-calendar form-control-feedback"></i>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Fecha de Recepc: </label>
                                                                    <input type="text" class="form-control expira" name="fecharecepcion" id="fecharecepcion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha de Recepción" tabindex="3">
                                                                    <i class="fa fa-calendar form-control-feedback"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Proveedor: </label>
                                                                    <select name="codproveedor" id="codproveedor" class="form-control" tabindex="4">
                                                                        <option value="">SELECCIONE</option>
                                                                        <?php
                                                                        $proveedor = new Login();
        $proveedor = $proveedor->ListarProveedores();
        for ($i = 0; $i < sizeof($proveedor); $i++) {
            ?>
                                                                            <option value="<?php echo $proveedor[$i]['codproveedor'] ?>"><?php echo $proveedor[$i]['nomproveedor'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">

                                                            <?php if ($_SESSION['acceso'] == "administradorS") { ?>

                                                                <div class="col-md-12">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Sucursal Asignada:
                                                                            <span class="symbol required"></span></label>
                                                                        <input type="hidden" class="form-control" name="codsucursal" id="codsucursal" value="<?php echo $_SESSION["codsucursal"]; ?>">
                                                                        <input type="text" class="form-control" name="sucursal" id="sucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="5" value="<?php echo $_SESSION["razonsocial"]; ?>" readonly="readonly">
                                                                        <i class="fa fa-bank form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                            <?php } else { ?>

                                                                <div class="col-md-12">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Sucursal: <span class="symbol required"></span></label>
                                                                        <select name="codsucursal" id="codsucursal" tabindex="5" class="form-control">
                                                                            <option value="">SELECCIONE</option>
                                                                            <?php
                $sucursal = new Login();
                                                                $sucursal = $sucursal->ListarSucursal();
                                                                for ($i = 0; $i < sizeof($sucursal); $i++) {
                                                                    ?>
                                                                                <option value="<?php echo $sucursal[$i]['codsucursal'] ?>"><?php echo $sucursal[$i]['razonsocial'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>


                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div class="form-group has-feedback">
                                                                    <label class="control-label">Tipo de Compra: <span class="symbol required"></span></label>
                                                                    <select name="tipocompra" id="tipocompra" tabindex="6" class="form-control" onChange="BuscaFormaPagosCompras()" required="" aria-required="true">
                                                                        <option value="">SELECCIONE</option>
                                                                        <option value="CONTADO">CONTADO</option>
                                                                        <option value="CREDITO">CRÉDITO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div id="muestraformapagocompras" style="display:none;">
                                                                <div class="col-md-6">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Forma de Compra: <span class="symbol required"></span></label>
                                                                        <select name="formacompra" id="formacompra" tabindex="7" class="form-control">
                                                                            <option value="">SELECCIONE</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
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


                    <footer class="footer"><i class="fa fa-copyright"></i> <span class="current-year"></span>.</footer>
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



            <script>
                $(document).ready(function() {
                  
                        $('#tipo-select').change(function() {
                          console.log($(this).val());
                        });
                })
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