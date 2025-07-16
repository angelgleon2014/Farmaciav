<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        $con = new Login();
        $con = $con->ConfiguracionPorId();
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        $tipo = base64_decode($_GET['tipo']);
        switch($tipo) {

            case 'SUCURSALES':

                $hoy = "LISTADO_GENERAL_SUCURSALES";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>RUC/DNI DE RESPONSABLE</th>
           <th>NOMBRE DE RESPONSABLE</th>
           <th>Nº DE CELULAR</th>
           <th>RUC DE SUCURSAL</th>
           <th>RAZÓN SOCIAL</th>
           <th>Nº DE TELEFONO</th>
           <th>Nº DE CELULAR</th>
           <th>EMAIL DE SUCURSAL</th>
           <th>DIRECCIÓN DE SUCURSAL</th>
           <th>Nº DE ACTIVIDAD</th>
           <th>SECUENCIA INICIO FACTURA</th>
           <th>FECHA AUTORIZACIÓN</th>
           <th>IGV % COMPRAS</th>
           <th>IGV % VENTAS</th>
           <th>DESCUENTO %</th>
           <th>CONTABILIDAD</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarSucursal();

                if($reg == "") {
                    echo "";
                } else {

                    $a = 1;
                    for($i = 0;$i < sizeof($reg);$i++) {
                        ?>
         <tr align="center" class="even_row">
           <td><?php echo $reg[$i]['nrosucursal']; ?></td>
           <td><?php echo $reg[$i]['cedresponsable']; ?></td>
           <td><?php echo $reg[$i]['nomresponsable']; ?></td>
           <td><?php echo $reg[$i]['celresponsable']; ?></td>
           <td><?php echo $reg[$i]['rucsucursal']; ?></td>
           <td><?php echo $reg[$i]['razonsocial']; ?></td>
           <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
           <td><?php echo $reg[$i]['celsucursal']; ?></td>
           <td><?php echo $reg[$i]['emailsucursal']; ?></td>
           <td><?php echo $reg[$i]['direcsucursal']; ?></td>
           <td><?php echo $reg[$i]['nroactividadsucursal']; ?></td>
           <td><?php echo $reg[$i]['nroiniciofactura']; ?></td>
           <td><?php echo $reg[$i]['fechaautorsucursal']; ?></td>
           <td><?php echo $reg[$i]['ivacsucursal']; ?></td>
           <td><?php echo $reg[$i]['ivavsucursal']; ?></td>
           <td><?php echo $reg[$i]['descsucursal']; ?></td>
           <td><?php echo $reg[$i]['llevacontabilidad']; ?></td>
         </tr>
        <?php }
                    } ?>
</table>
<?php
                    break;

            case 'TIPOSTARJETAS':

                $hoy = "LISTADO_GENERAL_TARJETAS";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE ENTIDAD BANCARIA</th>
           <th>NOMBRE DE TARJETA</th>
           <th>TIPO DE TARJETA</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarTarjetas();

                if($reg == "") {
                    echo "";
                } else {

                    $a = 1;
                    for($i = 0;$i < sizeof($reg);$i++) {
                        ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nombanco']; ?></td>
           <td><?php echo $reg[$i]['nomtarjeta']; ?></td>
           <td><?php echo $reg[$i]['tipotarjeta']; ?></td>
         </tr>
        <?php }
                    } ?>
</table>
<?php
                    break;

            case 'INTERESESTARJETAS':

                $hoy = "LISTADO_GENERAL_INTERESES_TARJETAS";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE ENTIDAD BANCARIA</th>
           <th>NOMBRE DE TARJETA</th>
           <th>MESES</th>
           <th>DIFERIDO SI %</th>
           <th>DIFERIDO NO %</th>
           <th>TIPO DE TARJETA</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarIntereses();

                if($reg == "") {
                    echo "";
                } else {

                    $a = 1;
                    for($i = 0;$i < sizeof($reg);$i++) {
                        ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nombanco']; ?></td>
           <td><?php echo $reg[$i]['nomtarjeta']; ?></td>
           <td><?php echo $reg[$i]['meses']; ?></td>
           <td><?php echo $reg[$i]['tasasi']; ?></td>
           <td><?php echo $reg[$i]['tasano']; ?></td>
           <td><?php echo $reg[$i]['tipotarjeta']; ?></td>
         </tr>
        <?php }
                    } ?>
</table>
<?php
                    break;

            case 'USUARIOS':

                $hoy = "LISTADO_GENERAL_USUARIOS";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>RUC/DNI</th>
           <th>NOMBRES Y APELLIDOS</th>
           <th>GENERO</th>
           <th>FECHA NACIMIENTO</th>
           <th>LUGAR NACIMIENTO</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>Nº DE TELÉFONO</th>
           <th>CARGO</th>
           <th>EMAIL</th>
           <th>USUARIO</th>
           <th>NIVEL</th>
           <th>STATUS</th>
           <th>SUCURSAL</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarUsuarios();

                if($reg == "") {
                    echo "";
                } else {

                    $a = 1;
                    for($i = 0;$i < sizeof($reg);$i++) {
                        ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['cedula']; ?></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['genero']; ?></td>
           <td><?php echo $reg[$i]['fnac']; ?></td>
           <td><?php echo $reg[$i]['lugnac']; ?></td>
           <td><?php echo $reg[$i]['direcdomic']; ?></td>
           <td><?php echo $reg[$i]['nrotelefono']; ?></td>
           <td><?php echo $reg[$i]['cargo']; ?></td>
           <td><?php echo $reg[$i]['email']; ?></td>
           <td><?php echo $reg[$i]['usuario']; ?></td>
           <td><?php echo $reg[$i]['nivel']; ?></td>
           <td><?php echo $reg[$i]['status']; ?></td>
           <td><?php echo $sucursal = ($reg[$i]['codsucursal'] == '' ? "ACCESO GENERAL" : $reg[$i]['razonsocial']); ?></td>
         </tr>
        <?php }
                    } ?>
</table>
<?php
                    break;

            case 'LOGS':

                $hoy = "LISTADO_GENERAL_LOGS";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>IP</th>
           <th>TIEMPO DE ENTRADA</th>
           <th>DETALLES DE ACCESO</th>
           <th>USUARIOS</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarLogs();

                if($reg == "") {
                    echo "";
                } else {

                    $a = 1;
                    for($i = 0;$i < sizeof($reg);$i++) {
                        ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['ip']; ?></td>
           <td><?php echo $reg[$i]['tiempo']; ?></td>
           <td><?php echo $reg[$i]['detalles']; ?></td>
           <td><?php echo $reg[$i]['usuario']; ?></td>
         </tr>
        <?php }
                    } ?>
</table>
<?php
                    break;

            case 'CAJAS':

                $hoy = "LISTADO_CAJAS_VENTAS";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <?php echo $var = ($_SESSION['acceso'] == "administradorG" ? "<th>SUCURSALES</th>" : ""); ?>
           <th>N° CAJA</th>
           <th>NOMBRE DE CAJA</th>
           <th>CÉDULA CAJERO</th>
           <th>NOMBRE CAJERO</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarCajas();

                if($reg == "") {
                    echo "";
                } else {

                    for($i = 0;$i < sizeof($reg);$i++) {
                        ?>
         <tr align="center" class="even_row">
           <td><?php echo $reg[$i]['codcaja']; ?></td>
<?php echo $var = ($_SESSION['acceso'] == "administradorG" ? "<td>".$reg[$i]['razonsocial']."</td>" : ""); ?>
           <td><?php echo $reg[$i]['nrocaja']; ?></td>
           <td><?php echo $reg[$i]['nombrecaja']; ?></td>
           <td><?php echo $reg[$i]['cedula']; ?></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
         </tr>
        <?php }
                    } ?>
</table>

<?php
                    break;

            case 'LABORATORIOS':

                $hoy = "LISTADO_LABORATORIOS";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>NOMBRE DE LABORATORIO</th>
           <th>APLICA DESCUENTO</th>
           <th>% DESCUENTO</th>
           <th>RECARGA TDC</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarLaboratorios();
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $reg[$i]['codlaboratorio']; ?></td>
           <td><?php echo $reg[$i]['nomlaboratorio']; ?></td>
           <td><?php echo $reg[$i]['aplicadescuento']; ?></td>
           <td><?php echo $reg[$i]['desclaboratorio']; ?></td>
           <td><?php echo $reg[$i]['recargotc']; ?></td>
         </tr>
        <?php } ?>
