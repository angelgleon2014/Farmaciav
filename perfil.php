<?php
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
<link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="assets/css/style.css" rel="stylesheet" type="text/css"> 

<!-- script jquery -->
<script src="assets/js/jquery.min.js"></script> 
<script type="text/javascript" src="assets/script/titulos.js"></script>
<script type="text/jscript" language="javascript" src="assets/script/script2.js"></script>
<!-- script jquery -->  	
	

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
<div class="page-header-title"><h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Perfil de Usuario</h4>
<ol class="breadcrumb pull-right"><li><a href="panel">Inicio</a></li>
<li class="active">Mi perfil</li>
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
<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-tasks"></i> Mi Perfil de Usuario</h3></div>
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12">
            <div class="box-body">
<form class="form" name="perfil" id="perfil" method="post" action="#">

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div> 
													 
				<div class="row"> 
                            <div class="col-md-2"> 
                              <div class="form-group has-feedback"> 
                              <label class="control-label">RUC/DNI</label> 
 <input name="cedula" class="form-control" type="text" id="cedula" value="<?php echo $_SESSION['cedula']; ?>" readonly="readonly"/>
                        <i class="fa fa-pencil form-control-feedback"></i>   
                                                                </div> 
                                                            </div>
															
							<div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Nombre de Usuario</label> 
<input name="nombres" class="form-control" type="text" id="nombres" value="<?php echo $_SESSION['nombres']; ?>" readonly="readonly"/>
                        <i class="fa fa-pencil form-control-feedback"></i>  
                                                                </div> 
                                                            </div> 	
                              
              <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Genero</label> 
<input name="genero" class="form-control" type="text" id="genero" value="<?php echo $_SESSION['genero']; ?>" readonly="readonly"/>
                        <i class="fa fa-pencil form-control-feedback"></i>  
                                                                </div> 
                                                            </div>  
                              
              <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Fecha de Nacimiento</label> 
<input name="fnac" class="form-control" type="text" id="fnac" value="<?php echo $_SESSION['fnac']; ?>" readonly="readonly"/>
                        <i class="fa fa-calendar form-control-feedback"></i>  
                                                                </div> 
                                                            </div> 
                    </div>
					
					<div class="row">
                              
              <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Lugar de Nacimiento</label> 
<input name="lugnac" class="form-control" type="text" id="lugnac" value="<?php echo $_SESSION['lugnac']; ?>" readonly="readonly"/>
                        <i class="fa fa-map-marker form-control-feedback"></i>  
                                                                </div> 
                                                            </div> 
                              
              <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Dirección Domiciliaria</label> 
<input name="direcdomic" class="form-control" type="text" id="direcdomic" value="<?php echo $_SESSION['direcdomic']; ?>" readonly="readonly"/>
                        <i class="fa fa-map-marker form-control-feedback"></i>  
                                                                </div> 
                                                            </div> 
                              
              <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">N° de Teléfono</label> 
<input name="nrotelefono" class="form-control" type="nrotelefono" id="nrotelefono" value="<?php echo $_SESSION['nrotelefono']; ?>" readonly="readonly"/>
                        <i class="fa fa-phone form-control-feedback"></i>  
                                                                </div> 
                                                            </div>

                            <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
                              <label class="control-label">Correo de Usuario</label> 
 <input name="email" class="form-control" type="text" id="email" value="<?php echo $_SESSION['email']; ?>" readonly="readonly"/>
                        <i class="fa fa-envelope-o form-control-feedback"></i>   
                                                                </div> 
                                                            </div> 
          </div>


            <div class="row"> 
															
							<div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Cargo de Usuario</label> 
  <input name="cargo" class="form-control" type="text" id="cargo" value="<?php echo $_SESSION['cargo']; ?>" readonly="readonly"/>
                        <i class="fa fa-pencil form-control-feedback"></i>  
                                                                </div> 
                                                            </div> 	
                    
                            <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
                              <label class="control-label">Usuarios de Acceso</label> 
<input name="usuario" class="form-control" type="text" id="usuario" value="<?php echo $_SESSION['usuario']; ?>" readonly="readonly"/>
                        <i class="fa fa-user form-control-feedback"></i>   
                                                                </div> 
                                                            </div>

                            <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
                              <label class="control-label">Status de Acceso</label> 
<input name="status" class="form-control" type="text" id="status" value="<?php echo $_SESSION['status']; ?>" readonly="readonly"/>
                        <i class="fa fa-pencil form-control-feedback"></i>  
                                                                </div> 
                                                            </div>
                              
              <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Nivel de Acceso</label> 
<input name="nivel" class="form-control" type="text" id="nivel" value="<?php echo $_SESSION['nivel']; ?>" readonly="readonly"/>
                        <i class="fa fa-pencil form-control-feedback"></i>
                                                                </div> 
                                                            </div>
                    </div>
					
			<?php if ($_SESSION['acceso'] != "administradorG") { ?>

      		<div class="row"> 
                              
              <div class="col-md-6"> 
                               <div class="form-group has-feedback"> 
                               <label class="control-label">Sucursal Asignada</label> 
<input name="razonsocial" class="form-control" type="text" id="razonsocial" value="<?php echo $_SESSION['razonsocial']; ?>" readonly="readonly"/>
                        <i class="fa fa-bank form-control-feedback"></i>
                                                                </div> 
                                                            </div> 	
                    </div>
      <?php } ?>
					
			  			  
            <div class="modal-footer">
<a href="panel"><button type="button" class="btn btn-success"><i class="fa fa-arrow-left"></i> Regresar</button></a>
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
        <script src="assets/plugins/moment/moment.js"></script>
        
        <!-- jQuery  -->
        <script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="assets/plugins/counterup/jquery.counterup.min.js"></script>
           
        <!-- jQuery  -->
        <script src="assets/pages/jquery.dashboard.js"></script>
  

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