<?php
require_once("class/class.php");
require_once("fpdf/pdf.php"); // tu clase extendida con estilos, logo, etc.

$login = new Login();

// Validación de parámetros
if (!isset($_GET['codsucursal'], $_GET['desde'], $_GET['hasta'])) {
    die("Parámetros incompletos");
}

$codsucursal = base64_decode($_GET['codsucursal']);
$desde = date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', $_GET['desde'])));
$hasta = date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $_GET['hasta'])));

$gastos = $login->ListarGastosPorRango($codsucursal, $desde, $hasta);

// Inicia PDF
$pdf = new PDF(); // Asegúrate que esta clase extiende FPDF
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('Reporte de Gastos'), 0, 1, 'C');
$pdf->Ln(5);

// Encabezados tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 8, '#', 1);
$pdf->Cell(40, 8, utf8_decode('Proveedor'), 1);
$pdf->Cell(30, 8, 'Monto', 1);
$pdf->Cell(40, 8, 'Fecha', 1);
$pdf->Cell(60, 8, utf8_decode('Descripción'), 1);
$pdf->Ln();

// Cuerpo tabla
$pdf->SetFont('Arial', '', 9);
$contador = 1;
foreach ($gastos as $g) {
    $pdf->Cell(10, 8, $contador++, 1);
    $pdf->Cell(40, 8, utf8_decode($g['proveedor']), 1);
    $pdf->Cell(30, 8, number_format((float)$g['monto_total'], 2, ',', '.'), 1);
    $fecha = $g['fecha_gasto'];
    $fechaFormateada = strtotime($fecha) ? date("d/m/Y", strtotime($fecha)) : 'Sin fecha';
    $pdf->Cell(40, 8, $fechaFormateada, 1);
    $pdf->Cell(60, 8, utf8_decode($g['descripcion']), 1);
    $pdf->Ln();
}

$pdf->Output();