</table>

<?php
                    break;

            case 'PROVEEDORES':

                $hoy = "LISTADO_PROVEEDORES";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>RUC/DNI PROVEEDOR</th>
           <th>NOMBRE PROVEEDOR</th>
           <th>DIRECCIÓN</th>
           <th>N° DE TELEFONO</th>
           <th>N° DE CELULAR</th>
           <th>EMAIL</th>
           <th>VENDEDOR</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarProveedores();
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $reg[$i]['codproveedor']; ?></td>
           <td><?php echo $reg[$i]['rucproveedor']; ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['direcproveedor']; ?></td>
           <td><?php echo $reg[$i]['tlfproveedor']; ?></td>
           <td><?php echo $reg[$i]['celproveedor']; ?></td>
           <td><?php echo $reg[$i]['emailproveedor']; ?></td>
           <td><?php echo $reg[$i]['contactoproveedor']; ?></td>
         </tr>
        <?php } ?>
</table>

<?php
                    break;

            case 'CLIENTES':

                $hoy = "LISTADO_CLIENTES";
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>CÓDIGO</th>
           <th>RUC/DNI</th>
           <th>NOMBRES</th>
           <th>DIRECCIÓN</th>
           <th>N° DE TELEFONO</th>
           <th>N° DE CELULAR</th>
           <th>EMAIL</th>
         </tr>
      <?php
                $tra = new Login();
                $reg = $tra->ListarClientes();
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $reg[$i]['codcliente']; ?></td>
           <td><?php echo $reg[$i]['nrocliente']; ?></td>
           <td><?php echo $reg[$i]['cedcliente']; ?></td>
           <td><?php echo $reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['direccliente']; ?></td>
           <td><?php echo $reg[$i]['tlfcliente']; ?></td>
           <td><?php echo $reg[$i]['celcliente']; ?></td>
           <td><?php echo $reg[$i]['emailcliente']; ?></td>
         </tr>
        <?php } ?>
</table>

<?php
                    break;

            case 'PRODUCTOSEXCEL':

                $tra = new Login();
                $reg = $tra->ListarProductos();

                $hoy = "LISTADO_GENERAL_PRODUCTOS_";

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php
                $a = 1;
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['principioactivo']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
           <td><?php echo $reg[$i]['codpresentacion']; ?></td>
           <td><?php echo $reg[$i]['codmedida']; ?></td>
           <td><?php echo $reg[$i]['preciocompra']; ?></td>
           <td><?php echo $reg[$i]['precioventacaja']; ?></td>
           <td><?php echo $reg[$i]['precioventaunidad']; ?></td>
           <td><?php echo $reg[$i]['stockcajas']; ?></td>
           <td><?php echo $reg[$i]['unidades']; ?></td>
           <td><?php echo $reg[$i]['stockunidad']; ?></td>
           <td><?php echo $reg[$i]['stocktotal']; ?></td>
           <td><?php echo $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['ivaproducto']; ?></td>
           <td><?php echo $reg[$i]['descproducto']; ?></td>
           <td><?php echo $reg[$i]['fechaelaboracion']; ?></td>
           <td><?php echo $reg[$i]['fechaexpiracion']; ?></td>
           <td><?php echo $reg[$i]['codigobarra']; ?></td>
           <td><?php echo $reg[$i]['codlaboratorio']; ?></td>
           <td><?php echo $reg[$i]['codproveedor']; ?></td>
           <td><?php echo $reg[$i]['codsucursal']; ?></td>
           <td><?php echo $reg[$i]['loteproducto']; ?></td>
           <td><?php echo $reg[$i]['ubicacion']; ?></td>
           <td><?php echo $reg[$i]['statusp']; ?></td>
         </tr>
        <?php } ?>
