<?php
require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();

        $ses = $tra->ExpiraSession();
        $reg = $tra->ConfiguracionPorId();

        if(isset($_POST['btn-update'])) {
            $reg = $tra->ActualizarConfiguracion();
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
<script type="text/javascript" src="assets/script/jquery.mask.js"></script>
<script type="text/javascript" src="assets/script/titulos.js"></script>
<script type="text/javascript" src="assets/script/script2.js"></script>
<script type="text/javascript" src="assets/script/validation.min.js"></script>
<script type="text/javascript" src="assets/script/script.js"></script>
<script type="text/javascript">
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
    });
</script>
<script type="text/javascript">
	$(document).ready(function() {
	$("#celresponsable").mask("999 9999 999");
  $("#tlfsucursal").mask("9999 999");
  $("#celsucursal").mask("999 9999 999");
	});
</script>
<script type="text/javascript">
$(document).ready(function() {
    
});

$(document).ready(function() {
   
});
</script>
<!-- script jquery -->

<!-- Calendario -->
  <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/autocompleto.js"></script>
<!-- Calendario -->

<script type="text/javascript" src="assets/script/ruc_jquery_validator.min.js"></script>

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
<div class="page-header-title"><h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Configuración General</h4>
<ol class="breadcrumb pull-right"><li><a href="panel">Inicio</a></li>
<li><a href="configuracion">Control</a></li>
<li class="active">Configuración</li>
</ol>

<div class="clearfix"></div>

</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Configuración General</h3></div>
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12"> 
            <div class="box-body">
			

			
			
<form class="form" method="post" data-id="<?php echo $reg[0]["id"] ?>" action="#" name="configuracion" id="configuracion">
		
                                              <div id="error">
                                                 <!-- error will be shown here ! -->
                                               </div>
												
				<div class="row"> 
                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
    <label class="control-label">RUC/C.I de Responsable: <span class="symbol required"></span></label> 
 <input type="hidden" name="id" id="id" value="<?php echo $reg[0]['id']; ?>">
<input type="text" class="form-control" name="cedresponsable" id="cedresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese RUC/C.I de Responsable" value="<?php echo $reg[0]['cedresponsable']; ?>" tabindex="1" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>
															
							<div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
    <label class="control-label">Nombre de Responsable: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="nomresponsable" id="nomresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Responsable" value="<?php echo $reg[0]['nomresponsable']; ?>" tabindex="2" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div> 

                            
                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
<label class="control-label">N° Celular de Responsable: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="celresponsable" id="celresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Celular de Responsable"  value="<?php echo $reg[0]['celresponsable']; ?>" tabindex="3" required="" aria-required="true">
                        <i class="fa fa-mobile form-control-feedback"></i>  
                              </div> 
                        </div> 
                    </div>

          <div class="row"> 
                              
              <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
   <label class="control-label">RUC/C.I de Empresa: <span class="symbol required"></span></label> 
<input type="text" class="form-control" name="rucsucursal" id="rucsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese RUC/C.I de Empresa" value="<?php echo $reg[0]['rucsucursal']; ?>" tabindex="4" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div> 

                           <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
             <label class="control-label">Razón Social: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="razonsocial" id="razonsocial" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Razón Social" value="<?php echo $reg[0]['razonsocial']; ?>" tabindex="5" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>  
                              
              <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
    <label class="control-label">N° de Teléfono Empresa: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="tlfsucursal" id="tlfsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Teléfono Empresa" value="<?php echo $reg[0]['tlfsucursal']; ?>" tabindex="6" required="" aria-required="true">
                        <i class="fa fa-phone form-control-feedback"></i>  
                              </div> 
                        </div>

                    </div>
					
					<div class="row"> 
                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
  <label class="control-label">N° de Celular Empresa: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="celsucursal" id="celsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Celular Empresa" value="<?php echo $reg[0]['celsucursal']; ?>" tabindex="7" required="" aria-required="true">
                        <i class="fa fa-mobile form-control-feedback"></i>  
                              </div> 
                        </div>
															
                        <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
    <label class="control-label">Dirección Empresa: <span class="symbol required"></span></label> 
<input type="text" class="form-control" name="direcsucursal" id="direcsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Dirección Empresa" value="<?php echo $reg[0]['direcsucursal']; ?>" tabindex="8" required="" aria-required="true">
                        <i class="fa fa-map-marker form-control-feedback"></i>  
                              </div> 
                        </div> 

                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
      <label class="control-label">Correo de Empresa: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="emailsucursal" id="emailsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Correo de Empresa" value="<?php echo $reg[0]['emailsucursal']; ?>" tabindex="9" required="" aria-required="true">
                        <i class="fa fa-envelope-o form-control-feedback"></i>  
                              </div> 
                        </div> 		

               </div>
					
					<div class="row"> 
                              
              <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
            <label class="control-label">IGV en Compras: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="ivacsucursal" id="ivacsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese IGV  de Compras" value="<?php echo $reg[0]['ivacsucursal']; ?>" tabindex="10" required="" aria-required="true">
                        <i class="fa fa-usd form-control-feedback"></i>  
                                                                </div> 
                                                            </div> 
                              
              <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
                <label class="control-label">IGV en Ventas: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="ivavsucursal" id="ivavsucursal" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese IGV  de Ventas" value="<?php echo $reg[0]['ivavsucursal']; ?>" tabindex="11" required="" aria-required="true">
                        <i class="fa fa-usd form-control-feedback"></i>  
                                                                </div> 
                                                            </div>

                <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
      <label class="control-label">Símbolo de moneda: </label> 
    <input name="simbolo" class="form-control" type="text" id="simbolo" onKeyUp="this.value=this.value.toUpperCase();" value="<?php echo $reg[0]['simbolo']; ?>" placeholder="Ingrese Símbolo de moneda" autocomplete="off" tabindex="12" required="required"/>
                        <i class="fa fa-pencil form-control-feedback"></i> 
                                                                </div> 
                                                            </div>
                </div><br>

			  
            <div class="modal-footer"> 
<button type="submit" tabindex="13" name="btn-update" id="btn-update" class="btn btn-primary"><span class="fa fa-edit"></span> Actualizar</button>
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