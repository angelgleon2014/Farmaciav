<?php
require_once("class/class.php");
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();

        if(isset($_POST['btn-submit'])) {
            $reg = $tra->RegistrarSucursal();
            exit;
        } elseif(isset($_POST['btn-update'])) {
            $reg = $tra->ActualizarSucursal();
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
   /* $("#cedresponsable").validarCedulaEC({
        onValid: function () {
    $("#cedresponsable").focus();
    $('#cedresponsable').css('border-color','#66afe9');
    return true;
        },
        onInvalid: function () {
    $("#cedresponsable").val("");
    $("#cedresponsable").focus();
    $('#cedresponsable').css('border-color','#f8ca4e');
        alert("La Cedula o Ruc ingresada es Invalida");
    return false;
       }
    });*/
});

$(document).ready(function() {
   /* $("#rucsucursal").validarCedulaEC({
        onValid: function () {
    $("#rucsucursal").focus();
    $('#rucsucursal').css('border-color','#66afe9');
    return true;
        },
        onInvalid: function () {
    $("#rucsucursal").val("");
    $("#rucsucursal").focus();
    $('#rucsucursal').css('border-color','#f8ca4e');
        alert("El Ruc ingresado es Invalido");
    return false;
       }
    });*/
});
</script>
<!-- script jquery -->

<!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
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
<div class="page-header-title"><h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Gestión de Sucursal</h4>
<ol class="breadcrumb pull-right"><li><a href="panel">Inicio</a></li>
<li><a href="sucursal">Control</a></li>
<li class="active">Sucursal</li>
</ol>

<div class="clearfix"></div>

</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Gestión de Sucursal</h3></div>
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12"> 
            <div class="box-body">
			
<?php  if (isset($_GET['codsucursal'])) {

    $reg = $tra->SucursalPorId(); ?>
			
<form class="form" name="updatesucursal" id="updatesucursal" method="post" data-id="<?php echo $reg[0]["codsucursal"] ?>" action="#" enctype="multipart/form-data">
				
		<?php } else { ?>
				
<form class="form" method="post"  action="#" name="sucursal" id="sucursal" enctype="multipart/form-data">	
			
		<?php } ?>
                                              <div id="error">
                                                 <!-- error will be shown here ! -->
                                               </div>
												
				<div class="row"> 
                            

          <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
     <label class="control-label">Código Sucursal: <span class="symbol required"></span></label>
<input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo $reg[0]['codsucursal']; ?>"<?php } ?>>
<div id="numerosucursal"><input type="text" class="form-control" name="nrosucursal" id="nrosucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Sucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo $reg[0]['nrosucursal']; ?>" readonly="readonly" <?php } else { ?>  value="<?php echo $reg = $tra->NumeroSucursal(); ?>" <?php } ?> tabindex="1" required="" aria-required="true"></div>
                <i class="fa fa-flash form-control-feedback"></i>
                              </div> 
                        </div>

                        <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
  <label class="control-label">RUC/DNI de Responsable: <span class="symbol required"></span></label> 
<input type="text" class="form-control" name="cedresponsable" id="cedresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese RUC/C.I de Responsable" <?php if (isset($reg[0]['cedresponsable'])) { ?> value="<?php echo $reg[0]['cedresponsable']; ?>"<?php } ?> tabindex="1" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>
															
							<div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
  <label class="control-label">Nombre de Responsable: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="nomresponsable" id="nomresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Responsable" <?php if (isset($reg[0]['nomresponsable'])) { ?> value="<?php echo $reg[0]['nomresponsable']; ?>"<?php } ?> tabindex="2" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div> 

                            
                            <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
<label class="control-label">N° Celular de Responsable: <span class=""></span></label> 
 <input type="text" class="form-control" name="celresponsable" id="celresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Celular de Responsable" <?php if (isset($reg[0]['celresponsable'])) { ?> value="<?php echo $reg[0]['celresponsable']; ?>"<?php } ?> tabindex="3" required="" aria-required="true">
                        <i class="fa fa-mobile form-control-feedback"></i>  
                              </div> 
                        </div> 
                    </div>


          <div class="row"> 
                              
              <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
      <label class="control-label">RUC de Sucursal: <span class="symbol required"></span></label> 