</table>
<?php
                    break;

            case 'PRODUCTOSXSUCURSAL':

                $tra = new Login();
                $reg = $tra->BuscarProductosSucursal();

                $hoy = "LISTADO_PRODUCTOS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>CÓDIGO</th>
           <th>PRODUCTO</th>
           <th>PRINCIPIO ACTIVO</th>
           <th>DESCRIPCIÓN</th>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA (CAJA)</th>
           <th>PRECIO VENTA (UNIDAD)</th>
           <th>UNIDAD X CAJAS</th>
           <th>STOCK x CAJAS</th>
           <th>STOCK x UNIDADES</th>
           <th>STOCK MINIMO</th>
           <th>IGV</th>
           <th>DCTO</th>
           <th>FECHA ELABORACIÓN</th>
           <th>FECHA EXPIRACIÓN</th>
           <th>CÓDIGO BARRA</th>
           <th>LABORATORIO</th>
           <th>LOTE</th>
           <th>UBICACIÓN</th>
         </tr>
      <?php
                $a = 1;
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['principioactivo']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['nommedida']; ?></td>
           <td><?php echo $reg[$i]['preciocompra']; ?></td>
           <td><?php echo $reg[$i]['precioventacaja']; ?></td>
           <td><?php echo $reg[$i]['precioventaunidad']; ?></td>
           <td><?php echo $reg[$i]['unidades']; ?></td>
       <td><?php echo floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])?></td>
       <td><?php echo((($reg[$i]["stocktotal"] / $reg[$i]["unidades"]) - floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])) * $reg[$i]["unidades"])?></td>
           <td><?php echo $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['ivaproducto']; ?></td>
           <td><?php echo $reg[$i]['descproducto']; ?></td>
           <td><?php echo $reg[$i]['fechaelaboracion']; ?></td>
           <td><?php echo $reg[$i]['fechaexpiracion']; ?></td>
           <td><?php echo $reg[$i]['codigobarra']; ?></td>
           <td><?php echo $reg[$i]['nomlaboratorio']; ?></td>
           <td><?php echo $reg[$i]['loteproducto']; ?></td>
           <td><?php echo $reg[$i]['ubicacion']; ?></td>
         </tr>
        <?php } ?>
</table>
<?php
                    break;

            case 'PRODUCTOSXLABORATORIO':

                $tra = new Login();
                $reg = $tra->BuscarProductosLaboratorios();

                $hoy = "LISTADO_PRODUCTOS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"])."_LABORATORIO_".str_replace(" ", "_", $reg[0]["nomlaboratorio"]);

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>CÓDIGO</th>
           <th>PRODUCTO</th>
           <th>PRINCIPIO ACTIVO</th>
           <th>DESCRIPCIÓN</th>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA (CAJA)</th>
           <th>PRECIO VENTA (UNIDAD)</th>
           <th>UNIDAD X CAJAS</th>
           <th>STOCK x CAJAS</th>
           <th>STOCK x UNIDADES</th>
           <th>STOCK MINIMO</th>
           <th>IGV</th>
           <th>DCTO</th>
           <th>FECHA ELABORACIÓN</th>
           <th>FECHA EXPIRACIÓN</th>
           <th>CÓDIGO BARRA</th>
           <th>LOTE</th>
           <th>UBICACIÓN</th>
         </tr>
      <?php
                $a = 1;
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['principioactivo']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['nommedida']; ?></td>
           <td><?php echo $reg[$i]['preciocompra']; ?></td>
           <td><?php echo $reg[$i]['precioventacaja']; ?></td>
           <td><?php echo $reg[$i]['precioventaunidad']; ?></td>
           <td><?php echo $reg[$i]['unidades']; ?></td>
       <td><?php echo floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])?></td>
       <td><?php echo((($reg[$i]["stocktotal"] / $reg[$i]["unidades"]) - floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])) * $reg[$i]["unidades"])?></td>
           <td><?php echo $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['ivaproducto']; ?></td>
           <td><?php echo $reg[$i]['descproducto']; ?></td>
           <td><?php echo $reg[$i]['fechaelaboracion']; ?></td>
           <td><?php echo $reg[$i]['fechaexpiracion']; ?></td>
           <td><?php echo $reg[$i]['codigobarra']; ?></td>
           <td><?php echo $reg[$i]['loteproducto']; ?></td>
           <td><?php echo $reg[$i]['ubicacion']; ?></td>
         </tr>
        <?php } ?>
</table>
<?php
                    break;

            case 'PRODUCTOSSTOCK':

                $tra = new Login();
                $reg = $tra->BuscarProductosStockMinimo();

                $hoy = "PRODUCTOS_STOCK_MINIMO_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>CÓDIGO</th>
           <th>PRODUCTO</th>
           <th>PRINCIPIO ACTIVO</th>
           <th>DESCRIPCIÓN</th>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA (CAJA)</th>
           <th>PRECIO VENTA (UNIDAD)</th>
           <th>UNIDAD X CAJAS</th>
           <th>STOCK TOTAL</th>
           <th>STOCK MINIMO</th>
           <th>IGV</th>
           <th>DCTO</th>
           <th>FECHA ELABORACIÓN</th>
           <th>FECHA EXPIRACIÓN</th>
           <th>CÓDIGO BARRA</th>
           <th>LABORATORIO</th>
           <th>LOTE</th>
           <th>UBICACIÓN</th>
         </tr>
      <?php
                $a = 1;
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['principioactivo']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['nommedida']; ?></td>
           <td><?php echo $reg[$i]['preciocompra']; ?></td>
           <td><?php echo $reg[$i]['precioventacaja']; ?></td>
           <td><?php echo $reg[$i]['precioventaunidad']; ?></td>
           <td><?php echo $reg[$i]['unidades']; ?></td>
           <td><?php echo $reg[$i]['stocktotal']; ?></td>
           <td><?php echo $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['ivaproducto']; ?></td>
           <td><?php echo $reg[$i]['descproducto']; ?></td>
           <td><?php echo $reg[$i]['fechaelaboracion']; ?></td>
           <td><?php echo $reg[$i]['fechaexpiracion']; ?></td>
           <td><?php echo $reg[$i]['codigobarra']; ?></td>
           <td><?php echo $reg[$i]['nomlaboratorio']; ?></td>
           <td><?php echo $reg[$i]['loteproducto']; ?></td>
           <td><?php echo $reg[$i]['ubicacion']; ?></td>
         </tr>
        <?php } ?>
</table>
<?php
                    break;

            case 'PRODUCTOSVENDIDOS':

                $ve = new Login();
                $reg = $ve->BuscarVentasProductos();

                $hoy = "PRODUCTOS_VENDIDOS_".$_GET["desde"]."_HASTA_".$_GET["hasta"]."_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>PRESENTACIÓN</th>
           <th>LABORATORIO</th>
           <th>PRECIO CAJA</th>
           <th>PRECIO UNIDAD</th>
           <th>DESCUENTO</th>
           <th>VENDIDOL</th>
           <th>VALOR NETO</th>
           <th>STOCK ACTUAL</th>
         </tr>
      <?php
                $a = 1;
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]["producto"]." ".$reg[$i]["nommedida"]; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['nomlaboratorio']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["precioventacajav"], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["precioventaunidadv"], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["descproductov"], 2, '.', ','); ?></td>
           <td><?php echo $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2']); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["valornetov"], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stocktotal']; ?></td>
         </tr>
        <?php } ?>
    </table>

