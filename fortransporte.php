<?php
require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorS") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();

        if(isset($_POST['btn-submit'])) {
            $reg = $tra->RegistrarTransporte();
            exit;
        } elseif(isset($_POST['btn-update'])) {
            $reg = $tra->ActualizarTransporte();
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
  //$("#tlfchofer").mask("999 9999 999");
  $("#tlfchofer").mask("9999 999");
  });
</script>
<script type="text/javascript" src="assets/script/ruc_jquery_validator.min.js"></script>
    <script type="text/javascript">
   $(document).ready(function() {
    $("#rucchofer").validarCedulaEC({
        onValid: function () {
    $("#rucchofer").focus();
    $('#rucchofer').css('border-color','#66afe9');
    return true;
        },
        onInvalid: function () {
    $("#rucchofer").val("");
    $("#rucchofer").focus();
    $('#rucchofer').css('border-color','#f8ca4e');
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
<div class="page-header-title"><h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Gestión de Transportes</h4>
<ol class="breadcrumb pull-right"><li><a href="panel">Inicio</a></li>
<li><a href="transporte">Control</a></li>
<li class="active">Transportes</li>
</ol>

<div class="clearfix"></div>

</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Gestión de Transportes</h3></div>
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12"> 
            <div class="box-body">
			
<?php  if (isset($_GET['codchofer'])) {

    $reg = $tra->TransportePorId(); ?>
			
<form class="form" method="post" action="#" name="updatetransporte" id="updatetransporte" data-id="<?php echo $reg[0]["codchofer"] ?>">				
		<?php } else { ?>
				
<form class="form" method="post" action="#" name="transporte" id="transporte">
			
		<?php } ?>
                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                 </div>
												
				<div class="row"> 
                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
  <label class="control-label">DNI de Chofer: <span class="symbol required"></span></label> 
  <input type="hidden" name="codchofer" id="codchofer" <?php if (isset($reg[0]['codchofer'])) { ?> value="<?php echo $reg[0]['codchofer']; ?>"<?php } ?>>
    <input type="text" class="form-control" name="rucchofer" id="rucchofer" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese DNI de Chofer" <?php if (isset($reg[0]['rucchofer'])) { ?> value="<?php echo $reg[0]['rucchofer']; ?>"<?php } ?> tabindex="1" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div> 
                        </div>
                              
              <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
        <label class="control-label">Nombre de Chofer: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="nomchofer" id="nomchofer" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Chofer" <?php if (isset($reg[0]['nomchofer'])) { ?> value="<?php echo $reg[0]['nomchofer']; ?>"<?php } ?> tabindex="2" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>

                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
               <label class="control-label">N° Teléfono de Chofer:</label> 
<input type="text" class="form-control" name="tlfchofer" id="tlfchofer" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Telefono de Chofer" <?php if (isset($reg[0]['tlfchofer'])) { ?> value="<?php echo $reg[0]['tlfchofer']; ?>"<?php } ?> tabindex="3" >
                        <i class="fa fa-phone form-control-feedback"></i> 
                              </div> 
                        </div>  
                    </div>

          <div class="row"> 
                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
  <label class="control-label">N° de Bultos: <span class="symbol required"></span></label> 
    <input type="text" class="form-control" name="numbultos" id="numbultos" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Bultos" <?php if (isset($reg[0]['numbultos'])) { ?> value="<?php echo $reg[0]['numbultos']; ?>"<?php } ?> tabindex="4" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div> 
                        </div>
                              
              <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
        <label class="control-label">Ruta: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="ruta" id="ruta" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Ruta" <?php if (isset($reg[0]['ruta'])) { ?> value="<?php echo $reg[0]['ruta']; ?>"<?php } ?> tabindex="5" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>

                            <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
               <label class="control-label">Ciudad de Ruta:</label> 
<input type="text" class="form-control" name="ciudadruta" id="ciudadruta" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Ciudad de Ruta" <?php if (isset($reg[0]['ciudadruta'])) { ?> value="<?php echo $reg[0]['ciudadruta']; ?>"<?php } ?> tabindex="6" >
                        <i class="fa fa-pencil form-control-feedback"></i> 
                              </div> 
                        </div>  
                    </div>

          
          <div class="row"> 

                        <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
    <label class="control-label">N° Placa de Vehiculo: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="placavehiculo" id="placavehiculo" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° Placa de Vehiculo" <?php if (isset($reg[0]['placavehiculo'])) { ?> value="<?php echo $reg[0]['placavehiculo']; ?>"<?php } ?> tabindex="7" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>  

                      <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
        <label class="control-label">Punto de Llegada: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="llegada" id="llegada" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Punto de Llegada" <?php if (isset($reg[0]['llegada'])) { ?> value="<?php echo $reg[0]['llegada']; ?>"<?php } ?> tabindex="8" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div> 

                        <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
        <label class="control-label">Motivo de Traslado: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="motivotraslado" id="motivotraslado" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Motivo de Traslado" <?php if (isset($reg[0]['motivotraslado'])) { ?> value="<?php echo $reg[0]['motivotraslado']; ?>"<?php } ?> tabindex="9" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>  
                    </div> 

					
			<div class="row"> 
                  
            <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
<label class="control-label">Fecha Inicio de Transporte: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="desde" id="desde" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Inicio de Transporte" <?php if (isset($reg[0]['iniciotransporte'])) { ?> value="<?php echo $reg[0]['iniciotransporte']; ?>"<?php } ?> tabindex="10" required="" aria-required="true">
                        <i class="fa fa-calendar form-control-feedback"></i>  
                              </div> 
                        </div> 

             <div class="col-md-4"> 
                               <div class="form-group has-feedback"> 
<label class="control-label">Fecha Fin de Transporte: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="hasta" id="hasta" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Fin de Transporte" <?php if (isset($reg[0]['fintransporte'])) { ?> value="<?php echo $reg[0]['fintransporte']; ?>"<?php } ?> tabindex="11" required="" aria-required="true">
                        <i class="fa fa-calendar form-control-feedback"></i>  
                              </div> 
                        </div>


          <div class="col-md-4"> 
                              <div class="form-group has-feedback"> 
        <label class="control-label">Status de Chofer: <span class="symbol required"></span></label>
                               <?php if (isset($reg[0]['statuschofer'])) { ?>
<select name="statuschofer" id="statuschofer" class="form-control" tabindex="12" required="" aria-required="true">
                        <option value="">SELECCIONE</option>
  <option value="0"<?php if (!(strcmp('0', $reg[0]['statuschofer']))) {
      echo "selected=\"selected\"";
  } ?>>ACTIVO</option>
  <option value="1"<?php if (!(strcmp('1', $reg[0]['statuschofer']))) {
      echo "selected=\"selected\"";
  } ?>>INACTIVO</option>
                      </select>
                             <?php } else { ?>
<select name="statuschofer" id="statuschofer" class="form-control" tabindex="12" required="" aria-required="true">
                        <option value="">SELECCIONE</option>
                        <option value="0">ACTIVO</option>
                        <option value="1">INACTIVO</option>
                      </select>
                   <?php } ?> 
                              </div> 
                        </div>

          </div>

						
		
			  
            <div class="modal-footer"> 
<?php  if (isset($_GET['codchofer'])) { ?>
<button type="submit" tabindex="13" name="btn-update" id="btn-update" class="btn btn-primary"><span class="fa fa-edit"></span> Actualizar</button>
<button class="btn btn-danger" type="reset"><i class="fa fa-trash-o"></i> Cancelar</button> 
    <?php } else { ?>
<button type="submit" tabindex="13" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Guardar</button>
<button class="btn btn-danger" type="reset"><i class="fa fa-trash-o"></i> Limpiar</button>
    <?php } ?> 
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