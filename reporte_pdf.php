
<?php
ob_start();
include_once('fpdf/pdf.php');
require_once('class/class.php');

$casos = array(
    'TOP_PRODUCTOS_MAS_VENDIDOS' => array(
        'medidas' => array('L', 'mm', 'LEGAL'),
        'func' => 'TablaTopProductosMasVendidos',
        'output' => array('Top Productos Más Vendidos.pdf', 'I')
    )
);

$tipo = base64_decode($_GET['tipo']);
$caso_data = $casos[$tipo];

// Crear PDF con medidas definidas
$pdf = new PDF($caso_data['medidas'][0], $caso_data['medidas'][1], $caso_data['medidas'][2]);
$pdf->AddPage();

// Ejecutar la función que dibuja el contenido del PDF
$pdf->{$caso_data['func']}();

// También enviar por email (si está habilitado en el sistema)
$pdfdoc = $pdf->Output('S');
if (method_exists($pdf, 'send_factura_mail')) {
    $pdf->send_factura_mail($pdfdoc);
}

// Mostrar PDF en el navegador
$pdf->Output($caso_data['output'][0], $caso_data['output'][1]);
ob_end_flush();
?>
