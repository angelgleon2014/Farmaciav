<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();

        $reg = $tra->DetallesComprasPorId();

        if (isset($_POST['btn-update'])) {
            $reg = $tra->ActualizarDetallesCompras();
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
<div class="page-header-title"><h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Gestión de Compras</h4>
<ol class="breadcrumb pull-right"><li><a href="panel">Inicio</a></li>
<li><a href="detallescompras">Control</a></li>
<li class="active">Compras</li>
</ol>

<div class="clearfix"></div>

</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Gestión de Compras</h3></div>
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12"> 
            <div class="box-body">
                  
<form class="form" method="post"  action="#" name="updatedetallescompras" id="updatedetallescompras" data-id="<?php echo $reg[0]["coddetallecompra"] ?>">
                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                               </div>
                                                                        
                                    <div class="row">

                        <div class="col-md-2"> 
                                          <div class="form-group has-feedback"> 
                       <label class="control-label">Código Producto: <span class="symbol required"></span></label> 
            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo $reg[0]['codsucursal']; ?>">

            <input type="hidden" name="coddetallecompra" id="coddetallecompra" value="<?php echo $reg[0]['coddetallecompra']; ?>">
            <input type="hidden" name="codcompra" id="codcompra" value="<?php echo $reg[0]['codcompra']; ?>">
            <input type="text" class="form-control" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Producto" value="<?php echo $reg[0]['codproductoc']; ?>" tabindex="1" readonly="readonly">
                                    <i class="fa fa-flash form-control-feedback"></i>
                                          </div> 
                                    </div>
                     
                         <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                     <label class="control-label">Nombre de Producto: <span class="symbol required"></span></label>
            <input type="text" class="form-control" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre" value="<?php echo $reg[0]['productoc']; ?>" tabindex="2" required="" aria-required="true">                        
                                <i class="fa fa-pencil form-control-feedback"></i> 
                                          </div> 
                                    </div>

                                  <div class="col-md-4"> 
                                           <div class="form-group has-feedback"> 
                      <label class="control-label">Principio Activo: <span class="symbol required"></span></label>
            <input type="text" class="form-control" name="principioactivo" id="principioactivo" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Principio Activo" value="<?php echo $reg[0]['principioactivoc']; ?>" tabindex="3" required="" aria-required="true">
                                    <i class="fa fa-pencil form-control-feedback"></i> 
                                          </div> 
                                    </div> 
                              
                          <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                            <label class="control-label">Descripción: <span class="symbol required"></span></label>
            <input type="text" class="form-control" name="descripcion" id="descripcion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripción de Producto" value="<?php echo $reg[0]['descripcionc']; ?>" tabindex="4" required="" aria-required="true">
                                    <i class="fa fa-pencil form-control-feedback"></i> 
                                          </div> 
                                    </div>

                   </div>


                    <div class="row"> 

                              <div class="col-md-3"> 
                    <div class="form-group has-feedback"> 
                      <label class="control-label">Presentación: <span class="symbol required"></span></label>
                      <select name="codpresentacion" id="codpresentacion" tabindex="5" class="form-control">
                        <option value="">SELECCIONE</option>
                        <?php
                 $pre = new Login();
        $pre = $pre->ListarPresentacion();
        for ($i = 0; $i < sizeof($pre); $i++) {
            ?>
                                <option value="<?php echo $pre[$i]['codpresentacion']; ?>"<?php if (!(strcmp($reg[0]['codpresentacionc'], htmlentities($pre[$i]['codpresentacion'])))) {
                                    echo "selected=\"selected\"";
                                } ?>><?php echo $pre[$i]['nompresentacion']; ?></option>        
                          <?php } ?>
                        </select>
                      </div> 
                    </div>


                   <div class="col-md-3"> 
                      <div class="form-group has-feedback"> 
                      <label class="control-label">Unidad de Medida: <span class="symbol required"></span></label>
                        <select name="codmedida" id="codmedida" tabindex="6" class="form-control">
                          <option value="">SELECCIONE</option>
                          <?php
                          $med = new Login();
        $med = $med->ListarMedidas();
        for ($i = 0; $i < sizeof($med); $i++) {
            ?>
                                  <option value="<?php echo $med[$i]['codmedida'] ?>"<?php if (!(strcmp($reg[0]['codmedidac'], htmlentities($med[$i]['codmedida'])))) {
                                      echo "selected=\"selected\"";
                                  } ?>><?php echo $med[$i]['nommedida'] ?></option>        
                            <?php } ?>
                          </select> 
                        </div> 
                      </div>


                        <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                  <label class="control-label">Cantidad de Compra: <span class="symbol required"></span></label>
            <div id="cargacomprainput"><input type="hidden" class="form-control" name="cantidadcompradb" id="cantidadcompradb" value="<?php echo $reg[0]['cantcompra']; ?>"></div><input type="text" class="form-control calculocompra" name="cantcompra" id="cantcompra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad" value="<?php echo $reg[0]['cantcompra']; ?>" tabindex="7" required="" aria-required="true">
                                    <i class="fa fa-pencil form-control-feedback"></i> 
                                          </div> 
                                    </div>

                          <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
            <label class="control-label">Cantidad de Bonificación: <span class="symbol required"></span></label>
            <div id="cargabonifinput"><input type="hidden" class="form-control" name="cantidadbonifdb" id="cantidadbonifdb" value="<?php echo $reg[0]['cantbonif']; ?>"></div><input type="text" class="form-control calculocompra" name="cantbonif" id="cantbonif" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad Bonif" value="<?php echo $reg[0]['cantbonif']; ?>" tabindex="8" required="" aria-required="true">
                                    <i class="fa fa-pencil form-control-feedback"></i> 
                                          </div> 
                                    </div>
                    </div>  


                <div class="row">


                                     <div class="col-md-3"> 
                                          <div class="form-group has-feedback"> 
                <label class="control-label">Desc. en Factura: <span class="symbol required"></span></label>
            <input class="form-control calculocompra" type="text" name="descfactura" id="descfactura" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento de Factura" value="<?php echo $reg[0]['descfactura']; ?>" tabindex="9" required="" aria-required="true">
                                    <i class="fa fa-money form-control-feedback"></i>
                                          </div> 
                                    </div> 

                                     <div class="col-md-3"> 
                                          <div class="form-group has-feedback"> 
                <label class="control-label">Desc. en Farmacia: <span class="symbol required"></span></label>
            <input class="form-control" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento en Farmacia" value="<?php echo $reg[0]['descproductoc']; ?>" tabindex="10" required="" aria-required="true">
                                    <i class="fa fa-money form-control-feedback"></i>
                                          </div> 
                                    </div> 

                                    <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                    <label class="control-label">IGV de Producto: <span class="symbol required"></span></label>
              <select name="ivaproducto" id="ivaproducto" tabindex="11" class="form-control" required="" aria-required="true">
                                    <option value="">SELECCIONE</option>
            <option value="SI"<?php if (!(strcmp('SI', $reg[0]['ivaproductoc']))) {
                echo "selected=\"selected\"";
            } ?>>SI</option>
            <option value="NO"<?php if (!(strcmp('NO', $reg[0]['ivaproductoc']))) {
                echo "selected=\"selected\"";
            } ?>>NO</option>
                              </select>  
                                     </div> 
                            </div>

               <div class="col-md-3"> 
                   <div class="form-group has-feedback"> 
                    <label class="control-label">N° de Lote: <span class="symbol required"></span></label>
                     <input class="form-control" type="text" name="lote" id="lote" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="16" value="<?php echo $reg[0]['lote']; ?>" placeholder="N° Lote" tabindex="12">
                     <i class="fa fa-flash form-control-feedback"></i> 
                   </div> 
                 </div>
              </div>

              <div class="row">

                            <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
            <input class="form-control calculocompra" type="text" name="preciocompra" id="preciocompra" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Precio de Compra" value="<?php echo $reg[0]['preciocomprac']; ?>" tabindex="13" required="" aria-required="true">
                                    <i class="fa fa-money form-control-feedback"></i> 
                                          </div> 
                                    </div>

                                        <div class="col-md-3"> 
                                          <div class="form-group has-feedback"> 
                <label class="control-label">Precio Venta (Caja): <span class="symbol required"></span></label>
            <input class="form-control calculounidad" type="text" name="precioventacaja" id="precioventacaja" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Precio Venta (Caja)" value="<?php echo $reg[0]['precioventacajac']; ?>" tabindex="14" required="" aria-required="true">
                                    <i class="fa fa-money form-control-feedback"></i> 
                                          </div> 
                                    </div>

                       <div class="col-md-3"> 
                                          <div class="form-group has-feedback"> 
              <label class="control-label">Precio Venta (Unidad): <span class="symbol required"></span></label>
            <input class="form-control" type="text" name="precioventaunidad" id="precioventaunidad" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Precio Venta (Unidad)" value="<?php echo $reg[0]['precioventaunidadc']; ?>" tabindex="15" readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i> 
                                          </div> 
                                    </div>

                                  <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                    <label class="control-label">Unidades por Cajas: <span class="symbol required"></span></label>
            <input type="text" class="form-control calculounidad" name="unidades" id="unidades" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="16" placeholder="Ingrese Cantidad Bonif" value="<?php echo $reg[0]['unidadesc']; ?>">
                                    <i class="fa fa-pencil form-control-feedback"></i> 
                                          </div> 
                                    </div>        
                    </div>


                    <div class="row"> 

                            <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                        <label class="control-label">Valor Total: <span class="symbol required"></span></label>
            <input class="form-control" type="text" name="valortotal" id="valortotal"onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Valor Total" value="<?php echo $reg[0]['valortotal']; ?>" tabindex="17" readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i> 
                                          </div> 
                                    </div> 


                            <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                        <label class="control-label">% Descuento: <span class="symbol required"></span></label>
            <input class="form-control" type="text" name="totaldescuentoc" id="totaldescuentoc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese % Descuento" value="<?php echo $reg[0]['totaldescuentoc']; ?>" tabindex="18" readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i> 
                                          </div> 
                                    </div> 

                            <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                    <label class="control-label">Dcto Bonificación: <span class="symbol required"></span></label>
            <input class="form-control" type="text" name="descbonific" id="descbonific" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Dcto de Bonificación" value="<?php echo $reg[0]['descbonific']; ?>" tabindex="19" readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i> 
                                          </div> 
                                    </div>   

                            <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                    <label class="control-label">Valor Neto: <span class="symbol required"></span></label>
            <input class="form-control" type="text" name="valorneto" id="valorneto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Valor Neto" value="<?php echo $reg[0]['valorneto']; ?>" tabindex="20" readonly="readonly">
                                    <i class="fa fa-money form-control-feedback"></i> 
                                          </div> 
                                    </div>     
                    </div>


                    <div class="row">  

                                    <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
                      <label class="control-label">Código de Barra: <span class="symbol required"></span></label>
            <input type="text" class="form-control" name="codigobarra" id="codigobarra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra" value="<?php echo $reg[0]['codigobarrac']; ?>" tabindex="21" required="" aria-required="true">
                                    <i class="fa fa-barcode form-control-feedback"></i> 
                                          </div> 
                                    </div>

                                   <div class="col-md-3"> 
                                          <div class="form-group has-feedback"> 
                        <label class="control-label">Laboratorio: <span class="symbol required"></span></label> 
            <select name="codlaboratorio" id="codlaboratorio" tabindex="22" class="form-control" required="" aria-required="true">
                                    <option value="">SELECCIONE</option>
                  <?php
                  $lab = new Login();
        $lab = $lab->ListarLaboratorios();
        for ($i = 0; $i < sizeof($lab); $i++) {
            ?>
                  <option value="<?php echo $lab[$i]['codlaboratorio'] ?>"<?php if (!(strcmp($reg[0]['codlaboratorioc'], htmlentities($lab[$i]['codlaboratorio'])))) {
                      echo "selected=\"selected\"";
                  } ?>><?php echo $lab[$i]['nomlaboratorio'] ?></option>        
                                  <?php } ?>
                              </select> 
                                          </div> 
                                    </div>

                                 <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
            <label for="field-6" class="control-label">Fecha de Elaboración: </label> 
              <input type="text" class="form-control calendario" name="fechaelaboracion" id="fechaelaboracion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha de Elaboración" value="<?php echo $reg[0]['fechaelaboracionc']; ?>" tabindex="23">
                                    <i class="fa fa-calendar form-control-feedback"></i>  
                                          </div> 
                                    </div> 

                                      <div class="col-md-3"> 
                                           <div class="form-group has-feedback"> 
            <label for="field-6" class="control-label">Fecha de Expiración: </label> 
              <input type="text" class="form-control expira" name="fechaexpiracion" id="fechaexpiracion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha de Expiración" value="<?php echo $reg[0]['fechaexpiracionc']; ?>" tabindex="24">
              <input type="text" class="form-control expira hidden" name="fechaexpiracionold" id="fechaexpiracionold" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha de Expiración" value="<?php echo $reg[0]['fechaexpiracionc']; ?>" tabindex="24">
                                    <i class="fa fa-calendar form-control-feedback"></i>  
                                          </div> 
                                    </div> 

                                </div><br>
                                    
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