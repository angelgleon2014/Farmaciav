<?php
if(isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        switch($_SESSION['acceso']) {
            case 'administradorG':  ?>

<!-- INICIO DE MENU -->
<div id="sidebar-menu">
    <ul>
        <li> <a href="panel" class="waves-effect"><i class="fa fa-home"></i><span> Inicio </span></a></li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-cog"></i> <span> Administración </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="cargamasiva">Cargar Productos</a></li>
                <li><a href="configuracion">Configuración</a></li>
                <li><a href="sucursales">Sucursales</a></li>
                <li><a href="inversion">Inversion</a></li>
                <li><a href="mediospagos">Medios de Pago</a></li>
                <li><a href="bancos">Entidades Bancarias</a></li>
                <li><a href="tarjetas">Tipos de Tarjetas</a></li>
                <li><a href="intereses">Intereses en Tarjetas</a></li>
                <li><a href="medidas">Categorías</a></li>
                <li><a href="presentaciones">Presentaciones</a></li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Seguridad</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="usuarios">Usuarios</a></li>
                        <li><a href="logs">Logs de Acceso</a></li>
                    </ul>
                </li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Base de Datos</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="backup">Respaldar</a></li>
                        <li><a href="restore">Restaurar</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-suitcase"></i> <span> Mantenimiento </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="cajas">Cajas de Ventas</a></li>
                <li><a href="laboratorios">Laboratorios</a></li>
                <li><a href="proveedores">Proveedores</a></li>
                <li><a href="clientes">Clientes</a></li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Productos</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="productos">Productos</a></li>
                        <li><a href="kardexproductos">Kardex Productos</a></li>
                        <li><a href="productos-filtro">Productos Filtro</a></li>
                        <li><a href="buscakardex">Búsqueda Kardex</a></li>
                        <li><a href="productostock">Producto Stock</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-bus"></i> <span>Traspaso Productos </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="traspasos">Consultar Traspasos</a></li>
                <li><a href="buscartraspasos">Búsqueda Traspasos</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-truck"></i> <span> Pedidos </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forpedido">Nuevo Pedido</a></li>
                <li><a href="pedidos"> Consulta de Pedidos</a></li>
                <li><a href="detallespedidos">Detalles de Pedidos</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-shopping-cart"></i> <span> Compras </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forcompra">Nueva Compra</a></li>
                <li><a href="compras"> Consulta de Compras</a></li>
                <li><a href="detallescompras">Detalles de Compras</a></li>
                <li><a href="compraspendientes"> Cuentas por Pagar</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-money"></i> <span> Gastos </span> <span class="pull-right"><i class="ion ion-plus"></i></span>
            </a>
            <ul class="list-unstyled" style="">
                <li><a href="forgasto">Nuevo Gasto</a></li>
                <li><a href="gastos">Consulta de Gastos</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-cart-arrow-down"></i><span> Ventas </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
			    <li><a href="arqueoscajas">Arqueo de Caja</a></li>
                <li><a href="movimientoscajas">Movimiento de Cajas</a></li>
                <li><a href="forventa">Nueva Venta</a></li>
                <li><a href="ventas">Ventas</a></li>
                <li><a href="ventas-filtro">Ventas Listado</a></li>
                <li><a href="detallesventas">Detalles de Ventas</a></li>
                <li><a href="detalleventas-filtro">Detalles de Ventas Listado</a></li>

            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-credit-card"></i><span> Cr&eacute;ditos de Clientes </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
			    <li><a href="forcartera">Nuevo Pago</a></li>
                <li><a href="carteracreditos">Consulta de Pagos</a></li>
                <li><a href="creditocliente">Créditos por Clientes</a></li>
                <li><a href="creditofecha">Créditos por Fechas</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-folder-open"></i> <span> Reportes </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li class="has_sub"><a href="javascript:void(0);"><span>Productos</span><i
                            class="pull-right fa fa-angle-double-right"></a></i>
                    <ul style="">
                        <li><a href="buscaproductossucursal">Por Sucursales</a></li>
                        <li><a href="buscaproductoslaboratorios">Por Laboratorios</a></li>
                        <li><a href="buscastockminimo">Stock Minimo</a></li>
                        <li><a href="productosvendidos">Vendidos</a></li>
                        <li><a href="productosvencidos">Vencidos</a></li>
                    </ul>
                </li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Compras</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="comprasxproveedor">Por Proveedores</a></li>
                        <li><a href="comprasxfechas">Por Fechas</a></li>
                        <li><a href="comprasxpagar">Cuentas por Pagar</a></li>
                    </ul>
                </li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="ventascajas">Ventas por Cajas</a></li>
                        <li><a href="ventasfechas">Ventas por Fechas</a></li>
                    </ul>
                </li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Cajas de Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="arqueosfechas">Arqueo de Cajas</a></li>
                        <li><a href="movimientosfechas">Movim. de Cajas</a></li>
                    </ul>
                </li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Cr&eacute;ditos de Clientes</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="creditocliente">Créditos por Clientes</a></li>
                        <li><a href="creditofecha">Créditos por Fechas</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li> <a href="logout" class="waves-effect"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>

    </ul>
</div>
<!-- FIN DE MENU -->

<?php
         break;
            case 'administradorS': ?>


<!-- INICIO DE MENU -->
<div id="sidebar-menu">
    <ul>
        <li> <a href="panel" class="waves-effect"><i class="fa fa-home"></i><span> Inicio </span></a></li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-cog"></i> <span> Administración </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
			    <li><a href="cargamasiva">Cargar Productos</a></li>
                <li><a href="configuracion">Configuración</a></li>
                <li><a href="sucursales">Sucursales</a></li>
                <li><a href="inversion">Inversion</a></li>
                <li><a href="mediospagos">Medios de Pago</a></li>
                <li><a href="bancos">Entidades Bancarias</a></li>
                <li><a href="tarjetas">Tipos de Tarjetas</a></li>
                <li><a href="intereses">Intereses en Tarjetas</a></li>
                <li><a href="medidas">Categorías</a></li>
                <li><a href="presentaciones">Presentaciones</a></li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Seguridad</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="usuarios">Usuarios</a></li>
                        <li><a href="logs">Logs de Acceso</a></li>
                    </ul>
                </li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Base de Datos</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="backup">Respaldar</a></li>
                        <li><a href="restore">Restaurar</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-suitcase"></i> <span> Mantenimiento </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="cajas">Cajas de Ventas</a></li>
                <li><a href="laboratorios">Laboratorios</a></li>
                <li><a href="proveedores">Proveedores</a></li>
                <li><a href="clientes">Clientes</a></li>
                <li><a href="transporte">Transporte de Guías</a></li>
                <li class="has_sub"><a href="javascript:void(0);"><span>Productos</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="productos">Productos</a></li>
                        <li><a href="productos-filtro">Productos Filtro</a></li>
                        <li><a href="kardexproductos">Kardex Productos</a></li>
                        <li><a href="buscakardex">Búsqueda Kardex</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-bus"></i> <span>Traspaso Productos </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="fortraspaso">Nuevo Traspaso</a></li>
                <li><a href="traspasos">Consultar Traspasos</a></li>
                <li><a href="buscartraspasos">Búsqueda Traspasos</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-truck"></i> <span> Pedidos </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forpedido">Nuevo Pedido</a></li>
                <li><a href="pedidos"> Consulta de Pedidos</a></li>
                <li><a href="detallespedidos">Detalles de Pedidos</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-shopping-cart"></i> <span> Compras </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forcompra">Nueva Compra</a></li>
                <li><a href="compras"> Consulta de Compras</a></li>
                <li><a href="detallescompras">Detalles de Compras</a></li>
                <li><a href="compraspendientes"> Cuentas por Pagar</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-money"></i> <span> Gastos </span> <span class="pull-right"><i class="ion ion-plus"></i></span>
            </a>
            <ul class="list-unstyled" style="">
                <li><a href="forgasto">Nuevo Gasto</a></li>
                <li><a href="gastos">Consulta de Gastos</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-cart-arrow-down"></i><span> Ventas </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="arqueoscajas">Arqueo de Caja</a></li>
                <li><a href="movimientoscajas">Movimiento de Cajas</a></li>
                <li><a href="forventa">Nueva Venta</a></li>
                <li><a href="ventas">Ventas</a></li>
                <li><a href="ventas-filtro">Ventas Listado</a></li>
                <li><a href="detalleventas-filtro">Detalles de Ventas Listado</a></li>
                <li><a href="detallesventas">Detalles de Ventas</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-credit-card"></i><span> Cr&eacute;ditos de Clientes </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forcartera">Nuevo Pago</a></li>
                <li><a href="carteracreditos">Consulta de Pagos</a></li>
                <li><a href="creditocliente">Créditos por Clientes</a></li>
                <li><a href="creditofecha">Créditos por Fechas</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-folder-open"></i> <span> Reportes </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li class="has_sub"><a href="javascript:void(0);"><span>Productos</span><i
                            class="pull-right fa fa-angle-double-right"></a></i>
                    <ul style="">
                        <li><a href="buscaproductoslaboratorios">Por Laboratorios</a></li>
                        <li><a href="productosvendidos">Vendidos</a></li>
                        <li><a href="productosvencidos">Vencidos</a></li>
                        <li><a href="productosmasvendidos">Top Productos Vendidos</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Compras</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="comprasxproveedor">Por Proveedores</a></li>
                        <li><a href="comprasxfechas">Por Fechas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="ventascajas">Ventas por Cajas</a></li>
                        <li><a href="ventasfechas">Ventas por Fechas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Cajas de Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="arqueosfechas">Arqueo de Cajas</a></li>
                        <li><a href="movimientosfechas">Movim. de Cajas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Cr&eacute;ditos de Clientes</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="creditocliente">Créditos por Clientes</a></li>
                        <li><a href="creditofecha">Créditos por Fechas</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li> <a href="logout" class="waves-effect"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>

    </ul>
</div>
<!-- FIN DE MENU -->


<?php
            break;
            case 'cajero': ?>

<!-- INICIO DE MENU -->
<div id="sidebar-menu">
    <ul>
        <li> <a href="panel" class="waves-effect"><i class="fa fa-home"></i><span> Inicio </span></a></li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-suitcase"></i> <span> Mantenimiento </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="laboratorios">Laboratorios</a></li>
                <li><a href="proveedores">Proveedores</a></li>
                <li><a href="clientes">Clientes</a></li>
				<li class="has_sub"><a href="javascript:void(0);"><span>Base de Datos</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="backup">Respaldar</a></li>
                        <li><a href="restore">Restaurar</a></li>
                    </ul>
                </li>
                <!--<li class="has_sub"><a href="javascript:void(0);"><span>Productos</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="productos">Productos</a></li>
                        <li><a href="kardexproductos">Kardex Productos</a></li>
                        <li><a href="buscakardex">Búsqueda Kardex</a></li>
                    </ul>
                </li>-->
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-shopping-cart"></i> <span> Compras </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forcompra">Nueva Compra</a></li>
                <li><a href="compras"> Consulta de Compras</a></li>
                <li><a href="detallescompras">Detalles de Compras</a></li>
                <li><a href="compraspendientes"> Cuentas por Pagar</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-money"></i> <span> Gastos </span> <span class="pull-right"><i class="ion ion-plus"></i></span>
            </a>
            <ul class="list-unstyled" style="">
                <li><a href="forgasto">Nuevo Gasto</a></li>
                <li><a href="gastos">Consulta de Gastos</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-cart-arrow-down"></i><span> Ventas </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="arqueoscajas">Arqueo de Caja</a></li>
                <li><a href="movimientoscajas">Movimiento de Cajas</a></li>
                <li><a href="forventa">Nueva Venta</a></li>
                <li><a href="ventas">Ventas</a></li>
                <li><a href="detallesventas">Detalles de Ventas</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-credit-card"></i><span> Cr&eacute;ditos de Clientes </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forcartera">Nuevo Pago</a></li>
                <li><a href="carteracreditos">Consulta de Pagos</a></li>
            </ul>
        </li>


       <!-- <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-folder-open"></i> <span> Reportes </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li class="has_sub"><a href="javascript:void(0);"><span>Productos</span><i
                            class="pull-right fa fa-angle-double-right"></a></i>
                    <ul style="">
                        <li><a href="buscaproductoslaboratorios">Por Laboratorios</a></li>
                        <li><a href="productosvendidos">Vendidos</a></li>
                        <li><a href="productosvencidos">Vencidos</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Compras</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="comprasxproveedor">Por Proveedores</a></li>
                        <li><a href="comprasxfechas">Por Fechas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="ventascajas">Ventas por Cajas</a></li>
                        <li><a href="ventasfechas">Ventas por Fechas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Cajas de Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="arqueosfechas">Arqueo de Cajas</a></li>
                        <li><a href="movimientosfechas">Movim. de Cajas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Cr&eacute;ditos de Clientes</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="creditocliente">Créditos por Clientes</a></li>
                        <li><a href="creditofecha">Créditos por Fechas</a></li>
                    </ul>
                </li>
            </ul>
        </li>-->

        <li> <a href="logout" class="waves-effect"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>

    </ul>
</div>
<!-- FIN DE MENU -->


<?php
            break;
            case 'bodega': ?>


<!-- INICIO DE MENU -->
<div id="sidebar-menu">
    <ul>
        <li> <a href="panel" class="waves-effect"><i class="fa fa-home"></i><span> Inicio </span></a></li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-cubes"></i> <span> Productos </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="productos">Productos</a></li>
                <li><a href="kardexproductos">Kardex Productos</a></li>
                <li><a href="buscakardex">Búsqueda Kardex</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-bus"></i> <span>Traspaso Productos </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="fortraspaso">Nuevo Traspaso</a></li>
                <li><a href="traspasos">Consultar Traspasos</a></li>
                <li><a href="buscartraspasos">Búsqueda Traspasos</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-truck"></i> <span> Pedidos </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forpedido">Nuevo Pedido</a></li>
                <li><a href="pedidos"> Consulta de Pedidos</a></li>
                <li><a href="detallespedidos">Detalles de Pedidos</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-shopping-cart"></i> <span> Compras </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forcompra">Nueva Compra</a></li>
                <li><a href="compras"> Consulta de Compras</a></li>
                <li><a href="detallescompras">Detalles de Compras</a></li>
                <li><a href="compraspendientes"> Cuentas por Pagar</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-money"></i> <span> Gastos </span> <span class="pull-right"><i class="ion ion-plus"></i></span>
            </a>
            <ul class="list-unstyled" style="">
                <li><a href="forgasto">Nuevo Gasto</a></li>
                <li><a href="gastos">Consulta de Gastos</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-cart-arrow-down"></i><span> Ventas </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="arqueoscajas">Arqueo de Caja</a></li>
                <li><a href="movimientoscajas">Movimiento de Cajas</a></li>
                <li><a href="forventa">Nueva Venta</a></li>
                <li><a href="ventas">Ventas</a></li>
                <li><a href="detallesventas">Detalles de Ventas</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-credit-card"></i><span> Cr&eacute;ditos de Clientes </span><span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="forcartera">Nuevo Pago</a></li>
                <li><a href="carteracreditos">Consulta de Pagos</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect">
                <i class="fa fa-folder-open"></i> <span> Reportes </span> <span class="pull-right"><i
                        class="ion ion-plus"></i></span></a>
            <ul class="list-unstyled" style="">

                <li class="has_sub"><a href="javascript:void(0);"><span>Productos</span><i
                            class="pull-right fa fa-angle-double-right"></a></i>
                    <ul style="">
                        <li><a href="buscaproductoslaboratorios">Por Laboratorios</a></li>
                        <li><a href="productosvendidos">Vendidos</a></li>
                        <li><a href="productosvencidos">Vencidos</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Compras</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="comprasxproveedor">Por Proveedores</a></li>
                        <li><a href="comprasxfechas">Por Fechas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="ventascajas">Ventas por Cajas</a></li>
                        <li><a href="ventasfechas">Ventas por Fechas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Cajas de Ventas</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="arqueosfechas">Arqueo de Cajas</a></li>
                        <li><a href="movimientosfechas">Movim. de Cajas</a></li>
                    </ul>
                </li>

                <li class="has_sub"><a href="javascript:void(0);"><span>Cr&eacute;ditos de Clientes</span><i
                            class="pull-right fa fa-angle-double-right"></i></a>
                    <ul style="">
                        <li><a href="creditocliente">Créditos por Clientes</a></li>
                        <li><a href="creditofecha">Créditos por Fechas</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li> <a href="logout" class="waves-effect"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>

    </ul>
</div>
<!-- FIN DE MENU -->



<?php } ?>

</body>

</html>
<?php } else { ?>
<script type='text/javascript' language='javascript'>
alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')
document.location.href = 'logout.php'
</script>
<?php }
} else { ?>
<script type='text/javascript' language='javascript'>
alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')
document.location.href = 'logout.php'
</script>
<?php } ?>