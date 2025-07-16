<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ContarRegistros();

        $tra = new Login();
        $ses = $tra->ExpiraSession();
        $reg = $tra->ListarProductos();

        if (isset($_POST['btn-submit'])) {
            $reg = $tra->RegistrarProductos();
            exit;
        } elseif (isset($_POST['btn-update'])) {
            $reg = $tra->ActualizarProductos();
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
                            <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
                            <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
                            <link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
                            <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
                            <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>

                            <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                            <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
                            <link href="assets/css/style.css" rel="stylesheet" type="text/css">

                            <!-- script jquery -->
                            <script src="assets/js/jquery.min.js"></script>
                            <!-- Custom file upload -->
                            <script src="assets/plugins/fileupload/bootstrap-fileupload.min.js"></script>
                            <script type="text/javascript" src="assets/script/titulos.js"></script>
                            <script type="text/javascript" src="assets/script/script2.js"></script>

                            <script type="text/javascript" src="assets/script/product-modal.js"></script>
                    
                            <script type="text/javascript" src="assets/script/validation.min.js"></script>
                            <script type="text/javascript" src="assets/script/script.js"></script>
                            <!-- script jquery -->

                            <!-- Calendario -->
                            <link rel="stylesheet" href="assets/calendario/jquery-ui.css"/>
                            <script src="assets/calendario/jquery-ui.js"></script>
                            <script src="assets/script/jscalendario.js"></script>
                            <script src="assets/script/autocompleto.js"></script>
                            <!-- Calendario -->
                            <?php
                            if (isset($_GET['acc'])) {

                                if ($_GET['acc'] == 'upd') {
                                    echo "<script>alert('Producto actualizado con éxito');</script>";
                                }

                            }
        ?>

                            <style>
                                tr[data-isScarce="true"] {
                                    background-color: antiquewhite !important;
                                }
                                tr[data-isExpired="true"] {
                                    background-color: pink !important;
                                }
                            </style>

                        </head>

                        <body onLoad="muestraReloj()" class="fixed-left">
                        <!-- Modal para mostrar detalles del producto-->
                        <div class="modal fade bs-example-modal-lgg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                             aria-hidden="true" style="display: none">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content p-0 b-0">
                                    <div class="panel panel-color panel-primary">
                                        <div class="panel-heading">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                                        src="assets/images/close.png"/></button>
                                            <h3 class="panel-title"><i class="fa fa-align-justify"></i> Detalle y Movimientos del
                                                Producto
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="muestraproductomodal"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                                        class="fa fa-times-circle"></span> Aceptar
                                            </button>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        <!-- Modal para mostrar foto y codigo de barra del producto -->
                        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                             aria-hidden="true" style="display: none">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content p-0 b-0">
                                    <div class="panel panel-color panel-primary">
                                        <div class="panel-heading">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                                        src="assets/images/close.png"/></button>
                                            <h3 class="panel-title"><i class="fa fa-picture-o"></i> Foto del Producto</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="muestrafotoproductomodal"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                                        class="fa fa-times-circle"></span> Aceptar
                                            </button>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        <!-- Modal para Registro de Productos-->
                        <div id="record-product-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none">

                            <div class="modal-dialog modal-lg">
                                <div class="modal-content p-0 b-0">
                                    <div class="panel panel-color panel-primary">
                                        <div class="panel-heading">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                                        src="assets/images/close.png"/></button>
                                            <h3 class="panel-title"><i class="fa fa-save"></i> Registro de Productos</h3>
                                        </div>
                                        <form class="form" method="post" action="#" name="productos" id="productos"
                                              enctype="multipart/form-data">
                                            <div class="panel-body">
                                                <div id="read">
                                                    <!-- error will be shown here ! -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Código Producto: <span
                                                                        class="symbol required"></span></label>
                                                            <div id="codigoproducto"><input type="text" class="form-control"
                                                                                            name="codproducto" id="codproducto"
                                                                                            onKeyUp="this.value=this.value.toUpperCase();"
                                                                                            autocomplete="off"
                                                                                            placeholder="Ingrese Código de Producto"
                                                                                            value="<?php $prod = new Login();
        echo $p = $prod->CodigoProducto(); ?>"
                                                                                            tabindex="1" required=""
                                                                                            aria-required="true"></div>
                                                            <i class="fa fa-flash form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nombre de Producto: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="producto" id="producto"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Nombre de Producto" tabindex="2" required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Principio Activo: </label>
                                                            <input type="text" class="form-control" name="principioactivo"
                                                                   id="principioactivo" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Principio Activo"
                                                                   tabindex="3"
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Indicaciones: </label>
                                                            <input type="text" class="form-control" name="descripcion" id="descripcion"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Descripción de Producto" tabindex="4"
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Presentación: <span
                                                                        class="symbol required"></span></label>
                                                            <select name="codpresentacion" id="codpresentacion" tabindex="5"
                                                                    class="form-control" aria-required="true" required>
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
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Categoría: </label>
                                                            <select name="codmedida" id="codmedida" tabindex="6" class="form-control"
                                                                    aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                                $med = new Login();
        $med = $med->ListarMedidas();
        for ($i = 0; $i < sizeof($med); $i++) {
            ?>
                                                                            <option value="<?php echo $med[$i]['codmedida'] ?>">
                                                                                <?php echo $med[$i]['nommedida'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Laboratorio: </label>
                                                            <select name="codlaboratorio" id="codlaboratorio" tabindex="7"
                                                                    class="form-control" aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                                $lab = new Login();
        $lab = $lab->ListarLaboratorios();
        for ($i = 0; $i < sizeof($lab); $i++) {
            ?>
                                                                            <option value="<?php echo $lab[$i]['codlaboratorio'] ?>">
                                                                                <?php echo $lab[$i]['nomlaboratorio'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Proveedor: </label>
                                                            <select name="codproveedor" id="codproveedor" tabindex="8"
                                                                    class="form-control"
                                                                    aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                                $proveedor = new Login();
        $proveedor = $proveedor->ListarProveedores();
        for ($i = 0; $i < sizeof($proveedor); $i++) {
            ?>
                                                                            <option value="<?php echo $proveedor[$i]['codproveedor'] ?>">
                                                                                <?php echo $proveedor[$i]['nomproveedor'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">N° de Lote:</label>
                                                            <input class="form-control" type="text" name="loteproducto"
                                                                   id="loteproducto"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Lote de Producto" tabindex="9"
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!--blister PVP-->

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Caja (PVP): </label>
                                                            <input class="form-control  new" type="text" name="precioventacaja"
                                                                   id="precioventacaja" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Cajas)" tabindex="11"
                                                                   aria-required="true">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Blister (PVP): </label>
                                                            <input class="form-control" type="text" name="precioventablister"
                                                                   id="precioventablister" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Blister)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Unidad (PVP): </label>
                                                            <input class="form-control" type="text" name="precioventaunidad"
                                                                   id="precioventaunidad" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Unid.)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Blister con Descuento: </label>
                                                            <input class="form-control" type="text" name="precioventablisterdesc"
                                                                   id="precioventablisterdesc" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Blister con descuento)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Caja con Descuento: </label>
                                                            <input class="form-control" type="text" name="precioventacajadesc"
                                                                   id="precioventacajadesc" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Caja con descuento)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Unidad con Descuento: </label>
                                                            <input class="form-control" type="text" name="precioventaunidaddesc"
                                                                   id="precioventaunidaddesc" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Unidad con descuento)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock por Cajas:</label>
                                                            <input class="form-control " type="text" name="stockcajas"
                                                                   id="stockcajas" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Stock por Cajas" value="0"
                                                                   tabindex="13" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Unidades por caja: </label>
                                                            <input class="form-control  " type="text"
                                                                   name="unidades" id="unidades"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Unidades por Cajas"
                                                                   tabindex="14"
                                                                   value="0" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock por Unidad (Sin Cajas): </label>
                                                            <input type="text" class="form-control " name="stockunidad"
                                                                   id="stockunidad" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Stock por Unidad"
                                                                   tabindex="15"
                                                                   value="0" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Blister en caja:</label>
                                                            <input class="form-control " type="text" name="stockblister"
                                                                   id="stockblister" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Blister por caja" value="0"
                                                                   tabindex="13" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock por Blister:</label>
                                                            <input class="form-control " type="text" name="totalBlister"
                                                                   id="totalBlister" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Stock por Blister" value="0"
                                                                   tabindex="13" aria-required="true" readonly>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Unidades por Blister: </label>
                                                            <input class="form-control  new" type="text"
                                                                   name="unidadesblister" id="unidadesblister"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Unidades por Blister"
                                                                   tabindex="14"
                                                                   value="0" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <input type="hidden" name="ivaproducto" id="ivaproducto" value="SI"/>

                                                        <!--
                                        <div class="form-group has-feedback">
                                            <label class="control-label">IGV de Producto: </label>
                                            <select name="ivaproducto" id="ivaproducto" tabindex="18" class="form-control"
                                                aria-required="true">

                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                                            -->
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio de Compra Caja: <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control new" type="text" name="preciocompra"
                                                                   id="preciocompra"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Compra" value="0.00" tabindex="10">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio de Compra Blister: </label>
                                                            <input class="form-control" type="text" name="preciocomprablister"
                                                                   id="preciocomprablister"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Compra" value="0.00" tabindex="10">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio de Compra Unidad: </label>
                                                            <input class="form-control" type="text" name="preciocompraunidad"
                                                                   id="preciocompraunidad"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Compra" value="0.00" tabindex="10">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock Minimo: </label>
                                                            <input type="text" class="form-control" name="stockminimo" id="stockminimo"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Stock Minimo de Producto" tabindex="17"
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock Total: </label>
                                                            <input type="text" class="form-control" name="stocktotal" id="stocktotal"
                                                                   placeholder="Ingrese Stock Total" value="0"
                                                                   readonly="readonly">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Código de Barra: </label>
                                                            <input type="text" class="form-control" name="codigobarra" id="codigobarra"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Código de Barra" tabindex="22"
                                                                   aria-required="true">
                                                            <i class="fa fa-barcode form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Ubicación en Estante: </label>
                                                            <input class="form-control" type="text" name="ubicacion" id="ubicacion"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese ubicacion en Estanteria" tabindex="23"
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Descuento %: </label>
                                                            <input class="form-control" type="text" name="descproducto"
                                                                   id="descproducto"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Descuento de Producto" tabindex="19"
                                                                   aria-required="true" value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">

                                                    <?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "cajero") { ?>


                                                                <div class="col-md-4">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Sucursal Asignada: </label>
                                                                        <input type="hidden" name="codsucursal" id="codsucursal"
                                                                               value="<?php echo $_SESSION["codsucursal"]; ?>"><input
                                                                                type="text"
                                                                                class="form-control" name="sucursal" id="sucursal"
                                                                                onKeyUp="this.value=this.value.toUpperCase();"
                                                                                autocomplete="off"
                                                                                placeholder="Ingrese Nombre de Sucursal"
                                                                                value="<?php echo $_SESSION["razonsocial"]; ?>" tabindex="25"
                                                                                readonly="readonly">
                                                                        <i class="fa fa-bank form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                    <?php } else { ?>

                                                                <div class="col-md-4">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Sucursal: </label>
                                                                        <select name="codsucursal" id="codsucursal" tabindex="25"
                                                                                class="form-control"
                                                                                aria-required="true">

                                                                            <?php
                    $sucursal = new Login();
                                                        $sucursal = $sucursal->ListarSucursal();
                                                        for ($i = 0; $i < sizeof($sucursal); $i++) {
                                                            ?>
                                                                                        <option value="<?php echo $sucursal[$i]['codsucursal'] ?>">
                                                                                            <?php echo $sucursal[$i]['razonsocial'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                    <?php } ?>

                                                    <div class="col-md-4" style="display:none">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Fecha de Elaboración: </label>
                                                            <input type="text" class="form-control calendario" name="fechaelaboracion"
                                                                   id="fechaelaboracion" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Fecha de Elaboración"
                                                                   tabindex="20"
                                                                   aria-required="true">
                                                            <i class="fa fa-calendar form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Fecha de Expiración: </label>
                                                            <input type="text" class="form-control calendario" name="fechaexpiracion"
                                                                   id="fechaexpiracion" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Fecha de Expiración"
                                                                   tabindex="21"
                                                                   aria-required="true">
                                                            <i class="fa fa-calendar form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Status de Producto: </label>
                                                            <select name="statusp" id="statusp" class="form-control" tabindex="24"
                                                                    aria-required="true">

                                                                <option value="0">ACTIVO</option>
                                                                <option value="1">INACTIVO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <div class="form-group has-feedback">
                                                                <label class="control-label">Registro Sanitario: </label>
                                                                <input type="text" class="form-control" name="rsanitario"
                                                                    id="rsanitario2" onKeyUp="this.value=this.value.toUpperCase();"
                                                                    autocomplete="off" placeholder="Ingrese Registro Sanitario"
                                                                    required="" aria-required="true">
                                                                <i class="fa fa-pencil form-control-feedback"></i>
                                                            </div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                                 style="width: 90px; height: 100px;">
                                                                <?php if (isset($reg[0]['codproducto'])) {
                                                                    if (file_exists("fotos/" . $reg[0]['codproducto'] . ".jpg")) {
                                                                        echo "<img src='fotos/" . $reg[0]['codproducto'] . ".jpg?" . date('h:i:s') . "' class='img-rounded' border='0' width='100' height='110' title='Foto del Producto' data-rel='tooltip'>";
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
                                                                            <span class="fileinput-new"><i
                                                                                        class="fa fa-file-image-o"></i>
                                                                                Imagen</span>
                                                                            <span class="fileinput-exists"><i
                                                                                        class="fa fa-paint-brush"></i>
                                                                                Imagen</span>
                                                                            <input type="file" size="10"
                                                                                   data-original-title="Subir Fotografia"
                                                                                   data-rel="tooltip" placeholder="Suba su Fotografia"
                                                                                   name="imagen"
                                                                                   id="imagen" tabindex="26"/>
                                                                        </span>
                                                                <a href="#" class="btn btn-danger fileinput-exists"
                                                                   data-dismiss="fileinput"><i class="fa fa-times-circle"></i>
                                                                    Remover</a><small>
                                                                    <p>Para Subir la Foto del Producto debe tener en cuenta lo
                                                                        siguiente:<br> * La Imagen debe ser extension.jpg<br> * La
                                                                        imagen no
                                                                        debe ser mayor de 50 KB</p>
                                                                </small></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span
                                                            class="fa fa-save"></span> Guardar
                                                </button>
                                                <button class="btn btn-danger" type="reset" class="close" data-dismiss="modal"
                                                        aria-hidden="true"><i class="fa fa-trash-o"></i> Cerrar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal para Actualizar de Productos-->
                        <div id="update-product-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none">

                            <div class="modal-dialog modal-lg">
                                <div class="modal-content p-0 b-0">
                                    <div class="panel panel-color panel-primary">
                                        <div class="panel-heading">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                                        src="assets/images/close.png"/></button>
                                            <h3 class="panel-title"><i class="fa fa-edit"></i> Actualizar Productos</h3>
                                        </div>
                                        <form class="form" method="post" action="#" name="updateproducto" id="updateproducto"
                                              enctype="multipart/form-data">
                                            <div class="panel-body">
                                                <div id="update">
                                                    <!-- error will be shown here ! -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Código Producto: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="hidden" name="codalmacen" id="codalmacen">
                                                            <input type="hidden" name="busqueda" id="busqueda">
                                                            <input type="text" class="form-control" name="codproducto" id="codproducto"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Código de Producto" tabindex="1"
                                                                   readonly="readonly">
                                                            <i class="fa fa-flash form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nombre de Producto: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="producto" id="producto"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Nombre de Producto" tabindex="2" required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Principio Activo: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="principioactivo"
                                                                   id="principioactivo" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Principio Activo"
                                                                   tabindex="3"
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Indicaciones: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="descripcion" id="descripcion"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Descripción de Producto" tabindex="4"
                                                                   required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Presentación: <span
                                                                        class="symbol required"></span></label>
                                                            <select name="codpresentacion" id="codpresentacion" tabindex="5"
                                                                    class="form-control" required="" aria-required="true">
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
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Categoría: <span
                                                                        class="symbol required"></span></label>
                                                            <select name="codmedida" id="codmedida" tabindex="6" class="form-control"
                                                                    required="" aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                                $med = new Login();
        $med = $med->ListarMedidas();
        for ($i = 0; $i < sizeof($med); $i++) {
            ?>
                                                                            <option value="<?php echo $med[$i]['codmedida'] ?>">
                                                                                <?php echo $med[$i]['nommedida'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Laboratorio: <span
                                                                        class="symbol required"></span></label>
                                                            <select name="codlaboratorio" id="codlaboratorio" tabindex="7"
                                                                    class="form-control" required="" aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                                $lab = new Login();
        $lab = $lab->ListarLaboratorios();
        for ($i = 0; $i < sizeof($lab); $i++) {
            ?>
                                                                            <option value="<?php echo $lab[$i]['codlaboratorio'] ?>">
                                                                                <?php echo $lab[$i]['nomlaboratorio'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Proveedor: <span
                                                                        class="symbol required"></span></label>
                                                            <select name="codproveedor" id="codproveedor" tabindex="8"
                                                                    class="form-control"
                                                                    required="" aria-required="true">
                                                                <option value="">SELECCIONE</option>
                                                                <?php
                                                                $proveedor = new Login();
        $proveedor = $proveedor->ListarProveedores();
        for ($i = 0; $i < sizeof($proveedor); $i++) {
            ?>
                                                                            <option value="<?php echo $proveedor[$i]['codproveedor'] ?>">
                                                                                <?php echo $proveedor[$i]['nomproveedor'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">N° de Lote: <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text" name="loteproducto"
                                                                   id="loteproducto"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Lote de Producto" tabindex="9" required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Caja (PVP): <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text"
                                                                   name="precioventacaja"
                                                                   id="precioventacaja2" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Cajas)" tabindex="11"
                                                                   required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Blister (PVP): <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text"
                                                                   name="precioventablister"
                                                                   id="precioventablister2" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Blister)" tabindex="11"
                                                                   required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Unidad (PVP): <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text" name="precioventaunidad"
                                                                   id="precioventaunidad2" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Unid.)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Blister con Descuento: </label>
                                                            <input class="form-control" type="text" name="precioventablisterdesc"
                                                                   id="precioventablisterdesc" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Blister con descuento)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Caja con Descuento: </label>
                                                            <input class="form-control" type="text" name="precioventacajadesc"
                                                                   id="precioventacajadesc" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Caja con descuento)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio por Unidad con Descuento: </label>
                                                            <input class="form-control" type="text" name="precioventaunidaddesc"
                                                                   id="precioventaunidaddesc" onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Venta (Unidad con descuento)" tabindex="12"
                                                                   value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") { ?>

                                                                <div class="col-md-4">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Stock por Cajas: <span
                                                                                    class="symbol required"></span></label>
                                                                        <input class="form-control" type="text" name="stockcajas"
                                                                               id="stockcajas2" onKeyUp="this.value=this.value.toUpperCase();"
                                                                               autocomplete="off" placeholder="Ingrese Stock por Cajas"
                                                                               value="0"
                                                                               tabindex="13" required="" aria-required="true">
                                                                        <i class="fa fa-pencil form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                    <?php } else { ?>

                                                                <div class="col-md-4">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Stock por Cajas: <span
                                                                                    class="symbol required"></span></label>
                                                                        <input class="form-control 2" type="text" name="stockcajas"
                                                                               id="stockcajas2" onKeyUp="this.value=this.value.toUpperCase();"
                                                                               autocomplete="off" placeholder="Ingrese Stock por Cajas"
                                                                               value="0"
                                                                               tabindex="13" readonly="readonly" aria-required="true">
                                                                        <i class="fa fa-pencil form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                    <?php } ?>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Unidades por Cajas: <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text"
                                                                   name="unidades" id="unidades2"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Unidades por Cajas" tabindex="14" value="0"
                                                                   required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock por Unidad (Sin Cajas): <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="stockunidad"
                                                                   id="stockunidad2" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Stock por Unidad"
                                                                   tabindex="15"
                                                                   value="0" required="" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Blister por Caja:</label>
                                                            <input class="form-control" type="text" name="blistercaja"
                                                                   id="stockblister2" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Blister por caja" value="0"
                                                                   tabindex="13" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock por Blister:</label>
                                                            <input class="form-control" type="text" name="totalBlister2"
                                                                   id="totalBlister2" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Stock por Blister" value="0"
                                                                   tabindex="13" aria-required="true" readonly>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Unidades por Blister: </label>
                                                            <input class="form-control" type="text"
                                                                   name="unidadesblister" id="unidadesblister2"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Unidades por Blister"
                                                                   tabindex="14"
                                                                   value="0" aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <input type="hidden" name="ivaproducto" id="ivaproducto" value="SI"/>
                                                        <!--
                                        <div class="form-group has-feedback">
                                            <label class="control-label">IGV de Producto: <span
                                                    class="symbol required"></span></label>
                                            <select name="ivaproducto" id="ivaproducto" tabindex="18" class="form-control"
                                                required="" aria-required="true">

                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                    -->
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio de Compra Caja: <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text" name="preciocompra"
                                                                   id="preciocompra2"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Compra" value="0.00" tabindex="10">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio de Compra Blister: </label>
                                                            <input class="form-control" type="text" name="preciocomprablister"
                                                                   id="preciocomprablister2"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Compra" value="0.00" tabindex="10">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Precio de Compra Unidad:</label>
                                                            <input class="form-control" type="text" name="preciocompraunidad"
                                                                   id="preciocompraunidad2"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Precio de Compra" value="0.00" tabindex="10">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">


                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock Minimo: </label>
                                                            <input type="text" class="form-control" name="stockminimo" id="stockminimo"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Stock Minimo de Producto" tabindex="17"
                                                                   required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Stock Total: </label>
                                                            <input type="text" class="form-control" name="stocktotal" id="stocktotal2"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Stock Total" tabindex="16" value="0"
                                                                   readonly="readonly">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Código de Barra: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="codigobarra" id="codigobarra"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Código de Barra" tabindex="22" required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-barcode form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Ubicación en Estante: <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text" name="ubicacion" id="ubicacion"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese ubicacion en Estanteria" tabindex="23"
                                                                   required=""
                                                                   aria-required="true">
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Descuento %: <span
                                                                        class="symbol required"></span></label>
                                                            <input class="form-control" type="text" name="descproducto"
                                                                   id="descproducto"
                                                                   onKeyPress="EvaluateText('%f', this);"
                                                                   onBlur="this.value = NumberFormat(this.value, '2', '.', '')"
                                                                   onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                                                   placeholder="Ingrese Descuento de Producto" tabindex="19" required=""
                                                                   aria-required="true" value="0.00">
                                                            <i class="fa fa-money form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "cajero") { ?>


                                                                <div class="col-md-4">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Sucursal Asignada: <span
                                                                                    class="symbol required"></span></label>
                                                                        <input type="hidden" name="codsucursal" id="codsucursal"
                                                                               value="<?php echo $_SESSION["codsucursal"]; ?>"><input
                                                                                type="text"
                                                                                class="form-control" name="sucursal" id="sucursal"
                                                                                onKeyUp="this.value=this.value.toUpperCase();"
                                                                                autocomplete="off"
                                                                                placeholder="Ingrese Nombre de Sucursal"
                                                                                value="<?php echo $_SESSION["razonsocial"]; ?>" tabindex="25"
                                                                                readonly="readonly">
                                                                        <i class="fa fa-bank form-control-feedback"></i>
                                                                    </div>
                                                                </div>

                                                    <?php } else { ?>

                                                                <div class="col-md-4">
                                                                    <div class="form-group has-feedback">
                                                                        <label class="control-label">Sucursal: <span
                                                                                    class="symbol required"></span></label>
                                                                        <select name="codsucursal" id="codsucursal" tabindex="25"
                                                                                class="form-control"
                                                                                required="" aria-required="true">

                                                                            <?php
                    $sucursal = new Login();
                                                        $sucursal = $sucursal->ListarSucursal();
                                                        for ($i = 0; $i < sizeof($sucursal); $i++) {
                                                            ?>
                                                                                        <option value="<?php echo $sucursal[$i]['codsucursal'] ?>">
                                                                                            <?php echo $sucursal[$i]['razonsocial'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                    <?php } ?>
                                                    <div class="col-md-4" style="display:none">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Fecha de Elaboración: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control calendario" name="fechaelaboracion"
                                                                   id="fechaelaboracion" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Fecha de Elaboración"
                                                                   tabindex="20"
                                                                   required="" aria-required="true">
                                                            <i class="fa fa-calendar form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Fecha de Expiración: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control calendario" name="fechaexpiracion"
                                                                   id="fechaexpiracion" onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off" placeholder="Ingrese Fecha de Expiración"
                                                                   tabindex="21"
                                                                   required="" aria-required="true">
                                                            <i class="fa fa-calendar form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Status de Producto: </label>
                                                            <select name="statusp" id="statusp" class="form-control" tabindex="24"
                                                                    aria-required="true">

                                                                <option value="0">ACTIVO</option>
                                                                <option value="1">INACTIVO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <div class="form-group has-feedback">
                                                                <label class="control-label">Registro Sanitario: </label>
                                                                <input type="text" class="form-control" name="rsanitario"
                                                                    id="rsanitario2" onKeyUp="this.value=this.value.toUpperCase();"
                                                                    autocomplete="off" placeholder="Ingrese Registro Sanitario"
                                                                    required="" aria-required="true">
                                                                <i class="fa fa-pencil form-control-feedback"></i>
                                                            </div>
                                                     </div>
                                                    <div class="col-sm-8">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                                 style="width: 90px; height: 100px;">
                                                                <?php if (isset($reg[0]['codproducto'])) {
                                                                    if (file_exists("fotos/" . $reg[0]['codproducto'] . ".jpg")) {
                                                                        echo "<img src='fotos/" . $reg[0]['codproducto'] . ".jpg?" . date('h:i:s') . "' class='img-rounded' border='0' width='100' height='110' title='Foto del Producto' data-rel='tooltip'>";
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
                                                                            <span class="fileinput-new"><i
                                                                                        class="fa fa-file-image-o"></i>
                                                                                Imagen</span>
                                                                            <span class="fileinput-exists"><i
                                                                                        class="fa fa-paint-brush"></i>
                                                                                Imagen</span>
                                                                            <input type="file" size="10"
                                                                                   data-original-title="Subir Fotografia"
                                                                                   data-rel="tooltip" placeholder="Suba su Fotografia"
                                                                                   name="imagen"
                                                                                   id="imagen" tabindex="26"/>
                                                                        </span>
                                                                <a href="#" class="btn btn-danger fileinput-exists"
                                                                   data-dismiss="fileinput"><i class="fa fa-times-circle"></i>
                                                                    Remover</a><small>
                                                                    <p>Para Subir la Foto del Producto debe tener en cuenta lo
                                                                        siguiente:<br> * La Imagen debe ser extension.jpg<br> * La
                                                                        imagen no
                                                                        debe ser mayor de 50 KB</p>
                                                                </small></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="btn-update" id="btn-update" class="btn btn-primary"><span
                                                            class="fa fa-edit"></span> Actualizar
                                                </button>
                                                <button class="btn btn-danger" type="reset" class="close" data-dismiss="modal"
                                                        aria-hidden="true"><i class="fa fa-trash-o"></i> Cerrar
                                                </button>
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
                                                <button type="button" class="button-menu-mobile open-left waves-effect waves-light"><i
                                                            class="ion-navicon"></i></button>
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
                                                            <a href="buscastockminimo"
                                                               class="dropdown-toggle waves-effect list-group-item">
                                                                <div class="media">
                                                                    <div class="pull-left">
                                                                        <em class="fa fa-cube fa-2x text-danger"></em>
                                                                    </div>
                                                                    <div class="media-body clearfix">
                                                                        <div class="media-heading">Productos en Stock Minimo</div>
                                                                        <p class="m-0">
                                                                            <small>Existen <span
                                                                                        class="text-primary"><?php echo $con[0]['stockproductos']; ?></span>
                                                                                Productos en Stock</small>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <!-- list item-->
                                                            <a href="productosvencidos"
                                                               class="dropdown-toggle waves-effect list-group-item">
                                                                <div class="media">
                                                                    <div class="pull-left">
                                                                        <em class="fa fa-calendar fa-2x text-warning"></em>
                                                                    </div>
                                                                    <div class="media-body clearfix">
                                                                        <div class="media-heading">Productos Vencidos</div>
                                                                        <p class="m-0">
                                                                            <small>Existen <span
                                                                                        class="text-primary"><?php echo $con[0]['productosvencidos']; ?></span>
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
                                                                            <small>Existen <span
                                                                                        class="text-primary"><?php echo $con[0]['creditoscomprasvencidos']; ?></span>
                                                                                Créditos Vencidos</small></p>
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
                                                                            <small>Existen <span
                                                                                        class="text-primary"><?php echo $con[0]['creditosventasvencidos']; ?></span>
                                                                                Créditos Vencidos</small></p>
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
                                                                class="fa fa-crosshairs"></i></a></li>
                                                <li class="dropdown">
                                                    <a href="" class="dropdown-toggle profile waves-effect waves-light"
                                                       data-toggle="dropdown" aria-expanded="true">

                                                        <span class="dropdown hidden-xs"><abbr
                                                                    title="<?php echo estado($_SESSION['acceso']); ?>"><?php echo $_SESSION['nombres']; ?></abbr></span>
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
                                <h4 class="pull-left page-title"><i class="fa fa-tasks"></i> Control de Productos</h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="panel">Inicio</a></li>
                                    <li class="active">Control de Productos</li>
                                </ol>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form" method="post" action="#" name="busquedaproductos" id="busquedaproductos">
                                <div class="panel panel-primary">
                                    <?php if ($con[0]['productosvencidos'] > 0) { ?>
                                        <div class="panel-heading panel-heading-productos-vencidos">
                                            <h3 class="panel-title"><i class="fa fa-clock-o"></i> Hay productos vencidos
                                                o por vencer, favor ver notificaciones</h3>
                                        </div>
                                    <?php } ?>
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Búsqueda de Productos<span
                                                    class="pull-right">

                                                        <?php if ($_SESSION['acceso'] == "administradorG") { ?>

                                                            <a class="btn btn-default waves-effect waves-light"
                                                               data-toggle="modal"
                                                               data-target="#record-product-modal" data-backdrop="static"
                                                               data-keyboard="false"
                                                               data-placement="left" title=""
                                                               data-original-title="Nuevo Producto"><i
                                                                        class="fa fa-plus"></i> Nuevo</a>

                                                        <?php } else { ?>

                                                            <div class="btn-group dropdown">
                                                            <button type="button"
                                                                    class="btn btn-default waves-effect waves-light"><span
                                                                        class="fa fa-cog"></span> Procesos</button>
                                                            <button type="button"
                                                                    class="btn btn-default dropdown-toggle waves-effect waves-light"
                                                                    data-toggle="dropdown" aria-expanded="false"><i
                                                                        class="caret"></i></button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="" data-toggle="modal"
                                                                       data-target="#record-product-modal"
                                                                       data-backdrop="static" data-keyboard="false"
                                                                       data-placement="left" title=""
                                                                       data-original-title="Nuevo Producto"><i
                                                                                class="fa fa-plus"></i> Nuevo</a></li>
                                                                <li><a href="reportepdf?codsucursal=<?php echo base64_encode($_SESSION["codsucursal"]); ?>&tipo=<?php echo base64_encode("PRODUCTOSXSUCURSAL") ?>"
                                                                       target="_blank" rel="noopener noreferrer"
                                                                       data-toggle="tooltip" data-placement="left"
                                                                       title=""
                                                                       data-original-title="Listado Pdf"><i
                                                                                class="fa fa-file-pdf-o"></i> Listado (Pdf)</a></li>
                                                                <li><a href="reportepdf?codsucursal=<?php echo base64_encode($_SESSION["codsucursal"]); ?>&tipo=<?php echo base64_encode("PRODUCTOSACTIVOS") ?>"
                                                                       target="_blank" rel="noopener noreferrer"
                                                                       data-toggle="tooltip" data-placement="left"
                                                                       title=""
                                                                       data-original-title="Listado Pdf"><i
                                                                                class="fa fa-file-pdf-o"></i> Activos (Pdf)</a></li>
                                                                <li><a href="reportepdf?codsucursal=<?php echo base64_encode($_SESSION["codsucursal"]); ?>&tipo=<?php echo base64_encode("PRODUCTOSINACTIVOS") ?>"
                                                                       target="_blank" rel="noopener noreferrer"
                                                                       data-toggle="tooltip" data-placement="left"
                                                                       title=""
                                                                       data-original-title="Listado Pdf"><i
                                                                                class="fa fa-file-pdf-o"></i> Inactivos (Pdf)</a></li>
                                                                <li><a href="reportepdf?codsucursal=<?php echo base64_encode($_SESSION["codsucursal"]); ?>&tipo=<?php echo base64_encode("PRODUCTOSSTOCK") ?>"
                                                                       target="_blank" rel="noopener noreferrer"
                                                                       data-toggle="tooltip" data-placement="left"
                                                                       title=""
                                                                       data-original-title="Stock Minimo Pdf"><i
                                                                                class="fa fa-file-pdf-o"></i> Stock M. (Pdf)</a></li>
                                                                <li><a href="reporteexcel?codsucursal=<?php echo base64_encode($_SESSION["codsucursal"]); ?>&tipo=<?php echo base64_encode("PRODUCTOSXSUCURSAL") ?>"
                                                                       data-toggle="tooltip" data-placement="left"
                                                                       title=""
                                                                       data-original-title="Listado Excel"><i
                                                                                class="fa fa-file-excel-o"></i> Listado (Excel)</a></li>
                                                            </ul>
                                                            </div><?php } ?></span></h3>
                                    </div>

                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="box-body">

                                                    <div id="delete-ok"></div>

                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group has-feedback">
                                                                <label class="control-label">Realice la Búsqueda de
                                                                    Productos: <span
                                                                            class="symbol required"></span></label>
                                                                <input class="form-control" type="text"
                                                                       name="buscaproducto"
                                                                       id="buscaproducto"
                                                                       onKeyUp="this.value=this.value.toUpperCase(); BuscarProductos();"
                                                                       autocomplete="off"
                                                                       placeholder="Ingrese Nombre de Producto o Principio Activo para Búsqueda de Productos"
                                                                       required="required">
                                                                <i class="fa fa-search form-control-feedback"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                </div><!-- /.box-body -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="resultadoproducto"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel-body">

                                    <div class="table-responsive">

                                        <div align="center"><a
                                                    href="reportepdf?codsucursal=<?php echo base64_encode($_SESSION['codsucursal']); ?>&tipo=<?php echo base64_encode("PRODUCTOSXSUCURSAL") ?>"
                                                    target="_blank" rel="noopener noreferrer">
                                                <button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-pdf-o"></span> Exportar Pdf
                                                </button>
                                            </a>

                                            <a
                                                    href="reporteexcel?codsucursal=<?php echo base64_encode($_SESSION['codsucursal']); ?>&tipo=<?php echo base64_encode("PRODUCTOSXSUCURSAL") ?>">
                                                <button
                                                        class="btn btn-success btn-lg" type="button"><span
                                                            class="fa fa-file-excel-o"></span> Exportar Excel
                                                </button>
                                            </a>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <?php
                if (isset($_GET["mesage"])) {
                    switch ($_GET["mesage"]) {
                        case 1:
                            echo "<div class='alert alert-info'>";
                            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                            echo "<center><span class='fa fa-check-square-o'></span> LA SUCURSAL FUE ELIMINADA EXITOSAMENTE </center>";
                            echo "</div>";
                            break;

                        case 2:
                            echo "<div class='alert alert-warning'>";
                            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                            echo "<center><span class='fa fa-info-circle'></span> ESTA SUCURSAL NO PUEDE SER ELIMINADA, TIENE PRODUCTOS ASOCIADOS ACTUALMENTE </center>";
                            echo "</div>";
                            break;

                    }
                }
        ?>
                                                <table id="datatable-responsive"
                                                       class="table table-striped table-bordered nowrap dataTable no-footer dtr-inline collapsed"
                                                       role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;"
                                                       width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr role="row">
                                                        <th>N°</th>
                                                        <th>Código de barra</th>
                                                        <th>Producto</th>
                                                        <th>Fecha de Vencimiento</th>
                                                        <th>Laboratorio</th>
                                                        <th>Ubicación</th>
                                                        <th>PVP Unid</th>
                                                        <th>PVP Blister</th>
                                                        <th>PVP Caja</th>
                                                        <th>PVP Blister Desc.</th>
                                                        <th>PVP Caja Desc.</th>
                                                        <th>PVP Unidad Desc.</th>
                                                        <th>Exist</th>
                                                        <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                                                                    <th>
                                                                        Sucursal
                                                                    </th><?php } ?>
                                                        <th>Acciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php

            if ($reg == "") {

                echo "";

            } else {

                $a = 1;
                for ($i = 0; $i < sizeof($reg); $i++) {
                    ?>
                                                                            <tr role="row" class="odd" data-isExpired="<?php echo $reg[$i]['isExpired'] ? 'true' : 'false'; ?>" data-isScarce="<?php echo $reg[$i]['isScarce'] ? 'true' : 'false'; ?>" >
                                                                                <td class="sorting_1" tabindex="0"><?php echo $a++; ?></td>

                                                                                <td><?php echo $reg[$i]['codigobarra']; ?></td>
                                                                                <td>
                                                                                    <abbr
                                                                                            title="<?php echo "Nº " . $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto'] . " : " . $reg[$i]['nommedida'] . " " . $reg[$i]['nompresentacion']; ?></abbr>
                                                                                </td>
                                                                                <td><?php echo $reg[$i]['fechaexpiracion']; ?></td>
                                                                                <td><?php echo $reg[$i]['nomlaboratorio']; ?></td>
                                                                                <td><?php echo $ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"]); ?>
                                                                                </td>
                                                                                <td><?php echo "<strong>" . $_SESSION["simbolo"] . "</strong>" . number_format($reg[$i]['precioventaunidad'], 2, '.', ','); ?>
                                                                                </td>
                                                                                <td><?php echo "<strong>" . $_SESSION["simbolo"] . "</strong>" . number_format($reg[$i]['precioventablister'], 2, '.', ','); ?>
                                                                                </td>
                                                                                <td><?php echo "<strong>" . $_SESSION["simbolo"] . "</strong>" . number_format($reg[$i]['precioventacaja'], 2, '.', ','); ?>
                                                                                </td>
                                                                                <td><?php echo $reg[$i]['precioventablisterdesc']; ?></td>
                                                                                <td><?php echo $reg[$i]['precioventacajadesc']; ?></td>
                                                                                <td><?php echo $reg[$i]['precioventaunidaddesc']; ?></td>
                                                                                <td><?php echo $reg[$i]['stocktotal']; ?></td>
                                                                                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                                                                                            <td>
                                                                                            <?php echo $reg[$i]['razonsocial']; ?></td><?php } ?>
                                                                                <td>
                                                                                    <a href="#" class="btn btn-success btn-xs"
                                                                                       onClick="VerProducto2('<?php echo base64_encode($reg[$i]['codproducto']) ?>','<?php echo base64_encode($reg[$i]['codsucursal']) ?>')"
                                                                                       data-href="#" data-toggle="modal"
                                                                                       data-target=".bs-example-modal-lgg"
                                                                                       data-placement="left" data-backdrop="static"
                                                                                       data-keyboard="false" data-id="" rel="tooltip"
                                                                                       data-original-title="Ver Producto"
                                                                                       title="Ver Producto"><i
                                                                                                class="fa fa-search-plus"></i></a>


                                                                                    <a class="btn btn-primary btn-xs" title="Editar"
                                                                                       data-toggle="modal" data-target="#update-product-modal"
                                                                                       data-backdrop="static" data-keyboard="false"
                                                                                       onClick="CargaProductos('<?php echo $reg[$i]["codalmacen"]; ?>','<?php echo $reg[$i]["codproducto"]; ?>','<?php echo $reg[$i]["producto"]; ?>','<?php echo $reg[$i]["principioactivo"]; ?>','<?php echo $reg[$i]["descripcion"]; ?>','<?php echo $reg[$i]["codpresentacion"]; ?>','<?php echo $reg[$i]["codmedida"]; ?>','<?php echo $reg[$i]["preciocompra"]; ?>','<?php echo $reg[$i]["precioventacaja"]; ?>','<?php echo $reg[$i]["precioventaunidad"]; ?>','<?php echo $reg[$i]["stockcajas"]; ?>','<?php echo $reg[$i]["unidades"]; ?>','<?php echo $reg[$i]["stockunidad"]; ?>','<?php echo $reg[$i]["stocktotal"]; ?>','<?php echo $reg[$i]["stockminimo"]; ?>','<?php echo $reg[$i]["ivaproducto"]; ?>','<?php echo $reg[$i]["descproducto"]; ?>','<?php echo date("d-m-Y", strtotime($reg[$i]["fechaelaboracion"])); ?>','<?php echo date("d-m-Y", strtotime($reg[$i]["fechaexpiracion"])); ?>','<?php echo $reg[$i]["codigobarra"]; ?>','<?php echo $reg[$i]["codlaboratorio"]; ?>','<?php echo $reg[$i]["codproveedor"]; ?>','<?php echo $reg[$i]["codsucursal"]; ?>','<?php echo $reg[$i]["loteproducto"]; ?>','<?php echo $reg[$i]["ubicacion"]; ?>','<?php echo $reg[$i]["statusp"]; ?>','','<?php echo $reg[$i]["precioventablister"]; ?>','<?php echo $reg[$i]["blisterunidad"]; ?>','<?php echo $reg[$i]["stockblister"]; ?>','<?php echo $reg[$i]["preciocompraunidad"]; ?>','<?php echo $reg[$i]["preciocomprablister"]; ?>', '<?php echo $reg[$i]["registrosanitario"]; ?>', '<?php echo $reg[$i]["blistercaja"]; ?>', '<?php echo $reg[$i]["precioventablisterdesc"]; ?>', '<?php echo $reg[$i]["precioventacajadesc"]; ?>', '<?php echo $reg[$i]["precioventaunidaddesc"]; ?>', true)"><i
                                                                                                class="fa fa-pencil"></i></a>


                                                                                    <a class="btn btn-danger btn-xs" title="Eliminar"
                                                                                       onClick="EliminarProducto('<?php echo base64_encode($reg[$i]["codproducto"]); ?>','<?php echo base64_encode($reg[$i]["codsucursal"]); ?>','<?php echo base64_encode("PRODUCTOS") ?>')"><i
                                                                                                class="fa fa-trash-o"></i></a>

                                                                                                <a class="btn btn-danger btn-xs" title="Deshabilitar"
                                                                                       onClick="deshabilitarProducto('<?php echo base64_encode($reg[$i]["codproducto"]); ?>','<?php echo base64_encode($reg[$i]["codsucursal"]); ?>','<?php echo base64_encode("PRODUCTOS") ?>')"><i
                                                                                                class="fa fa-eye-slash"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                <?php }
                } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <footer class="footer"><i class="fa fa-copyright"></i> <span class="current-year"></span>.</footer>
                            </div>
                        </div>

                        <script>
                            var resizefunc = [];
                        </script>

                        <!-- jQuery  -->
                        <script src="assets/js/jquery.min.js"></script>
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

            <script type="text/javascript">
                //calculostock
                //FUNCION PARA CALCULAR PRECIO VENTA UNIDAD
                $(document).ready(function () {
                    $('.calculostock').keyup(function () {

                        var stockcajas = $('input#stockcajas').val();
                        var unidades = $('input#unidades').val();
                        var stockunidad = $('input#stockunidad').val();

                        //REALIZO EL CALCULO
                        var calculo = parseFloat(stockcajas) * parseFloat(unidades);
                        total = parseFloat(calculo) + parseFloat(stockunidad);
                        $("#stocktotal").val((unidades == "0") ? "0" : total);
                    });
                    $('#datatable').DataTable();
                    $('#datatable-keytable').DataTable({keys: true});
                    $('#datatable-responsive').DataTable();
                    $('#datatable-scroller').DataTable({
                        ajax: "assets/plugins/datatables/json/scroller-demo.json",
                        deferRender: true,
                        scrollY: 380,
                        scrollCollapse: true,
                        scroller: true
                    });
                    var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});


                });
                TableManageButtons.init();
            </script>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable({
            "scrollX": true
        });
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({
            ajax: "assets/plugins/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
    });
    TableManageButtons.init();
</script>