<input type="text" class="form-control" name="rucsucursal" id="rucsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese RUC/C.I de Sucursal" <?php if (isset($reg[0]['rucsucursal'])) { ?> value="<?php echo $reg[0]['rucsucursal']; ?>"<?php } ?> tabindex="4" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div> 

                           <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
             <label class="control-label">Razón Social: <span class="symbol required"></span></label> 
  <input type="text" class="form-control" name="razonsocial" id="razonsocial" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Razón Social" <?php if (isset($reg[0]['razonsocial'])) { ?> value="<?php echo $reg[0]['razonsocial']; ?>"<?php } ?> tabindex="5" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>  
                              </div> 
                        </div>  
                              
              <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
  <label class="control-label">N° de Teléfono Sucursal: <span class=""></span></label> 
 <input type="text" class="form-control" name="tlfsucursal" id="tlfsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Teléfono Sucursal" <?php if (isset($reg[0]['tlfsucursal'])) { ?> value="<?php echo $reg[0]['tlfsucursal']; ?>"<?php } ?> tabindex="6" required="" aria-required="true">
                        <i class="fa fa-phone form-control-feedback"></i>  
                              </div> 
                        </div> 

                            <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
        <label class="control-label">N° de Celular Sucursal: <span class=""></span></label> 
 <input type="text" class="form-control" name="celsucursal" id="celsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Celular Sucural" <?php if (isset($reg[0]['celsucursal'])) { ?> value="<?php echo $reg[0]['celsucursal']; ?>"<?php } ?> tabindex="7" required="" aria-required="true">
                        <i class="fa fa-mobile form-control-feedback"></i>  
                              </div> 
                        </div>
                    </div>
					
					<div class="row">
															
                        <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
      <label class="control-label">Dirección Sucursal: <span class=""></span></label> 
<input type="text" class="form-control" name="direcsucursal" id="direcsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Dirección Sucursal" <?php if (isset($reg[0]['direcsucursal'])) { ?> value="<?php echo $reg[0]['direcsucursal']; ?>"<?php } ?> tabindex="8" required="" aria-required="true">
                        <i class="fa fa-map-marker form-control-feedback"></i>  
                              </div> 
                        </div> 

                            <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
      <label class="control-label">Correo de Sucursal: <span class=""></span></label> 
 <input type="text" class="form-control" name="emailsucursal" id="emailsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Correo de Sucursal" <?php if (isset($reg[0]['emailsucursal'])) { ?> value="<?php echo $reg[0]['emailsucursal']; ?>"<?php } ?> tabindex="9" required="" aria-required="true">
                        <i class="fa fa-envelope-o form-control-feedback"></i>  
                              </div> 
                        </div> 		
                          
                           <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
            <label class="control-label">N° de Actividad: <span class=""></span></label> 
<input type="text" class="form-control" name="nroactividadsucursal" id="nroactividadsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Actividad" <?php if (isset($reg[0]['nroactividadsucursal'])) { ?> value="<?php echo $reg[0]['nroactividadsucursal']; ?>"<?php } ?> tabindex="10" required="" aria-required="true">
                        <i class="fa fa-user form-control-feedback"></i>  
                              </div> 
                    </div>    
                          
                           <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
  <label class="control-label">N° Inicio de Factura: <span class=""></span></label> 
<input type="text" class="form-control" name="nroiniciofactura" id="nroiniciofactura" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° Inicio de Factura" <?php if (isset($reg[0]['nroiniciofactura'])) { ?> value="<?php echo $reg[0]['nroiniciofactura']; ?>"<?php } ?> tabindex="10" required="" aria-required="true">
                        <i class="fa fa-user form-control-feedback"></i>  
                              </div> 
                    </div>  
                </div>
					
					<div class="row"> 
                          
                            <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
  <label class="control-label">Fecha de Autorización: <span class=""></span></label> 
