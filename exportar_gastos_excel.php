<?php
require_once("class/class.php");

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte_gastos.xls");
header("Pragma: no-cache");
header("Expires: 0");

$login = new Login();

$codsucursal = base64_decode($_GET['codsucursal']);
$desde = !empty($_GET['desde']) ? date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', $_GET['desde']))) : null;
$hasta = !empty($_GET['hasta']) ? date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $_GET['hasta']))) : null;

$gastos = $login->ListarGastosPorRango($codsucursal, $desde, $hasta);

// ENCABEZADO
echo "<table border='1'>";
echo "<tr><th colspan='9' style='font-size:16px;'>Reporte de Gastos</th></tr>";
echo "<tr>
        <th>#</th>
        <th>Proveedor</th>
        <th>Descripción</th>
        <th>Monto</th>
        <th>Fecha</th>
        <th>Tipo de Gasto</th>
        <th>Método de Pago</th>
        <th>Observaciones</th>
        <th>Creado por</th>
    </tr>";

$contador = 1;
$totalGastos = 0;

foreach ($gastos as $g) {
    $fecha = $g['fecha_gasto'];
    $fechaFormateada = strtotime($fecha) ? date("d/m/Y", strtotime($fecha)) : 'Sin fecha';

    $monto = (float)$g['monto_total'];
    $totalGastos += $monto;

    echo "<tr>";
    echo "<td>{$contador}</td>";
    echo "<td>" . htmlentities($g['proveedor']) . "</td>";
    echo "<td>" . htmlentities($g['descripcion']) . "</td>";
    echo "<td>" . number_format($monto, 2, ',', '.') . "</td>";
    echo "<td>" . $fechaFormateada . "</td>";
    echo "<td>" . htmlentities($g['tipo_gasto']) . "</td>";
    echo "<td>" . htmlentities($g['metodo_pago']) . "</td>";
    echo "<td>" . htmlentities($g['observaciones']) . "</td>";
    echo "<td>" . htmlentities($g['creado_por']) . "</td>";
    echo "</tr>";

    $contador++;
}

// TOTAL GENERAL
echo "<tr style='font-weight:bold; background-color:#f2f2f2'>";
echo "<td colspan='3' align='right'>TOTAL:</td>";
echo "<td>" . number_format($totalGastos, 2, ',', '.') . "</td>";
echo "<td colspan='5'></td>";
echo "</tr>";
echo "</table>";
