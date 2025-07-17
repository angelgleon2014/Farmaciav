<?php
require_once("class/class.php");

if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "bodega") {

        $login = new Login();

        $codsucursal = base64_decode($_GET['codsucursal']);
        $desde = date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', $_GET['desde'])));
        $hasta = date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $_GET['hasta'])));
        $top_n = $_GET['top_n'];

        $reg = $login->TopProductosMasVendidos($codsucursal, $desde, $hasta, $top_n);

        $hoy = "TOP_PRODUCTOS_MAS_VENDIDOS_".$desde."_AL_".$hasta;       

        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Disposition: attachment;filename=".$hoy.".xls");
        ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
    <tr>
        <th colspan="3" style="font-size:16px;">TOP PRODUCTOS MÁS VENDIDOS</th>
    </tr>
    <tr>
        <th>Nº</th>
        <th>PRODUCTO</th>
        <th>CANTIDAD VENDIDA</th>
    </tr>

<?php
        $total = 0;
        $num = 1;

        if (!empty($reg)) {
            foreach ($reg as $row) {
                $total += $row['cantidad_total_vendida'];
                ?>
                <tr align="center">
                    <td><?php echo $num++; ?></td>
                    <td><?php echo $row['producto']; ?></td>
                    <td><?php echo $row['cantidad_total_vendida']; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    <tr>
        <td></td>
        <td><strong>TOTAL GENERAL</strong></td>
        <td><strong><?php echo $total; ?></strong></td>
    </tr>
</table>

<?php
    } else {
        echo "<script>alert('NO TIENES PERMISO PARA ACCEDER A ESTA PÁGINA'); window.location='panel';</script>";
    }
} else {
    echo "<script>alert('DEBES INICIAR SESIÓN'); window.location='logout';</script>";
}
?>