<?php
                    break;


            case 'PRODUCTOSVENCIDOS':

                $ve = new Login();
                $reg = $ve->BuscarProductosVencidos();

                if($_GET['tiempovence'] == '0') {

                    $hoy = "PRODUCTOS_VENCIDOS_DE_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                } else {

                    if($_GET['tiempovence'] == '5') {

                        $hoy = "PRODUCTOS_POR_VENCER_5_DIAS_DE_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                    } elseif($_GET['tiempovence'] == '15') {

                        $hoy = "PRODUCTOS_POR_VENCER_15_DIAS_DE_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                    } elseif($_GET['tiempovence'] == '30') {

                        $hoy = "PRODUCTOS_POR_VENCER_1_MES_DE_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                    } elseif($_GET['tiempovence'] == '60') {

                        $hoy = "PRODUCTOS_POR_VENCER_2_MESES_DE_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                    } elseif($_GET['tiempovence'] == '90') {

                        $hoy = "PRODUCTOS_POR_VENCER_3_MESES_DE_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                    }

                }

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>PRESENTACIÓN</th>
           <th>LABORATORIO</th>
           <th>PRECIO CAJA</th>
           <th>PRECIO UNIDAD</th>
           <th>STOCK TOTAL</th>
           <th>FECHA EXPIRACIÓN</th>
           <th>UBICACIÓN</th>
         </tr>
      <?php
                $a = 1;
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]["producto"]." ".$reg[$i]["nommedida"]; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['nomlaboratorio']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["precioventacaja"], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["precioventaunidad"], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stocktotal']; ?></td>
           <td><?php echo $reg[$i]['fechaexpiracion']; ?></td>
           <td><?php echo $reg[$i]['ubicacion']; ?></td>
         </tr>
        <?php } ?>
    </table>

<?php
                    break;

            case 'KARDEXPRODUCTOS':

                $kardex = new Login();
                $kardex = $kardex->BuscarKardexProducto();

                $hoy = "KARDEX_PRODUCTO_".str_replace(" ", "_", $kardex[0]["producto"]." ".$kardex[0]["principioactivo"])."_DE_SUCURSAL_".str_replace(" ", "_", $kardex[0]["razonsocial"]);

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>MOVIMIENTOS</th>
           <th>ENTRADAS</th>
           <th>SALIDAS</th>
           <th>DEVOLUCIÓN</th>
           <th>PVP CAJA</th>
           <th>PVP UNIDAD</th>
           <th>COSTO UNIDAD</th>
           <th>STOCK ACTUAL</th>
           <th>DOCUMENTO</th>
           <th>FECHA KARDEX</th>
         </tr>
<?php
                $TotalEntradas = 0;
                $TotalSalidas = 0;
                $TotalDevolucion = 0;
                $a = 1;
                for($i = 0;$i < sizeof($kardex);$i++) {
                    $TotalEntradas += $entradas = ($kardex[$i]['entradabonif'] == '0' ? $kardex[$i]['entradacaja'] : $kardex[$i]['entradacaja']."+".$kardex[$i]['entradabonif']);
                    $TotalSalidas += $salidas = ($kardex[$i]['salidabonif'] == '0' ? $kardex[$i]['salidaunidad'] : $kardex[$i]['salidaunidad']."+".$kardex[$i]['salidabonif']);
                    $TotalDevolucion += $devolucion = ($kardex[$i]['devolucionbonif'] == '0' ? $kardex[$i]['devolucionunidad'] : $kardex[$i]['devolucionunidad']."+".$kardex[$i]['devolucionbonif']);
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $kardex[$i]['movimiento']; ?></td>
      
<td><?php echo $entradas = ($kardex[$i]['entradabonif'] == '0' ? $kardex[$i]['entradacaja'] : $kardex[$i]['entradacaja']."+".$kardex[$i]['entradabonif']); ?></td>

<td><?php echo $salidas = ($kardex[$i]['salidabonif'] == '0' ? $kardex[$i]['salidaunidad'] : $kardex[$i]['salidaunidad']."+".$kardex[$i]['salidabonif']); ?></td>

<td><?php echo $devolucion = ($kardex[$i]['devolucionbonif'] == '0' ? $kardex[$i]['devolucionunidad'] : $kardex[$i]['devolucionunidad']."+".$kardex[$i]['devolucionbonif']); ?></td>

           <td><?php echo number_format($kardex[$i]['precioventacajam'], 2, '.', ','); ?></td>
           <td><?php echo number_format($kardex[$i]['precioventacajam'], 2, '.', ','); ?></td>

<?php if($kardex[$i]['movimiento'] == "ENTRADAS") { ?>

<td><?php echo $simbolo.number_format($kardex[$i]['precioventaunidadm'] * $entradas, 2, '.', ','); ?></td>

<?php } elseif($kardex[$i]['movimiento'] == "SALIDAS") { ?>

<td><?php echo $simbolo.number_format($kardex[$i]['precioventaunidadm'] * $salidas, 2, '.', ','); ?></td>

<?php } elseif($kardex[$i]['movimiento'] == "DEVOLUCION") { ?>

<td><?php echo $simbolo.number_format($kardex[$i]['precioventaunidadm'] * $devolucion, 2, '.', ','); ?></td>

<?php } ?>
          
           <td><?php echo $kardex[$i]['stocktotalunidad']; ?></td>
           <td><?php echo $kardex[$i]['documento']; ?></td>
           <td><?php echo date("d-m-Y", strtotime($kardex[$i]['fechakardex'])); ?></td>
         </tr>
        <?php } ?>
    </table>

