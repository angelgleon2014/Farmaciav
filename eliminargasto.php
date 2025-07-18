<?php
require_once("class/class.php");

if (isset($_GET["id"])) {
    $idgasto = base64_decode($_GET["id"]);
    error_log("🧨 ID para eliminar: $idgasto");

    $login = new Login();
    $login->EliminarGasto($idgasto);

    echo "<script>alert('Gasto eliminado');window.location='gastos.php';</script>";
} else {
    error_log("❌ ID no recibido para eliminar");
    echo "<script>alert('ID no recibido');window.location='gastos.php';</script>";
}
?>

