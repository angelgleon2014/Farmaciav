<?php
require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();

        $reg = $tra->PedidosPorId();

        if(isset($_POST['btn-update'])) {
            $reg = $tra->ActualizarPedidos();
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
<link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="assets/css/style.css" rel="stylesheet" type="text/css"> 

<!-- script jquery -->
<script src="assets/js/jquery.min.js"></script> 
<!-- Custom file upload -->
<script src="assets/plugins/fileupload/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="assets/script/titulos.js"></script>
<script type="text/javascript" src="assets/script/script2.js"></script>
<script type="text/javascript" src="assets/script/validation.min.js"></script>
<script type="text/javascript" src="assets/script/script.js"></script>
<!-- script jquery -->

<!-- Calendario -->
  <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/autocompleto.js"></script> 
<!-- Calendario -->

</head>
<body onLoad="muestraReloj()" class="fixed-left">
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
 <button type="button" class="button-menu-mobile open-left waves-effect waves-light"><i class="ion-navicon"></i> </button> 
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
   <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="fa fa-crosshairs"></i></a>   </li>
   <li class="dropdown"> 
   <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">

<span class="dropdown hidden-xs"><abbr title="<?php echo estado($_SESSION['acceso']); ?>"><?php echo $_SESSION['nombres']; ?></abbr></span>
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
<div class="page-header-title"><h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Gestión de Pedidos</h4>
<ol class="breadcrumb pull-right"><li><a href="panel">Inicio</a></li>
<li><a href="pedidos">Control</a></li>
<li class="active">Pedidos</li>
</ol>

<div class="clearfix"></div>

</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Gestión de Pedidos</h3></div>
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12"> 
            <div class="box-body">
      
<form class="form" method="post"  action="#" name="updatepedidos" id="updatepedidos" data-id="<?php echo $reg[0]["codpedido"] ?>" onSubmit="asigna()">       

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                      </div>
                        
        <div class="row"> 
                            <div class="col-md-2"> 
                              <div class="form-group has-feedback"> 
            <label class="control-label">Código Pedido: <span class="symbol required"></span></label>
  <input type="text" class="form-control" name="codpedido" id="codpedido" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código Pedido" value="<?php echo $reg[0]['codpedido']; ?>" readonly="readonly">
                <i class="fa fa-pencil form-control-feedback"></i>
                              </div> 
                        </div>

                      <div class="col-md-2"> 
                              <div class="form-group has-feedback"> 
             <label class="control-label">Proveedor: <span class="symbol required"></span></label>
  <select name="codproveedor" id="codproveedor" class="form-control" required="" aria-required="true">
                        <option value="">SELECCIONE</option>
      <?php
              $proveedor = new Login();
        $proveedor = $proveedor->ListarProveedores();
        for($i = 0;$i < sizeof($proveedor);$i++) {
            ?>
<option value="<?php echo $proveedor[$i]['codproveedor']; ?>"<?php if (!(strcmp($proveedor[0]['codproveedor'], htmlentities($proveedor[$i]['codproveedor'])))) {
    echo "selected=\"selected\"";
} ?>><?php echo $proveedor[$i]['nomproveedor']; ?></option>        
                      <?php } ?>
                  </select>
                              </div> 
                        </div>
                              
              <div class="col-md-2"> 
                              <div class="form-group has-feedback"> 
          <label class="control-label">Sucursal: <span class="symbol required"></span></label>
  <select name="codsucursal" id="codsucursal" class="form-control" required="" aria-required="true">
                        <option value="">SELECCIONE</option>
      <?php
      $sucursal = new Login();
        $sucursal = $sucursal->ListarSucursal();
        for($i = 0;$i < sizeof($sucursal);$i++) {
            ?>
<option value="<?php echo $sucursal[$i]['codsucursal']; ?>"<?php if (!(strcmp($sucursal[0]['codsucursal'], htmlentities($sucursal[$i]['codsucursal'])))) {
    echo "selected=\"selected\"";
} ?>><?php echo $sucursal[$i]['razonsocial']; ?></option>        
                      <?php } ?>
                  </select>
                              </div> 
                        </div>


                     <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
<label class="control-label">Fecha de Pedido: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="fechapedido" id="fechapedido" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo date("d-m-Y h:i:s", strtotime($reg[0]['fechapedido'])); ?>" readonly="readonly">
                        <i class="fa fa-calendar form-control-feedback"></i>  
                              </div> 
                        </div>   

                  <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
        <label class="control-label">Registrado por: <span class="symbol required"></span></label>
<input type="text" class="form-control" name="nombres" id="nombres" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['nombres']; ?>" readonly="readonly">
                        <i class="fa fa-pencil form-control-feedback"></i> 
                              </div> 
                        </div>
                </div>

                <hr>


<div class="table-responsive" data-pattern="priority-columns">
      <div id="cargaproductos"><table id="tech-companies-1" class="table table-small-font table-bordered table-striped">                                    <thead>
                    <tr role="row">
          <th colspan="7" data-priority="1"><center>Productos Pedidos</center></th>
          </tr>
                                                <tr>
                                                <th>C&oacute;digo</th>
                                                <th>Nombre</th>
                                                <th>Principio Activo</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Presentaci&oacute;n</th>
                                                <th>Laboratorio</th>
                                                <th>Unid/Med</th>
                                                <th>Cantidad</th>
                                                            </tr>
                            </thead>
                                                        <tbody>
 <?php
$tru = new Login();
        $busq = $tru->VerDetallesPedidos();
        for($i = 0;$i < sizeof($busq);$i++) {
            ?>
                             <tr>
<td><input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $busq[$i]["codproducto"]; ?>"><?php echo $busq[$i]["codproducto"]; ?></td>
<td><?php echo $busq[$i]["producto"]; ?></td>
<td><?php echo $busq[$i]["principioactivo"]; ?></td>
<td><?php echo $busq[$i]["descripcion"]; ?></td>
<td><?php echo $busq[$i]["nompresentacion"]; ?></td>
<td><?php echo $busq[$i]["nomlaboratorio"]; ?></td>
<td><?php echo $busq[$i]["nommedida"]; ?></td>

<td><input type="text" class="form-control" name="cantpedido[]" id="cantpedido" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad Pedido" value="<?php echo $busq[$i]["cantpedido"]; ?>" style="width: 80px;" title="Ingrese Cantidad Pedido" required="" aria-required="true"></td>
                                                          </tr>
                              <?php } ?>
                                                        </tbody>
                                                      </table></div>
                                                    </div>

        
            <div class="modal-footer"> 
<button type="submit" name="btn-update" id="btn-update" class="btn btn-primary"><span class="fa fa-edit"></span> Actualizar</button>
<button class="btn btn-danger" type="reset"><i class="fa fa-trash-o"></i> Cancelar</button>  
                      </div>
                    </form>
                                    </div><!-- /.box-body -->
                </div>
                          </div>
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
        document.location.href='panel'   
        </script> 
<?php }
} else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?> 