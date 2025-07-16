<?php
include('class.consultas.php');
$filtro    = $_GET["term"];
$Json      = new Json();
$productos  = $Json->BuscaProductosVentas($filtro);
echo  json_encode($productos);

?>  