<?php
                    break;

            case 'TRASPASO':

                $tra = new Login();
                $reg = $tra->BuscarTraspasosFechas();

                $hoy = "TRASPASO_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"]."_SUCURSAL_ENVIA_".str_replace(" ", "_", $reg[0]["enviado"])."_SUCURSAL_RECIBE_".str_replace(" ", "_", $reg[0]["recibido"]);
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>PRESENTACIÓN</th>
           <th>PRECIO CAJA</th>
           <th>PRECIO UNIDAD</th>
           <th>CANT. ENVIO</th>
           <th>FECHA TRASPASO</th>
         </tr>
      <?php
                $a = 1;
                for($i = 0;$i < sizeof($reg);$i++) {
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproductot']; ?></td>
           <td><?php echo $reg[$i]["producto"]." ".$reg[$i]["nommedida"]; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["preciocajat"], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["preciounidadt"], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]["cantenvio"]; ?></td>
           <td><?php echo date("d-m-Y h:i:s", strtotime($reg[$i]['fechatraspaso'])); ?></td>
         </tr>
        <?php } ?>
    </table>

<?php
                    break;

            case 'COMPRASXPROVEEDOR':

                $tra = new Login();
                $reg = $tra->BuscarComprasProveedor();

                $hoy = "COMPRAS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"])."_PROVEEDOR_".str_replace(" ", "_", $reg[0]["nomproveedor"]);
                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>Nº FACTURA</th>
           <th>FECHA RECEPCIÓN</th>
           <th>FECHA EMISIÓN</th>
           <th>STATUS</th>
           <th>VENCIDOS</th>
           <th>ARTICULOS</th>
           <th>DCTO</th>
           <th>DCTO BONIF</th>
           <th>SUBTOTAL</th>
           <th>TARIFA 0%</th>
           <th>TARIFA CON %</th>
           <th>TOTAL IGV</th>
           <th>TOTAL PAGO</th>
         </tr>
      <?php
                $a = 1;
                $TotalArticulos = 0;
                $TotalDescuento = 0;
                $TotalBonificiacion = 0;
                $TotalSubtotal = 0;
                $TotalTarifano = 0;
                $TotalTarifasi = 0;
                $Totaliva = 0;
                $TotalPago = 0;

                for($i = 0;$i < sizeof($reg);$i++) {

                    $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
                    $TotalDescuento += $reg[$i]['descuentoc'];
                    $TotalBonificiacion += $reg[$i]['descbonific'];
                    $TotalSubtotal += $reg[$i]['subtotalc'];
                    $TotalTarifano += $reg[$i]['tarifano'];
                    $TotalTarifasi += $reg[$i]['tarifasi'];
                    $Totaliva += $reg[$i]['totalivac'];
                    $TotalPago += $reg[$i]['totalc'];
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['fecharecepcion']; ?></td>
           <td><?php echo $reg[$i]['fechaemision']; ?></td>
<td><?php if($reg[$i]['fechavencecredito'] == null) {
    echo $reg[$i]["statuscompra"];
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo $reg[$i]["statuscompra"];
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo "VENCIDA";
} ?></td>

<td><?php if($reg[$i]['fechavencecredito'] == null) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito']);
} ?></td>

           <td><?php echo $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2']); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['descuentoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['descbonific'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['tarifano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['tarifasi'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center" class="even_row">
           <td colspan="5">&nbsp;</td>
           <td><strong>Total General</strong></div></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalBonificiacion, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifano, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifasi, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($Totaliva, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalPago, 2, '.', ','); ?></strong></td>
         </tr>
</table>

<?php
break;

            case 'COMPRASXFECHAS':

                $tra = new Login();
                $reg = $tra->BuscarComprasFechas();

                $hoy = "COMPRAS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"])."_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"];

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>Nº FACTURA</th>
           <th>PROVEEDOR</th>
           <th>FECHA RECEPCIÓN</th>
           <th>STATUS</th>
           <th>VENCIDOS</th>
           <th>ARTICULOS</th>
           <th>DCTO</th>
           <th>DCTO BONIF</th>
           <th>SUBTOTAL</th>
           <th>TARIFA 0%</th>
           <th>TARIFA CON %</th>
           <th>TOTAL IGV</th>
           <th>TOTAL PAGO</th>
         </tr>
      <?php
                $a = 1;
                $TotalArticulos = 0;
                $TotalDescuento = 0;
                $TotalBonificiacion = 0;
                $TotalSubtotal = 0;
                $TotalTarifano = 0;
                $TotalTarifasi = 0;
                $Totaliva = 0;
                $TotalPago = 0;

                for($i = 0;$i < sizeof($reg);$i++) {

                    $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
                    $TotalDescuento += $reg[$i]['descuentoc'];
                    $TotalBonificiacion += $reg[$i]['descbonific'];
                    $TotalSubtotal += $reg[$i]['subtotalc'];
                    $TotalTarifano += $reg[$i]['tarifano'];
                    $TotalTarifasi += $reg[$i]['tarifasi'];
                    $Totaliva += $reg[$i]['totalivac'];
                    $TotalPago += $reg[$i]['totalc'];
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['fecharecepcion']; ?></td>
<td><?php if($reg[$i]['fechavencecredito'] == null) {
    echo $reg[$i]["statuscompra"];
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo $reg[$i]["statuscompra"];
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo "VENCIDA";
} ?></td>

<td><?php if($reg[$i]['fechavencecredito'] == null) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito']);
} ?></td>

           <td><?php echo $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2']); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['descuentoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['descbonific'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['tarifano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['tarifasi'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center" class="even_row">
           <td colspan="5">&nbsp;</td>
           <td><strong>Total General</strong></div></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalBonificiacion, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifano, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifasi, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($Totaliva, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalPago, 2, '.', ','); ?></strong></td>
         </tr>
</table>

<?php
break;

            case 'COMPRASXPAGAR':

                $tra = new Login();
                $reg = $tra->BuscarComprasxPagar();

                $hoy = "COMPRAS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"]);

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>Nº FACTURA</th>
           <th>PROVEEDOR</th>
           <th>FECHA RECEPCIÓN</th>
           <th>STATUS</th>
           <th>VENCIDOS</th>
           <th>ARTICULOS</th>
           <th>DCTO</th>
           <th>DCTO BONIF</th>
           <th>SUBTOTAL</th>
           <th>TARIFA 0%</th>
           <th>TARIFA CON %</th>
           <th>TOTAL IGV</th>
           <th>TOTAL PAGO</th>
         </tr>
      <?php
                $a = 1;
                $TotalArticulos = 0;
                $TotalDescuento = 0;
                $TotalBonificiacion = 0;
                $TotalSubtotal = 0;
                $TotalTarifano = 0;
                $TotalTarifasi = 0;
                $Totaliva = 0;
                $TotalPago = 0;

                for($i = 0;$i < sizeof($reg);$i++) {

                    $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
                    $TotalDescuento += $reg[$i]['descuentoc'];
                    $TotalBonificiacion += $reg[$i]['descbonific'];
                    $TotalSubtotal += $reg[$i]['subtotalc'];
                    $TotalTarifano += $reg[$i]['tarifano'];
                    $TotalTarifasi += $reg[$i]['tarifasi'];
                    $Totaliva += $reg[$i]['totalivac'];
                    $TotalPago += $reg[$i]['totalc'];
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['fecharecepcion']; ?></td>
<td><?php if($reg[$i]['fechavencecredito'] == null) {
    echo $reg[$i]["statuscompra"];
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo $reg[$i]["statuscompra"];
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo "VENCIDA";
} ?></td>

<td><?php if($reg[$i]['fechavencecredito'] == null) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito']);
} ?></td>

           <td><?php echo $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2']); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['descuentoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['descbonific'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['tarifano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['tarifasi'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center" class="even_row">
           <td colspan="5">&nbsp;</td>
           <td><strong>Total General</strong></div></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalBonificiacion, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifano, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifasi, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($Totaliva, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalPago, 2, '.', ','); ?></strong></td>
         </tr>
</table>

<?php
break;

            case 'ARQUEOSGENERAL':

                $tra = new Login();
                $reg = $tra->ListarArqueoCaja();

                $hoy = "ARQUEOS_GENERAL_CAJAS";

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>RESPONSABLE</th>
           <th>CAJA</th>
           <th>FECHA DE APERTURA</th>
           <th>FECHA DE CIERRE</th>
           <th>ESTIMADO</th>
           <th>REAL</th>
           <th>DIFERENCIA</th>
         </tr>
      <?php

                if($reg == "") {
                    echo "";
                } else {

                    $a = 1;
                    for($i = 0;$i < sizeof($reg);$i++) {

                        ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></span></td>
           <td><?php echo $reg[$i]['nombres']; ?></span></td>
           <td><?php echo $reg[$i]['nombrecaja']; ?></span></td>
           <td><?php echo $reg[$i]['fechaapertura']; ?></span></td>
           <td><?php echo $reg[$i]['fechacierre']; ?></span></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'] + $reg[$i]['ingresos'] - $reg[$i]['egresos'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["dineroefectivo"], 2, '.', '.'); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["diferencia"], 2, '.', '.'); ?></td>
         </tr>
        <?php }
                    } ?>
    </table>

<?php
                    break;

            case 'MOVIMIENTOSGENERAL':

                $movim = new Login();
                $reg = $movim->ListarMovimientoCajas();

                $hoy = "MOVIMIENTOS_CAJAS";

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>RESPONSABLE</th>
           <th>DESCRIPCIÓN DE MOVIMIENTO</th>
           <th>MEDIO DE MOVIMIENTO</th>
           <th>TIPO</th>
           <th>FECHA MOVIMIENTO</th>
           <th>MONTO</th>
         </tr>
      <?php

                if($reg == "") {
                    echo "";
                } else {

                    $a = 1;
                    $TotalIngresos = 0;
                    $TotalEgresos = 0;
                    for($i = 0;$i < sizeof($reg);$i++) {
                        $TotalIngresos += $ingresos = ($reg[$i]['tipomovimientocaja'] == 'INGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
                        $TotalEgresos += $egresos = ($reg[$i]['tipomovimientocaja'] == 'EGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
                        ?>
         <tr class="even_row">
           <td><?php echo $a++; ?></span></td>
           <td><?php echo $reg[$i]['nrocaja']." : ".$reg[$i]['nombrecaja']; ?></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimientocaja']; ?></td>
           <td><?php echo $reg[$i]['mediopago']; ?></td>
           <td><?php echo $reg[$i]['tipomovimientocaja']; ?></td>
           <td><?php echo $reg[$i]['fechamovimientocaja']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimientocaja'], 2, '.', ','); ?></td>
         </tr>
        <?php }
                    } ?>
         <tr class="even_row">
           <td colspan="6">&nbsp;</td>
           <td><strong>Total Ingresos</strong></div></td>
           <td><strong><?php echo $simbolo.number_format($TotalIngresos, 2, '.', ','); ?></strong></td>
         </tr>
         <tr class="even_row">
           <td colspan="6">&nbsp;</td>
           <td><strong>Total Egresos</strong></div></td>
           <td><strong><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></strong></td>
         </tr>
         <tr class="even_row">
           <td colspan="6">&nbsp;</td>
           <td><strong>Total General</strong></div></td>
           <td><strong><?php echo $simbolo.number_format($TotalIngresos - $TotalEgresos, 2, '.', ','); ?></strong></td>
         </tr>
    </table>

<?php
                    break;

            case 'VENTASXCAJAS':

                $ci = new Login();
                $reg = $ci->BuscarVentasCajas();

                $hoy = "VENTAS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"])."_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"]."_CAJA_N°_".$reg[0]['nrocaja'];

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>SUCURSAL</th>
           <th>Nº FACTURA</th>
           <th>CLIENTES</th>
           <th>STATUS VENTA</th>
           <th>VENC</th>
           <th>FECHA VENTA</th>
           <th>ARTICULOS</th>
           <th>DCTO</th>
           <th>DCTO/BONIF</th>
           <th>SUBTOTAL</th>
           <th>TARIFA 0%</th>
           <th>TARIFA CON %</th>
           <th>TOTAL IGV</th>
           <th>TOTAL PAGO</th>
         </tr>
      <?php
                  $TotalArticulos = 0;
                $TotalDescuento = 0;
                $TotalBonificiacion = 0;
                $TotalSubtotal = 0;
                $TotalTarifano = 0;
                $TotalTarifasi = 0;
                $Totaliva = 0;
                $TotalPago = 0;
                $a = 1;

                for($i = 0;$i < sizeof($reg);$i++) {
                    $tasa = $reg[$i]["totalpago"] * $reg[$i]["intereses"] / 100;

                    $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
                    $TotalDescuento += $reg[$i]['descuentove'];
                    $TotalBonificiacion += $reg[$i]['descbonificve'];
                    $TotalSubtotal += $reg[$i]['subtotalve'];
                    $TotalTarifano += $reg[$i]['subtotalve'];
                    $TotalTarifasi += $reg[$i]['tarifasive'];
                    $Totaliva += $reg[$i]['totalivave'];
                    $TotalPago += $reg[$i]['totalpago'] + $tasa;
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['razonsocial']; ?></td>
           <td><?php echo $reg[$i]['codventa']; ?></td>
<td><?php echo $cliente = ($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']); ?></td>
           <td><?php
if($reg[$i]['fechavencecredito'] == null) {
    echo $reg[$i]["statusventa"];
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo $reg[$i]["statusventa"];
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo "VENCIDA";
} ?></td>

<td><?php if($reg[$i]['fechavencecredito'] == null) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "0";
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito']);
} ?></td>

<td><?php echo $reg[$i]['fechaventa']; ?></td>
<td><?php echo $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2']); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['descuentove'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['descbonificve'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['subtotalve'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['tarifanove'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['tarifasive'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['totalivave'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['totalpago'] + $tasa, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center" class="even_row">
           <td colspan="6">&nbsp;</td>
<td><strong>Total General</strong></div></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalBonificiacion, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifano, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifasi, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($Totaliva, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalPago, 2, '.', ','); ?></strong></td>
         </tr>
    </table>

<?php
break;


            case 'VENTASXFECHAS':

                $ci = new Login();
                $reg = $ci->BuscarVentasFechas();

                $hoy = "VENTAS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"])."_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"];

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>SUCURSAL</th>
           <th>Nº FACTURA</th>
           <th>CLIENTES</th>
           <th>CAJA</th>
           <th>STATUS VENTA</th>
           <th>FECHA VENTA</th>
           <th>ARTICULOS</th>
           <th>DCTO</th>
           <th>DCTO/BONIF</th>
           <th>SUBTOTAL</th>
           <th>TARIFA 0%</th>
           <th>TARIFA CON %</th>
           <th>TOTAL IGV</th>
           <th>TOTAL PAGO</th>
         </tr>
      <?php
                  $TotalArticulos = 0;
                $TotalDescuento = 0;
                $TotalBonificiacion = 0;
                $TotalSubtotal = 0;
                $TotalTarifano = 0;
                $TotalTarifasi = 0;
                $Totaliva = 0;
                $TotalPago = 0;
                $a = 1;

                for($i = 0;$i < sizeof($reg);$i++) {
                    $tasa = $reg[$i]["totalpago"] * $reg[$i]["intereses"] / 100;

                    $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
                    $TotalDescuento += $reg[$i]['descuentove'];
                    $TotalBonificiacion += $reg[$i]['descbonificve'];
                    $TotalSubtotal += $reg[$i]['subtotalve'];
                    $TotalTarifano += $reg[$i]['subtotalve'];
                    $TotalTarifasi += $reg[$i]['tarifasive'];
                    $Totaliva += $reg[$i]['totalivave'];
                    $TotalPago += $reg[$i]['totalpago'] + $tasa;
                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['razonsocial']; ?></td>
           <td><?php echo $reg[$i]['codventa']; ?></td>
<td><?php echo $cliente = ($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']); ?></td>
<td><?php echo $reg[$i]['nombrecaja']; ?></td>
           <td><?php
if($reg[$i]['fechavencecredito'] == null) {
    echo $reg[$i]["statusventa"];
} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo $reg[$i]["statusventa"];
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo "VENCIDA";
} ?></td>

<td><?php echo $reg[$i]['fechaventa']; ?></td>
<td><?php echo $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2']); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['descuentove'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['descbonificve'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['subtotalve'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['tarifanove'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['tarifasive'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['totalivave'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['totalpago'] + $tasa, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center" class="even_row">
           <td colspan="6">&nbsp;</td>
<td><strong>Total General</strong></div></td>
<td><strong><?php echo $TotalArticulos; ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalBonificiacion, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifano, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalTarifasi, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($Totaliva, 2, '.', ','); ?></strong></td>
<td><strong><?php echo $simbolo.number_format($TotalPago, 2, '.', ','); ?></strong></td>
         </tr>
    </table>

<?php
break;

            case 'ARQUEOSFECHAS':

                $tra = new Login();
                $reg = $tra->BuscarArqueosFechas();

                $hoy = "ARQUEOS_CAJAS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"])."_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"];

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>RESPONSABLE</th>
           <th>CAJA</th>
           <th>FECHA DE APERTURA</th>
           <th>FECHA DE CIERRE</th>
           <th>ESTIMADO</th>
           <th>REAL</th>
           <th>DIFERENCIA</th>
         </tr>
      <?php
                $a = 1;

                for($i = 0;$i < sizeof($reg);$i++) {

                    ?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></span></td>
           <td><?php echo $reg[$i]['nombres']; ?></span></td>
           <td><?php echo $reg[$i]['nombrecaja']; ?></span></td>
           <td><?php echo $reg[$i]['fechaapertura']; ?></span></td>
           <td><?php echo $reg[$i]['fechacierre']; ?></span></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'] + $reg[$i]['ingresos'] - $reg[$i]['egresos'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["dineroefectivo"], 2, '.', '.'); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]["diferencia"], 2, '.', '.'); ?></td>
         </tr>
        <?php } ?>
    </table>

