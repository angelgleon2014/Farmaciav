<?php

session_start();
require_once("classconexion.php");

class conectorDB extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function EjecutarSentencia($consulta, $valores = array())  //funcion principal, ejecuta todas las consultas
    {$resultado = false;

        if($statement = $this->dbh->prepare($consulta)) {  //prepara la consulta
            if(preg_match_all("/(:\w+)/", $consulta, $campo, PREG_PATTERN_ORDER)) { //tomo los nombres de los campos iniciados con :xxxxx
                $campo = array_pop($campo); //inserto en un arreglo
                foreach($campo as $parametro) {
                    $statement->bindValue($parametro, $valores[substr($parametro, 1)]);
                }
            }
            try {
                if (!$statement->execute()) { //si no se ejecuta la consulta...
                    print_r($statement->errorInfo()); //imprimir errores
                    return false;
                }
                $resultado = $statement->fetchAll(PDO::FETCH_ASSOC); //si es una consulta que devuelve valores los guarda en un arreglo.
                $statement->closeCursor();
            } catch(PDOException $e) {
                echo "Error de ejecución: \n";
                print_r($e->getMessage());
            }
        }
        return $resultado;
        $this->dbh = null; //cerramos la conexión
    } /// Termina funcion consultarBD
}/// Termina clase conectorDB

class Json
{
    private $json;

    public function BuscaProductos($filtro)
    {

        $consulta = "SELECT 
        productos.preciocompraunidad,
        productos.preciocomprablister,
        productos.precioventablister,
		productos.precioventablisterdesc,
		productos.precioventacajadesc,
		productos.precioventaunidaddesc,
        productos.blisterunidad,
        CONCAT(producto, ' : ',principioactivo, ' : ',nompresentacion, ' : ',nommedida, ' : ', COALESCE(nomproveedor, '')) as label, productos.codproducto, productos.producto, productos.principioactivo, productos.descripcion, productos.codpresentacion, productos.codmedida, productos.preciocompra, productos.precioventaunidad, productos.precioventacaja, productos.unidades, productos.ivaproducto, productos.descproducto, productos.fechaelaboracion, productos.fechaexpiracion, productos.loteproducto, productos.codigobarra, productos.codlaboratorio, presentaciones.nompresentacion, medidas.nommedida, proveedores.nomproveedor, laboratorios.nomlaboratorio
		FROM productos LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor LEFT JOIN laboratorios ON productos.codlaboratorio=laboratorios.codlaboratorio
		WHERE CONCAT(principioactivo, '',producto, '',codigobarra) LIKE '%".$filtro."%' GROUP BY codproducto ASC LIMIT 0,15";
        $conexion = new conectorDB();
        $this->json = $conexion->EjecutarSentencia($consulta);
        return $this->json;
    }



    public function BuscaProductosVentas($filtro)
    {
        $consulta = "SELECT 
            CONCAT(producto, ' : ',principioactivo, ' : ',nompresentacion, ' : ',nommedida, ' : ', nomlaboratorio, ' : ',ubicacion) as label, 
            productos.precioventablister, 
            productos.blisterunidad, 
            productos.stockblister, 
            productos.codproducto, 
            productos.producto, 
            productos.principioactivo, 
            productos.descripcion, 
            productos.codpresentacion, 
            productos.codmedida, 
            productos.preciocompra, 
            productos.precioventaunidad, 
            productos.precioventacaja, 
			productos.precioventablisterdesc,
			productos.precioventacajadesc,
			productos.precioventaunidaddesc,
            productos.stockcajas, productos.unidades, productos.stocktotal, productos.ivaproducto, productos.descproducto, productos.fechaelaboracion, productos.fechaexpiracion, productos.loteproducto, productos.ubicacion, productos.statusp, presentaciones.nompresentacion, medidas.nommedida, laboratorios.nomlaboratorio, laboratorios.desclaboratorio, sucursales.codsucursal FROM productos INNER JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON productos.codmedida = medidas.codmedida INNER JOIN sucursales ON productos.codsucursal=sucursales.codsucursal LEFT JOIN laboratorios ON productos.codlaboratorio=laboratorios.codlaboratorio
			WHERE CONCAT(producto, '',codigobarra) LIKE '%".$filtro."%' AND productos.codsucursal= '".$_SESSION["codsucursal"]."' AND productos.statusp = '0' AND productos.fechaexpiracion > NOW() ORDER BY codproducto ASC LIMIT 0,15";
        $conexion = new conectorDB();
        //print_r(json_encode($consulta));
        $this->json = $conexion->EjecutarSentencia($consulta);
        return $this->json;
    }


    public function BuscaPresentacion($filtro)
    {
        $consulta = "SELECT CONCAT(presentacion, '') as label FROM productos WHERE CONCAT(presentacion, '') LIKE '%".$filtro."%' ORDER BY codproducto asc LIMIT 0,15";
        $conexion = new conectorDB();
        $this->json = $conexion->EjecutarSentencia($consulta);
        return $this->json;
    }


    public function BuscaClientes($filtro)
    {
        $consulta = "SELECT CONCAT(cedcliente, ': ',nomcliente) as label, codcliente FROM clientes WHERE CONCAT(cedcliente, '',nomcliente) LIKE '%".$filtro."%' order by codcliente asc LIMIT 0,15";
        $conexion = new conectorDB();
        $this->json = $conexion->EjecutarSentencia($consulta);
        return $this->json;
    }

    public function BuscaCodventa($filtro)
    {
        $consulta = "SELECT codventa as label FROM ventas WHERE codventa LIKE '%".$filtro."%' order by codventa asc LIMIT 0,10";
        $conexion = new conectorDB();
        $this->json = $conexion->EjecutarSentencia($consulta);
        return $this->json;
    }



}/// TERMINA CLASE  ///
