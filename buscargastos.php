
<?php
require_once('class/class.php');
$tra = new Login();

if (isset($_GET['BuscaGastos']) && $_GET['BuscaGastos'] === 'si') {
    //var_dump($_GET); // Para depuración, eliminar en producción
    // DEBUG: imprimir todos los parámetros recibidos
    error_log("🛠️ DEBUG - GET completo:");
    foreach ($_GET as $k => $v) {
        error_log("  $k = $v");
    }

    if (
        isset($_GET['codsucursal'], $_GET['desde'], $_GET['hasta']) &&
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
        //var_dump($codsucursal); // Para depuración, eliminar en producción
        $desde = $_GET['desde'];
        $hasta = $_GET['hasta'];
        

        // Rango extendido para cubrir todo el día
        $fechaDesde = date('Y-m-d 00:00:00', strtotime($desde));
        $fechaHasta = date('Y-m-d 23:59:59', strtotime($hasta));

        error_log('✅ Gastos - Parámetros:');
        error_log('  codsucursal: ' . $codsucursal);
        error_log('  desde: ' . $fechaDesde);
        error_log('  hasta: ' . $fechaHasta);
        

        $gastos = $tra->ListarGastosPorRango($codsucursal, $fechaDesde, $fechaHasta);
        //var_dump($gastos); // Para depuración, eliminar en producción
        if (!empty($gastos)) {
            echo '<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-money"></i> Reporte de Gastos</h3></div>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-bordered">';
            echo '<thead>
                    <tr>
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Descripción</th>
                        <th>Monto Total</th>
                        <th>Fecha del Gasto</th>
                        <th>Tipo de Gasto</th>
                        <th>Método de Pago</th>
                        <th>Observaciones</th>
                        <th>Creado por</th>
                        <th>Acciones</th>

                    </tr>
                </thead><tbody>';

            foreach ($gastos as $index => $g) {
                echo '<tr>';
                echo '<td>' . ($index + 1) . '</td>';
                echo '<td>' . htmlentities($g['proveedor']) . '</td>';
                echo '<td>' . htmlentities($g['descripcion']) . '</td>';
                echo '<td>' . number_format((float)$g['monto_total'], 2, ',', '.') . '</td>';
                echo '<td>' . htmlentities($g['fecha_gasto']) . '</td>';
                echo '<td>' . htmlentities($g['tipo_gasto']) . '</td>';
                echo '<td>' . htmlentities($g['metodo_pago']) . '</td>';
                echo '<td>' . nl2br(htmlentities($g['observaciones'])) . '</td>';
                echo '<td>' . htmlentities($g['creado_por']) . '</td>';
                echo '<td>
                        <a href="editargasto.php?id=' . base64_encode($g['idgasto']) . '" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Editar
                        </a>
                        <a href="eliminargasto.php?id=' . base64_encode($g['idgasto']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar este gasto?\')">
                            <i class="fa fa-trash"></i> Eliminar
                        </a>
                    </td>';
                echo '</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No se encontraron gastos en el rango de fechas y criterio seleccionados.</div>';
        }
        } else {
            error_log('❌ Error: codsucursal inválido o parámetros faltantes.');
            echo '<div class="alert alert-danger">Error: Faltan parámetros o codsucursal inválido.</div>';
        }

}
?>