<?php
                    break;

            case 'MOVIMIENTOSFECHAS':

                $movim = new Login();
                $reg = $movim->BuscarMovimientosCajasFechas();

                $hoy = "MOVIMIENTOS_SUCURSAL_".str_replace(" ", "_", $reg[0]["razonsocial"])."_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"]."_CAJA_N°_".$reg[0]['nrocaja'];

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>RESPONSABLE</th>
           <th>FECHA DE MOVIMIENTO</th>
           <th>TIPO</th>
           <th>DESCRIPCIÓN DE MOVIMIENTO</th>
           <th>MONTO</th>
         </tr>
      <?php
                $a = 1;
                $TotalIngresos = 0;
                $TotalEgresos = 0;
                for($i = 0;$i < sizeof($reg);$i++) {
                    $TotalIngresos += $ingresos = ($reg[$i]['tipomovimientocaja'] == 'INGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
                    $TotalEgresos += $egresos = ($reg[$i]['tipomovimientocaja'] == 'EGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
                    ?>
         <tr class="even_row">
           <td><?php echo $a++; ?></span></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['fechamovimientocaja']; ?></td>
           <td><?php echo $reg[$i]['tipomovimientocaja']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimientocaja']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimientocaja'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="even_row">
           <td colspan="4">&nbsp;</td>
           <td><strong>Total Ingresos</strong></div></td>
           <td><strong><?php echo $simbolo.number_format($TotalIngresos, 2, '.', ','); ?></strong></td>
         </tr>
         <tr class="even_row">
           <td colspan="4">&nbsp;</td>
           <td><strong>Total Egresos</strong></div></td>
           <td><strong><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></strong></td>
         </tr>
         <tr class="even_row">
           <td colspan="4">&nbsp;</td>
           <td><strong>Total General</strong></div></td>
           <td><strong><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></strong></td>
         </tr>
    </table>

<?php
                    break;


            case 'CREDITOSCLIENTES':

                $bon = new Login();
                $bon = $bon->BuscarClientesAbonos();

                $hoy = "CREDITOS_CLIENTE_".str_replace(" ", "_", $bon[0]["cedcliente"]).":".str_replace(" ", "_", $bon[0]["nomcliente"])."_SUCURSAL_".str_replace(" ", "_", $bon[0]["razonsocial"]);

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
                  <th>N°</th>
                  <th>CÓDIGO DE VENTA</th>
                  <th>N° DE CAJA</th>
                  <th>STATUS DE CRÉDITO</th>
                  <th>DIAS VENDIDOS</th>
                  <th>Nº FACTURA</th>
                  <th>FECHA DE VENTA</th>
                  <th>TOTAL FACTURA</th>
                  <th>TOTAL ABONO</th>
                  <th>TOTAL DEBE</th>
                              </tr>
      <?php
                $a = 1;
                $TotalFactura = 0;
                $TotalCredito = 0;
                $TotalDebe = 0;
                for($i = 0;$i < sizeof($bon);$i++) {
                    $TotalFactura += $bon[$i]['totalpago'];
                    $TotalCredito += $bon[$i]['abonototal'];
                    $TotalDebe += $bon[$i]['totalpago'] - $bon[$i]['abonototal'];
                    ?>
        <tr align="center" class="even_row">
                           <td><?php echo $a++; ?></td>
                           <td><?php echo $bon[$i]['codventa']; ?></td>
                           <td><?php echo $bon[$i]['nrocaja']; ?></td>
                          <td><?php
if($bon[$i]['fechavencecredito'] == null) {
    echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>";
} elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>";
} elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo "<span class='label label-danger'>VENCIDA</span>";
} ?></td>
                          <td><?php
if($bon[$i]['fechavencecredito'] == null) {
    echo "0";
} elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "0";
} elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo Dias_Transcurridos(date("Y-m-d"), $bon[$i]['fechavencecredito']);
} ?></td>
                           <td><?php echo $bon[$i]['codventa']; ?></td>
                           <td><?php echo $bon[$i]['fechaventa']; ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago'], 2, '.', '.'); ?></td>
                           <td><?php echo number_format($bon[$i]['abonototal'], 2, '.', '.'); ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago'] - $bon[$i]['abonototal'], 2, '.', '.'); ?></td>
                              </tr>
        <?php } ?>
         <tr align="center" class="even_row">
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
      <td><strong>Total General</strong></td>
      <td><strong><?php echo number_format($TotalFactura, 2, '.', '.'); ?></strong></td>
      <td><strong><?php echo number_format($TotalCredito, 2, '.', '.'); ?></strong></td>
     <td><strong><?php echo number_format($TotalDebe, 2, '.', '.'); ?></strong></td>
                            </tr>
    </table>