<input type="text" class="form-control calendario" name="fechaautorsucursal" id="fechaautorsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha de Autorización" <?php if (isset($reg[0]['fechaautorsucursal'])) { ?> value="<?php echo $reg[0]['fechaautorsucursal']; ?>"<?php } ?> tabindex="12" required="" aria-required="true">
                        <i class="fa fa-calendar form-control-feedback"></i>  
                              </div> 
                        </div> 
                              
              <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
          <label class="control-label">IGV en Compras: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="ivacsucursal" id="ivacsucursal" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese IGV de Compras" <?php if (isset($reg[0]['ivacsucursal'])) { ?> value="<?php echo $reg[0]['ivacsucursal']; ?>"<?php } ?> tabindex="13" required="" aria-required="true">
                        <i class="fa fa-usd form-control-feedback"></i>  
                                                                </div> 
                                                            </div> 
                              
              <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
       <label class="control-label">IGV en Ventas: <span class="symbol required"></span></label> 
 <input type="text" class="form-control" name="ivavsucursal" id="ivavsucursal" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese IGV de Ventas" <?php if (isset($reg[0]['ivavsucursal'])) { ?> value="<?php echo $reg[0]['ivavsucursal']; ?>"<?php } ?> tabindex="14" required="" aria-required="true">
                        <i class="fa fa-usd form-control-feedback"></i>  
                                                                </div> 
                                                            </div>


                            <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
      <label class="control-label">Descuento en Ventas: <span class=""></span></label> 
 <input type="text" class="form-control" name="descsucursal" id="descsucursal" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento de Ventas" <?php if (isset($reg[0]['descsucursal'])) { ?> value="<?php echo $reg[0]['descsucursal']; ?>"<?php } ?> tabindex="15" required="" aria-required="true">
                        <i class="fa fa-usd form-control-feedback"></i>  
                                                                </div> 
                                                            </div>
                </div>
          

          <div class="row">   
                                                  
              <div class="col-md-3"> 
                              <div class="form-group has-feedback"> 
    <label class="control-label">Lleva Contabilidad: <span class="symbol required"></span></label>
                               <?php if (isset($reg[0]['llevacontabilidad'])) { ?>
<select name="llevacontabilidad" id="llevacontabilidad" class="form-control" tabindex="16" required="" aria-required="true">
                        <option value="">SELECCIONE</option>
  <option value="SI"<?php if (!(strcmp('SI', $reg[0]['llevacontabilidad']))) {
      echo "selected=\"selected\"";
  } ?>>SI</option>
  <option value="NO"<?php if (!(strcmp('NO', $reg[0]['llevacontabilidad']))) {
      echo "selected=\"selected\"";
  } ?>>NO</option>
                      </select>
                             <?php } else { ?>
<select name="llevacontabilidad" id="llevacontabilidad" class="form-control" tabindex="16" required="" aria-required="true">
                        <option value="">SELECCIONE</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                      </select>
                   <?php } ?> 
                              </div> 
                        </div>
                                            
              <div class="col-md-3"> 
                               <div class="form-group has-feedback"> 
            <label class="control-label">Símbolo de moneda: </label> 
    <input name="simbolo" class="form-control" type="text" id="simbolo" onKeyUp="this.value=this.value.toUpperCase();" <?php if (isset($reg[0]['simbolo'])) { ?> value="<?php echo $reg[0]['simbolo']; ?>"<?php } ?> placeholder="Ingrese Símbolo de moneda" autocomplete="off" tabindex="17" required="required"/>
                        <i class="fa fa-pencil form-control-feedback"></i> 
                                                                </div> 
                                                            </div>

             <div class="col-sm-6">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
     <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 90px; height: 100px;">
<?php if (isset($reg[0]['rucsucursal'])) {
    if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {
        echo "<img src='fotos/".$reg[0]['rucsucursal'].".png?".date('h:i:s')."' class='img-rounded' border='0' width='100' height='110' title='Foto' data-rel='tooltip'>";
    } else {
        echo "<img src='fotos/producto.png' class='img-rounded' border='1' width='90' height='100' title='SIN FOTO' data-rel='tooltip'>";
    }
} else {
    echo "<img src='fotos/producto.png' class='img-rounded' border='1' width='90' height='100' title='SIN FOTO' data-rel='tooltip'>";
}
        ?>
                            </div>
                            <div>
                              <span class="btn btn-default btn-file">
              <span class="fileinput-new"><i class="fa fa-file-image-o"></i> Imagen</span>
               <span class="fileinput-exists"><i class="fa fa-paint-brush"></i> Imagen</span>
<input type="file" size="10" data-original-title="Subir Fotografia" data-rel="tooltip" placeholder="Suba Logo de Sucursal" name="imagen" id="imagen"/>
                              </span>
 <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times-circle"></i> Remover</a><small><p>Para Subir el Logo de Sucursal debe tener en cuenta lo siguiente:<br> * La Imagen debe ser extension.jpg<br> * La imagen no debe ser mayor de 200 KB</p></small>                             </div>
                          </div>
                        </div>
              
                    </div>


			  
            <div class="modal-footer"> 
<?php  if (isset($_GET['codsucursal'])) { ?>
<button type="submit" name="btn-update" id="btn-update" class="btn btn-primary"><span class="fa fa-edit"></span> Actualizar</button>
<button class="btn btn-danger" type="reset"><i class="fa fa-trash-o"></i> Cancelar</button> 
    <?php } else { ?>
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Guardar</button>
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