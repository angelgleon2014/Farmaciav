
<?php
require_once('class/class.php');
$tra = new Login();

if (isset($_GET['BuscaMasVendidos']) && $_GET['BuscaMasVendidos'] === 'si') {

    // DEBUG: imprimir todos los parámetros recibidos
    error_log("🛠️ DEBUG - GET completo:");
    foreach ($_GET as $k => $v) {
        error_log("  $k = $v");
    }

    if (
        isset($_GET['codsucursal'], $_GET['desde'], $_GET['hasta'], $_GET['top_n']) &&
        base64_decode($_GET['codsucursal'], true) !== false
    ) {
        $codsucursal_encoded = $_GET['codsucursal'];
        error_log("🧪 Recibido codsucursal base64: $codsucursal_encoded");

        $codsucursal = base64_decode($codsucursal_encoded, true);
        if ($codsucursal === false) {
            error_log("❌ No se pudo decodificar correctamente el codsucursal");
            exit('<div class="alert alert-danger">Error: codsucursal inválido (decodificación fallida).</div>');
        } else {
            error_log("✅ codsucursal decodificado correctamente: $codsucursal");
        }

        $desde = $_GET['desde'];
        $hasta = $_GET['hasta'];
        $top_n = (int)$_GET['top_n'];

        // Rango extendido para cubrir todo el día
        $fechaDesde = date('Y-m-d 00:00:00', strtotime($desde));
        $fechaHasta = date('Y-m-d 23:59:59', strtotime($hasta));

        error_log('✅ TOP_PRODUCTOS_MAS_VENDIDOS - Parámetros:');
        error_log('  codsucursal: ' . $codsucursal);
        error_log('  desde: ' . $fechaDesde);
        error_log('  hasta: ' . $fechaHasta);
        error_log('  top_n: ' . $top_n);

        $productosMasVendidos = $tra->TopProductosMasVendidos($codsucursal, $fechaDesde, $fechaHasta, $top_n);

        if (!empty($productosMasVendidos)) {
            echo '<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bar-chart"></i> Reporte de Top ' . $top_n . ' Productos Más Vendidos</h3></div>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>Producto</th><th>Cantidad Vendida</th></tr></thead><tbody>';
            foreach ($productosMasVendidos as $producto) {
                echo '<tr><td>' . htmlentities($producto['producto']) . '</td><td>' . (int)$producto['cantidad_total_vendida'] . '</td></tr>';
            }
            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No se encontraron productos vendidos en el rango de fechas y criterio seleccionados.</div>';
        }
    } else {
        error_log('❌ Error: codsucursal inválido o parámetros faltantes.');
        echo '<div class="alert alert-danger">Error: Faltan parámetros o codsucursal inválido.</div>';
    }
}
?>
