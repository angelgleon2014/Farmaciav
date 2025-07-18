<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();
        $config = $tra->ConfiguracionPorId();

        if (isset($_GET["id"])) {
            $idgasto = base64_decode($_GET["id"]);
            $gasto = $tra->ObtenerGastoPorId($idgasto);
        }

        if (isset($_POST['btn-submit'])) {
            $tra->ActualizarGasto();
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
                                        Edicion de Gastos</h4>
                                    <ol class="breadcrumb pull-right">
                                        <li><a href="panel">Inicio</a></li>
                                        <li><a href="compras">Control</a></li>
                                        <li class="active">Edicion de Gastos</li>
                                    </ol>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            
                                <div class="col-sm-12">
                                    <div class="panel panel-primary">
                                        <?php if ($con[0]['productosvencidos'] > 0) { ?>
                                            <div class="panel-heading panel-heading-productos-vencidos">
                                                <h3 class="panel-title"><i class="fa fa-clock-o"></i> Hay productos vencidos o por vencer, favor ver notificaciones</h3>
                                            </div>
                                        <?php } ?>
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-edit"></i> Edicion de Gastos
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
                                                        <form method="post" action="#" name="formgastos" id="formgastos">
                                                            <input type="hidden" name="idgasto" value="<?= $gasto['idgasto'] ?>">
                                                            <div class="row">

                                                                <!-- proveedor_id -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Proveedor:</label>
                                                                        
                                                                        <input type="text" name="proveedor" class="form-control" value="<?= htmlentities($gasto['proveedor']) ?>" required>
                                                                    </div>
                                                                </div>

                                                                <!-- descripcion -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Descripción:</label>
                                                                        <textarea name="descripcion" class="form-control" required><?= htmlentities($gasto['descripcion']) ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- monto_total -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Monto Total:</label>
                                                                        <input type="number" step="0.01" name="monto_total" class="form-control" value="<?= $gasto['monto_total'] ?>" required>
                                                                    </div>
                                                                </div>

                                                                <!-- fecha_gasto -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Fecha del Gasto:</label>
                                                                        <input type="date" name="fecha_gasto" class="form-control" value="<?= substr($gasto['fecha_gasto'], 0, 10) ?>" required>
                                                                    </div>
                                                                </div>

                                                                <!-- tipo_gasto -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Tipo de Gasto:</label>
                                                                        <input type="text" name="tipo_gasto" class="form-control" value="<?= htmlentities($gasto['tipo_gasto']) ?>" required>
                                                                    </div>
                                                                </div>

                                                                <!-- metodo_pago -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Método de Pago:</label>
                                                                        <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                                                                            <option value="<?= htmlentities($gasto['metodo_pago']) ?>" selected><?= htmlentities($gasto['metodo_pago']) ?></option>
                                                                            <?php
                                                                                $opciones = ['EFECTIVO', 'TRANSFERENCIA', 'TARJETA'];
                                                                                foreach ($opciones as $op) {
                                                                                    if ($op != $gasto['metodo_pago']) {
                                                                                        echo "<option value='$op'>$op</option>";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- observaciones -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Observaciones:</label>
                                                                        <textarea name="observaciones" class="form-control"><?= htmlentities($gasto['observaciones']) ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- codsucursal -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        
                                                                        <input type="hidden" name="codsucursal" class="form-control" value="<?= htmlentities($gasto['codsucursal']) ?>" required>
                                                                    </div>
                                                                </div>

                                                                <!-- creado_por (oculto) -->
                                                                <input type="hidden" name="creado_por" value="<?php echo $_SESSION['nombres']; ?>">

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" name="btn-submit" class="btn btn-primary"><i class="fa fa-save"></i> Actualizar Gasto</button>
                                                                <button type="reset" class="btn btn-danger"><i class="fa fa-trash"></i> Limpiar</button>
                                                            </div>
                                                            <input type="hidden" name="detalle" id="detalle">

                                                        </form>
                                                        
                                                        
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
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
            <script src="assets/script/guardar_gasto.js"></script>




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