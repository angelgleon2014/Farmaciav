<?php
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();
require_once("classconexion.php");
include_once('funciones_basicas.php');
ini_set('memory_limit', '-1'); //evita el error Fatal error: Allowed memory size of X bytes exhausted (tried to allocate Y bytes)...
ini_set('max_execution_time', 3800); // es lo mismo que set_time_limit(300) ;

################################ CLASE LOGIN ############################################
class Login extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    ##########################  FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD #######################
    public function ExpiraSession()
    {


        if (!isset($_SESSION['usuario'])) { // Esta logeado?.
            header("Location: logout.php");
        }

        //Verifico el tiempo si esta seteado, caso contrario lo seteo.
        if (isset($_SESSION['time'])) {
            $tiempo = $_SESSION['time'];
        } else {
            $tiempo = strtotime(date("Y-m-d h:i:s"));
        }

        $inactividad = 36000;

        $actual =  strtotime(date("Y-m-d h:i:s"));

        if (($actual - $tiempo) >= $inactividad) {
            ?>
			<script type='text/javascript' language='javascript'>
				alert('SU SESSION A EXPIRADO \nPOR FAVOR LOGUEESE DE NUEVO PARA ACCEDER AL SISTEMA')
				document.location.href = 'logout'
			</script>
			<?php

        } else {

            $_SESSION['time'] = $actual;
        }
    }

    ##########################  FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD #######################



    ##################################### FUNCION LOGIN DE ACCESO #####################################
    public function Logueo()
    {
        self::SetNames();
        if (empty($_POST["usuario"]) or empty($_POST["password"])) {
            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LOS CAMPOS NO PUEDEN IR VACIOS";
            echo "</div>";
            exit;
        }
        $pass = sha1(md5($_POST["password"]));


        $sql = " SELECT * from usuarios LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE usuarios.usuario = ? and usuarios.password = ? and usuarios.status = 'ACTIVO'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["usuario"], $pass));
        $num = $stmt->rowCount();
        //var_dump($pass);
        //var_dump($num);
        if ($num === 0) {
            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LOS DATOS INGRESADOS NO EXISTEN";
            echo "</div>";
            exit;
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $p[] = $row;
            }

            ######### DATOS DEL USUARIO ###########
            $_SESSION["codigo"] = $p[0]["codigo"];
            $_SESSION["cedula"] = $p[0]["cedula"];
            $_SESSION["nombres"] = $p[0]["nombres"];
            $_SESSION["genero"] = $p[0]["genero"];
            $_SESSION["fnac"] = $p[0]["fnac"];
            $_SESSION["direcdomic"] = $p[0]["direcdomic"];
            $_SESSION["lugnac"] = $p[0]["lugnac"];
            $_SESSION["nrotelefono"] = $p[0]["nrotelefono"];
            $_SESSION["cargo"] = $p[0]["cargo"];
            $_SESSION["email"] = $p[0]["email"];
            $_SESSION["usuario"] = $p[0]["usuario"];
            $_SESSION["nivel"] = $p[0]["nivel"];
            $_SESSION["status"] = $p[0]["status"];

            ######### DATOS DE LA SUCURSAL ###########
            $_SESSION["codsucursal"] = $p[0]["codsucursal"];
            $_SESSION["cedresponsable"] = $p[0]["cedresponsable"];
            $_SESSION["nomresponsable"] = $p[0]["nomresponsable"];
            $_SESSION["celresponsable"] = $p[0]["celresponsable"];
            $_SESSION["rucsucursal"] = $p[0]["rucsucursal"];
            $_SESSION["razonsocial"] = $p[0]["razonsocial"];
            $_SESSION["tlfsucursal"] = $p[0]["tlfsucursal"];
            $_SESSION["celsucursal"] = $p[0]["celsucursal"];
            $_SESSION["emailsucursal"] = $p[0]["emailsucursal"];
            $_SESSION["direcsucursal"] = $p[0]["direcsucursal"];
            $_SESSION["nroactividadsucursal"] = $p[0]["nroactividadsucursal"];
            $_SESSION["nroiniciofactura"] = $p[0]["nroiniciofactura"];
            $_SESSION["fechaautorsucursal"] = $p[0]["fechaautorsucursal"];
            $_SESSION["ivacsucursal"] = $p[0]["ivacsucursal"];
            $_SESSION["ivavsucursal"] = $p[0]["ivavsucursal"];
            $_SESSION["descsucursal"] = $p[0]["descsucursal"];
            $_SESSION["llevacontabilidad"] = $p[0]["llevacontabilidad"];
            $_SESSION["simbolo"] = $p[0]["simbolo"];


            ######### REGISTRO LOS DATOS DE ACCESO ###########
            $query = " insert into log values (null, ?, ?, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $a);
            $stmt->bindParam(2, $b);
            $stmt->bindParam(3, $c);
            $stmt->bindParam(4, $d);
            $stmt->bindParam(5, $e);

            $a = strip_tags($_SERVER['REMOTE_ADDR']);
            $b = strip_tags(date("Y-m-d h:i:s"));
            $c = strip_tags($_SERVER['HTTP_USER_AGENT']);
            $d = strip_tags($_SERVER['PHP_SELF']);
            $e = strip_tags($_POST["usuario"]);
            $stmt->execute();


            switch ($_SESSION["nivel"]) {
                case 'ADMINISTRADOR(A) GENERAL':
                    $_SESSION["acceso"] = "administradorG";

                    ?>

					<script type="text/javascript">
						window.location = "panel";
					</script>

				<?php
                            break;
                case 'ADMINISTRADOR(A) SUCURSAL':
                    $_SESSION["acceso"] = "administradorS";

                    ?>

					<script type="text/javascript">
						window.location = "panel";
					</script>

				<?php
                        break;
                case 'CAJERO(A)':
                    $_SESSION["acceso"] = "cajero";
                    ?>

					<script type="text/javascript">
						window.location = "panel";
					</script>

				<?php
                        break;
                case 'BODEGA':
                    $_SESSION["acceso"] = "bodega";
                    ?>

					<script type="text/javascript">
						window.location = "panel";
					</script>

		<?php
                        break;
                    //}
            }
        }
        // print_r($_SESSION["acceso"] . "\n");
        //print_r($_POST);
        exit;
    }
    ##################################### FUNCION LOGIN DE ACCESO #####################################








    ########################### FUNCION RECUPERAR Y ACTUALIZAR PASSWORD ##########################

    ################################ FUNCION PARA RECUPERAR CLAVE ###############################
    public function RecuperarPassword()
    {
        self::SetNames();
        if (empty($_POST["email"])) {
            echo "1";
            exit;
        }

        $sql = " select * from usuarios where email = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["email"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "2";
            exit;
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pa[] = $row;
            }
            $id = $pa[0]["codigo"];
            $nombres = $pa[0]["nombres"];
            $password = $pa[0]["password"];
        }

        $sql = " update usuarios set "
            . " password = ? "
            . " where "
            . " codigo = ?;
		";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $password);
        $stmt->bindParam(2, $codigo);

        $codigo = $id;
        $pass = strtoupper(generar_clave(10));
        $password = sha1(md5($pass));
        $stmt->execute();

        $para = $_POST["email"];
        $titulo = 'RECUPERACION DE PASSWORD';
        $header = 'From: ' . 'SISTEMA PARA GESTI�N DE FARMACIA';
        $msjCorreo = " Nombre: $nombres\n Nuevo Passw: $pass\n Mensaje: Por favor use esta nueva clave de acceso para ingresar al Sistema para Gesti�n de Farmacia\n";
        mail($para, $titulo, $msjCorreo, $header);

        echo "<div class='alert alert-info'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> SU NUEVA CLAVE DE ACCESO LE FUE ENVIADA A SU CORREO";
        echo "</div>";
        exit;
    }
    ################################# FUNCION PARA RECUPERAR CLAVE ################################

    ################################ FUNCION PARA ACTUALIZAR PASSWORD ##################################
    public function ActualizarPassword()
    {
        if (empty($_POST["cedula"])) {
            echo "1";
            exit;
        }

        self::SetNames();
        $sql = " update usuarios set "
            . " usuario = ?, "
            . " password = ? "
            . " where "
            . " codigo = ?;
			   ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $password);
        $stmt->bindParam(3, $codigo);

        $usuario = strip_tags($_POST["usuario"]);
        $password = sha1(md5($_POST["password"]));
        $codigo = strip_tags($_SESSION["codigo"]);
        $stmt->execute();

        echo "<div class='alert alert-info'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> SU CLAVE DE ACCESO FUE ACTUALIZADA EXITOSAMENTE, SER&Aacute; EXPULSADO DE SU SESI&Oacute;N Y DEBER&Aacute; DE ACCEDER NUEVAMENTE";
        echo "</div>";
        ?>
		<script>
			function redireccionar() {
				location.href = "logout.php";
			}
			setTimeout("redireccionar()", 3000);
		</script>
		<?php
        exit;
    }
    ############################### FUNCION PARA ACTUALIZAR PASSWORD #############################

    ########################## FUNCION RECUPERAR Y ACTUALIZAR PASSWORD ###########################






































    ####################################### CLASE USUARIOS #######################################

    ##################################### FUNCION REGISTRAR USUARIOS ###################################
    public function RegistrarUsuarios()
    {
        self::SetNames();
        if (empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"])) {
            echo "1";
            exit;
        }

        if ($_POST['nivel'] == "CAJERO") {

            if ($_POST["nivel"] == "CAJERO" && $_POST["codsucursal"] == "") {

                echo "2";
                exit;
            }
        }

        $sql = " select cedula from usuarios where cedula = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["cedula"]));
        $num = $stmt->rowCount();
        if ($num > 0) {

            echo "3";
            exit;
        } else {
            $sql = " select email from usuarios where email = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["email"]));
            $num = $stmt->rowCount();
            if ($num > 0) {

                echo "4";
                exit;
            } else {
                $sql = " select usuario from usuarios where usuario = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_POST["usuario"]));
                $num = $stmt->rowCount();
                if ($num == 0) {
                    $query = " insert into usuarios values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $cedula);
                    $stmt->bindParam(2, $nombres);
                    $stmt->bindParam(3, $genero);
                    $stmt->bindParam(4, $fnac);
                    $stmt->bindParam(5, $lugnac);
                    $stmt->bindParam(6, $direcdomic);
                    $stmt->bindParam(7, $nrotelefono);
                    $stmt->bindParam(8, $cargo);
                    $stmt->bindParam(9, $email);
                    $stmt->bindParam(10, $usuario);
                    $stmt->bindParam(11, $password);
                    $stmt->bindParam(12, $nivel);
                    $stmt->bindParam(13, $codsucursal);
                    $stmt->bindParam(14, $status);

                    $cedula = strip_tags($_POST["cedula"]);
                    $nombres = strip_tags($_POST["nombres"]);
                    $genero = strip_tags($_POST["genero"]);
                    $fnac = strip_tags(date("Y-m-d", strtotime($_POST['fnac'])));
                    $lugnac = strip_tags($_POST["lugnac"]);
                    $direcdomic = strip_tags($_POST["direcdomic"]);
                    $nrotelefono = strip_tags($_POST["nrotelefono"]);
                    $cargo = strip_tags($_POST["cargo"]);
                    $email = strip_tags($_POST["email"]);
                    $usuario = strip_tags($_POST["usuario"]);
                    $password = sha1(md5($_POST["password"]));
                    $nivel = strip_tags($_POST["nivel"]);
                    if (strip_tags(isset($_POST['codsucursal']))) {
                        $codsucursal = strip_tags($_POST['codsucursal']);
                    } else {
                        $codsucursal = '0';
                    }
                    $status = strip_tags($_POST["status"]);
                    $stmt->execute();

                    ##################  SUBIR FOTO DE USUARIOS ######################################
                    //datos del arhivo
                    if (isset($_FILES['imagen']['name'])) {
                        $nombre_archivo = $_FILES['imagen']['name'];
                    } else {
                        $nombre_archivo = '';
                    }
                    if (isset($_FILES['imagen']['type'])) {
                        $tipo_archivo = $_FILES['imagen']['type'];
                    } else {
                        $tipo_archivo = '';
                    }
                    if (isset($_FILES['imagen']['size'])) {
                        $tamano_archivo = $_FILES['imagen']['size'];
                    } else {
                        $tamano_archivo = '';
                    }
                    //compruebo si las caracter�sticas del archivo son las que deseo
                    if ((strpos($tipo_archivo, 'image/jpeg') !== false) && $tamano_archivo < 50000) {
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombre_archivo) && rename("fotos/" . $nombre_archivo, "fotos/" . $_POST["cedula"] . ".jpg")) {
                            ## se puede dar un aviso
                        }
                        ## se puede dar otro aviso
                    }
                    ##################  FINALIZA SUBIR FOTO DE USUARIOS ######################################

                    echo "<div class='alert alert-success'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-check-square-o'></span> EL USUARIO FUE REGISTRADO EXITOSAMENTE";
                    echo "</div>";
                    exit;
                } else {
                    echo "5";
                    exit;
                }
            }
        }
    }
    ################################## FUNCION REGISTRAR USUARIOS #################################

    ################################### FUNCION LISTAR USUARIOS ####################################
    public function ListarUsuarios()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " select * FROM usuarios LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " select * FROM usuarios LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE usuarios.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################## FUNCION LISTAR USUARIOS ##################################

    ################################# FUNCION LISTAR LOG USUARIOS #################################
    public function ListarLogs()
    {
        self::SetNames();
        $sql = " select * FROM log";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################ FUNCION LISTAR LOG USUARIOS ################################

    ###################################### FUNCION ID USUARIOS ######################################
    public function UsuariosPorId()
    {
        self::SetNames();
        $sql = "select * FROM usuarios LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal where usuarios.codigo = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codigo"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    #################################### FUNCION ID USUARIOS ######################################

    ################################ FUNCION ACTUALIZAR USUARIOS #################################
    public function ActualizarUsuarios()
    {

        if (empty($_POST["cedula"]) or empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"])) {
            echo "1";
            exit;
        }

        if ($_POST['nivel'] == "CAJERO(A)") {

            if ($_POST["nivel"] == "CAJERO(A)" && $_POST["codsucursal"] == "") {

                echo "2";
                exit;
            }
        }
        self::SetNames();
        $sql = " select * from usuarios where codigo != ? and cedula = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codigo"], $_POST["cedula"]));
        $num = $stmt->rowCount();
        if ($num > 0) {
            echo "3";
            exit;
        } else {
            $sql = " select email from usuarios where codigo != ? and email = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codigo"], $_POST["email"]));
            $num = $stmt->rowCount();
            if ($num > 0) {
                echo "4";
                exit;
            } else {
                $sql = " select usuario from usuarios where codigo != ? and usuario = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_POST["codigo"], $_POST["usuario"]));
                $num = $stmt->rowCount();
                if ($num == 0) {
                    $sql = " update usuarios set "
                        . " cedula = ?, "
                        . " nombres = ?, "
                        . " genero = ?, "
                        . " fnac = ?, "
                        . " lugnac = ?, "
                        . " direcdomic = ?, "
                        . " nrotelefono = ?, "
                        . " cargo = ?, "
                        . " email = ?, "
                        . " usuario = ?, "
                        . " password = ?, "
                        . " nivel = ?, "
                        . " codsucursal = ?, "
                        . " status = ? "
                        . " where "
                        . " codigo = ?;
					";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $cedula);
                    $stmt->bindParam(2, $nombres);
                    $stmt->bindParam(3, $genero);
                    $stmt->bindParam(4, $fnac);
                    $stmt->bindParam(5, $lugnac);
                    $stmt->bindParam(6, $direcdomic);
                    $stmt->bindParam(7, $nrotelefono);
                    $stmt->bindParam(8, $cargo);
                    $stmt->bindParam(9, $email);
                    $stmt->bindParam(10, $usuario);
                    $stmt->bindParam(11, $password);
                    $stmt->bindParam(12, $nivel);
                    $stmt->bindParam(13, $codsucursal);
                    $stmt->bindParam(14, $status);
                    $stmt->bindParam(15, $codigo);

                    $cedula = strip_tags($_POST["cedula"]);
                    $nombres = strip_tags($_POST["nombres"]);
                    $genero = strip_tags($_POST["genero"]);
                    $fnac = strip_tags(date("Y-m-d", strtotime($_POST['fnac'])));
                    $lugnac = strip_tags($_POST["lugnac"]);
                    $direcdomic = strip_tags($_POST["direcdomic"]);
                    $nrotelefono = strip_tags($_POST["nrotelefono"]);
                    $cargo = strip_tags($_POST["cargo"]);
                    $email = strip_tags($_POST["email"]);
                    $usuario = strip_tags($_POST["usuario"]);
                    $password = sha1(md5($_POST["password"]));
                    $nivel = strip_tags($_POST["nivel"]);
                    if (strip_tags(isset($_POST['codsucursal']))) {
                        $codsucursal = strip_tags($_POST['codsucursal']);
                    } else {
                        $codsucursal = '0';
                    }
                    $status = strip_tags($_POST["status"]);
                    $codigo = strip_tags($_POST["codigo"]);
                    $stmt->execute();

                    ##################  SUBIR FOTO DE USUARIOS ######################################
                    //datos del arhivo
                    if (isset($_FILES['imagen']['name'])) {
                        $nombre_archivo = $_FILES['imagen']['name'];
                    } else {
                        $nombre_archivo = '';
                    }
                    if (isset($_FILES['imagen']['type'])) {
                        $tipo_archivo = $_FILES['imagen']['type'];
                    } else {
                        $tipo_archivo = '';
                    }
                    if (isset($_FILES['imagen']['size'])) {
                        $tamano_archivo = $_FILES['imagen']['size'];
                    } else {
                        $tamano_archivo = '';
                    }
                    //compruebo si las caracter�sticas del archivo son las que deseo
                    if ((strpos($tipo_archivo, 'image/jpeg') !== false) && $tamano_archivo < 50000) {
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombre_archivo) && rename("fotos/" . $nombre_archivo, "fotos/" . $_POST["cedula"] . ".jpg")) {
                            ## se puede dar un aviso
                        }
                        ## se puede dar otro aviso
                    }
                    ##################  FINALIZA SUBIR FOTO DE USUARIOS ######################################

                    echo "<div class='alert alert-info'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-check-square-o'></span> EL USUARIO FUE ACTUALIZADO EXITOSAMENTE";
                    echo "</div>";
                    exit;
                } else {
                    echo "5";
                    exit;
                }
            }
        }
    }
    ################################### FUNCION ACTUALIZAR USUARIOS ####################################

    ################################## FUNCION ELIMINAR USUARIOS ##################################
    public function EliminarUsuarios()
    {

        $sql = " select codigo from ventas where codigo = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codigo"])));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " delete from usuarios where codigo = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codigo);
            $codigo = base64_decode($_GET["codigo"]);
            $stmt->execute();

            header("Location: usuarios?mesage=1");
            exit;
        } else {

            header("Location: usuarios?mesage=2");
            exit;
        }
    }
    ################################### FUNCION ELIMINAR USUARIOS ##################################

    ##################################### FIN DE CLASE USUARIOS ####################################



























    ######################################## CLASE CONFIGURACION #######################################

    ###################################### FUNCION ID CONFIGURACION ##################################
    public function ConfiguracionPorId()
    {
        self::SetNames();
        $sql = " select * from configuracion where id = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array('1'));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID CONFIGURACION ##################################

    ############################### FUNCION ACTUALIZAR CONFIGURACION ###############################
    public function ActualizarConfiguracion()
    {

        if (empty($_POST["cedresponsable"]) or empty($_POST["nomresponsable"]) or empty($_POST["rucsucursal"]) or empty($_POST["razonsocial"]) or empty($_POST["tlfsucursal"])) {
            echo "1";
            exit;
        }

        $sql = " update configuracion set "
            . " cedresponsable = ?, "
            . " nomresponsable = ?, "
            . " celresponsable = ?, "
            . " rucsucursal = ?, "
            . " razonsocial = ?, "
            . " tlfsucursal = ?, "
            . " celsucursal = ?, "
            . " emailsucursal = ?, "
            . " direcsucursal = ?, "
            . " ivacsucursal = ?, "
            . " ivavsucursal = ?, "
            . " simbolo = ? "
            . " where "
            . " id = ?;
					";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $cedresponsable);
        $stmt->bindParam(2, $nomresponsable);
        $stmt->bindParam(3, $celresponsable);
        $stmt->bindParam(4, $rucsucursal);
        $stmt->bindParam(5, $razonsocial);
        $stmt->bindParam(6, $tlfsucursal);
        $stmt->bindParam(7, $celsucursal);
        $stmt->bindParam(8, $emailsucursal);
        $stmt->bindParam(9, $direcsucursal);
        $stmt->bindParam(10, $ivacsucursal);
        $stmt->bindParam(11, $ivavsucursal);
        $stmt->bindParam(12, $simbolo);
        $stmt->bindParam(13, $id);

        $cedresponsable = strip_tags($_POST["cedresponsable"]);
        $nomresponsable = strip_tags($_POST["nomresponsable"]);
        $celresponsable = strip_tags($_POST["celresponsable"]);
        $rucsucursal = strip_tags($_POST["rucsucursal"]);
        $razonsocial = strip_tags($_POST["razonsocial"]);
        $tlfsucursal = strip_tags($_POST["tlfsucursal"]);
        $celsucursal = strip_tags($_POST["celsucursal"]);
        $emailsucursal = strip_tags($_POST["emailsucursal"]);
        $direcsucursal = strip_tags($_POST["direcsucursal"]);
        $ivacsucursal = strip_tags($_POST["ivacsucursal"]);
        $ivavsucursal = strip_tags($_POST["ivavsucursal"]);
        $simbolo = strip_tags($_POST["simbolo"]);
        $id = strip_tags($_POST["id"]);
        $stmt->execute();


        echo "<div class='alert alert-info'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> LOS DATOS DE CONFIGURACION FUERON ACTUALIZADOS EXITOSAMENTE";
        echo "</div>";
        exit;
    }
    ############################## FUNCION ACTUALIZAR CONFIGURACION ###############################

    #################################### CLASE CONFIGURACION #######################################


































































    ######################################## CLASE SUCURSALES #########################################

    ################################## FUNCION CODIGO SUCURSAL ####################################
    public function NumeroSucursal()
    {
        self::SetNames();

        $sql = " select nrosucursal from sucursales order by nrosucursal desc limit 1";
        foreach ($this->dbh->query($sql) as $row) {

            $nrosucursal["nrosucursal"] = $row["nrosucursal"];
        }
        if (empty($nrosucursal["nrosucursal"])) {
            echo $nro = '001';
        } else {
            $resto = substr($nrosucursal["nrosucursal"], 0, 0);
            $coun = strlen($resto);
            $num     = substr($nrosucursal["nrosucursal"], $coun);
            $dig     = $num + 1;
            $codigo = str_pad($dig, 3, "0", STR_PAD_LEFT);
            echo $nro = $codigo;
        }
    }
    ################################## FUNCION CODIGO SUCURSAL ####################################


    ################################## FUNCION REGISTRAR SUCURSALES ################################
    public function RegistrarSucursal()
    {
        self::SetNames();
        if (empty($_POST["cedresponsable"]) or empty($_POST["nomresponsable"]) or empty($_POST["rucsucursal"]) or empty($_POST["razonsocial"]) or empty($_POST["tlfsucursal"])) {
            echo "1";
            exit;
        }
        $sql = " select rucsucursal from sucursales where rucsucursal = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["rucsucursal"]));
        $num = $stmt->rowCount();
        if ($num > 0) {

            echo "2";
            exit;
        } else {
            $sql = " select emailsucursal from sucursales where emailsucursal = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["emailsucursal"]));
            $num = $stmt->rowCount();
            if ($num > 0) {

                echo "3";
                exit;
            } else {

                $sql = " select razonsocial from sucursales where razonsocial = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_POST["razonsocial"]));
                $num = $stmt->rowCount();
                if ($num == 0) {
                    $query = " insert into sucursales values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $nrosucursal);
                    $stmt->bindParam(2, $cedresponsable);
                    $stmt->bindParam(3, $nomresponsable);
                    $stmt->bindParam(4, $celresponsable);
                    $stmt->bindParam(5, $rucsucursal);
                    $stmt->bindParam(6, $razonsocial);
                    $stmt->bindParam(7, $tlfsucursal);
                    $stmt->bindParam(8, $celsucursal);
                    $stmt->bindParam(9, $emailsucursal);
                    $stmt->bindParam(10, $direcsucursal);
                    $stmt->bindParam(11, $nroactividadsucursal);
                    $stmt->bindParam(12, $nroiniciofactura);
                    $stmt->bindParam(13, $fechaautorsucursal);
                    $stmt->bindParam(14, $ivacsucursal);
                    $stmt->bindParam(15, $ivavsucursal);
                    $stmt->bindParam(16, $descsucursal);
                    $stmt->bindParam(17, $llevacontabilidad);
                    $stmt->bindParam(18, $simbolo);

                    $nrosucursal = strip_tags($_POST["nrosucursal"]);
                    $cedresponsable = strip_tags($_POST["cedresponsable"]);
                    $nomresponsable = strip_tags($_POST["nomresponsable"]);
                    $celresponsable = strip_tags($_POST["celresponsable"]);
                    $rucsucursal = strip_tags($_POST["rucsucursal"]);
                    $razonsocial = strip_tags($_POST["razonsocial"]);
                    $tlfsucursal = strip_tags($_POST["tlfsucursal"]);
                    $celsucursal = strip_tags($_POST["celsucursal"]);
                    $emailsucursal = strip_tags($_POST["emailsucursal"]);
                    $direcsucursal = strip_tags($_POST["direcsucursal"]);
                    $nroactividadsucursal = strip_tags($_POST["nroactividadsucursal"]);
                    $nroiniciofactura = strip_tags($_POST["nroiniciofactura"]);
                    $fechaautorsucursal = strip_tags(date("Y-m-d", strtotime($_POST['fechaautorsucursal'])));
                    $ivacsucursal = strip_tags($_POST["ivacsucursal"]);
                    $ivavsucursal = strip_tags($_POST["ivavsucursal"]);
                    $descsucursal = strip_tags($_POST["descsucursal"]);
                    $llevacontabilidad = strip_tags($_POST["llevacontabilidad"]);
                    $simbolo = strip_tags($_POST["simbolo"]);
                    $stmt->execute();

                    ##################  SUBIR LOGO DE SUCURSAL ######################################
                    //datos del arhivo
                    if (isset($_FILES['imagen']['name'])) {
                        $nombre_archivo = $_FILES['imagen']['name'];
                    } else {
                        $nombre_archivo = '';
                    }
                    if (isset($_FILES['imagen']['type'])) {
                        $tipo_archivo = $_FILES['imagen']['type'];
                    } else {
                        $tipo_archivo = '';
                    }
                    if (isset($_FILES['imagen']['size'])) {
                        $tamano_archivo = $_FILES['imagen']['size'];
                    } else {
                        $tamano_archivo = '';
                    }
                    //compruebo si las caracter�sticas del archivo son las que deseo
                    if ((strpos($tipo_archivo, 'image/png') !== false) && $tamano_archivo < 200000) {
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombre_archivo) && rename("fotos/" . $nombre_archivo, "fotos/" . $_POST["rucsucursal"] . ".png")) {
                            ## se puede dar un aviso
                        }
                        ## se puede dar otro aviso
                    }
                    ##################  FINALIZA SUBIR LOGO DE SUCURSAL ######################################

                    echo "<div class='alert alert-success'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-check-square-o'></span> A SUCURSAL FUE REGISTRADA EXITOSAMENTE";
                    echo "</div>";
                    exit;
                } else {
                    echo "6";
                    exit;
                }
            }
        }
    }
    ################################# FUNCION REGISTRAR SUCURSALES ##################################

    ###################################### FUNCION LISTAR SUCURSALES ##################################
    public function ListarSucursal()
    {
        self::SetNames();
        $sql = " select * from sucursales ";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ###################################### FUNCION LISTAR SUCURSALES ##################################

    ########################### FUNCION ID REMISIONES ###############################
    public function RemisionesPorId()
    {
        self::SetNames();
        $sql = "SELECT
GROUP_CONCAT(DISTINCT sucursales.razonsocial SEPARATOR ',') AS sucursales
 FROM sucursales";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################### FUNCION ID REMISIONES ###############################


    ###################################### FUNCION ID SUCURSALES ##################################
    public function SucursalPorId()
    {
        self::SetNames();
        $sql = " select * from sucursales where codsucursal = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codsucursal"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID SUCURSALES ##################################

    ################################## FUNCION ACTUALIZAR SUCURSALES ##################################
    public function ActualizarSucursal()
    {

        if (empty($_POST["cedresponsable"]) or empty($_POST["nomresponsable"]) or empty($_POST["rucsucursal"]) or empty($_POST["razonsocial"]) or empty($_POST["tlfsucursal"])) {
            echo "1";
            exit;
        }
        self::SetNames();
        $sql = " select * from sucursales where codsucursal != ? and rucsucursal = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codsucursal"], $_POST["rucsucursal"]));
        $num = $stmt->rowCount();
        if ($num > 0) {
            echo "2";
            exit;
        } else {
            $sql = " select emailsucursal from sucursales where codsucursal != ? and emailsucursal = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codsucursal"], $_POST["emailsucursal"]));
            $num = $stmt->rowCount();
            if ($num > 0) {
                echo "3";
                exit;
            } else {

                $sql = " select razonsocial from sucursales where codsucursal != ? and razonsocial = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_POST["codsucursal"], $_POST["razonsocial"]));
                $num = $stmt->rowCount();
                if ($num == 0) {
                    $sql = " update sucursales set "
                        . " cedresponsable = ?, "
                        . " nomresponsable = ?, "
                        . " celresponsable = ?, "
                        . " rucsucursal = ?, "
                        . " razonsocial = ?, "
                        . " tlfsucursal = ?, "
                        . " celsucursal = ?, "
                        . " emailsucursal = ?, "
                        . " direcsucursal = ?, "
                        . " nroactividadsucursal = ?, "
                        . " nroiniciofactura = ?, "
                        . " fechaautorsucursal = ?, "
                        . " ivacsucursal = ?, "
                        . " ivavsucursal = ?, "
                        . " descsucursal = ?, "
                        . " llevacontabilidad = ?, "
                        . " simbolo = ? "
                        . " where "
                        . " codsucursal = ?;
					";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $cedresponsable);
                    $stmt->bindParam(2, $nomresponsable);
                    $stmt->bindParam(3, $celresponsable);
                    $stmt->bindParam(4, $rucsucursal);
                    $stmt->bindParam(5, $razonsocial);
                    $stmt->bindParam(6, $tlfsucursal);
                    $stmt->bindParam(7, $celsucursal);
                    $stmt->bindParam(8, $emailsucursal);
                    $stmt->bindParam(9, $direcsucursal);
                    $stmt->bindParam(10, $nroactividadsucursal);
                    $stmt->bindParam(11, $nroiniciofactura);
                    $stmt->bindParam(12, $fechaautorsucursal);
                    $stmt->bindParam(13, $ivacsucursal);
                    $stmt->bindParam(14, $ivavsucursal);
                    $stmt->bindParam(15, $descsucursal);
                    $stmt->bindParam(16, $llevacontabilidad);
                    $stmt->bindParam(17, $simbolo);
                    $stmt->bindParam(18, $codsucursal);

                    $cedresponsable = strip_tags($_POST["cedresponsable"]);
                    $nomresponsable = strip_tags($_POST["nomresponsable"]);
                    $celresponsable = strip_tags($_POST["celresponsable"]);
                    $rucsucursal = strip_tags($_POST["rucsucursal"]);
                    $razonsocial = strip_tags($_POST["razonsocial"]);
                    $tlfsucursal = strip_tags($_POST["tlfsucursal"]);
                    $celsucursal = strip_tags($_POST["celsucursal"]);
                    $emailsucursal = strip_tags($_POST["emailsucursal"]);
                    $direcsucursal = strip_tags($_POST["direcsucursal"]);
                    $nroactividadsucursal = strip_tags($_POST["nroactividadsucursal"]);
                    $nroiniciofactura = strip_tags($_POST["nroiniciofactura"]);
                    $fechaautorsucursal = strip_tags(date("Y-m-d", strtotime($_POST['fechaautorsucursal'])));
                    $ivacsucursal = strip_tags($_POST["ivacsucursal"]);
                    $ivavsucursal = strip_tags($_POST["ivavsucursal"]);
                    $descsucursal = strip_tags($_POST["descsucursal"]);
                    $llevacontabilidad = strip_tags($_POST["llevacontabilidad"]);
                    $simbolo = strip_tags($_POST["simbolo"]);
                    $codsucursal = strip_tags($_POST["codsucursal"]);
                    $stmt->execute();

                    ##################  SUBIR LOGO DE SUCURSAL ######################################
                    //datos del arhivo
                    if (isset($_FILES['imagen']['name'])) {
                        $nombre_archivo = $_FILES['imagen']['name'];
                    } else {
                        $nombre_archivo = '';
                    }
                    if (isset($_FILES['imagen']['type'])) {
                        $tipo_archivo = $_FILES['imagen']['type'];
                    } else {
                        $tipo_archivo = '';
                    }
                    if (isset($_FILES['imagen']['size'])) {
                        $tamano_archivo = $_FILES['imagen']['size'];
                    } else {
                        $tamano_archivo = '';
                    }
                    //compruebo si las caracter�sticas del archivo son las que deseo
                    if ((strpos($tipo_archivo, 'image/png') !== false) && $tamano_archivo < 200000) {
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombre_archivo) && rename("fotos/" . $nombre_archivo, "fotos/" . $_POST["rucsucursal"] . ".png")) {
                            ## se puede dar un aviso
                        }
                        ## se puede dar otro aviso
                    }
                    ##################  FINALIZA SUBIR LOGO DE SUCURSAL ######################################

                    echo "<div class='alert alert-info'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-check-square-o'></span> LA SUCURSAL FUE ACTUALIZADA EXITOSAMENTE";
                    echo "</div>";
                    exit;
                } else {
                    echo "4";
                    exit;
                }
            }
        }
    }
    ################################## FUNCION ACTUALIZAR SUCURSALES ##################################

    #################################### FUNCION ELIMINAR SUCURSALES ##################################
    public function EliminarSucursal()
    {

        $sql = " select codsucursal from ventas where codsucursal = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codsucursal"])));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " delete from sucursales where codsucursal = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codsucursal);
            $codsucursal = base64_decode($_GET["codsucursal"]);
            $stmt->execute();

            header("Location: sucursales?mesage=1");
            exit;
        } else {

            header("Location: sucursales?mesage=2");
            exit;
        }
    }
    ################################## FUNCION ELIMINAR SUCURSALES ##################################

    ################################# FIN DE CLASE SUCURSALES #####################################






































    ######################################## CLASE MEDIOS DE PAGO ######################################

    ################################# FUNCION REGISTRAR MEDIO DE PAGO ##################################
    public function RegistrarMediosPagos()
    {
        self::SetNames();
        if (empty($_POST["mediopago"])) {
            echo "1";
            exit;
        }
        $sql = " select mediopago from mediospagos where mediopago = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["mediopago"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into mediospagos values (null, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $mediopago);

            $mediopago = strip_tags(strtoupper($_POST["mediopago"]));
            $stmt->execute();


            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL MEDIO DE PAGO FUE REGISTRADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################### FUNCION REGISTRAR MEDIO DE PAGO ###############################

    ################################ FUNCION LISTAR MEDIO DE PAGO ##################################
    public function ListarMediosPagos()
    {
        self::SetNames();
        $sql = " select * from mediospagos";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################## FUNCION LISTAR MEDIO DE PAGO ##################################

    public function ListarTiposDocumento()
    {
        self::SetNames();
        $sql = " select * from tipo_documento";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }

    ################################## FUNCION ID MEDIO DE PAGO ##################################
    public function MediosPagosPorId()
    {
        self::SetNames();
        $sql = " select * from mediospagos where codmediopago = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codmediopago"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION ID MEDIO DE PAGO ##################################

    ################################# FUNCION ID MEDIO DE PAGO #2 ##################################
    public function MediosPagosId()
    {
        self::SetNames();
        $sql = " select * from mediospagos where codmediopago = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["formapagove"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION ID MEDIO DE PAGO #2 #################################

    ################################ FUNCION ACTUALIZAR MEDIO DE PAGO ###############################
    public function ActualizarMediosPagos()
    {

        self::SetNames();
        if (empty($_POST["codmediopago"]) or empty($_POST["mediopago"])) {
            echo "1";
            exit;
        }
        $sql = " select mediopago from mediospagos where codmediopago != ? and mediopago = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codmediopago"], $_POST["mediopago"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $sql = " update mediospagos set "
                . " mediopago = ? "
                . " where "
                . " codmediopago = ?;
				";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $mediopago);
            $stmt->bindParam(2, $codmediopago);

            $mediopago = strip_tags(strtoupper($_POST["mediopago"]));
            $codmediopago = strip_tags(strtoupper($_POST["codmediopago"]));
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL MEDIO DE PAGO FUE ACTUALIZADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################## FUNCION ACTUALIZAR MEDIO DE PAGO ##############################

    ############################## FUNCION ELIMINAR MEDIO DE PAGO ##################################
    public function EliminarMediosPagos()
    {

        $sql = " select formapagove from ventas where formapagove = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codmediopago"])));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " delete from mediospagos where codmediopago = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codmediopago);
            $codmediopago = base64_decode($_GET["codmediopago"]);
            $stmt->execute();

            header("Location: mediospagos?mesage=1");
            exit;
        } else {

            header("Location: mediospagos?mesage=2");
            exit;
        }
    }
    ################################# FUNCION ELIMINAR MEDIO DE PAGO ##################################

    ################################### FIN DE CLASE MEDIOS DE PAGO ###############################






































    ######################################## CLASE ENTIDADES BANCARIAS ######################################

    ################################# FUNCION REGISTRAR ENTIDADES BANCARIAS ##################################
    public function RegistrarBancos()
    {
        self::SetNames();
        if (empty($_POST["nombanco"])) {
            echo "1";
            exit;
        }
        $sql = " select nombanco from bancos where nombanco = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["nombanco"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into bancos values (null, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $nombanco);

            $nombanco = strip_tags(strtoupper($_POST["nombanco"]));
            $stmt->execute();


            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA ENTIDAD BANCARIA FUE REGISTRADA EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################### FUNCION REGISTRAR ENTIDADES BANCARIAS ###############################

    ################################ FUNCION LISTAR ENTIDADES BANCARIAS ##################################
    public function ListarBancos()
    {
        self::SetNames();
        $sql = " select * from bancos";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################## FUNCION LISTAR ENTIDADES BANCARIAS ##################################

    ################################## FUNCION ID ENTIDADES BANCARIAS ##################################
    public function BancosPorId()
    {
        self::SetNames();
        $sql = " select * from bancos where codbanco = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codbanco"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION ID ENTIDADES BANCARIAS ##################################

    ################################# FUNCION ID ENTIDADES BANCARIAS #2 ##################################
    public function BancosId()
    {
        self::SetNames();
        $sql = " select * from bancos where codbanco = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codbanco"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION ID ENTIDADES BANCARIAS #2 #################################

    ################################ FUNCION ACTUALIZAR ENTIDADES BANCARIAS ###############################
    public function ActualizarBancos()
    {

        self::SetNames();
        if (empty($_POST["codbanco"]) or empty($_POST["nombanco"])) {
            echo "1";
            exit;
        }
        $sql = " select nombanco from bancos where codbanco != ? and nombanco = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codbanco"], $_POST["nombanco"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $sql = " update bancos set "
                . " nombanco = ? "
                . " where "
                . " codbanco = ?;
				";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $nombanco);
            $stmt->bindParam(2, $codbanco);

            $nombanco = strip_tags(strtoupper($_POST["nombanco"]));
            $codbanco = strip_tags(strtoupper($_POST["codbanco"]));
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA ENTIDAD BANCARIA FUE ACTUALIZADA EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################## FUNCION ACTUALIZAR ENTIDADES BANCARIAS ##############################

    ############################## FUNCION ELIMINAR ENTIDADES BANCARIAS ##################################
    public function EliminarBancos()
    {

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " select codbanco from tipostarjetas where codbanco = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codbanco"])));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " delete from bancos where codbanco = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codbanco);
                $codbanco = base64_decode($_GET["codbanco"]);
                $stmt->execute();

                header("Location: bancos?mesage=1");
                exit;
            } else {

                header("Location: bancos?mesage=2");
                exit;
            }
        } else {

            header("Location: bancos?mesage=3");
            exit;
        }
    }
    ################################# FUNCION ELIMINAR ENTIDADES BANCARIAS ##################################

    ################################### FIN DE CLASE ENTIDADES BANCARIAS ###############################





































    ######################################## CLASE TIPOS DE TARJETAS ######################################

    ################################# FUNCION REGISTRAR TIPOS DE TARJETAS ##################################
    public function RegistrarTarjetas()
    {
        self::SetNames();
        if (empty($_POST["codbanco"]) or empty($_POST["nomtarjeta"])) {
            echo "1";
            exit;
        }
        $sql = " select * from tipostarjetas where codbanco = ? and nomtarjeta = ? and tipotarjeta = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codbanco"], $_POST["nomtarjeta"], $_POST["tipotarjeta"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into tipostarjetas values (null, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $codbanco);
            $stmt->bindParam(2, $nomtarjeta);
            $stmt->bindParam(3, $tipotarjeta);

            $codbanco = strip_tags($_POST["codbanco"]);
            $nomtarjeta = strip_tags($_POST["nomtarjeta"]);
            $tipotarjeta = strip_tags($_POST["tipotarjeta"]);
            $stmt->execute();


            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL TIPO DE TARJETA FUE REGISTRADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################### FUNCION REGISTRAR TIPOS DE TARJETAS ###############################

    ################################ FUNCION LISTAR TIPOS DE TARJETAS ##################################
    public function ListarTarjetas()
    {
        self::SetNames();
        $sql = " SELECT * from tipostarjetas INNER JOIN bancos ON tipostarjetas.codbanco = bancos.codbanco";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################## FUNCION LISTAR TIPOS DE TARJETAS ##################################

    ############################ FUNCION LISTAR TARJETAS POR BANCOS #############################
    public function ListarTarjetasBancos()
    {
        self::SetNames();
        $sql = "select * from tipostarjetas where codbanco = ? and tipotarjeta = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codbanco"], $_GET["tipotarjeta"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<select name='codtarjeta' id='codtarjeta' disabled class='form-control' required=''  aria-required='true'>";
            echo "<option value=''>SELECCIONE</option>";
            echo "</select>";
            exit;
        } else {
            while ($row = $stmt->fetch()) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################ FUNCION LISTAR TARJETAS POR BANCOS #############################

    ############################ FUNCION LISTAR TARJETAS POR BANCOS #2 ############################
    public function ListarTarjetasxBancos()
    {
        self::SetNames();
        $sql = "select * from tipostarjetas where codbanco = ? and tipotarjeta = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codbanco"], $_GET["tipotarjeta"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<option value='' disabled selected>SELECCIONE</option>";
            exit;
        } else {
            while ($row = $stmt->fetch()) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################ FUNCION LISTAR TARJETAS POR BANCOS #2 ############################

    ################################## FUNCION ID TIPOS DE TARJETAS ##################################
    public function TarjetasPorId()
    {
        self::SetNames();
        $sql = " select * from tipostarjetas where codtarjeta = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codtarjeta"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION ID TIPOS DE TARJETAS ##################################

    ################################# FUNCION ID TIPOS DE TARJETAS #2 ##################################
    public function TarjetasId()
    {
        self::SetNames();
        $sql = " select * from tipostarjetas where codtarjeta = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codtarjeta"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION ID TIPOS DE TARJETAS #2 #################################

    ################################ FUNCION ACTUALIZAR TIPOS DE TARJETAS ###############################
    public function ActualizarTarjetas()
    {

        self::SetNames();
        if (empty($_POST["codtarjeta"]) or empty($_POST["nomtarjeta"]) or empty($_POST["tipotarjeta"])) {
            echo "1";
            exit;
        }
        $sql = " select * from tipostarjetas where codtarjeta != ? and codbanco = ? and nomtarjeta = ? and tipotarjeta = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codtarjeta"], $_POST["codbanco"], $_POST["nomtarjeta"], $_POST["tipotarjeta"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $sql = " update tipostarjetas set "
                . " codbanco = ?, "
                . " nomtarjeta = ?, "
                . " tipotarjeta = ? "
                . " where "
                . " codtarjeta = ?;
				";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codbanco);
            $stmt->bindParam(2, $nomtarjeta);
            $stmt->bindParam(3, $tipotarjeta);
            $stmt->bindParam(4, $codtarjeta);

            $codbanco = strip_tags($_POST["codbanco"]);
            $nomtarjeta = strip_tags($_POST["nomtarjeta"]);
            $tipotarjeta = strip_tags($_POST["tipotarjeta"]);
            $codtarjeta = strip_tags($_POST["codtarjeta"]);
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL TIPO DE TARJETA FUE ACTUALIZADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################## FUNCION ACTUALIZAR TIPOS DE TARJETAS ##############################

    ############################## FUNCION ELIMINAR TIPOS DE TARJETAS ##################################
    public function EliminarTarjetas()
    {

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " select codtarjeta from intereses where codtarjeta = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codtarjeta"])));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " delete from tipostarjetas where codtarjeta = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codbanco);
                $codbanco = base64_decode($_GET["codtarjeta"]);
                $stmt->execute();

                header("Location: tarjetas?mesage=1");
                exit;
            } else {

                header("Location: tarjetas?mesage=2");
                exit;
            }
        } else {

            header("Location: tarjetas?mesage=3");
            exit;
        }
    }
    ################################# FUNCION ELIMINAR TIPOS DE TARJETAS ##################################

    ################################### FIN DE CLASE TIPOS DE TARJETAS ###############################




































    ############################### CLASE INTERES EN TARJETAS ##############################

    ############################ FUNCION REGISTRAR INTERES EN TARJETAS ##############################
    public function RegistrarIntereses()
    {
        self::SetNames();
        if (empty($_POST["codbanco"]) or empty($_POST["codtarjeta"]) or empty($_POST["tasasi"])) {
            echo "1";
            exit;
        }

        if ($_POST["tipotarjeta"] == "DEBITO") {

            $sql = " select * from intereses where codbanco = ? and codtarjeta = ? and tipotarjeta = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codbanco"], $_POST["codtarjeta"], $_POST["tipotarjeta"]));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $query = " insert into intereses values (null, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codbanco);
                $stmt->bindParam(2, $codtarjeta);
                $stmt->bindParam(3, $meses);
                $stmt->bindParam(4, $tasasi);
                $stmt->bindParam(5, $tasano);
                $stmt->bindParam(6, $tipotarjeta);

                $codbanco = strip_tags(strtoupper($_POST["codbanco"]));
                $codtarjeta = strip_tags(strtoupper($_POST["codtarjeta"]));
                if (strip_tags(isset($_POST['meses']))) {
                    $meses = strip_tags($_POST['meses']);
                } else {
                    $meses = '0';
                }
                $tasasi = strip_tags(strtoupper($_POST["tasasi"]));
                if (strip_tags(isset($_POST['tasano']))) {
                    $tasano = strip_tags($_POST['tasano']);
                } else {
                    $tasano = '0.00';
                }
                $tipotarjeta = strip_tags(strtoupper($_POST["tipotarjeta"]));
                $stmt->execute();

                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA TASA DE INTERES EN LA TARJETA DE DEBITO FUE REGISTRADO EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "2";
                exit;
            }
        } elseif ($_POST["tipotarjeta"] == "CREDITO") {

            $sql = " select * from intereses where codbanco = ? and codtarjeta = ? and meses = ? and tipotarjeta = ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codbanco"], $_POST["codtarjeta"], $_POST["meses"], $_POST["tipotarjeta"]));
            $num = $stmt->rowCount();
            if ($num == 0) {
                $query = " insert into intereses values (null, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codbanco);
                $stmt->bindParam(2, $codtarjeta);
                $stmt->bindParam(3, $meses);
                $stmt->bindParam(4, $tasasi);
                $stmt->bindParam(5, $tasano);
                $stmt->bindParam(6, $tipotarjeta);

                $codbanco = strip_tags(strtoupper($_POST["codbanco"]));
                $codtarjeta = strip_tags(strtoupper($_POST["codtarjeta"]));
                if (strip_tags(isset($_POST['meses']))) {
                    $meses = strip_tags($_POST['meses']);
                } else {
                    $meses = '0';
                }
                $tasasi = strip_tags(strtoupper($_POST["tasasi"]));
                if (strip_tags(isset($_POST['tasano']))) {
                    $tasano = strip_tags($_POST['tasano']);
                } else {
                    $tasano = '0.00';
                }
                $tipotarjeta = strip_tags(strtoupper($_POST["tipotarjeta"]));
                $stmt->execute();

                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA TASA DE INTERES EN LA TARJETA DE CREDITO FUE REGISTRADO EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "3";
                exit;
            }
        }
    }
    ########################### FUNCION REGISTRAR INTERES EN TARJETAS ###########################

    ########################### FUNCION LISTAR INTERES EN TARJETAS ##############################
    public function ListarIntereses()
    {
        self::SetNames();
        $sql = " SELECT * from intereses INNER JOIN tipostarjetas ON intereses.codtarjeta = tipostarjetas.codtarjeta INNER JOIN bancos ON intereses.codbanco = bancos.codbanco";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ############################## FUNCION LISTAR INTERES EN TARJETAS ##############################

    ############################# FUNCION ID INTERES EN TARJETAS ###############################
    public function CargaInteresesId()
    {
        self::SetNames();
        $sql = " select * from intereses where codbanco = ? and codtarjeta = ? and meses = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codbanco"], $_GET["codtarjeta"], $_GET["meses"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################### FUNCION ID INTERES EN TARJETAS ##################################

    ############################## FUNCION CARGAR MESES EN TARJETAS ##############################
    public function CargarMesesTarjetas()
    {
        self::SetNames();
        $sql = " select * from intereses where codbanco = ? and codtarjeta = ? ORDER BY meses ASC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codbanco"], $_GET["codtarjeta"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
            exit;
        } else {
            while ($row = $stmt->fetch()) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################## FUNCION CARGAR MESES EN TARJETAS ##############################

    ############################# FUNCION ID INTERES EN TARJETAS ###############################
    public function InteresesPorId()
    {
        self::SetNames();
        $sql = " select * from intereses where codinteres = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codinteres"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################### FUNCION ID INTERES EN TARJETAS ##################################

    ########################### FUNCION ACTUALIZAR INTERES EN TARJETAS #############################
    public function ActualizarIntereses()
    {

        self::SetNames();
        if (empty($_POST["codinteres"]) or empty($_POST["codbanco"]) or empty($_POST["codtarjeta"]) or empty($_POST["tasasi"])) {
            echo "1";
            exit;
        }

        if ($_POST["tipotarjeta"] == "DEBITO") {

            $sql = " select * from intereses where codinteres != ? and codbanco = ? and codtarjeta = ? and tipotarjeta = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codinteres"], $_POST["codbanco"], $_POST["codtarjeta"], $_POST["tipotarjeta"]));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " update intereses set "
                    . " codbanco = ?, "
                    . " codtarjeta = ?, "
                    . " meses = ?, "
                    . " tasasi = ?, "
                    . " tasano = ?, "
                    . " tipotarjeta = ? "
                    . " where "
                    . " codinteres = ?;
				";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codbanco);
                $stmt->bindParam(2, $codtarjeta);
                $stmt->bindParam(3, $meses);
                $stmt->bindParam(4, $tasasi);
                $stmt->bindParam(5, $tasano);
                $stmt->bindParam(6, $tipotarjeta);
                $stmt->bindParam(7, $codinteres);

                $codbanco = strip_tags(strtoupper($_POST["codbanco"]));
                $codtarjeta = strip_tags(strtoupper($_POST["codtarjeta"]));
                if (strip_tags(isset($_POST['meses']))) {
                    $meses = strip_tags($_POST['meses']);
                } else {
                    $meses = '0';
                }
                $tasasi = strip_tags(strtoupper($_POST["tasasi"]));
                if (strip_tags(isset($_POST['tasano']))) {
                    $tasano = strip_tags($_POST['tasano']);
                } else {
                    $tasano = '0.00';
                }
                $tipotarjeta = strip_tags(strtoupper($_POST["tipotarjeta"]));
                $codinteres = strip_tags(strtoupper($_POST["codinteres"]));
                $stmt->execute();

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA TASA DE INTERES EN LA TARJETA DE DEBITO FUE ACTUALIZADO EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "2";
                exit;
            }
        } elseif ($_POST["tipotarjeta"] == "CREDITO") {

            $sql = " select * from intereses where codinteres != ? and codbanco = ? and codtarjeta = ? and meses = ? and tipotarjeta = ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codinteres"], $_POST["codbanco"], $_POST["codtarjeta"], $_POST["meses"], $_POST["tipotarjeta"]));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " update intereses set "
                    . " codbanco = ?, "
                    . " codtarjeta = ?, "
                    . " meses = ?, "
                    . " tasasi = ?, "
                    . " tasano = ?, "
                    . " tipotarjeta = ? "
                    . " where "
                    . " codinteres = ?;
				";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codbanco);
                $stmt->bindParam(2, $codtarjeta);
                $stmt->bindParam(3, $meses);
                $stmt->bindParam(4, $tasasi);
                $stmt->bindParam(5, $tasano);
                $stmt->bindParam(6, $tipotarjeta);
                $stmt->bindParam(7, $codinteres);

                $codbanco = strip_tags(strtoupper($_POST["codbanco"]));
                $codtarjeta = strip_tags(strtoupper($_POST["codtarjeta"]));
                if (strip_tags(isset($_POST['meses']))) {
                    $meses = strip_tags($_POST['meses']);
                } else {
                    $meses = '0';
                }
                $tasasi = strip_tags(strtoupper($_POST["tasasi"]));
                if (strip_tags(isset($_POST['tasano']))) {
                    $tasano = strip_tags($_POST['tasano']);
                } else {
                    $tasano = '0.00';
                }
                $tipotarjeta = strip_tags(strtoupper($_POST["tipotarjeta"]));
                $codinteres = strip_tags(strtoupper($_POST["codinteres"]));
                $stmt->execute();

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA TASA DE INTERES EN LA TARJETA DE CREDITO FUE ACTUALIZADO EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "3";
                exit;
            }
        }
    }
    ############################## FUNCION ACTUALIZAR INTERES EN TARJETAS ##########################

    ############################## FUNCION ELIMINAR INTERES EN TARJETAS #############################
    public function EliminarIntereses()
    {

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " delete from tarjetascreditos where codtarjetac = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codtarjetac);
            $codtarjetac = base64_decode($_GET["codtarjetac"]);
            $stmt->execute();

            header("Location: intereses?mesage=1");
            exit;
        } else {

            header("Location: intereses?mesage=2");
            exit;
        }
    }
    ############################ FUNCION ELIMINAR INTERES EN TARJETAS ##############################

    ################################### FIN DE CLASE INTERES EN TARJETAS ###############################









































    ############################## CLASE UNIDAD DE MEDIDAS DE PRODUCTOS ###############################

    ############################# FUNCION REGISTRAR UNIDAD DE MEDIDAS ###############################
    public function RegistrarMedidas()
    {
        self::SetNames();
        if (empty($_POST["nommedida"])) {
            echo "1";
            exit;
        }
        $sql = " select nommedida from medidas where nommedida = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["nommedida"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into medidas values (null, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $nommedida);

            $nommedida = strip_tags($_POST["nommedida"]);
            $stmt->execute();


            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA UNIDAD DE MEDIDA DE PRODUCTO FUE REGISTRADA EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################# FUNCION REGISTRAR UNIDAD DE MEDIDAS ##############################

    ############################ FUNCION LISTAR UNIDAD DE MEDIDAS ###############################
    public function ListarMedidas()
    {
        self::SetNames();
        $sql = " select * from medidas ORDER BY nommedida";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ############################## FUNCION LISTAR UNIDAD DE MEDIDAS ###############################

    ############################### FUNCION ID UNIDAD DE MEDIDAS ##################################
    public function MedidasPorId()
    {
        self::SetNames();
        $sql = " select * from medidas where codmedida = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codmedida"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION ID UNIDAD DE MEDIDAS ##################################

    ############################## FUNCION ACTUALIZAR UNIDAD DE MEDIDAS ###############################
    public function ActualizarMedidas()
    {

        self::SetNames();
        if (empty($_POST["codmedida"]) or empty($_POST["nommedida"])) {
            echo "1";
            exit;
        }
        $sql = " select nommedida from medidas where codmedida != ? and nommedida = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codmedida"], $_POST["nommedida"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $sql = " update medidas set "
                . " nommedida = ? "
                . " where "
                . " codmedida = ?;
			";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $nommedida);
            $stmt->bindParam(2, $codmedida);

            $codmedida = strip_tags($_POST["codmedida"]);
            $nommedida = strip_tags($_POST["nommedida"]);
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA UNIDAD DE MEDIDA DE PRODUCTO FUE ACTUALIZADA EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ################################ FUNCION ACTUALIZAR UNIDAD DE MEDIDAS ##############################

    ############################# FUNCION ELIMINAR UNIDAD DE MEDIDAS ##################################
    public function EliminarMedidas()
    {

        $sql = " select codmedida from productos where codmedida = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codmedida"])));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " delete from medidas where codmedida = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codcategoria);
            $codcategoria = base64_decode($_GET["codmedida"]);
            $stmt->execute();

            header("Location: medidas?mesage=1");
            exit;
        } else {

            header("Location: medidas?mesage=2");
            exit;
        }
    }
    ########################## FUNCION ELIMINAR UNIDAD DE MEDIDAS ##############################

    ######################### FIN DE CLASE UNIDAD DE MEDIDAS DE PRODUCTOS #########################









































    ############################## CLASE PRESENTACIONES DE PRODUCTOS ##################################

    ############################## FUNCION REGISTRAR PRESENTACIONES ##############################
    public function RegistrarPresentacion()
    {
        self::SetNames();
        if (empty($_POST["nompresentacion"])) {
            echo "1";
            exit;
        }
        $sql = " select nompresentacion from presentaciones where nompresentacion = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["nompresentacion"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into presentaciones values (null, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $nompresentacion);

            $nompresentacion = strip_tags($_POST["nompresentacion"]);
            $stmt->execute();


            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA PRESENTACI&Oacute;N DE PRODUCTO FUE REGISTRADA EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################### FUNCION REGISTRAR PRESENTACIONES ##############################

    ############################### FUNCION LISTAR PRESENTACIONES ##################################
    public function ListarPresentacion()
    {
        self::SetNames();
        $sql = " select * from presentaciones ORDER BY nompresentacion";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################## FUNCION LISTAR PRESENTACIONES ##################################

    ################################## FUNCION ID PRESENTACIONES ##################################
    public function PresentacionPorId()
    {
        self::SetNames();
        $sql = " select * from presentaciones where codpresentacion = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codpresentacion"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################### FUNCION ID PRESENTACIONES ##################################

    ############################## FUNCION ACTUALIZAR PRESENTACIONES ##################################
    public function ActualizarPresentacion()
    {

        self::SetNames();
        if (empty($_POST["codpresentacion"]) or empty($_POST["nompresentacion"])) {
            echo "1";
            exit;
        }
        $sql = " select nompresentacion from presentaciones where codpresentacion != ? and nompresentacion = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codpresentacion"], $_POST["nompresentacion"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $sql = " update presentaciones set "
                . " nompresentacion = ? "
                . " where "
                . " codpresentacion = ?;
			";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $nompresentacion);
            $stmt->bindParam(2, $codpresentacion);

            $codpresentacion = strip_tags($_POST["codpresentacion"]);
            $nompresentacion = strip_tags($_POST["nompresentacion"]);
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA PRESENTACI&Oacute;N DE PRODUCTO FUE ACTUALIZADA EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################# FUNCION ACTUALIZAR PRESENTACIONES ##############################

    ############################## FUNCION ELIMINAR PRESENTACIONES ##################################
    public function EliminarPresentacion()
    {

        $sql = " select codpresentacion from productos where codpresentacion = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codpresentacion"])));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " delete from presentaciones where codpresentacion = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codpresentacion);
            $codpresentacion = base64_decode($_GET["codpresentacion"]);
            $stmt->execute();

            header("Location: presentaciones?mesage=1");
            exit;
        } else {

            header("Location: presentaciones?mesage=2");
            exit;
        }
    }
    ############################## FUNCION ELIMINAR PRESENTACIONES ###############################

    ########################### FIN DE CLASE PRESENTACIONES DE PRODUCTOS ############################









































    ####################################### CLASE CAJAS DE VENTAS ######################################

    ###################################### FUNCION CODIGO PRODUCTO ##################################
    public function CodigoCaja()
    {
        self::SetNames();

        $sql = " select nrocaja from cajas order by nrocaja desc limit 1";
        foreach ($this->dbh->query($sql) as $row) {

            $nrocaja["nrocaja"] = $row["nrocaja"];
        }
        if (empty($nrocaja["nrocaja"])) {
            echo $nro = '001';
        } else {
            $resto = substr($nrocaja["nrocaja"], 0, -0);
            $coun = strlen($resto);
            $num     = substr($nrocaja["nrocaja"], $coun);
            $dig     = $num + 1;
            $codigo = str_pad($dig, 3, "0", STR_PAD_LEFT);
            echo $nro = $codigo;
        }
    }
    ################################### FUNCION CODIGO PRODUCTO ##################################

    ###################################### FUNCION REGISTRAR CAJAS ##################################
    public function RegistrarCajas()
    {
        self::SetNames();
        if (empty($_POST["nrocaja"]) or empty($_POST["nombrecaja"])) {
            echo "1";
            exit;
        }
        $sql = " select nrocaja from cajas where nrocaja = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["nrocaja"]));
        $num = $stmt->rowCount();
        if ($num > 0) {
            echo "2";
            exit;
        } else {
            $sql = " select codigo from cajas where codigo = ? and codigo != ''";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codigo"]));
            $num = $stmt->rowCount();
            if ($num == 0) {
                $query = " insert into cajas values (null, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $nrocaja);
                $stmt->bindParam(2, $nombrecaja);
                $stmt->bindParam(3, $codigo);

                $nrocaja = strip_tags($_POST["nrocaja"]);
                $nombrecaja = strip_tags($_POST["nombrecaja"]);
                $codigo = strip_tags($_POST["codigo"]);
                $stmt->execute();

                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA FUE REGISTRADA EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "3";
                exit;
            }
        }
    }
    ###################################### FUNCION REGISTRAR CAJAS ##################################

    ###################################### FUNCION LISTAR CAJAS ##################################
    public function ListarCajas()
    {
        self::SetNames();
        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " select * from cajas LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " select * from cajas LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE usuarios.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION LISTAR CAJAS ##################################

    ################################## FUNCION LISTAR CAJAS ABIERTAS ##################################
    public function ListarCajasAbiertas()
    {
        self::SetNames();
        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " select * from cajas INNER JOIN arqueocaja ON cajas.codcaja = arqueocaja.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE arqueocaja.statusarqueo = '1'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " select * from cajas INNER JOIN arqueocaja ON cajas.codcaja = arqueocaja.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE usuarios.codsucursal = '" . $_SESSION["codsucursal"] . "' AND arqueocaja.statusarqueo = '1'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################### FUNCION LISTAR CAJAS ABIERTAS ##################################

    ################################## FUNCION CARGA CAJAS POR SUCURSAL ###############################
    public function ListarCajasSucursal()
    {
        self::SetNames();
        $sql = " SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo INNER JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE sucursales.codsucursal = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codsucursal"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<option value=''>SELECCIONE</option>";
            exit;
        } else {
            while ($row = $stmt->fetch()) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################## FUNCION CARGA CAJAS POR SUCURSAL ###############################

    ###################################### FUNCION ID CAJAS ##################################
    public function CajaPorId()
    {
        self::SetNames();
        $sql = " select * from cajas LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codcaja = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codcaja"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID CAJAS ##################################

    ###################################### FUNCION ID CAJAS #2 #################################
    public function CajerosPorId()
    {
        self::SetNames();
        $sql = " select * from cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codcaja = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codcaja"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID CAJAS #2 #################################

    ###################################### FUNCION ACTUALIZAR CAJAS ##################################
    public function ActualizarCaja()
    {
        self::SetNames();
        if (empty($_POST["codcaja"])) {
            echo "1";
            exit;
        }
        $sql = " select nrocaja from cajas where codcaja != ? and nrocaja = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codcaja"], $_POST["nrocaja"]));
        $num = $stmt->rowCount();
        if ($num > 0) {
            echo "2";
            exit;
        } else {
            $sql = " select codigo from cajas where codcaja != ? and codigo = ? and codigo != 0";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codcaja"], $_POST["codigo"]));
            $num = $stmt->rowCount();
            if ($num == 0) {
                $sql = " update cajas set "
                    . " nrocaja = ?, "
                    . " nombrecaja = ?, "
                    . " codigo = ? "
                    . " where "
                    . " codcaja = ?;
					";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $nrocaja);
                $stmt->bindParam(2, $nombrecaja);
                $stmt->bindParam(3, $codigo);
                $stmt->bindParam(4, $codcaja);

                $nrocaja = strip_tags($_POST["nrocaja"]);
                $nombrecaja = strip_tags($_POST["nombrecaja"]);
                $codigo = strip_tags($_POST["codigo"]);
                $codcaja = strip_tags($_POST["codcaja"]);
                $stmt->execute();

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA CAJA DE VENTA FUE ACTUALIZADA EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "3";
                exit;
            }
        }
    }
    ###################################### FUNCION ACTUALIZAR CAJAS ##################################

    ###################################### FUNCION ELIMINAR CAJAS ##################################
    public function EliminarCaja()
    {

        $sql = " select codcaja from ventas where codcaja = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codcaja"])));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " delete from cajas where codcaja = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codcaja);
            $codcaja = base64_decode($_GET["codcaja"]);
            $stmt->execute();

            header("Location: cajas?mesage=1");
            exit;
        } else {

            header("Location: cajas?mesage=2");
            exit;
        }
    }
    ################################### FUNCION ELIMINAR CAJAS ##################################

    ############################### FIN DE CLASE CAJAS DE VENTAS##################################






























    ################################# CLASE LABORATORIOS  #######################################

    ################################# FUNCION REGISTRAR LABORATORIOS ##################################
    public function RegistrarLaboratorios()
    {
        self::SetNames();
        if (empty($_POST["nomlaboratorio"]) or empty($_POST["aplicadescuento"]) or empty($_POST["desclaboratorio"]) or empty($_POST["recargotc"])) {
            echo "1";
            exit;
        }
        $sql = " select nomlaboratorio from laboratorios where nomlaboratorio = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["nomlaboratorio"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into laboratorios values (null, ?, ?, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $nomlaboratorio);
            $stmt->bindParam(2, $aplicadescuento);
            $stmt->bindParam(3, $desclaboratorio);
            $stmt->bindParam(4, $recargotc);
            $stmt->bindParam(5, $fecharegistro);

            $nomlaboratorio = strip_tags($_POST["nomlaboratorio"]);
            $aplicadescuento = strip_tags($_POST["aplicadescuento"]);
            if (strip_tags($_POST['aplicadescuento'] == "NO")) {
                $desclaboratorio = strip_tags("0.00");
            } else {
                $desclaboratorio = strip_tags($_POST["desclaboratorio"]);
            }
            $recargotc = strip_tags($_POST["recargotc"]);
            $fecharegistro = strip_tags(date("Y-m-d"));
            $stmt->execute();

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL LABORATORIO FUE REGISTRADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ################################# FUNCION REGISTRAR LABORATORIOS ##################################

    ################################ FUNCION LISTRA LABORATORIOS ##################################
    public function ListarLaboratorios()
    {
        self::SetNames();
        $sql = " select * from laboratorios ORDER BY nomlaboratorio";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################# FUNCION REGISTRAR LABORATORIOS ##################################

    ###################################### FUNCION ID LABORATORIOS ##################################
    public function LaboratoriosPorId()
    {
        self::SetNames();
        $sql = " select * from laboratorios where codlaboratorio = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codlaboratorio"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    #################################### FUNCION ID LABORATORIOS ##################################

    #################################### FUNCION ID LABORATORIOS #2 #################################
    public function LaboratorioPorId()
    {
        self::SetNames();
        $sql = " select * from laboratorios where codlaboratorio = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codlaboratorio"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID LABORATORIOS #2 #################################

    ################################# FUNCION ACTUALIZAR LABORATORIOS ##################################
    public function ActualizarLaboratorios()
    {
        self::SetNames();
        if (empty($_POST["nomlaboratorio"]) or empty($_POST["aplicadescuento"]) or empty($_POST["desclaboratorio"]) or empty($_POST["recargotc"])) {
            echo "1";
            exit;
        }

        $sql = " select nomlaboratorio from laboratorios where codlaboratorio != ? and nomlaboratorio = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codlaboratorio"], $_POST["nomlaboratorio"]));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " update laboratorios set "
                . " nomlaboratorio = ?, "
                . " aplicadescuento = ?, "
                . " desclaboratorio = ?, "
                . " recargotc = ? "
                . " where "
                . " codlaboratorio = ?;
				";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $nomlaboratorio);
            $stmt->bindParam(2, $aplicadescuento);
            $stmt->bindParam(3, $desclaboratorio);
            $stmt->bindParam(4, $recargotc);
            $stmt->bindParam(5, $codlaboratorio);

            $nomlaboratorio = strip_tags($_POST["nomlaboratorio"]);
            $aplicadescuento = strip_tags($_POST["aplicadescuento"]);
            if (strip_tags($_POST['aplicadescuento'] == "NO")) {
                $desclaboratorio = strip_tags("0.00");
            } else {
                $desclaboratorio = strip_tags($_POST["desclaboratorio"]);
            }
            $recargotc = strip_tags($_POST["recargotc"]);
            $codlaboratorio = strip_tags($_POST["codlaboratorio"]);
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL LABORATORIO FUE ACTUALIZADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ################################# FUNCION ACTUALIZAR LABORATORIOS ##################################

    ################################# FUNCION ELIMINAR LABORATORIOS ##################################
    public function EliminarLaboratorios()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            $sql = " select codlaboratorio from productos where codlaboratorio = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codlaboratorio"])));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " delete from laboratorios where codlaboratorio = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codlaboratorio);
                $codlaboratorio = base64_decode($_GET["codlaboratorio"]);
                $stmt->execute();

                header("Location: laboratorios?mesage=1");
                exit;
            } else {

                header("Location: laboratorios?mesage=2");
                exit;
            }
        } else {

            header("Location: laboratorios?mesage=3");
            exit;
        }
    }
    ################################# FUNCION ELIMINAR LABORATORIOS ##################################

    #################################### FIN DE CLASE LABORATORIOS #####################################














































    ######################################## CLASE PROVEEDORES #########################################

    ################################## FUNCION REGISTRAR PROVEEDORES ##################################
    public function RegistrarProveedores()
    {
        self::SetNames();
        if (empty($_POST["rucproveedor"]) or empty($_POST["nomproveedor"])) {
            echo "1";
            exit;
        }
        $sql = " select rucproveedor from proveedores where rucproveedor = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["rucproveedor"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into proveedores values (null, ?, ?, ?, ?, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $rucproveedor);
            $stmt->bindParam(2, $nomproveedor);
            $stmt->bindParam(3, $direcproveedor);
            $stmt->bindParam(4, $tlfproveedor);
            $stmt->bindParam(5, $celproveedor);
            $stmt->bindParam(6, $emailproveedor);
            $stmt->bindParam(7, $contactoproveedor);

            $rucproveedor = strip_tags($_POST["rucproveedor"]);
            $nomproveedor = strip_tags($_POST["nomproveedor"]);
            $direcproveedor = strip_tags($_POST["direcproveedor"]);
            $tlfproveedor = strip_tags($_POST["tlfproveedor"]);
            $celproveedor = strip_tags($_POST["celproveedor"]);
            $emailproveedor = strip_tags($_POST["emailproveedor"]);
            $contactoproveedor = strip_tags($_POST["contactoproveedor"]);
            $stmt->execute();

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR FUE REGISTRADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################### FUNCION REGISTRAR PROVEEDORES ##################################

    ############################### FUNCION LISTAR PROVEEDORES ##################################
    public function ListarProveedores()
    {
        self::SetNames();
        $sql = " select * from proveedores ";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################## FUNCION LISTAR PROVEEDORES ##################################

    ################################## FUNCION ID PROVEEDORES ##################################
    public function ProveedoresPorId()
    {
        self::SetNames();
        $sql = " select * from proveedores where codproveedor = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codproveedor"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################### FUNCION ID PROVEEDORES ##################################

    #################################### FUNCION ID PROVEEDORES #2 #################################
    public function ProveedorPorId()
    {
        self::SetNames();
        $sql = " select * from proveedores where codproveedor = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codproveedor"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID PROVEEDORES #2 #################################

    ################################## FUNCION ACTUALIZAR PROVEEDORES ##################################
    public function ActualizarProveedores()
    {
        self::SetNames();
        if (empty($_POST["rucproveedor"]) or empty($_POST["nomproveedor"])) {
            echo "1";
            exit;
        }

        $sql = " select rucproveedor from proveedores where codproveedor != ? and rucproveedor = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codproveedor"], $_POST["rucproveedor"]));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " update proveedores set "
                . " rucproveedor = ?, "
                . " nomproveedor = ?, "
                . " direcproveedor = ?, "
                . " tlfproveedor = ?, "
                . " celproveedor = ?, "
                . " emailproveedor = ?, "
                . " contactoproveedor = ? "
                . " where "
                . " codproveedor = ?;
				";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $rucproveedor);
            $stmt->bindParam(2, $nomproveedor);
            $stmt->bindParam(3, $direcproveedor);
            $stmt->bindParam(4, $tlfproveedor);
            $stmt->bindParam(5, $celproveedor);
            $stmt->bindParam(6, $emailproveedor);
            $stmt->bindParam(7, $contactoproveedor);
            $stmt->bindParam(8, $codproveedor);

            $rucproveedor = strip_tags($_POST["rucproveedor"]);
            $nomproveedor = strip_tags($_POST["nomproveedor"]);
            $direcproveedor = strip_tags($_POST["direcproveedor"]);
            $tlfproveedor = strip_tags($_POST["tlfproveedor"]);
            $celproveedor = strip_tags($_POST["celproveedor"]);
            $emailproveedor = strip_tags($_POST["emailproveedor"]);
            $contactoproveedor = strip_tags($_POST["contactoproveedor"]);
            $codproveedor = strip_tags($_POST["codproveedor"]);
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR FUE ACTUALIZADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ################################## FUNCION ACTUALIZAR PROVEEDORES ##################################

    ################################ FUNCION ELIMINAR PROVEEDORES ##################################
    public function EliminarProveedores()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            $sql = " select codproveedor from compras where codproveedor = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codproveedor"])));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " delete from proveedores where codproveedor = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codproveedor);
                $codproveedor = base64_decode($_GET["codproveedor"]);
                $stmt->execute();

                header("Location: proveedores?mesage=1");
                exit;
            } else {

                header("Location: proveedores?mesage=2");
                exit;
            }
        } else {

            header("Location: proveedores?mesage=3");
            exit;
        }
    }
    ################################# FUNCION ELIMINAR PROVEEDORES ##################################

    ################################# FIN DE CLASE PROVEEDORES ####################################








































    ###################################### CLASE CLIENTES ##########################################

    ###################################### FUNCION LISTAR CLIENTES ##################################
    public function BusquedaClientes()
    {
        self::SetNames();

        $sql = " SELECT * from clientes WHERE CONCAT(nrocliente, '',cedcliente, '',nomcliente) LIKE '%" . $_GET["buscacliente"] . "%' ORDER BY codcliente ASC LIMIT 0,20";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {

            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA !</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION LISTAR CLIENTES ##################################

    ###################################### FUNCION REGISTRAR CLIENTES ##################################
    public function RegistrarClientes()
    {
        self::SetNames();
        if (empty($_POST["cedcliente"]) or empty($_POST["nomcliente"])) {
            echo "1";
            exit;
        }

        $sql = " select nrocliente from clientes order by nrocliente desc limit 1";
        foreach ($this->dbh->query($sql) as $row) {

            $nrocliente = $row["nrocliente"];
        }
        if (empty($nrocliente)) {

            $codigo = '0000001';
        } else {
            $resto = substr($nrocliente, 0, -7);
            $coun = strlen($resto);
            $num     = substr($nrocliente, $coun);
            $dig     = $num + 1;
            $cod = str_pad($dig, 7, "0", STR_PAD_LEFT);
            $codigo = $cod;
        }

        $sql = " select cedcliente from clientes where cedcliente = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["cedcliente"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into clientes values (null, ?, ?, ?, ?, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $codigo);
            $stmt->bindParam(2, $cedcliente);
            $stmt->bindParam(3, $nomcliente);
            $stmt->bindParam(4, $direccliente);
            $stmt->bindParam(5, $tlfcliente);
            $stmt->bindParam(6, $celcliente);
            $stmt->bindParam(7, $emailcliente);

            $cedcliente = strip_tags($_POST["cedcliente"]);
            $nomcliente = strip_tags($_POST["nomcliente"]);
            $direccliente = strip_tags($_POST["direccliente"]);
            $tlfcliente = strip_tags($_POST["tlfcliente"]);
            $celcliente = strip_tags($_POST["celcliente"]);
            $emailcliente = strip_tags($_POST["emailcliente"]);
            $stmt->execute();

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL CLIENTE FUE REGISTRADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ###################################### FUNCION REGISTRAR CLIENTES ##################################

    public function ListarVentas()
    {
        self::SetNames();
        $sql1 = " select * from ventas ";
        $sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }



    ###################################### FUNCION LISTAR CLIENTES ##################################
    public function ListarClientes()
    {
        self::SetNames();
        $sql = " select * from clientes ";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ###################################### FUNCION LISTAR CLIENTES ##################################


    ###################################### FUNCION ID CLIENTES ##################################
    public function ClientesPorId()
    {
        self::SetNames();
        $sql = " select * from clientes where codcliente = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codcliente"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################## FUNCION ID CLIENTES ##################################

    ################################# FUNCION ACTUALIZAR CLIENTES ##################################
    public function ActualizarClientes()
    {
        self::SetNames();
        if (empty($_POST["cedcliente"]) or empty($_POST["nomcliente"])) {
            echo "1";
            exit;
        }

        $sql = " select cedcliente from clientes where codcliente != ? and cedcliente = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codcliente"], $_POST["cedcliente"]));
        $num = $stmt->rowCount();
        if ($num == 0) {

            $sql = " update clientes set "
                . " cedcliente = ?, "
                . " nomcliente = ?, "
                . " direccliente = ?, "
                . " tlfcliente = ?, "
                . " celcliente = ?, "
                . " emailcliente = ? "
                . " where "
                . " codcliente = ?;
			";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $cedcliente);
            $stmt->bindParam(2, $nomcliente);
            $stmt->bindParam(3, $direccliente);
            $stmt->bindParam(4, $tlfcliente);
            $stmt->bindParam(5, $celcliente);
            $stmt->bindParam(6, $emailcliente);
            $stmt->bindParam(7, $codcliente);

            $cedcliente = strip_tags($_POST["cedcliente"]);
            $nomcliente = strip_tags($_POST["nomcliente"]);
            $direccliente = strip_tags($_POST["direccliente"]);
            $tlfcliente = strip_tags($_POST["tlfcliente"]);
            $celcliente = strip_tags($_POST["celcliente"]);
            $emailcliente = strip_tags($_POST["emailcliente"]);
            $codcliente = strip_tags($_POST["codcliente"]);
            $stmt->execute();

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL CLIENTE FUE ACTUALIZADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ################################# FUNCION ACTUALIZAR CLIENTES ##################################

    ###################################### FUNCION ELIMINAR CLIENTES ##################################
    public function EliminarClientes()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            $sql = " select codcliente from ventas where codcliente = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codcliente"])));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " delete from clientes where codcliente = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codcliente);
                $codcliente = base64_decode($_GET["codcliente"]);
                $stmt->execute();

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-check-square-o'></span> EL CLIENTE FUE ELIMINADO EXITOSAMENTE </center>";
                echo "</div>";
                exit;
            } else {

                echo "<div class='alert alert-warning'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-info-circle'></span> ESTE CLIENTE NO PUEDE SER ELIMINADO, TIENE VENTAS ASOCIADAS ACTUALMENTE </center>";
                echo "</div>";
                exit;
            }
        } else {

            echo "<div class='alert alert-warning'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> USTED NO TIENE ACCESO PARA ELIMINAR CLIENTES, NO ERES EL ADMINISTRADOR DEL SISTEMA </center>";
            echo "</div>";
            exit;
        }
    }
    ###################################### FUNCION ELIMINAR CLIENTES ##################################

    #################################### FIN DE CLASE CLIENTES ######################################









































    ###################################### CLASE TRANSPORTE ##########################################

    ###################################### FUNCION REGISTRAR TRANSPORTE ##################################
    public function RegistrarTransporte()
    {
        self::SetNames();
        if (empty($_POST["rucchofer"]) or empty($_POST["nomchofer"]) or empty($_POST["placavehiculo"])) {
            echo "1";
            exit;
        }

        $sql = " SELECT * from transporteguias where rucchofer != ? and statuschofer = ? and statuschofer = '0'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["rucchofer"], $_POST["statuschofer"]));
        $num = $stmt->rowCount();
        if ($num > 0) {
            echo "2";
            exit;
        } else {

            $sql = " select rucchofer from transporteguias where rucchofer = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["rucchofer"]));
            $num = $stmt->rowCount();
            if ($num == 0) {
                $query = " insert into transporteguias values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $rucchofer);
                $stmt->bindParam(2, $nomchofer);
                $stmt->bindParam(3, $tlfchofer);
                $stmt->bindParam(4, $numbultos);
                $stmt->bindParam(5, $ruta);
                $stmt->bindParam(6, $ciudadruta);
                $stmt->bindParam(7, $placavehiculo);
                $stmt->bindParam(8, $llegada);
                $stmt->bindParam(9, $motivotraslado);
                $stmt->bindParam(10, $iniciotransporte);
                $stmt->bindParam(11, $fintransporte);
                $stmt->bindParam(12, $statuschofer);

                $rucchofer = strip_tags($_POST["rucchofer"]);
                $nomchofer = strip_tags($_POST["nomchofer"]);
                $tlfchofer = strip_tags($_POST["tlfchofer"]);
                $numbultos = strip_tags($_POST["numbultos"]);
                $ruta = strip_tags($_POST["ruta"]);
                $ciudadruta = strip_tags($_POST["ciudadruta"]);
                $placavehiculo = strip_tags($_POST["placavehiculo"]);
                $llegada = strip_tags($_POST["llegada"]);
                $motivotraslado = strip_tags($_POST["motivotraslado"]);
                $iniciotransporte = strip_tags(date("Y-m-d", strtotime($_POST['desde'])));
                $fintransporte = strip_tags(date("Y-m-d", strtotime($_POST['hasta'])));
                $statuschofer = strip_tags($_POST["statuschofer"]);
                $stmt->execute();

                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> EL TRANSPORTE PARA GUIA FUE REGISTRADO EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "3";
                exit;
            }
        }
    }
    ################################## FUNCION REGISTRAR TRANSPORTE ##################################

    ################################## FUNCION LISTAR TRANSPORTE ##################################
    public function ListarTransporte()
    {
        self::SetNames();
        $sql = " select * from transporteguias ";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################### FUNCION LISTAR TRANSPORTE ##################################

    ################################### FUNCION ID TRANSPORTE ##################################
    public function TransportePorId()
    {
        self::SetNames();
        $sql = " select * from transporteguias where codchofer = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codchofer"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################## FUNCION ID TRANSPORTE ##################################

    ################################### FUNCION TRANSPORTE ACTIVO ##################################
    public function TransporteActivoPorId()
    {
        self::SetNames();
        $sql = " select * from transporteguias where statuschofer = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array('0'));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################## FUNCION TRANSPORTE ACTIVO ##################################


    ################################# FUNCION ACTUALIZAR TRANSPORTE ##################################
    public function ActualizarTransporte()
    {
        self::SetNames();
        if (empty($_POST["codchofer"]) or empty($_POST["rucchofer"]) or empty($_POST["nomchofer"]) or empty($_POST["placavehiculo"])) {
            echo "1";
            exit;
        }

        $sql = " SELECT * from transporteguias where codchofer != ? and statuschofer = ? and statuschofer = '0'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codchofer"], $_POST["statuschofer"]));
        $num = $stmt->rowCount();
        if ($num > 0) {
            echo "2";
            exit;
        } else {

            $sql = " select * from transporteguias where codchofer != ? and rucchofer = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codchofer"], $_POST["rucchofer"]));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " update transporteguias set "
                    . " rucchofer = ?, "
                    . " nomchofer = ?, "
                    . " tlfchofer = ?, "
                    . " numbultos = ?, "
                    . " ruta = ?, "
                    . " ciudadruta = ?, "
                    . " placavehiculo = ?, "
                    . " llegada = ?, "
                    . " motivotraslado = ?, "
                    . " iniciotransporte = ?, "
                    . " fintransporte = ?, "
                    . " statuschofer = ? "
                    . " where "
                    . " codchofer = ?;
			";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $rucchofer);
                $stmt->bindParam(2, $nomchofer);
                $stmt->bindParam(3, $tlfchofer);
                $stmt->bindParam(4, $numbultos);
                $stmt->bindParam(5, $ruta);
                $stmt->bindParam(6, $ciudadruta);
                $stmt->bindParam(7, $placavehiculo);
                $stmt->bindParam(8, $llegada);
                $stmt->bindParam(9, $motivotraslado);
                $stmt->bindParam(10, $iniciotransporte);
                $stmt->bindParam(11, $fintransporte);
                $stmt->bindParam(12, $statuschofer);
                $stmt->bindParam(13, $codchofer);

                $rucchofer = strip_tags($_POST["rucchofer"]);
                $nomchofer = strip_tags($_POST["nomchofer"]);
                $tlfchofer = strip_tags($_POST["tlfchofer"]);
                $numbultos = strip_tags($_POST["numbultos"]);
                $ruta = strip_tags($_POST["ruta"]);
                $ciudadruta = strip_tags($_POST["ciudadruta"]);
                $placavehiculo = strip_tags($_POST["placavehiculo"]);
                $llegada = strip_tags($_POST["llegada"]);
                $motivotraslado = strip_tags($_POST["motivotraslado"]);
                $iniciotransporte = strip_tags(date("Y-m-d", strtotime($_POST['desde'])));
                $fintransporte = strip_tags(date("Y-m-d", strtotime($_POST['hasta'])));
                $statuschofer = strip_tags($_POST["statuschofer"]);
                $codchofer = strip_tags($_POST["codchofer"]);
                $stmt->execute();

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> EL TRANSPORTE PARA GUIA FUE ACTUALIZADO EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {

                echo "3";
                exit;
            }
        }
    }
    ################################# FUNCION ACTUALIZAR TRANSPORTE ##################################

    ###################################### FUNCION ELIMINAR TRANSPORTE ##################################
    public function EliminarTransporte()
    {
        if ($_SESSION['acceso'] == "administradorS") {

            $sql = " delete from transporteguias where codchofer = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codchofer);
            $codchofer = base64_decode($_GET["codchofer"]);
            $stmt->execute();

            header("Location: transporte?mesage=1");
            exit;
        } else {

            header("Location: transporte?mesage=2");
            exit;
        }
    }
    ################################## FUNCION ELIMINAR TRANSPORTE ################################

    #################################### FIN DE CLASE TRANSPORTE ######################################






































    ################################## CLASE PRODUCTOS EN ALMACEN  #####################################

    ###################################### FUNCION CODIGO PRODUCTO ##################################
    public function CodigoProducto()
    {
        self::SetNames();
        $sql = " select codproducto from productos order by codalmacen desc limit 1";
        foreach ($this->dbh->query($sql) as $row) {
            $codproducto["codproducto"] = $row["codproducto"];
            //echo $dig = ($row["codproducto"]== "" ? "cwecwec1" : $codproducto["codproducto"] + 1);
        }

        if (empty($codproducto["codproducto"])) {
            echo $nro = '1';
        } else {
            echo $nro = $codproducto["codproducto"] + 1;
        }
    }
    ################################### FUNCION CODIGO PRODUCTO ###################################

    ###################################### FUNCION CARGAR PRODUCTOS ##################################
    public function CargarProductos()
    {
        self::SetNames();
        if (empty($_FILES["sel_file"])) {
            echo "1";
            exit;
        }
        //Aqu� es donde seleccionamos nuestro csv
        $fname = $_FILES['sel_file']['name'];
        //echo 'Cargando nombre del archivo: '.$fname.' ';
        $chk_ext = explode(".", $fname);

        if (strtolower(end($chk_ext)) == "csv") {
            //si es correcto, entonces damos permisos de lectura para subir
            $filename = $_FILES['sel_file']['tmp_name'];
            $handle = fopen($filename, "r");

            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                //Insertamos los datos con los valores...

                $query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $data[0]);
                $stmt->bindParam(2, $data[1]);
                $stmt->bindParam(3, $data[2]);
                $stmt->bindParam(4, $data[3]);
                $stmt->bindParam(5, $data[4]);
                $stmt->bindParam(6, $data[5]);
                $stmt->bindParam(7, $data[6]);
                $stmt->bindParam(8, $data[7]);
                $stmt->bindParam(9, $data[8]);
                $stmt->bindParam(10, $data[9]);
                $stmt->bindParam(11, $data[10]);
                $stmt->bindParam(12, $data[11]);
                $stmt->bindParam(13, $data[12]);
                $stmt->bindParam(14, $data[13]);
                $stmt->bindParam(15, $data[14]);
                $stmt->bindParam(16, $data[15]);
                $stmt->bindParam(17, $data[16]);
                $stmt->bindParam(18, $data[17]);
                $stmt->bindParam(19, $data[18]);
                $stmt->bindParam(20, $data[19]);
                $stmt->bindParam(21, $data[20]);
                $stmt->bindParam(22, $data[21]);
                $stmt->bindParam(23, $data[22]);
                $stmt->bindParam(24, $data[23]);
                $stmt->bindParam(25, $data[24]);
                $stmt->execute();

                ##################### ACTUALIZAMOS EL PRECIO POR UNIDAD DE PRODUCTOS ##########################
                /*$sql = " update productos set "
            ." precioventaunidad = ?, "
            ." stocktotal = ? "
            ." where "
            ." codproducto = ?;
            ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $precio);
            $stmt->bindParam(2, $stocktotal);
            $stmt->bindParam(3, $codproducto);

            $precio = rount($data[7]/$data[10],2);
            $stocktotal = strip_tags($data[9]*$data[10]+$data[11]);
            $codproducto = strip_tags($data[0]);
            $stmt->execute();*/


                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ################################
                $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codproceso);
                $stmt->bindParam(2, $codresponsable);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);
                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);
                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);
                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);
                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);

                $codproceso = strip_tags($data[0]);
                $codresponsable = strip_tags("0");
                $codsucursalm = strip_tags($data[21]);
                $codproductom = strip_tags($data[0]);
                $movimiento = strip_tags("ENTRADAS");
                $entradacaja = strip_tags($data[9]);
                $entradaunidad = strip_tags($data[10]);
                $entradacajano = strip_tags($data[11]);
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags("0");
                $salidabonif = strip_tags("0");
                $devolucioncaja = strip_tags("0");
                $devolucionunidad = strip_tags("0");
                $devolucionbonif = strip_tags("0");
                $stocktotalcaja = strip_tags($data[9]);
                $stocktotalunidad = strip_tags($data[12]);
                $preciocompram = strip_tags($data[6]);
                $precioventacajam = strip_tags($data[7]);
                $precioventaunidadm = strip_tags($data[8]);
                $ivaproducto = strip_tags($data[14]);
                $descproducto = strip_tags($data[15]);
                $documento = strip_tags("INVENTARIO INICIAL");
                $fechakardex = strip_tags(date("Y-m-d"));
                $stmt->execute();
            }
            //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
            fclose($handle);


            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PRODUCTOS FUE REALIZADA EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
            echo "2";
            exit;
        }
    }
    ################################## FUNCION CARGAR PRODUCTOS ##################################

    ################################# FUNCION REGISTRAR PRODUCTOS ##################################
    public function RegistrarProductos()
    {
        self::SetNames();
        if (empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codpresentacion"])) {
            echo "1";
            exit;
        }

        if ($_POST["precioventacaja"] == "0.00" || $_POST["precioventacaja"] == "0") {
            echo "2";
            exit;
        } else {

            $sql = " SELECT codproducto from productos where codproducto = ? AND codsucursal = ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST["codproducto"], $_POST["codsucursal"]));
            $num = $stmt->rowCount();
            if ($num == 0) {
                ##################### REGISTRAMOS LOS NUEVOS PRODUCTOS ####################################
                $query = " insert into productos 
				(`codalmacen`, `codproducto`, `producto`, `principioactivo`, `descripcion`,
				`codpresentacion`, `codmedida`, `preciocompra`, `precioventacaja`, `precioventaunidad`,
				`stockcajas`, `unidades`, `stockunidad`, `stocktotal`, `stockminimo`,
				`ivaproducto`, `descproducto`, `fechaelaboracion`, `fechaexpiracion`, `codigobarra`,
				`codlaboratorio`, `codproveedor`, `codsucursal`, `loteproducto`, `ubicacion`,
				`statusp`, `precioventablister`, `blisterunidad`, `stockblister`, `preciocompraunidad`,
				`preciocomprablister`, `registrosanitario`, `blistercaja`, `precioventablisterdesc`, `precioventacajadesc`)
				values
				(null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codproducto);
                $stmt->bindParam(2, $producto);
                $stmt->bindParam(3, $principioactivo);
                $stmt->bindParam(4, $descripcion);

                $stmt->bindParam(5, $codpresentacion);
                $stmt->bindParam(6, $codmedida);
                $stmt->bindParam(7, $preciocompra);
                $stmt->bindParam(8, $precioventacaja);
                $stmt->bindParam(9, $precioventaunidad);

                $stmt->bindParam(10, $stockcajas);
                $stmt->bindParam(11, $unidades);
                $stmt->bindParam(12, $stockunidad);
                $stmt->bindParam(13, $stocktotal);
                $stmt->bindParam(14, $stockminimo);

                $stmt->bindParam(15, $ivaproducto);
                $stmt->bindParam(16, $descproducto);
                $stmt->bindParam(17, $fechaelaboracion);
                $stmt->bindParam(18, $fechaexpiracion);
                $stmt->bindParam(19, $codigobarra);

                $stmt->bindParam(20, $codlaboratorio);
                $stmt->bindParam(21, $codproveedor);
                $stmt->bindParam(22, $codsucursal);
                $stmt->bindParam(23, $loteproducto);
                $stmt->bindParam(24, $ubicacion);

                $stmt->bindParam(25, $statusp);
                $stmt->bindParam(26, $precioventablister);
                $stmt->bindParam(27, $unidadesblister);
                $stmt->bindParam(28, $stockblister);
                $stmt->bindParam(29, $preciocompraunidad);

                $stmt->bindParam(30, $preciocomprablister);
                $stmt->bindParam(31, $registrosanitario);
                $stmt->bindParam(32, $blistercaja);
                $stmt->bindParam(33, $precioventablisterdesc);
                $stmt->bindParam(34, $precioventacajadesc);



                $codproducto = strip_tags($_POST["codproducto"]);
                $producto = strip_tags($_POST["producto"]);
                $principioactivo = strip_tags($_POST["principioactivo"]);
                $descripcion = strip_tags($_POST["descripcion"]);
                $codpresentacion = strip_tags($_POST["codpresentacion"]);
                $codmedida = $_POST["codmedida"] ? strip_tags($_POST["codmedida"]) : null;
                $preciocompra = strip_tags($_POST["preciocompra"]);
                $precioventacaja = $_POST["precioventacaja"] ? strip_tags($_POST["precioventacaja"]) : null;
                $precioventaunidad = strip_tags($_POST["precioventaunidad"]);
                $stockcajas = strip_tags($_POST["stockcajas"]);
                $unidades = strip_tags($_POST["unidades"]);
                $stockunidad = strip_tags($_POST["stockunidad"]);
                $stocktotal = strip_tags($_POST["stocktotal"]);
                $stockminimo = $_POST["stockminimo"] ? strip_tags($_POST["stockminimo"]) : null;
                $ivaproducto = strip_tags($_POST["ivaproducto"]);
                $descproducto = $_POST["descproducto"] ? strip_tags($_POST["descproducto"]) : null;
                $fechaelaboracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaelaboracion'])));
                $fechaexpiracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaexpiracion'])));
                $codigobarra = strip_tags($_POST["codigobarra"]);
                $codlaboratorio = $_POST["codlaboratorio"] ? strip_tags($_POST["codlaboratorio"]) : null;
                $codproveedor = $_POST["codproveedor"] ? strip_tags($_POST["codproveedor"]) : null;
                $codsucursal = $_POST["codsucursal"] ? strip_tags($_POST["codsucursal"]) : null;
                $loteproducto = strip_tags($_POST["loteproducto"]);
                $ubicacion = strip_tags($_POST["ubicacion"]);
                $statusp = $_POST["statusp"] ? strip_tags($_POST["statusp"]) : 0;

                $precioventablister = $_POST["precioventablister"] ? strip_tags($_POST["precioventablister"]) : null;
                $stockblister = $_POST["stockblister"] ? strip_tags($_POST["stockblister"]) : null;
                $unidadesblister = $_POST["unidadesblister"] ? strip_tags($_POST["unidadesblister"]) : null;

                $preciocomprablister = $_POST["preciocomprablister"] ? strip_tags($_POST["preciocomprablister"]) : null;
                $preciocompraunidad = $_POST["preciocompraunidad"] ? strip_tags($_POST["preciocompraunidad"]) : null;

                $registrosanitario = strip_tags($_POST["rsanitario"]);
                $blistercaja = strip_tags($_POST["blistercaja"]);

                $precioventablisterdesc = $_POST["precioventablisterdesc"] ? strip_tags($_POST["precioventablisterdesc"]) : null;
                $precioventacajadesc = $_POST["precioventacajadesc"] ? strip_tags($_POST["precioventacajadesc"]) : null;

                $stmt->execute();
                ##################### REGISTRAMOS LOS NUEVOS PRODUCTOS ####################################

                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ################################
                $query = " insert into kardexproductos
				(`codkardex`, `codproceso`, `codresponsable`, `codsucursalm`, `codproductom`,
				`movimiento`, `entradacaja`, `entradaunidad`, `entradacajano`, `entradabonif`,
				`salidacaja`, `salidaunidad`, `salidabonif`, `devolucioncaja`, `devolucionunidad`,
				`devolucionbonif`, `stocktotalcaja`, `stocktotalunidad`, `preciocompram`, `precioventacajam`,
				`precioventaunidadm`, `ivaproductom`, `descproductom`, `documento`, `fechakardex`)
				values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codproceso);
                $stmt->bindParam(2, $codresponsable);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);

                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);

                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);

                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);

                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);

                $codproceso = strip_tags(GenerateRandomString());
                $codresponsable = $_POST["codproveedor"] ? strip_tags($_POST["codproveedor"]) : null;
                $codsucursalm = $_POST["codsucursal"] ? strip_tags($_POST["codsucursal"]) : null;
                $codproductom = $_POST['codproducto'] ? strip_tags($_POST['codproducto']) : null;
                $movimiento = strip_tags("ENTRADAS");
                $entradacaja = strip_tags($_POST['stockcajas']);
                $entradaunidad = strip_tags($_POST['unidades']);
                $entradacajano = strip_tags($_POST['stockunidad']);
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags("0");
                $salidabonif = strip_tags("0");
                $devolucioncaja = strip_tags("0");
                $devolucionunidad = strip_tags("0");
                $devolucionbonif = strip_tags("0");
                $stocktotalcaja = strip_tags($_POST['stockcajas']);
                $stocktotalunidad = strip_tags($_POST['stocktotal']);
                $preciocompram = strip_tags($_POST["preciocompra"]);
                $precioventacajam = $_POST["precioventacaja"] ? strip_tags($_POST["precioventacaja"]) : null;
                $precioventaunidadm = strip_tags($_POST["precioventaunidad"]);
                $ivaproducto = strip_tags($_POST["ivaproducto"]);
                $descproducto = $_POST["descproducto"] ? strip_tags($_POST["descproducto"]) : null;
                $documento = strip_tags("INVENTARIO INICIAL");
                $fechakardex = strip_tags(date("Y-m-d"));
                $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############################

                ##################  SUBIR FOTO DE PRODUCTO ######################################
                //datos del arhivo
                if (isset($_FILES['imagen']['name'])) {
                    $nombre_archivo = $_FILES['imagen']['name'];
                } else {
                    $nombre_archivo = '';
                }
                if (isset($_FILES['imagen']['type'])) {
                    $tipo_archivo = $_FILES['imagen']['type'];
                } else {
                    $tipo_archivo = '';
                }
                if (isset($_FILES['imagen']['size'])) {
                    $tamano_archivo = $_FILES['imagen']['size'];
                } else {
                    $tamano_archivo = '';
                }
                //compruebo si las caracter�sticas del archivo son las que deseo

                if ((strpos($tipo_archivo, 'image/jpeg') !== false) && $tamano_archivo < 200000) {
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombre_archivo) && rename("fotos/" . $nombre_archivo, "fotos/" . $codproducto . ".jpg")) {
                        ## se puede dar un aviso
                    }
                    ## se puede dar otro aviso
                }
                ##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################


                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO INICIAL FUE REGISTRADO EXITOSAMENTE";
                echo "</div>";
                exit;
            } else {
                echo "3";
                exit;
            }
        }
    }
    ################################# FUNCION REGISTRAR PRODUCTOS ##################################

    ###################################### FUNCION BUSQUEDA PRODUCTOS ##################################
    public function BusquedaProductos()
    {
        self::SetNames();
        //$sql = " SELECT CONCAT(producto, ' - ',principioactivo, ' - ',nompresentacion, ' - ',nommedida, ' - ', nomproveedor) as label, productos.codalmacen, productos.codproducto, productos.producto, productos.principioactivo, productos.descripcion, productos.codpresentacion, productos.codmedida, productos.preciocompra, productos.precioventacaja, productos.precioventaunidad, productos.stockcajas, productos.unidades, productos.stockunidad, productos.stocktotal, productos.stockminimo, productos.ivaproducto, productos.descproducto, productos.fechaelaboracion, productos.fechaexpiracion, productos.codigobarra, productos.codlaboratorio, productos.codproveedor, productos.codsucursal, productos.loteproducto, productos.ubicacion, productos.statusp, presentaciones.nompresentacion, medidas.nommedida, proveedores.nomproveedor, laboratorios.nomlaboratorio, sucursales.razonsocial FROM productos INNER JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON productos.codmedida = medidas.codmedida INNER JOIN proveedores ON productos.codproveedor=proveedores.codproveedor LEFT JOIN laboratorios ON productos.codlaboratorio=laboratorios.codlaboratorio LEFT JOIN sucursales ON productos.codsucursal=sucursales.codsucursal WHERE CONCAT(principioactivo, '',producto) LIKE '%".$_GET["buscaproducto"]."%' ORDER BY codproducto ASC LIMIT 0,20";
        $sql = " SELECT 
                    productos.precioventablister, 
                    productos.blisterunidad, 
                    productos.stockblister, 
                    productos.preciocompraunidad, 
                    productos.preciocomprablister, 
                    CONCAT(producto, ' - ',principioactivo, ' - ',nompresentacion, ' - ',nommedida, ' - ', nomproveedor) as label, productos.codalmacen, productos.codproducto, productos.producto, productos.principioactivo, productos.descripcion, productos.codpresentacion, productos.codmedida, productos.preciocompra, productos.precioventacaja, productos.precioventaunidad, productos.stockcajas, productos.unidades, productos.stockunidad, productos.stocktotal, productos.stockminimo, productos.ivaproducto, productos.descproducto, productos.fechaelaboracion, productos.fechaexpiracion, productos.codigobarra, productos.codlaboratorio, productos.codproveedor, productos.codsucursal, productos.loteproducto, productos.ubicacion, productos.statusp, presentaciones.nompresentacion, medidas.nommedida, proveedores.nomproveedor, laboratorios.nomlaboratorio, sucursales.razonsocial FROM productos INNER JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor LEFT JOIN laboratorios ON productos.codlaboratorio=laboratorios.codlaboratorio LEFT JOIN sucursales ON productos.codsucursal=sucursales.codsucursal WHERE producto LIKE '%" . $_GET["buscaproducto"] . "%' ORDER BY codproducto ASC LIMIT 0,20";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA DE PRODUCTOS !</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION BUSQUEDA PRODUCTOS ##################################

    ################################# FUNCION LISTAR PRODUCTOS ##################################
    public function ListarProductos()
    {
        self::SetNames();
        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT * from productos INNER JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON productos.codmedida = medidas.codmedida LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio";
            //$sql="SELECT * from productos LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio";

            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT * from productos INNER JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON productos.codmedida = medidas.codmedida LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION LISTAR PRODUCTOS ##################################

    ###################################### FUNCION ID PRODUCTOS ##################################
    public function ProductosPorId()
    {
        self::SetNames();
        $sql = " SELECT * from productos INNER JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON productos.codmedida = medidas.codmedida WHERE productos.codproducto = ? AND productos.codsucursal = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codproducto"]), base64_decode($_GET["codsucursal"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID PRODUCTOS ##################################

    ###################################### FUNCION DETALLES PRODUCTOS ##################################
    public function DetalleProductosPorId()
    {
        self::SetNames();
        $sql = " SELECT * from productos INNER JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON productos.codmedida = medidas.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal WHERE productos.codproducto = ? AND productos.codsucursal = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codproducto"]), base64_decode($_GET["codsucursal"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION DETALLES PRODUCTOS ##################################

    ################################ FUNCION ACTUALIZAR PRODUCTOS ##################################
    public function ActualizarProductos()
    {
        if (empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codpresentacion"])) {
            echo "1";
            exit;
        }

        if ($_POST["precioventacaja"] == "0.00" || $_POST["precioventacaja"] == "0") {
            echo "2";
            exit;
        } else {

            self::SetNames();
            $sql = " update productos set "
                . " codproducto = ?, "
                . " producto = ?, "
                . " principioactivo = ?, "
                . " descripcion = ?, "
                . " codpresentacion = ?, "
                . " codmedida = ?, "
                . " preciocompra = ?, "
                . " precioventacaja = ?, "
                . " precioventaunidad = ?, "
                . " stockcajas = ?, "
                . " unidades = ?, "
                . " stockunidad = ?, "
                . " stocktotal = ?, "
                . " stockminimo = ?, "
                . " ivaproducto = ?, "
                . " descproducto = ?, "
                . " fechaelaboracion = ?, "
                . " fechaexpiracion = ?, "
                . " codigobarra = ?, "
                . " codlaboratorio = ?, "
                . " codproveedor = ?, "
                . " codsucursal = ?, "
                . " loteproducto = ?, "
                . " ubicacion = ?, "
                . " statusp = ?, "
                . " precioventablister = ?, "
                . " stockblister = ?, "
                . " blisterunidad = ?, "
                . " preciocompraunidad = ?, "
                . " preciocomprablister = ?, "
                . " registrosanitario = ?, "
                . " blistercaja = ?, "
                . " precioventablisterdesc = ?, "
                . " precioventacajadesc = ?"
                . " where "
                . " codalmacen = ?;
		";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codproducto);
            $stmt->bindParam(2, $producto);
            $stmt->bindParam(3, $principioactivo);
            $stmt->bindParam(4, $descripcion);
            $stmt->bindParam(5, $codpresentacion);
            $stmt->bindParam(6, $codmedida);
            $stmt->bindParam(7, $preciocompra);
            $stmt->bindParam(8, $precioventacaja);
            $stmt->bindParam(9, $precioventaunidad);
            $stmt->bindParam(10, $stockcajas);
            $stmt->bindParam(11, $unidades);
            $stmt->bindParam(12, $stockunidad);
            $stmt->bindParam(13, $stocktotal);
            $stmt->bindParam(14, $stockminimo);
            $stmt->bindParam(15, $ivaproducto);
            $stmt->bindParam(16, $descproducto);
            $stmt->bindParam(17, $fechaelaboracion);
            $stmt->bindParam(18, $fechaexpiracion);
            $stmt->bindParam(19, $codigobarra);
            $stmt->bindParam(20, $codlaboratorio);
            $stmt->bindParam(21, $codproveedor);
            $stmt->bindParam(22, $codsucursal);
            $stmt->bindParam(23, $loteproducto);
            $stmt->bindParam(24, $ubicacion);
            $stmt->bindParam(25, $statusp);
            $stmt->bindParam(26, $precioventablister);
            $stmt->bindParam(27, $stockblister);
            $stmt->bindParam(28, $unidadesblister);
            $stmt->bindParam(29, $preciocompraunidad);
            $stmt->bindParam(30, $preciocomprablister);
            $stmt->bindParam(31, $registrosanitario);
            $stmt->bindParam(32, $blistercaja);
            $stmt->bindParam(33, $precioventablisterdesc);
            $stmt->bindParam(34, $precioventacajadesc);
            $stmt->bindParam(35, $codalmacen);



            $codproducto = strip_tags($_POST["codproducto"]);
            $producto = strip_tags($_POST["producto"]);
            $principioactivo = strip_tags($_POST["principioactivo"]);
            $descripcion = strip_tags($_POST["descripcion"]);
            $codpresentacion = strip_tags($_POST["codpresentacion"]);
            $codmedida = strip_tags($_POST["codmedida"]);
            $preciocompra = strip_tags($_POST["preciocompra"]);
            $precioventacaja = strip_tags($_POST["precioventacaja"]);
            $precioventaunidad = strip_tags($_POST["precioventaunidad"]);
            $stockcajas = strip_tags($_POST["stockcajas"]);
            $unidades = strip_tags($_POST["unidades"]);
            $stockunidad = strip_tags($_POST["stockunidad"]);
            $stocktotal = strip_tags($_POST["stocktotal"]);
            $stockminimo = strip_tags($_POST["stockminimo"]);
            $ivaproducto = strip_tags($_POST["ivaproducto"]);
            $descproducto = strip_tags($_POST["descproducto"]);
            $fechaelaboracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaelaboracion'])));
            $fechaexpiracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaexpiracion'])));
            $codigobarra = strip_tags($_POST["codigobarra"]);
            $codlaboratorio = strip_tags($_POST["codlaboratorio"]);
            $codproveedor = strip_tags($_POST["codproveedor"]);
            $codsucursal = strip_tags($_POST["codsucursal"]);
            $loteproducto = strip_tags($_POST["loteproducto"]);
            $ubicacion = strip_tags($_POST["ubicacion"]);
            $statusp = strip_tags($_POST["statusp"]);
            $codalmacen = strip_tags($_POST["codalmacen"]);
            $registrosanitario = strip_tags($_POST["rsanitario"]);

            $precioventablister = $_POST["precioventablister"] ? strip_tags($_POST["precioventablister"]) : null;
            //$stockblister = $_POST["stockblister"] ? strip_tags($_POST["stockblister"]) : null;
            $stockblister = $_POST["totalBlister2"] ? strip_tags($_POST["totalBlister2"]) : null;
            $unidadesblister = $_POST["unidadesblister"] ? strip_tags($_POST["unidadesblister"]) : null;

            $preciocompraunidad = $_POST["preciocompraunidad"] ? strip_tags($_POST["preciocompraunidad"]) : null;
            $preciocomprablister = $_POST["preciocomprablister"] ? strip_tags($_POST["preciocomprablister"]) : null;
            $blistercaja = (int)(strip_tags($_POST["blistercaja"]));

            $precioventablisterdesc = $_POST["precioventablisterdesc"] ? strip_tags($_POST["precioventablisterdesc"]) : null;
            $precioventacajadesc = $_POST["precioventacajadesc"] ? strip_tags($_POST["precioventacajadesc"]) : null;

            $stmt->execute();

            ##################  SUBIR FOTO DE PRODUCTO ######################################
            //datos del arhivo
            if (isset($_FILES['imagen']['name'])) {
                $nombre_archivo = $_FILES['imagen']['name'];
            } else {
                $nombre_archivo = '';
            }
            if (isset($_FILES['imagen']['type'])) {
                $tipo_archivo = $_FILES['imagen']['type'];
            } else {
                $tipo_archivo = '';
            }
            if (isset($_FILES['imagen']['size'])) {
                $tamano_archivo = $_FILES['imagen']['size'];
            } else {
                $tamano_archivo = '';
            }
            //compruebo si las caracter�sticas del archivo son las que deseo
            if ((strpos($tipo_archivo, 'image/jpeg') !== false) && $tamano_archivo < 200000) {
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombre_archivo) && rename("fotos/" . $nombre_archivo, "fotos/" . $codproducto . ".jpg")) {
                    ## se puede dar un aviso
                }
                ## se puede dar otro aviso
            }
            ##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################



            header("Refresh:0; ?acc=upd");
        }
    }
    ################################# FUNCION ACTUALIZAR PRODUCTOS ##################################

    ################################# FUNCION ELIMINAR PRODUCTOS ##################################
    public function EliminarProductos()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            $sql = " SELECT codproductov from detalleventas WHERE codproductov = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codproducto"])));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $sql = " DELETE from productos WHERE codproducto = ? AND codsucursal = ?";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codproducto);
                $stmt->bindParam(2, $codsucursal);
                $codproducto = base64_decode($_GET["codproducto"]);
                $codsucursal = base64_decode($_GET["codsucursal"]);
                $stmt->execute();

                $sql = " DELETE from kardexproductos WHERE codproductom = ? AND codsucursalm = ?";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codproducto);
                $stmt->bindParam(2, $codsucursal);
                $codproducto = base64_decode($_GET["codproducto"]);
                $codsucursal = base64_decode($_GET["codsucursal"]);
                $stmt->execute();

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-check-square-o'></span> EL PRODUCTO FUE ELIMINADO EXITOSAMENTE </center>";
                echo "</div>";
                exit;
            } else {

                echo "<div class='alert alert-warning'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-info-circle'></span> ESTE PRODUCTO NO PUEDE SER ELIMINADO, TIENE VENTAS RELACIONADAS ACTUALMENTE </center>";
                echo "</div>";
                exit;
            }
        } else {

            echo "<div class='alert alert-warning'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> USTED NO TIENE ACCESO PARA ELIMINAR PRODUCTOS, NO ERES EL ADMINISTRADOR DEL SISTEMA </center>";
            echo "</div>";
            exit;
        }
    }
    ###################################### FUNCION ELIMINAR PRODUCTOS ##################################

    ############################## FUNCION LISTAR PRODUCTOS ACTIVOS POR SUCURSAL ##############################
    public function BuscarProductosActivos()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.statusp = 0 ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS ACTIVOS PARA LA SUCURSAL SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.statusp = 0 ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) { ?>

				<script type='text/javascript' language='javascript'>
					alert('NO EXISTEN PRODUCTOS ACTIVOS PARA LA SUCURSAL SELECCIONADA')
					//se actualiza la pagina padre al cerrar el popup
					var ventana = window.self;
					ventana.opener = window.self;
					ventana.close();
				</script>
			<?php
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ########################### FUNCION LISTAR PRODUCTOS ACTIVOS POR SUCURSAL ###############################

    ############################## FUNCION LISTAR PRODUCTOS INACTIVOS POR SUCURSAL ##############################
    public function BuscarProductosInactivos()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.statusp = 1 ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS INACTIVOS PARA LA SUCURSAL SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.statusp = 1 ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) { ?>

				<script type='text/javascript' language='javascript'>
					alert('NO EXISTEN PRODUCTOS INACTIVOS PARA LA SUCURSAL SELECCIONADA')
					//se actualiza la pagina padre al cerrar el popup
					var ventana = window.self;
					ventana.opener = window.self;
					ventana.close();
				</script>
			<?php
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ########################### FUNCION LISTAR PRODUCTOS INACTIVOS POR SUCURSAL ###############################

    ############################## FUNCION LISTAR PRODUCTOS POR SUCURSAL ##############################
    public function BuscarProductosSucursal()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS PARA LA SUCURSAL SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) { ?>

				<script type='text/javascript' language='javascript'>
					alert('NO EXISTEN PRODUCTOS PARA LA SUCURSAL SELECCIONADA')
					//se actualiza la pagina padre al cerrar el popup
					var ventana = window.self;
					ventana.opener = window.self;
					ventana.close();
				</script>
			<?php
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ########################### FUNCION LISTAR PRODUCTOS POR SUCURSAL ###############################

    ######################### FUNCION LISTAR PRODUCTOS POR LABORATORIOS ############################
    public function BuscarProductosLaboratorios()
    {
        self::SetNames();

        $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.codlaboratorio = ? ORDER BY productos.codproducto";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
        $stmt->bindValue(2, trim(base64_decode($_GET['codlaboratorio'])));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS PARA LA SUCURSAL Y LABORATORIO SELECCIONADO</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################## FUNCION LISTAR PRODUCTOS POR LABORATORIOS ############################


    ############################ FUNCION LISTAR PRODUCTOS STOCK MINIMO ##############################
    public function BuscarProductosStockMinimo()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.stocktotal <= productos.stockminimo ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS EN STOCK MINIMO EN LA SUCURSAL SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.stocktotal <= productos.stockminimo ORDER BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) { ?>

				<script type='text/javascript' language='javascript'>
					alert('ACTUALMENTE NO EXISTEN PRODUCTOS EN STOCK MINIMO')
					//se actualiza la pagina padre al cerrar el popup
					var ventana = window.self;
					ventana.opener = window.self;
					ventana.close();
				</script>
			<?php
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ############################## FUNCION LISTAR PRODUCTOS STOCK MINIMO ##############################

    ############################## FUNCION LISTAR PRODUCTOS VENCIDOS ##############################
    public function BuscarProductosVencidos()
    {
        self::SetNames();

        $var = $_GET['tiempovence'];

        if ($var == '0') {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND fechaexpiracion != null AND productos.fechaexpiracion <= '" . date("Y-m-d") . "' ORDER BY productos.codproducto";
        } else {

            $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND fechaexpiracion between curdate() and date_add(curdate(), interval '" . $var . "' day) ORDER BY productos.codproducto";
        }
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS VENCIDOS EN LA SUCURSAL SELECCIONADA</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################## FUNCION LISTAR PRODUCTOS VENCIDOS ##############################


    ################################## FUNCION LISTAR DETALLES KARDEX ##################################
    public function VerDetallesKardexProducto()
    {
        self::SetNames();
        $sql = "SELECT kardexproductos.codproductom, kardexproductos.codresponsable, kardexproductos.movimiento, kardexproductos.entradacaja, kardexproductos.entradaunidad, kardexproductos.entradacajano, kardexproductos.entradabonif, kardexproductos.salidacaja, kardexproductos.salidaunidad, kardexproductos.salidabonif, kardexproductos.devolucioncaja, kardexproductos.devolucionunidad, kardexproductos.devolucionbonif, kardexproductos.stocktotalcaja, kardexproductos.stocktotalunidad, kardexproductos.preciocompram, kardexproductos.precioventaunidadm, kardexproductos.precioventacajam, kardexproductos.ivaproductom, kardexproductos.descproductom, kardexproductos.documento, kardexproductos.fechakardex, proveedores.nomproveedor as proveedor, sucursales.razonsocial, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardexproductos ON productos.codproducto=kardexproductos.codproductom) LEFT JOIN proveedores ON proveedores.codproveedor=kardexproductos.codresponsable LEFT JOIN sucursales ON sucursales.codsucursal=kardexproductos.codsucursalm LEFT JOIN clientes ON clientes.codcliente=kardexproductos.codresponsable WHERE kardexproductos.codproductom = ? AND kardexproductos.codsucursalm = ? GROUP BY kardexproductos.codproductom, kardexproductos.documento ORDER BY  kardexproductos.codkardex ASC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codproducto"]), base64_decode($_GET['codsucursal'])));
        $num = $stmt->rowCount();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################# FUNCION LISTAR DETALLES KARDEX ##################################

    ################################# FUNCION LISTAR KARDEX PRODUCTOS ##################################
    public function ListarKardexProductos()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT productos.producto, productos.principioactivo, kardexproductos.codkardex, kardexproductos.codproductom, kardexproductos.codresponsable, kardexproductos.movimiento, kardexproductos.entradacaja, kardexproductos.entradaunidad, kardexproductos.entradacajano, kardexproductos.entradabonif, kardexproductos.salidacaja, kardexproductos.salidaunidad, kardexproductos.salidabonif, kardexproductos.devolucioncaja, kardexproductos.devolucionunidad, kardexproductos.devolucionbonif, kardexproductos.stocktotalcaja, kardexproductos.stocktotalunidad, kardexproductos.preciocompram, kardexproductos.precioventaunidadm, kardexproductos.precioventacajam, kardexproductos.ivaproductom, kardexproductos.descproductom, kardexproductos.documento, kardexproductos.fechakardex, proveedores.nomproveedor as proveedor, sucursales.razonsocial, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardexproductos ON productos.codproducto=kardexproductos.codproductom) LEFT JOIN proveedores ON proveedores.codproveedor=kardexproductos.codresponsable LEFT JOIN sucursales ON sucursales.codsucursal=kardexproductos.codsucursalm LEFT JOIN clientes ON clientes.codcliente=kardexproductos.codresponsable";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = "SELECT productos.producto, productos.principioactivo, kardexproductos.codkardex, kardexproductos.codproductom, kardexproductos.codresponsable, kardexproductos.movimiento, kardexproductos.entradacaja, kardexproductos.entradaunidad, kardexproductos.entradacajano, kardexproductos.entradabonif, kardexproductos.salidacaja, kardexproductos.salidaunidad, kardexproductos.salidabonif, kardexproductos.devolucioncaja, kardexproductos.devolucionunidad, kardexproductos.devolucionbonif, kardexproductos.stocktotalcaja, kardexproductos.stocktotalunidad, kardexproductos.preciocompram, kardexproductos.precioventaunidadm, kardexproductos.precioventacajam, kardexproductos.ivaproductom, kardexproductos.descproductom, kardexproductos.documento, kardexproductos.fechakardex, proveedores.nomproveedor as proveedor, sucursales.razonsocial, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardexproductos ON productos.codproducto=kardexproductos.codproductom) LEFT JOIN proveedores ON proveedores.codproveedor=kardexproductos.codresponsable LEFT JOIN sucursales ON sucursales.codsucursal=kardexproductos.codsucursalm LEFT JOIN clientes ON clientes.codcliente=kardexproductos.codresponsable WHERE kardexproductos.codsucursalm = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION LISTAR KARDEX PRODUCTOS ##################################

    ###################################### FUNCION DETALLES KARDEX ##################################
    public function VerDetalleKardexModal()
    {
        self::SetNames();
        $sql = "SELECT productos.producto, productos.principioactivo, productos.descripcion, presentaciones.nompresentacion, medidas.nommedida, kardexproductos.codproductom, kardexproductos.codresponsable, kardexproductos.movimiento, kardexproductos.entradacaja, kardexproductos.entradaunidad, kardexproductos.entradacajano, kardexproductos.entradabonif, kardexproductos.salidacaja, kardexproductos.salidaunidad, kardexproductos.salidabonif, kardexproductos.devolucioncaja, kardexproductos.devolucionunidad, kardexproductos.devolucionbonif, kardexproductos.stocktotalcaja, kardexproductos.stocktotalunidad, kardexproductos.preciocompram, kardexproductos.precioventaunidadm, kardexproductos.precioventacajam, kardexproductos.ivaproductom, kardexproductos.descproductom, kardexproductos.documento, kardexproductos.fechakardex, proveedores.nomproveedor as proveedor, sucursales.razonsocial, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardexproductos ON productos.codproducto=kardexproductos.codproductom) LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida=medidas.codmedida LEFT JOIN proveedores ON proveedores.codproveedor=kardexproductos.codresponsable LEFT JOIN sucursales ON sucursales.codsucursal=kardexproductos.codsucursalm LEFT JOIN clientes ON clientes.codcliente=kardexproductos.codresponsable WHERE kardexproductos.codkardex = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codkardex"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION DETALLES KARDEX ##################################

    ################################# FUNCION BUSCAR KARDEX PRODUCTOS ##################################
    public function BuscarKardexProducto()
    {
        self::SetNames();
        $sql = "SELECT * FROM (productos LEFT JOIN kardexproductos ON productos.codproducto=kardexproductos.codproductom) LEFT JOIN sucursales ON kardexproductos.codsucursalm=sucursales.codsucursal  LEFT JOIN presentaciones ON productos.codpresentacion=presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida=medidas.codmedida WHERE kardexproductos.codproductom = ? AND kardexproductos.codsucursalm = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codproducto"], $_GET["codsucursal"]));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS EN KARDEX PARA EL PRODUCTO INGRESADO</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION BUSCAR KARDEX PRODUCTOS ##################################

    ################################ FIN DE CLASE PRODUCTOS EN ALMACEN ##############################








































    ################################## CLASE TRASPASO DE PRODUCTOS #####################################

    ############################## FUNCION LISTAR SUCURSAL PARA TRASPASO ##########################
    public function ListarSucursalTraspaso()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT * FROM sucursales WHERE codsucursal != ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['envio'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<option value='0' selected>SELECCIONE</option>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT * FROM sucursales WHERE codsucursal != '" . $_SESSION['codsucursal'] . "'";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "";
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ############################ FUNCION LISTAR SUCURSAL PARA TRASPASO #############################

    ######################### FUNCION PRODUCTOS POR LABORATORIOS PARA TRASPASO ########################
    public function BuscarProductosTraspasos()
    {
        self::SetNames();

        $sql = "SELECT * FROM (productos LEFT JOIN sucursales ON productos.codsucursal = sucursales.codsucursal) LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE productos.codsucursal = ? AND productos.codlaboratorio = ? ORDER BY productos.codproducto";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['envio'])));
        $stmt->bindValue(2, trim(base64_decode($_GET['codlaboratorio'])));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS PARA LA SUCURSAL Y LABORATORIO SELECCIONADO</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ######################### FUNCION PRODUCTOS POR LABORATORIOS PARA TRASPASO ########################

    ############################## FUNCION REGISTRAR TRASPASO DE PRODCUTOS ############################
    public function RegistrarTraspaso()
    {
        self::SetNames();
        if (empty($_POST["envio"]) or empty($_POST["recibe"])) {
            echo "1";
            exit;
        }

        if (empty($_SESSION["CarritoT"])) {
            echo "2";
            exit;
        } else {

            ################### AQUI CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ####################
            $sql = " SELECT * FROM sucursales INNER JOIN usuarios ON sucursales.codsucursal = usuarios.codsucursal WHERE usuarios.codigo = '" . $_SESSION["codigo"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            $nrosucursal = $row['nrosucursal'];
            $codactividad = $row['nroactividadsucursal'];
            $iniciofactura = $row['nroiniciofactura'];


            $sql = " select nrotraspaso from traspasoproductos where envio = '" . $_POST["envio"] . "' order by nrotraspaso desc limit 1";
            foreach ($this->dbh->query($sql) as $row) {

                $nrotraspaso = $row["nrotraspaso"];
            }
            if (empty($nrotraspaso)) {
                $numero = $nrosucursal . '-' . $codactividad . '-000000001';
            } else {
                $venta = substr($nrotraspaso, 0, -9);
                $coun = strlen($venta);
                $num     = substr($nrotraspaso, $coun);
                $dig     = $num + 1;
                $codigo = str_pad($dig, 9, "0", STR_PAD_LEFT);
                $numero = $nrosucursal . '-' . $codactividad . '-' . $codigo;
            }
            ################### AQUI CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ####################

            ################### AQUI VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ###################
            $t = $_SESSION["CarritoT"];
            for ($i = 0; $i < count($t); $i++) {

                $sql = "select stockcajas from productos where codproducto = '" . $t[$i]['txtCodigo'] . "' AND codsucursal = '" . $_POST['envio'] . "'";
                foreach ($this->dbh->query($sql) as $row) {
                    $this->p[] = $row;
                }

                $existenciadb = $row['stockcajas'];
                $cantidad = $t[$i]['cantidad'];

                if ($cantidad > $existenciadb) {
                    echo "3";
                    exit;
                }
            }


            $fecha = date("Y-m-d h:i:s");

            $traspaso = $_SESSION["CarritoT"];
            for ($i = 0; $i < count($traspaso); $i++) {

                $sql = "select stockcajas, unidades, stocktotal from productos where codproducto = '" . $traspaso[$i]['txtCodigo'] . "' AND codsucursal = '" . $_POST['envio'] . "'";
                foreach ($this->dbh->query($sql) as $row) {
                    $this->p[] = $row;
                }

                $stockcajasdb = $row['stockcajas'];
                $stocktotaldb = $row['stocktotal'];
                $unidadesdb = $row['unidades'];


                $query = " insert into traspasoproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $nro);
                $stmt->bindParam(2, $envio);
                $stmt->bindParam(3, $recibe);
                $stmt->bindParam(4, $codproducto);
                $stmt->bindParam(5, $preciocaja);
                $stmt->bindParam(6, $preciounidad);
                $stmt->bindParam(7, $cantenvio);
                $stmt->bindParam(8, $fechatraspaso);
                $stmt->bindParam(9, $codigo);

                $nro = strip_tags($numero);
                $envio = strip_tags($_POST['envio']);
                $recibe = strip_tags($_POST['recibe']);
                $codproducto = strip_tags($traspaso[$i]['txtCodigo']);
                $preciocaja = strip_tags($traspaso[$i]['precio2']);
                $preciounidad = strip_tags($traspaso[$i]['precio3']);
                $cantenvio = strip_tags($traspaso[$i]['cantidad']);
                $fechatraspaso = strip_tags($fecha);
                $codigo = strip_tags($_SESSION["codigo"]);
                $stmt->execute();

                ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
                $sql = " update productos set "
                    . " stockcajas = ?, "
                    . " stocktotal = ? "
                    . " where "
                    . " codproducto = '" . $traspaso[$i]['txtCodigo'] . "' AND codsucursal = '" . $_POST['envio'] . "';
			   ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $stocajas);
                $stmt->bindParam(2, $stototal);
                $cantidad = strip_tags($traspaso[$i]['cantidad']);

                $stocajas = $stockcajasdb - $cantidad;

                $restounidad = $cantidad * $traspaso[$i]['unidades'];
                $stototal = $row['stocktotal'] - $restounidad;
                $stmt->execute();


                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codventa);
                $stmt->bindParam(2, $codcliente);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);
                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);
                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);
                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);
                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);

                $codventa = strip_tags($numero);
                $codcliente = strip_tags("0");
                $codsucursalm = strip_tags($_POST["envio"]);
                $codproductom = strip_tags($traspaso[$i]['txtCodigo']);
                $movimiento = strip_tags("SALIDAS");
                $entradacaja = strip_tags("0");
                $entradaunidad = strip_tags("0");
                $entradacajano = strip_tags("0");
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags($traspaso[$i]['cantidad']);
                $salidabonif = strip_tags("0");
                $devolucioncaja = strip_tags("0");
                $devolucionunidad = strip_tags("0");
                $devolucionbonif = strip_tags("0");
                $cantcaja = strip_tags("0");
                $stocktotalcaja = strip_tags("0");
                $cantidad = strip_tags($traspaso[$i]['cantidad'] + $traspaso[$i]['cantidad2']);

                $restounidad = $cantidad * $traspaso[$i]['unidades'];
                $stocktotalunidad = $row['stocktotal'] - $restounidad;

                //$stocktotalunidad = $row['stocktotal'] - $cantidad;
                $preciocompram = strip_tags($traspaso[$i]["precio"]);
                $precioventacajam = strip_tags($traspaso[$i]["precio2"]);
                $precioventaunidadm = strip_tags($traspaso[$i]["precio3"]);
                $ivaproducto = strip_tags($traspaso[$i]['ivaproducto']);
                $descproducto = strip_tags($traspaso[$i]['descproducto']);
                $documento = strip_tags("TRASPASO - FACTURA: " . $numero);
                $fechakardex = strip_tags($fecha);
                $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################


                $sql = " select codproducto from productos where codproducto = ? AND codsucursal = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($traspaso[$i]['txtCodigo'], $_POST['recibe']));
                $num = $stmt->rowCount();
                if ($num == 0) {

                    $sql = "select * from productos where codproducto = '" . $traspaso[$i]['txtCodigo'] . "' AND codsucursal = '" . $_POST['envio'] . "'";
                    foreach ($this->dbh->query($sql) as $roww) {
                        $this->p[] = $roww;
                    }


                    ##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ####################################
                    $query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $codproducto);
                    $stmt->bindParam(2, $producto);
                    $stmt->bindParam(3, $principioactivo);
                    $stmt->bindParam(4, $descripcion);
                    $stmt->bindParam(5, $codpresentacion);
                    $stmt->bindParam(6, $codmedida);
                    $stmt->bindParam(7, $preciocompra);
                    $stmt->bindParam(8, $precioventacaja);
                    $stmt->bindParam(9, $precioventaunidad);
                    $stmt->bindParam(10, $stockcajas);
                    $stmt->bindParam(11, $unidades);
                    $stmt->bindParam(12, $stockunidad);
                    $stmt->bindParam(13, $stocktotal);
                    $stmt->bindParam(14, $stockminimo);
                    $stmt->bindParam(15, $ivaproducto);
                    $stmt->bindParam(16, $descproducto);
                    $stmt->bindParam(17, $fechaelaboracion);
                    $stmt->bindParam(18, $fechaexpiracion);
                    $stmt->bindParam(19, $codigobarra);
                    $stmt->bindParam(20, $codlaboratorio);
                    $stmt->bindParam(21, $codproveedor);
                    $stmt->bindParam(22, $codsucursal);
                    $stmt->bindParam(23, $loteproducto);

                    $codproducto = strip_tags($traspaso[$i]["txtCodigo"]);
                    $producto = strip_tags($traspaso[$i]["producto"]);
                    $principioactivo = strip_tags($traspaso[$i]["principioactivo"]);
                    $descripcion = strip_tags($traspaso[$i]["descripcion"]);
                    $codpresentacion = strip_tags($traspaso[$i]["presentacion"]);
                    $codmedida = strip_tags($traspaso[$i]["tipo"]);
                    $preciocompra = strip_tags($traspaso[$i]["precio"]);
                    $precioventacaja = strip_tags($traspaso[$i]["precio2"]);
                    $precioventaunidad = strip_tags($traspaso[$i]["precio3"]);
                    $stockcajas = strip_tags($traspaso[$i]['cantidad']);
                    $unidades = strip_tags($traspaso[$i]["unidades"]);
                    $stockunidad = strip_tags("0");
                    $stocktotal = strip_tags($traspaso[$i]['cantidad'] * $traspaso[$i]["unidades"]);
                    $stockminimo = strip_tags($roww["stockminimo"]);
                    $ivaproducto = strip_tags($traspaso[$i]["ivaproducto"]);
                    $descproducto = strip_tags($traspaso[$i]["descproducto"]);
                    $fechaelaboracion = strip_tags($roww['fechaelaboracion']);
                    $fechaexpiracion = strip_tags($traspaso[$i]['fechaexpiracion']);
                    $codigobarra = strip_tags($roww["codigobarra"]);
                    $codlaboratorio = strip_tags($roww["codlaboratorio"]);
                    $codproveedor = strip_tags($roww["codproveedor"]);
                    $codsucursal = strip_tags($_POST["recibe"]);
                    $loteproducto = strip_tags($roww["loteproducto"]);
                    $stmt->execute();
                    ##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ##########################


                    ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                    $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $codcompra);
                    $stmt->bindParam(2, $codproveedor);
                    $stmt->bindParam(3, $codsucursalm);
                    $stmt->bindParam(4, $codproductom);
                    $stmt->bindParam(5, $movimiento);
                    $stmt->bindParam(6, $entradacaja);
                    $stmt->bindParam(7, $entradaunidad);
                    $stmt->bindParam(8, $entradacajano);
                    $stmt->bindParam(9, $entradabonif);
                    $stmt->bindParam(10, $salidacajas);
                    $stmt->bindParam(11, $salidaunidad);
                    $stmt->bindParam(12, $salidabonif);
                    $stmt->bindParam(13, $devolucioncaja);
                    $stmt->bindParam(14, $devolucionunidad);
                    $stmt->bindParam(15, $devolucionbonif);
                    $stmt->bindParam(16, $stocktotalcaja);
                    $stmt->bindParam(17, $stocktotalunidad);
                    $stmt->bindParam(18, $preciocompram);
                    $stmt->bindParam(19, $precioventaunidadm);
                    $stmt->bindParam(20, $precioventacajam);
                    $stmt->bindParam(21, $ivaproducto);
                    $stmt->bindParam(22, $descproducto);
                    $stmt->bindParam(23, $documento);
                    $stmt->bindParam(24, $fechakardex);

                    $codcompra = strip_tags($numero);
                    $codproveedor = strip_tags($roww["codproveedor"]);
                    $codsucursalm = strip_tags($_POST["recibe"]);
                    $codproductom = strip_tags($traspaso[$i]['txtCodigo']);
                    $movimiento = strip_tags("ENTRADAS");
                    $entradacaja = strip_tags($traspaso[$i]['cantidad']);
                    $entradaunidad = strip_tags($traspaso[$i]['unidades']);
                    $entradacajano = strip_tags("0");
                    $entradabonif = strip_tags("0");
                    $salidacajas = strip_tags("0");
                    $salidaunidad = strip_tags("0");
                    $salidabonif = strip_tags("0");
                    $devolucioncaja = strip_tags("0");
                    $devolucionunidad = strip_tags("0");
                    $devolucionbonif = strip_tags("0");
                    $stocktotalcaja = strip_tags($traspaso[$i]['cantidad'] + $traspaso[$i]['cantidad2']);
                    $stocktotalunidad = strip_tags($stocktotalcaja * $traspaso[$i]['unidades']);
                    $preciocompram = strip_tags($traspaso[$i]["precio"]);
                    $precioventacajam = strip_tags($traspaso[$i]["precio2"]);
                    $precioventaunidadm = strip_tags($traspaso[$i]["precio3"]);
                    $ivaproducto = strip_tags($traspaso[$i]['ivaproducto']);
                    $descproducto = strip_tags($traspaso[$i]['descproducto']);
                    $documento = strip_tags("TRASPASO - FACTURA: " . $numero);
                    $fechakardex = strip_tags($fecha);
                    $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

                } else {

                    $sql = "select codproveedor, stockcajas, unidades, stocktotal from productos where codproducto = '" . $traspaso[$i]['txtCodigo'] . "' AND codsucursal = '" . $_POST['recibe'] . "'";
                    foreach ($this->dbh->query($sql) as $row) {
                        $this->p[] = $row;
                    }

                    $stockcajasdb = $row['stockcajas'];
                    $stocktotaldb = $row['stocktotal'];
                    $unidadesdb = $row['unidades'];

                    ##################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ###################
                    $sql = " update productos set "
                        . " preciocompra = ?, "
                        . " precioventaunidad = ?, "
                        . " precioventacaja = ?, "
                        . " stockcajas = ?, "
                        . " unidades = ?, "
                        . " stocktotal = ?, "
                        . " ivaproducto = ?, "
                        . " descproducto = ? "
                        . " where "
                        . " codproducto = ?;
			   ";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $preciocompra);
                    $stmt->bindParam(2, $precioventaunidad);
                    $stmt->bindParam(3, $precioventacaja);
                    $stmt->bindParam(4, $stockcajas);
                    $stmt->bindParam(5, $unidades);
                    $stmt->bindParam(6, $stocktotal);
                    $stmt->bindParam(7, $ivaproducto);
                    $stmt->bindParam(8, $descproducto);
                    $stmt->bindParam(9, $codigo);

                    $preciocompra = strip_tags($traspaso[$i]['precio']);
                    $precioventaunidad = strip_tags($traspaso[$i]['precio2']);
                    $precioventacaja = strip_tags($traspaso[$i]['precio3']);
                    $cantcaja = strip_tags($traspaso[$i]['cantidad']);
                    $stockcajas = $cantcaja + $stockcajasdb;
                    $unidades = strip_tags($traspaso[$i]['unidades']);
                    $canttotal = strip_tags($cantcaja * $traspaso[$i]['unidades']);
                    $stocktotal = $canttotal + $stocktotaldb;
                    $ivaproducto = strip_tags($traspaso[$i]['ivaproducto']);
                    $descproducto = strip_tags($traspaso[$i]['descproducto']);
                    $codigo = strip_tags($traspaso[$i]['txtCodigo']);
                    $stmt->execute();


                    ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                    $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $codcompra);
                    $stmt->bindParam(2, $codproveedor);
                    $stmt->bindParam(3, $codsucursalm);
                    $stmt->bindParam(4, $codproductom);
                    $stmt->bindParam(5, $movimiento);
                    $stmt->bindParam(6, $entradacaja);
                    $stmt->bindParam(7, $entradaunidad);
                    $stmt->bindParam(8, $entradacajano);
                    $stmt->bindParam(9, $entradabonif);
                    $stmt->bindParam(10, $salidacajas);
                    $stmt->bindParam(11, $salidaunidad);
                    $stmt->bindParam(12, $salidabonif);
                    $stmt->bindParam(13, $devolucioncaja);
                    $stmt->bindParam(14, $devolucionunidad);
                    $stmt->bindParam(15, $devolucionbonif);
                    $stmt->bindParam(16, $stocktotalcaja);
                    $stmt->bindParam(17, $stocktotalunidad);
                    $stmt->bindParam(18, $preciocompram);
                    $stmt->bindParam(19, $precioventaunidadm);
                    $stmt->bindParam(20, $precioventacajam);
                    $stmt->bindParam(21, $ivaproducto);
                    $stmt->bindParam(22, $descproducto);
                    $stmt->bindParam(23, $documento);
                    $stmt->bindParam(24, $fechakardex);

                    $codcompra = strip_tags($numero);
                    $codproveedor = strip_tags($row["codproveedor"]);
                    $codsucursalm = strip_tags($_POST["recibe"]);
                    $codproductom = strip_tags($traspaso[$i]['txtCodigo']);
                    $movimiento = strip_tags("ENTRADAS");
                    $entradacaja = strip_tags($traspaso[$i]['cantidad']);
                    $entradaunidad = strip_tags($traspaso[$i]['unidades']);
                    $entradacajano = strip_tags("0");
                    $entradabonif = strip_tags("0");
                    $salidacajas = strip_tags("0");
                    $salidaunidad = strip_tags("0");
                    $salidabonif = strip_tags("0");
                    $devolucioncaja = strip_tags("0");
                    $devolucionunidad = strip_tags("0");
                    $devolucionbonif = strip_tags("0");

                    $cantcaja = strip_tags($traspaso[$i]['cantidad'] + $traspaso[$i]['cantidad2']);
                    $stocktotalcaja = $cantcaja + $stockcajasdb;

                    $stocktotalunidad = strip_tags($stocktotalcaja * $traspaso[$i]['unidades']);

                    $preciocompram = strip_tags($traspaso[$i]["precio"]);
                    $precioventacajam = strip_tags($traspaso[$i]["precio2"]);
                    $precioventaunidadm = strip_tags($traspaso[$i]["precio3"]);
                    $ivaproducto = strip_tags($traspaso[$i]['ivaproducto']);
                    $descproducto = strip_tags($traspaso[$i]['descproducto']);
                    $documento = strip_tags("TRASPASO - FACTURA: " . $numero);
                    $fechakardex = strip_tags($fecha);
                    $stmt->execute();
                    ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

                }
            }

            unset($_SESSION["CarritoT"]);

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL TRASPASO DE PRODUCTOS FUE REALIZADO EXITOSAMENTE</div>";
            echo "</div>";
            exit;
        }
    }
    ################################ FUNCION REGISTRAR TRASPASO DE PRODUCTOS ##########################

    ########################## FUNCION LISTAR PRODUCTOS PARA TRASPASOS ############################
    public function ListarTraspasos()
    {
        self::SetNames();
        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT productos.producto, productos.principioactivo, traspasoproductos.codproductot, traspasoproductos.envio, traspasoproductos.recibe, traspasoproductos.cantenvio, traspasoproductos.fechatraspaso, sucursales.razonsocial as enviado, sucursal.razonsocial as recibido, presentaciones.nompresentacion, medidas.nommedida FROM traspasoproductos INNER JOIN productos ON traspasoproductos.codproductot = productos.codproducto LEFT JOIN sucursales ON traspasoproductos.envio=sucursales.codsucursal LEFT JOIN sucursales as sucursal ON traspasoproductos.recibe=sucursal.codsucursal LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida GROUP BY productos.codproducto";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT productos.producto, productos.principioactivo, traspasoproductos.codproductot, traspasoproductos.envio, traspasoproductos.recibe, traspasoproductos.cantenvio, traspasoproductos.fechatraspaso, sucursales.razonsocial as enviado, sucursal.razonsocial as recibido, presentaciones.nompresentacion, medidas.nommedida FROM traspasoproductos INNER JOIN productos ON traspasoproductos.codproductot = productos.codproducto LEFT JOIN sucursales ON traspasoproductos.envio=sucursales.codsucursal LEFT JOIN sucursales as sucursal ON traspasoproductos.recibe=sucursal.codsucursal LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida WHERE traspasoproductos.envio = '" . $_SESSION["codsucursal"] . "' GROUP BY productos.codproducto";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################## FUNCION LISTAR PRODUCTOS PARA TRASPASOS ##############################

    ########################## FUNCION BUSCAR TRASPASO DE PRODUCTOS ##############################
    public function BuscarTraspasosFechas()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT productos.producto, productos.principioactivo, traspasoproductos.codproductot, traspasoproductos.envio, traspasoproductos.recibe, traspasoproductos.preciocajat, traspasoproductos.preciounidadt, traspasoproductos.cantenvio, traspasoproductos.fechatraspaso, sucursales.razonsocial as enviado, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, sucursal.razonsocial as recibido, presentaciones.nompresentacion, medidas.nommedida FROM traspasoproductos INNER JOIN productos ON traspasoproductos.codproductot = productos.codproducto LEFT JOIN sucursales ON traspasoproductos.envio=sucursales.codsucursal LEFT JOIN sucursales as sucursal ON traspasoproductos.recibe=sucursal.codsucursal LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida WHERE traspasoproductos.envio = ? AND traspasoproductos.recibe = ? AND DATE_FORMAT(traspasoproductos.fechatraspaso,'%Y-%m-%d') >= ? AND DATE_FORMAT(traspasoproductos.fechatraspaso,'%Y-%m-%d') <= ? GROUP BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['envio'])));
            $stmt->bindValue(2, trim(base64_decode($_GET['recibe'])));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(4, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN TRASPASOS DE PRODUCTOS PARA LAS SUCURSALES Y FECHA SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = " SELECT productos.producto, productos.principioactivo, traspasoproductos.codproductot, traspasoproductos.envio, traspasoproductos.recibe, traspasoproductos.preciocajat, traspasoproductos.preciounidadt, traspasoproductos.cantenvio, traspasoproductos.fechatraspaso, sucursales.razonsocial as enviado, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, sucursal.razonsocial as recibido, presentaciones.nompresentacion, medidas.nommedida FROM traspasoproductos INNER JOIN productos ON traspasoproductos.codproductot = productos.codproducto LEFT JOIN sucursales ON traspasoproductos.envio=sucursales.codsucursal LEFT JOIN sucursales as sucursal ON traspasoproductos.recibe=sucursal.codsucursal LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida WHERE traspasoproductos.envio = ? AND traspasoproductos.recibe = ? AND DATE_FORMAT(traspasoproductos.fechatraspaso,'%Y-%m-%d') >= ? AND DATE_FORMAT(traspasoproductos.fechatraspaso,'%Y-%m-%d') <= ? GROUP BY productos.codproducto";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['envio'])));
            $stmt->bindValue(2, trim(base64_decode($_GET['recibe'])));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(4, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN TRASPASOS DE PRODUCTOS PARA LAS SUCURSALES Y FECHA SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ############################## FUNCION BUSCAR TRASPASO DE PRODUCTOS ##############################

    ################################## CLASE TRASPASO DE PRODUCTOS #####################################





































    ##################################### CLASE PEDIDOS DE PRODUCTOS ###################################

    ###################################### FUNCION CODIGO PEDIDOS ##################################
    public function CodigoPedidos()
    {
        self::SetNames();
        $sql = " select codpedido from pedidos where codigo = '" . $_SESSION["codigo"] . "' and DATE_FORMAT(fechapedido,'%Y-%m-%d') = '" . date("Y-m-d") . "' order by codpedido desc limit 1";
        foreach ($this->dbh->query($sql) as $row) {

            $fecha = date("Y-m-d");
            $year = date("Y");
            $mes = date("m");
            $day = date("d");
            $codpedido["codpedido"] = $row["codpedido"];
        }
        if (empty($codpedido["codpedido"])) {

            echo $factura = date("Y") . '-' . date("m") . '' . date("d") . '-' . 'P' . $_SESSION["codigo"] . '00001';
        } else {
            $resto = substr($codpedido["codpedido"], 0, -5);
            $coun = strlen($resto);
            $num     = substr($codpedido["codpedido"], $coun);
            $dig     = $num + 1;
            $cod = str_pad($dig, 5, "0", STR_PAD_LEFT);
            echo $factura = $year . '-' . $mes . '' . $day . '-P' . $_SESSION["codigo"] . $cod;
        }
    }
    ################################ FUNCION CODIGO PEDIDOS ####################################

    ################################ FUNCION REGISTRAR PEDIDOS ####################################
    public function RegistrarPedidos()
    {
        self::SetNames();
        if (empty($_POST["codpedido"]) or empty($_POST["codproveedor"]) or empty($_POST["codsucursal"])) {
            echo "1";
            exit;
        }

        if (empty($_SESSION["CarritoP"])) {
            echo "2";
            exit;
        } else {

            $fecha = date("Y-m-d h:i:s");

            $query = " insert into pedidos values (?, ?, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $codpedido);
            $stmt->bindParam(2, $codproveedor);
            $stmt->bindParam(3, $codsucursal);
            $stmt->bindParam(4, $fechapedido);
            $stmt->bindParam(5, $codigo);

            $codpedido = strip_tags($_POST['codpedido']);
            $codproveedor = strip_tags($_POST['codproveedor']);
            $codsucursal = strip_tags($_POST['codsucursal']);
            $fechapedido = strip_tags($fecha);
            $codigo = strip_tags($_SESSION['codigo']);
            $stmt->execute();

            $pedidos = $_SESSION["CarritoP"];
            for ($i = 0; $i < count($pedidos); $i++) {

                $query = " insert into detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codpedido);
                $stmt->bindParam(2, $codlaboratorio);
                $stmt->bindParam(3, $codproducto);
                $stmt->bindParam(4, $producto);
                $stmt->bindParam(5, $principioactivo);
                $stmt->bindParam(6, $descripcion);
                $stmt->bindParam(7, $presentacion);
                $stmt->bindParam(8, $codmedida);
                $stmt->bindParam(9, $cantidad);
                $stmt->bindParam(10, $fechadetallepedido);

                $codpedido = strip_tags($_POST['codpedido']);
                $codlaboratorio = strip_tags($pedidos[$i]['laboratorio']);
                $codproducto = strip_tags($pedidos[$i]['txtCodigo']);
                $producto = strip_tags($pedidos[$i]['producto']);
                $principioactivo = strip_tags($pedidos[$i]['principioactivo']);
                $descripcion = strip_tags($pedidos[$i]['descripcion']);
                $presentacion = strip_tags($pedidos[$i]['presentacion']);
                $cantidad = strip_tags($pedidos[$i]['cantidad']);
                $codmedida = strip_tags($pedidos[$i]['tipo']);
                $fechadetallepedido = strip_tags($fecha);
                $stmt->execute();
            }
            ################# DESTRUIMOS LAS VARIABLES DE SESSION DE PEDIDOS #################
            unset($_SESSION["CarritoP"]);

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL PEDIDO DE PRODUCTOS FUE REGISTRADO EXITOSAMENTE <a href='reportepdf?codpedido=" . base64_encode($codpedido) . "&tipo=" . base64_encode("PEDIDOS") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR PEDIDO</strong></a></div>";
            echo "<script>window.open('reportepdf?codpedido=" . base64_encode($codpedido) . "&tipo=" . base64_encode("PEDIDOS") . "', '_blank');</script>";

            exit;
        }
    }
    ################################ FUNCION REGISTRAR PEDIDOS ####################################

    ################################ FUNCION LISTAR PEDIDOS ####################################
    public function ListarPedidos()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT pedidos.codpedido, pedidos.fechapedido, proveedores.nomproveedor, sucursales.razonsocial FROM (pedidos LEFT JOIN proveedores ON pedidos.codproveedor = proveedores.codproveedor) LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT pedidos.codpedido, pedidos.fechapedido, proveedores.nomproveedor, sucursales.razonsocial FROM (pedidos LEFT JOIN proveedores ON pedidos.codproveedor = proveedores.codproveedor) LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo WHERE pedidos.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION LISTAR PEDIDOS ####################################

    ############################# FUNCION LISTAR DETALLES PEDIDOS #################################
    public function ListarDetallesPedidos()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT * FROM detallepedidos INNER JOIN presentaciones ON detallepedidos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON detallepedidos.codmedida = medidas.codmedida LEFT JOIN laboratorios ON detallepedidos.codlaboratorio = laboratorios.codlaboratorio";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT * FROM detallepedidos INNER JOIN presentaciones ON detallepedidos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON detallepedidos.codmedida = medidas.codmedida LEFT JOIN laboratorios ON detallepedidos.codlaboratorio = laboratorios.codlaboratorio LEFT JOIN pedidos ON detallepedidos.codpedido = pedidos.codpedido LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo WHERE pedidos.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION LISTAR DETALLES PEDIDOS ####################################

    ################################ FUNCION ID PEDIDOS ####################################
    public function PedidosPorId()
    {
        self::SetNames();
        $sql = " SELECT * FROM (pedidos LEFT JOIN proveedores ON pedidos.codproveedor = proveedores.codproveedor) LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo WHERE pedidos.codpedido = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codpedido"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################### FUNCION ID PEDIDOS ####################################

    ############################### FUNCION VER DETALLES PEDIDOS ####################################
    public function VerDetallesPedidos()
    {
        self::SetNames();
        $sql = " SELECT * FROM detallepedidos INNER JOIN presentaciones ON detallepedidos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON detallepedidos.codmedida = medidas.codmedida LEFT JOIN laboratorios ON detallepedidos.codlaboratorio = laboratorios.codlaboratorio WHERE detallepedidos.codpedido = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET["codpedido"])));
        $stmt->execute();
        $num = $stmt->rowCount();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################ FUNCION VER DETALLES PEDIDOS ####################################

    ################################ FUNCION ID DETALLES PEDIDOS ####################################
    public function DetallesPedidosPorId()
    {
        self::SetNames();
        $sql = " SELECT * FROM detallepedidos INNER JOIN presentaciones ON detallepedidos.codpresentacion = presentaciones.codpresentacion INNER JOIN medidas ON detallepedidos.codmedida = medidas.codmedida LEFT JOIN laboratorios ON detallepedidos.codlaboratorio = laboratorios.codlaboratorio LEFT JOIN pedidos ON detallepedidos.codpedido = pedidos.codpedido LEFT JOIN sucursales ON pedidos.codsucursal = sucursales.codsucursal LEFT JOIN proveedores ON pedidos.codproveedor = proveedores.codproveedor LEFT JOIN usuarios ON pedidos.codigo = usuarios.codigo WHERE detallepedidos.coddetallepedido = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["coddetallepedido"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION ID DETALLES PEDIDOS ####################################

    ################################ FUNCION ACTUALIZAR PEDIDOS ####################################
    public function ActualizarPedidos()
    {
        if (empty($_POST["codpedido"]) or empty($_POST["codproveedor"]) or empty($_POST["codsucursal"])) {
            echo "1";
            exit;
        }

        if (isset($_POST['codproducto'])) {

            $producto = $_POST['codproducto'];
            $repeated = array_filter(array_count_values($producto), function ($count) {
                return $count > 1;
            });
            foreach ($repeated as $key => $value) {
                echo "2";
                exit;
            }
        }

        self::SetNames();
        $sql = " update pedidos set "
            . " codproveedor = ?, "
            . " codsucursal = ? "
            . " where "
            . " codpedido = ?;
		";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $codproveedor);
        $stmt->bindParam(2, $codsucursal);
        $stmt->bindParam(3, $codpedido);

        $codproveedor = strip_tags($_POST["codproveedor"]);
        $codsucursal = strip_tags($_POST["codsucursal"]);
        $codpedido = strip_tags($_POST["codpedido"]);
        $stmt->execute();


        for ($i = 0; $i < count($_POST['codproducto']); $i++) {  //recorro el array
            if (!empty($_POST['codproducto'][$i])) {

                $query = " update detallepedidos set "
                    . " cantpedido = ? "
                    . " where "
                    . " codpedido = ? and codproducto = ?;
		";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $cantidad);
                $stmt->bindParam(2, $codpedido);
                $stmt->bindParam(3, $codproducto);

                $cantidad = strip_tags($_POST['cantpedido'][$i]);
                $codpedido = strip_tags($_POST["codpedido"]);
                $codproducto = strip_tags($_POST['codproducto'][$i]);
                $stmt->execute();
            }
        }


        echo "<div class='alert alert-info'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> EL PEDIDO FUE ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codpedido=" . base64_encode($codpedido) . "&tipo=" . base64_encode("PEDIDOS") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR PEDIDO</strong></a>";
        echo "<script>window.open('reportepdf?codpedido=" . base64_encode($codpedido) . "&tipo=" . base64_encode("PEDIDOS") . "', '_blank');</script>";
        exit;
    }
    ################################ FUNCION ACTUALIZAR PEDIDOS ####################################

    ################################ FUNCION ELIMINAR PEDIDOS ####################################
    public function EliminarPedidos()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            $sql = " delete from pedidos where codpedido = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codpedido);
            $codpedido = base64_decode($_GET["codpedido"]);
            $stmt->execute();

            $sql = " delete from detallepedidos where codpedido = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codpedido);
            $codpedido = base64_decode($_GET["codpedido"]);
            $stmt->execute();

            header("Location: pedidos?mesage=1");
            exit;
        } else {
            header("Location: pedidos?mesage=2");
            exit;
        }
    }
    ################################ FUNCION ELIMINAR PEDIDOS ####################################

    ################################ FUNCION ELIMINAR DETALLES PEDIDOS ################################
    public function EliminarDetallesPedidos()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            $sql = " select * from detallepedidos where codpedido = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codpedido"])));
            $nu = $stmt->rowCount();
            if ($nu > 1) {

                $sql = " delete from detallepedidos where coddetallepedido = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $coddetallepedido);
                $coddetallepedido = base64_decode($_GET["coddetallepedido"]);
                $stmt->execute();

                header("Location: detallespedidos?mesage=1");
                exit;
            } else {
                $sql = " delete from pedidos where codpedido = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codpedido);
                $codpedido = base64_decode($_GET["codpedido"]);
                $stmt->execute();

                $sql = " delete from detallepedidos where codpedido = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codpedido);
                $codpedido = base64_decode($_GET["codpedido"]);
                $stmt->execute();

                header("Location: detallespedidos?mesage=1");
                exit;
            }
        } else {
            header("Location: detallespedidos?mesage=2");
            exit;
        }
    }
    ############################# FUNCION ELIMINAR DETALES PEDIDOS ################################

    ################################ FUNCION BUSCAR PEDIDOS ####################################
    public function BuscarPedidosReportes()
    {
        self::SetNames();
        $sql = " SELECT * FROM pedidos INNER JOIN usuarios ON pedidos.codigo = usuarios.codigo WHERE pedidos.codproveedor = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_GET["codproveedor"]));
        $num = $stmt->rowCount();
        if ($num == 0) {

            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO EXISTEN PEDIDOS DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION BUSCAR PEDIDOS ####################################

    ################################## FIN DE CLASE PEDIDOS DE PRODUCTOS ##############################














































    ################################# CLASE COMPRAS DE PRODUCTOS ###################################

    ################################# FUNCION REGISTRAR COMPRAS #####################################
    public function RegistrarCompras()
    {
        self::SetNames();


        //if(empty($_POST["codcompra"]) or empty($_POST["fechaemision"]) or empty($_POST["fecharecepcion"]) or empty($_POST["codproveedor"]))
        if (empty($_POST["codcompra"])) {
            echo "1";
            exit;
        }

        if (strip_tags(isset($_POST['fechavencecredito']))) {
            $fechaactual = date("Y-m-d");
            $fechavence = date("Y-m-d", strtotime($_POST['fechavencecredito']));

            if (strtotime($fechavence) < strtotime($fechaactual)) {
                echo "2";
                exit;
            }
        }

        if (empty($_SESSION["CarritoC"])) {
            echo "3";
            exit;
        } else {
            $sql = " select codcompra from compras where codcompra = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_POST['codcompra']));
            $num = $stmt->rowCount();
            if ($num == 0) {

                $fecha = date("Y-m-d h:i:s");

                $query = " insert into compras values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codcompra);
                $stmt->bindParam(2, $codproveedor);
                $stmt->bindParam(3, $codsucursal);
                $stmt->bindParam(4, $descuentoc);
                $stmt->bindParam(5, $descbonific);
                $stmt->bindParam(6, $subtotalc);
                $stmt->bindParam(7, $totalsinimpuestosc);
                $stmt->bindParam(8, $tarifano);
                $stmt->bindParam(9, $tarifasi);
                $stmt->bindParam(10, $ivac);
                $stmt->bindParam(11, $totalivac);
                $stmt->bindParam(12, $totalc);
                $stmt->bindParam(13, $tipocompra);
                $stmt->bindParam(14, $formacompra);
                $stmt->bindParam(15, $fechavencecredito);
                $stmt->bindParam(16, $statuscompra);
                $stmt->bindParam(17, $fechaemision);
                $stmt->bindParam(18, $fecharecepcion);
                $stmt->bindParam(19, $fechacompra);
                $stmt->bindParam(20, $codigo);

                $codcompra = strip_tags($_POST["codcompra"]);
                $codproveedor = $_POST["codproveedor"] ? strip_tags($_POST["codproveedor"]) : null;
                $codsucursal = $_POST["codsucursal"] ? strip_tags($_POST["codsucursal"]) : null;
                $descuentoc = strip_tags($_POST["txtDescuento"]);
                $descbonific = strip_tags($_POST["txtDescbonif"]);
                $subtotalc = strip_tags($_POST["txtsubtotal"]);
                $totalsinimpuestosc = strip_tags($_POST["txtimpuestos"]);
                $tarifano = strip_tags($_POST["txttarifano"]);
                $tarifasi = strip_tags($_POST["txttarifasi"]);
                $ivac = strip_tags($_POST["iva"]);
                $totalivac = strip_tags($_POST["txtIva"]);
                $totalc = strip_tags($_POST["txtTotal"]);
                $tipocompra = strip_tags($_POST["tipocompra"]);
                if (strip_tags($_POST["tipocompra"] == "CONTADO")) {
                    $formacompra = strip_tags($_POST["formacompra"]);
                } else {
                    $formacompra = "CREDITO";
                }
                if (strip_tags($_POST["tipocompra"] == "CREDITO")) {
                    $fechavencecredito = strip_tags(date("Y-m-d", strtotime($_POST['fechavencecredito'])));
                } else {
                    $fechavencecredito = "0000-00-00";
                }
                if (strip_tags($_POST["tipocompra"] == "CONTADO")) {
                    $statuscompra = strip_tags("PAGADA");
                } else {
                    $statuscompra = "PENDIENTE";
                }
                $fechaemision = strip_tags(date("Y-m-d", strtotime($_POST['fechaemision'])));
                $fecharecepcion = strip_tags(date("Y-m-d", strtotime($_POST['fecharecepcion'])));
                $fechacompra = strip_tags($fecha);
                $codigo = strip_tags($_SESSION["codigo"]);
                //var_dump($stmt);
                $stmt->execute();

                $compra = $_SESSION["CarritoC"];
                for ($i = 0; $i < count($compra); $i++) {

                    $query = "insert into detallecompras values (
		                null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $codcompra);
                    $stmt->bindParam(2, $codproducto);
                    $stmt->bindParam(3, $producto);
                    $stmt->bindParam(4, $principioactivo);
                    $stmt->bindParam(5, $descripcion);
                    $stmt->bindParam(6, $presentacion);
                    $stmt->bindParam(7, $tipo);
                    $stmt->bindParam(8, $precio);
                    $stmt->bindParam(9, $precio2);
                    $stmt->bindParam(10, $precio3);
                    $stmt->bindParam(11, $ivaproducto);
                    $stmt->bindParam(12, $descproducto);
                    $stmt->bindParam(13, $descfactura);
                    $stmt->bindParam(14, $cantidad);
                    $stmt->bindParam(15, $cantidad2);
                    $stmt->bindParam(16, $unidades);
                    $stmt->bindParam(17, $valortotal);
                    $stmt->bindParam(18, $totaldescuentoc);
                    $stmt->bindParam(19, $descbonific);
                    $stmt->bindParam(20, $valorneto);
                    $stmt->bindParam(21, $lote);
                    $stmt->bindParam(22, $fechaelaboracion);
                    $stmt->bindParam(23, $fechaexpiracion);
                    $stmt->bindParam(24, $codigobarra);
                    $stmt->bindParam(25, $codlaboratorio);
                    $stmt->bindParam(26, $fechadetallecompra);
                    $stmt->bindParam(27, $codigo);

                    $codcompra = strip_tags($_POST['codcompra']);
                    $codproducto = strip_tags($compra[$i]['txtCodigo']);
                    $producto = strip_tags($compra[$i]['producto']);
                    $principioactivo = strip_tags($compra[$i]['principioactivo']);
                    $descripcion = strip_tags($compra[$i]['descripcion']);
                    $presentacion = strip_tags($compra[$i]['presentacion']);
                    $tipo = strip_tags($compra[$i]['tipo']);
                    $precio = strip_tags($compra[$i]['precio']);
                    $precio2 = strip_tags($compra[$i]['precio2']);
                    $precio3 = strip_tags($compra[$i]['precio3']);
                    $ivaproducto = strip_tags($compra[$i]['ivaproducto']);
                    $descproducto = $compra[$i]['descproducto'] ? strip_tags($compra[$i]['descproducto']) : null;
                    $descfactura = $compra[$i]['descproductofact'] ? strip_tags($compra[$i]['descproductofact']) : null;
                    $cantidad = strip_tags($compra[$i]['cantidad']);
                    $cantidad2 = strip_tags($compra[$i]['cantidad2']);
                    $unidades = strip_tags($compra[$i]['unidades']);
                    $valortotal = number_format($compra[$i]['precio'] * $compra[$i]['cantidad'], 2);
                    $totaldescuentoc = number_format($valortotal * $descfactura / 100, 2);
                    $descbonific = number_format($compra[$i]['precio'] * $compra[$i]['cantidad2'], 2);
                    $neto = number_format($valortotal - $totaldescuentoc, 2);
                    $valorneto = number_format($neto + $descbonific, 2);

                    $lote = strip_tags($compra[$i]['lote']);
                    if (strip_tags($compra[$i]['fechaelaboracion'] == "")) {
                        $fechaelaboracion = "0000-00-00";
                    } else {
                        $fechaelaboracion = strip_tags(date("Y-m-d", strtotime($compra[$i]['fechaelaboracion'])));
                    }
                    if (strip_tags($compra[$i]['fechaexpiracion'] == "")) {
                        $fechaexpiracion = "0000-00-00";
                    } else {
                        $fechaexpiracion = strip_tags(date("Y-m-d", strtotime($compra[$i]['fechaexpiracion'])));
                    }
                    $codigobarra = strip_tags($compra[$i]['codigobarra']);
                    if (strip_tags($compra[$i]['codlaboratorio'] == "")) {
                        $codlaboratorio = "1";
                    } else {
                        $codlaboratorio = strip_tags($compra[$i]['codlaboratorio']);
                    }
                    $fechadetallecompra = strip_tags($fecha);
                    $codigo = strip_tags($_SESSION['codigo']);
                    $stmt->execute();

                    $sql = " SELECT codproducto FROM productos WHERE codproducto = ? AND codsucursal = ?";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->execute(array($compra[$i]['txtCodigo'], $_POST['codsucursal']));
                    $num = $stmt->rowCount();
                    if ($num == 0) {
                        ##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ##########################
                        $query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                        $stmt = $this->dbh->prepare($query);
                        $stmt->bindParam(1, $codproducto);
                        $stmt->bindParam(2, $producto);
                        $stmt->bindParam(3, $principioactivo);
                        $stmt->bindParam(4, $descripcion);
                        $stmt->bindParam(5, $presentacion);
                        $stmt->bindParam(6, $tipo);
                        $stmt->bindParam(7, $precio);
                        $stmt->bindParam(8, $precio2);
                        $stmt->bindParam(9, $precio3);
                        $stmt->bindParam(10, $stockcajas);
                        $stmt->bindParam(11, $unidades);
                        $stmt->bindParam(12, $stockunidad);
                        $stmt->bindParam(13, $stocktotal);
                        $stmt->bindParam(14, $stockminimo);
                        $stmt->bindParam(15, $ivaproducto);
                        $stmt->bindParam(16, $descproducto);
                        $stmt->bindParam(17, $fechaelaboracion);
                        $stmt->bindParam(18, $fechaexpiracion);
                        $stmt->bindParam(19, $codigobarra);
                        $stmt->bindParam(20, $codlaboratorio);
                        $stmt->bindParam(21, $codproveedor);
                        $stmt->bindParam(22, $codsucursal);
                        $stmt->bindParam(23, $loteproducto);
                        $stmt->bindParam(24, $ubicacion);
                        $stmt->bindParam(25, $statusp);
                        $stmt->bindParam(26, $stockblister);

                        $codproducto = strip_tags($compra[$i]['txtCodigo']);
                        $producto = strip_tags($compra[$i]['producto']);
                        $principioactivo = strip_tags($compra[$i]['principioactivo']);
                        $descripcion = strip_tags($compra[$i]['descripcion']);
                        $presentacion = strip_tags($compra[$i]['presentacion']);
                        $tipo = strip_tags($compra[$i]['tipo']);
                        $precio = strip_tags($compra[$i]['precio']);
                        $precio2 = strip_tags($compra[$i]['precio2']);
                        $precio3 = strip_tags($compra[$i]['precio3']);

                        // tip presentacion: blister, caja o unidad
                        $tipo_pre = strip_tags($compra[$i]['tipo_pre']);

                        if ($tipo_pre === 'unidad') {
                            $stockunidad = strip_tags($compra[$i]['cantidad']);
                            $stockblister = strip_tags('0');
                            $stockcajas = strip_tags('0');
                        } elseif ($tipo_pre === 'blister') {
                            $stockblister = strip_tags($compra[$i]['cantidad']);
                            $stockcajas = strip_tags('0');
                            $stockunidad = strip_tags('0');
                        } elseif ($tipo_pre === 'caja') {
                            $stockcajas = strip_tags($compra[$i]['cantidad'] + $compra[$i]['cantidad2']);
                            $stockblister = strip_tags('0');
                            $stockunidad = strip_tags('0');
                        }



                        $unidades = strip_tags($compra[$i]['unidades']);
                        $stocktotal = strip_tags($stockcajas * $compra[$i]['unidades']);



                        $stockminimo = strip_tags('0');
                        $ivaproducto = strip_tags($compra[$i]['ivaproducto']);
                        $descproducto = $compra[$i]['descproducto'] ? strip_tags($compra[$i]['descproducto']) : null;
                        if (strip_tags($compra[$i]['fechaelaboracion'] == "")) {
                            $fechaelaboracion = "0000-00-00";
                        } else {
                            $fechaelaboracion = strip_tags(date("Y-m-d", strtotime($compra[$i]['fechaelaboracion'])));
                        }
                        if (strip_tags($compra[$i]['fechaexpiracion'] == "")) {
                            $fechaexpiracion = "0000-00-00";
                        } else {
                            $fechaexpiracion = strip_tags(date("Y-m-d", strtotime($compra[$i]['fechaexpiracion'])));
                        }
                        $codigobarra = strip_tags($compra[$i]['codigobarra']);
                        if (strip_tags($compra[$i]['codlaboratorio'] == "")) {
                            $codlaboratorio = "1";
                        } else {
                            $codlaboratorio = strip_tags($compra[$i]['codlaboratorio']);
                        }
                        $codproveedor = $_POST['codproveedor'] ? strip_tags($_POST['codproveedor']) : null;
                        $codsucursal = $_POST['codsucursal'] ? strip_tags($_POST['codsucursal']) : null;
                        $loteproducto = strip_tags($compra[$i]['lote']);
                        $ubicacion = strip_tags("NA");
                        $statusp = strip_tags("0");
                        $stmt->execute();
                        ##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ##########################


                        ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                        $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                        $stmt = $this->dbh->prepare($query);
                        $stmt->bindParam(1, $codcompra);
                        $stmt->bindParam(2, $codproveedor);
                        $stmt->bindParam(3, $codsucursalm);
                        $stmt->bindParam(4, $codproductom);
                        $stmt->bindParam(5, $movimiento);
                        $stmt->bindParam(6, $entradacaja);
                        $stmt->bindParam(7, $entradaunidad);
                        $stmt->bindParam(8, $entradacajano);
                        $stmt->bindParam(9, $entradabonif);
                        $stmt->bindParam(10, $salidacajas);
                        $stmt->bindParam(11, $salidaunidad);
                        $stmt->bindParam(12, $salidabonif);
                        $stmt->bindParam(13, $devolucioncaja);
                        $stmt->bindParam(14, $devolucionunidad);
                        $stmt->bindParam(15, $devolucionbonif);
                        $stmt->bindParam(16, $stocktotalcaja);
                        $stmt->bindParam(17, $stocktotalunidad);
                        $stmt->bindParam(18, $preciocompram);
                        $stmt->bindParam(19, $precioventaunidadm);
                        $stmt->bindParam(20, $precioventacajam);
                        $stmt->bindParam(21, $ivaproducto);
                        $stmt->bindParam(22, $descproducto);
                        $stmt->bindParam(23, $documento);
                        $stmt->bindParam(24, $fechakardex);

                        $codcompra = strip_tags($_POST['codcompra']);
                        $codproveedor = $_POST["codproveedor"] ? strip_tags($_POST["codproveedor"]) : null;
                        $codsucursalm = $_POST["codsucursal"] ? strip_tags($_POST["codsucursal"]) : null;
                        $codproductom = strip_tags($compra[$i]['txtCodigo']);
                        $movimiento = strip_tags("ENTRADAS");
                        $entradacaja = strip_tags($compra[$i]['cantidad']);
                        $entradaunidad = strip_tags($compra[$i]['unidades']);
                        $entradacajano = strip_tags("0");
                        $entradabonif = strip_tags($compra[$i]['cantidad2']);
                        $salidacajas = strip_tags("0");
                        $salidaunidad = strip_tags("0");
                        $salidabonif = strip_tags("0");
                        $devolucioncaja = strip_tags("0");
                        $devolucionunidad = strip_tags("0");
                        $devolucionbonif = strip_tags("0");
                        $stocktotalcaja = strip_tags($compra[$i]['cantidad'] + $compra[$i]['cantidad2']);
                        $stocktotalunidad = strip_tags($stocktotalcaja * $compra[$i]['unidades']);
                        $preciocompram = strip_tags($compra[$i]["precio"]);
                        $precioventacajam = strip_tags($compra[$i]["precio2"]);
                        $precioventaunidadm = strip_tags($compra[$i]["precio3"]);
                        $ivaproducto = strip_tags($compra[$i]['ivaproducto']);
                        $descproducto = strip_tags($compra[$i]['descproducto']);
                        $documento = strip_tags("COMPRA - " . $_POST["tipocompra"] . " - FACTURA: " . $_POST['codcompra']);
                        $fechakardex = strip_tags($fecha);
                        $stmt->execute();
                    ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

                    } else {

                        $sql = "select stockunidad, stockblister,stockcajas,blisterunidad, stocktotal, unidades from productos where codproducto = '" . $compra[$i]['txtCodigo'] . "' AND codsucursal = '" . $_POST['codsucursal'] . "'";
                        foreach ($this->dbh->query($sql) as $row) {
                            $this->p[] = $row;
                        }

                        $stockcajasdb = $row['stockcajas'];
                        $stocktotaldb = $row['stocktotal'];
                        $stockunidadb = $row['stockunidad'];
                        $stockblisterdb = $row['stockblister'];
                        $blisterunidaddb = $row['blisterunidad'];
                        $unidadesdb = $row['unidades'];

                        ##################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ###################
                        $sql = " update productos set "
                            . " preciocompraunidad = ?, "
                            . " preciocomprablister = ?, "
                            . " precioventablister = ?, "
                            . " preciocompra = ?, "
                            . " precioventacaja = ?, "
                            . " precioventaunidad = ?, "
                            . " stockcajas = ?, "
                            . " stockunidad = ?, "
                            . " stockblister = ?, "
                            . " unidades = ?, "
                            . " stocktotal = ?, "
                            . " ivaproducto = ?, "
                            . " descproducto = ?, "
                            . " fechaelaboracion = ?, "
                            . " fechaelaboracion = ?, "
                            . " codigobarra = ?, "
                            . " codlaboratorio = ?, "
                            . " codproveedor = ?, "
                            . " loteproducto = ? "
                            . " where "
                            . " codproducto = ? AND codsucursal = ?;
			   ";
                        $stmt = $this->dbh->prepare($sql);
                        $stmt->bindParam(1, $preciocompraunidad);
                        $stmt->bindParam(2, $preciocomprablister);
                        $stmt->bindParam(3, $precioventablister);
                        $stmt->bindParam(4, $preciocompra);
                        $stmt->bindParam(5, $precioventacaja);
                        $stmt->bindParam(6, $precioventaunidad);
                        $stmt->bindParam(7, $stockcajas);
                        $stmt->bindParam(8, $stockunidad);
                        $stmt->bindParam(9, $stockblister);
                        $stmt->bindParam(10, $unidades);
                        $stmt->bindParam(11, $stocktotal);
                        $stmt->bindParam(12, $ivaproducto);
                        $stmt->bindParam(13, $descproducto);
                        $stmt->bindParam(14, $fechaelaboracion);
                        $stmt->bindParam(15, $fechaexpiracion);
                        $stmt->bindParam(16, $codigobarra);
                        $stmt->bindParam(17, $codlaboratorio);
                        $stmt->bindParam(18, $codproveedor);
                        $stmt->bindParam(19, $loteproducto);
                        $stmt->bindParam(20, $codigo);
                        $stmt->bindParam(21, $codsucursal);

                        $preciocompra = strip_tags($compra[$i]['precio']);
                        $precioventacaja = strip_tags($compra[$i]['precio2']);
                        $precioventaunidad = strip_tags($compra[$i]['precio3']);
                        $cantcaja = strip_tags($compra[$i]['cantidad'] + $compra[$i]['cantidad2']);

                        if ($compra[$i]['tipoProd'] === 'unidad') {
                            //$stockunidad = (int)$stockunidadb + (int)$compra[$i]['cantidad'];

                            $canttotal = (int)($compra[$i]['cantidad']);
                            $stocktotal = (int)$canttotal + (int)$stocktotaldb;
                            $stockblister = (int)((int)$stocktotal / (int)$blisterunidaddb);
                            $stockcajas = (int)((int)$stocktotal / (int)$unidadesdb);
                            $stockunidad = (int)$stocktotal - ((int)$stockcajas * (int)$unidadesdb);
                        } elseif ($compra[$i]['tipoProd'] === 'blister') {
                            $stockblister = $stockblisterdb + $compra[$i]['cantidad'];
                            $stocktotal = (int)($compra[$i]['cantidad']) * (int)$blisterunidaddb + (int)$stocktotaldb;
                            $stockcajas = (int)((int)$stocktotal / (int)$unidadesdb);
                            $stockunidad = (int)$stocktotal - ((int)$stockcajas * (int)$unidadesdb);
                        } elseif ($compra[$i]['tipoProd'] === 'caja') {
                            $canttotal = (int)($compra[$i]['cantidad']);
                            $stockcajas = (int)$canttotal + (int)$stockcajasdb;
                            $stocktotal = (int)$stocktotaldb + ((int)$canttotal * (int)$unidadesdb);
                            $stockblister = (int)((int)$stocktotal / (int)$blisterunidaddb);
                            $stockunidad = (int)$stocktotal - ((int)$stockcajas * (int)$unidadesdb);
                        }

                        $ivaproducto = strip_tags($compra[$i]['ivaproducto']);
                        $descproducto = strip_tags($compra[$i]['descproducto']);
                        if (strip_tags($compra[$i]['fechaelaboracion'] == "")) {
                            $fechaelaboracion = "0000-00-00";
                        } else {
                            $fechaelaboracion = strip_tags(date("Y-m-d", strtotime($compra[$i]['fechaelaboracion'])));
                        }
                        if (strip_tags($compra[$i]['fechaexpiracion'] == "")) {
                            $fechaexpiracion = "0000-00-00";
                        } else {
                            $fechaexpiracion = strip_tags(date("Y-m-d", strtotime($compra[$i]['fechaexpiracion'])));
                        }
                        $codigobarra = strip_tags($compra[$i]['codigobarra']);
                        if (strip_tags($compra[$i]['codlaboratorio'] == "")) {
                            $codlaboratorio = "1";
                        } else {
                            $codlaboratorio = strip_tags($compra[$i]['codlaboratorio']);
                        }
                        $preciocompraunidad = strip_tags($_POST['preciocompraunidad']);



                        $preciocomprablister = strip_tags($_POST['preciocomprablister']);
                        $precioventablister = strip_tags($_POST['precioventablister']);

                        $codproveedor = (int)(strip_tags($_POST['codproveedor']));
                        $loteproducto = strip_tags($compra[$i]['lote']);
                        $codigo = strip_tags($compra[$i]['txtCodigo']);
                        $codsucursal = strip_tags($_POST['codsucursal']);

                        $stmt->execute();
                        ##################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ##################

                        ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                        $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                        $stmt = $this->dbh->prepare($query);
                        $stmt->bindParam(1, $codcompra);
                        $stmt->bindParam(2, $codproveedor);
                        $stmt->bindParam(3, $codsucursalm);
                        $stmt->bindParam(4, $codproductom);
                        $stmt->bindParam(5, $movimiento);
                        $stmt->bindParam(6, $entradacaja);
                        $stmt->bindParam(7, $entradaunidad);
                        $stmt->bindParam(8, $entradacajano);
                        $stmt->bindParam(9, $entradabonif);
                        $stmt->bindParam(10, $salidacajas);
                        $stmt->bindParam(11, $salidaunidad);
                        $stmt->bindParam(12, $salidabonif);
                        $stmt->bindParam(13, $devolucioncaja);
                        $stmt->bindParam(14, $devolucionunidad);
                        $stmt->bindParam(15, $devolucionbonif);
                        $stmt->bindParam(16, $stocktotalcaja);
                        $stmt->bindParam(17, $stocktotalunidad);
                        $stmt->bindParam(18, $preciocompram);
                        $stmt->bindParam(19, $precioventacajam);
                        $stmt->bindParam(20, $precioventaunidadm);
                        $stmt->bindParam(21, $ivaproducto);
                        $stmt->bindParam(22, $descproducto);
                        $stmt->bindParam(23, $documento);
                        $stmt->bindParam(24, $fechakardex);

                        $codcompra = strip_tags($_POST['codcompra']);
                        $codproveedor = strip_tags($_POST["codproveedor"]);
                        $codsucursalm = strip_tags($_POST["codsucursal"]);
                        $codproductom = strip_tags($compra[$i]['txtCodigo']);
                        $movimiento = strip_tags("ENTRADAS");
                        $entradacaja = strip_tags($compra[$i]['cantidad']);
                        $entradaunidad = strip_tags($compra[$i]['unidades']);
                        $entradacajano = strip_tags("0");
                        $entradabonif = strip_tags($compra[$i]['cantidad2']);
                        $salidacajas = strip_tags("0");
                        $salidaunidad = strip_tags("0");
                        $salidabonif = strip_tags("0");
                        $devolucioncaja = strip_tags("0");
                        $devolucionunidad = strip_tags("0");
                        $devolucionbonif = strip_tags("0");

                        $cantcaja = strip_tags($compra[$i]['cantidad'] + $compra[$i]['cantidad2']);
                        $stocktotalcaja = $cantcaja + $stockcajasdb;

                        $unidades = strip_tags($compra[$i]['unidades']);
                        $canttotal = strip_tags($cantcaja * $compra[$i]['unidades']);
                        $stocktotalunidad = $canttotal + $stocktotaldb;

                        $preciocompram = strip_tags($compra[$i]["precio"]);
                        $precioventacajam = strip_tags($compra[$i]["precio2"]);
                        $precioventaunidadm = strip_tags($compra[$i]["precio3"]);
                        $ivaproducto = strip_tags($compra[$i]['ivaproducto']);
                        $descproducto = strip_tags($compra[$i]['descproducto']);
                        $documento = strip_tags("COMPRA - " . $_POST["tipocompra"] . " - FACTURA: " . $_POST['codcompra']);
                        $fechakardex = strip_tags($fecha);
                        $stmt->execute();
                        ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################
                    }
                }
                ####################### DESTRUYO LA VARIABLE DE SESSION #####################
                unset($_SESSION["CarritoC"]);

                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA COMPRA FUE REGISTRADA EXITOSAMENTE <a href='reportepdf?codcompra=" . base64_encode($codcompra) . "&tipo=" . base64_encode("FACTURACOMPRAS") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR FACTURA</strong></a></div>";
                echo "<script>window.open('reportepdf?codcompra=" . base64_encode($codcompra) . "&tipo=" . base64_encode("FACTURACOMPRAS") . "', '_blank');</script>";
                exit;
            } else {
                echo "4";
                exit;
            }
        }
    }
    ################################### FUNCION REGISTRAR COMPRAS ##################################

    ############################## FUNCION LISTAR COMPRAS PAGADAS #################################
    public function ListarComprasPag()
    {
        self::SetNames();
        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.razonsocial, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.statuscompra = 'PAGADA' GROUP BY compras.codcompra";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.razonsocial, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = " . $_SESSION["codsucursal"] . " AND compras.statuscompra = 'PAGADA' GROUP BY compras.codcompra";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION LISTAR COMPRAS PAGADAS #################################

    ############################# FUNCION LISTAR COMPRAS PENDIENTES #############################
    public function ListarComprasPend()
    {
        self::SetNames();
        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.razonsocial, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.statuscompra = 'PENDIENTE' GROUP BY compras.codcompra";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.razonsocial, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = " . $_SESSION["codsucursal"] . " AND compras.statuscompra = 'PENDIENTE' GROUP BY compras.codcompra";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION LISTAR COMPRAS PENDIENTES ################################

    ###################################### FUNCION PAGAR COMPRAS #######################################
    public function PagarCompras()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            self::SetNames();
            $sql = " update compras set "
                . " fechavencecredito = null, "
                . " statuscompra = ? "
                . " where "
                . " codcompra = ?;
			   ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $statuscompra);
            $stmt->bindParam(2, $codcompra);
            $codcompra = strip_tags(base64_decode($_GET["codcompra"]));
            $statuscompra = strip_tags("PAGADA");
            $stmt->execute();

            header("Location: compraspendientes?mesage=1");
            exit;
        } else {

            header("Location: compraspendientes?mesage=2");
            exit;
        }
    }
    ###################################### FUNCION PAGAR COMPRAS #######################################

    ###################################### FUNCION ID COMPRAS #######################################
    public function ComprasPorId()
    {
        self::SetNames();
        $sql = " SELECT * FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN mediospagos ON compras.formacompra = mediospagos.codmediopago WHERE compras.codcompra = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codcompra"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION ID COMPRAS #######################################

    ################################ FUNCION VER DETALLES COMPRAS ################################
    public function VerDetallesCompras()
    {
        self::SetNames();
        $sql = " SELECT * FROM detallecompras INNER JOIN presentaciones ON detallecompras.codpresentacionc = presentaciones.codpresentacion INNER JOIN medidas ON detallecompras.codmedidac = medidas.codmedida WHERE detallecompras.codcompra = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET["codcompra"])));
        $stmt->execute();
        $num = $stmt->rowCount();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################### FUNCION VER DETALLES COMPRAS ###################################

    ############################ FUNCION LISTAR DETALLES COMPRAS ##################################
    public function ListarDetallesCompras()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT * FROM detallecompras INNER JOIN presentaciones ON detallecompras.codpresentacionc = presentaciones.codpresentacion INNER JOIN medidas ON detallecompras.codmedidac = medidas.codmedida LEFT JOIN compras ON detallecompras.codcompra = compras.codcompra";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT * FROM detallecompras INNER JOIN presentaciones ON detallecompras.codpresentacionc = presentaciones.codpresentacion INNER JOIN medidas ON detallecompras.codmedidac = medidas.codmedida LEFT JOIN compras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################### FUNCION LISTAR DETALLES COMPRAS ##############################

    ################################### FUNCION ID DETALLE COMPRAS ###################################
    public function DetallesComprasPorId()
    {
        self::SetNames();
        $sql = " SELECT * FROM detallecompras INNER JOIN presentaciones ON detallecompras.codpresentacionc = presentaciones.codpresentacion INNER JOIN medidas ON detallecompras.codmedidac = medidas.codmedida LEFT JOIN compras ON detallecompras.codcompra = compras.codcompra WHERE detallecompras.coddetallecompra = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["coddetallecompra"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################ FUNCION ID DETALLE COMPRAS ##################################

    ################################ FUNCION ACTUALIZAR DETALLE COMPRAS ################################
    public function ActualizarDetallesCompras()
    {
        self::SetNames();
        if (empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantcompra"])) {
            echo "1";
            exit;
        }

        $sql = "select stockcajas, stocktotal from productos where codproducto = '" . $_POST["codproducto"] . "' AND codsucursal = '" . $_POST['codsucursal'] . "'";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        $stockcajasdb = $row['stockcajas'];
        $stocktotaldb = $row['stocktotal'];

        $sql2 = " select * from detallecompras where coddetallecompra = ? and codcompra = ? ";
        $stmt = $this->dbh->prepare($sql2);
        $stmt->execute(array($_POST["coddetallecompra"], $_POST["codcompra"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pa[] = $row;
        }
        $cantidadcompradb = $pa[0]["cantcompra"];

        $sql = " update detallecompras set "
            . " codproductoc = ?, "
            . " productoc = ?, "
            . " principioactivoc = ?, "
            . " descripcionc = ?, "
            . " codpresentacionc = ?, "
            . " codmedidac = ?, "
            . " preciocomprac = ?, "
            . " precioventacajac = ?, "
            . " precioventaunidadc = ?, "
            . " ivaproductoc = ?, "
            . " descproductoc = ?, "
            . " descfactura = ?, "
            . " cantcompra = ?, "
            . " cantbonif = ?, "
            . " unidadesc = ?, "
            . " valortotal = ?, "
            . " totaldescuentoc = ?, "
            . " descbonific = ?, "
            . " valorneto = ?, "
            . " lote = ?, "
            . " fechaelaboracionc = ?, "
            . " fechaexpiracionc = ?, "
            . " codbarrac = ?, "
            . " codlaboratorioc = ? "
            . " where "
            . " coddetallecompra = ?;
			   ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $codproducto);
        $stmt->bindParam(2, $producto);
        $stmt->bindParam(3, $principioactivo);
        $stmt->bindParam(4, $descripcion);
        $stmt->bindParam(5, $codpresentacion);
        $stmt->bindParam(6, $codmedida);
        $stmt->bindParam(7, $preciocompra);
        $stmt->bindParam(8, $precioventacaja);
        $stmt->bindParam(9, $precioventaunidad);
        $stmt->bindParam(10, $ivaproducto);
        $stmt->bindParam(11, $descproducto);
        $stmt->bindParam(12, $descfactura);
        $stmt->bindParam(13, $cantcompra);
        $stmt->bindParam(14, $cantbonif);
        $stmt->bindParam(15, $unidades);
        $stmt->bindParam(16, $valortotal);
        $stmt->bindParam(17, $totaldescuentoc);
        $stmt->bindParam(18, $descbonific);
        $stmt->bindParam(19, $valorneto);
        $stmt->bindParam(20, $lote);
        $stmt->bindParam(21, $fechaelaboracion);
        $stmt->bindParam(22, $fechaexpiracion);
        $stmt->bindParam(23, $codigobarra);
        $stmt->bindParam(24, $codlaboratorio);
        $stmt->bindParam(25, $coddetallecompra);

        $codproducto = strip_tags($_POST["codproducto"]);
        $producto = strip_tags($_POST["producto"]);
        $principioactivo = strip_tags($_POST["principioactivo"]);
        $descripcion = strip_tags($_POST["descripcion"]);
        $codpresentacion = strip_tags($_POST["codpresentacion"]);
        $codmedida = strip_tags($_POST["codmedida"]);
        $preciocompra = strip_tags($_POST["preciocompra"]);
        $precioventacaja = strip_tags($_POST["precioventacaja"]);
        $precioventaunidad = strip_tags($_POST["precioventaunidad"]);
        $ivaproducto = strip_tags($_POST["ivaproducto"]);
        $descproducto = strip_tags($_POST["descproducto"]);
        $descfactura = strip_tags($_POST["descfactura"]);
        $cantcompra = strip_tags($_POST["cantcompra"]);
        $cantbonif = strip_tags($_POST["cantbonif"]);
        $unidades = strip_tags($_POST["unidades"]);
        $valortotal = strip_tags($_POST["valortotal"]);
        $totaldescuentoc = strip_tags($_POST["totaldescuentoc"]);
        $descbonific = strip_tags($_POST["descbonific"]);
        $valorneto = strip_tags($_POST["valorneto"]);
        $lote = strip_tags($_POST["lote"]);
        if (strip_tags($_POST["fechaelaboracion"] == null)) {
            $fechaelaboracion = strip_tags(null);
        } else {
            $fechaelaboracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaelaboracion'])));
        }
        if (strip_tags($_POST["fechaexpiracion"] == null)) {
            $fechaexpiracion = strip_tags(null);
        } else {
            $fechaexpiracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaexpiracion'])));
        }
        $codigobarra = strip_tags($_POST['codigobarra']);
        if (strip_tags($_POST['codlaboratorio'] == "")) {
            $codlaboratorio = "1";
        } else {
            $codlaboratorio = strip_tags($_POST['codlaboratorio']);
        }
        $coddetallecompra = strip_tags($_POST["coddetallecompra"]);
        $stmt->execute();

        ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
        $sql = " update productos set "
            . " producto = ?, "
            . " principioactivo = ?, "
            . " descripcion = ?, "
            . " codpresentacion = ?, "
            . " codmedida = ?, "
            . " preciocompra = ?, "
            . " precioventacaja = ?, "
            . " precioventaunidad = ?, "
            . " stockcajas = ?, "
            . " unidades = ?, "
            . " stocktotal = ?, "
            . " ivaproducto = ?, "
            . " descproducto = ?, "
            . " fechaelaboracion = ?, "
            . " fechaexpiracion = ?, "
            . " codigobarra = ?, "
            . " codlaboratorio = ?, "
            . " loteproducto = ? "
            . " where "
            . " codproducto = ? AND codsucursal = ?;
			   ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $producto);
        $stmt->bindParam(2, $principioactivo);
        $stmt->bindParam(3, $descripcion);
        $stmt->bindParam(4, $codpresentacion);
        $stmt->bindParam(5, $codmedida);
        $stmt->bindParam(6, $preciocompra);
        $stmt->bindParam(7, $precioventacaja);
        $stmt->bindParam(8, $precioventaunidad);
        $stmt->bindParam(9, $stockcajas);
        $stmt->bindParam(10, $unidades);
        $stmt->bindParam(11, $stocktotal);
        $stmt->bindParam(12, $ivaproducto);
        $stmt->bindParam(13, $descproducto);
        $stmt->bindParam(14, $fechaelaboracion);
        $stmt->bindParam(15, $fechaexpiracion);
        $stmt->bindParam(16, $codigobarra);
        $stmt->bindParam(17, $codlaboratorio);
        $stmt->bindParam(18, $loteproducto);
        $stmt->bindParam(19, $codproducto);
        $stmt->bindParam(20, $codsucursal);

        $producto = strip_tags($_POST["producto"]);
        $principioactivo = strip_tags($_POST["principioactivo"]);
        $descripcion = strip_tags($_POST["descripcion"]);
        $codpresentacion = strip_tags($_POST["codpresentacion"]);
        $codmedida = strip_tags($_POST["codmedida"]);
        $preciocompra = strip_tags($_POST["preciocompra"]);
        $precioventacaja = strip_tags($_POST["precioventacaja"]);
        $precioventaunidad = strip_tags($_POST["precioventaunidad"]);
        $unidades = strip_tags($_POST["unidades"]);

        ######### AQUI HACEMOS CALCULOS ############
        $cantidad = strip_tags($_POST["cantcompra"]);
        $cantidadcompradb = strip_tags($_POST["cantidadcompradb"]);
        $cantidad2 = strip_tags($_POST["cantbonif"]);
        $cantidadbonifdb = strip_tags($_POST["cantidadbonifdb"]);
        $calexistencia = $cantidad - $cantidadcompradb;
        $calbonific = $cantidad2 - $cantidadbonifdb;
        $stockcajas = $stockcajasdb + $calexistencia + $calbonific;
        $stocktotal = $stockcajas * $unidades;
        ######### AQUI HACEMOS CALCULOS ############

        $ivaproducto = strip_tags($_POST["ivaproducto"]);
        $descproducto = strip_tags($_POST["descproducto"]);
        if (strip_tags($_POST["fechaelaboracion"] == null)) {
            $fechaelaboracion = strip_tags(null);
        } else {
            $fechaelaboracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaelaboracion'])));
        }
        if (strip_tags($_POST["fechaexpiracion"] == null)) {
            $fechaexpiracion = strip_tags(null);
        } else {
            $fechaexpiracion = strip_tags(date("Y-m-d", strtotime($_POST['fechaexpiracion'])));
        }
        $codigobarra = strip_tags($_POST['codigobarra']);
        if (strip_tags($_POST['codlaboratorio'] == "")) {
            $codlaboratorio = "1";
        } else {
            $codlaboratorio = strip_tags($_POST['codlaboratorio']);
        }
        $lote = strip_tags($_POST["lote"]);
        $codproducto = strip_tags($_POST["codproducto"]);
        $codsucursal = strip_tags($_POST["codsucursal"]);
        $stmt->execute();


        ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################
        $sql2 = " update kardexproductos set "
            . " entradacaja = ?, "
            . " entradaunidad = ?, "
            . " entradabonif = ?, "
            . " stocktotalcaja = ?, "
            . " stocktotalunidad = ?, "
            . " preciocompram = ?, "
            . " precioventacajam = ?, "
            . " precioventaunidadm = ?, "
            . " ivaproductom = ?, "
            . " descproductom = ? "
            . " where "
            . " codproceso = ? and codproductom = ?;
			   ";
        $stmt = $this->dbh->prepare($sql2);
        $stmt->bindParam(1, $entradacaja);
        $stmt->bindParam(2, $entradaunidad);
        $stmt->bindParam(3, $entradabonif);
        $stmt->bindParam(4, $stockcajas);
        $stmt->bindParam(5, $stocktotal);
        $stmt->bindParam(6, $preciocompra);
        $stmt->bindParam(7, $precioventacaja);
        $stmt->bindParam(8, $precioventaunidad);
        $stmt->bindParam(9, $ivaproducto);
        $stmt->bindParam(10, $descproducto);
        $stmt->bindParam(11, $codcompra);
        $stmt->bindParam(12, $codproducto);

        $entradacaja = strip_tags($_POST["cantcompra"]);
        $entradaunidad = strip_tags($_POST["unidades"]);
        $entradabonif = strip_tags($_POST["cantbonif"]);
        $preciocompra = strip_tags($_POST["preciocompra"]);
        $precioventacaja = strip_tags($_POST["precioventacaja"]);
        $precioventaunidad = strip_tags($_POST["precioventaunidad"]);
        $ivaproducto = strip_tags($_POST["ivaproducto"]);
        $descproducto = strip_tags($_POST["descproducto"]);

        ######### AQUI HACEMOS CALCULOS ############
        $cantidad = strip_tags($_POST["cantcompra"]);
        $cantidadcompradb = strip_tags($_POST["cantidadcompradb"]);
        $cantidad2 = strip_tags($_POST["cantbonif"]);
        $cantidadbonifdb = strip_tags($_POST["cantidadbonifdb"]);
        $calexistencia = $cantidad - $cantidadcompradb;
        $calbonific = $cantidad2 - $cantidadbonifdb;
        $stockcajas = $stockcajasdb + $calexistencia + $calbonific;
        $stocktotal = $stockcajas * $unidades;
        ######### AQUI HACEMOS CALCULOS ############

        $codcompra = strip_tags($_POST["codcompra"]);
        $codproducto = strip_tags($_POST["codproducto"]);
        $stmt->execute();


        $sql4 = "select ivac from compras where codcompra = ? ";
        $stmt = $this->dbh->prepare($sql4);
        $stmt->execute(array($_POST["codcompra"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $paea[] = $row;
        }
        $iva = $paea[0]["ivac"] / 100;

        $sql3 = "select sum(totaldescuentoc) as descuento, sum(descbonific) as bonificacion, sum(valorneto) as neto from detallecompras where codcompra = ? and ivaproductoc = 'SI'";
        $stmt = $this->dbh->prepare($sql3);
        $stmt->execute(array($_POST["codcompra"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch()) {
            $p[] = $row;
        }
        $descuentosi = ($p[0]["descuento"] == "" ? "0.00" : $p[0]["descuento"]);
        $bonificacionsi = ($p[0]["bonificacion"] == "" ? "0.00" : $p[0]["bonificacion"]);
        $valornetosi = ($p[0]["neto"] == "" ? "0.00" : $p[0]["neto"]);

        $sql5 = "select sum(totaldescuentoc) as descuento, sum(descbonific) as bonificacion, sum(valorneto) as neto from detallecompras where codcompra = ? and ivaproductoc = 'NO'";
        $stmt = $this->dbh->prepare($sql5);
        $stmt->execute(array($_POST["codcompra"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch()) {
            $p[] = $row;
        }
        $descuentono = ($row["descuento"] == "" ? "0.00" : $row["descuento"]);
        $bonificacionno = ($row["bonificacion"] == "" ? "0.00" : $row["bonificacion"]);
        $valornetono = ($row["neto"] == "" ? "0.00" : $row["neto"]);

        $sql = " update compras set "
            . " descuentoc = ?, "
            . " descbonific = ?, "
            . " subtotalc = ?, "
            . " totalsinimpuestosc = ?, "
            . " tarifano = ?, "
            . " tarifasi = ?, "
            . " totalivac = ?, "
            . " totalc= ? "
            . " where "
            . " codcompra = ?;
			   ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $descuentoc);
        $stmt->bindParam(2, $descbonific);
        $stmt->bindParam(3, $subtotalc);
        $stmt->bindParam(4, $totalsinimpuestosc);
        $stmt->bindParam(5, $tarifano);
        $stmt->bindParam(6, $tarifasi);
        $stmt->bindParam(7, $totalivac);
        $stmt->bindParam(8, $total);
        $stmt->bindParam(9, $codcompra);

        $descuentoc = number_format($descuentosi + $descuentono, 2);
        $descbonific = number_format($bonificacionsi + $bonificacionno, 2);
        $subtotalc = number_format($valornetosi + $valornetono + $descuentoc, 2);
        $totalsinimpuestosc = number_format($valornetosi + $valornetono, 2);
        $tarifano = number_format($valornetono - $bonificacionno, 2);
        $tarifasi = number_format($valornetosi - $bonificacionsi, 2);
        $totalivac = number_format($tarifasi * $iva, 2);

        $resto = number_format($descuentoc + $descbonific, 2);
        $subtotalresto = number_format($subtotalc - $resto, 2);
        $total = number_format($subtotalresto + $totalivac, 2);
        $codcompra = strip_tags($_POST["codcompra"]);
        $stmt->execute();

        echo "<div class='alert alert-info'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE COMPRA FUE ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codcompra=" . base64_encode($codcompra) . "&tipo=" . base64_encode("FACTURACOMPRAS") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR FACTURA</strong></a></div>";
        echo "<script>window.open('reportepdf?codcompra=" . base64_encode($codcompra) . "&tipo=" . base64_encode("FACTURACOMPRAS") . "', '_blank');</script>";
        exit;
    }
    ################################ FUNCION ACTUALIZAR DETALLE COMPRAS ###############################

    ################################## FUNCION ELIMINAR DETALLES COMPRAS ##############################
    public function EliminarDetallesCompras()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            self::SetNames();
            $sql = " select * from detallecompras where codcompra = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(base64_decode($_GET["codcompra"])));
            $num = $stmt->rowCount();
            if ($num > 1) {

                $sql = " delete from detallecompras where coddetallecompra = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $coddetallecompra);
                $coddetallecompra = base64_decode($_GET["coddetallecompra"]);
                $stmt->execute();

                $sql2 = "select stockcajas, stocktotal from productos where codproducto = ? and codsucursal = ?";
                $stmt = $this->dbh->prepare($sql2);
                $stmt->execute(array(base64_decode($_GET["codproductoc"]), base64_decode($_GET["codsucursal"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $p[] = $row;
                }
                $stockcajasdb = $row['stockcajas'];
                $stocktotaldb = $row['stocktotal'];

                ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ######################
                $sql = " update productos set "
                    . " stockcajas = ?, "
                    . " stocktotal = ? "
                    . " where "
                    . " codproducto = ? and codsucursal = ?;
			   ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $stockcajas);
                $stmt->bindParam(2, $stocktotal);
                $stmt->bindParam(3, $codproducto);
                $stmt->bindParam(4, $codsucursal);
                $cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
                $cantbonif = strip_tags(base64_decode($_GET["cantbonif"]));
                $unidad = strip_tags(base64_decode($_GET["unidadesc"]));
                $codproducto = strip_tags(base64_decode($_GET["codproductoc"]));
                $codsucursal = strip_tags(base64_decode($_GET["codsucursal"]));
                $resto = $cantcompra + $cantbonif;
                $stockcajas = $stockcajasdb - $resto;
                $calculo = $resto * $unidad;
                $stocktotal = $stocktotaldb - $calculo;
                $stmt->execute();


                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codcompra);
                $stmt->bindParam(2, $codproveedor);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);
                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);
                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);
                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);
                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);

                $codcompra = strip_tags(base64_decode($_GET["codcompra"]));
                $codproveedor = strip_tags(base64_decode($_GET["codproveedor"]));
                $codsucursalm = strip_tags(base64_decode($_GET["codsucursal"]));
                $codproductom = strip_tags(base64_decode($_GET["codproductoc"]));
                $movimiento = strip_tags("DEVOLUCION");
                $entradacaja = strip_tags("0");
                $entradaunidad = strip_tags("0");
                $entradacajano = strip_tags("0");
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags("0");
                $salidabonif = strip_tags("0");
                $devolucioncaja = strip_tags(base64_decode($_GET["cantcompra"]));
                $devolucionunidad = strip_tags(base64_decode($_GET["unidadesc"]));
                $devolucionbonif = strip_tags(base64_decode($_GET["cantbonif"]));
                $cantcaja = strip_tags($devolucioncaja + $devolucionbonif);
                $stocktotalcaja = $stockcajasdb - $cantcaja;
                $canttotal = strip_tags($cantcaja * $devolucionunidad);
                $stocktotalunidad = $stocktotaldb - $canttotal;
                $preciocompram = strip_tags(base64_decode($_GET['preciocomprac']));
                $precioventacajam = strip_tags(base64_decode($_GET['precioventacajac']));
                $precioventaunidadm = strip_tags(base64_decode($_GET['precioventaunidadc']));
                $ivaproducto = strip_tags(base64_decode($_GET['ivaproductoc']));
                $descproducto = strip_tags(base64_decode($_GET['descproductoc']));
                $documento = strip_tags("DEVOLUCI�N COMPRA - " . base64_decode($_GET["codcompra"]));
                $fechakardex = strip_tags(date("Y-m-d"));
                $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

                $sql4 = "select ivac, totalivac from compras where codcompra = ? ";
                $stmt = $this->dbh->prepare($sql4);
                $stmt->execute(array(base64_decode($_GET["codcompra"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $paea[] = $row;
                }
                $iva = $paea[0]["ivac"] / 100;
                $totaliva = $paea[0]["totalivac"];

                $sql5 = "select sum(totaldescuentoc) as descuento, sum(descbonific) as bonificacion, sum(valorneto) as neto from detallecompras where codcompra = ?";
                $stmt = $this->dbh->prepare($sql5);
                $stmt->execute(array(base64_decode($_GET["codcompra"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch()) {
                    $p[] = $row;
                }
                $descuento = ($row["descuento"] == "" ? "0.00" : $row["descuento"]);
                $bonificacion = ($row["bonificacion"] == "" ? "0.00" : $row["bonificacion"]);
                $valorneto = ($row["neto"] == "" ? "0.00" : $row["neto"]);



                if (base64_decode($_GET["ivaproductoc"]) == "SI") {

                    $sql3 = "select sum(valorneto) as valorneto, sum(descbonific) as descbonific from detallecompras where codcompra = ? and ivaproductoc = 'SI'";
                    $stmt = $this->dbh->prepare($sql3);
                    $stmt->execute(array(base64_decode($_GET["codcompra"])));
                    $num = $stmt->rowCount();

                    if ($roww = $stmt->fetch()) {
                        $p[] = $roww;
                    }
                    $neto = ($roww["valorneto"] == "" ? "0" : $roww["valorneto"]);
                    $bonific = ($roww["descbonific"] == "" ? "0" : $roww["descbonific"]);

                    $sql = " update compras set "
                        . " descuentoc = ?, "
                        . " descbonific = ?, "
                        . " subtotalc = ?, "
                        . " totalsinimpuestosc = ?, "
                        . " tarifasi = ?, "
                        . " totalivac = ?, "
                        . " totalc= ? "
                        . " where "
                        . " codcompra = ?;
			   ";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $descuentoc);
                    $stmt->bindParam(2, $descbonific);
                    $stmt->bindParam(3, $subtotalc);
                    $stmt->bindParam(4, $totalsinimpuestosc);
                    $stmt->bindParam(5, $tarifasi);
                    $stmt->bindParam(6, $totalivac);
                    $stmt->bindParam(7, $total);
                    $stmt->bindParam(8, $codcompra);

                    $descuentoc = number_format($descuento, 2);
                    $descbonific = number_format($bonificacion, 2);
                    $subtotalc = number_format($valorneto + $descuentoc, 2);
                    $totalsinimpuestosc = number_format($valorneto, 2);
                    $tarifasi = number_format($neto - $bonific, 2);
                    $totalivac = number_format($tarifasi * $iva, 2);
                    $resto = number_format($descuentoc + $descbonific, 2);
                    $subtotalresto = number_format($subtotalc - $resto, 2);
                    $total = number_format($subtotalresto + $totalivac, 2);
                    $codcompra = strip_tags(base64_decode($_GET["codcompra"]));
                    $stmt->execute();
                } else {

                    $sql3 = "select sum(valorneto) as valorneto, sum(descbonific) as descbonific from detallecompras where codcompra = ? and ivaproductoc = 'NO'";
                    $stmt = $this->dbh->prepare($sql3);
                    $stmt->execute(array(base64_decode($_GET["codcompra"])));
                    $num = $stmt->rowCount();

                    if ($roww = $stmt->fetch()) {
                        $p[] = $roww;
                    }
                    $neto = ($roww["valorneto"] == "" ? "0" : $roww["valorneto"]);
                    $bonific = ($roww["descbonific"] == "" ? "0" : $roww["descbonific"]);

                    $sql = " update compras set "
                        . " descuentoc = ?, "
                        . " descbonific = ?, "
                        . " subtotalc = ?, "
                        . " totalsinimpuestosc = ?, "
                        . " tarifano = ?, "
                        . " totalc= ? "
                        . " where "
                        . " codcompra = ?;
			   ";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $descuentoc);
                    $stmt->bindParam(2, $descbonific);
                    $stmt->bindParam(3, $subtotalc);
                    $stmt->bindParam(4, $totalsinimpuestosc);
                    $stmt->bindParam(5, $tarifano);
                    $stmt->bindParam(6, $total);
                    $stmt->bindParam(7, $codcompra);

                    $descuentoc = number_format($descuento, 2);
                    $descbonific = number_format($bonificacion, 2);
                    $subtotalc = number_format($valorneto + $descuentoc, 2);
                    $totalsinimpuestosc = number_format($valorneto, 2);
                    $tarifano = number_format($neto - $bonific, 2);
                    $resto = number_format($descuentoc + $descbonific, 2);
                    $subtotalresto = number_format($subtotalc - $resto, 2);
                    $total = number_format($subtotalresto + $totaliva, 2);
                    $codcompra = strip_tags(base64_decode($_GET["codcompra"]));
                    $stmt->execute();
                }

                header("Location: detallescompras?mesage=1");
                exit;
            } else {

                ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN #####################
                $sql2 = "select stockcajas, stocktotal from productos where codproducto = ? and codsucursal = ?";
                $stmt = $this->dbh->prepare($sql2);
                $stmt->execute(array(base64_decode($_GET["codproductoc"]), base64_decode($_GET["codsucursal"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $p[] = $row;
                }
                $stockcajasdb = $row['stockcajas'];
                $stocktotaldb = $row['stocktotal'];

                ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ######################
                $sql = " update productos set "
                    . " stockcajas = ?, "
                    . " stocktotal = ? "
                    . " where "
                    . " codproducto = ? and codsucursal = ?;
			   ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $stockcajas);
                $stmt->bindParam(2, $stocktotal);
                $stmt->bindParam(3, $codproducto);
                $stmt->bindParam(4, $codsucursal);
                $cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
                $cantbonif = strip_tags(base64_decode($_GET["cantbonif"]));
                $unidad = strip_tags(base64_decode($_GET["unidadesc"]));
                $codproducto = strip_tags(base64_decode($_GET["codproductoc"]));
                $codsucursal = strip_tags(base64_decode($_GET["codsucursal"]));
                $resto = $cantcompra + $cantbonif;
                $stockcajas = $stockcajasdb - $resto;
                $calculo = $resto * $unidad;
                $stocktotal = $stocktotaldb - $calculo;
                $stmt->execute();


                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codcompra);
                $stmt->bindParam(2, $codproveedor);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);
                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);
                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);
                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);
                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);

                $codcompra = strip_tags(base64_decode($_GET["codcompra"]));
                $codproveedor = strip_tags(base64_decode($_GET["codproveedor"]));
                $codsucursalm = strip_tags(base64_decode($_GET["codsucursal"]));
                $codproductom = strip_tags(base64_decode($_GET["codproductoc"]));
                $movimiento = strip_tags("DEVOLUCION");
                $entradacaja = strip_tags("0");
                $entradaunidad = strip_tags("0");
                $entradacajano = strip_tags("0");
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags("0");
                $salidabonif = strip_tags("0");
                $devolucioncaja = strip_tags(base64_decode($_GET["cantcompra"]));
                $devolucionunidad = strip_tags(base64_decode($_GET["unidadesc"]));
                $devolucionbonif = strip_tags(base64_decode($_GET["cantbonif"]));
                $cantcaja = strip_tags($devolucioncaja + $devolucionbonif);
                $stocktotalcaja = $stockcajasdb - $cantcaja;
                $canttotal = strip_tags($cantcaja * $devolucionunidad);
                $stocktotalunidad = $stocktotaldb - $canttotal;
                $preciocompram = strip_tags(base64_decode($_GET['preciocomprac']));
                $precioventacajam = strip_tags(base64_decode($_GET['precioventacajac']));
                $precioventaunidadm = strip_tags(base64_decode($_GET['precioventaunidadc']));
                $ivaproducto = strip_tags(base64_decode($_GET['ivaproductoc']));
                $descproducto = strip_tags(base64_decode($_GET['descproductoc']));
                $documento = strip_tags("DEVOLUCI�N COMPRA - " . base64_decode($_GET["codcompra"]));
                $fechakardex = strip_tags(date("Y-m-d"));
                $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

                $sql = " delete from compras where codcompra = ?";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codcompra);
                $codcompra = base64_decode($_GET["codcompra"]);
                $stmt->execute();

                $sql = " delete from detallecompras where coddetallecompra = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $coddetallecompra);
                $coddetallecompra = base64_decode($_GET["coddetallecompra"]);
                $stmt->execute();

                header("Location: detallescompras?mesage=1");
                exit;
            }
        } else {
            header("Location: detallescompras?mesage=2");
            exit;
        }
    }
    ############################## FUNCION ELIMINAR DETALLES COMPRAS ###############################

    ###################### FUNCION BUSCAR COMPRAS POR PROVEEDOR PARA REPORTES ######################
    public function BuscarComprasProveedor()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, proveedores.rucproveedor, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos, SUM(detallecompras.cantbonif) as articulos2 FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = ? AND proveedores.codproveedor = ? GROUP BY compras.codcompra";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim($_GET['codproveedor']));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS PARA LA SUCURSAL Y EL PROVEEDOR SELECCIONADO</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, proveedores.rucproveedor, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos, SUM(detallecompras.cantbonif) as articulos2 FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = ? AND proveedores.codproveedor = ? GROUP BY compras.codcompra";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim($_GET['codproveedor']));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS PARA LA SUCURSAL Y EL PROVEEDOR SELECCIONADO</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ######################## FUNCION BUSCAR COMPRAS POR PROVEEDOR PARA REPORTES ########################

    ######################### FUNCION BUSCAR COMPRAS POR FECHAS PARA REPORTES ########################
    public function BuscarComprasFechas()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, proveedores.rucproveedor, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos, SUM(detallecompras.cantbonif) as articulos2 FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = ? AND DATE_FORMAT(compras.fechacompra,'%Y-%m-%d') >= ? AND DATE_FORMAT(compras.fechacompra,'%Y-%m-%d') <= ? GROUP BY compras.codcompra";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS PARA SUCURSAL Y FECHA SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, proveedores.rucproveedor, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos, SUM(detallecompras.cantbonif) as articulos2 FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = ? AND DATE_FORMAT(compras.fechacompra,'%Y-%m-%d') >= ? AND DATE_FORMAT(compras.fechacompra,'%Y-%m-%d') <= ? AND compras.codsucursal = " . $_SESSION["codsucursal"] . " GROUP BY compras.codcompra";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS PARA SUCURSAL Y FECHA SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ######################## FUNCION BUSCAR COMPRAS POR FECHAS PARA REPORTES ########################

    ######################### FUNCION BUSCAR COMPRAS POR PAGAR PARA REPORTES ########################
    public function BuscarComprasxPagar()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, proveedores.rucproveedor, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos, SUM(detallecompras.cantbonif) as articulos2 FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = ? AND compras.statuscompra = 'PENDIENTE' GROUP BY compras.codcompra";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS PARA LA SUCURSAL SELECCIONADA</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = " SELECT compras.codcompra, compras.descuentoc, compras.descbonific, compras.subtotalc, compras.totalsinimpuestosc, compras.tarifano, compras.tarifasi, compras.ivac, compras.totalivac, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fecharecepcion, compras.fechaemision, compras.fechacompra, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, proveedores.rucproveedor, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos, SUM(detallecompras.cantbonif) as articulos2 FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codsucursal = ? AND compras.statuscompra = 'PENDIENTE' GROUP BY compras.codcompra";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) { ?>

				<script type='text/javascript' language='javascript'>
					alert('NO EXISTEN COMPRAS DE PRODUCTOS PARA ESTA SUCURSAL')
					//se actualiza la pagina padre al cerrar el popup
					var ventana = window.self;
					ventana.opener = window.self;
					ventana.close();
				</script>
			<?php
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ######################## FUNCION BUSCAR COMPRAS POR PAGAR PARA REPORTES ########################

    ################################# FIN DE CLASE COMPRAS DE PRODUCTOS ################################







































    ###################################### CLASE ARQUEO DE CAJA ######################################

    ############################# FUNCION PARA REGISTRAR ARQUEO DE CAJA ##############################
    public function RegistrarArqueoCaja()
    {
        self::SetNames();
        if (empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["fecharegistro"])) {
            echo "1";
            exit;
        }
        $sql = " select codcaja from arqueocaja where codcaja = ? and statusarqueo = '1'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array($_POST["codcaja"]));
        $num = $stmt->rowCount();
        if ($num == 0) {
            $query = " insert into arqueocaja values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";


            $codcaja = strip_tags($_POST["codcaja"]);
            $montoinicial = strip_tags($_POST["montoinicial"]);
            if (strip_tags(isset($_POST['ingresos']))) {
                $ingresos = strip_tags($_POST['ingresos']);
            } else {
                $ingresos = 0.00;
            }
            if (strip_tags(isset($_POST['egresos']))) {
                $egresos = strip_tags($_POST['egresos']);
            } else {
                $egresos = 0.00;
            }
            if (strip_tags(isset($_POST['dineroefectivo']))) {
                $dineroefectivo = strip_tags($_POST['dineroefectivo']);
            } else {
                $dineroefectivo = 0.00;
            }
            if (strip_tags(isset($_POST['diferencia']))) {
                $diferencia = strip_tags($_POST['diferencia']);
            } else {
                $diferencia = 0.00;
            }
            if (strip_tags(isset($_POST['comentarios']))) {
                $comentarios = strip_tags($_POST['comentarios']);
            } else {
                $comentarios = '';
            }
            $fechaapertura = strip_tags(date("Y-m-d h:i:s", strtotime($_POST['fecharegistro'])));
            //$fechacierre = strip_tags(date("00-00-0000 00:00:00"));
            $fechacierre = null;
            $statusarqueo = strip_tags("1");

            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $codcaja);
            $stmt->bindParam(2, $montoinicial);
            $stmt->bindParam(3, $ingresos);
            $stmt->bindParam(4, $egresos);
            $stmt->bindParam(5, $dineroefectivo);
            $stmt->bindParam(6, $diferencia);
            $stmt->bindParam(7, $comentarios);
            $stmt->bindParam(8, $fechaapertura);
            $stmt->bindParam(9, $fechacierre);
            $stmt->bindParam(10, $statusarqueo);


            $stmt->execute();
            //var_dump($stmt);



            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL ARQUEO DE CAJA FUE REALIZADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ############################### FUNCION PARA REGISTRAR ARQUEO DE CAJA #############################

    ############################## FUNCION PARA LISTAR ARQUEO DE CAJA ################################
    public function ListarArqueoCaja()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorS") {

            $sql = " SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE usuarios.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } elseif ($_SESSION["acceso"] == "cajero") {


            $sql = " SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja WHERE cajas.codigo = '" . $_SESSION["codigo"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################## FUNCION PARA LISTAR ARQUEO DE CAJA ##############################

    ############################# FUNCION ID ARQUEO DE CAJA #####################################
    public function ArqueoCajaPorId()
    {
        self::SetNames();
        $sql = " select * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo where arqueocaja.codarqueo = ? ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codarqueo"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################### FUNCION ID ARQUEO DE CAJA ###############################

    ############################# FUNCION PARA CERRAR ARQUEO DE CAJA ##############################
    public function CerrarArqueoCaja()
    {

        self::SetNames();
        if (empty($_POST["codarqueo"]) or empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["dineroefectivo"])) {
            echo "1";
            exit;
        }

        $sql = " update arqueocaja set "
            . " dineroefectivo = ?, "
            . " diferencia = ?, "
            . " comentarios = ?, "
            . " fechacierre = ?, "
            . " statusarqueo = ? "
            . " where "
            . " codarqueo = ?;
				";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $dineroefectivo);
        $stmt->bindParam(2, $diferencia);
        $stmt->bindParam(3, $comentarios);
        $stmt->bindParam(4, $fechacierre);
        $stmt->bindParam(5, $statusarqueo);
        $stmt->bindParam(6, $codarqueo);

        $dineroefectivo = strip_tags($_POST["dineroefectivo"]);
        $diferencia = strip_tags($_POST["diferencia"]);
        $comentarios = strip_tags($_POST['comentarios']);
        $fechacierre = strip_tags(date("Y-m-d h:i:s"));
        $statusarqueo = strip_tags("0");
        $codarqueo = strip_tags($_POST["codarqueo"]);
        $stmt->execute();

        echo "<div class='alert alert-info'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> EL ARQUEO DE CAJA FUE CERRADO EXITOSAMENTE";
        echo "</div>";
        exit;
    }
    ############################ FUNCION PARA CERRAR ARQUEO DE CAJA ################################

    ################################ FIN DE CLASE ARQUEO DE CAJA ##################################












































    ############################# CLASE MOVIMIENTOS DE CAJAS ################################

    ######################### FUNCION PARA REGISTRAR MOVIMIENTOS DE CAJAS #########################
    public function RegistrarMovimientoCajas()
    {
        self::SetNames();
        if (empty($_POST["tipomovimientocaja"]) or empty($_POST["montomovimientocaja"]) or empty($_POST["mediopagomovimientocaja"]) or empty($_POST["codcaja"])) {
            echo "1";
            exit;
        }

        $sql = " SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja WHERE arqueocaja.codcaja = " . $_POST["codcaja"] . " AND statusarqueo = '1'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "2";
            exit;
        } elseif ($_POST["montomovimientocaja"] > 0) {


            #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
            $sql = "select montoinicial, ingresos, egresos from arqueocaja where codcaja = '" . $_POST["codcaja"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            $inicial = $row['montoinicial'];
            $ingreso = $row['ingresos'];
            $egresos = $row['egresos'];
            $total = $inicial + $ingreso - $egresos;

            if ($_POST["tipomovimientocaja"] == "INGRESO") {

                $sql = " update arqueocaja set "
                    . " ingresos = ? "
                    . " where "
                    . " codcaja = ? and statusarqueo = '1';
		";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $ingresos);
                $stmt->bindParam(2, $codcaja);

                $ingresos = number_format($_POST["montomovimientocaja"] + $ingreso, 2);
                $codcaja = strip_tags($_POST["codcaja"]);
                $stmt->execute();

                $query = " insert into movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $tipomovimientocaja);
                $stmt->bindParam(2, $montomovimientocaja);
                $stmt->bindParam(3, $mediopagomovimientocaja);
                $stmt->bindParam(4, $codcaja);
                $stmt->bindParam(5, $descripcionmovimientocaja);
                $stmt->bindParam(6, $fechamovimientocaja);
                $stmt->bindParam(7, $codigo);

                $tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
                $montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
                $mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
                $codcaja = strip_tags($_POST["codcaja"]);
                $descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
                $fechamovimientocaja = strip_tags(date("Y-m-d h:i:s", strtotime($_POST['fecharegistro'])));
                $codigo = strip_tags($_SESSION["codigo"]);
                $stmt->execute();
            } else {

                if ($_POST["montomovimientocaja"] > $total) {

                    echo "3";
                    exit;
                } else {

                    $sql = " update arqueocaja set "
                        . " egresos = ? "
                        . " where "
                        . " codcaja = ? and statusarqueo = '1';
		";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $egresos);
                    $stmt->bindParam(2, $codcaja);

                    $egresos = number_format($_POST["montomovimientocaja"] + $egresos, 2);
                    $codcaja = strip_tags($_POST["codcaja"]);
                    $stmt->execute();

                    $query = " insert into movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
                    $stmt = $this->dbh->prepare($query);
                    $stmt->bindParam(1, $tipomovimientocaja);
                    $stmt->bindParam(2, $montomovimientocaja);
                    $stmt->bindParam(3, $mediopagomovimientocaja);
                    $stmt->bindParam(4, $codcaja);
                    $stmt->bindParam(5, $descripcionmovimientocaja);
                    $stmt->bindParam(6, $fechamovimientocaja);
                    $stmt->bindParam(7, $codigo);

                    $tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
                    $montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
                    $mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
                    $codcaja = strip_tags($_POST["codcaja"]);
                    $descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
                    $fechamovimientocaja = strip_tags(date("Y-m-d h:i:s", strtotime($_POST['fecharegistro'])));
                    $codigo = strip_tags($_SESSION["codigo"]);
                    $stmt->execute();
                }
            }

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO DE CAJA FUE REGISTRADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "4";
            exit;
        }
    }
    ######################## FUNCION PARA REGISTRAR MOVIMIENTOS DE CAJAS #########################

    ########################## FUNCION PARA LISTAR MOVIMIENTOS DE CAJAS ############################
    public function ListarMovimientoCajas()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorS") {

            $sql = " SELECT * FROM movimientoscajas INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.mediopagomovimientocaja WHERE usuarios.codsucursal = '" . $_SESSION["codsucursal"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } elseif ($_SESSION["acceso"] == "cajero") {

            $sql = " SELECT * FROM movimientoscajas LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.mediopagomovimientocaja WHERE codigo = '" . $_SESSION["codigo"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = " SELECT * FROM movimientoscajas LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.mediopagomovimientocaja";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ######################## FUNCION PARA LISTAR MOVIMIENTOS DE CAJAS ##########################

    ######################## FUNCION PARA SELECCIONAR MOVIMIENTOS DE CAJAS ###########################
    public function MovimientoCajasPorId()
    {
        self::SetNames();
        $sql = " SELECT * from movimientoscajas LEFT JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja LEFT JOIN mediospagos ON movimientoscajas.mediopagomovimientocaja = mediospagos.codmediopago LEFT JOIN usuarios ON movimientoscajas.codigo = usuarios.codigo WHERE movimientoscajas.codmovimientocaja = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codmovimientocaja"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ######################### FUNCION PARA SELECCIONAR MOVIMIENTOS DE CAJAS ############################

    ######################## FUNCION PARA ACTUALIZAR MOVIMIENTOS DE CAJAS #########################
    public function ActualizarMovimientoCajas()
    {
        self::SetNames();
        if (empty($_POST["tipomovimientocaja"]) or empty($_POST["montomovimientocaja"]) or empty($_POST["mediopagomovimientocaja"]) or empty($_POST["codcaja"])) {
            echo "1";
            exit;
        }

        if ($_POST["montomovimientocaja"] > 0) {

            #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
            $sql = "select montoinicial, ingresos, egresos from arqueocaja where codcaja = '" . $_POST["codcaja"] . "' and statusarqueo = '1'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            $inicial = $row['montoinicial'];
            $ingreso = $row['ingresos'];
            $egreso = $row['egresos'];
            $total = $inicial + $ingreso - $egreso;
            $montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
            $movimientodb = strip_tags($_POST["montomovimientocajadb"]);
            $totalmovimiento = number_format($montomovimientocaja - $movimientodb, 2);

            if ($_POST["tipomovimientocaja"] == "INGRESO") {

                $sql = " update arqueocaja set "
                    . " ingresos = ? "
                    . " where "
                    . " codcaja = ? and statusarqueo = '1';
		";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $ingresos);
                $stmt->bindParam(2, $codcaja);

                $ingresos = number_format($totalmovimiento + $ingreso, 2);
                $codcaja = strip_tags($_POST["codcaja"]);
                $stmt->execute();

                $sql = " update movimientoscajas set "
                    . " tipomovimientocaja = ?, "
                    . " montomovimientocaja = ?, "
                    . " mediopagomovimientocaja = ?, "
                    . " codcaja = ?, "
                    . " descripcionmovimientocaja = ? "
                    . " where "
                    . " codmovimientocaja = ?;
		";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $tipomovimientocaja);
                $stmt->bindParam(2, $montomovimientocaja);
                $stmt->bindParam(3, $mediopagomovimientocaja);
                $stmt->bindParam(4, $codcaja);
                $stmt->bindParam(5, $descripcionmovimientocaja);
                $stmt->bindParam(6, $codmovimientocaja);

                $tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
                $montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
                $mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
                $codcaja = strip_tags($_POST["codcaja"]);
                $descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
                $codmovimientocaja = strip_tags($_POST["codmovimientocaja"]);
                $stmt->execute();
            } else {

                if ($totalmovimiento > $total) {

                    echo "2";
                    exit;
                } else {

                    $sql = " update arqueocaja set "
                        . " egresos = ? "
                        . " where "
                        . " codcaja = ? and statusarqueo = '1';
		";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $egresos);
                    $stmt->bindParam(2, $codcaja);

                    $egresos = number_format($totalmovimiento + $egreso, 2);
                    $codcaja = strip_tags($_POST["codcaja"]);
                    $stmt->execute();

                    $sql = " update movimientoscajas set "
                        . " tipomovimientocaja = ?, "
                        . " montomovimientocaja = ?, "
                        . " mediopagomovimientocaja = ?, "
                        . " codcaja = ?, "
                        . " descripcionmovimientocaja = ? "
                        . " where "
                        . " codmovimientocaja = ?;
		";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $tipomovimientocaja);
                    $stmt->bindParam(2, $montomovimientocaja);
                    $stmt->bindParam(3, $mediopagomovimientocaja);
                    $stmt->bindParam(4, $codcaja);
                    $stmt->bindParam(5, $descripcionmovimientocaja);
                    $stmt->bindParam(6, $codmovimientocaja);

                    $tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
                    $montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
                    $mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
                    $codcaja = strip_tags($_POST["codcaja"]);
                    $descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
                    $codmovimientocaja = strip_tags($_POST["codmovimientocaja"]);
                    $stmt->execute();
                }
            }

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO DE CAJA FUE ACTUALIZADO EXITOSAMENTE";
            echo "</div>";
            exit;
        } else {
            echo "2";
            exit;
        }
    }
    ########################## FUNCION PARA ACTUALIZAR MOVIMIENTOS DE CAJAS ###########################

    ######################### FUNCION PARA ELIMINAR MOVIMIENTOS DE CAJAS ##########################
    public function EliminarMovimientoCajas()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") {

            #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
            $sql = "select montoinicial, ingresos, egresos from arqueocaja where codcaja = '" . base64_decode($_GET["codcaja"]) . "' and statusarqueo = '1'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            $inicial = $row['montoinicial'];
            $ingreso = $row['ingresos'];
            $egreso = $row['egresos'];

            if (base64_decode($_GET["tipomovimientocaja"]) == "INGRESO") {

                $sql = " update arqueocaja set "
                    . " ingresos = ? "
                    . " where "
                    . " codcaja = ? and statusarqueo = '1';
		";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $ingresos);
                $stmt->bindParam(2, $codcaja);

                $entro = base64_decode($_GET["montomovimientocaja"]);
                $ingresos = number_format($ingreso - $entro, 2);
                $codcaja = base64_decode($_GET["codcaja"]);
                $stmt->execute();
            } else {

                $sql = " update arqueocaja set "
                    . " egresos = ? "
                    . " where "
                    . " codcaja = ? and statusarqueo = '1';
		";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $egresos);
                $stmt->bindParam(2, $codcaja);

                $salio = base64_decode($_GET["montomovimientocaja"]);
                $egresos = number_format($egreso - $salio, 2);
                $codcaja = base64_decode($_GET["codcaja"]);
                $stmt->execute();
            }

            $sql = " delete from movimientoscajas where codmovimientocaja = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $codmovimientocaja);
            $codmovimientocaja = base64_decode($_GET["codmovimientocaja"]);
            $stmt->execute();

            header("Location: movimientoscajas?mesage=1");
            exit;
        } else {

            header("Location: movimientoscajas?mesage=2");
            exit;
        }
    }
    ############################# FUNCION PARA ELIMINAR MOVIMIENTOS DE CAJAS  ##########################

    ################################# FIN DE CLASE MOVIMIENTOS DE CAJAS ################################

















































    ################################## CLASE VENTAS DE PRODUCTOS #####################################

    ################################# FUNCION LISTAR CLIENTES VENTAS ##################################
    public function ListarClientesVentas()
    {
        self::SetNames();

        $sql = " SELECT * from clientes WHERE CONCAT(nrocliente, '',cedcliente, '',nomcliente) LIKE '%" . $_GET["buscacliente"] . "%' ORDER BY codcliente ASC LIMIT 0,20";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {

            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA !</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION LISTAR CLIENTES VENTAS ##################################

    ###################################### FUNCION VERIFICA CAJAS ######################################
    public function VerificaCaja()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {
        } else {

            $sql = " select * from cajas where codigo = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array($_SESSION["codigo"]));
            $num = $stmt->rowCount();
            if ($num == 0) {
                ?>
				<script type='text/javascript' language='javascript'>
					alert(
						'DISCULPE, USTED NO TIENE ASIGNADA UNA CAJA PARA VENTA, \nDIRIJASE AL ADMINISTRADOR DEL SISTEMA PARA QUE LE SEA ASIGNADA UNA CAJA'
					)
					document.location.href = 'panel'
				</script>
			<?php
                    exit;
            } else {
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ###################################### FUNCION VERIFICA CAJAS ######################################

    ############################## FUNCION VERIFICAR CAJAS EN VENTAS ###############################
    public function VerificaArqueo()
    {
        self::SetNames();


        $sql = " SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja WHERE cajas.codigo = " . $_SESSION["codigo"] . " AND statusarqueo = '1'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num > 0) {
            ?>

			<div class="row">
				<input class="form-control" type="hidden" name="codproducto" id="codproducto">
				<input class="form-control" type="hidden" name="producto" id="producto">
				<input class="form-control" type="hidden" name="descripcion" id="descripcion">
				<input class="form-control" type="hidden" name="principioactivo" id="principioactivo">
				<input class="form-control" type="hidden" name="codpresentacion" id="codpresentacion">
				<input class="form-control" type="hidden" name="codmedida" id="codmedida">
				<input class="form-control" type="hidden" name="preciocompra" id="preciocompra">
				<input class="form-control" type="hidden" name="precioconiva" id="precioconiva">
				<input class="form-control" type="hidden" name="ivaproducto" id="ivaproducto">
				<input class="form-control" type="hidden" name="desclaboratorio" id="desclaboratorio">
				<input class="form-control" type="hidden" value="<?php echo $_SESSION['descsucursal']; ?>" name="descgeneral" id="descgeneral">



				<div class="col-md-6">
					<div class="form-group has-feedback">
						<label class="control-label">Descripci&oacute;n de Productos: </label>
						<input type="text" class="form-control agregar" name="busquedaproductov" id="busquedaproductov" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="1" placeholder="Realice la b&uacute;squeda de Productos">
						<i class="fa fa-search form-control-feedback"></i>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group has-feedback">
						<label class="control-label">Tipo Venta: <span class="symbol required"></span> </label>
						<select class="form-control" onchange="calculaUnidadCosto()" id="tipoVenta" name="tipoventa">
							<option value="Unidad">Unidad</option>
							<option value="Blister">Blister</option>
							<option value="Caja">Caja</option>
							<option value="BlisterDescuento">Blister con Descuento</option>
							<option value="CajaDescuento">Caja con Descuento</option>

						</select>
					</div>
				</div>



			</div>


			<div class="row">
				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">P.V.P (Caja): <span class="symbol required"></span> </label>
						<input class="form-control" type="text" name="precioventacaja" id="precioventacaja" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="P.V.P (Caja)" readonly="readonly">
						<input type="hidden" id="unidadCaja" />
						<i class="fa fa-money form-control-feedback"></i>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">P.V.P (Blister): <span class="symbol required"></span> </label>
						<input class="form-control" type="text" name="precioventablister" id="precioventablister" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="P.V.P (Blister)" readonly="readonly">
						<input type="hidden" id="unidadBlister" />
						<i class="fa fa-money form-control-feedback"></i>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">P.V.P (Unidad): <span class="symbol required"></span> </label>
						<input class="form-control" type="text" name="precioventaunidad" id="precioventaunidad" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="P.V.P (Unidad)" readonly="readonly">
						<i class="fa fa-money form-control-feedback"></i>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">P.V.P (Blister con Descuento): <span class="symbol required"></span> </label>
						<input class="form-control" type="text" name="precioventablisterdesc" id="precioventablisterdesc" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="P.V.P (Blister con Descuento)" readonly="readonly">
						<i class="fa fa-money form-control-feedback"></i>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">P.V.P (Caja con Descuento): <span class="symbol required"></span> </label>
						<input class="form-control" type="text" name="precioventacajadesc" id="precioventacajadesc" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="P.V.P (Blister con Descuento)" readonly="readonly">
						<i class="fa fa-money form-control-feedback"></i>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">Stock Actual: <span class="symbol required"></span> </label>
						<input type="text" class="form-control" name="stocktotal" id="stocktotal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Stock Actual" readonly="readonly">
						<i class="fa fa-pencil form-control-feedback"></i>
					</div>
				</div>



			</div>
			<div class="row">


				<div class="col-md-3">
					<input type="hidden" id="unidadcaja" />
					<input type="hidden" id="unidadblister" />
					<input type="hidden" id="precioventablister" />
					<input type="hidden" id="precioventacaja" />
					<input type="hidden" id="cantidad" name="cantidad" />

					<div class="form-group has-feedback">
						<label class="control-label">Cantidad Venta: <span class="symbol required"></span></label>
						<input type="text" class="form-control agregar" name="cantidadprev" id="cantidadprev" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="2" placeholder="Ingrese Cantidad Venta" onchange="calculaUnidadCosto()">
						<i class="fa fa-pencil form-control-feedback"></i>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">Descuento: <span class="symbol required"></span></label>
						<input type="text" class="form-control agregar" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" tabindex="3" autocomplete="off" placeholder="Ingrese Descuento">
						<i class="fa fa-pencil form-control-feedback"></i>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group has-feedback">
						<label class="control-label">Cantidad Bonif: <span class="symbol required"></span></label>
						<input type="text" class="form-control agregar" name="cantidad2" id="cantidad2" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" tabindex="4" placeholder="Ingrese Cantidad Bonif" value="0">
						<i class="fa fa-pencil form-control-feedback"></i>
					</div>
				</div>
			</div>

			<hr>
			<div align="right">
				<button type="button" id="AgregaV" tabindex="5" class="btn btn-info"><span class="fa fa-cart-plus"></span>
					Agregar</button>
			</div>
			<hr>

<?php

        } else {

            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> DEBE DE REALIZAR EL ARQUEO DE CAJA PARA REGISTRAR VENTAS, PARA HACER ARQUEO HAZ CLIC <a href='forarqueo'>AQUI</a></center>";
            echo "</div>";
        }
    }
    ############################## FUNCION VERIFICAR CAJAS EN VENTAS ###############################

    public function ActualizaPrecioVentaDetalle($codproducto, $codventa)
    {
        self::SetNames();
        $sql = "
                update detalleventas
                set preciocompraunidadv  = (select productos.preciocompraunidad
                                            from productos
                                            where productos.codproducto = $codproducto),
                    precioventablisterv  = (select productos.precioventablister
                                            from productos
                                            where productos.codproducto = $codproducto),
                    preciocomprablisterv = (select productos.preciocomprablister
                                            from productos
                                            where productos.codproducto = $codproducto)            
                where codventa = ?
            ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim($codventa));
        $stmt->execute();
    }


    ################################## FUNCION REGISTRAR VENTAS ##################################
    public function RegistrarVentas()
    {
        self::SetNames();
        if (empty($_POST["tipopagove"]) or empty($_POST["codcaja"]) or empty($_POST["codsucursal"])) {
            echo "1";
            exit;
        }

        if (strip_tags(isset($_POST['fechavencecredito']))) {

            $fechaactual = date("Y-m-d");
            $fechavence = date("Y-m-d", strtotime($_POST['fechavencecredito']));

            if (strtotime($fechavence) < strtotime($fechaactual)) {

                echo "2";
                exit;
            }
        }

        if ($_POST["tipopagove"] == "CREDITO" && $_POST["codcliente"] == '0') {

            echo "3";
            exit;
        }

        if (empty($_SESSION["CarritoV"])) {
            echo "4";
            exit;
        } elseif ($_POST["tipopagove"] == "CREDITO" && $_POST["montoabono"] >= $_POST["txtTotal"]) {
            echo "5";
            exit;
        } else {


            ############### AQUI VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ################
            $v = $_SESSION["CarritoV"];

            $tipoventaInsert = strip_tags($_POST["tipoventa"]);

            for ($i = 0; $i < count($v); $i++) {

                if ($v[$i]['tipoventa'] == 'Unidad') {
                    $sql = "select stocktotal from productos where codproducto = '" . $v[$i]['txtCodigo'] . "'";
                    foreach ($this->dbh->query($sql) as $row) {
                        $this->p[] = $row;
                    }

                    $existenciadb = $row['stocktotal'];
                    $cantidad = $v[$i]['cantidad'] + $v[$i]['cantidad2'];

                    if ($cantidad > $existenciadb) {
                        echo "6";
                        exit;
                    }
                } elseif ($v[$i]['tipoventa'] == 'Blister' || $v[$i]['tipoventa'] == 'BlisterDescuento') {
                    $sql = "select stockblister from productos where codproducto = '" . $v[$i]['txtCodigo'] . "'";
                    foreach ($this->dbh->query($sql) as $row) {
                        $this->p[] = $row;
                    }

                    $existenciadb = $row['stockblister'];
                    $cantidad = $v[$i]['cantidad'] + $v[$i]['cantidad2'];

                    if ($cantidad > $existenciadb) {
                        echo "6";
                        exit;
                    }
                } elseif ($v[$i]['tipoventa'] == 'Caja' || $v[$i]['tipoventa'] == 'CajaDescuento') {
                    $sql = "select stockcajas from productos where codproducto = '" . $v[$i]['txtCodigo'] . "'";
                    foreach ($this->dbh->query($sql) as $row) {
                        $this->p[] = $row;
                    }

                    $existenciadb = $row['stockcajas'];
                    $cantidad = $v[$i]['cantidad'];
                    //var_dump("cantidad:", json_encode($cantidad));
                    //var_dump("exisstencia: ", json_encode($existenciadb));

                    if ($cantidad > $existenciadb) {
                        echo "6";
                        exit;
                    }
                }
            }

            ################### AQUI CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ####################
            $sql = " SELECT * FROM sucursales INNER JOIN usuarios ON sucursales.codsucursal = usuarios.codsucursal WHERE usuarios.codigo = '" . $_SESSION["codigo"] . "'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            $nrosucursal = $row['nrosucursal'];
            $codactividad = $row['nroactividadsucursal'];
            $iniciofactura = $row['nroiniciofactura'];


            $sql = " select codventa from ventas where codsucursal = '" . $_POST["codsucursal"] . "' order by codventa desc limit 1";
            foreach ($this->dbh->query($sql) as $row) {

                $codventa = $row["codventa"];
            }
            if (empty($codventa)) {
                $nroventa = $nrosucursal . '-' . $codactividad . '-' . $iniciofactura;
            } else {
                $venta = substr($codventa, 0, -9);
                $coun = strlen($venta);
                $num     = substr($codventa, $coun);
                $dig     = $num + 1;
                $codigo = str_pad($dig, 9, "0", STR_PAD_LEFT);
                $nroventa = $nrosucursal . '-' . $codactividad . '-' . $codigo;
            }
            ################### AQUI CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ####################

            $fecha = date("Y-m-d h:i:s");
            $ivg2 = 1 + $_POST["iva"] / 100;

            $query = " insert into ventas values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $codventa);
            $stmt->bindParam(2, $codserieve);
            $stmt->bindParam(3, $codautorizacionve);
            $stmt->bindParam(4, $codcaja);
            $stmt->bindParam(5, $codcliente);
            $stmt->bindParam(6, $codsucursal);
            $stmt->bindParam(7, $tipodocumento);
            $stmt->bindParam(8, $descuentove);
            $stmt->bindParam(9, $descbonificve);
            $stmt->bindParam(10, $subtotalve);
            $stmt->bindParam(11, $totalsinimpuestosve);
            $stmt->bindParam(12, $tarifanove);
            $stmt->bindParam(13, $tarifasive);
            $stmt->bindParam(14, $ivave);
            $stmt->bindParam(15, $totalivave);
            $stmt->bindParam(16, $intereses);
            $stmt->bindParam(17, $totalpago);
            $stmt->bindParam(18, $totalpago2);
            $stmt->bindParam(19, $tipopagove);
            $stmt->bindParam(20, $formapagove);
            $stmt->bindParam(21, $montopagado);
            $stmt->bindParam(22, $montodevuelto);
            $stmt->bindParam(23, $fechavencecredito);
            $stmt->bindParam(24, $statusventa);
            $stmt->bindParam(25, $fechaventa);
            $stmt->bindParam(26, $codigo);
            $stmt->bindParam(27, $correo_cliente_to_send);
            $stmt->bindParam(28, $ganancia);

            // validando correo
            if (empty($_POST['correo_cliente_to_send'])) {
                $correo_cliente_to_send = "NULL";
            } else {
                $correo_cliente_to_send = strip_tags($_POST['correo_cliente_to_send']);
            }

            $tipoventa = strip_tags($_POST["tipoventa"]);
            $codventa = strip_tags($nroventa);
            $codserieve = strip_tags(GenerateRandomStringg(10));
            $codautorizacionve = strip_tags(GenerateRandomStringg());
            $codcaja = strip_tags($_POST["codcaja"]);
            $codcliente = strip_tags($_POST["cliente"]);
            $codsucursal = strip_tags($_POST["codsucursal"]);
            $tipodocumento = strip_tags($_POST["tipodocumento"]);
            $descuentove = strip_tags($_POST["txtDescuento"]);
            $descbonificve = strip_tags($_POST["txtDescbonif"]);
            $subtotalve = strip_tags($_POST["txtsubtotal"]);
            $totalsinimpuestosve = strip_tags($_POST["txtimpuestos"]);
            $tarifanove = strip_tags($_POST["txttarifano"]);
            $tarifasive = strip_tags($_POST["txttarifasi"]);
            $ivave = strip_tags($_POST["iva"]);
            $totalivave = strip_tags($_POST["txtIva"]);
            if (strip_tags(isset($_POST['codtarjeta']))) {
                $intereses = strip_tags($_POST['codtarjeta']);
            } else {
                $intereses = '0.00';
            }
            $totalpago = strip_tags($_POST["txtTotal"]);
            $totalpago2 = strip_tags($_POST["txtTotal"]);
            $tipopagove = strip_tags($_POST["tipopagove"]);
            $ganancia = 0;

            if (strip_tags($_POST["tipopagove"] == "CONTADO")) {
                $formapagove = strip_tags(base64_decode($_POST["codmediopago"]));
            } else {
                $formapagove = "CREDITO";
            }
            if (strip_tags(isset($_POST['montopagado']))) {
                $montopagado = strip_tags($_POST['montopagado']);
            } else {
                $montopagado = '0.00';
            }
            if (strip_tags(isset($_POST['montodevuelto']))) {
                $montodevuelto = strip_tags($_POST['montodevuelto']);
            } else {
                $montodevuelto = '0.00';
            }
            if (strip_tags(isset($_POST['fechavencecredito']))) {
                $fechavencecredito = strip_tags(date("Y-m-d", strtotime($_POST['fechavencecredito'])));
            } else {
                $fechavencecredito = null;
            }
            if (strip_tags($_POST["tipopagove"] == "CONTADO")) {
                $statusventa = strip_tags("PAGADA");
            } else {
                $statusventa = "PENDIENTE";
            }
            $fechaventa = strip_tags($fecha);
            $codigo = strip_tags($_SESSION["codigo"]);
            $stmt->execute();


            $venta = $_SESSION["CarritoV"];
            for ($i = 0; $i < count($venta); $i++) {

                $sql = "select stocktotal from productos where codproducto = '" . $venta[$i]['txtCodigo'] . "' and codsucursal = '" . $_POST["codsucursal"] . "'";
                foreach ($this->dbh->query($sql) as $row) {
                    $this->p[] = $row;
                }

                $existenciadb = $row['stocktotal'];
                $cantidad = $venta[$i]['cantidad'] + $venta[$i]['cantidad2'];

                $query = " insert into detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, null, null, null); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codventa);
                $stmt->bindParam(2, $codproducto);
                $stmt->bindParam(3, $producto);
                $stmt->bindParam(4, $principioactivo);
                $stmt->bindParam(5, $descripcion);
                $stmt->bindParam(6, $presentacion);
                $stmt->bindParam(7, $tipo);
                $stmt->bindParam(8, $precio);
                $stmt->bindParam(9, $precio2);
                $stmt->bindParam(10, $precio3);
                $stmt->bindParam(11, $preciounitario);
                $stmt->bindParam(12, $cantidad);
                $stmt->bindParam(13, $novoParam);
                $stmt->bindParam(14, $valortotal);
                $stmt->bindParam(15, $descproductov);
                $stmt->bindParam(16, $descporc);
                $stmt->bindParam(17, $descbonific);
                $stmt->bindParam(18, $valorneto);
                $stmt->bindParam(19, $baseimponible);
                $stmt->bindParam(20, $ivaproducto);
                $stmt->bindParam(21, $fechadetalleventa);
                $stmt->bindParam(22, $codigo);



                $novoParam = '0';
                $codventa = strip_tags($nroventa);
                $codproducto = strip_tags($venta[$i]['txtCodigo']);
                $producto = strip_tags($venta[$i]['producto']);
                $principioactivo = strip_tags($venta[$i]['principioactivo']);
                $descripcion = strip_tags($venta[$i]['descripcion']);
                $presentacion = strip_tags($venta[$i]['presentacion']);
                $tipo = strip_tags($venta[$i]['tipo']);
                $precio = strip_tags($venta[$i]['precio']);
                $precio2 = strip_tags($venta[$i]['precio2']);
                $precio3 = strip_tags($venta[$i]['precio3']);

                $DescuentoGeneral = number_format($venta[$i]['precio3'] * $venta[$i]['descgeneral'] / 100, 4);
                $preciounitario = number_format($venta[$i]['precio3'] - $DescuentoGeneral, 4);
                $cantidad = strip_tags($venta[$i]['cantidad']);
                $cantidad2 = strip_tags($venta[$i]['cantidad2']);
                $valortotal = number_format($preciounitario * $venta[$i]['cantidad'], 4);
                $descproductov = number_format($venta[$i]['descproducto'] + $venta[$i]['desclaboratorio'], 4);

                $calcdes = number_format($preciounitario * $descproductov / 100, 4);
                $descporc = number_format($calcdes * $venta[$i]['cantidad'], 4);

                $descbonific = number_format($preciounitario * $venta[$i]['cantidad2'] * $descproductov / 100, 4);
                $valorneto = number_format($valortotal - $descporc + $descbonific, 4);

                $baseimponible = ($venta[$i]['ivaproducto'] == 'NO' ? number_format($valorneto, 2) : number_format($valorneto / $ivg2, 2));

                $ivaproducto = strip_tags($venta[$i]['ivaproducto']);
                $fechadetalleventa = strip_tags($fecha);
                $codigo = strip_tags($_SESSION['codigo']);
                $stmt->execute();

                // actualiza precios faltantes de producto en la tabla detalleventas
                $this->ActualizaPrecioVentaDetalle($codproducto, $codventa);

                ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
                /*
                    $sql = " update productos set "
                    ." stocktotal = stocktotal - ".($venta[$i]['cantidad2']+1)." where "
                    ." codproducto = '".$venta[$i]['txtCodigo']."' and codsucursal = '".$_POST["codsucursal"]."';
                    ";

                    $stmt = $this->dbh->prepare($sql);
                    $cantidad = strip_tags($venta[$i]['cantidad']+$venta[$i]['cantidad2']);
                    $stocktotal = $row['stocktotal'] - $cantidad;
                    $stmt->execute();
                    */


                ################## PARA ACTUALIZAR EL STOCK DEL ALMACEN DEPENDIENDO DEL TIPO DE VENTA ################

                $tipo_venta = $venta[$i]['tipoventa'];
                if ($tipo_venta == 'Unidad') {
                    //stockunidad
                    $stockblister = 0;
                    $stockcaja = 0;
                    $blisterunidad = 0;

                    $sql1 = "select stocktotal, 
					stockunidad, unidades, stockcajas,
					blistercaja, stockblister,blisterunidad,
					precioventaunidad, preciocompraunidad,
					codproducto from productos where codproducto = '" . $venta[$i]['txtCodigo'] . "'";

                    $totalCajas = 0;
                    $unidadTotal = 0;
                    $totalUnidad = 0;
                    $totalBlister = 0;
                    $totalStock = 0;
                    $cantidadUnitario = 0;
                    $totalGanancia = 0;

                    //Se usa para obtener la ganancia en caso de tener varios productos de diferentes tipos, unidad caja o blister, para la sumatoria total de la ganancia
                    $sql2 = "select ganancia from ventas where codventa = '" . $codventa . "'";
                    foreach ($this->dbh->query($sql2) as $row2) {
                        $this->p[] = $row2;
                        $gananciaConsultada = (int)$row2['ganancia'];
                    }

                    foreach ($this->dbh->query($sql1) as $row1) {
                        $this->p[] = $row1;


                        $totalUnidad = (int)$row1['stockunidad'] - (int)$cantidad;

                        //var_dump($cantidadUnitario);
                        //return;

                        $totalStock = (int)$row1['stocktotal'] - (int)$cantidad;

                        if ($totalUnidad < 0) {
                            if ($row1['stockcajas'] > 0) {
                                $cantidadUnitario = (int)$row1['unidades'] + $totalUnidad;
                            } else {
                                $cantidadUnitario = $totalStock;
                            }
                        } else {
                            $cantidadUnitario = (int)$totalUnidad;
                        }

                        // 10 unidades son 1 blister
                        // stocktotal / blisterunidad =
                        $totalBlister = (int)$totalStock / (int)$row1['blisterunidad'];
                        //$stockblister = (int)$row1['stockblister'] - (int)$cantidad;
                        $stockblister = (int)((int)$row1['stockblister'] - (int)$totalBlister);
                        $existenciablistercaja = (int)$row1['blistercaja'];
                        //var_dump($stockblister);
                        //return;
                        // dividir $stockblister / blistercaja  (sabriamos cuantas cajas hay pero tiene que dar entero)
                        // $totalCajas = (int)(((int)$totalBlister - $cantidadUnitario) / $existenciablistercaja);
                        $totalCajas = (int)((int)$totalBlister / $existenciablistercaja);
                        //$unidadTotal = (int)((int)$row1['blisterunidad'] * (int)$cantidad);

                        $totalGanancia += floatval((floatval($row1['precioventaunidad']) - floatval($row1['preciocompraunidad'])) * (int)$cantidad);
                    }

                    $totalGanancia = $gananciaConsultada + $totalGanancia;

                    $sql = " update productos set "
                        . " stockunidad = " . ($cantidadUnitario) . ", "
                        . " stockblister = " . ((int)$totalBlister) . ", "
                        . " stockcajas = " . ($totalCajas) . ", "
                        . " stocktotal = stocktotal - " . ($venta[$i]['cantidad2'] + 1) . " where "
                        . " codproducto = '" . $venta[$i]['txtCodigo'] . "' and codsucursal = '" . $_POST["codsucursal"] . "';";

                    $stmt = $this->dbh->prepare($sql);
                    $cantidad = strip_tags($venta[$i]['cantidad'] + $venta[$i]['cantidad2']);
                    $stocktotal = $row['stocktotal'] - $cantidad;
                    $stmt->execute();



                    $updateVentas = " update ventas set "
                        . " ganancia = '" . ($totalGanancia) . "' where "
                        . " codventa = '" . $codventa . "' and codsucursal = '" . $_POST["codsucursal"] . "';";

                    $stmt = $this->dbh->prepare($updateVentas);
                    $stmt->execute();
                } elseif ($tipo_venta  == 'Blister' || $tipo_venta  == 'BlisterDescuento') {

                    // sql para obtener blistercaja
                    $sql = "select blistercaja, 
			            stockblister,
			            blisterunidad, 
			            precioventablister, preciocomprablister,
						precioventablisterdesc,
			            stocktotal, stockcajas, unidades, codproducto from productos where codproducto = '" . $venta[$i]['txtCodigo'] . "'";
                    $totalCajas = 0;
                    $unidadTotal = 0;
                    $stockTotalOld = 0;
                    $stockblisterOld = 0;
                    $totalGanancia = 0;
                    $cantidadUnitario = 0;

                    //Se usa para obtener la ganancia en caso de tener varios productos de diferentes tipos, unidad caja o blister, para la sumatoria total de la ganancia
                    $sql2 = "select ganancia from ventas where codventa = '" . $codventa . "'";
                    foreach ($this->dbh->query($sql2) as $row2) {
                        $this->p[] = (int)$row2;
                        $gananciaConsultada = (int)$row2['ganancia'];
                    }
                    foreach ($this->dbh->query($sql) as $row1) {
                        $this->p[] = $row1;

                        // por cada blisterunidad ( 10) descontar 1 caja
                        $stockblister = (int)$row1['stockblister'] - (int)$cantidad;

                        $totalGanancia += floatval((floatval($tipo_venta == 'Blister' ? $row1['precioventablister'] : $row1['precioventablisterdesc']) - floatval($row1['preciocomprablister'])) * (int)$cantidad);

                        $existenciablistercaja = (int)$row1['blistercaja'];

                        // dividir $stockblister / blistercaja  (sabriamos cuantas cajas hay pero tiene que dar entero)

                        $totalCajas = (int)((int)$stockblister / $existenciablistercaja);
                        $stockTotalOld = (int)$row1['stocktotal'] - ((int)$venta[$i]['cantidad2'] + 1);

                        //stocktotal - stockcajas * unidades
                        //$unidadTotal = (int)$stockTotalOld - (int)((int)$totalCajas * (int)$row1['unidades']);
                        //$unidadTotal = (int)((int)$row1['stocktotal'] - (int)($venta[$i]['cantidad2'] +1) - (int)$row1['unidades'] - (int)$row1['unidades']);

                        $totalUnidad = (int)$row1['stockunidad'] - (int)$cantidad;

                        if ($totalUnidad <= 0) {
                            $cantidadUnitario = (int)$stockTotalOld - (int)((int)$totalCajas * (int)$row1['unidades']);
                        } else {
                            $cantidadUnitario = (int)$totalUnidad;
                        }
                    }
                    $totalGanancia = $gananciaConsultada + $totalGanancia;
                    // stockunidad dividir blisterunidad / $cantidad

                    // stocktotal - stockcajas * unidades

                    $sql = " update productos set "
                        . " stockblister = stockblister - " . ($venta[$i]['cantidad']) . ", "
                        . " stockunidad = " . $cantidadUnitario . ", "
                        . " stockcajas = " . ($totalCajas) . ", "
                        . " stocktotal = stocktotal - " . ($venta[$i]['cantidad2'] + 1) . " where "
                        . " codproducto = '" . $venta[$i]['txtCodigo'] . "' and codsucursal = '" . $_POST["codsucursal"] . "';
						";

                    $stmt = $this->dbh->prepare($sql);
                    $cantidad = strip_tags($venta[$i]['cantidad'] + $venta[$i]['cantidad2']);

                    $stocktotal = $row['stocktotal'] - $cantidad;
                    $stmt->execute();

                    $updateVentas = " update ventas set "
                        . " ganancia = '" . ($totalGanancia) . "' where "
                        . " codventa = '" . $codventa . "' and codsucursal = '" . $_POST["codsucursal"] . "';
        			";

                    $stmt = $this->dbh->prepare($updateVentas);
                    $stmt->execute();
                } elseif ($venta[$i]['tipoventa'] == 'Caja' || $tipo_venta  == 'CajaDescuento') {
                    // sql para obtener blistercaja
                    $sql = "select blistercaja, precioventacaja, precioventacajadesc, preciocompra, stockblister,blisterunidad, unidades, codproducto from productos where codproducto = '" . $venta[$i]['txtCodigo'] . "'";
                    $totalBlister = 0;
                    $unidadTotal = 0;
                    $totalGanancia = 0;
                    $gananciaConsultada = 0;

                    //Se usa para obtener la ganancia en caso de tener varios productos de diferentes tipos, unidad caja o blister, para la sumatoria total de la ganancia
                    $sql2 = "select ganancia from ventas where codventa = '" . $codventa . "'";
                    foreach ($this->dbh->query($sql2) as $row2) {
                        $this->p[] = $row2;
                        $gananciaConsultada = (int)$row2['ganancia'];
                    }

                    foreach ($this->dbh->query($sql) as $row1) {
                        $this->p[] = $row1;

                        $totalGanancia += floatval(($tipo_venta == 'Caja' ? floatval($row1['precioventacaja']) : floatval($row1['precioventacajadesc']) - floatval($row1['preciocompra'])) * (int)$cantidad);
                        $totalBlister = (int)$row1['blistercaja'] * (int)$cantidad;
                        //$unidadTotal = (int)((int)$row1['unidades'] * (int)$cantidad); // 200
                    }
                    $totalGanancia = $gananciaConsultada + $totalGanancia;
                    // stockcajas
                    $sql = " update productos set "
                        . " stockcajas = stockcajas - " . ($venta[$i]['cantidad']) . ", "

                        . " stockblister = stockblister - " . ($totalBlister) . ", "
                        . " stocktotal = stocktotal - " . ($venta[$i]['cantidad2'] + 1) . " where "
                        . " codproducto = '" . $venta[$i]['txtCodigo'] . "' and codsucursal = '" . $_POST["codsucursal"] . "';
						";

                    $stmt = $this->dbh->prepare($sql);
                    $cantidad = strip_tags($venta[$i]['cantidad'] + $venta[$i]['cantidad2']);
                    $stockcajas = $row['stockcajas'] - $cantidad;
                    $stmt->execute();

                    $updateVentas = " update ventas set "
                        . " ganancia = '" . ($totalGanancia) . "' where "
                        . " codventa = '" . $codventa . "' and codsucursal = '" . $_POST["codsucursal"] . "';
        			";

                    $stmt = $this->dbh->prepare($updateVentas);
                    $stmt->execute();
                }
                ################## PARA ACTUALIZAR EL STOCK DEL ALMACEN DEPENDIENDO DEL TIPO DE VENTA ################

                /*
                    $sql = " update productos set "
                        ." stocktotal = ? "
                        ." where "
                        ." codproducto = '".$venta[$i]['txtCodigo']."' and codsucursal = '".$_POST["codsucursal"]."';
                        ";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $stocktotal);
                    $cantidad = strip_tags($venta[$i]['cantidad']+$venta[$i]['cantidad2']);
                    $stocktotal = $row['stocktotal'] - $cantidad;
                    $stmt->execute();
                    */

                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                $query = " insert into kardexproductos
				values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codventa);
                $stmt->bindParam(2, $codcliente);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);
                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);
                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);
                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);
                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);


                $codventa = strip_tags($nroventa);
                $codcliente = strip_tags($_POST["cliente"]);
                $codsucursalm = strip_tags($_POST["codsucursal"]);
                $codproductom = strip_tags($venta[$i]['txtCodigo']);
                $movimiento = strip_tags("SALIDAS");
                $entradacaja = strip_tags("0");
                $entradaunidad = strip_tags("0");
                $entradacajano = strip_tags("0");
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags($venta[$i]['cantidad']);
                $salidabonif = strip_tags($venta[$i]['cantidad2']);
                $devolucioncaja = strip_tags("0");
                $devolucionunidad = strip_tags("0");
                $devolucionbonif = strip_tags("0");
                $cantcaja = strip_tags("0");
                $stocktotalcaja = strip_tags("0");
                $cantidad = strip_tags($venta[$i]['cantidad'] + $venta[$i]['cantidad2']);
                $stocktotalunidad = $row['stocktotal'] - $cantidad;
                $preciocompram = strip_tags($venta[$i]["precio"]);
                $precioventacajam = strip_tags($venta[$i]["precio2"]);
                $precioventaunidadm = strip_tags($venta[$i]["precio3"]);
                $ivaproducto = strip_tags($venta[$i]['ivaproducto']);
                $descproducto = strip_tags($venta[$i]['descproducto'] + $venta[$i]['desclaboratorio']);
                $documento = strip_tags("VENTA - " . $_POST["tipopagove"] . " - TICKET: " . $codventa);
                $fechakardex = strip_tags($fecha);
                $precioventablisterdesc = strip_tags($venta[$i]['precioventablisterdesc']);
                $precioventacajadesc = strip_tags($venta[$i]['precioventacajadesc']);
                $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################
            }
            unset($_SESSION["CarritoV"]);


            #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
            if ($_POST["tipopagove"] == "CONTADO") {

                $sql = "select ingresos from arqueocaja where codcaja = '" . $_POST["codcaja"] . "' and statusarqueo = '1'";
                foreach ($this->dbh->query($sql) as $row) {
                    $this->p[] = $row;
                }
                $ingreso = $row['ingresos'];

                $registro = " update arqueocaja set "
                    . " ingresos = ? "
                    . " where "
                    . " codcaja = ? and statusarqueo = '1';";

                $stmt = $this->dbh->prepare($registro);
                $stmt->bindParam(1, $txtTotal);
                $stmt->bindParam(2, $codcaja);

                if (strip_tags(isset($_POST['codtarjeta']))) {
                    $intereses = strip_tags($_POST['codtarjeta']);
                } else {
                    $intereses = '0.00';
                }
                $TotalFactura = $_POST["txtTotal"] * $intereses / 100;
                $SubtotalMonto = number_format($_POST["txtTotal"] + $TotalFactura, 2);
                $txtTotal = number_format($SubtotalMonto + $ingreso, 2, '.', '');
                $codcaja = strip_tags($_POST["codcaja"]);
                $stmt->execute();
            }

            ############## REGISTRO DE ABONOS EN VENTAS SI SERIA EL CASO ##################
            if (strip_tags($_POST["tipopagove"] == "CREDITO" && $_POST["montoabono"] != "0.00")) {

                $query = " insert into abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codventa);
                $stmt->bindParam(2, $codcliente);
                $stmt->bindParam(3, $montoabono);
                $stmt->bindParam(4, $fechaabono);
                $stmt->bindParam(5, $codigo);
                $stmt->bindParam(6, $codcaja);

                $codventa = strip_tags($nroventa);
                $codcliente = strip_tags($_POST["cliente"]);
                $montoabono = strip_tags($_POST["montoabono"]);
                $fechaabono = strip_tags($fecha);
                $codigo = strip_tags($_SESSION["codigo"]);
                $codcaja = strip_tags($_POST["codcaja"]);
                $stmt->execute();
            }
            if ($_POST["tipodocumento"] == "TICKET") {

                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA VENTA FUE REALIZADA EXITOSAMENTE <a href='reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("TICKET") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Ticket' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR TICKET</strong></a></div>";

                echo "<script>window.open('reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("TICKET") . "', '_blank');</script>";
                exit;
            } else {

                echo "<div class='alert alert-success'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-check-square-o'></span> LA VENTA FUE REALIZADA EXITOSAMENTE <a href='reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("FACTURAVENTAS") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR FACTURA</strong></a></div>";

                echo "<script>window.open('reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("FACTURAVENTAS") . "', '_blank');</script>";
                exit;
            }
        }
    }
    ################################# FUNCION REGISTRAR VENTAS ###################################

    ################################# FUNCION BUSQUEDA DE VENTAS ##################################
    public function BusquedaVentas()
    {

        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {


            if ($_GET['tipobusqueda'] == "1") {

                $sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcliente = ? GROUP BY ventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET['codcliente']));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS PARA EL CLIENTE INGRESADO !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusqueda'] == "2") {

                $sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcaja = ? GROUP BY ventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET['codcaja']));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusqueda'] == "3") {

                //$sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = ? GROUP BY ventas.codventa";
                $sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ? GROUP BY ventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array(date("Y-m-d", strtotime($_GET['fecha'])), (date("Y-m-d", strtotime($_GET['fechah'])))));
                //$stmt->execute( array(date("Y-m-d",strtotime($_GET['fechah']))));

                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            }

        ################# AQUI BUSCAMOS POR CAJEROS Y DISTRIBUIDOR ################

        } else {


            if ($_GET['tipobusqueda'] == "1") {

                $sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcliente = ? AND ventas.codigo = '" . $_SESSION["codigo"] . "' GROUP BY ventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET['codcliente']));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS PARA EL CLIENTE INGRESADO !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusqueda'] == "2") {

                $sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcaja = ? AND ventas.codigo = '" . $_SESSION["codigo"] . "' GROUP BY ventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET['codcaja']));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusqueda'] == "3") {

                $sql = " SELECT ventas.tipodocumento, ventas.codventa, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.codcliente, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = ? AND ventas.codigo = '" . $_SESSION["codigo"] . "' GROUP BY ventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array(date("Y-m-d", strtotime($_GET['fecha']))));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            }
        }
    }
    ################################# FUNCION BUSQUEDA DE VENTAS ##################################

    ###################################### FUNCION ID VENTAS #######################################
    public function VentasPorId()
    {
        self::SetNames();
        $sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, 
            clientes.celcliente, clientes.direccliente, clientes.emailcliente, ventas.tipodocumento, ventas.codventa, 
            ventas.codserie, ventas.codautorizacion, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, 
            ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, 
            ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.tipopagove, ventas.formapagove, 
            ventas.montopagado, ventas.montodevuelto, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, 
            mediospagos.mediopago, usuarios.cedula, usuarios.nombres, usuarios.email, cajas.nrocaja, cajas.nombrecaja, 
            abonoscreditos.codventa as cod, abonoscreditos.fechaabono, sucursales.cedresponsable, sucursales.nomresponsable, 
            sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, 
            sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, 
            sucursales.llevacontabilidad, SUM(montoabono) AS abonototal,
            ventas.correo_to_send
        FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN mediospagos ON ventas.formapagove = mediospagos.codmediopago LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.codventa =? GROUP BY cod";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codventa"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ###################################### FUNCION ID VENTAS #######################################

    #################################### FUNCION VER DETALLES VENTAS ###################################
    public function VerDetallesVentas()
    {
        self::SetNames();
        $sql = " SELECT * FROM detalleventas INNER JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion INNER JOIN medidas ON detalleventas.codmedidav = medidas.codmedida LEFT JOIN productos ON detalleventas.codproductov = productos.codproducto LEFT JOIN laboratorios ON productos.codlaboratorio = laboratorios.codlaboratorio WHERE detalleventas.codventa = ? GROUP BY productos.codproducto, detalleventas.productov";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET["codventa"])));
        $stmt->execute();
        $num = $stmt->rowCount();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ################################### FUNCION VER DETALLES VENTAS ###################################
    public function ListarDetallesVentas()
    {
        self::SetNames();
        $sql = "SELECT detalleventas.coddetalleventa, detalleventas.codventa,
			detalleventas.codproductov, detalleventas.productov, detalleventas.principioactivov, detalleventas.descripcionv,detalleventas.preciocomprav,
			detalleventas.precioventacajav,
			detalleventas.precioventaunidadv,
			detalleventas.preciounitario,
			detalleventas.cantventa,
			detalleventas.cantbonificv,
			detalleventas.valortotalv,
			detalleventas.descproductov,
			detalleventas.descporc,
			detalleventas.descbonificv,
			detalleventas.valornetov,
			detalleventas.baseimponible, detalleventas.ivaproductov, detalleventas.fechadetalleventa,
			medidas.nommedida,
			presentaciones.nompresentacion,
			ventas.tipodocumento,
			ventas.codventa,
			ventas.codcaja,
			ventas.codcliente,
			ventas.codsucursal,
			ventas.tipopagove,
			ventas.ivave
			FROM (detalleventas LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion LEFT JOIN medidas ON detalleventas.codmedidav = medidas.codmedida";

        if ($_SESSION['acceso'] == "administradorG") {


            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            //$sql = " select * from cajas LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE usuarios.codsucursal = '".$_SESSION["codsucursal"]."'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }


    ################################# FUNCION BUSQUEDA DETALLES DE VENTAS ##################################
    public function BusquedaDetallesVentas()
    {

        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            if ($_GET['tipobusquedad'] == "1") {

                $sql = "SELECT
				detalleventas.coddetalleventa,
				detalleventas.codventa,
				detalleventas.codproductov,
				detalleventas.productov,
				detalleventas.principioactivov,
				detalleventas.descripcionv,
				detalleventas.preciocomprav,
				detalleventas.precioventacajav,
				detalleventas.precioventaunidadv,
				detalleventas.preciounitario,
				detalleventas.cantventa,
				detalleventas.cantbonificv,
				detalleventas.valortotalv,
				detalleventas.descproductov,
				detalleventas.descporc,
				detalleventas.descbonificv,
				detalleventas.valornetov,
				detalleventas.baseimponible,
				detalleventas.ivaproductov,
				detalleventas.fechadetalleventa,
				medidas.nommedida,
				presentaciones.nompresentacion,
				ventas.tipodocumento,
				ventas.codventa,
				ventas.codcaja,
				ventas.codcliente,
				ventas.codsucursal,
				ventas.tipopagove,
				ventas.ivave
				FROM (detalleventas LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion LEFT JOIN medidas ON detalleventas.codmedidav = medidas.codmedida WHERE detalleventas.codventa = ? ORDER BY detalleventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET["codventa"]));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS CON ESTE N&deg; DE FACTURA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusquedad'] == "2") {

                $sql = "SELECT
			detalleventas.coddetalleventa,
			detalleventas.codventa,
			detalleventas.codproductov,
			detalleventas.productov,
			detalleventas.principioactivov,
			detalleventas.descripcionv,
			detalleventas.preciocomprav,
			detalleventas.precioventacajav,
			detalleventas.precioventaunidadv,
			detalleventas.preciounitario,
			detalleventas.cantventa,
			detalleventas.cantbonificv,
			detalleventas.valortotalv,
			detalleventas.descproductov,
			detalleventas.descporc,
			detalleventas.descbonificv,
			detalleventas.valornetov,
			detalleventas.baseimponible,
			detalleventas.ivaproductov,
			detalleventas.fechadetalleventa,
			medidas.nommedida,
			presentaciones.nompresentacion,
			ventas.tipodocumento,
			ventas.codventa,
			ventas.codcaja,
			ventas.codcliente,
			ventas.codsucursal,
			ventas.tipopagove,
			ventas.ivave,
			cajas.nrocaja,
			cajas.nombrecaja
			FROM (detalleventas LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion LEFT JOIN medidas ON detalleventas.codmedidav = medidas.codmedida WHERE ventas.codcaja = ? ORDER BY detalleventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET['codcaja']));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusquedad'] == "3") {

                $sql = "SELECT
			detalleventas.coddetalleventa,
			detalleventas.codventa,
			detalleventas.codproductov,
			detalleventas.productov,
			detalleventas.principioactivov,
			detalleventas.descripcionv,
			detalleventas.preciocomprav,
			detalleventas.precioventacajav,
			detalleventas.precioventaunidadv,
			detalleventas.preciounitario,
			detalleventas.cantventa,
			detalleventas.cantbonificv,
			detalleventas.valortotalv,
			detalleventas.descproductov,
			detalleventas.descporc,
			detalleventas.descbonificv,
			detalleventas.valornetov,
			detalleventas.baseimponible,
			detalleventas.ivaproductov,
			detalleventas.fechadetalleventa,
			medidas.nommedida,
			presentaciones.nompresentacion,
			ventas.tipodocumento,
			ventas.codventa,
			ventas.codcaja,
			ventas.codcliente,
			ventas.codsucursal,
			ventas.tipopagove,
			ventas.ivave
			FROM (detalleventas LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion LEFT JOIN medidas ON detalleventas.codmedidav = medidas.codmedida WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ? ORDER BY detalleventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array(date("Y-m-d", strtotime($_GET['fecha'])), date("Y-m-d", strtotime($_GET['fechah']))));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            }

        ################# AQUI BUSCAMOS POR CAJEROS Y DISTRIBUIDOR ################

        } else {


            if ($_GET['tipobusquedad'] == "1") {

                $sql = "SELECT
detalleventas.coddetalleventa,
detalleventas.codventa,
detalleventas.codproductov,
detalleventas.productov,
detalleventas.principioactivov,
detalleventas.descripcionv,
detalleventas.preciocomprav,
detalleventas.precioventacajav,
detalleventas.precioventaunidadv,
detalleventas.preciounitario,
detalleventas.cantventa,
detalleventas.cantbonificv,
detalleventas.valortotalv,
detalleventas.descproductov,
detalleventas.descporc,
detalleventas.descbonificv,
detalleventas.valornetov,
detalleventas.baseimponible,
detalleventas.ivaproductov,
detalleventas.fechadetalleventa,
medidas.nommedida,
presentaciones.nompresentacion,
ventas.tipodocumento,
ventas.codventa,
ventas.codcaja,
ventas.codcliente,
ventas.codsucursal,
ventas.tipopagove,
ventas.ivave
FROM (detalleventas LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion LEFT JOIN medidas ON detalleventas.codmedidav = medidas.codmedidaWHERE detalleventas.codventa = ? AND ventas.codigo = '" . $_SESSION["codigo"] . "' ORDER BY detalleventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET["codventa"]));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS CON ESTE N&deg; DE FACTURA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusquedad'] == "2") {

                $sql = "SELECT
detalleventas.coddetalleventa,
detalleventas.codventa,
detalleventas.codproductov,
detalleventas.productov,
detalleventas.principioactivov,
detalleventas.descripcionv,
detalleventas.preciocomprav,
detalleventas.precioventacajav,
detalleventas.precioventaunidadv,
detalleventas.preciounitario,
detalleventas.cantventa,
detalleventas.cantbonificv,
detalleventas.valortotalv,
detalleventas.descproductov,
detalleventas.descporc,
detalleventas.descbonificv,
detalleventas.valornetov,
detalleventas.baseimponible,
detalleventas.ivaproductov,
detalleventas.fechadetalleventa,
medidas.nommedida,
presentaciones.nompresentacion,
ventas.tipodocumento,
ventas.codventa,
ventas.codcaja,
ventas.codcliente,
ventas.codsucursal,
ventas.tipopagove,
ventas.ivave,
cajas.nrocaja,
cajas.nombrecaja
FROM (detalleventas LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion LEFT JOIN medidas ON detalleventas.codmedidav = medidas.codmedida WHERE ventas.codcaja = ? AND ventas.codigo = '" . $_SESSION["codigo"] . "' ORDER BY detalleventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array($_GET['codcaja']));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            } elseif ($_GET['tipobusquedad'] == "3") {

                $sql = "SELECT
detalleventas.coddetalleventa,
detalleventas.codventa,
detalleventas.codproductov,
detalleventas.productov,
detalleventas.principioactivov,
detalleventas.descripcionv,
detalleventas.preciocomprav,
detalleventas.precioventacajav,
detalleventas.precioventaunidadv,
detalleventas.preciounitario,
detalleventas.cantventa,
detalleventas.cantbonificv,
detalleventas.valortotalv,
detalleventas.descproductov,
detalleventas.descporc,
detalleventas.descbonificv,
detalleventas.valornetov,
detalleventas.baseimponible,
detalleventas.ivaproductov,
detalleventas.fechadetalleventa,
medidas.nommedida,
presentaciones.nompresentacion,
ventas.tipodocumento,
ventas.codventa,
ventas.codcaja,
ventas.codcliente,
ventas.codsucursal,
ventas.tipopagove,
ventas.ivave
FROM (detalleventas LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion LEFT JOIN medidas ON detalleventas.codmedidav = medidas.codmedida WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = ? AND ventas.codigo = '" . $_SESSION["codigo"] . "' ORDER BY detalleventas.codventa";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute(array(date("Y-m-d", strtotime($_GET['fecha']))));
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num == 0) {

                    echo "<center><div class='alert alert-danger'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
                    exit;
                } else {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->p[] = $row;
                    }
                    return $this->p;
                    $this->dbh = null;
                }
            }
        }
    }
    ################################# FUNCION BUSQUEDA DETALLES DE VENTAS ##################################

    ################################### FUNCION ID DETALLE VENTAS ###################################
    public function DetallesVentasPorId()
    {
        self::SetNames();
        $sql = " SELECT * FROM detalleventas INNER JOIN presentaciones ON detalleventas.codpresentacionv = presentaciones.codpresentacion INNER JOIN medidas ON detalleventas.codmedidav = medidas.codmedida LEFT JOIN ventas ON detalleventas.codventa = ventas.codventa LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente WHERE detalleventas.coddetalleventa = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["coddetalleventa"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################### FUNCION ID DETALLE VENTAS ###################################

    ################################ FUNCION ACTUALIZAR DETALLE VENTAS ################################
    public function ActualizarDetallesVentas()
    {
        self::SetNames();
        if (empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantventa"])) {
            echo "1";
            exit;
        }

        $sql = "select stocktotal from productos where codproducto = '" . $_POST["codproducto"] . "'";
        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        $stocktotaldb = $row['stocktotal'];

        $sql2 = " select * from detalleventas where coddetalleventa = ? and codventa = ? ";
        $stmt = $this->dbh->prepare($sql2);
        $stmt->execute(array($_POST["coddetalleventa"], $_POST["codigoventa"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pa[] = $row;
        }
        $cantidadventadb = $pa[0]["cantventa"];

        $sql = " update detalleventas set "
            . " cantventa = ?, "
            . " cantbonificv = ?, "
            . " valortotalv = ?, "
            . " descproductov = ?, "
            . " descporc = ?, "
            . " descbonificv = ?, "
            . " valornetov = ?, "
            . " baseimponible = ? "
            . " where "
            . " coddetalleventa = ?;
			   ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $cantventa);
        $stmt->bindParam(2, $cantbonificv);
        $stmt->bindParam(3, $valortotalv);
        $stmt->bindParam(4, $descproductov);
        $stmt->bindParam(5, $descporc);
        $stmt->bindParam(6, $descbonificv);
        $stmt->bindParam(7, $valornetov);
        $stmt->bindParam(8, $baseimponible);
        $stmt->bindParam(9, $coddetalleventa);

        $codproducto = strip_tags($_POST["codproducto"]);
        $ivaproducto = strip_tags($_POST["ivaproductov"]);
        $descproducto = strip_tags($_POST["descproductov"]);
        $cantventa = strip_tags($_POST["cantventa"]);
        $cantbonificv = strip_tags($_POST["cantbonificv"]);
        $valortotalv = strip_tags($_POST["valortotalv"]);
        $descproductov = strip_tags($_POST["descproductov"]);
        $descporc = strip_tags($_POST["descporc"]);
        $descbonificv = strip_tags($_POST["descbonificv"]);
        $valornetov = strip_tags($_POST["valornetov"]);
        $baseimponible = strip_tags($_POST["baseimponible"]);
        $coddetalleventa = strip_tags($_POST["coddetalleventa"]);
        $stmt->execute();

        ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
        $sql = " update productos set "
            . " stocktotal = ? "
            . " where "
            . " codproducto = ? and codsucursal = ?;
			   ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $stocktotal);
        $stmt->bindParam(2, $codproducto);
        $stmt->bindParam(3, $codsucursal);

        ######### AQUI HACEMOS CALCULOS ############
        $cantidad = strip_tags($_POST["cantventa"]);
        $cantidadventadb = strip_tags($_POST["cantidadventadb"]);
        $cantidad2 = strip_tags($_POST["cantbonificv"]);
        $cantidadbonifdb = strip_tags($_POST["cantidadbonifventadb"]);

        $calexistencia = $cantidad - $cantidadventadb;
        $calbonific = $cantidad2 - $cantidadbonifdb;
        $calculostock = $calexistencia + $calbonific;
        $stocktotal = $stocktotaldb - $calculostock;
        ######### AQUI HACEMOS CALCULOS ############

        $codproducto = strip_tags($_POST["codproducto"]);
        $codsucursal = strip_tags($_POST["codsucursal"]);
        $stmt->execute();


        ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################
        $sql2 = " update kardexproductos set "
            . " salidaunidad = ?, "
            . " salidabonif = ?, "
            . " stocktotalunidad = ? "
            . " where "
            . " codproceso = ? and codproductom = ?;
			   ";
        $stmt = $this->dbh->prepare($sql2);
        $stmt->bindParam(1, $salidaunidad);
        $stmt->bindParam(2, $salidabonif);
        $stmt->bindParam(3, $stocktotal);
        $stmt->bindParam(4, $codventa);
        $stmt->bindParam(5, $codproducto);

        $salidaunidad = strip_tags($_POST["cantventa"]);
        $salidabonif = strip_tags($_POST["cantbonificv"]);

        ######### AQUI HACEMOS CALCULOS ############
        $cantidad = strip_tags($_POST["cantventa"]);
        $cantidadventadb = strip_tags($_POST["cantidadventadb"]);
        $cantidad2 = strip_tags($_POST["cantbonificv"]);
        $cantidadbonifdb = strip_tags($_POST["cantidadbonifventadb"]);

        $calexistencia = $cantidad - $cantidadventadb;
        $calbonific = $cantidad2 - $cantidadbonifdb;
        $calculostock = $calexistencia + $calbonific;
        $stocktotal = $stocktotaldb - $calculostock;
        ######### AQUI HACEMOS CALCULOS ############

        $codventa = strip_tags($_POST["codigoventa"]);
        $codproducto = strip_tags($_POST["codproducto"]);
        $stmt->execute();


        $sql4 = "select codcaja, tipodocumento, ivave, intereses, totalpago, tipopagove from ventas where codventa = ? ";
        $stmt = $this->dbh->prepare($sql4);
        $stmt->execute(array($_POST["codigoventa"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $paea[] = $row;
        }
        $iva = $paea[0]["ivave"] / 100;
        $intereses = ($paea[0]["intereses"] == "" ? "0.00" : $paea[0]["intereses"]);
        $totalpago = $paea[0]["totalpago"];
        $tipopagove = $paea[0]["tipopagove"];
        $codcaja = $paea[0]["codcaja"];
        $tipodocumento = $paea[0]["tipodocumento"];
        $ivg2 = 1 + $paea[0]["ivave"] / 100;

        $sql3 = "select sum(descporc) as descuento, sum(descbonificv) as bonificacion, sum(valortotalv) as total, sum(valornetov) as neto, sum(baseimponible) as base from detalleventas where codventa = ? and ivaproductov = 'SI'";
        $stmt = $this->dbh->prepare($sql3);
        $stmt->execute(array($_POST["codigoventa"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch()) {
            $p[] = $row;
        }
        $descuentosi = ($p[0]["descuento"] == "" ? "0.00" : $p[0]["descuento"]);
        $bonificacionsi = ($p[0]["bonificacion"] == "" ? "0.00" : $p[0]["bonificacion"]);
        $valortotalsi = ($p[0]["total"] == "" ? "0.00" : $p[0]["total"]);
        $valornetosi = ($p[0]["neto"] == "" ? "0.00" : $p[0]["neto"]);
        $baseimponiblesi = ($p[0]["base"] == "" ? "0.00" : $p[0]["base"]);

        $sql5 = "select sum(descporc) as descuento, sum(descbonificv) as bonificacion, sum(valortotalv) as total, sum(valornetov) as neto, sum(baseimponible) as base from detalleventas where codventa = ? and ivaproductov = 'NO'";
        $stmt = $this->dbh->prepare($sql5);
        $stmt->execute(array($_POST["codigoventa"]));
        $num = $stmt->rowCount();

        if ($row = $stmt->fetch()) {
            $p[] = $row;
        }
        $descuentono = ($row["descuento"] == "" ? "0.00" : $row["descuento"]);
        $bonificacionno = ($row["bonificacion"] == "" ? "0.00" : $row["bonificacion"]);
        $valortotalno = ($row["total"] == "" ? "0.00" : $row["total"]);
        $valornetono = ($row["neto"] == "" ? "0.00" : $row["neto"]);
        $baseimponibleno = ($row["base"] == "" ? "0.00" : $row["base"]);

        $sql = " update ventas set "
            . " descuentove = ?, "
            . " descbonificve = ?, "
            . " subtotalve = ?, "
            . " totalsinimpuestosve = ?, "
            . " tarifanove = ?, "
            . " tarifasive = ?, "
            . " totalivave = ?, "
            . " totalpago= ? "
            . " where "
            . " codventa = ?;
			   ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $descuentove);
        $stmt->bindParam(2, $descbonificve);
        $stmt->bindParam(3, $subtotalve);
        $stmt->bindParam(4, $totalsinimpuestosve);
        $stmt->bindParam(5, $tarifanove);
        $stmt->bindParam(6, $tarifasive);
        $stmt->bindParam(7, $totalivave);
        $stmt->bindParam(8, $total);
        $stmt->bindParam(9, $codventa);

        $descuentove = number_format($descuentosi + $descuentono, 2);
        $descbonificve = number_format($bonificacionsi + $bonificacionno, 2);
        $subtotalve = number_format($baseimponiblesi + $baseimponibleno + $descuentove, 2);
        $totalsinimpuestosve = number_format($valornetosi + $valornetono, 2);

        $tarifanove = number_format($valornetono, 2);
        $tarifasive = number_format($baseimponiblesi, 2);
        $totalivave = number_format($tarifasive * $iva, 2);

        $total = number_format($subtotalve - $descuentove - $descbonificve + $totalivave, 2);
        $codventa = strip_tags($_POST["codigoventa"]);
        $stmt->execute();

        #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
        if ($tipopagove == "CONTADO") {

            $sql = "select ingresos from arqueocaja where codcaja = '" . $codcaja . "' and statusarqueo = '1'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            if (isset($row['ingresos'])) {
                $ingreso = $row['ingresos'];
            } else {
                $ingreso = '0.00';
            }
            //$ingreso = $row['ingresos'];

            $sql = " update arqueocaja set "
                . " ingresos = ? "
                . " where "
                . " codcaja = '" . $codcaja . "' and statusarqueo = '1';
		";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $txtTotal);

            $monto = number_format($totalpago - $total, 2);
            $TotalFactura = $monto * $intereses / 100;
            $SubtotalMonto = number_format($monto + $TotalFactura, 2);
            $txtTotal = number_format($ingreso - $SubtotalMonto, 2, '.', '');
            $stmt->execute();
        }
        #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################

        if ($tipodocumento == "TICKET") {


            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE VENTA FUE ACTUALIZADO EXITOSAMENTE <a href='reportepdf.php?codventa=" . base64_encode($_POST["codigoventa"]) . "&tipo=" . base64_encode("TICKET") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR TICKET</strong></a></div>";

            echo "<script>window.open('reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("TICKET") . "', '_blank');</script>";

            echo "<script>window.open('reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("GUIAREMISION") . "', '_blank');</script>";
            exit;
        } else {

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE VENTA FUE ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codventa=" . base64_encode($_POST["codigoventa"]) . "&tipo=" . base64_encode("FACTURAVENTAS") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR FACTURA</strong></a></div>";
            echo "<script>window.open('reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("FACTURAVENTAS") . "', '_blank');</script>";

            echo "<script>window.open('reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("GUIAREMISION") . "', '_blank');</script>";
            exit;
        }
    }
    ################################ FUNCION ACTUALIZAR DETALLE VENTAS ###############################

    ################################## FUNCION ELIMINAR DETALLES VENTAS ##############################
    public function EliminarDetallesVentas()
    {
        if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

            self::SetNames();
            $sql = " select * from detalleventas where codventa = ? ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute(array(strip_tags($_GET["codventa"])));
            $num = $stmt->rowCount();
            if ($num > 1) {

                $sql2 = "select stocktotal from productos where codproducto = ? and codsucursal = ?";
                $stmt = $this->dbh->prepare($sql2);
                $stmt->execute(array(base64_decode($_GET["codproductov"]), base64_decode($_GET["codsucursal"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $p[] = $row;
                }
                $stocktotaldb = $row['stocktotal'];

                ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ######################
                $sql = " update productos set "
                    . " stocktotal = ? "
                    . " where "
                    . " codproducto = ? and codsucursal = ?;
			   ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $stocktotal);
                $stmt->bindParam(2, $codproducto);
                $stmt->bindParam(3, $codsucursal);
                $cantventa = strip_tags(base64_decode($_GET["cantventa"]));
                $cantbonif = strip_tags(base64_decode($_GET["cantbonificv"]));
                $codproducto = strip_tags(base64_decode($_GET["codproductov"]));
                $codsucursal = strip_tags(base64_decode($_GET["codsucursal"]));
                $resto = $cantventa + $cantbonif;
                $stocktotal = $stocktotaldb + $resto;
                $stmt->execute();

                $sql = " delete from detalleventas where coddetalleventa = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $coddetalleventa);
                $coddetalleventa = base64_decode($_GET["coddetalleventa"]);
                $stmt->execute();


                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codventa);
                $stmt->bindParam(2, $codcliente);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);
                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);
                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);
                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);
                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);

                $codventa = strip_tags(base64_decode($_GET["codventa"]));
                $codcliente = strip_tags(base64_decode($_GET["codcliente"]));
                $codsucursalm = strip_tags(base64_decode($_GET["codsucursal"]));
                $codproductom = strip_tags(base64_decode($_GET["codproductov"]));
                $movimiento = strip_tags("DEVOLUCION");
                $entradacaja = strip_tags("0");
                $entradaunidad = strip_tags("0");
                $entradacajano = strip_tags("0");
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags("0");
                $salidabonif = strip_tags("0");
                $devolucioncaja = strip_tags("0");
                $devolucionunidad = strip_tags(base64_decode($_GET["cantventa"]));
                $devolucionbonif = strip_tags(base64_decode($_GET["cantbonificv"]));
                $canttotal = strip_tags($devolucionunidad + $devolucionbonif);
                $stocktotalcaja = strip_tags("0");
                $stocktotalunidad = $canttotal + $stocktotaldb;
                $preciocompram = strip_tags(base64_decode($_GET['preciocomprav']));
                $precioventacajam = strip_tags(base64_decode($_GET['precioventacajav']));
                $precioventaunidadm = strip_tags(base64_decode($_GET['precioventaunidadv']));
                $ivaproducto = strip_tags(base64_decode($_GET['ivaproductov']));
                $descproducto = strip_tags(base64_decode($_GET['descproductov']));
                $documento = strip_tags("DEVOLUCION VENTA - " . $_GET["codventa"]);
                $fechakardex = strip_tags(date("Y-m-d"));
                $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

                $sql4 = "select ivave, totalivave, intereses, totalpago from ventas where codventa = ? ";
                $stmt = $this->dbh->prepare($sql4);
                $stmt->execute(array(strip_tags($_GET["codventa"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $paea[] = $row;
                }
                $iva = $paea[0]["ivave"] / 100;
                $totaliva = $paea[0]["totalivave"];
                $intereses = ($paea[0]["intereses"] == "" ? "0.00" : $paea[0]["intereses"]);
                $pagodb = $paea[0]["totalpago"];

                $ivg2 = 1 + $iva / 100;

                $sql5 = "select sum(descporc) as descuento, sum(descbonificv) as bonificacion, sum(valortotalv) as total, sum(valornetov) as neto, sum(baseimponible) as base from detalleventas where codventa = ?";
                $stmt = $this->dbh->prepare($sql5);
                $stmt->execute(array(strip_tags($_GET["codventa"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch()) {
                    $p[] = $row;
                }
                $descuento = ($row["descuento"] == "" ? "0.00" : $row["descuento"]);
                $bonificacion = ($row["bonificacion"] == "" ? "0.00" : $row["bonificacion"]);
                $valortotal = ($row["total"] == "" ? "0.00" : $row["total"]);
                $valorneto = ($row["neto"] == "" ? "0.00" : $row["neto"]);
                $baseimponible = ($row["base"] == "" ? "0.00" : $row["base"]);

                if (base64_decode($_GET["ivaproductov"]) == "SI") {

                    $sql3 = "select sum(valornetov) as valorneto, sum(baseimponible) as baseiva from detalleventas where codventa = ? and ivaproductov = 'SI'";
                    $stmt = $this->dbh->prepare($sql3);
                    $stmt->execute(array(strip_tags($_GET["codventa"])));
                    $num = $stmt->rowCount();

                    if ($roww = $stmt->fetch()) {
                        $p[] = $roww;
                    }
                    $neto = ($roww["valorneto"] == "" ? "0" : $roww["valorneto"]);
                    $base = ($roww["baseiva"] == "" ? "0" : $roww["baseiva"]);

                    $sql = " update ventas set "
                        . " descuentove = ?, "
                        . " descbonificve = ?, "
                        . " subtotalve = ?, "
                        . " totalsinimpuestosve = ?, "
                        . " tarifasive = ?, "
                        . " totalivave = ?, "
                        . " totalpago= ? "
                        . " where "
                        . " codventa = ?;
			   		";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $descuentove);
                    $stmt->bindParam(2, $descbonificve);
                    $stmt->bindParam(3, $subtotalve);
                    $stmt->bindParam(4, $totalsinimpuestosve);
                    $stmt->bindParam(5, $tarifasive);
                    $stmt->bindParam(6, $totalivave);
                    $stmt->bindParam(7, $totalpago);
                    $stmt->bindParam(8, $codventa);

                    $descuentove = number_format($descuento, 2);
                    $descbonificve = number_format($bonificacion, 2);
                    $subtotalve = number_format($baseimponible + $descuentove, 2);
                    $totalsinimpuestosve = number_format($valorneto, 2);
                    $tarifasive = number_format($base, 2);
                    $totalivave = number_format($tarifasive * $iva, 2);
                    $totalpago = number_format($subtotalve - $descuentove - $descbonificve + $totalivave, 2);
                    $codventa = strip_tags(strip_tags($_GET["codventa"]));
                    $stmt->execute();

                    #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
                    if (base64_decode($_GET["tipopagove"]) == "CONTADO") {

                        $sql = "select ingresos from arqueocaja where codcaja = '" . strip_tags($_GET["codcaja"]) . "' and statusarqueo = '1'";
                        foreach ($this->dbh->query($sql) as $row) {
                            $this->p[] = $row;
                        }
                        $ingreso = $row['ingresos'];

                        $sql = " update arqueocaja set "
                            . " ingresos = ? "
                            . " where "
                            . " codcaja = ? and statusarqueo = '1';
						";
                        $stmt = $this->dbh->prepare($sql);
                        $stmt->bindParam(1, $txtTotal);
                        $stmt->bindParam(2, $codcaja);

                        $calculo = number_format($pagodb - $totalpago, 2);
                        $TotalFactura = $calculo * $intereses / 100;
                        $SubtotalMonto = number_format($calculo + $TotalFactura, 2);
                        $txtTotal = number_format($ingreso - $SubtotalMonto, 2, '.', '');
                        $codcaja = strip_tags(strip_tags($_GET["codcaja"]));
                        $stmt->execute();
                    }
                } else {

                    $sql3 = "select sum(valornetov) as valorneto, sum(baseimponible) as baseiva from detalleventas where codventa = ? and ivaproductov = 'NO'";
                    $stmt = $this->dbh->prepare($sql3);
                    $stmt->execute(array(strip_tags($_GET["codventa"])));
                    $num = $stmt->rowCount();

                    if ($roww = $stmt->fetch()) {
                        $p[] = $roww;
                    }
                    $neto = ($roww["valorneto"] == "" ? "0" : $roww["valorneto"]);
                    $base = ($roww["baseiva"] == "" ? "0" : $roww["baseiva"]);

                    $sql = " update ventas set "
                        . " descuentove = ?, "
                        . " descbonificve = ?, "
                        . " subtotalve = ?, "
                        . " totalsinimpuestosve = ?, "
                        . " tarifanove = ?, "
                        . " totalpago= ? "
                        . " where "
                        . " codventa = ?;
			   ";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $descuentove);
                    $stmt->bindParam(2, $descbonificve);
                    $stmt->bindParam(3, $subtotalve);
                    $stmt->bindParam(4, $totalsinimpuestosve);
                    $stmt->bindParam(5, $tarifanove);
                    $stmt->bindParam(6, $totalpago);
                    $stmt->bindParam(7, $codventa);

                    $descuentove = number_format($descuento, 2);
                    $descbonificve = number_format($bonificacion, 2);
                    $subtotalve = number_format($baseimponible + $descuentove, 2);
                    $totalsinimpuestosve = number_format($valorneto, 2);
                    $tarifanove = number_format($neto, 2);
                    $totalpago = number_format($subtotalve - $descuentove - $descbonificve + $totaliva, 2);
                    $codventa = strip_tags($_GET["codventa"]);
                    $stmt->execute();


                    #################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
                    if (base64_decode($_GET["tipopagove"]) == "CONTADO") {

                        $sql = "select ingresos from arqueocaja where codcaja = '" . strip_tags($_GET["codcaja"]) . "' and statusarqueo = '1'";
                        foreach ($this->dbh->query($sql) as $row) {
                            $this->p[] = $row;
                        }
                        $ingreso = $row['ingresos'];

                        $sql = " update arqueocaja set "
                            . " ingresos = ? "
                            . " where "
                            . " codcaja = ? and statusarqueo = '1';
		";
                        $stmt = $this->dbh->prepare($sql);
                        $stmt->bindParam(1, $txtTotal);
                        $stmt->bindParam(2, $codcaja);

                        $calculo = number_format($pagodb - $totalpago, 2);
                        $TotalFactura = $calculo * $intereses / 100;
                        $SubtotalMonto = number_format($calculo + $TotalFactura, 2);
                        $txtTotal = number_format($ingreso - $SubtotalMonto, 2, '.', '');
                        $codcaja = strip_tags($_GET["codcaja"]);
                        $stmt->execute();
                    }
                }

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-check-square-o'></span> EL DETALLE DE VENTA DE PRODUCTO FUE ELIMINADO EXITOSAMENTE </center>";
                echo "</div>";
                exit;
            } else {

                $sql2 = "select stocktotal from productos where codproducto = ? and codsucursal = ?";
                $stmt = $this->dbh->prepare($sql2);
                $stmt->execute(array(base64_decode($_GET["codproductov"]), base64_decode($_GET["codsucursal"])));
                $num = $stmt->rowCount();

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $p[] = $row;
                }
                $stocktotaldb = $row['stocktotal'];

                ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ######################
                $sql = " update productos set "
                    . " stocktotal = ? "
                    . " where "
                    . " codproducto = ? and codsucursal = ?;
			   ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $stocktotal);
                $stmt->bindParam(2, $codproducto);
                $stmt->bindParam(3, $codsucursal);
                $cantventa = strip_tags(base64_decode($_GET["cantventa"]));
                $cantbonif = strip_tags(base64_decode($_GET["cantbonificv"]));
                $codproducto = strip_tags(base64_decode($_GET["codproductov"]));
                $codsucursal = strip_tags(base64_decode($_GET["codsucursal"]));
                $resto = $cantventa + $cantbonif;
                $stocktotal = $stocktotaldb + $resto;
                $stmt->execute();

                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
                $query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
                $stmt = $this->dbh->prepare($query);
                $stmt->bindParam(1, $codventa);
                $stmt->bindParam(2, $codcliente);
                $stmt->bindParam(3, $codsucursalm);
                $stmt->bindParam(4, $codproductom);
                $stmt->bindParam(5, $movimiento);
                $stmt->bindParam(6, $entradacaja);
                $stmt->bindParam(7, $entradaunidad);
                $stmt->bindParam(8, $entradacajano);
                $stmt->bindParam(9, $entradabonif);
                $stmt->bindParam(10, $salidacajas);
                $stmt->bindParam(11, $salidaunidad);
                $stmt->bindParam(12, $salidabonif);
                $stmt->bindParam(13, $devolucioncaja);
                $stmt->bindParam(14, $devolucionunidad);
                $stmt->bindParam(15, $devolucionbonif);
                $stmt->bindParam(16, $stocktotalcaja);
                $stmt->bindParam(17, $stocktotalunidad);
                $stmt->bindParam(18, $preciocompram);
                $stmt->bindParam(19, $precioventacajam);
                $stmt->bindParam(20, $precioventaunidadm);
                $stmt->bindParam(21, $ivaproducto);
                $stmt->bindParam(22, $descproducto);
                $stmt->bindParam(23, $documento);
                $stmt->bindParam(24, $fechakardex);

                $codventa = strip_tags($_GET["codventa"]);
                $codcliente = strip_tags(base64_decode($_GET["codcliente"]));
                $codsucursalm = strip_tags(base64_decode($_GET["codsucursal"]));
                $codproductom = strip_tags(base64_decode($_GET["codproductov"]));
                $movimiento = strip_tags("DEVOLUCION");
                $entradacaja = strip_tags("0");
                $entradaunidad = strip_tags("0");
                $entradacajano = strip_tags("0");
                $entradabonif = strip_tags("0");
                $salidacajas = strip_tags("0");
                $salidaunidad = strip_tags("0");
                $salidabonif = strip_tags("0");
                $devolucioncaja = strip_tags("0");
                $devolucionunidad = strip_tags(base64_decode($_GET["cantventa"]));
                $devolucionbonif = strip_tags(base64_decode($_GET["cantbonificv"]));
                $canttotal = strip_tags($devolucionunidad + $devolucionbonif);
                $stocktotalcaja = strip_tags("0");
                $stocktotalunidad = $canttotal + $stocktotaldb;
                $preciocompram = strip_tags(base64_decode($_GET['preciocomprav']));
                $precioventacajam = strip_tags(base64_decode($_GET['precioventacajav']));
                $precioventaunidadm = strip_tags(base64_decode($_GET['precioventaunidadv']));
                $ivaproducto = strip_tags(base64_decode($_GET['ivaproductov']));
                $descproducto = strip_tags(base64_decode($_GET['descproductov']));
                $documento = strip_tags("DEVOLUCION VENTA - " . $_GET["codventa"]);
                $fechakardex = strip_tags(date("Y-m-d"));
                $stmt->execute();
                ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

                #################### AQUI RESTAMOS EL INGRESO A ARQUEO DE CAJA ####################
                if (base64_decode($_GET["tipopagove"]) == "CONTADO") {

                    $sql4 = "select * from ventas where codventa = ? ";
                    $stmt = $this->dbh->prepare($sql4);
                    $stmt->execute(array(strip_tags($_GET["codventa"])));
                    $num = $stmt->rowCount();

                    if ($roww = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $paea[] = $roww;
                    }
                    $totaldb = $roww["totalpago"];

                    $sql = "select ingresos from arqueocaja where codcaja = '" . strip_tags($_GET["codcaja"]) . "' and statusarqueo = '1'";
                    foreach ($this->dbh->query($sql) as $row) {
                        $this->p[] = $row;
                    }
                    $ingreso = ($row['ingresos'] == "" ? "0.00" : $row['ingresos']);

                    $sql = " update arqueocaja set "
                        . " ingresos = ? "
                        . " where "
                        . " codcaja = ? and statusarqueo = '1';";
                    $stmt = $this->dbh->prepare($sql);
                    $stmt->bindParam(1, $txtTotal);
                    $stmt->bindParam(2, $codcaja);

                    $TotalFactura = $totaldb * $intereses / 100;
                    $SubtotalMonto = number_format($totaldb + $TotalFactura, 2);
                    $txtTotal = number_format($ingreso - $SubtotalMonto, 2, '.', '');
                    $codcaja = strip_tags($_GET["codcaja"]);
                    $stmt->execute();
                }

                $sql = " delete from ventas where codventa = ?";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $codventa);
                $codventa = strip_tags($_GET["codventa"]);
                $stmt->execute();

                $sql = " delete from detalleventas where coddetalleventa = ? ";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $coddetalleventa);
                $coddetalleventa = base64_decode($_GET["coddetalleventa"]);
                $stmt->execute();

                echo "<div class='alert alert-info'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-check-square-o'></span> EL DETALLE DE VENTA DE PRODUCTO FUE ELIMINADO EXITOSAMENTE </center>";
                echo "</div>";
                exit;
            }
        } else {

            echo "<div class='alert alert-info'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-check-square-o'></span> USTED NO TIENE ACCESO PARA ELIMINAR DETALLES DE VENTAS, NO ERES EL ADMINISTRADOR DEL SISTEMA </center>";
            echo "</div>";
            exit;
        }
    }
    ################################## FUNCION ELIMINAR DETALLES VENTAS ###############################

    ############################ FUNCION BUSCAR VENTAS CAJAS Y FECHAS #################################
    public function BuscarVentasCajas()
    {
        self::SetNames();

        $sql = "SELECT ventas.codventa, ventas.tipodocumento, ventas.codcliente, cajas.nrocaja, cajas.nombrecaja, ventas.codcaja, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve,  ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, detalleventas.codventa, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, SUM(detalleventas.cantventa) as articulos, SUM(detalleventas.cantbonificv) as articulos2 FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE ventas.codsucursal = ? AND ventas.codcaja = ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codventa";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
        $stmt->bindValue(2, trim(base64_decode($_GET['codcaja'])));
        $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['desde']))));
        $stmt->bindValue(4, trim(date("Y-m-d", strtotime($_GET['hasta']))));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS PARA LA CAJA Y EL RANGO DE FECHAS SELECCIONADO</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################# FUNCION BUSCAR VENTAS CAJAS Y FECHAS ###############################

    /**
     * @author Khahory
     * @param $CODVENTA
     * @return float
     */
    public function BuscarGananciaTotal($CODVENTA)
    {
        self::SetNames();
        $sql = "SELECT * FROM detalleventas INNER JOIN presentaciones 
                ON detalleventas.codpresentacionv = presentaciones.codpresentacion INNER JOIN medidas 
                ON detalleventas.codmedidav = medidas.codmedida LEFT JOIN productos 
                ON detalleventas.codproductov = productos.codproducto LEFT JOIN laboratorios 
                ON productos.codlaboratorio = laboratorios.codlaboratorio 
            WHERE detalleventas.codventa = ? GROUP BY productos.codproducto, detalleventas.productov";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim($CODVENTA));
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = 0;

        // sacamos el total de ganancia
        foreach ($res as $key => $row) {
            // debemos saber que tipo de venta es: unidad, caja, blister
            // con esto tomamos el precio correspondiente
            $tipoventa = substr($row['productov'], -4, 3);

            switch ($tipoventa) {
                case 'dad':
                    $precio_venta_cliente = (float) $row['precioventaunidadv'];
                    $precio_compra_proveedor = (float) $row['preciocompraunidadv'];
                    break;
                case 'aja':
                    $precio_venta_cliente = (float) $row['precioventacajav'];
                    $precio_compra_proveedor = (float) $row['preciocomprav'];
                    break;
                case 'ter':
                    $precio_venta_cliente = (float) $row['precioventablisterv'];
                    $precio_compra_proveedor = (float) $row['preciocomprablisterv'];
                    break;
            }


            $cantventa = $row['cantventa'];
            $res[$key]['GANANCIA_PRODUCTO_VENTA'] = ($precio_venta_cliente - $precio_compra_proveedor) * $cantventa;
            $res[$key]['TIPO_VENTA_PRODUCTO'] = $tipoventa;
            $total += $res[$key]['GANANCIA_PRODUCTO_VENTA'];
        }
        return (float) $total;
    }

    ############################ FUNCION BUSCAR VENTAS FECHAS #################################
    public function BuscarVentasFechas()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") {

            $sql = "SELECT ventas.ganancia
	 as totalganancia, 
	ventas.codventa, ventas.tipodocumento, ventas.codcliente, cajas.nrocaja, cajas.nombrecaja, ventas.codcaja, ventas.descuentove, 
	ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve,  ventas.tarifanove, ventas.tarifasive, ventas.ivave, 
	ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, 
	ventas.fechaventa, clientes.nomcliente, detalleventas.codventa, sucursales.cedresponsable, sucursales.nomresponsable, 
	sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, 
	sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, SUM(detalleventas.cantventa) as articulos, 
	SUM(detalleventas.cantbonificv) as articulos2 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa) 
	LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal
		INNER JOIN productos on detalleventas.codproductov = productos.codproducto 
		LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja 
		LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente 
		WHERE ventas.codsucursal = ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
		GROUP BY detalleventas.codventa";


            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS PARA LAS FECHAS SELECCIONADAS</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // obtenemos de manera correcta las ganancias de cada venta
                    //$row['totalganancia'] = $this->BuscarGananciaTotal($row['codventa']);
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT  ventas.ganancia
 as totalganancia,
ventas.codventa, ventas.tipodocumento, ventas.codcliente, cajas.nrocaja, cajas.nombrecaja, ventas.codcaja, ventas.descuentove, 
ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve,  ventas.tarifanove, ventas.tarifasive, ventas.ivave, 
ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, 
ventas.fechaventa, clientes.nomcliente, detalleventas.codventa, sucursales.cedresponsable, sucursales.nomresponsable, 
sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, 
sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, SUM(detalleventas.cantventa) as articulos, 
SUM(detalleventas.cantbonificv) as articulos2 
FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa) 
LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal
INNER JOIN productos on detalleventas.codproductov = productos.codproducto 
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja 
LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente 
WHERE ventas.codsucursal = ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? AND ventas.codigo = '" . $_SESSION["codigo"] . "' GROUP BY detalleventas.codventa";




            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));

            $stmt->execute();
            //var_dump($stmt);
            // var_dump(base64_decode($_GET['codsucursal']));
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS PARA LAS FECHAS SELECCIONADAS</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // obtenemos de manera correcta las ganancias de cada venta
                    // $row['totalganancia'] = $this->BuscarGananciaTotal($row['codventa']);
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ############################# FUNCION BUSCAR VENTAS FECHAS ###############################

    ############################# FUNCION BUSCAR PRODUCTOS FACTURADOS ################################
    public function BuscarVentasProductos()
    {
        self::SetNames();
        $sql = "SELECT productos.codproducto, productos.producto, productos.codpresentacion,productos.codmedida, detalleventas.descproductov, detalleventas.precioventacajav, detalleventas.descproductov, detalleventas.precioventaunidadv, detalleventas.valornetov, productos.stocktotal, presentaciones.nompresentacion, medidas.nommedida, laboratorios.nomlaboratorio, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, SUM(detalleventas.cantventa) as articulos, SUM(detalleventas.cantbonificv) as articulos2 FROM (productos LEFT JOIN detalleventas ON productos.codproducto=detalleventas.codproductov) LEFT JOIN ventas ON detalleventas.codventa=ventas.codventa LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal LEFT JOIN laboratorios ON productos.codlaboratorio=laboratorios.codlaboratorio
LEFT JOIN presentaciones ON presentaciones.codpresentacion=productos.codpresentacion LEFT JOIN medidas ON medidas.codmedida=productos.codmedida WHERE ventas.codsucursal = ? AND DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codproductov, detalleventas.precioventaunidadv, detalleventas.descproductov ORDER BY productos.codproducto ASC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
        $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
        $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<center><div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL RANGO DE FECHAS SELECCIONADAS</div></center>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ################################# FUNCION PRODUCTOS FACTURADOS ###################################

    ############################# FUNCION BUSCAR ARQUEOS POR FECHAS ###############################
    public function BuscarArqueosFechas()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") {

            $sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE sucursales.codsucursal = ? AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') >= ? AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') <= ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN ARQUEOS PARA LAS FECHAS SELECCIONADAS</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE sucursales.codsucursal = ? AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') >= ? AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') <= ? AND usuarios.codigo = '" . $_SESSION["codigo"] . "'";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                echo "<center><div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<span class='fa fa-info-circle'></span> NO EXISTEN ARQUEOS PARA LAS FECHAS SELECCIONADAS</div></center>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ############################# FUNCION BUSCAR ARQUEOS POR FECHAS ###############################

    ############################# FUNCION BUSCAR MOVIMIENTOS POR FECHAS #############################
    public function BuscarMovimientosCajasFechas()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") {

            $sql = "SELECT * FROM movimientoscajas INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja LEFT JOIN usuarios ON movimientoscajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal LEFT JOIN mediospagos ON mediospagos.codmediopago = movimientoscajas.mediopagomovimientocaja WHERE sucursales.codsucursal = ? AND movimientoscajas.codcaja = ? AND DATE_FORMAT(movimientoscajas.fechamovimientocaja,'%Y-%m-%d') >= ? AND DATE_FORMAT(movimientoscajas.fechamovimientocaja,'%Y-%m-%d') <= ?";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(base64_decode($_GET['codcaja'])));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(4, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {

                echo "<div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS DE ESTA CAJA PARA LAS FECHAS SELECCIONADAS</center>";
                echo "</div>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        } else {

            $sql = "SELECT * FROM movimientoscajas INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja LEFT JOIN usuarios ON movimientoscajas.codigo = usuarios.codigo LEFT JOIN sucursales ON usuarios.codsucursal = sucursales.codsucursal WHERE sucursales.codsucursal = ? AND movimientoscajas.codcaja = ? AND DATE_FORMAT(movimientoscajas.fechamovimientocaja,'%Y-%m-%d') >= ? AND DATE_FORMAT(movimientoscajas.fechamovimientocaja,'%Y-%m-%d') <= ? AND movimientoscajas.codigo = '" . $_SESSION["codigo"] . "'";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
            $stmt->bindValue(2, trim(base64_decode($_GET['codcaja'])));
            $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['desde']))));
            $stmt->bindValue(4, trim(date("Y-m-d", strtotime($_GET['hasta']))));
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {

                echo "<div class='alert alert-danger'>";
                echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS DE ESTA CAJA PARA LAS FECHAS SELECCIONADAS</center>";
                echo "</div>";
                exit;
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $this->p[] = $row;
                }
                return $this->p;
                $this->dbh = null;
            }
        }
    }
    ############################# FUNCION BUSCAR MOVIMIENTOS POR FECHAS #############################

    ################################### FUNCION LISTAR VENTAS DIARIAS ################################
    public function ListarVentasDiarias()
    {
        self::SetNames();

        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "SELECT ventas.codventa, ventas.tipodocumento, ventas.codcliente, cajas.nrocaja, cajas.nombrecaja, ventas.codcaja, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve,  ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, detalleventas.codventa, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, SUM(detalleventas.cantventa) as articulos, SUM(detalleventas.cantbonificv) as articulos2 FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = '" . date('Y-m-d') . "' GROUP BY detalleventas.codventa";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } elseif ($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "bodega") {

            $sql = "SELECT ventas.codventa, ventas.tipodocumento, ventas.codcliente, cajas.nrocaja, cajas.nombrecaja, ventas.codcaja, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, detalleventas.codventa, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, SUM(detalleventas.cantventa) as articulos, SUM(detalleventas.cantbonificv) as articulos2 FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = '" . date('Y-m-d') . "' AND ventas.codsucursal = '" . $_SESSION["codsucursal"] . "' GROUP BY detalleventas.codventa";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } elseif ($_SESSION['acceso'] == "cajero") {

            $sql = "SELECT ventas.codventa, ventas.tipodocumento, ventas.codcliente, cajas.nrocaja, cajas.nombrecaja, ventas.codcaja, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve,  ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.intereses, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, detalleventas.codventa, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, SUM(detalleventas.cantventa) as articulos, SUM(detalleventas.cantbonificv) as articulos2 FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = '" . date('Y-m-d') . "' AND ventas.codsucursal = '" . $_SESSION["codsucursal"] . "' AND ventas.codigo = '" . $_SESSION["codigo"] . "' GROUP BY detalleventas.codventa";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################## FUNCION LISTAR VENTAS DIARIAS ###############################

    ############################# FIN DE CLASE VENTAS DE PRODUCTOS ##############################





























    ################################ CLASE ABONOS DE CREDITOS ####################################

    ######################## FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS ############################
    public function BuscarClientesAbonos()
    {
        self::SetNames();
        $sql = "SELECT
	ventas.codventa, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
	FROM
	(ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON
	clientes.codcliente=ventas.codcliente LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.codsucursal = ? AND ventas.codcliente = ? AND ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET['codsucursal']), $_GET["codcliente"]));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> EL CLIENTE INGRESADO NO TIENE CREDITOS EN VENTAS, VERIFIQUE NUEVAMENTE POR FAVOR</center>";
            echo "</div>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################### FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS ########################

    ######################## FUNCION PARA BUSQUEDA DE FORMULARIO PARA ABONOS #########################
    public function BuscaAbonosCreditos()
    {
        self::SetNames();
        $sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.codventa as codigo, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa WHERE clientes.cedcliente = ? AND ventas.codventa = ? AND ventas.tipopagove ='CREDITO'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['cedcliente'])));
        $stmt->bindValue(2, trim(base64_decode($_GET['codventa'])));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
            exit;
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ######################### FUNCION PARA BUSQUEDA DE FORMULARIO PARA ABONOS #######################

    ####################### FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS POR ID #######################
    public function AbonosCreditosId()
    {
        self::SetNames();
        $sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.codventa as codigo, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa WHERE abonoscreditos.codabono = ? AND clientes.cedcliente = ? AND ventas.codventa = ? AND ventas.tipopagove ='CREDITO'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['codabono'])));
        $stmt->bindValue(2, trim(base64_decode($_GET['cedcliente'])));
        $stmt->bindValue(3, trim(base64_decode($_GET['codventa'])));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
            exit;
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ####################### FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS POR ID ########################

    ########################## FUNCION PARA REGISTRAR ABONOS A CREDITOS #########################
    public function RegistrarAbonos()
    {
        self::SetNames();
        if (empty($_POST["codcliente"]) or empty($_POST["codventa"]) or empty($_POST["montoabono"])) {
            echo "1";
            exit;
        }

        if ($_POST["montoabono"] > $_POST["totaldebe"]) {
            echo "2";
            exit;
        } else {

            $query = " insert into abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(1, $codventa);
            $stmt->bindParam(2, $codcliente);
            $stmt->bindParam(3, $montoabono);
            $stmt->bindParam(4, $fechaabono);
            $stmt->bindParam(5, $codigo);
            $stmt->bindParam(6, $codcaja);

            $codventa = strip_tags($_POST["codventa"]);
            $codcliente = strip_tags($_POST["codcliente"]);
            $montoabono = strip_tags($_POST["montoabono"]);
            $fechaabono = strip_tags(date("Y-m-d h:i:s"));
            $codigo = strip_tags($_SESSION["codigo"]);
            $codcaja = strip_tags($_POST["codcaja"]);
            $stmt->execute();

            $sql = "select ingresos from arqueocaja where codcaja = '" . $_POST["codcaja"] . "' and statusarqueo = '1'";
            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            $ingreso = $row['ingresos'];

            $sql = " update arqueocaja set "
                . " ingresos = ? "
                . " where "
                . " codcaja = ? and statusarqueo = '1';
		";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(1, $txtTotal);
            $stmt->bindParam(2, $codcaja);

            $txtTotal = strip_tags($_POST["montoabono"] + $ingreso);
            $codcaja = strip_tags($_POST["codcaja"]);
            $stmt->execute();


            ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
            if ($_POST["montoabono"] == $_POST["totaldebe"]) {

                $sql = " update ventas set "
                    . " statusventa = ? "
                    . " where "
                    . " codventa = ?;
			";
                $stmt = $this->dbh->prepare($sql);
                $stmt->bindParam(1, $statusventa);
                $stmt->bindParam(2, $codventa);

                $codventa = strip_tags($_POST["codventa"]);
                $statusventa = strip_tags("PAGADA");
                $stmt->execute();
            }

            echo "<div class='alert alert-success'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL ABONO AL CR&Eacute;DITO DE FACTURA FUE REGISTRADO EXITOSAMENTE <a href='reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("TICKETCREDITOS") . "' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Ticket' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR TICKET</strong></a></div>";
            echo "<script>window.open('reportepdf?codventa=" . base64_encode($codventa) . "&tipo=" . base64_encode("TICKETCREDITOS") . "', '_blank');</script>";
            exit;
        }
    }
    ############################ FUNCION PARA REGISTRAR ABONOS A CREDITOS ########################

    ###################### FUNCION PARA LISTAR CREDITOS DE VENTAS DE PRODUCTOS #######################
    public function ListarCreditos()
    {
        self::SetNames();
        $sql = "SELECT ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja FROM (ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON clientes.codcliente=ventas.codcliente LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";

        foreach ($this->dbh->query($sql) as $row) {
            $this->p[] = $row;
        }
        return $this->p;
        $this->dbh = null;
    }
    ####################### FUNCION PARA LISTAR CREDITOS DE VENTAS DE PRODUCTOS #######################

    ########################## FUNCION PARA MOSTRAR CREDITOS DE VENTAS POR ID ############################
    public function CreditosPorId()
    {
        self::SetNames();
        $sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.celcliente, clientes.direccliente, clientes.emailcliente, ventas.codventa, ventas.codserie, ventas.codautorizacion, ventas.descuentove, ventas.descbonificve, ventas.subtotalve, ventas.totalsinimpuestosve, ventas.tarifanove, ventas.tarifasive, ventas.ivave, ventas.totalivave, ventas.totalpago, ventas.totalpago2, ventas.tipopagove, ventas.formapagove, ventas.montopagado, ventas.montodevuelto, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, mediospagos.mediopago, usuarios.cedula, usuarios.nombres, usuarios.email, cajas.nrocaja, cajas.nombrecaja, abonoscreditos.codventa as cod, abonoscreditos.fechaabono, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, sucursales.llevacontabilidad, SUM(montoabono) AS abonototal FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN mediospagos ON ventas.formapagove = mediospagos.codmediopago LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.codventa =? GROUP BY cod";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(base64_decode($_GET["codventa"])));
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "";
        } else {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################## FUNCION PARA MOSTRAR CREDITOS DE VENTAS POR ID ############################

    ############################ FUNCION PARA MOSTRAR DETALLES DE CREDITOS #############################
    public function VerDetallesCreditos()
    {
        self::SetNames();
        $sql = " SELECT * FROM abonoscreditos INNER JOIN ventas ON abonoscreditos.codventa = ventas.codventa WHERE abonoscreditos.codventa = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET["codventa"])));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN ABONOS PARA CR&Eacute;DITOS ACTUALMENTE</center>";
            echo "</div>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ############################ FUNCION PARA MOSTRAR DETALLES DE CREDITOS ############################

    ########################## FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS ############################
    public function BuscarCreditosFechas()
    {
        self::SetNames();

        $sql = "SELECT
	ventas.codventa, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, sucursales.cedresponsable, sucursales.nomresponsable, sucursales.celresponsable, sucursales.rucsucursal, sucursales.razonsocial, sucursales.tlfsucursal, sucursales.celsucursal, sucursales.direcsucursal, sucursales.emailsucursal, sucursales.simbolo, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
	FROM
	(ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON
	clientes.codcliente=ventas.codcliente LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE sucursales.codsucursal = ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? AND ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, trim(base64_decode($_GET['codsucursal'])));
        $stmt->bindValue(2, trim(date("Y-m-d", strtotime($_GET['desde']))));
        $stmt->bindValue(3, trim(date("Y-m-d", strtotime($_GET['hasta']))));
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num == 0) {
            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN CREDITOS DE VENTAS PARA EL RANGO DE FECHA INGRESADO</center>";
            echo "</div>";
            exit;
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################## FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS ###########################

    ############################# FIN DE CLASE ABONOS DE CREDITOS  ##############################








    ################################## FUNCION PARA CONTAR REGISTROS ###################################
    public function ContarRegistros()
    {

        //(select count(*) from ingredientes where CAST(cantingrediente AS DECIMAL(10,5)) <= CAST(stockminimoingrediente AS DECIMAL(10,5))) as stockingredientes,
        if ($_SESSION['acceso'] == "administradorG") {

            $sql = "select
(select count(*) from productos where stocktotal <= stockminimo) as stockproductos,
(select count(*) from productos where fechaexpiracion != null AND fechaexpiracion <= '" . date("Y-m-d") . "') as productosvencidos,
(select count(*) from compras where tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '" . date("Y-m-d") . "') as creditoscomprasvencidos,
(select count(*) from ventas where tipopagove = 'CREDITO' AND formapagove = '' AND fechavencecredito <= '" . date("Y-m-d") . "') as creditosventasvencidos";

            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        } else {

            $sql = "select
(select count(*) from productos where stocktotal <= stockminimo and codsucursal = '" . $_SESSION["codsucursal"] . "') as stockproductos,
(select count(*) from productos where fechaexpiracion != null AND fechaexpiracion <= '" . date("Y-m-d") . "' and codsucursal = '" . $_SESSION["codsucursal"] . "') as productosvencidos,
(select count(*) from compras where tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '" . date("Y-m-d") . "' and codsucursal = '" . $_SESSION["codsucursal"] . "') as creditoscomprasvencidos,
(select count(*) from ventas where tipopagove = 'CREDITO' AND formapagove = '' AND fechavencecredito <= '" . date("Y-m-d") . "' and codsucursal = '" . $_SESSION["codsucursal"] . "') as creditosventasvencidos";

            foreach ($this->dbh->query($sql) as $row) {
                $this->p[] = $row;
            }
            return $this->p;
            $this->dbh = null;
        }
    }
    ########################### FIN DE FUNCION PARA CONTAR REGISTROS ##################################


}
############################# AQUI TERMINA LA CLASE LOGIN ################################
?>