<?php
include('class.consultas.php');
$filtro    = $_GET["term"];
$Json      = new Json();
$presentacion  = $Json->BuscaPresentacion($filtro);
echo  json_encode($presentacion);

?>  