<?php
break;

            case 'CREDITOSFECHAS':

                $bon = new Login();
                $bon = $bon->BuscarCreditosFechas();

                $hoy = "CREDITOS_FECHAS_".$_GET["desde"]."_HASTA_".$_GET["hasta"]."_SUCURSAL_".str_replace(" ", "_", $bon[0]["razonsocial"]);

                header("Content-Type: application/vnd.ms-excel");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("content-disposition: attachment;filename=".$hoy.".xls");

                ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">

        <tr>
                  <th>Nº</th>
                  <th>RUC/DNI DE CLIENTE</th>
                  <th>NOMBRE DE CLIENTE</th>
                  <th>Nº DE CAJA</th>
                  <th>STATUS DE CRÉDITO</th>
                  <th>DIAS VENDIDOS</th>
                  <th>Nº FACTURA</th>
                  <th>FECHA DE VENTA</th>
                  <th>TOTAL FACTURA</th>
                  <th>TOTAL ABONO</th>
                  <th>TOTAL DEBE</th>
                              </tr>
      <?php
                $a = 1;
                $TotalFactura = 0;
                $TotalCredito = 0;
                $TotalDebe = 0;
                for($i = 0;$i < sizeof($bon);$i++) {
                    $TotalFactura += $bon[$i]['totalpago'];
                    $TotalCredito += $bon[$i]['abonototal'];
                    $TotalDebe += $bon[$i]['totalpago'] - $bon[$i]['abonototal'];
                    ?>
        <tr align="center" class="even_row">
                          <td><?php echo $a++; ?></td>
                          <td><?php echo $bon[$i]['cedcliente']; ?></td>
                          <td><?php echo $bon[$i]['nomcliente']; ?></td>
                          <td><?php echo $bon[$i]['nrocaja']; ?></td>
                          <td><?php
if($bon[$i]['fechavencecredito'] == null) {
    echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>";
} elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>";
} elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo "<span class='label label-danger'>VENCIDA</span>";
} ?></td>
                          <td><?php
if($bon[$i]['fechavencecredito'] == null) {
    echo "0";
} elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) {
    echo "0";
} elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) {
    echo Dias_Transcurridos(date("Y-m-d"), $bon[$i]['fechavencecredito']);
} ?></td>
                           <td><?php echo $bon[$i]['codventa']; ?></td>
                           <td><?php echo $bon[$i]['fechaventa']; ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago'] - $bon[$i]['abonototal'], 2, '.', ','); ?></td>
                              </tr>
        <?php } ?>
         <tr align="center" class="even_row">
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td><strong>Total General</strong></td>
                          <td><strong><?php echo number_format($TotalFactura, 2, '.', ','); ?></strong></td>
                          <td><strong><?php echo number_format($TotalCredito, 2, '.', ','); ?></strong></td>
                          <td><strong><?php echo number_format($TotalDebe, 2, '.', ','); ?></strong></td>
                            </tr>
    </table>

<?php
            break;
}

?>

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