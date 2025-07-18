<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "cajero") {

        $login = new Login();
        $login->ExpiraSession();

        if (isset($_GET["id"])) {
            $idgasto = base64_decode($_GET["id"]);
            $gasto = $login->ObtenerGastoPorId($idgasto);
        }

        if (isset($_POST["btn_update"])) {
            $login->ActualizarGasto();
            exit;
        }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Gasto</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h3 class="mt-4"><i class="fa fa-edit"></i> Editar Gasto</h3>
        <form method="post" action="">
            <input type="hidden" name="idgasto" value="<?= $gasto['idgasto'] ?>">

            <div class="form-group">
                <label>Proveedor:</label>
                <input type="text" name="proveedor" class="form-control" value="<?= htmlentities($gasto['proveedor']) ?>" required>
            </div>

            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control" required><?= htmlentities($gasto['descripcion']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Monto Total:</label>
                <input type="number" step="0.01" name="monto_total" class="form-control" value="<?= $gasto['monto_total'] ?>" required>
            </div>

            <div class="form-group">
                <label>Fecha del Gasto:</label>
                <input type="date" name="fecha_gasto" class="form-control" value="<?= substr($gasto['fecha_gasto'], 0, 10) ?>" required>
            </div>

            <div class="form-group">
                <label>Tipo de Gasto:</label>
                <input type="text" name="tipo_gasto" class="form-control" value="<?= htmlentities($gasto['tipo_gasto']) ?>" required>
            </div>

            <div class="form-group">
                <label>Método de Pago:</label>
                <input type="text" name="metodo_pago" class="form-control" value="<?= htmlentities($gasto['metodo_pago']) ?>" required>
            </div>

            <div class="form-group">
                <label>Observaciones:</label>
                <textarea name="observaciones" class="form-control"><?= htmlentities($gasto['observaciones']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Sucursal:</label>
                <input type="text" name="codsucursal" class="form-control" value="<?= htmlentities($gasto['codsucursal']) ?>" required>
            </div>

            <div class="form-group">
                <label>Creado por:</label>
                <input type="text" name="creado_por" class="form-control" value="<?= htmlentities($gasto['creado_por']) ?>" required>
            </div>

            <div class="form-group mt-3">
                <button type="submit" name="btn_update" class="btn btn-success">
                    <i class="fa fa-save"></i> Actualizar Gasto
                </button>
                <a href="buscargastos.php" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    } else {
        echo "<script>window.location='logout.php';</script>";
    }
} else {
    echo "<script>window.location='logout.php';</script>";
}
?>
