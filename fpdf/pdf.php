<?php

define('FPDF_FONTPATH', 'font/');
require('fpdf.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'helpers/PHPMailer/src/Exception.php';
require_once 'helpers/PHPMailer/src/PHPMailer.php';
require_once 'helpers/PHPMailer/src/SMTP.php';

class PDF extends FPDF
{
    public $flowingBlockAttr;

    ############################### FUNCION PARA MOSTRAR EL FOOTER ################################
    //Pie de p�gina
    public function Footer()
    {
        //Posici�n: a 2 cm del final
        $this->Ln();
        $this->SetY(0);
        //Arial italic 8
        $this->SetFont('Courier', 'B', 8);
        //N�mero de p�gina

        /*$this->Cell(195,-4,'   -  ','0',0,'L');
        $this->Ln();*/

        /*$this->Cell(195,-3,utf8_decode($con[0]['direcempresa']),'0',0,'L');
        $this->Ln();
        $this->Cell(195,-4,"RUT-".utf8_decode($con[0]['rifempresa']." - ".$con[0]['nomempresa']),'0',0,'L');
        $this->Ln();*/

        /*$this->AliasNbPages();
        $this->Cell(0,4,'Pagina '.$this->PageNo().'/{nb}','T',1,'R');*/
    }
    ####################### FIN DE FUNCION PARA MOSTRAR EL FOOTER ###############################


    public function send_factura_mail($attachment)
    {
        $ve = new Login();
        $ve = $ve->VentasPorId();
        $username = 'botica-yurifarma@outlook.es';
        $pass = 'BoticaYurifarma*123*';
        $name = 'BoticaYurifarma';
        if ($ve[0]['correo_to_send'] === null) {
            return;
        }

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = "smtp.office365.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = 587; // TLS only
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $pass;
        $mail->setFrom($username, $name);
        $mail->addAddress($ve[0]['correo_to_send']);
        $mail->Subject = 'AQUI ESTA TU FACTURA: BoticaYurifarma';
        $mail->msgHTML("Mira el PDF");
        $mail->AltBody = 'HTML messaging not supported';
        $mail->AddStringAttachment($attachment, 'FACTURA Botica_Yuri_farma.pdf');
        $mail->send();
    }


    ################################### REPORTES DE MANTENIMIENTO ##################################

    ########################## FUNCION LISTAR SUCURSALES ##############################
    public function TablaListarSucursales()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Movernos a la derecha
        $this->Cell(130);
        //T�tulo
        $this->Cell(180, 25, 'LISTADO GENERAL DE SUCURSALES', 0, 0, 'C');
        //Salto de l�nea
        $this->Ln(30);


        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TEL�FONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es AZUL)
        $this->Cell(15, 8, 'NUM', 1, 0, 'C', true);
        $this->Cell(30, 8, 'RUC SUCURSAL', 1, 0, 'C', true);
        $this->Cell(78, 8, 'RAZON SOCIAL', 1, 0, 'C', true);
        $this->Cell(28, 8, 'TEL�FONO', 1, 0, 'C', true);
        $this->Cell(45, 8, 'EMAIL', 1, 0, 'C', true);
        $this->Cell(40, 8, 'C.I RESPONSABLE', 1, 0, 'C', true);
        $this->Cell(65, 8, 'NOMBRE DE RESPONSABLE', 1, 0, 'C', true);
        $this->Cell(28, 8, 'CELULAR', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarSucursal();

        if($reg == "") {
            echo "";
        } else {

            $a = 1;
            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->CellFitSpace(15, 6, $reg[$i]["nrosucursal"], 1, 0, 'C');
                $this->CellFitSpace(30, 6, utf8_decode($reg[$i]["rucsucursal"]), 1, 0, 'C');
                $this->CellFitSpace(78, 6, utf8_decode($reg[$i]["razonsocial"]), 1, 0, 'C');
                $this->CellFitSpace(28, 6, utf8_decode($reg[$i]["tlfsucursal"]), 1, 0, 'C');
                $this->CellFitSpace(45, 6, utf8_decode($reg[$i]["emailsucursal"]), 1, 0, 'C');
                $this->CellFitSpace(40, 6, utf8_decode($reg[$i]["cedresponsable"]), 1, 0, 'C');
                $this->CellFitSpace(65, 6, utf8_decode($reg[$i]["nomresponsable"]), 1, 0, 'C');
                $this->CellFitSpace(28, 6, utf8_decode($reg[$i]["celresponsable"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ########################## FUNCION LISTAR SUCURSALES ##############################

    ################################ FUNCION LISTAR TARJETAS ##################################
    public function TablaListarTarjetas()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {

            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");

            } else {

                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");

        }
        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        //Movernos a la derecha
        $this->Cell(100);
        //T�tulo
        $this->Cell(65, 20, 'LISTADO GENERAL DE TARJETAS', 0, 0, 'C');
        //Salto de l�nea
        $this->Ln(25);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $con[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $_SESSION['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(75, 8, 'NOMBRE DE ENTIDAD BANCARIA', 1, 0, 'C', true);
        $this->Cell(65, 8, 'NOMBRE DE TARJETA', 1, 0, 'C', true);
        $this->Cell(40, 8, 'TIPO DE TARJETA', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarTarjetas();
        $a = 1;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 5, $a++, 1, 0, 'C');
                $this->CellFitSpace(75, 5, utf8_decode($reg[$i]["nombanco"]), 1, 0, 'C');
                $this->CellFitSpace(65, 5, utf8_decode($reg[$i]["nomtarjeta"]), 1, 0, 'C');
                $this->CellFitSpace(40, 5, utf8_decode($reg[$i]["tipotarjeta"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(85, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(85, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR TARJETAS ##################################

    ################################ FUNCION LISTAR INTERESES EN TARJETAS ##################################
    public function TablaListarInteresesTarjetas()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {

            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");

            } else {

                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");

        }
        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        //Movernos a la derecha
        $this->Cell(100);
        //T�tulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(65, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(90);
        $this->Cell(65, 8, 'LISTADO GENERAL DE INTERESES', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(90);
        $this->Cell(65, 8, 'EN TARJETAS DE CREDITO', 0, 0, 'C');
        $this->Ln(12);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $con[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $_SESSION['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(44, 8, 'NOMBRE DE BANCO', 1, 0, 'C', true);
        $this->Cell(40, 8, 'NOMBRE DE TARJETA', 1, 0, 'C', true);
        $this->Cell(25, 8, 'MESES', 1, 0, 'C', true);
        $this->Cell(25, 8, 'TASA SI %', 1, 0, 'C', true);
        $this->Cell(25, 8, 'TASA NO %', 1, 0, 'C', true);
        $this->Cell(20, 8, 'TIPO', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarIntereses();
        $a = 1;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 5, $a++, 1, 0, 'C');
                $this->CellFitSpace(44, 5, utf8_decode($reg[$i]["nombanco"]), 1, 0, 'C');
                $this->CellFitSpace(40, 5, utf8_decode($reg[$i]["nomtarjeta"]), 1, 0, 'C');
                $this->CellFitSpace(25, 5, utf8_decode($reg[$i]["meses"]), 1, 0, 'C');
                $this->CellFitSpace(25, 5, utf8_decode($reg[$i]["tasasi"]), 1, 0, 'C');
                $this->CellFitSpace(25, 5, utf8_decode($reg[$i]["tasano"]), 1, 0, 'C');
                $this->CellFitSpace(20, 5, utf8_decode($reg[$i]["tipotarjeta"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(85, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(85, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR INTERESES EN TARJETAS ##################################


    ########################## FUNCION LISTAR USUARIOS ##############################
    public function TablaListarUsuarios()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Movernos a la derecha
        $this->Cell(130);
        //T�tulo
        $this->Cell(180, 25, 'LISTADO GENERAL DE USUARIOS', 0, 0, 'C');
        //Salto de l�nea
        $this->Ln(30);


        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es AZUL)
        $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(30, 8, 'C.I/RUC', 1, 0, 'C', true);
        $this->Cell(80, 8, 'NOMBRES Y APELLIDOS', 1, 0, 'C', true);
        $this->Cell(25, 8, 'GENERO', 1, 0, 'C', true);
        $this->Cell(70, 8, 'DIRECCION DOMICILIARIA', 1, 0, 'C', true);
        $this->Cell(35, 8, 'TELEFONO', 1, 0, 'C', true);
        $this->Cell(40, 8, 'USUARIO', 1, 0, 'C', true);
        $this->Cell(40, 8, 'NIVEL', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarUsuarios();

        if($reg == "") {
            echo "";
        } else {

            $a = 1;
            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(30, 6, $reg[$i]["cedula"], 1, 0, 'C');
                $this->CellFitSpace(80, 6, utf8_decode($reg[$i]["nombres"]), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($reg[$i]["genero"]), 1, 0, 'C');
                $this->CellFitSpace(70, 6, utf8_decode($reg[$i]["direcdomic"]), 1, 0, 'C');
                $this->CellFitSpace(35, 6, utf8_decode($reg[$i]["nrotelefono"]), 1, 0, 'C');
                $this->CellFitSpace(40, 6, utf8_decode($reg[$i]["usuario"]), 1, 0, 'C');
                $this->CellFitSpace(40, 6, utf8_decode($reg[$i]["nivel"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ########################## FUNCION LISTAR USUARIOS ##############################

    ########################## FUNCION LISTAR LOGS DE ACCESO DE USUARIOS ##############################
    public function TablaListarLogs()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Movernos a la derecha
        $this->Cell(130);
        //T�tulo
        $this->Cell(180, 25, 'LISTADO GENERAL DE LOGS DE ACCESO DE USUARIOS', 0, 0, 'C');
        //Salto de l�nea
        $this->Ln(30);


        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(35, 8, 'IP', 1, 0, 'C', true);
        $this->Cell(45, 8, 'TIEMPO ENTRADA', 1, 0, 'C', true);
        $this->Cell(190, 8, 'NAVEGADOR DE ACCESO', 1, 0, 'C', true);
        $this->Cell(50, 8, 'USUARIO', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarLogs();
        $a = 1;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(35, 6, $reg[$i]["ip"], 1, 0, 'C');
                $this->CellFitSpace(45, 6, utf8_decode($reg[$i]["tiempo"]), 1, 0, 'C');
                $this->CellFitSpace(190, 6, utf8_decode($reg[$i]["detalles"]), 1, 0, 'C');
                $this->CellFitSpace(50, 6, utf8_decode($reg[$i]["usuario"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ########################## FUNCION LISTAR LOGS DE ACCESO DE USUARIOS ##############################

    ################################ FUNCION LISTAR CAJAS DE VENTAS ##################################
    public function TablaListarCajas()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {

            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {
                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        //Movernos a la derecha
        $this->Cell(100);
        //T�tulo

        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(65, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(90);
        $this->Cell(65, 8, 'LISTADO GENERAL DE CAJAS', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(90);
        $this->Cell(65, 8, 'PARA VENTAS', 0, 0, 'C');
        $this->Ln(12);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $con[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $_SESSION['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        if($_SESSION['acceso'] == "administradorG") {

            $this->SetFont('Courier', 'B', 10);
            $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
            $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
            $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
            $this->Cell(55, 8, 'SUCURSALES', 1, 0, 'C', true);
            $this->Cell(20, 8, 'NUM. CAJA', 1, 0, 'C', true);
            $this->Cell(40, 8, 'NOMBRE DE CAJA', 1, 0, 'C', true);
            $this->Cell(65, 8, 'NOMBRE CAJERO', 1, 1, 'C', true);

            $tra = new Login();
            $reg = $tra->ListarCajas();
            $a = 1;

            if($reg == "") {
                echo "";
            } else {

                for($i = 0;$i < sizeof($reg);$i++) {
                    $this->SetFont('Courier', '', 9);
                    $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                    $this->Cell(10, 6, $a++, 1, 0, 'C');
                    $this->CellFitSpace(55, 6, utf8_decode($razon = ($reg[$i]["razonsocial"] == '' ? "SIN ASIGNACI�N" : $reg[$i]["razonsocial"])), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode($reg[$i]["nrocaja"]), 1, 0, 'C');
                    $this->CellFitSpace(40, 6, utf8_decode($reg[$i]["nombrecaja"]), 1, 0, 'C');
                    $this->CellFitSpace(65, 6, utf8_decode($reg[$i]["nombres"]), 1, 0, 'C');
                    $this->Ln();
                }

            }
        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
            $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
            $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
            $this->Cell(25, 8, 'NUM. CAJA', 1, 0, 'C', true);
            $this->Cell(45, 8, 'NOMBRE DE CAJA', 1, 0, 'C', true);
            $this->Cell(40, 8, 'DNI CAJERO', 1, 0, 'C', true);
            $this->Cell(70, 8, 'NOMBRE CAJERO', 1, 1, 'C', true);

            $tra = new Login();
            $reg = $tra->ListarCajas();
            $a = 1;

            if($reg == "") {
                echo "";
            } else {

                for($i = 0;$i < sizeof($reg);$i++) {
                    $this->SetFont('Courier', '', 9);
                    $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                    $this->Cell(10, 6, $a++, 1, 0, 'C');
                    $this->CellFitSpace(25, 6, utf8_decode($reg[$i]["nrocaja"]), 1, 0, 'C');
                    $this->CellFitSpace(45, 6, utf8_decode($reg[$i]["nombrecaja"]), 1, 0, 'C');
                    $this->CellFitSpace(40, 6, utf8_decode($reg[$i]["cedula"]), 1, 0, 'C');
                    $this->CellFitSpace(70, 6, utf8_decode($reg[$i]["nombres"]), 1, 0, 'C');
                    $this->Ln();
                }

            }
        }

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(85, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(85, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR CAJAS DE VENTAS ##################################

    ################################ FUNCION LISTAR LABORATORIOS ##################################
    public function TablaListarLaboratorios()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {

            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");

            } else {

                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");

        }
        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        //Movernos a la derecha
        $this->Cell(100);
        //T�tulo
        $this->Cell(65, 20, 'LISTADO GENERAL DE LABORATORIOS', 0, 0, 'C');
        //Salto de l�nea
        $this->Ln(25);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $con[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $_SESSION['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($_SESSION['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(75, 8, 'NOMBRE DE LABORATORIO', 1, 0, 'C', true);
        $this->Cell(45, 8, 'APLICA DESCUENTO', 1, 0, 'C', true);
        $this->Cell(30, 8, '% DESCUENTO', 1, 0, 'C', true);
        $this->Cell(30, 8, 'RECARGA TDC', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarLaboratorios();
        $a = 1;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 5, $a++, 1, 0, 'C');
                $this->CellFitSpace(75, 5, utf8_decode($reg[$i]["nomlaboratorio"]), 1, 0, 'C');
                $this->CellFitSpace(45, 5, utf8_decode($reg[$i]["aplicadescuento"]), 1, 0, 'C');
                $this->CellFitSpace(30, 5, utf8_decode($reg[$i]["desclaboratorio"]), 1, 0, 'C');
                $this->CellFitSpace(30, 5, utf8_decode($reg[$i]["recargotc"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(85, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(85, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR LABORATORIOS ##################################

    ################################### FUNCION LISTAR PROVEEDORES #################################
    public function TablaListarProveedores()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Movernos a la derecha
        $this->Cell(130);
        //T�tulo
        $this->Cell(180, 25, 'LISTADO GENERAL DE PROVEEDORES', 0, 0, 'C');
        //Salto de l�nea
        $this->Ln(30);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(28, 8, 'RUC', 1, 0, 'C', true);
        $this->Cell(45, 8, 'NOMBRE COMERCIAL', 1, 0, 'C', true);
        $this->Cell(100, 8, 'DIRECCION DOMICILIARIA', 1, 0, 'C', true);
        $this->Cell(32, 8, 'TELEFONO', 1, 0, 'C', true);
        $this->Cell(65, 8, 'CORREO', 1, 0, 'C', true);
        $this->Cell(55, 8, 'PROVEEDOR', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarProveedores();
        $a = 1;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(28, 6, utf8_decode($reg[$i]["rucproveedor"]), 1, 0, 'C');
                $this->CellFitSpace(45, 6, utf8_decode($reg[$i]["nomproveedor"]), 1, 0, 'C');
                $this->CellFitSpace(100, 6, utf8_decode($reg[$i]["direcproveedor"]), 1, 0, 'C');
                $this->Cell(32, 6, utf8_decode($reg[$i]["tlfproveedor"]), 1, 0, 'C');
                $this->Cell(65, 6, utf8_decode($reg[$i]["emailproveedor"]), 1, 0, 'C');
                $this->Cell(55, 6, utf8_decode($reg[$i]["contactoproveedor"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################### FUNCION LISTAR PROVEEDORES #################################

    #################################### FUNCION LISTAR CLIENTES ###################################
    public function TablaListarClientes()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Movernos a la derecha
        $this->Cell(130);
        //T�tulo
        $this->Cell(180, 25, 'LISTADO GENERAL DE CLIENTES', 0, 0, 'C');
        //Salto de l�nea
        $this->Ln(30);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln();

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'N� TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln();
        }

        $this->Ln();
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(35, 8, 'DNI', 1, 0, 'C', true);
        $this->Cell(70, 8, 'NOMBRES', 1, 0, 'C', true);
        $this->Cell(125, 8, 'DIRECCION DOMICILIARIA', 1, 0, 'C', true);
        $this->Cell(30, 8, 'TEL�FONO', 1, 0, 'C', true);
        $this->Cell(65, 8, 'CORREO', 1, 1, 'C', true);

        $tra = new Login();
        $reg = $tra->ListarClientes();
        $a = 1;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(35, 6, utf8_decode($reg[$i]["cedcliente"]), 1, 0, 'C');
                $this->CellFitSpace(70, 6, utf8_decode($reg[$i]["nomcliente"]), 1, 0, 'C');
                $this->CellFitSpace(125, 6, utf8_decode($reg[$i]["direccliente"]), 1, 0, 'C');
                $this->Cell(30, 6, utf8_decode($reg[$i]["tlfcliente"]), 1, 0, 'C');
                $this->Cell(65, 6, utf8_decode($reg[$i]["emailcliente"]), 1, 0, 'C');
                $this->Ln();
            }
        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    #################################### FUNCION LISTAR CLIENTES ###################################

    ################################ FUNCION LISTAR PRODUTOS ACTIVOS POR SUCURSAL ################################
    public function TablaListarProductosAct()
    {

        $tra = new Login();
        $reg = $tra->BuscarProductosActivos();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'LISTADO GENERAL DE PRODUCTOS ACTIVOS', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DE SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }


        //Calculo del stock por cajas y por unidades,cambio en la cabecera....... Christian........
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(90, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(52, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'LAB.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'U. x CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK CAJ', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK UNI', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'PVP UNID', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'COSTO TOT', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'CODIGO BARRA', 1, 1, 'C', true);

        $a = 1;
        $TotalCajas = 0;
        $TotalUnidad = 0;
        $TotalInventario = 0;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $TotalCajas += $reg[$i]['stockcajas'];
                $TotalUnidad += $reg[$i]['stocktotal'];
                $TotalInventario += $reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"];

                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(18, 6, $reg[$i]["codproducto"], 1, 0, 'C');
                $this->CellFitSpace(90, 6, utf8_decode($reg[$i]["producto"]." ".$reg[$i]["nommedida"]), 1, 0, 'C');
                $this->CellFitSpace(52, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');

                $this->CellFitSpace(15, 6, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 5)), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventacaja"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(18, 6, utf8_decode($reg[$i]["unidades"]), 1, 0, 'C');

                if($reg[$i]["stocktotal"] == 0) {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');

                } else {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode(floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode((($reg[$i]["stocktotal"] / $reg[$i]["unidades"]) - floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])) * $reg[$i]["unidades"]), 1, 0, 'C');
                }


                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(22, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"], 2, '.', ',')), 1, 0, 'C');
                $this->Cell(30, 6, utf8_decode($reg[$i]["codigobarra"]), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Cell(325, 5, '', 0, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(120, 5, 'DETALLES DEL INVENTARIO', 1, 0, 'C', true);
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL CAJAS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalCajas, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL ARTICULOS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalUnidad, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'COSTO INVENTARIO', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalInventario, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR PRODUTOS ACTIVOS POR SUCURSAL ################################

    ################################ FUNCION LISTAR PRODUTOS INACTIVOS POR SUCURSAL ################################
    public function TablaListarProductosInact()
    {

        $tra = new Login();
        $reg = $tra->BuscarProductosInactivos();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'LISTADO GENERAL DE PRODUCTOS INACTIVOS', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DE SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }


        //Calculo del stock por cajas y por unidades,cambio en la cabecera....... Christian........
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(90, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(52, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'LAB.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'U. x CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK CAJ', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK UNI', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'PVP UNID', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'COSTO TOT', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'CODIGO BARRA', 1, 1, 'C', true);

        $a = 1;
        $TotalCajas = 0;
        $TotalUnidad = 0;
        $TotalInventario = 0;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $TotalCajas += $reg[$i]['stockcajas'];
                $TotalUnidad += $reg[$i]['stocktotal'];
                $TotalInventario += $reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"];

                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(18, 6, $reg[$i]["codproducto"], 1, 0, 'C');
                $this->CellFitSpace(90, 6, utf8_decode($reg[$i]["producto"]." ".$reg[$i]["nommedida"]), 1, 0, 'C');
                $this->CellFitSpace(52, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');

                $this->CellFitSpace(15, 6, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 5)), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventacaja"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(18, 6, utf8_decode($reg[$i]["unidades"]), 1, 0, 'C');

                if($reg[$i]["stocktotal"] == 0) {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');

                } else {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode(floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode((($reg[$i]["stocktotal"] / $reg[$i]["unidades"]) - floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])) * $reg[$i]["unidades"]), 1, 0, 'C');
                }


                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(22, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"], 2, '.', ',')), 1, 0, 'C');
                $this->Cell(30, 6, utf8_decode($reg[$i]["codigobarra"]), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Cell(325, 5, '', 0, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(120, 5, 'DETALLES DEL INVENTARIO', 1, 0, 'C', true);
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL CAJAS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalCajas, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL ARTICULOS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalUnidad, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'COSTO INVENTARIO', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalInventario, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR PRODUTOS INACTIVOS POR SUCURSAL ################################

    ################################ FUNCION LISTAR PRODUTOS POR SUCURSAL ################################
    public function TablaListarProductosSucursal()
    {

        $tra = new Login();
        $reg = $tra->BuscarProductosSucursal();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'LISTADO GENERAL DE PRODUCTOS EN ALMACEN', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DE SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }


        //Calculo del stock por cajas y por unidades,cambio en la cabecera....... Christian........
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(90, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(52, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'LAB.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'U. x CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK CAJ', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK UNI', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'PVP UNID', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'COSTO TOT', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'CODIGO BARRA', 1, 1, 'C', true);

        $a = 1;
        $TotalCajas = 0;
        $TotalUnidad = 0;
        $TotalInventario = 0;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $TotalCajas += $reg[$i]['stockcajas'];
                $TotalUnidad += $reg[$i]['stocktotal'];
                $TotalInventario += $reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"];

                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(18, 6, $reg[$i]["codproducto"], 1, 0, 'C');
                $this->CellFitSpace(90, 6, utf8_decode($reg[$i]["producto"]." ".$reg[$i]["nommedida"]), 1, 0, 'C');
                $this->CellFitSpace(52, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');

                $this->CellFitSpace(15, 6, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 5)), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventacaja"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(18, 6, utf8_decode($reg[$i]["unidades"]), 1, 0, 'C');

                if($reg[$i]["stocktotal"] == 0) {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');

                } else {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode(floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode((($reg[$i]["stocktotal"] / $reg[$i]["unidades"]) - floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])) * $reg[$i]["unidades"]), 1, 0, 'C');
                }


                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(22, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"], 2, '.', ',')), 1, 0, 'C');
                $this->Cell(30, 6, utf8_decode($reg[$i]["codigobarra"]), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Cell(325, 5, '', 0, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(120, 5, 'DETALLES DEL INVENTARIO', 1, 0, 'C', true);
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL CAJAS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalCajas, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL ARTICULOS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalUnidad, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'COSTO INVENTARIO', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalInventario, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR PRODUTOS POR SUCURSAL ################################

    ############################# FUNCION LISTAR PRODUCTOS POR LABORATORIO ############################
    public function TablaListarProductosLaboratorio()
    {

        $tra = new Login();
        $reg = $tra->BuscarProductosLaboratorios();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'PRODUCTOS DEL LABORATORIO '.getSubString($reg[0]['nomlaboratorio'], 20), 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('Y SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(100, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(42, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'UNI x CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK CAJ', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK UNI', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PVP UNID', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'COSTO TOTAL', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'CODIGO BARRA', 1, 1, 'C', true);

        $a = 1;
        $TotalCajas = 0;
        $TotalUnidad = 0;
        $TotalInventario = 0;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $TotalCajas += $reg[$i]['stockcajas'];
                $TotalUnidad += $reg[$i]['stocktotal'];
                $TotalInventario += $reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"];

                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(18, 6, $reg[$i]["codproducto"], 1, 0, 'C');
                $this->CellFitSpace(100, 6, utf8_decode($reg[$i]["producto"]." ".$reg[$i]["nommedida"]), 1, 0, 'C');
                $this->CellFitSpace(42, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventacaja"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($reg[$i]["unidades"]), 1, 0, 'C');


                if($reg[$i]["stocktotal"] == 0) {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');

                } else {

                    //Calculo del stock por cajas y por unidades ....... Christian........
                    $this->CellFitSpace(20, 6, utf8_decode(floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])), 1, 0, 'C');
                    $this->CellFitSpace(20, 6, utf8_decode((($reg[$i]["stocktotal"] / $reg[$i]["unidades"]) - floor($reg[$i]["stocktotal"] / $reg[$i]["unidades"])) * $reg[$i]["unidades"]), 1, 0, 'C');
                }


                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"] * $reg[$i]["stocktotal"], 2, '.', ',')), 1, 0, 'C');
                $this->Cell(30, 6, utf8_decode($reg[$i]["codigobarra"]), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Cell(325, 5, '', 0, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(120, 5, 'DETALLES DEL INVENTARIO', 1, 0, 'C', true);
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL CAJAS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalCajas, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL ARTICULOS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalUnidad, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'COSTO INVENTARIO', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(80, 5, number_format($TotalInventario, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################## FUNCION LISTAR PRODUTOS POR LABORATORIO ############################


    ############################ FUNCION LISTAR PRODUTOS EN STOCK MINIMO #############################
    public function ListarProductosStockMinimo()
    {
        $tra = new Login();
        $reg = $tra->BuscarProductosStockMinimo();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'LISTADO DE PRODUCTOS EN STOCK MINIMO', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DE SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);


        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(100, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(48, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'LAB.', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'PVP UNIDAD', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK TOT', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK MIN', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'IVA', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'DCTO', 1, 0, 'C', true);
        $this->CellFitSpace(26, 8, 'CODIGO BARRA', 1, 1, 'C', true);


        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(20, 6, $reg[$i]["codproducto"], 1, 0, 'C');
                $this->CellFitSpace(100, 6, utf8_decode($reg[$i]["producto"]." ".$reg[$i]["nommedida"]), 1, 0, 'C');
                $this->CellFitSpace(48, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');
                $this->CellFitSpace(15, 6, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 5)), 1, 0, 'C');
                $this->CellFitSpace(22, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(22, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventacaja"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($reg[$i]["stocktotal"]), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($reg[$i]["stockminimo"]), 1, 0, 'C');
                $this->Cell(15, 6, utf8_decode($reg[$i]["ivaproducto"]), 1, 0, 'C');
                $this->Cell(15, 6, utf8_decode($reg[$i]["descproducto"]), 1, 0, 'C');
                $this->Cell(26, 6, utf8_decode($reg[$i]["codigobarra"]), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################ FUNCION LISTAR PRODUTOS EN STOCK MINIMO #############################

    ################################ FUNCION LISTAR PRODUTOS VENDIDOS ###############################
    public function TablaListarProductosVendidos()
    {

        $con = new Login();
        $con = $con->ConfiguracionPorId();

        $vend = new Login();
        $reg = $vend->BuscarVentasProductos();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'LISTADO DE PRODUCTOS VENDIDOS', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"]), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(122, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(40, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'LAB.', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PRECIO CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PRECIO UNIDAD', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'DCTO', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'VENDIDO', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'VALOR NETO', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK ACTUAL', 1, 1, 'C', true);

        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);
        $a = 1;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 8);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 5, $a++, 1, 0, 'C');
                $this->CellFitSpace(20, 6, $reg[$i]["codproducto"], 1, 0, 'C');
                $this->CellFitSpace(122, 6, utf8_decode($reg[$i]["producto"]." ".$reg[$i]["nommedida"]), 1, 0, 'C');
                $this->CellFitSpace(40, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');

                $this->CellFitSpace(15, 6, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 5)), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventacajav"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidadv"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(15, 6, utf8_decode($simbolo.number_format($reg[$i]["descproductov"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(18, 6, $cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2']), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]["valornetov"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($reg[$i]["stocktotal"]), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################ FUNCION LISTAR PRODUTOS VENDIDOS ###############################

    ############################ FUNCION LISTAR PRODUTOS VENCIDOS #############################
    public function TablaListarProductosVencidos()
    {
        $tra = new Login();
        $reg = $tra->BuscarProductosVencidos();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        if($_GET['tiempovence'] == '0') {
            //T�tulo
            $this->Cell(180, 10, 'LISTADO DE PRODUCTOS VENCIDOS', 0, 0, 'C');

        } else {

            if($_GET['tiempovence'] == '5') {
                //T�tulo
                $this->Cell(180, 10, 'LISTADO DE PRODUCTOS A VENCER EN 5 DIAS', 0, 0, 'C');

            } elseif($_GET['tiempovence'] == '15') {
                //T�tulo
                $this->Cell(180, 10, 'LISTADO DE PRODUCTOS A VENCER EN 15 DIAS', 0, 0, 'C');

            } elseif($_GET['tiempovence'] == '30') {
                //T�tulo
                $this->Cell(180, 10, 'LISTADO DE PRODUCTOS A VENCER EN 1 MES', 0, 0, 'C');

            } elseif($_GET['tiempovence'] == '60') {
                //T�tulo
                $this->Cell(180, 10, 'LISTADO DE PRODUCTOS A VENCER EN 2 MESES', 0, 0, 'C');

            } elseif($_GET['tiempovence'] == '90') {
                //T�tulo
                $this->Cell(180, 10, 'LISTADO DE PRODUCTOS A VENCER EN 3 MESES', 0, 0, 'C');
            }
        }
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DE SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(125, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(45, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'LABORATORIO', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PVP UNIDAD', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'STOCK TOTAL', 1, 0, 'C', true);
        $this->CellFitSpace(28, 8, 'FECHA EXPIRACION', 1, 1, 'C', true);

        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(20, 6, $reg[$i]["codproducto"], 1, 0, 'C');
                $this->CellFitSpace(125, 6, utf8_decode($reg[$i]["producto"]." ".$reg[$i]["nommedida"]), 1, 0, 'C');
                $this->CellFitSpace(45, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');
                $this->CellFitSpace(30, 6, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 15)), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventacaja"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidad"], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($reg[$i]["stocktotal"]), 1, 0, 'C');
                $this->CellFitSpace(28, 6, utf8_decode($reg[$i]["fechaexpiracion"]), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################ FUNCION LISTAR PRODUTOS VENCIDOS #############################

    ################################## FUNCION LISTAR KARDEX POR PRODUCTOS ###########################
    public function TablaKardexProductos()
    {

        $con = new Login();
        $con = $con->ConfiguracionPorId();

        $kardex = new Login();
        $kardex = $kardex->BuscarKardexProducto();

        //Logo
        if (isset($kardex[0]['rucsucursal'])) {
            if (file_exists("fotos/".$kardex[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$kardex[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'LISTADO DE KARDEX DEL PRODUCTO '.utf8_decode($kardex[0]['producto']), 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DE SUCURSAL '.$kardex[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(35, 8, 'MOVIMIENTO', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'ENTRADAS', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'SALIDAS', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'DEVOLUCION', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PVP UNIDAD', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'COSTO UNID.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'STOCK ACTUAL', 1, 0, 'C', true);
        $this->CellFitSpace(104, 8, 'DOCUMENTO', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'FECHA', 1, 1, 'C', true);

        $TotalEntradas = 0;
        $TotalSalidas = 0;
        $TotalDevolucion = 0;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);
        $a = 1;

        if($kardex == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($kardex);$i++) {
                $TotalEntradas += $entradas = ($kardex[$i]['entradabonif'] == '0' ? $kardex[$i]['entradacaja'] : $kardex[$i]['entradacaja']."+".$kardex[$i]['entradabonif']);
                $TotalSalidas += $salidas = ($kardex[$i]['salidabonif'] == '0' ? $kardex[$i]['salidaunidad'] : $kardex[$i]['salidaunidad']."+".$kardex[$i]['salidabonif']);
                $TotalDevolucion += $devolucion = ($kardex[$i]['devolucionbonif'] == '0' ? $kardex[$i]['devolucionunidad'] : $kardex[$i]['devolucionunidad']."+".$kardex[$i]['devolucionbonif']);

                $this->SetFont('Courier', '', 8);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 5, $a++, 1, 0, 'C');
                $this->CellFitSpace(35, 5, $kardex[$i]['movimiento'], 1, 0, 'C');
                $this->CellFitSpace(20, 5, utf8_decode($entradas = ($kardex[$i]['entradabonif'] == '0' ? $kardex[$i]['entradacaja'] : $kardex[$i]['entradacaja']."+".$kardex[$i]['entradabonif'])), 1, 0, 'C');
                $this->CellFitSpace(20, 5, utf8_decode($salidas = ($kardex[$i]['salidabonif'] == '0' ? $kardex[$i]['salidaunidad'] : $kardex[$i]['salidaunidad']."+".$kardex[$i]['salidabonif'])), 1, 0, 'C');
                $this->CellFitSpace(20, 5, utf8_decode($devolucion = ($kardex[$i]['devolucionbonif'] == '0' ? $kardex[$i]['devolucionunidad'] : $kardex[$i]['devolucionunidad']."+".$kardex[$i]['devolucionbonif'])), 1, 0, 'C');
                $this->CellFitSpace(25, 5, utf8_decode($simbolo.number_format($kardex[$i]['precioventaunidadm'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(25, 5, utf8_decode($simbolo.number_format($kardex[$i]['precioventacajam'], 2, '.', ',')), 1, 0, 'C');

                if($kardex[$i]['movimiento'] == "ENTRADAS") {
                    $this->CellFitSpace(25, 5, utf8_decode($simbolo.number_format($kardex[$i]['precioventaunidadm'] * $entradas, 2, '.', ',')), 1, 0, 'C');

                } elseif($kardex[$i]['movimiento'] == "SALIDAS") {
                    $this->CellFitSpace(25, 5, utf8_decode($simbolo.number_format($kardex[$i]['precioventaunidadm'] * $salidas, 2, '.', ',')), 1, 0, 'C');

                } elseif($kardex[$i]['movimiento'] == "DEVOLUCION") {
                    $this->CellFitSpace(25, 5, utf8_decode($simbolo.number_format($kardex[$i]['precioventaunidadm'] * $devolucion, 2, '.', ',')), 1, 0, 'C');
                }

                $this->CellFitSpace(20, 5, utf8_decode($kardex[$i]['stocktotalunidad']), 1, 0, 'C');
                $this->CellFitSpace(104, 5, utf8_decode($kardex[$i]['documento']), 1, 0, 'C');
                $this->CellFitSpace(30, 5, utf8_decode(date("d-m-Y", strtotime($kardex[$i]['fechakardex']))), 1, 0, 'C');
                $this->Ln();
            }

        }

        $this->Cell(325, 5, '', 0, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(120, 5, 'DETALLES DEL PRODUCTO', 1, 0, 'C', true);
        $this->Ln();

        $this->Cell(35, 5, 'CODIGO', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($kardex[0]['codproducto']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'DESCRIPCION', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($kardex[0]['producto']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'PRINCIPIO ACTIVO', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($kardex[0]['principioactivo']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'UNIDAD DE MEDIDA', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($kardex[0]['nommedida']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'PRESENTACION', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($kardex[0]['nompresentacion']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'ENTRADAS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($TotalEntradas), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'SALIDAS', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($TotalSalidas), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'DEVOLUCION', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($TotalDevolucion), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'STOCK ACTUAL', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($kardex[0]['stocktotal']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'PRECIO COMPRA', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($simbolo.$kardex[0]['preciocompra']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'PVP CAJA', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($simbolo.$kardex[0]['precioventacaja']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'PVP UNIDAD', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(85, 5, utf8_decode($simbolo.$kardex[0]['precioventaunidad']), 1, 0, 'C');

        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(40, 6, '', 0, 0, '');
        $this->Cell(140, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(80, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(40, 6, '', 0, 0, '');
        $this->Cell(140, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(80, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ################################## FUNCION LISTAR KARDEX POR PRODUCTOS ###########################


    ########################### FUNCION LISTAR TRAPASO DE PRODUCTOS POR FECHAS #############################
    public function TablaListarTraspasos()
    {

        $tra = new Login();
        $reg = $tra->BuscarTraspasosFechas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 30, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 30, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 30, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Movernos a la derecha
        $this->Cell(130);
        //T�tulo
        $this->Cell(180, 10, 'TRASPASO DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"], 0, 0, 'C');
        $this->Ln();
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('A SUCURSAL '.$reg[0]['recibido']), 0, 0, 'C');
        $this->Ln(20);


        $this->SetFont('Courier', 'B', 10);
        $this->SetFillColor(2, 157, 116);
        $this->Cell(15, 5, '', 0, 0, '');
        $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
        $this->CellFitSpace(42, 5, $reg[0]['cedresponsable'], 0, 0, '');
        $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
        $this->CellFitSpace(100, 5, utf8_decode($reg[0]['nomresponsable']), 0, 0, '');
        $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
        $this->CellFitSpace(55, 5, $reg[0]['celresponsable'], 0, 1, '');

        $this->Cell(15, 5, '', 0, 0, '');
        $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
        $this->CellFitSpace(42, 5, $reg[0]['rucsucursal'], 0, 0, '');
        $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
        $this->CellFitSpace(100, 5, utf8_decode($reg[0]['razonsocial']), 0, 0, '');
        $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
        $this->CellFitSpace(55, 5, $reg[0]['tlfsucursal'], 0, 1, '');

        $this->Cell(15, 5, '', 0, 0, '');
        $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
        $this->CellFitSpace(42, 5, $reg[0]['celsucursal'], 0, 0, '');
        $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
        $this->CellFitSpace(100, 5, utf8_decode($reg[0]['direcsucursal']), 0, 0, '');
        $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
        $this->CellFitSpace(55, 5, utf8_decode($reg[0]['emailsucursal']), 0, 0, '');
        $this->Ln();


        $this->Ln();
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'CODIGO', 1, 0, 'C', true);
        $this->CellFitSpace(120, 8, 'PRODUCTO', 1, 0, 'C', true);
        $this->CellFitSpace(60, 8, 'PRESENTACION', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PVP CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'PVP UNIDAD', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'CANTIDAD', 1, 0, 'C', true);
        $this->CellFitSpace(45, 8, 'FECHA TRASPASO', 1, 1, 'C', true);


        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $reg[0]['simbolo'] : $reg[0]["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {

                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(25, 6, $reg[$i]["codproductot"], 1, 0, 'C');
                $this->CellFitSpace(120, 6, $reg[$i]["producto"]." ".$reg[$i]["nommedida"], 1, 0, 'C');

                $this->CellFitSpace(60, 6, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');

                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['preciocajat'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['preciounidadt'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($reg[$i]['cantenvio']), 1, 0, 'C');
                $this->CellFitSpace(45, 6, utf8_decode(date("d-m-Y h:i:s", strtotime($reg[$i]['fechatraspaso']))), 1, 0, 'C');
                $this->Ln();
            }
        }


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ########################### FUNCION LISTAR TRAPASO DE PRODUCTOS POR FECHAS #############################

    ################################# REPORTES DE MANTENIMIENTO #################################






























    ################################## CLASE PEDIDOS DE PRODUCTOS ################################

    ############################### FUNCION FACTURA DE PEDIDOS DE PRODUCTOS ###########################
    public function TablaPedidosProductos()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 15, 11, 55, 15, "PNG");
            } else {

                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 15, 11, 55, 15, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 15, 11, 55, 15, "PNG");
        }

        //$this->Image("./assets/images/logo.png" , 15 ,11, 55 , 15 , "PNG");
        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        $this->Ln(30);

        $pe = new Login();
        $pe = $pe->PedidosPorId();

        #################################### BLOQUE N� 1 ########################################

        //Bloque de membrete principal
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 10, 190, 17, '1.5', '');

        //Bloque de membrete principal
        $this->SetFillColor(199);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');
        //Bloque de membrete principal
        $this->SetFillColor(199);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(98, 12, 12, 12, '1.5', '');
        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 16);
        $this->SetXY(101, 14);
        $this->Cell(20, 5, 'P', 0, 0);
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(98, 19);
        $this->Cell(20, 5, 'Pedido', 0, 0);


        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 11);
        $this->SetXY(135, 12);
        $this->Cell(20, 5, 'NUM. PEDIDO ', 0, 0);
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(165, 12);
        $this->Cell(20, 5, utf8_decode($pe[0]['codpedido']), 0, 0);
        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(135, 16);
        $this->Cell(20, 5, 'FECHA PEDIDO ', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(165, 16);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y h:i:s", strtotime($pe[0]['fechapedido']))), 0, 0);
        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(135, 20);
        $this->Cell(20, 5, 'FECHA EMISION', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(165, 20);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y h:i:s")), 0, 0);


        ############################### BLOQUE N� 2 #####################################

        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 29, 190, 18, '1.5', '');
        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 30);
        $this->Cell(20, 5, 'DATOS DE SUCURSAL ', 0, 0);
        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(15, 34);
        $this->Cell(20, 5, 'RAZON SOCIAL :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(38, 34);
        $this->Cell(20, 5, utf8_decode($pe[0]['razonsocial']), 0, 0);
        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(110, 34);
        $this->Cell(90, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(125, 34);
        $this->Cell(90, 5, utf8_decode($pe[0]['rucsucursal']), 0, 0);
        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(155, 34);
        $this->Cell(90, 5, 'TELEFONO :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(175, 34);
        $this->Cell(90, 5, utf8_decode($pe[0]['tlfsucursal']), 0, 0);
        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(15, 38);
        $this->Cell(20, 5, 'DIRECCION :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(32, 38);
        $this->Cell(20, 5, utf8_decode($pe[0]['direcsucursal']), 0, 0);
        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(104, 38);
        $this->Cell(20, 5, 'EMAIL :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(116, 38);
        $this->Cell(20, 5, utf8_decode($pe[0]['emailsucursal']), 0, 0);
        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(155, 38);
        $this->Cell(20, 5, 'CELULAR :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(175, 38);
        $this->Cell(20, 5, utf8_decode($pe[0]['celsucursal']), 0, 0);
        //Linea de membrete Nro 8
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(15, 42);
        $this->Cell(20, 5, 'RESPONSABLE :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(36, 42);
        $this->Cell(20, 5, utf8_decode($pe[0]['nomresponsable']), 0, 0);
        //Linea de membrete Nro 9
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(94, 42);
        $this->Cell(20, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(108, 42);
        $this->Cell(20, 5, utf8_decode($pe[0]['cedresponsable']), 0, 0);
        //Linea de membrete Nro 8
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(134, 42);
        $this->Cell(20, 5, 'CELULAR :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(154, 42);
        $this->Cell(20, 5, utf8_decode($pe[0]['celresponsable']), 0, 0);

        ################################# BLOQUE N� 3 #######################################

        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 49, 190, 14, '1.5', '');
        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 50);
        $this->Cell(20, 5, 'DATOS DEL PROVEEDOR ', 0, 0);
        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(15, 54);
        $this->Cell(20, 5, 'RAZON SOCIAL :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(36, 54);
        $this->Cell(20, 5, utf8_decode($pe[0]['nomproveedor']), 0, 0);
        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(94, 54);
        $this->Cell(70, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(108, 54);
        $this->Cell(75, 5, utf8_decode($pe[0]['rucproveedor']), 0, 0);
        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(134, 54);
        $this->Cell(90, 5, 'EMAIL :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(146, 54);
        $this->Cell(90, 5, utf8_decode($pe[0]['emailproveedor']), 0, 0);
        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(15, 58);
        $this->Cell(20, 5, 'DIRECCION :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(33, 58);
        $this->Cell(20, 5, utf8_decode($pe[0]['direcproveedor']), 0, 0);
        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(98, 58);
        $this->Cell(20, 5, 'TELEFONO :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(118, 58);
        $this->Cell(20, 5, utf8_decode($pe[0]['tlfproveedor']), 0, 0);
        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 7);
        $this->SetXY(140, 58);
        $this->Cell(20, 5, 'VENDEDOR :', 0, 0);
        $this->SetFont('Courier', '', 7);
        $this->SetXY(156, 58);
        $this->Cell(20, 5, utf8_decode($pe[0]['contactoproveedor']), 0, 0);

        $this->Ln(7);
        $this->SetFont('Courier', 'B', 10);
        $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS
        $this->Cell(8, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(20, 8, 'CODIGO', 1, 0, 'C', true);
        $this->Cell(50, 8, 'NOMBRE DE PRODUCTO', 1, 0, 'C', true);
        $this->Cell(50, 8, 'PRINCIPIO ACTIVO', 1, 0, 'C', true);
        $this->Cell(20, 8, 'PRESENT', 1, 0, 'C', true);
        $this->Cell(30, 8, 'LABORATORIO', 1, 0, 'C', true);
        $this->Cell(12, 8, 'CANT', 1, 1, 'C', true);

        ########################### BLOQUE N� 4 DE DETALLES DE PRODUCTOS ###########################
        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 75, 190, 180, '1.5', '');

        $this->Ln(3);
        $tra = new Login();
        $reg = $tra->VerDetallesPedidos();
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $this->SetFont('Courier', '', 8);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(8, 4, $a++, 0, 0, 'C');
            $this->CellFitSpace(20, 4, utf8_decode($reg[$i]["codproducto"]), 0, 0, 'C');
            $this->CellFitSpace(50, 4, utf8_decode(getSubString($reg[$i]["producto"]." - ".$reg[$i]["nommedida"], 40)), 0, 0, 'C');
            $this->CellFitSpace(50, 4, utf8_decode(getSubString($reg[$i]["principioactivo"], 40)), 0, 0, 'C');
            $this->CellFitSpace(20, 4, utf8_decode($reg[$i]["nompresentacion"]), 0, 0, 'C');
            $this->Cell(30, 4, utf8_decode($reg[$i]["nomlaboratorio"]), 0, 0, 'C');
            $this->CellFitSpace(12, 4, utf8_decode($reg[$i]["cantpedido"]), 0, 0, 'C');
            $this->Ln();
        }

        $this->SetXY(10, 270);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(190, 0, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________', '', 1, 'C');
        $this->Ln(4);
    }

    ############################### FUNCION FACTURA DE PEDIDOS DE PRODUCTOS ###########################

    ##################################### CLASE PEDIDOS DE PRODUCTOS ###################################


























    ############################## CLASE COMPRAS DE PRODUCTOS ###################################

    ################################# FUNCION FACTURA DE COMPRAS ################################
    public function TablaFacturaCompra()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 25, 11, 65, 18, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 25, 11, 65, 18, "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 25, 11, 65, 18, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        //Movernos a la derecha

        $co = new Login();
        $co = $co->ComprasPorId();

        ######################### BLOQUE N� 1 #########################

        //Bloque de membrete principal
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 10, 335, 20, '1.5', '');

        //Bloque de membrete principal
        $this->SetFillColor(199);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(164, 13, 13, 13, '1.5', 'F');

        //Bloque de membrete principal
        $this->SetFillColor(199);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(164, 13, 13, 13, '1.5', '');

        //Linea de membrete Centro
        $this->SetFont('Courier', 'B', 16);
        $this->SetXY(168, 14);
        $this->Cell(20, 5, 'C', 0, 0);
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(164, 19);
        $this->Cell(20, 5, 'Compra', 0, 0);

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 12);
        $this->Cell(20, 5, 'NUM. COMPRA ', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(320, 12);
        $this->Cell(20, 5, utf8_decode($co[0]['codcompra']), 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 16);
        $this->Cell(20, 5, 'FECHA EMISION ', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(320, 16);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y", strtotime($co[0]['fechaemision']))), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 20);
        $this->Cell(20, 5, 'FECHA RECEPCION ', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(320, 20);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y", strtotime($co[0]['fecharecepcion']))), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 24);
        $this->Cell(20, 5, 'STATUS COMPRA', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(320, 24);

        if($co[0]['fechavencecredito'] == '0000-00-00') {
            $this->Cell(20, 5, utf8_decode($co[0]['statuscompra']), 0, 0);
        } elseif($co[0]['fechavencecredito'] >= date("Y-m-d")) {
            $this->Cell(20, 5, utf8_decode($co[0]['statuscompra']), 0, 0);
        } elseif($co[0]['fechavencecredito'] < date("Y-m-d")) {
            $this->Cell(20, 5, utf8_decode("VENCIDA"), 0, 0);
        }

        ############################### BLOQUE N� 2 #####################################

        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 32, 335, 29, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(15, 33);
        $this->Cell(20, 5, 'DATOS DE SUCURSAL ', 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 37);
        $this->Cell(20, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(36, 37);
        $this->Cell(20, 5, utf8_decode($co[0]['rucsucursal']), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(72, 37);
        $this->Cell(70, 5, 'RAZON SOCIAL :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(102, 37);
        $this->Cell(75, 5, utf8_decode($co[0]['razonsocial']), 0, 0);


        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(155, 37);
        $this->Cell(90, 5, 'TELEFONO :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(180, 37);
        $this->Cell(90, 5, utf8_decode($co[0]['tlfsucursal']), 0, 0);

        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(200, 37);
        $this->Cell(20, 5, 'CELULAR :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(224, 37);
        $this->Cell(20, 5, utf8_decode($co[0]['celsucursal']), 0, 0);

        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(254, 37);
        $this->Cell(20, 5, 'EMAIL :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(272, 37);
        $this->Cell(20, 5, utf8_decode($co[0]['emailsucursal']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 41);
        $this->Cell(20, 5, 'DIRECCION :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(38, 41);
        $this->Cell(20, 5, utf8_decode($co[0]['direcsucursal']), 0, 0);

        //Linea de membrete Nro 8
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(112, 41);
        $this->Cell(20, 5, 'RESPONSABLE :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(138, 41);
        $this->Cell(20, 5, utf8_decode($co[0]['nomresponsable']), 0, 0);

        //Linea de membrete Nro 9
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(200, 41);
        $this->Cell(20, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(218, 41);
        $this->Cell(20, 5, utf8_decode($co[0]['cedresponsable']), 0, 0);

        //Linea de membrete Nro 10
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(254, 41);
        $this->Cell(20, 5, 'NUM. CELULAR :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(278, 41);
        $this->Cell(20, 5, utf8_decode($co[0]['celresponsable']), 0, 0);

        ################################# BLOQUE N� 3 #######################################


        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(15, 47);
        $this->Cell(20, 5, 'DATOS DEL PROVEEDOR', 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 51);
        $this->Cell(20, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(42, 51);
        $this->Cell(20, 5, utf8_decode($co[0]['rucproveedor']), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(76, 51);
        $this->Cell(70, 5, 'RAZON SOCIAL :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(108, 51);
        $this->Cell(75, 5, utf8_decode($co[0]['nomproveedor']), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(172, 51);
        $this->Cell(90, 5, 'EMAIL :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(186, 51);
        $this->Cell(90, 5, utf8_decode($co[0]['emailproveedor']), 0, 0);

        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(256, 51);
        $this->Cell(20, 5, 'VENDEDOR :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(276, 51);
        $this->Cell(20, 5, utf8_decode($co[0]['contactoproveedor']), 0, 0);

        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 55);
        $this->Cell(20, 5, 'TELEFONO :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(42, 55);
        $this->Cell(20, 5, utf8_decode($co[0]['tlfproveedor']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(90, 55);
        $this->Cell(20, 5, 'DIRECCION :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(116, 55);
        $this->Cell(20, 5, utf8_decode($co[0]['direcproveedor']), 0, 0);

        $this->Ln(8);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
        $this->Cell(8, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(16, 8, 'CODIGO', 1, 0, 'C', true);
        $this->Cell(20, 8, 'LOTE', 1, 0, 'C', true);
        $this->Cell(18, 8, 'F.VCTO', 1, 0, 'C', true);
        $this->Cell(140, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->Cell(12, 8, 'CANT', 1, 0, 'C', true);
        //$this->Cell(65,8,'UNIDAD DE MEDIDA',1,0,'C', True);
        $this->Cell(12, 8, 'IVA', 1, 0, 'C', true);
        $this->Cell(25, 8, 'PRECIO UNIT', 1, 0, 'C', true);
        $this->Cell(25, 8, 'VALOR TOTAL', 1, 0, 'C', true);
        $this->Cell(16, 8, '% DCTO', 1, 0, 'C', true);
        $this->Cell(18, 8, 'DCTO/BON', 1, 0, 'C', true);
        $this->Cell(25, 8, 'VALOR NETO', 1, 1, 'C', true);

        ########################### BLOQUE N� 4 DE DETALLES DE PRODUCTOS ###########################
        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 73, 335, 82, '1.5', '');

        $this->Ln(3);
        $tra = new Login();
        $reg = $tra->VerDetallesCompras();
        $cantidad = 0;
        $bonificacion = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $cantidad += $reg[$i]['cantcompra'];
            $bonificacion += $reg[$i]['cantbonif'];
              //$valortotal = $reg[$i]["preciocomprac"]*$reg[$i]["cantcompra"];
            $valortotal = $reg[$i]["precioventaunidadc"] * $reg[$i]["cantcompra"];
           
            /*
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
            */


            $descuento = $reg[$i]['descproductoc'] / 100;
            $DescBonif = $valortotal * $descuento;
            $valorNeto = $valortotal - $descuento - $DescBonif;

            $this->SetFont('Courier', '', 8);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(8, 4, $a++, 0, 0, 'C');
            $this->CellFitSpace(16, 4, utf8_decode($reg[$i]["codproductoc"]), 0, 0, 'C');
            $this->CellFitSpace(20, 4, utf8_decode($reg[$i]["lote"]), 0, 0, 'C');
            $this->CellFitSpace(18, 4, utf8_decode($reg[$i]["fechaexpiracionc"]), 0, 0, 'C');
            $this->CellFitSpace(140, 4, utf8_decode(getSubString($reg[$i]["productoc"]." ".$reg[$i]["nommedida"]." ".$reg[$i]["nompresentacion"], 90)), 0, 0, 'C');

            if($reg[$i]["cantbonif"] == "0") {
                $this->CellFitSpace(12, 4, utf8_decode($reg[$i]["cantcompra"]), 0, 0, 'C');
            } else {
                $this->CellFitSpace(12, 4, utf8_decode($reg[$i]["cantcompra"]."+".$reg[$i]["cantbonif"]), 0, 0, 'C');
            }


            //$this->Cell(65,4,utf8_decode($reg[$i]["nommedida"]),0,0,'C');
            $this->CellFitSpace(12, 4, utf8_decode($reg[$i]["ivaproductoc"]), 0, 0, 'C');
            $this->CellFitSpace(25, 4, utf8_decode($co[0]['simbolo'].number_format($reg[$i]["precioventaunidadc"], 2, '.', ',')), 0, 0, 'C');
            $this->CellFitSpace(25, 4, utf8_decode($co[0]['simbolo'].number_format($valortotal, 2, '.', ',')), 0, 0, 'C');
            $this->Cell(16, 4, utf8_decode($co[0]['simbolo'].$reg[$i]["totaldescuentoc"]), 0, 0, 'C');
            $this->CellFitSpace(18, 4, utf8_decode($co[0]['simbolo'].$reg[$i]["descbonific"]), 0, 0, 'C');
            //$this->CellFitSpace(25,4,utf8_decode($co[0]['simbolo'].number_format($reg[$i]["valorneto"], 2, '.', ',')),0,0,'C');
            $this->CellFitSpace(25, 4, utf8_decode($co[0]['simbolo'].number_format($valorNeto, 2, '.', ',')), 0, 0, 'C');
            $this->Ln();
        }

        ########################### BLOQUE N� 5 DE TOTALES #############################
        //Bloque de Informacion adicional
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 159, 245, 34, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 12);
        $this->SetXY(115, 160);
        $this->Cell(20, 5, 'INFORMACION ADICIONAL', 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 164);
        $this->Cell(20, 5, 'CANTIDAD DE COMPRA :', 0, 0);
        $this->SetXY(64, 164);
        $this->SetFont('Courier', '', 10);
        $this->Cell(20, 5, utf8_decode($cantidad), 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 169);
        $this->Cell(20, 5, 'CANTIDAD DE BONIFICION :', 0, 0);
        $this->SetXY(64, 169);
        $this->SetFont('Courier', '', 10);
        $this->Cell(20, 5, utf8_decode($bonificacion), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 173);
        $this->Cell(20, 5, 'TIPO DE DOCUMENTO :', 0, 0);
        $this->SetXY(64, 173);
        $this->SetFont('Courier', '', 10);
        $this->Cell(20, 5, utf8_decode("FACTURA"), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 177);
        $this->Cell(20, 5, 'TIPO DE PAGO :', 0, 0);
        $this->SetXY(64, 177);
        $this->SetFont('Courier', '', 10);
        $this->Cell(20, 5, utf8_decode($co[0]['tipocompra']." - ".$variable = ($co[0]['tipocompra'] == 'CONTADO' ? $co[0]['mediopago'] : $co[0]['formacompra'])), 0, 0);

        if($co[0]['tipocompra'] == "CREDITO") {

            //Linea de membrete Nro 5
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(120, 177);
            $this->Cell(20, 5, 'FECHA DE VENCIMIENTO :', 0, 0);
            $this->SetXY(168, 177);
            $this->SetFont('Courier', '', 10);
            $this->Cell(20, 5, utf8_decode($vence = ($co[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y", strtotime($co[0]['fechavencecredito'])))), 0, 0);

            //Linea de membrete Nro 6
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(200, 177);
            $this->Cell(20, 5, 'DIAS VENCIDOS :', 0, 0);
            $this->SetXY(234, 177);
            $this->SetFont('Courier', '', 10);

            if($co[0]['fechavencecredito'] == '0000-00-00') {
                $this->Cell(20, 5, utf8_decode("0"), 0, 0);
            } elseif($co[0]['fechavencecredito'] >= date("Y-m-d")) {
                $this->Cell(20, 5, utf8_decode("0"), 0, 0);
            } elseif($co[0]['fechavencecredito'] < date("Y-m-d")) {
                $this->Cell(20, 5, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $co[0]['fechavencecredito'])), 0, 0);
            }
        }

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 182);
        $this->Cell(20, 5, 'DESCRIPCION DE PAGO :', 0, 0);
        $this->SetXY(64, 182);
        $this->SetFont('Courier', 'B', 12);
        $this->Cell(20, 5, utf8_decode(numtoletras($co[0]["totalc"])), 0, 0);


        //Bloque de Totales de factura
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(257, 159, 88, 34, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 160);
        $this->Cell(20, 5, '% DESCUENTO:', 0, 0);
        $this->SetXY(318, 160);
        $this->SetFont('Courier', '', 9);
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format($co[0]["descuentoc"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 164);
        $this->Cell(20, 5, 'DCTO BONIF:', 0, 0);
        $this->SetXY(318, 164);
        $this->SetFont('Courier', '', 9);
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format($co[0]["descbonific"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 168);
        $this->Cell(20, 5, 'SUBTOTAL:', 0, 0);
        $this->SetXY(318, 168);
        $this->SetFont('Courier', '', 9);
        $subtotalLine = $co[0]['subtotalc'] - $co[0]["totalivac"];
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format( $subtotalLine, 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        /*
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 172);
        $this->Cell(20, 5, 'TOTAL CON IMPUESTOS:', 0, 0);
        $this->SetXY(318, 172);
        $this->SetFont('Courier', '', 9);
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format($co[0]["totalsinimpuestosc"], 2, '.', ',')), 0, 0, "R");
        */
        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 176);
        $this->Cell(20, 5, 'SUBTOTAL TARIFA 0%:', 0, 0);
        $this->SetXY(318, 176);
        $this->SetFont('Courier', '', 9);
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format($co[0]["tarifano"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 180);
        $this->Cell(20, 5, 'SUBTOTAL TARIFA '.$co[0]["ivac"].'%:', 0, 0);
        $this->SetXY(318, 180);
        $this->SetFont('Courier', '', 9);
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format($co[0]["tarifasi"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 184);
        $this->Cell(20, 5, 'IGV '.$co[0]["ivac"].'%:', 0, 0);
        $this->SetXY(318, 184);
        $this->SetFont('Courier', '', 9);
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format($co[0]["totalivac"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 188);
        $this->Cell(20, 5, 'TOTAL :', 0, 0);
        $this->SetXY(318, 188);
        $this->SetFont('Courier', '', 9);
        // calculo del total - el impuesto ya que los productos vienen con imp incluido
        //$totalLine = $co[0]['totalc'] - $co[0]["totalivac"];
        $totalLine = $co[0]['totalc'];
        
        $this->Cell(20, 5, utf8_decode($co[0]['simbolo'].number_format($totalLine, 2, '.', ',')), 0, 0, "R");
    }
    ################################# FUNCION FACTURA DE COMPRAS ################################


    ############################# FUNCION LISTAR COMPRAS POR PROVEEDORES ###############################
    public function TablaComprasProveedor()
    {

        $tra = new Login();
        $reg = $tra->BuscarComprasProveedor();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'COMPRAS DEL PROVEEDOR '.utf8_decode($reg[0]["nomproveedor"]), 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('Y SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'NUM. FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(32, 8, 'FECHA RECEPCION', 1, 0, 'C', true);
        $this->CellFitSpace(32, 8, 'FECHA EMISION', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'STATUS', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'VENC', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'ARTIC', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'DCTO', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'DCTO/BONIF', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'SUBTOTAL', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TARIFA 0%', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TARIFA CON %', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TOTAL IGV', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'TOTAL PAGO', 1, 1, 'C', true);

        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;
        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        for($i = 0;$i < sizeof($reg);$i++) {

            $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
            $TotalDescuento += $reg[$i]['descuentoc'];
            $TotalBonificiacion += $reg[$i]['descbonific'];
            $TotalSubtotal += $reg[$i]['subtotalc'];
            $TotalTarifano += $reg[$i]['tarifano'];
            $TotalTarifasi += $reg[$i]['tarifasi'];
            $Totaliva += $reg[$i]['totalivac'];
            $TotalPago += $reg[$i]['totalc'];

            $this->SetFont('Courier', '', 9);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(10, 6, $a++, 1, 0, 'C');
            $this->CellFitSpace(20, 6, $reg[$i]["codcompra"], 1, 0, 'C');
            $this->CellFitSpace(32, 6, utf8_decode($reg[$i]["fecharecepcion"]), 1, 0, 'C');
            $this->CellFitSpace(32, 6, utf8_decode($reg[$i]["fechaemision"]), 1, 0, 'C');

            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(25, 6, utf8_decode($reg[$i]['statuscompra']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(25, 6, utf8_decode($reg[$i]['statuscompra']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(25, 6, utf8_decode("VENCIDA"), 1, 0, 'C');
            }

            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->Cell(15, 6, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito'])), 1, 0, 'C');
            }

            $this->CellFitSpace(20, 6, utf8_decode($cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2'])), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['descuentoc'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['descbonific'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['subtotalc'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifano'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifasi'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(30, 6, utf8_decode($simbolo.number_format($reg[$i]['totalc'], 2, '.', ',')), 1, 0, 'C');
            $this->Ln();
        }

        $this->Cell(10, 5, '', 0, 0, 'C');
        $this->Cell(20, 5, '', 0, 0, 'C');
        $this->Cell(32, 5, '', 0, 0, 'C');
        $this->Cell(32, 5, '', 0, 0, 'C');
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(40, 5, 'TOTAL GENERAL', 1, 0, 'C', true);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(20, 5, utf8_decode($TotalArticulos), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalBonificiacion, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalTarifano, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalTarifasi, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($Totaliva, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode($simbolo.number_format($TotalPago, 2, '.', ',')), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################# FUNCION LISTAR COMPRAS POR PROVEEDORES ###############################


    ############################# FUNCION LISTAR COMPRAS POR FECHAS ###############################
    public function TablaComprasFechas()
    {

        $tra = new Login();
        $reg = $tra->BuscarComprasFechas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'COMPRAS POR FECHAS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"], 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('Y SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);


        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'NUM. FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(40, 8, 'PROVEEDOR', 1, 0, 'C', true);
        $this->CellFitSpace(32, 8, 'FECHA RECEPCION', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'STATUS', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'VENC', 1, 0, 'C', true);
        $this->CellFitSpace(17, 8, 'ARTIC', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'DCTO', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'DCTO/BONIF', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'SUBTOTAL', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TARIFA 0%', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TARIFA CON %', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TOTAL IGV', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'TOTAL PAGO', 1, 1, 'C', true);

        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;
        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        for($i = 0;$i < sizeof($reg);$i++) {

            $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
            $TotalDescuento += $reg[$i]['descuentoc'];
            $TotalBonificiacion += $reg[$i]['descbonific'];
            $TotalSubtotal += $reg[$i]['subtotalc'];
            $TotalTarifano += $reg[$i]['tarifano'];
            $TotalTarifasi += $reg[$i]['tarifasi'];
            $Totaliva += $reg[$i]['totalivac'];
            $TotalPago += $reg[$i]['totalc'];

            $this->SetFont('Courier', '', 9);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(10, 6, $a++, 1, 0, 'C');
            $this->CellFitSpace(20, 6, $reg[$i]["codcompra"], 1, 0, 'C');
            $this->CellFitSpace(40, 6, utf8_decode($reg[$i]["nomproveedor"]), 1, 0, 'C');
            $this->CellFitSpace(32, 6, utf8_decode($reg[$i]["fecharecepcion"]), 1, 0, 'C');

            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statuscompra']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statuscompra']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(22, 6, utf8_decode("VENCIDA"), 1, 0, 'C');
            }

            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->Cell(15, 6, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito'])), 1, 0, 'C');
            }

            $this->CellFitSpace(17, 6, utf8_decode($cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2'])), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['descuentoc'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['descbonific'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['subtotalc'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifano'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifasi'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(30, 6, utf8_decode($simbolo.number_format($reg[$i]['totalc'], 2, '.', ',')), 1, 0, 'C');
            $this->Ln();
        }

        $this->Cell(10, 5, '', 0, 0, 'C');
        $this->Cell(20, 5, '', 0, 0, 'C');
        $this->Cell(40, 5, '', 0, 0, 'C');
        $this->Cell(32, 5, '', 0, 0, 'C');
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(37, 5, 'TOTAL GENERAL', 1, 0, 'C', true);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(17, 5, utf8_decode($TotalArticulos), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalBonificiacion, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalTarifano, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalTarifasi, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($Totaliva, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode($simbolo.number_format($TotalPago, 2, '.', ',')), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################# FUNCION LISTAR COMPRAS POR FECHAS ###############################

    ############################### FUNCION LISTAR COMPRAS POR PAGAR ################################
    public function TablaComprasxPagar()
    {

        $tra = new Login();
        $reg = $tra->BuscarComprasxPagar();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'LISTADO DE COMPRAS POR PAGAR', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('DE SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);


        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }


        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'NUM.  FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(58, 8, 'PROVEEDOR', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'STATUS', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'VENC', 1, 0, 'C', true);
        $this->CellFitSpace(35, 8, 'FECHA RECEPCION', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'ARTIC', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'DCTO', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'DCTO/BONIF', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'SUBTOTAL', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'TARIFA 0%', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'TARIFA CON %', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TOTAL IVA', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'TOTAL PAGO', 1, 1, 'C', true);

        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;
        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {

                $TotalArticulos += $reg[$i]['articulos'];
                $TotalDescuento += $reg[$i]['descuentoc'];
                $TotalBonificiacion += $reg[$i]['descbonific'];
                $TotalSubtotal += $reg[$i]['subtotalc'];
                $TotalTarifano += $reg[$i]['tarifano'];
                $TotalTarifasi += $reg[$i]['tarifasi'];
                $Totaliva += $reg[$i]['totalivac'];
                $TotalPago += $reg[$i]['totalc'];

                $this->SetFont('Courier', '', 9);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(20, 6, $reg[$i]["codcompra"], 1, 0, 'C');
                $this->CellFitSpace(58, 6, utf8_decode($reg[$i]["nomproveedor"]), 1, 0, 'C');

                if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                    $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statuscompra']), 1, 0, 'C');
                } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                    $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statuscompra']), 1, 0, 'C');
                } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                    $this->CellFitSpace(22, 6, utf8_decode("VENCIDA"), 1, 0, 'C');
                }

                if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                    $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
                } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                    $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
                } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                    $this->Cell(15, 6, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito'])), 1, 0, 'C');
                }

                $this->CellFitSpace(35, 6, utf8_decode(date("d-m-Y", strtotime($reg[$i]['fecharecepcion']))), 1, 0, 'C');
                $this->CellFitSpace(18, 6, utf8_decode($reg[$i]["articulos"]), 1, 0, 'C');
                $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]['descuentoc'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['descbonific'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['subtotalc'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(22, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifano'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(22, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifasi'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')), 1, 0, 'C');
                $this->CellFitSpace(30, 6, utf8_decode($simbolo.number_format($reg[$i]['totalc'], 2, '.', ',')), 1, 0, 'C');
                $this->Ln();
            }
        }

        $this->Cell(10, 5, '', 0, 0, 'C');
        $this->Cell(20, 5, '', 0, 0, 'C');
        $this->Cell(58, 5, '', 0, 0, 'C');
        $this->Cell(22, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 5, 'TOTAL GENERAL', 1, 0, 'C', true);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(18, 5, utf8_decode($TotalArticulos), 1, 0, 'C');
        $this->Cell(18, 5, utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalBonificiacion, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(22, 5, utf8_decode($simbolo.number_format($TotalTarifano, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(22, 5, utf8_decode($simbolo.number_format($TotalTarifasi, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($Totaliva, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode($simbolo.number_format($TotalPago, 2, '.', ',')), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################### FUNCION LISTAR COMPRAS POR PAGAR ################################

    ################################## CLASE COMPRAS DE PRODUCTOS #################################










































    ################################## CLASE VENTAS DE PRODUCTOS #####################################

































    ################################# FUNCION GUIA DE REMISION ################################
    public function TablaGuiaRemision()
    {

        $tra = new Login();
        $chof = $tra->TransporteActivoPorId();

        $ve = new Login();
        $ve = $ve->VentasPorId();
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $ve[0]['simbolo'] : $_SESSION["simbolo"]);

        ######################### BLOQUE N� 1 #########################

        //Bloque de membrete principal
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 10, 245, 24, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(12, 12);
        $this->Cell(20, 5, utf8_decode($ve[0]['razonsocial']), 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 16);
        $this->Cell(20, 5, 'DIREC. MATRIZ :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(47, 16);
        $this->Cell(20, 5, utf8_decode($ve[0]['direcsucursal']), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 20);
        $this->Cell(20, 5, 'DIREC. SUCURSAL :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(52, 20);
        $this->Cell(20, 5, utf8_decode($ve[0]['direcsucursal']), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 24);
        $this->Cell(20, 5, 'CONTRIBUYENTE ESPECIAL :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(65, 24);
        $this->Cell(20, 5, utf8_decode($ve[0]['direcsucursal']), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 28);
        $this->Cell(20, 5, 'OBLIGADO A LLEVAR CONTABILIDAD :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(82, 28);
        $this->Cell(20, 5, utf8_decode($ve[0]['llevacontabilidad']), 0, 0);

        ############################### BLOQUE N� 2 #####################################

        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 36, 245, 24, '1.5', '');

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 37);
        $this->Cell(20, 5, 'IDENTIF (TRANSPORTISTA) :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(78, 37);
        $this->Cell(20, 5, utf8_decode($chof[0]['rucchofer']), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 41);
        $this->Cell(90, 5, 'RAZON SOC / NOMBRE Y APELLIDOS :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(78, 41);
        $this->Cell(90, 5, utf8_decode($chof[0]['nomchofer']), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 45);
        $this->Cell(90, 5, 'PLACA :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(78, 45);
        $this->Cell(90, 5, utf8_decode($chof[0]['placavehiculo']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(178, 45);
        $this->Cell(20, 5, 'NUM. DE BULTOS :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(210, 45);
        $this->Cell(20, 5, utf8_decode($chof[0]['numbultos']), 0, 0);

        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 49);
        $this->Cell(20, 5, 'PUNTO DE PARTIDA :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(78, 49);
        $this->Cell(20, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0);

        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 53);
        $this->Cell(20, 5, 'FECHA INICIO TRANSPORTE :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(78, 53);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y", strtotime($chof[0]['iniciotransporte']))), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(178, 53);
        $this->Cell(20, 5, 'FECHA FIN TRANSPORTE :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(220, 53);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y", strtotime($chof[0]['fintransporte']))), 0, 0);

        ################################# BLOQUE N� 3 #######################################


        //Bloque de datos de factura
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 62, 245, 27, '1.5', '');

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 63);
        $this->Cell(20, 5, 'COMPROBANTE DE VENTA :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(78, 63);
        $this->Cell(20, 5, utf8_decode($ve[0]['tipodocumento']." ".$ve[0]['codventa']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(178, 63);
        $this->Cell(20, 5, 'FECHA EMISION :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(210, 63);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y")), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 67);
        $this->Cell(70, 5, 'NUM. DE AUTORIZACION :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(78, 67);
        $this->Cell(75, 5, utf8_decode($ve[0]['codautorizacion']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(178, 67);
        $this->Cell(20, 5, 'RUTA :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(192, 67);
        $this->Cell(20, 5, utf8_decode($chof[0]['ruta']), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 71);
        $this->Cell(90, 5, 'MOTIVO DE TRASLADO :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(78, 71);
        $this->Cell(90, 5, utf8_decode($chof[0]['motivotraslado']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(178, 71);
        $this->Cell(20, 5, 'CIUDAD :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(192, 71);
        $this->Cell(20, 5, utf8_decode($chof[0]['ciudadruta']), 0, 0);

        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 75);
        $this->Cell(20, 5, 'RAZON SOC / NOMBRE Y APELLIDOS :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(78, 75);
        $this->Cell(20, 5, utf8_decode($ve[0]['nomresponsable']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(178, 75);
        $this->Cell(20, 5, 'IDENTIF. (DESTINATARIO) :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(227, 75);
        $this->Cell(20, 5, utf8_decode($ve[0]['cedresponsable']), 0, 0);

        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 79);
        $this->Cell(20, 5, 'ESTABLECIMIENTO :', 0, 0);
        $this->SetFont('Courier', '', 9);
        $this->SetXY(78, 79);
        $this->Cell(20, 5, utf8_decode(""), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(12, 83);
        $this->Cell(20, 5, 'DESTINO (PUNTO DE LLEGADA) :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(78, 83);
        $this->Cell(20, 5, utf8_decode($chof[0]['llegada']), 0, 0);


        ################################# BLOQUE N� 4 #######################################

        //Bloque de membrete principal
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(257, 10, 88, 79, '1.5', '');

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(258, 16);
        $this->Cell(20, 5, 'RUC :', 0, 0);
        $this->SetFont('Courier', '', 14);
        $this->SetXY(275, 16);
        $this->Cell(20, 5, utf8_decode($_SESSION['rucsucursal']), 0, 0);

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 18);
        $this->SetXY(258, 28);
        $this->Cell(20, 5, "GUIA DE REMISION", 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(258, 38);
        $this->Cell(20, 5, 'NUM.:', 0, 0);
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(268, 38);
        $this->Cell(20, 5, utf8_decode($ve[0]['codventa']), 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(258, 48);
        $this->Cell(20, 5, 'AMBIENTE:', 0, 0);
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(286, 48);
        $this->Cell(20, 5, "PRODUCCION", 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(258, 54);
        $this->Cell(20, 5, 'EMISION:', 0, 0);
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(286, 54);
        $this->Cell(20, 5, utf8_decode("NORMAL"), 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(258, 66);
        $this->Cell(20, 5, 'CLAVE ACCESO - NUM. DE AUTORIZ:', 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 14);
        $this->SetXY(258, 76);
        $this->Codabar(260, 75, utf8_decode($ve[0]['codautorizacion']));
        $this->Ln(8);

        $this->Ln(8);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
        $this->Cell(20, 8, 'NUM.', 1, 0, 'C', true);
        $this->Cell(30, 8, 'CODIGO', 1, 0, 'C', true);
        $this->Cell(200, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->Cell(20, 8, 'CANTIDAD', 1, 0, 'C', true);
        $this->Cell(30, 8, 'LOTE', 1, 0, 'C', true);
        $this->Cell(34, 8, 'TIPO', 1, 1, 'C', true);

        ########################### BLOQUE N� 4 DE DETALLES DE PRODUCTOS ###########################


        $tra = new Login();
        $reg = $tra->VerDetallesVentas();
        $cantidad = 0;
        $bonificacion = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $cantidad += $reg[$i]['cantventa'];
            $bonificacion += $reg[$i]['cantbonificv'];

            $tasa = $ve[0]["totalpago"] * $ve[0]["intereses"] / 100;

            $this->SetFont('Courier', '', 8);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(20, 4, $a++, 1, 0, 'C');
            $this->CellFitSpace(30, 4, utf8_decode($reg[$i]["codproductov"]), 1, 0, 'C');
            $this->CellFitSpace(200, 4, utf8_decode($reg[$i]["productov"]), 1, 0, 'C');
            if($reg[$i]["cantbonificv"] == "0") {
                $this->CellFitSpace(20, 4, utf8_decode($reg[$i]["cantventa"]), 1, 0, 'C');
            } else {
                $this->CellFitSpace(20, 4, utf8_decode($reg[$i]["cantventa"]."+".$reg[$i]["cantbonificv"]), 1, 0, 'C');
            }
            $this->CellFitSpace(30, 4, utf8_decode($reg[$i]["loteproducto"]), 1, 0, 'C');
            $this->CellFitSpace(34, 4, utf8_decode($reg[$i]["nompresentacion"]), 1, 0, 'C');
            $this->Ln();
        }

        $this->Ln(6);
        $this->SetFont('Courier', 'B', 14);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(80, 6, 'OBSERVACION:__________________________________________________________________________________________________', 0, 0, '');
        $this->Ln();

    }
    ################################# FUNCION GUIA DE REMISION ################################

























    ################################# FUNCION FACTURA DE VENTAS ################################
    public function TablaFacturaVenta2()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
            //$this->Image($logo , 25 ,11, 65 , 18 , "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                //$this->Image($logo , 25 ,11, 65 , 18 , "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            //$this->Image($logo , 25 ,11, 65 , 18 , "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        //Movernos a la derecha

        $ve = new Login();
        $ve = $ve->VentasPorId();
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $ve[0]['simbolo'] : $_SESSION["simbolo"]);

        ######################### BLOQUE N� 1 #########################


        //CHRISTIAN
        //Bloque de membrete principal
        //$this->SetFillColor(192);
        //$this->SetDrawColor(3,3,3);
        //$this->SetLineWidth(.3);
        //$this->RoundedRect(10, 10, 335, 20, '1.5', '');

        //Bloque de membrete principal
        //$this->SetFillColor(199);
        //$this->SetDrawColor(3,3,3);
        //$this->SetLineWidth(.3);
        //$this->RoundedRect(164, 13, 13, 13, '1.5', 'F');

        //Bloque de membrete principal
        //$this->SetFillColor(199);
        //$this->SetDrawColor(3,3,3);
        //$this->SetLineWidth(.3);
        //$this->RoundedRect(164, 13, 13, 13, '1.5', '');

        //Linea de membrete Centro
        //$this->SetFont('Courier','B',16);
        //$this->SetXY(168, 14);
        //$this->Cell(20, 5, 'V', 0 , 0);
        //$this->SetFont('Courier','B',8);
        //$this->SetXY(165, 19);
        //$this->Cell(20, 5, 'Venta', 0 , 0);

        //Linea de membrete Nro 1
        //$this->SetFont('Courier','B',10);
        //$this->SetXY(280, 12);
        //$this->Cell(20, 5, 'N� VENTA ', 0 , 0);
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(307, 12);
        //$this->Cell(20, 5,utf8_decode($ve[0]['codventa']), 0 , 0);

        //Linea de membrete Nro 2
        //$this->SetFont('Courier','B',10);
        //$this->SetXY(280, 16);
        //$this->Cell(20, 5, 'N� SERIE ', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(320, 16);
        //$this->Cell(20, 5,utf8_decode($ve[0]['codserie']), 0 , 0);

        //Linea de membrete Nro 3
        //$this->SetFont('Courier','B',10);
        //$this->SetXY(280, 20);
        //$this->Cell(20, 5, 'FECHA EMISI�N ', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(320, 20);
        //$this->Cell(20, 5,utf8_decode(date("d-m-Y",strtotime($ve[0]['fechaventa']))), 0 , 0);

        //Linea de membrete Nro 4
        //$this->SetFont('Courier','B',10);
        //$this->SetXY(280, 24);
        //$this->Cell(20, 5, 'STATUS VENTA', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(320, 24);

        //if($ve[0]['fechavencecredito']== '0000-00-00') {
        //$this->Cell(20, 5,utf8_decode($ve[0]['statusventa']), 0 , 0);
        //} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
        //$this->Cell(20, 5,utf8_decode($ve[0]['statusventa']), 0 , 0);
        //} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
        //$this->Cell(20, 5,utf8_decode("VENCIDA"), 0 , 0);
        //}

        ############################### BLOQUE N� 2 #####################################

        //Bloque de datos de empresa
        //$this->SetFillColor(192);
        //$this->SetDrawColor(3,3,3);
        //$this->SetLineWidth(.3);
        //$this->RoundedRect(10, 32, 335, 29, '1.5', '');

        //Linea de membrete Nro 1
        //$this->SetFont('Courier','B',10);
        //$this->SetXY(15, 33);
        //$this->Cell(20, 5, 'DATOS DE SUCURSAL ', 0 , 0);

        //Linea de membrete Nro 2
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(15, 37);
        //$this->Cell(20, 5, 'RAZ�N SOCIAL :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(42, 37);
        //$this->Cell(20, 5,utf8_decode($ve[0]['razonsocial']), 0 , 0);

        //Linea de membrete Nro 3
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(110, 37);
        //$this->Cell(90, 5, 'DNI/RUC :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(128, 37);
        //$this->Cell(90, 5,utf8_decode($ve[0]['rucsucursal']), 0 , 0);

        //Linea de membrete Nro 4
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(155, 37);
        //$this->Cell(90, 5, 'N� TEL�FONO :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(180, 37);
        //$this->Cell(90, 5,utf8_decode($ve[0]['tlfsucursal']), 0 , 0);

        //Linea de membrete Nro 5
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(200, 37);
        //$this->Cell(20, 5, 'N� CELULAR :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(224, 37);
        //$this->Cell(20, 5,utf8_decode($ve[0]['celsucursal']), 0 , 0);

        //Linea de membrete Nro 6
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(254, 37);
        //$this->Cell(20, 5, 'EMAIL :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(272, 37);
        //$this->Cell(20, 5,utf8_decode($ve[0]['emailsucursal']), 0 , 0);

        //Linea de membrete Nro 7
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(15, 41);
        //$this->Cell(20, 5, 'DIRECCI�N :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(38, 41);
        //$this->Cell(20, 5,utf8_decode($ve[0]['direcsucursal']), 0 , 0);

        //Linea de membrete Nro 8
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(112, 41);
        //$this->Cell(20, 5, 'RESPONSABLE :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(138, 41);
        //$this->Cell(20, 5,utf8_decode($ve[0]['nomresponsable']), 0 , 0);

        //Linea de membrete Nro 9
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(200, 41);
        //$this->Cell(20, 5, 'DNI/RUC :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(218, 41);
        //$this->Cell(20, 5,utf8_decode($ve[0]['cedresponsable']), 0 , 0);

        //Linea de membrete Nro 10
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(254, 41);
        //$this->Cell(20, 5, 'N� CELULAR :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(278, 41);
        //$this->Cell(20, 5,utf8_decode($ve[0]['celresponsable']), 0 , 0);

        ################################# BLOQUE N� 3 #######################################


        //Linea de membrete Nro 1
        //$this->SetFont('Courier','B',10);
        //$this->SetXY(15, 47);
        //$this->Cell(20, 5, 'DATOS DEL CLIENTE', 0 , 0);

        //Linea de membrete Nro 2
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(15, 51);
        //$this->Cell(20, 5, 'DNI/RUC :', 0 , 0);
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(120, 67);
        $this->Cell(20, 5, utf8_decode($ve[0]['cedcliente']), 0, 0);

        $this->SetFont('Courier', '', 8);
        $this->SetXY(20, 267);
        $this->Cell(65, 3, "Vendedor: ".utf8_decode($ve[0]['nombres']), 0, 1, 'C');

        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(48, 67);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y", strtotime($ve[0]['fechaventa']))), 0, 0);

        //Linea de membrete Nro 3
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(90, 51);
        //$this->Cell(70, 5, 'NOMBRES :', 0 , 0);
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(48, 61);
        $this->Cell(75, 5, utf8_decode($variable = ($ve[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $ve[0]['nomcliente'])), 0, 0);

        //Linea de membrete Nro 4
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(172, 51);
        //$this->Cell(90, 5, 'EMAIL :', 0 , 0);
        //$this->SetFont('Courier','',9);
        //$this->SetXY(10, 43);
        //$this->Cell(90, 5,utf8_decode($ve[0]['emailcliente']), 0 , 0);

        //Linea de membrete Nro 5
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(240, 51);
        //$this->Cell(20, 5, 'N� CELULAR :', 0 , 0);
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(120, 78);
        $this->Cell(20, 5, utf8_decode($ve[0]['celcliente']), 0, 0);
        $this->SetFont('ARIAL', '', 5);
        $this->SetXY(20, 241);
        $this->Cell(20, 5, utf8_decode($ve[0]['codventa']), 0, 0);


        //Linea de membrete Nro 6
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(15, 55);
        //$this->Cell(20, 5, 'N� TEL�FONO :', 0 , 0);
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(48, 78);
        $this->Cell(20, 5, utf8_decode($ve[0]['tlfcliente']), 0, 0);

        //Linea de membrete Nro 7
        //$this->SetFont('Courier','B',9);
        //$this->SetXY(90, 55);
        //$this->Cell(20, 5, 'DIRECCI�N :', 0 , 0);
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(48, 73);
        $this->Cell(20, 5, utf8_decode($ve[0]['direccliente']), 0, 0);


        $this->Ln(11);
        //$this->SetFont('Courier','B',9);

        //$this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
        //$this->Cell(8,8,'N�',1,0,'C', True);
        //$this->Cell(16,8,'C�DIGO',1,0,'C', True);
        //$this->Cell(12,8,'CANT',1,0,'C', True);
        //$this->Cell(20,8,'LOTE',1,0,'C', True);
        //$this->Cell(18,8,'F.VCTO',1,0,'C', True);
        //$this->Cell(107,8,'DESCRIPCI�N DE PRODUCTO',1,0,'C', True);
        //$this->Cell(12,8,'IVA',1,0,'C', True);
        //$this->Cell(12,8,'CANT',1,0,'C', True);
        //$this->Cell(18,8,'PVP',1,0,'C', True);
        //$this->Cell(22,8,'PRECIO UNIT',1,0,'C', True);
        //    $this->Cell(25,8,'VALOR TOTAL',1,0,'C', True);
        //    $this->Cell(14,8,'% DCTO',1,0,'C', True);
        //    $this->Cell(19,8,'DCTO/BON',1,0,'C', True);
        //    $this->Cell(19,8,'DCTO/PORC',1,0,'C', True);
        //$this->Cell(25,8,'VALOR NETO',1,1,'C', True);

        ########################### BLOQUE N� 4 DE DETALLES DE PRODUCTOS ###########################
        //Bloque de datos de empresa
        //    $this->SetFillColor(192);
        //    $this->SetDrawColor(3,3,3);
        //    $this->SetLineWidth(.3);
        //    $this->RoundedRect(10, 73, 335, 82, '1.5', '');

        $this->Ln(13);
        $tra = new Login();
        $reg = $tra->VerDetallesVentas();
        $cantidad = 0;
        $bonificacion = 0;
        $a = 1;

        for($i = 0;$i < sizeof($reg);$i++) {
            $cantidad += $reg[$i]['cantventa'];
            $bonificacion += $reg[$i]['cantbonificv'];

            $this->SetFont('arial', 'B', 9);
            if($reg[$i]["cantbonificv"] == "0") {
                $this->CellFitSpace(30, 1, utf8_decode($reg[$i]["cantventa"]), 0, 0, 'C');
            } else {
                $this->CellFitSpace(30, 1, utf8_decode($reg[$i]["cantventa"]."+".$reg[$i]["cantbonificv"]), 0, 0, 'C');
            }

            $this->SetTextColor(1, 1, 1);  // Establece el color del texto (en este caso es negro)

            //$this->Cell(8,4,$a++,0,0,'C');
            //$this->CellFitSpace(16,4,utf8_decode($reg[$i]["codproductov"]),0,0,'C');
            //$this->CellFitSpace(20,4,utf8_decode($reg[$i]["loteproducto"]),0,0,'C');
            //$this->CellFitSpace(18,4,utf8_decode($reg[$i]["fechaexpiracion"]),0,0,'C');
            $this->CellFitSpace(90, 1, utf8_decode(getSubString($reg[$i]["productov"]." - ".$reg[$i]["nommedida"]." / ".$ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"]), 90)), 0, 0, 'L');
            //$this->CellFitSpace(90,1,utf8_decode($reg[$i]["descproductov"]." - ".getSubString($reg[$i]["productov"]." - ".$reg[$i]["nommedida"], 90)),0,0,'L');
            //if($reg[$i]["ivaproductov"]=="NO") {
            //  $valiva=("N");
            //} else {
            //  $valiva=("s");
            //}
            $this->CellFitSpace(10, 1, utf8_decode($reg[$i]["ivaproductov"]), 0, 0, 'C');
            //$this->CellFitSpace(18,4,utf8_decode($simbolo.number_format($reg[$i]["precioventaunidadv"], 2, '.', ',')),0,0,'C');
            $this->CellFitSpace(40, 1, utf8_decode($simbolo.number_format($reg[$i]["valornetov"] / $reg[$i]["cantventa"], 2, '.', ',')), 0, 0, 'C');
            //$this->CellFitSpace(25,4,utf8_decode($simbolo.number_format($reg[$i]["valortotalv"], 2, '.', ',')),0,0,'C');
            //$this->Cell(14,4,utf8_decode($simbolo.$reg[$i]["descproductov"]),0,0,'C');
            //$this->CellFitSpace(19,4,utf8_decode($simbolo.$reg[$i]["descbonificv"]),0,0,'C');
            //$this->CellFitSpace(19,4,utf8_decode($simbolo.$reg[$i]["descporc"]),0,0,'C');
            $this->CellFitSpace(10, 3, utf8_decode($simbolo.number_format($reg[$i]["valornetov"], 2, '.', ',')), 0, 1, 'C');
            $this->Ln();
        }

        ########################### BLOQUE N� 5 DE TOTALES #############################
        //Bloque de Informacion adicional
        //    $this->SetFillColor(192);
        //    $this->SetDrawColor(3,3,3);
        //    $this->SetLineWidth(.3);
        //    $this->RoundedRect(10, 159, 245, 34, '1.5', '');

        //Linea de membrete Nro 1
        //    $this->SetFont('Courier','B',12);
        //    $this->SetXY(115, 160);
        //    $this->Cell(20, 5, 'INFORMACI�N ADICIONAL', 0 , 0);

        //Linea de membrete Nro 2
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 162);
        //    $this->Cell(20, 5, 'CANTIDAD DE VENTA :', 0 , 0);
        //    $this->SetXY(64, 162);
        //    $this->SetFont('Courier','',10);
        //    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);

        //Linea de membrete Nro 2
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 166);
        //    $this->Cell(20, 5, 'CANTIDAD DE BONIF :', 0 , 0);
        //    $this->SetXY(64, 166);
        //    $this->SetFont('Courier','',10);
        //    $this->Cell(20, 5,utf8_decode($bonificacion), 0 , 0);

        //Linea de membrete Nro 3
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 170);
        //    $this->Cell(20, 5, 'TIPO DE DOCUMENTO :', 0 , 0);
        //    $this->SetXY(64, 170);
        //    $this->SetFont('Courier','',10);
        //    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);


        //if($ve[0]['tipopagove']=="CONTADO"){

        //Linea de membrete Nro 4
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 174);
        //    $this->Cell(20, 5, 'TIPO DE PAGO :', 0 , 0);
        //    $this->SetXY(64, 174);
        //    $this->SetFont('Courier','',10);
        //    $this->Cell(20, 5,utf8_decode($ve[0]['tipopagove']." - ".$variable = ( $ve[0]['tipopagove'] == 'CONTADO' ? $ve[0]['mediopago'] : $ve[0]['formapagove'])), 0 , 0);

        //Linea de membrete Nro 4
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 178);
        //    $this->Cell(20, 5, 'EFECTIVO :', 0 , 0);
        //    $this->SetXY(64, 178);
        //    $this->SetFont('Courier','',10);
        //    $this->Cell(20, 5,utf8_decode(number_format($ve[0]["montopagado"], 2, '.', ',')), 0 , 0);


        //Linea de membrete Nro 4
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 182);
        //    $this->Cell(20, 5, 'CAMBIO :', 0 , 0);
        //    $this->SetXY(64, 182);
        //    $this->SetFont('Courier','',10);
        //    $this->Cell(20, 5,utf8_decode(number_format($ve[0]["montodevuelto"], 2, '.', ',')), 0 , 0);

        //Linea de membrete Nro 4
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 186);
        //    $this->Cell(20, 5, 'DESCRIPCI�N DE PAGO :', 0 , 0);
        //    $this->SetXY(64, 186);
        //    $this->SetFont('Courier','B',11);
        //    $this->Cell(20, 5,utf8_decode(numtoletras($ve[0]["totalpago"])), 0 , 0);

        //  } else {

        //Linea de membrete Nro 5
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 178);
        //    $this->Cell(20, 5, 'FECHA DE VENCIMIENTO :', 0 , 0);
        //    $this->SetXY(64, 178);
        //    $this->SetFont('Courier','',10);
        //    $this->Cell(20, 5,utf8_decode($vence = ( $ve[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($ve[0]['fechavencecredito'])))), 0 , 0);


        //Linea de membrete Nro 6
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 182);
        //    $this->Cell(20, 5, 'DIAS VENCIDOS :', 0 , 0);
        //    $this->SetXY(64, 182);
        //    $this->SetFont('Courier','',10);

        //    if($ve[0]['fechavencecredito']== '0000-00-00') {
        //    $this->Cell(20, 5,utf8_decode("0"), 0 , 0);
        //    } elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
        //    $this->Cell(20, 5,utf8_decode("0"), 0 , 0);
        //    } elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
        //    $this->Cell(20, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$ve[0]['fechavencecredito'])), 0 , 0);
        //    }

        //Linea de membrete Nro 4
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(12, 186);
        //    $this->Cell(20, 5, 'DESCRIPCI�N DE PAGO :', 0 , 0);
        //    $this->SetXY(64, 186);
        //    $this->SetFont('Courier','B',11);
        //    $this->Cell(20, 5,utf8_decode(numtoletras($ve[0]["totalpago"])), 0 , 0);
        //}


        //Linea de membrete Nro 5
        //    $this->SetFont('Courier','B',10);
        //    $this->SetXY(140, 176);
        //    $this->Cell(20, 5, '______________________', 0 , 0);
        //    $this->SetXY(155, 181);
        //    $this->Cell(20, 5, 'FIRMA AUTORIZADA', 0 , 0, 'C');

        //Linea de membrete Nro 6
        //    $this->SetXY(200, 176);
        //    $this->Cell(20, 5, '______________________', 0 , 0);
        //    $this->SetXY(215, 181);
        //    $this->Cell(20, 5, 'RECIBI CONFORME', 0 , 0, 'C');


        //Bloque de Totales de factura
        //    $this->SetFillColor(192);
        //    $this->SetDrawColor(3,3,3);
        //    $this->SetLineWidth(.3);
        //    $this->RoundedRect(257, 159, 88, 34, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('arial', 'B', 8);
        $this->SetXY(17, 238);
        $this->Cell(20, 5, '% DESCUENTO:', 0, 0);
        $this->SetXY(30, 238);
        $this->SetFont('arial', '', 8);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["descuentove"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('arial', 'B', 8);
        $this->SetXY(53, 238);
        $this->Cell(20, 5, 'DCTO BONIF:', 0, 0);
        $this->SetXY(63, 238);
        $this->SetFont('arial', '', 8);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["descbonificve"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        //    $this->SetFont('Courier','B',9);
        //    $this->SetXY(100, 168);
        //    $this->Cell(20, 5, 'SUBTOTAL:', 0 , 0);
        $this->SetLineWidth(.2);
        $this->SetXY(167, 253);
        $this->SetFont('arial', 'B', 9);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["tarifanove"] + $ve[0]["tarifasive"], 2, '.', ',')), 0, 0, "R");

        //$this->Cell(20, 5,utf8_decode($ve[0]['simbolo'].number_format($ve[0]["subtotalve"], 3, '.', ',')), 0 , 0, "R");

        //     //Linea de membrete Nro 1
        //    $this->SetFont('Courier','B',9);
        //    $this->SetXY(100, 172);
        //    $this->Cell(20, 5, 'TOTAL SIN IMPUESTOS:', 0 , 0);
        //    $this->SetXY(165, 172);
        //    $this->SetFont('Courier','',9);
        //    $this->Cell(20, 5,utf8_decode($ve[0]['simbolo'].number_format($ve[0]["totalsinimpuestosve"], 2, '.', ',')), 0 , 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('arial', 'B', 8);
        $this->SetXY(88, 238);
        $this->Cell(20, 5, 'SUBTOTAL TARIFA 0%:', 0, 0);
        $this->SetXY(112, 238);
        $this->SetFont('arial', '', 8);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["tarifanove"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(134, 238);
        $this->Cell(20, 5, 'SUBTOTAL TARIFA '.$ve[0]["ivave"].'%:', 0, 0);
        $this->SetXY(167, 238);
        $this->SetFont('arial', '', 8);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["tarifasive"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        //    $this->SetFont('Courier','B',9);
        //    $this->SetXY(100, 184);
        //    $this->Cell(20, 5, 'IVA '.$ve[0]["ivave"].'%:', 0 , 0);
        $this->SetXY(167, 262);
        $this->SetFont('arial', 'B', 9);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["totalivave"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        //    $this->SetFont('Courier','B',9);
        //    $this->SetXY(100, 188);
        //    $this->Cell(20, 5, 'TOTAL :', 0 , 0);
        $this->SetXY(167, 271);
        $this->SetFont('arial', 'B', 12);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
    }
    ################################# FUNCION FACTURA DE VENTAS ################################





















    ################################# FUNCION FACTURA DE VENTAS ################################
    public function TablaFacturaVenta()
    {
        //Logo
        if (isset($_SESSION['rucsucursal'])) {
            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 25, 11, 65, 18, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 25, 11, 65, 18, "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 25, 11, 65, 18, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        //Movernos a la derecha

        $ve = new Login();
        $ve = $ve->VentasPorId();
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $ve[0]['simbolo'] : $_SESSION["simbolo"]);

        ######################### BLOQUE N� 1 #########################

        //Bloque de membrete principal
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 10, 335, 20, '1.5', '');

        //Bloque de membrete principal
        $this->SetFillColor(199);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(164, 13, 13, 13, '1.5', 'F');

        //Bloque de membrete principal
        $this->SetFillColor(199);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(164, 13, 13, 13, '1.5', '');

        //Linea de membrete Centro
        $this->SetFont('Courier', 'B', 16);
        $this->SetXY(168, 14);
        $this->Cell(20, 5, 'V', 0, 0);
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(165, 19);
        $this->Cell(20, 5, 'Venta', 0, 0);

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 12);
        $this->Cell(20, 5, 'BOLETA NUM:', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(307, 12);
        $this->Cell(20, 5, utf8_decode($ve[0]['codventa']), 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 16);
        $this->Cell(20, 5, 'NO. SERIE ', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(320, 16);
        $this->Cell(20, 5, utf8_decode($ve[0]['codserie']), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 20);
        $this->Cell(20, 5, 'FECHA EMISION ', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(320, 20);
        $this->Cell(20, 5, utf8_decode(date("d-m-Y", strtotime($ve[0]['fechaventa']))), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(280, 24);
        $this->Cell(20, 5, 'STATUS VENTA', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(320, 24);

        if($ve[0]['fechavencecredito'] == '0000-00-00') {
            $this->Cell(20, 5, utf8_decode($ve[0]['statusventa']), 0, 0);
        } elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
            $this->Cell(20, 5, utf8_decode($ve[0]['statusventa']), 0, 0);
        } elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
            $this->Cell(20, 5, utf8_decode("VENCIDA"), 0, 0);
        }

        ############################### BLOQUE N� 2 #####################################

        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 32, 335, 29, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(15, 33);
        $this->Cell(20, 5, 'DATOS DE SUCURSAL ', 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 37);
        $this->Cell(20, 5, 'RAZON SOCIAL :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(42, 37);
        $this->Cell(20, 5, utf8_decode($ve[0]['razonsocial']), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(110, 37);
        $this->Cell(90, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(128, 37);
        $this->Cell(90, 5, utf8_decode($ve[0]['rucsucursal']), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(155, 37);
        $this->Cell(90, 5, 'NO. TELEFONO :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(180, 37);
        $this->Cell(90, 5, utf8_decode($ve[0]['tlfsucursal']), 0, 0);

        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(200, 37);
        $this->Cell(20, 5, 'NO. CELULAR :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(224, 37);
        $this->Cell(20, 5, utf8_decode($ve[0]['celsucursal']), 0, 0);

        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(254, 37);
        $this->Cell(20, 5, 'EMAIL :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(272, 37);
        $this->Cell(20, 5, utf8_decode($ve[0]['emailsucursal']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 41);
        $this->Cell(20, 5, 'DIRECCION :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(38, 41);
        $this->Cell(20, 5, utf8_decode($ve[0]['direcsucursal']), 0, 0);

        //Linea de membrete Nro 8
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(112, 41);
        $this->Cell(20, 5, 'RESPONSABLE :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(138, 41);
        $this->Cell(20, 5, utf8_decode($ve[0]['nomresponsable']), 0, 0);

        //Linea de membrete Nro 9
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(200, 41);
        $this->Cell(20, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(218, 41);
        $this->Cell(20, 5, utf8_decode($ve[0]['cedresponsable']), 0, 0);

        //Linea de membrete Nro 10
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(254, 41);
        $this->Cell(20, 5, 'NO. CELULAR :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(278, 41);
        $this->Cell(20, 5, utf8_decode($ve[0]['celresponsable']), 0, 0);

        ################################# BLOQUE N� 3 #######################################

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(15, 47);
        $this->Cell(20, 5, 'DATOS DEL CLIENTE', 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 51);
        $this->Cell(20, 5, 'DNI/RUC :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(42, 51);
        $this->Cell(20, 5, utf8_decode($ve[0]['cedcliente']), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(90, 51);
        $this->Cell(70, 5, 'NOMBRES :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(118, 51);
        $this->Cell(75, 5, utf8_decode($variable = ($ve[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $ve[0]['nomcliente'])), 0, 0);

        //Linea de membrete Nro 4
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(172, 51);
        $this->Cell(90, 5, 'EMAIL :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(186, 51);
        $this->Cell(90, 5, utf8_decode($ve[0]['emailcliente']), 0, 0);

        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(240, 51);
        $this->Cell(20, 5, 'NO. CELULAR :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(264, 51);
        $this->Cell(20, 5, utf8_decode($ve[0]['celcliente']), 0, 0);

        //Linea de membrete Nro 6
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(15, 55);
        $this->Cell(20, 5, 'NO. TELEFONO :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(42, 55);
        $this->Cell(20, 5, utf8_decode($ve[0]['tlfcliente']), 0, 0);

        //Linea de membrete Nro 7
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(90, 55);
        $this->Cell(20, 5, 'DIRECCION :', 0, 0);
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(116, 55);
        $this->Cell(20, 5, utf8_decode($ve[0]['direccliente']), 0, 0);

        $this->Ln(8);
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
        $this->Cell(8, 8, 'NO.', 1, 0, 'C', true);
        $this->Cell(16, 8, 'CODIGO', 1, 0, 'C', true);
        $this->Cell(20, 8, 'LOTE', 1, 0, 'C', true);
        $this->Cell(18, 8, 'F.VCTO', 1, 0, 'C', true);
        $this->Cell(87, 8, 'DESCRIPCION DE PRODUCTO', 1, 0, 'C', true);
        $this->Cell(30, 8, 'UBICACION', 1, 0, 'C', true);
        $this->Cell(12, 8, 'IGV', 1, 0, 'C', true);
        $this->Cell(12, 8, 'CANT', 1, 0, 'C', true);
        $this->Cell(16, 8, 'PVP', 1, 0, 'C', true);
        $this->Cell(22, 8, 'PRECIO UNIT', 1, 0, 'C', true);
        $this->Cell(22, 8, 'VAL. TOTAL', 1, 0, 'C', true);
        $this->Cell(14, 8, '% DCTO', 1, 0, 'C', true);
        $this->Cell(19, 8, 'DCTO/BON', 1, 0, 'C', true);
        $this->Cell(19, 8, 'DCTO/PORC', 1, 0, 'C', true);
        $this->Cell(20, 8, 'VAL. NETO', 1, 1, 'C', true);

        ########################### BLOQUE N� 4 DE DETALLES DE PRODUCTOS ###########################
        //Bloque de datos de empresa
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 73, 335, 82, '1.5', '');

        $this->Ln(3);
        $tra = new Login();
        $reg = $tra->VerDetallesVentas();
        $cantidad = 0;
        $bonificacion = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $cantidad += $reg[$i]['cantventa'];
            $bonificacion += $reg[$i]['cantbonificv'];

            $tasa = $ve[0]["totalpago"] * $ve[0]["intereses"] / 100;

            $this->SetFont('Courier', 'B', 8);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(8, 4, $a++, 0, 0, 'C');
            $this->CellFitSpace(16, 4, utf8_decode($reg[$i]["codproductov"]), 0, 0, 'C');
            $this->CellFitSpace(20, 4, utf8_decode($reg[$i]["loteproducto"]), 0, 0, 'C');
            $this->CellFitSpace(18, 4, utf8_decode($reg[$i]["fechaexpiracion"]), 0, 0, 'C');
            $this->CellFitSpace(87, 4, utf8_decode(getSubString($reg[$i]["productov"]." ".$reg[$i]["nommedida"]." ".$reg[$i]["nompresentacion"], 90)), 0, 0, 'C');
            $this->CellFitSpace(30, 4, utf8_decode($ubicacion = ($reg[$i]["ubicacion"] == '' ? "NINGUNA" : $reg[$i]["ubicacion"])), 0, 0, 'C');
            $this->CellFitSpace(12, 4, utf8_decode($reg[$i]["ivaproductov"]), 0, 0, 'C');

            if($reg[$i]["cantbonificv"] == "0") {
                $this->CellFitSpace(12, 4, utf8_decode($reg[$i]["cantventa"]), 0, 0, 'C');
            } else {
                $this->CellFitSpace(12, 4, utf8_decode($reg[$i]["cantventa"]."+".$reg[$i]["cantbonificv"]), 0, 0, 'C');
            }

            $this->CellFitSpace(16, 4, utf8_decode($simbolo.number_format($reg[$i]["precioventaunidadv"], 2, '.', ',')), 0, 0, 'C');

            $this->CellFitSpace(22, 4, utf8_decode($simbolo.number_format($reg[$i]["preciounitario"], 2, '.', ',')), 0, 0, 'C');

            $this->CellFitSpace(22, 4, utf8_decode($simbolo.number_format($reg[$i]["valortotalv"], 2, '.', ',')), 0, 0, 'C');
            $this->Cell(14, 4, utf8_decode($simbolo.$reg[$i]["descproductov"]), 0, 0, 'C');
            $this->CellFitSpace(19, 4, utf8_decode($simbolo.$reg[$i]["descbonificv"]), 0, 0, 'C');
            $this->CellFitSpace(19, 4, utf8_decode($simbolo.$reg[$i]["descporc"]), 0, 0, 'C');
            $this->CellFitSpace(20, 4, utf8_decode($simbolo.number_format($reg[$i]["valornetov"], 2, '.', ',')), 0, 0, 'C');
            $this->Ln();
        }

        ########################### BLOQUE N� 5 DE TOTALES #############################
        //Bloque de Informacion adicional
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(10, 159, 245, 34, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 12);
        $this->SetXY(115, 160);
        $this->Cell(20, 5, 'INFORMACION ADICIONAL', 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 162);
        $this->Cell(20, 5, 'CANTIDAD DE VENTA :', 0, 0);
        $this->SetXY(64, 162);
        $this->SetFont('Courier', 'B', 10);
        $this->Cell(20, 5, utf8_decode($cantidad), 0, 0);

        //Linea de membrete Nro 2
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 166);
        $this->Cell(20, 5, 'CANTIDAD DE BONIF :', 0, 0);
        $this->SetXY(64, 166);
        $this->SetFont('Courier', 'B', 10);
        $this->Cell(20, 5, utf8_decode($bonificacion), 0, 0);

        //Linea de membrete Nro 3
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(12, 170);
        $this->Cell(20, 5, 'TIPO DE DOCUMENTO :', 0, 0);
        $this->SetXY(64, 170);
        $this->SetFont('Courier', 'B', 10);
        $this->Cell(20, 5, utf8_decode("FACTURA"), 0, 0);


        if($ve[0]['tipopagove'] == "CONTADO") {

            //Linea de membrete Nro 4
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(12, 174);
            $this->Cell(20, 5, 'TIPO DE PAGO :', 0, 0);
            $this->SetXY(64, 174);
            $this->SetFont('Courier', 'B', 10);
            $this->Cell(20, 5, utf8_decode($ve[0]['tipopagove']." - ".$variable = ($ve[0]['tipopagove'] == 'CONTADO' ? $ve[0]['mediopago'] : $ve[0]['formapagove'])), 0, 0);

            //Linea de membrete Nro 4
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(12, 178);
            $this->Cell(20, 5, 'EFECTIVO :', 0, 0);
            $this->SetXY(64, 178);
            $this->SetFont('Courier', 'B', 10);
            $this->Cell(20, 5, utf8_decode(number_format($ve[0]["montopagado"], 2, '.', ',')), 0, 0);


            //Linea de membrete Nro 4
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(12, 182);
            $this->Cell(20, 5, 'CAMBIO :', 0, 0);
            $this->SetXY(64, 182);
            $this->SetFont('Courier', 'B', 10);
            $this->Cell(20, 5, utf8_decode(number_format($ve[0]["montodevuelto"], 2, '.', ',')), 0, 0);

            //Linea de membrete Nro 4
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(12, 186);
            $this->Cell(20, 5, 'DESCRIPCION DE PAGO :', 0, 0);
            $this->SetXY(64, 186);
            $this->SetFont('Courier', 'B', 11);
            $this->Cell(20, 5, utf8_decode(numtoletras($ve[0]["totalpago"] + $tasa)), 0, 0);

        } else {

            //Linea de membrete Nro 5
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(12, 178);
            $this->Cell(20, 5, 'FECHA DE VENCIMIENTO :', 0, 0);
            $this->SetXY(64, 178);
            $this->SetFont('Courier', 'B', 10);
            $this->Cell(20, 5, utf8_decode($vence = ($ve[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y", strtotime($ve[0]['fechavencecredito'])))), 0, 0);

            //Linea de membrete Nro 6
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(12, 182);
            $this->Cell(20, 5, 'DIAS VENCIDOS :', 0, 0);
            $this->SetXY(64, 182);
            $this->SetFont('Courier', 'B', 10);

            if($ve[0]['fechavencecredito'] == '0000-00-00') {
                $this->Cell(20, 5, utf8_decode("0"), 0, 0);
            } elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                $this->Cell(20, 5, utf8_decode("0"), 0, 0);
            } elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                $this->Cell(20, 5, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $ve[0]['fechavencecredito'])), 0, 0);
            }

            //Linea de membrete Nro 4
            $this->SetFont('Courier', 'B', 10);
            $this->SetXY(12, 186);
            $this->Cell(20, 5, 'DESCRIPCION DE PAGO :', 0, 0);
            $this->SetXY(64, 186);
            $this->SetFont('Courier', 'B', 11);
            $this->Cell(20, 5, utf8_decode(numtoletras($ve[0]["totalpago"] + $tasa)), 0, 0);
        }


        //Linea de membrete Nro 5
        $this->SetFont('Courier', 'B', 10);
        $this->SetXY(140, 176);
        $this->Cell(20, 5, '______________________', 0, 0);
        $this->SetXY(155, 181);
        $this->Cell(20, 5, 'FIRMA AUTORIZADA', 0, 0, 'C');

        //Linea de membrete Nro 6
        $this->SetXY(200, 176);
        $this->Cell(20, 5, '______________________', 0, 0);
        $this->SetXY(215, 181);
        $this->Cell(20, 5, 'RECIBI CONFORME', 0, 0, 'C');


        //Bloque de Totales de factura
        $this->SetFillColor(192);
        $this->SetDrawColor(3, 3, 3);
        $this->SetLineWidth(.3);
        $this->RoundedRect(257, 159, 88, 34, '1.5', '');

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 160);
        $this->Cell(20, 5, '% DESCUENTO:', 0, 0);
        $this->SetXY(318, 160);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["descuentove"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 164);
        $this->Cell(20, 5, 'DCTO BONIF:', 0, 0);
        $this->SetXY(318, 164);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["descbonificve"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        /*
         $this->SetFont('Courier','B',9);
         $this->SetXY(258, 168);
         $this->Cell(20, 5, 'SUBTOTAL:', 0 , 0);
         $this->SetXY(318, 168);
         $this->SetFont('Courier','',9);
         $this->Cell(20, 5,utf8_decode($ve[0]['simbolo'].number_format($ve[0]["subtotalve"], 2, '.', ',')), 0 , 0, "R");
*/
        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 172);
        $this->Cell(20, 5, 'SUBTOTAL:', 0, 0);
        $this->SetXY(318, 172);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["totalsinimpuestosve"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        /*
         $this->SetFont('Courier','B',9);
         $this->SetXY(258, 176);
         $this->Cell(20, 5, 'SUBTOTAL TARIFA 0%:', 0 , 0);
         $this->SetXY(318, 176);
         $this->SetFont('Courier','',9);
         $this->Cell(20, 5,utf8_decode($ve[0]['simbolo'].number_format($ve[0]["tarifanove"], 2, '.', ',')), 0 , 0, "R");
*/
        //Linea de membrete Nro 1
        /*
            $this->SetFont('Courier','B',9);
            $this->SetXY(258, 180);
            $this->Cell(20, 5, 'SUBTOTAL TARIFA '.$ve[0]["ivave"].'%:', 0 , 0);
            $this->SetXY(318, 180);
            $this->SetFont('Courier','',9);
            $this->Cell(20, 5,utf8_decode($ve[0]['simbolo'].number_format($ve[0]["tarifasive"], 2, '.', ',')), 0 , 0, "R");
        */
        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);

        $this->SetXY(258, 176);
        $this->Cell(20, 5, 'IGV '.$ve[0]["ivave"].'%:', 0, 0);
        $this->SetXY(318, 176);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["totalivave"], 2, '.', ',')), 0, 0, "R");

        //Linea de membrete Nro 1
        $this->SetFont('Courier', 'B', 9);
        $this->SetXY(258, 188);
        $this->Cell(20, 5, 'TOTAL :', 0, 0);
        $this->SetXY(318, 188);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(20, 5, utf8_decode($ve[0]['simbolo'].number_format($ve[0]["totalpago"] + $tasa, 2, '.', ',')), 0, 0, "R");
    }
    ################################# FUNCION FACTURA DE VENTAS ################################




















    ############################ FUNCION TICKET DE VENTAS DE PRODUCTOS ###########################
    public function TablaTicketProductos()
    {

        $con = new Login();
        $con = $con->ConfiguracionPorId();

        $ve = new Login();
        $ve = $ve->VentasPorId();
        $logo = "./assets/images/logo_white_2.png";
        $this->Image($logo, 25, -1, 33, 17, "PNG");
        $this->SetFont('Courier', 'B', 14);
        $this->SetFillColor(2, 157, 116);
        //$this->SetXY(13, 6);
        //$this->Cell(13, 5, "TICKET DE VENTA", 0 , 0);
        //$this->Ln(5);

        $this->SetFont('Courier', 'B', 8);
        $this->SetFillColor(2, 157, 116);
        $this->SetXY(4, 13);
        $this->CellFitSpace(65, 3, utf8_decode($ve[0]['razonsocial']), 0, 1, 'C');
        $this->SetFont('Courier', 'B', 6.5);
        $this->SetXY(4, 15);
        $this->CellFitSpace(65, 5, "DIRECCION:".utf8_decode($ve[0]['direcsucursal']), 0, 1, 'C');
        //$this->SetXY(4, 16);
        //$this->CellFitSpace(65,3,"OBLIGADO A LLEVAR CONTABILIDAD:".utf8_decode($ve[0]['llevacontabilidad']),0,1,'C');
        $this->SetXY(4, 19);
        $this->CellFitSpace(65, 3, "RUC:".utf8_decode($ve[0]['rucsucursal']), 0, 1, 'C');
        $this->SetXY(4, 22);
        $this->SetFont('Courier', 'B', 8);
        $this->CellFitSpace(65, 3, "TICKET DE VENTA NUM:".utf8_decode($ve[0]['codventa']), 0, 1, 'C');
        $this->SetXY(4, 25);
        //$this->CellFitSpace(65,3,"AMBIENTE: PRODUCCION",0,1,'C');
        //$this->SetXY(4, 28);
        //$this->CellFitSpace(65,3,"EMISION: NORMAL",0,1,'C');
        //$this->SetXY(4, 31);
        //$this->CellFitSpace(65,3,"CLAVE DE ACCESO - NO. DE AUTORIZACION",0,1,'C');
        //$this->SetXY(4, 34);
        //$this->CellFitSpace(65,3,utf8_decode($ve[0]['codautorizacion']),0,1,'C');
        //$this->Ln(2);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '--------------- CLIENTE ---------------', 0, 0, 'C');
        $this->Ln(3);

        if($ve[0]['codcliente'] == "") {

            $this->SetFont('Courier', 'B', 8);
            $this->SetX(4);
            $this->Cell(65, 3, "CONSUMIDOR FINAL", 0, 1, 'C');

        } else {

            $this->SetFont('Courier', 'B', 8);
            $this->SetX(4);
            $this->Cell(65, 3, utf8_decode($ve[0]['cedcliente']), 0, 1, 'C');
            $this->SetX(4);
            $this->Cell(65, 3, utf8_decode($ve[0]['nomcliente']), 0, 1, 'C');

        }
        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '---------------------------------------', 0, 1, 'C');

        $this->SetX(4);
        $this->Cell(65, 3, "FECHA EMISION: ".date("d/m/Y h:i:s A ", time() + 1800), 0, 1, 'C');

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '-------------- PRODUCTOS --------------', 0, 1, 'C');
        $this->Ln(1);

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 7);
        $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
        $this->Cell(12, 3, 'CANT', 0, 0, 'L');
        $this->Cell(42, 3, 'DESCRIPCION', 0, 0, 'C');
        $this->Cell(12, 3, 'IGV', 0, 1, 'C');

        $this->SetX(4);
        $this->Cell(15, 3, 'LABOR.', 0, 0, 'L');
        $this->Cell(18, 3, 'PVP.', 0, 0, 'C');
        $this->Cell(22, 3, 'DCTO.', 0, 0, 'C');
        $this->Cell(11, 3, 'TOTAL', 0, 1, 'C');

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '---------------------------------------', 0, 0, 'C');
        $this->Ln(3);

        $tra = new Login();
        $reg = $tra->VerDetallesVentas();
        $cantidad = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $tasa = $ve[0]["totalpago"] * $ve[0]["intereses"] / 100;

            $this->SetX(4);
            $this->SetFillColor(192);
            $this->SetDrawColor(3, 3, 3);
            $this->SetLineWidth(.2);
            $this->SetFont('Courier', 'B', 7);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->CellFitSpace(12, 3, utf8_decode($cantidad = ($reg[$i]['cantbonificv'] == '0' ? $reg[$i]['cantventa'] : $reg[$i]['cantventa']."+".$reg[$i]['cantbonificv'])), 0, 0, 'C');
            $this->CellFitSpace(42, 3, utf8_decode(getSubString($reg[$i]["productov"]." ".$reg[$i]["nommedida"], 22)), 0, 0, 'C');
            $this->CellFitSpace(12, 3, utf8_decode($iva = ($reg[$i]['ivaproductov'] == 'SI' ? "S" : "N")), 0, 1, 'C');
            $this->SetX(4);
            $this->CellFitSpace(15, 3, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 8)), 0, 0, 'C');
            $this->CellFitSpace(18, 3, utf8_decode($reg[$i]["preciounitario"]), 0, 0, 'C');
            $this->CellFitSpace(22, 3, utf8_decode($reg[$i]["descporc"]), 0, 0, 'C');
            $this->CellFitSpace(11, 3, utf8_decode($reg[$i]["valornetov"]), 0, 0, 'C');
            $this->Ln();
        }

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '---------------------------------------', 0, 0, 'C');
        $this->Ln(3);

        $this->SetFont('Courier', 'B', 7);
        $this->SetX(4);
        $this->CellFitSpace(50, 3, "SUBTOTAL:", 0, 0, 'R');
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format(($ve[0]["totalpago"] * 0.82), 2, '.', ',')), 0, 1, 'R');
        /*
            $this->SetX(4);
            $this->SetFont('Courier','B',7);
            $this->CellFitSpace(50,3,"SUBTOTAL EXENTO DE IVA:",0,0,'R');
            $this->SetFont('Courier','',7);
            $this->CellFitSpace(15,3,utf8_decode(number_format($ve[0]["tarifasive"], 2, '.', ',')),0,1,'R');

            $this->SetX(4);
            $this->SetFont('Courier','B',7);
            $this->CellFitSpace(50,3,"SUBTOTAL NO OBJETO DE IVA:",0,0,'R');
            $this->SetFont('Courier','',7);
            $this->CellFitSpace(15,3,utf8_decode(number_format($ve[0]["tarifanove"], 2, '.', ',')),0,1,'R');
        */
        $this->SetX(4);
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(50, 3, "DESCUENTO %:", 0, 0, 'R');
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["descuentove"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(50, 3, "DESCUENTO BONIFICACION:", 0, 0, 'R');
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["descbonificve"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(50, 3, "IGV ".$ve[0]["ivave"]."%:", 0, 0, 'R');
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["totalivave"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(50, 3, "TOTAL A PAGAR:", 0, 0, 'R');
        $this->SetFont('Courier', 'B', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["totalpago"] + $tasa, 2, '.', ',')), 0, 1, 'R');
        $this->Ln(1);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);

        $this->Cell(70, 3, '------- INFORMACION ADICIONAL -------', 0, 1, 'C');
        $this->Ln(1);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(4);
        $this->Cell(65, 3, "CAJERO: ".utf8_decode($ve[0]['nombres']), 0, 1, 'C');
        $this->Ln(3);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, 'FIRMA: ___________________________', 0, 1, 'C');
        $this->Ln(4);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '--------------- PAGO ----------------', 0, 1, 'C');
        $this->Ln(1);

        if($ve[0]['tipopagove'] == "CREDITO") {

            $this->SetFont('Courier', 'B', 8);
            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(65, 3, utf8_decode($ve[0]["tipopagove"]." - ".$variable = ($ve[0]['tipopagove'] == 'CONTADO' ? $ve[0]['mediopago'] : $ve[0]['formapagove'])), 0, 1, 'C');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "STATUS PAGO:", 0, 0, 'R');
            $this->SetFont('Courier', 'B', 8);
            if($ve[0]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(20, 3, utf8_decode($ve[0]["statusventa"]), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode($ve[0]["statusventa"]), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode("VENCIDA"), 0, 1, 'R');
            }

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "FECHA VENC:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(20, 3, utf8_decode($ve[0]["fechavencecredito"]), 0, 1, 'R');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "DIAS VENCIDOS:", 0, 0, 'R');
            $this->SetFont('Courier', 'B', 8);
            if($ve[0]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(20, 3, utf8_decode("0"), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode("0"), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $ve[0]['fechavencecredito'])), 0, 1, 'R');
            }

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "TOTAL ABONO:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(20, 3, utf8_decode(number_format($ve[0]["abonototal"], 2, '.', ',')), 0, 1, 'R');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "TOTAL DEBE:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(20, 3, utf8_decode(number_format($ve[0]["totalpago"] - $ve[0]["abonototal"], 2, '.', ',')), 0, 1, 'R');
            $this->Ln(1);


        } else {

            $this->SetFont('Courier', 'B', 8);
            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(65, 3, utf8_decode($ve[0]["tipopagove"]." - ".$ve[0]["mediopago"]), 0, 1, 'C');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(50, 3, "EFECTIVO:", 0, 0, 'R');
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["montopagado"], 2, '.', ',')), 0, 1, 'R');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(50, 3, "CAMBIO:", 0, 0, 'R');
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["montodevuelto"], 2, '.', ',')), 0, 1, 'R');
            $this->Ln(1);

        }

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 0.5, '-------------------------------------', 0, 1, 'C');
        $this->SetX(2);
        $this->Cell(70, 0.5, '-------------------------------------', 0, 1, 'C');
        $this->Ln(3);
        $this->CellFitSpace(50, 5, "Gracias por su compra....");
        //$this->SetXY(4, 94);
        //$this->Codabar(6,-90,utf8_decode("111111222222333333444444555555666666777777888888999999"));

    }
    ######################### FIN DE FUNCION TICKET DE VENTAS DE PRODUCTOS ############################



















    ############################ FUNCION TICKET DE VENTAS DE PRODUCTOS ###########################
    public function TablaTicketProductos2()
    {

        $ve = new Login();
        $ve = $ve->VentasPorId();

        $this->SetFont('helvetica', 'B', 14);
        $this->SetFillColor(2, 157, 116);
        //$this->SetXY(13, 6);
        //$this->Cell(13, 5, "TICKET DE VENTA", 0 , 0);
        //$this->Ln(5);

        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(2, 157, 116);
        $this->SetXY(4, 10);
        //$this->CellFitSpace(65,3,utf8_decode($ve[0]['razonsocial']),0,1,'C');
        $this->SetFont('times', 'B', 8);
        $this->SetXY(4, 13);
        //$this->CellFitSpace(65,3,"MATRIZ:".utf8_decode($ve[0]['direcsucursal']),0,1,'C');
        $this->SetXY(4, 16);
        //$this->CellFitSpace(65,3,"OBLIGADO A LLEVAR CONTABILIDAD:".utf8_decode($ve[0]['llevacontabilidad']),0,1,'C');
        $this->SetXY(4, 19);
        //$this->CellFitSpace(65,3,"RUC:".utf8_decode($ve[0]['rucsucursal']),0,1,'C');
        $this->SetXY(4, 22);
        //$this->CellFitSpace(65,3,"FACTURA:".utf8_decode($ve[0]['codventa']),0,1,'C');
        $this->SetXY(4, 25);
        //$this->CellFitSpace(65,3,"AMBIENTE: PRODUCCI�N",0,1,'C');
        $this->SetXY(4, 28);
        //$this->CellFitSpace(65,3,"EMISI�N: NORMAL",0,1,'C');
        $this->SetXY(4, 31);
        //$this->CellFitSpace(65,3,"CLAVE DE ACCESO - N� DE AUTORIZACI�N",0,1,'C');
        $this->SetXY(4, 34);
        //$this->CellFitSpace(65,3,utf8_decode($ve[0]['codautorizacion']),0,1,'C');
        $this->Ln(2);

        $this->SetX(3);
        $this->Cell(70, 5, '-------------- CLIENTE --------------', 0, 1, 'C');

        if($ve[0]['codcliente'] == "") {

            $this->SetFont('times', '', 8);
            $this->SetX(4);
            $this->Cell(65, 3, "CONSUMIDOR FINAL", 0, 1, 'C');

        } else {

            $this->SetFont('times', '', 8);
            $this->SetX(4);
            $this->Cell(65, 3, utf8_decode($ve[0]['cedcliente']), 0, 1, 'C');
            $this->SetX(4);
            $this->Cell(65, 3, utf8_decode($ve[0]['nomcliente']), 0, 1, 'C');

        }
        $this->SetFont('times', '', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '-------------------------------------', 0, 1, 'C');

        $this->SetX(4);
        $this->Cell(65, 3, "FECHA EMISION: ".date("d/m/Y h:i:s A ", time() + 1800), 0, 1, 'C');

        $this->SetX(2);
        $this->Cell(70, 3, '------------- PRODUCTOS -------------', 0, 1, 'C');
        $this->Ln(1);

        $this->SetX(4);
        $this->SetFont('times', 'B', 7);
        $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
        $this->Cell(12, 3, 'CANT', 0, 0, 'L');
        $this->Cell(42, 3, 'DESCRIPCION', 0, 0, 'C');
        $this->Cell(12, 3, 'IGV', 0, 1, 'C');

        $this->SetX(4);
        $this->Cell(15, 3, 'LABOR.', 0, 0, 'L');
        $this->Cell(18, 3, 'PVP.', 0, 0, 'C');
        $this->Cell(22, 3, 'DCTO.', 0, 0, 'C');
        $this->Cell(11, 3, 'TOTAL', 0, 1, 'C');

        $this->SetFont('times', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '-------------------------------------', 0, 0, 'C');
        $this->Ln(3);

        $tra = new Login();
        $reg = $tra->VerDetallesVentas();
        $cantidad = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $tasa = $ve[0]["totalpago"] * $ve[0]["intereses"] / 100;

            $this->SetX(4);
            $this->SetFillColor(192);
            $this->SetDrawColor(3, 3, 3);
            $this->SetLineWidth(.2);
            $this->SetFont('times', '', 7);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->CellFitSpace(12, 3, utf8_decode($cantidad = ($reg[$i]['cantbonificv'] == '0' ? $reg[$i]['cantventa'] : $reg[$i]['cantventa']."+".$reg[$i]['cantbonificv'])), 0, 0, 'C');
            $this->CellFitSpace(42, 3, utf8_decode(getSubString($reg[$i]["productov"]." ".$reg[$i]["nommedida"], 22)), 0, 0, 'C');
            $this->CellFitSpace(12, 3, utf8_decode($iva = ($reg[$i]['ivaproductov'] == 'SI' ? "S" : "N")), 0, 1, 'C');

            $this->SetX(4);
            $this->CellFitSpace(15, 3, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 8)), 0, 0, 'C');

            $this->CellFitSpace(18, 3, utf8_decode($reg[$i]["preciounitario"]), 0, 0, 'C');


            $this->CellFitSpace(22, 3, utf8_decode($reg[$i]["descporc"]), 0, 0, 'C');
            $this->CellFitSpace(11, 3, utf8_decode($reg[$i]["valornetov"]), 0, 0, 'C');
            $this->Ln();
        }

        $this->SetFont('times', 'B', 6);
        $this->SetX(2);
        $this->Cell(70, 3, '-------------------------------------', 0, 0, 'C');
        $this->Ln(3);

        $this->SetFont('times', 'B', 6);
        $this->SetX(4);
        $this->CellFitSpace(50, 3, "SUBTOTAL:", 0, 0, 'R');
        $this->SetFont('times', '', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["subtotalve"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('times', 'B', 6);
        $this->CellFitSpace(50, 3, "SUBTOTAL EXENTO DE IGV:", 0, 0, 'R');
        $this->SetFont('times', '', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["tarifasive"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('times', 'B', 6);
        $this->CellFitSpace(50, 3, "SUBTOTAL NO OBJETO DE IVA:", 0, 0, 'R');
        $this->SetFont('times', '', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["tarifanove"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('times', 'B', 6);
        $this->CellFitSpace(50, 3, "DESCUENTO %:", 0, 0, 'R');
        $this->SetFont('times', '', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["descuentove"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('times', 'B', 6);
        $this->CellFitSpace(50, 3, "DESCUENTO BONIFICACION:", 0, 0, 'R');
        $this->SetFont('times', '', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["descbonificve"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('times', 'B', 6);
        $this->CellFitSpace(50, 3, "IVA ".$ve[0]["ivave"]."%:", 0, 0, 'R');
        $this->SetFont('times', '', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["totalivave"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('times', 'B', 6);
        $this->CellFitSpace(50, 3, "TOTAL A PAGAR:", 0, 0, 'R');
        $this->SetFont('times', '', 7);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["totalpago"] + $tasa, 2, '.', ',')), 0, 1, 'R');
        $this->Ln(1);


        //$this->SetFont('Courier','B',8);
        //$this->SetX(2);

        //$this->Cell(70,3,'------- INFORMACI�N ADICIONAL -------',0,1,'C');
        //$this->Ln(1);

        //$this->SetFont('Courier','',8);
        //$this->SetX(4);
        //$this->Cell(65, 3,"CAJERO: ".utf8_decode($ve[0]['nombres']),0,1,'C');
        //$this->Ln(3);

        //$this->SetFont('Courier','B',8);
        //$this->SetX(2);
        //$this->Cell(70,3,'FIRMA: ___________________________',0,1,'C');
        //$this->Ln(4);


        //$this->SetFont('Courier','B',8);
        //$this->SetX(2);
        //$this->Cell(70,3,'--------------- PAGO ----------------',0,1,'C');
        //$this->Ln(1);

        //if($ve[0]['tipopagove']=="CREDITO"){

        //$this->SetFont('Courier','B',8);
        //$this->SetX(4);
        //$this->SetFont('Courier','',8);
        //$this->CellFitSpace(65,3,utf8_decode($ve[0]["tipopagove"]." - ".$variable = ( $ve[0]['tipopagove'] == 'CONTADO' ? $ve[0]['mediopago'] : $ve[0]['formapagove'])),0,1,'C');

        //$this->SetX(4);
        //$this->SetFont('Courier','B',8);
        //$this->CellFitSpace(45,3,"STATUS PAGO:",0,0,'R');
        //$this->SetFont('Courier','',8);
        //if($ve[0]['fechavencecredito']== '0000-00-00') {
        //$this->CellFitSpace(20,3,utf8_decode($ve[0]["statusventa"]),0,1,'R');
        //} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
        //$this->CellFitSpace(20,3,utf8_decode($ve[0]["statusventa"]),0,1,'R');
        //} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
        //$this->CellFitSpace(20,3,utf8_decode("VENCIDA"),0,1,'R');
        //}

        //$this->SetX(4);
        //$this->SetFont('Courier','B',8);
        //$this->CellFitSpace(45,3,"FECHA VENC:",0,0,'R');
        //$this->SetFont('Courier','',8);
        //$this->CellFitSpace(20,3,utf8_decode($ve[0]["fechavencecredito"]),0,1,'R');

        //$this->SetX(4);
        //$this->SetFont('Courier','B',8);
        //$this->CellFitSpace(45,3,"DIAS VENCIDOS:",0,0,'R');
        //$this->SetFont('Courier','',8);
        //if($ve[0]['fechavencecredito']== '0000-00-00') {
        //$this->CellFitSpace(20,3,utf8_decode("0"),0,1,'R');
        //} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
        //$this->CellFitSpace(20,3,utf8_decode("0"),0,1,'R');
        //} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
        //$this->CellFitSpace(20,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$ve[0]['fechavencecredito'])),0,1,'R');
        //}

        //$this->SetX(4);
        //$this->SetFont('Courier','B',8);
        //$this->CellFitSpace(45,3,"TOTAL ABONO:",0,0,'R');
        //$this->SetFont('Courier','',8);
        //$this->CellFitSpace(20,3,utf8_decode(number_format($ve[0]["abonototal"], 2, '.', ',')),0,1,'R');

        //$this->SetX(4);
        //$this->SetFont('Courier','B',8);
        //$this->CellFitSpace(45,3,"TOTAL DEBE:",0,0,'R');
        //$this->SetFont('Courier','',8);
        //$this->CellFitSpace(20,3,utf8_decode(number_format($ve[0]["totalpago"]-$ve[0]["abonototal"], 2, '.', ',')),0,1,'R');
        //$this->Ln(1);


        //  } else {

        //$this->SetFont('Courier','B',8);
        //$this->SetX(4);
        //$this->SetFont('Courier','',8);
        //$this->CellFitSpace(65,3,utf8_decode($ve[0]["tipopagove"]." - ".$ve[0]["mediopago"]),0,1,'C');

        //$this->SetX(4);
        //$this->SetFont('Courier','B',8);
        //$this->CellFitSpace(50,3,"EFECTIVO:",0,0,'R');
        //$this->SetFont('Courier','',8);
        //$this->CellFitSpace(15,3,utf8_decode(number_format($ve[0]["montopagado"], 2, '.', ',')),0,1,'R');

        //$this->SetX(4);
        //$this->SetFont('Courier','B',8);
        //$this->CellFitSpace(50,3,"CAMBIO:",0,0,'R');
        //$this->SetFont('Courier','',8);
        //$this->CellFitSpace(15,3,utf8_decode(number_format($ve[0]["montodevuelto"], 2, '.', ',')),0,1,'R');
        //$this->Ln(1);

        //}

        //$this->SetFont('Courier','B',8);
        //$this->SetX(2);
        //$this->Cell(70,0.5,'-------------------------------------',0,1,'C');
        //$this->SetX(2);
        //$this->Cell(70,0.5,'-------------------------------------',0,1,'C');
        //$this->Ln(3);

        $this->SetXY(4, 94);
        $this->Codabar(6, -90, utf8_decode("111111222222333333444444555555666666777777888888999999"));
    }
    ######################### FIN DE FUNCION TICKET DE VENTAS DE PRODUCTOS ############################















    ############################# FUNCION LISTAR VENTAS POR CAJAS ###############################
    public function TablaVentasCajas()
    {
        $ca = new Login();
        $ca = $ca->CajaPorId();

        $tra = new Login();
        $reg = $tra->BuscarVentasCajas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 18);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'VENTAS EN CAJA N� '.$ca[0]['nrocaja'].' : DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"], 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('Y SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(28, 8, 'NUM. FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(62, 8, 'CLIENTE', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'STATUS', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'VENC', 1, 0, 'C', true);
        $this->CellFitSpace(26, 8, 'FECHA VENTA', 1, 0, 'C', true);
        $this->CellFitSpace(16, 8, 'ARTIC', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'DCTO', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'DCTO/BONIF', 1, 0, 'C', true);
        $this->CellFitSpace(24, 8, 'SUBTOTAL', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TARIFA 0%', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TARIFA CON %', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TOTAL IVA', 1, 0, 'C', true);
        $this->CellFitSpace(24, 8, 'TOTAL PAGO', 1, 1, 'C', true);

        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;
        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $reg[0]['simbolo'] : $reg[0]["simbolo"]);

        for($i = 0;$i < sizeof($reg);$i++) {
            $tasa = $reg[$i]["totalpago"] * $reg[$i]["intereses"] / 100;

            $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
            $TotalDescuento += $reg[$i]['descuentove'];
            $TotalBonificiacion += $reg[$i]['descbonificve'];
            $TotalSubtotal += $reg[$i]['subtotalve'];
            $TotalTarifano += $reg[$i]['subtotalve'];
            $TotalTarifasi += $reg[$i]['tarifasive'];
            $Totaliva += $reg[$i]['totalivave'];
            $TotalPago += $reg[$i]['totalpago'] + $tasa;

            $this->SetFont('Courier', '', 9);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(10, 6, $a++, 1, 0, 'C');
            $this->CellFitSpace(28, 6, $reg[$i]["codventa"], 1, 0, 'C');
            $this->CellFitSpace(62, 6, utf8_decode($cliente = ($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente'])), 1, 0, 'C');

            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(22, 6, utf8_decode("VENCIDA"), 1, 0, 'C');
            }

            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->Cell(15, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->Cell(15, 6, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito'])), 1, 0, 'C');
            }

            $this->CellFitSpace(26, 6, utf8_decode($reg[$i]["fechaventa"]), 1, 0, 'C');


            $this->CellFitSpace(16, 6, utf8_decode($cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2'])), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]['descuentove'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['descbonificve'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(24, 6, utf8_decode($simbolo.number_format($reg[$i]['subtotalve'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifanove'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifasive'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['totalivave'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(24, 6, utf8_decode($simbolo.number_format($reg[$i]['totalpago'] + $tasa, 2, '.', ',')), 1, 0, 'C');
            $this->Ln();
        }

        $this->Cell(10, 5, '', 0, 0, 'C');
        $this->Cell(28, 5, '', 0, 0, 'C');
        $this->Cell(62, 5, '', 0, 0, 'C');
        $this->Cell(22, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(26, 5, 'TOTAL GEN.', 1, 0, 'C', true);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(16, 5, utf8_decode($TotalArticulos), 1, 0, 'C');
        $this->Cell(18, 5, utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalBonificiacion, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(24, 5, utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalTarifano, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalTarifasi, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($Totaliva, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(24, 5, utf8_decode($simbolo.number_format($TotalPago, 2, '.', ',')), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################# FUNCION LISTAR VENTAS POR CAJAS ###############################

    ############################# FUNCION LISTAR VENTAS POR FECHAS ###############################
    public function TablaVentasFechas()
    {


        $tra = new Login();
        $reg = $tra->BuscarVentasFechas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 18);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'VENTAS POR FECHAS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"], 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('Y SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TELEFONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(28, 8, 'NUM. FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(62, 8, 'CLIENTE', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'STATUS', 1, 0, 'C', true);
        $this->CellFitSpace(26, 8, 'FECHA VENTA', 1, 0, 'C', true);
        $this->CellFitSpace(16, 8, 'ARTIC', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'DCTO', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'DCTO/BONIF', 1, 0, 'C', true);
        $this->CellFitSpace(24, 8, 'SUBTOTAL', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TARIFA 0%', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TARIFA CON %', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TOTAL IGV', 1, 0, 'C', true);
        $this->CellFitSpace(24, 8, 'TOTAL PAGO', 1, 1, 'C', true);

        $TotalArticulos = 0;
        $TotalDescuento = 0;
        $TotalBonificiacion = 0;
        $TotalSubtotal = 0;
        $TotalTarifano = 0;
        $TotalTarifasi = 0;
        $Totaliva = 0;
        $TotalPago = 0;
        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $reg[0]['simbolo'] : $reg[0]["simbolo"]);

        for($i = 0;$i < sizeof($reg);$i++) {

            $TotalArticulos += $reg[$i]['articulos'] + $reg[$i]['articulos2'];
            $TotalDescuento += $reg[$i]['descuentove'];
            $TotalBonificiacion += $reg[$i]['descbonificve'];
            $TotalSubtotal += $reg[$i]['subtotalve'];
            $TotalTarifano += $reg[$i]['subtotalve'];
            $TotalTarifasi += $reg[$i]['tarifasive'];
            $Totaliva += $reg[$i]['totalivave'];
            $TotalPago += $reg[$i]['totalpago'];

            $this->SetFont('Courier', '', 9);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(10, 6, $a++, 1, 0, 'C');
            $this->CellFitSpace(28, 6, $reg[$i]["codventa"], 1, 0, 'C');
            $this->CellFitSpace(62, 6, utf8_decode($cliente = ($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente'])), 1, 0, 'C');
            $this->CellFitSpace(15, 6, utf8_decode($reg[$i]["nrocaja"]), 1, 0, 'C');

            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(22, 6, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(22, 6, utf8_decode("VENCIDA"), 1, 0, 'C');
            }

            $this->CellFitSpace(26, 6, utf8_decode($reg[$i]["fechaventa"]), 1, 0, 'C');

            $this->CellFitSpace(16, 6, utf8_decode($cantidad = ($reg[$i]['articulos2'] == '0' ? $reg[$i]['articulos'] : $reg[$i]['articulos']."+".$reg[$i]['articulos2'])), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]['descuentove'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(25, 6, utf8_decode($simbolo.number_format($reg[$i]['descbonificve'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(24, 6, utf8_decode($simbolo.number_format($reg[$i]['subtotalve'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifanove'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['tarifasive'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['totalivave'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(24, 6, utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')), 1, 0, 'C');
            $this->Ln();
        }

        $this->Cell(10, 5, '', 0, 0, 'C');
        $this->Cell(28, 5, '', 0, 0, 'C');
        $this->Cell(62, 5, '', 0, 0, 'C');
        $this->Cell(22, 5, '', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0, 'C');
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(26, 5, 'TOTAL GEN.', 1, 0, 'C', true);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(16, 5, utf8_decode($TotalArticulos), 1, 0, 'C');
        $this->Cell(18, 5, utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalBonificiacion, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(24, 5, utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalTarifano, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalTarifasi, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($Totaliva, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(24, 5, utf8_decode($simbolo.number_format($TotalPago, 2, '.', ',')), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################# FUNCION LISTAR VENTAS POR FECHAS ###############################

    ############################ FUNCION LISTAR ARQUEOS DE CAJAS ################################
    public function TablaListarArqueosGeneral()
    {

        $tra = new Login();
        $reg = $tra->ListarArqueoCaja();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 12);
        //T�tulo
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 8, 'LISTADO GENERAL DE ARQUEOS DE CAJAS ', 0, 0, 'C');
        $this->Ln();
        $this->Cell(100);
        $this->Cell(65, 8, 'DE SUCURSAL '. utf8_decode($reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(12);


        $this->SetFont('Courier', 'B', 9);
        $this->SetFillColor(2, 157, 116);
        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
        $this->Cell(35, 5, $reg[0]['cedresponsable'], 0, 0, '');
        $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
        $this->Cell(72, 5, $reg[0]['nomresponsable'], 0, 1, '');

        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
        $this->Cell(35, 5, utf8_decode($reg[0]['rucsucursal']), 0, 0, '');
        $this->Cell(40, 5, 'RAZ�N SOCIAL :', 0, 0, '');
        $this->Cell(72, 5, utf8_decode($reg[0]['razonsocial']), 0, 1, '');

        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
        $this->Cell(35, 5, utf8_decode($reg[0]['celsucursal']), 0, 0, '');
        $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
        $this->Cell(72, 5, utf8_decode($reg[0]['direcsucursal']), 0, 0, '');
        $this->Ln(8);

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(45, 8, 'RESPONSABLE', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'HORA DE APERTURA', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'HORA DE CIERRE', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'ESTIMADO', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'REAL', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'DIFERENCIA', 1, 1, 'C', true);

        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $reg[0]['simbolo'] : $reg[0]["simbolo"]);
        for($i = 0;$i < sizeof($reg);$i++) {
            $this->SetFont('Courier', '', 8);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(10, 6, $a++, 1, 0, 'C');
            $this->CellFitSpace(45, 6, utf8_decode($reg[$i]["nombres"]), 1, 0, 'C');
            $this->CellFitSpace(25, 6, $reg[$i]["nombrecaja"], 1, 0, 'C');
            $this->CellFitSpace(30, 6, utf8_decode($reg[$i]["fechaapertura"]), 1, 0, 'C');
            $this->CellFitSpace(30, 6, utf8_decode($reg[$i]["fechacierre"]), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]['montoinicial'] + $reg[$i]['ingresos'] - $reg[$i]['egresos'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]["dineroefectivo"], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]["diferencia"], 2, '.', ',')), 1, 0, 'C');
            $this->Ln();

        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(60, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(60, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################ FUNCION LISTAR ARQUEOS DE CAJAS ################################

    ############################ FUNCION LISTAR ARQUEOS DE CAJAS POR FECHA ################################
    public function TablaListarArqueosFechas()
    {

        $tra = new Login();
        $reg = $tra->BuscarArqueosFechas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 12);
        //T�tulo
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 8, 'ARQUEOS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"], 0, 0, 'C');
        $this->Ln();
        $this->Cell(100);
        $this->Cell(65, 8, 'Y SUCURSAL '. utf8_decode($reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(12);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $con[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $reg[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $reg[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($reg[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($reg[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($reg[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($reg[0]['direcsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(45, 8, 'RESPONSABLE', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'HORA DE APERTURA', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'HORA DE CIERRE', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'ESTIMADO', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'REAL', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'DIFERENCIA', 1, 1, 'C', true);

        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $reg[0]['simbolo'] : $reg[0]["simbolo"]);
        for($i = 0;$i < sizeof($reg);$i++) {
            $this->SetFont('Courier', '', 8);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(10, 6, $a++, 1, 0, 'C');
            $this->CellFitSpace(45, 6, utf8_decode($reg[$i]["nombres"]), 1, 0, 'C');
            $this->CellFitSpace(25, 6, $reg[$i]["nombrecaja"], 1, 0, 'C');
            $this->CellFitSpace(30, 6, utf8_decode($reg[$i]["fechaapertura"]), 1, 0, 'C');
            $this->CellFitSpace(30, 6, utf8_decode($reg[$i]["fechacierre"]), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]['montoinicial'] + $reg[$i]['ingresos'] - $reg[$i]['egresos'], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]["dineroefectivo"], 2, '.', ',')), 1, 0, 'C');
            $this->CellFitSpace(18, 6, utf8_decode($simbolo.number_format($reg[$i]["diferencia"], 2, '.', ',')), 1, 0, 'C');
            $this->Ln();

        }
        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(60, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(60, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################ FUNCION LISTAR ARQUEOS DE CAJAS POR FECHA ################################

    ############################### FUNCION LISTAR MOVIMIENTOS GENERAL #################################
    public function TablaListarMovimientosGeneral()
    {

        $movim = new Login();
        $reg = $movim->ListarMovimientoCajas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 12);
        //T�tulo
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 8, 'LISTADO GENERAL DE MOVIMIENTOS DE CAJAS ', 0, 0, 'C');
        $this->Ln();
        $this->Cell(100);
        $this->Cell(65, 8, 'DE SUCURSAL '. utf8_decode($reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(12);

        $this->SetFont('Courier', 'B', 9);
        $this->SetFillColor(2, 157, 116);
        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
        $this->Cell(35, 5, $reg[0]['cedresponsable'], 0, 0, '');
        $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
        $this->Cell(72, 5, $reg[0]['nomresponsable'], 0, 1, '');

        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
        $this->Cell(35, 5, utf8_decode($reg[0]['rucsucursal']), 0, 0, '');
        $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
        $this->Cell(72, 5, utf8_decode($reg[0]['razonsocial']), 0, 1, '');

        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
        $this->Cell(35, 5, utf8_decode($reg[0]['celsucursal']), 0, 0, '');
        $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
        $this->Cell(72, 5, utf8_decode($reg[0]['direcsucursal']), 0, 0, '');
        $this->Ln(8);

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es AZUL)
        $this->CellFitSpace(10, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(75, 8, 'DESCRIPCION DE MOVIMIENTO', 1, 0, 'C', true);
        $this->CellFitSpace(37, 8, 'MEDIO MOVIMIENTO', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'TIPO', 1, 0, 'C', true);
        $this->CellFitSpace(35, 8, 'FECHA MOVIMIENTO', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'MONTO', 1, 1, 'C', true);

        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $reg[0]['simbolo'] : $reg[0]["simbolo"]);
        $TotalIngresos = 0;
        $TotalEgresos = 0;

        if($reg == "") {
            echo "";
        } else {

            for($i = 0;$i < sizeof($reg);$i++) {
                $TotalIngresos += $ingresos = ($reg[$i]['tipomovimientocaja'] == 'INGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
                $TotalEgresos += $egresos = ($reg[$i]['tipomovimientocaja'] == 'EGRESO' ? $reg[$i]['montomovimientocaja'] : "0");


                $this->SetFont('Courier', '', 8);
                $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
                $this->Cell(10, 6, $a++, 1, 0, 'C');
                $this->CellFitSpace(75, 6, utf8_decode($reg[$i]["descripcionmovimientocaja"]), 1, 0, 'C');
                $this->CellFitSpace(37, 6, utf8_decode($reg[$i]["mediopago"]), 1, 0, 'C');
                $this->CellFitSpace(15, 6, utf8_decode($reg[$i]["tipomovimientocaja"]), 1, 0, 'C');
                $this->CellFitSpace(35, 6, $reg[$i]["fechamovimientocaja"], 1, 0, 'C');
                $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['montomovimientocaja'], 2, '.', ',')), 1, 0, 'C');
                $this->Ln();
            }

        }

        $this->Cell(325, 5, '', 0, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(95, 5, 'DETALLES DE MOVIMIENTO', 1, 0, 'C', true);
        $this->Ln();


        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'RESPONSABLE DE CAJA', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, utf8_decode($reg[0]['nombres']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'NOMBRE DE CAJA', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nombrecaja']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'TOTAL INGRESOS', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, $simbolo.number_format($TotalIngresos, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'TOTAL EGRESOS', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, $simbolo.number_format($TotalEgresos, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'TOTAL GENERAL', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, $simbolo.number_format($TotalIngresos - $TotalEgresos, 2, '.', ','), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(60, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(60, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################### FUNCION LISTAR MOVIMIENTOS GENERAL #################################

    ############################### FUNCION LISTAR MOVIMIENTOS DE CAJAS #################################
    public function TablaListarMovimientosCajas()
    {

        $movim = new Login();
        $reg = $movim->BuscarMovimientosCajasFechas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 12);
        //T�tulo
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 8, 'MOVIMIENTOS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"], 0, 0, 'C');
        $this->Ln();
        $this->Cell(100);
        $this->Cell(65, 8, 'Y SUCURSAL '. utf8_decode($reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(12);

        if($_SESSION['acceso'] == "administradorG") {

            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $con[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $reg[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $reg[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($reg[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($reg[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($reg[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($reg[0]['direcsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es AZUL)
        $this->CellFitSpace(10, 8, 'N�', 1, 0, 'C', true);
        $this->CellFitSpace(75, 8, 'DESCRIPCION DE MOVIMIENTO', 1, 0, 'C', true);
        $this->CellFitSpace(37, 8, 'MEDIO MOVIMIENTO', 1, 0, 'C', true);
        $this->CellFitSpace(15, 8, 'TIPO', 1, 0, 'C', true);
        $this->CellFitSpace(35, 8, 'FECHA MOVIMIENTO', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'MONTO', 1, 1, 'C', true);

        $a = 1;
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $reg[0]['simbolo'] : $reg[0]["simbolo"]);
        $TotalIngresos = 0;
        $TotalEgresos = 0;
        for($i = 0;$i < sizeof($reg);$i++) {
            $TotalIngresos += $ingresos = ($reg[$i]['tipomovimientocaja'] == 'INGRESO' ? $reg[$i]['montomovimientocaja'] : "0");
            $TotalEgresos += $egresos = ($reg[$i]['tipomovimientocaja'] == 'EGRESO' ? $reg[$i]['montomovimientocaja'] : "0");


            $this->SetFont('Courier', '', 8);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(10, 6, $a++, 1, 0, 'C');
            $this->CellFitSpace(75, 6, utf8_decode($reg[$i]["descripcionmovimientocaja"]), 1, 0, 'C');
            $this->CellFitSpace(37, 6, utf8_decode($reg[$i]["mediopago"]), 1, 0, 'C');
            $this->CellFitSpace(15, 6, utf8_decode($reg[$i]["tipomovimientocaja"]), 1, 0, 'C');
            $this->CellFitSpace(35, 6, $reg[$i]["fechamovimientocaja"], 1, 0, 'C');
            $this->CellFitSpace(20, 6, utf8_decode($simbolo.number_format($reg[$i]['montomovimientocaja'], 2, '.', ',')), 1, 0, 'C');
            $this->Ln();

        }

        $this->Cell(325, 5, '', 0, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(95, 5, 'DETALLES DE MOVIMIENTO', 1, 0, 'C', true);
        $this->Ln();


        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'RESPONSABLE DE CAJA', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, utf8_decode($reg[0]['nombres']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'NOMBRE DE CAJA', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nombrecaja']), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'TOTAL INGRESOS', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, $simbolo.number_format($TotalIngresos, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'TOTAL EGRESOS', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, $simbolo.number_format($TotalEgresos, 2, '.', ','), 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Courier', 'B', 8);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->Cell(35, 5, 'TOTAL GENERAL', 1, 0, 'C', true);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(60, 5, $simbolo.number_format($TotalIngresos - $TotalEgresos, 2, '.', ','), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(60, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(60, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################### FUNCION LISTAR MOVIMIENTOS DE CAJAS #################################

    ################################### CLASE VENTAS DE PRODUCTOS #######################################








































    #################################### CLASE CREDITOS DE VENTAS ####################################

    ################################# FUNCION TICKET DE ABONOS DE CREDITOS ################################
    public function TablaTicketCreditos()
    {

        $ve = new Login();
        $ve = $ve->VentasPorId();

        $this->SetFont('Courier', 'B', 14);
        $this->SetFillColor(2, 157, 116);
        //$this->SetXY(13, 6);
        //$this->Cell(13, 5, "TICKET DE VENTA", 0 , 0);
        //$this->Ln(5);

        $this->SetFont('Courier', 'B', 10);
        $this->SetFillColor(2, 157, 116);
        $this->SetXY(4, 10);
        $this->CellFitSpace(65, 3, utf8_decode($ve[0]['razonsocial']), 0, 1, 'C');
        $this->SetFont('Courier', 'B', 8);
        $this->SetXY(4, 13);
        $this->CellFitSpace(65, 3, "MATRIZ:".utf8_decode($ve[0]['direcsucursal']), 0, 1, 'C');
        $this->SetXY(4, 16);
        $this->CellFitSpace(65, 3, "OBLIGADO A LLEVAR CONTABILIDAD:".utf8_decode($ve[0]['llevacontabilidad']), 0, 1, 'C');
        $this->SetXY(4, 19);
        $this->CellFitSpace(65, 3, "RUC:".utf8_decode($ve[0]['rucsucursal']), 0, 1, 'C');
        $this->SetXY(4, 22);
        $this->CellFitSpace(65, 3, "FACTURA:".utf8_decode($ve[0]['codventa']), 0, 1, 'C');
        $this->SetXY(4, 25);
        $this->CellFitSpace(65, 3, "AMBIENTE: PRODUCCI�N", 0, 1, 'C');
        $this->SetXY(4, 28);
        $this->CellFitSpace(65, 3, "EMISION: NORMAL", 0, 1, 'C');
        $this->SetXY(4, 31);
        $this->CellFitSpace(65, 3, "CLAVE DE ACCESO - N� DE AUTORIZACI�N", 0, 1, 'C');
        $this->SetXY(4, 34);
        $this->CellFitSpace(65, 3, utf8_decode($ve[0]['codautorizacion']), 0, 1, 'C');
        $this->Ln(1);

        $this->SetX(2);
        $this->Cell(70, 3, '-------------- CLIENTE --------------', 0, 1, 'C');

        if($ve[0]['codcliente'] == "") {

            $this->SetFont('Courier', '', 8);
            $this->SetX(4);
            $this->Cell(65, 3, "CONSUMIDOR FINAL", 0, 1, 'C');

        } else {

            $this->SetFont('Courier', '', 8);
            $this->SetX(4);
            $this->Cell(65, 3, utf8_decode($ve[0]['cedcliente']), 0, 1, 'C');
            $this->SetX(4);
            $this->Cell(65, 3, utf8_decode($ve[0]['nomcliente']), 0, 1, 'C');

        }
        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '-------------------------------------', 0, 1, 'C');

        $this->SetX(4);
        $this->Cell(65, 3, "FECHA EMISI�N: ".date("d/m/Y h:i:s A ", time() + 1800), 0, 1, 'L');

        $this->SetX(2);
        $this->Cell(70, 3, '------------- PRODUCTOS -------------', 0, 1, 'C');
        $this->Ln(1);

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 7);
        $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
        $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
        $this->Cell(12, 3, 'CANT', 0, 0, 'L');
        $this->Cell(42, 3, 'DESCRIPCION', 0, 0, 'C');
        $this->Cell(12, 3, 'IVA', 0, 1, 'C');

        $this->SetX(4);
        $this->Cell(15, 3, 'LAB.', 0, 0, 'L');
        $this->Cell(18, 3, 'PVP.', 0, 0, 'C');
        $this->Cell(22, 3, 'DCTO.', 0, 0, 'C');
        $this->Cell(11, 3, 'TOTAL', 0, 1, 'C');

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '-------------------------------------', 0, 0, 'C');
        $this->Ln(3);

        $tra = new Login();
        $reg = $tra->VerDetallesVentas();
        $cantidad = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {

            $this->SetX(4);
            $this->SetFillColor(192);
            $this->SetDrawColor(3, 3, 3);
            $this->SetLineWidth(.2);
            $this->SetFont('Courier', '', 7);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->CellFitSpace(12, 3, utf8_decode($cantidad = ($reg[$i]['cantbonificv'] == '0' ? $reg[$i]['cantventa'] : $reg[$i]['cantventa']."+".$reg[$i]['cantbonificv'])), 0, 0, 'C');
            $this->CellFitSpace(42, 3, utf8_decode(getSubString($reg[$i]["productov"]." ".$reg[$i]["nommedida"], 22)), 0, 0, 'C');
            $this->CellFitSpace(12, 3, utf8_decode($iva = ($reg[$i]['ivaproductov'] == 'SI' ? "S" : "N")), 0, 1, 'C');

            $this->SetX(4);
            $this->CellFitSpace(15, 3, utf8_decode(getSubString($reg[$i]["nomlaboratorio"], 8)), 0, 0, 'C');

            $this->CellFitSpace(18, 3, utf8_decode($reg[$i]["preciounitario"]), 0, 0, 'C');


            $this->CellFitSpace(22, 3, utf8_decode($reg[$i]["descporc"]), 0, 0, 'C');
            $this->CellFitSpace(11, 3, utf8_decode($reg[$i]["valornetov"]), 0, 0, 'C');
            $this->Ln();
        }

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '-------------------------------------', 0, 0, 'C');
        $this->Ln(3);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(4);
        $this->CellFitSpace(50, 3, "SUBTOTAL:", 0, 0, 'R');
        $this->SetFont('Courier', '', 8);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["subtotalve"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 8);
        $this->CellFitSpace(50, 3, "SUBTOTAL EXENTO DE IVA:", 0, 0, 'R');
        $this->SetFont('Courier', '', 8);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["tarifasive"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 8);
        $this->CellFitSpace(50, 3, "SUBTOTAL NO OBJETO DE IVA:", 0, 0, 'R');
        $this->SetFont('Courier', '', 8);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["tarifanove"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 8);
        $this->CellFitSpace(50, 3, "DESCUENTO %:", 0, 0, 'R');
        $this->SetFont('Courier', '', 8);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["descuentove"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 8);
        $this->CellFitSpace(50, 3, "DESCUENTO BONIFICACION:", 0, 0, 'R');
        $this->SetFont('Courier', '', 8);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["descbonificve"], 2, '.', ',')), 0, 1, 'R');

        $this->SetX(4);
        $this->SetFont('Courier', 'B', 8);
        $this->CellFitSpace(50, 3, "TOTAL A PAGAR:", 0, 0, 'R');
        $this->SetFont('Courier', '', 8);
        $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["totalpago"], 2, '.', ',')), 0, 1, 'R');
        $this->Ln(1);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '------- INFORMACION ADICIONAL -------', 0, 1, 'C');
        $this->Ln(1);

        $this->SetFont('Courier', '', 8);
        $this->SetX(4);
        $this->Cell(65, 3, "CAJERO: ".utf8_decode($ve[0]['nombres']), 0, 1, 'C');
        $this->Ln(3);

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, 'FIRMA: ___________________________', 0, 1, 'C');
        $this->Ln(4);


        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 3, '--------------- PAGO ----------------', 0, 1, 'C');
        $this->Ln(1);

        if($ve[0]['tipopagove'] == "CREDITO") {

            $this->SetFont('Courier', 'B', 8);
            $this->SetX(4);
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(65, 3, utf8_decode($ve[0]["tipopagove"]." - ".$variable = ($ve[0]['tipopagove'] == 'CONTADO' ? $ve[0]['mediopago'] : $ve[0]['formapagove'])), 0, 1, 'C');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "STATUS PAGO:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            if($ve[0]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(20, 3, utf8_decode($ve[0]["statusventa"]), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode($ve[0]["statusventa"]), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode("VENCIDA"), 0, 1, 'R');
            }

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "FECHA VENC:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(20, 3, utf8_decode($ve[0]["fechavencecredito"]), 0, 1, 'R');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "DIAS VENCIDOS:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            if($ve[0]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(20, 3, utf8_decode("0"), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode("0"), 0, 1, 'R');
            } elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(20, 3, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $ve[0]['fechavencecredito'])), 0, 1, 'R');
            }

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "TOTAL ABONO:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(20, 3, utf8_decode(number_format($ve[0]["abonototal"], 2, '.', ',')), 0, 1, 'R');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(45, 3, "TOTAL DEBE:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(20, 3, utf8_decode(number_format($ve[0]["totalpago"] - $ve[0]["abonototal"], 2, '.', ',')), 0, 1, 'R');
            $this->Ln(1);


        } else {

            $this->SetFont('Courier', 'B', 8);
            $this->SetX(4);
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(65, 3, utf8_decode($ve[0]["tipopagove"]." - ".$ve[0]["mediopago"]), 0, 1, 'C');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(50, 3, "EFECTIVO:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["montopagado"], 2, '.', ',')), 0, 1, 'R');

            $this->SetX(4);
            $this->SetFont('Courier', 'B', 8);
            $this->CellFitSpace(50, 3, "CAMBIO:", 0, 0, 'R');
            $this->SetFont('Courier', '', 8);
            $this->CellFitSpace(15, 3, utf8_decode(number_format($ve[0]["montodevuelto"], 2, '.', ',')), 0, 1, 'R');
            $this->Ln(1);

        }

        $this->SetFont('Courier', 'B', 8);
        $this->SetX(2);
        $this->Cell(70, 0.5, '-------------------------------------', 0, 1, 'C');
        $this->SetX(2);
        $this->Cell(70, 0.5, '-------------------------------------', 0, 1, 'C');
        $this->Ln(3);

        //$this->SetXY(4, 94);
        $this->Codabar(6, -90, utf8_decode("111111222222333333444444555555666666777777888888999999"));

    }
    ########################### FIN DE FUNCION TICKET DE ABONOS DE CREDITOS ###########################


    ############################### FUNCION LISTAR CREDITOS POR CLIENTES ##############################
    public function TablaCreditosClientes()
    {

        $tra = new Login();
        $reg = $tra->BuscarClientesAbonos();

        //Logo
        if (isset($_SESSION['rucsucursal'])) {

            if (file_exists("fotos/".$_SESSION['rucsucursal'].".png")) {

                $logo = "./fotos/".$_SESSION['rucsucursal'].".png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");

            } else {

                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 20, 12, 60, 20, "PNG");
            }

        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 20, 12, 60, 20, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 12);
        //T�tulo
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(100);
        $this->Cell(65, 8, 'LISTADO DE CREDITOS POR CLIENTES ', 0, 0, 'C');
        $this->Ln();
        $this->Cell(100);
        $this->Cell(65, 8, 'DE SUCURSAL '. utf8_decode($reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(12);

        $con = new Login();
        $con = $con->ConfiguracionPorId();
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($_SESSION['acceso'] == "administradorG") {


            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'DNI RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $con[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($con[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($con[0]['direcsucursal']), 0, 1, '');

        } else {

            $this->SetFont('Courier', 'B', 9);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, ' RESPONSABLE : ', 0, 0, '');
            $this->Cell(35, 5, $reg[0]['cedresponsable'], 0, 0, '');
            $this->Cell(40, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->Cell(72, 5, $reg[0]['nomresponsable'], 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'RUC DE SUCURSAL : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($reg[0]['rucsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($reg[0]['razonsocial']), 0, 1, '');

            $this->Cell(3, 5, '', 0, 0, '');
            $this->Cell(40, 5, 'CELULAR : ', 0, 0, '');
            $this->Cell(35, 5, utf8_decode($reg[0]['celsucursal']), 0, 0, '');
            $this->Cell(40, 5, 'DIRECION SUCURSAL :', 0, 0, '');
            $this->Cell(72, 5, utf8_decode($reg[0]['direcsucursal']), 0, 1, '');
        }


        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'DNI CLIENTE: ', 0, 0, '');
        $this->Cell(35, 5, utf8_decode($reg[0]['cedcliente']), 0, 0, '');
        $this->Cell(40, 5, 'NOMBRE CLIENTE:', 0, 0, '');
        $this->Cell(72, 5, utf8_decode($reg[0]['nomcliente']), 0, 1, '');

        $this->Cell(3, 5, '', 0, 0, '');
        $this->Cell(40, 5, 'TELEFONO CLIENTE: ', 0, 0, '');
        $this->Cell(35, 5, utf8_decode($reg[0]['tlfcliente']), 0, 0, '');
        $this->Cell(40, 5, 'CORREO CLIENTE:', 0, 0, '');
        $this->Cell(72, 5, utf8_decode($reg[0]['emailcliente']), 0, 0, '');
        $this->Ln(8);

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(8, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'NUM. FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(18, 8, 'NUM. CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(17, 8, 'STATUS', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'DIAS VENC', 1, 0, 'C', true);
        $this->CellFitSpace(26, 8, 'FECHA VENTA', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TOT FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'TOT ABONO', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'TOT DEBE', 1, 1, 'C', true);

        $TotalFactura = 0;
        $TotalCredito = 0;
        $TotalDebe = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $TotalFactura += $reg[$i]['totalpago'];
            $TotalCredito += $reg[$i]['abonototal'];
            $TotalDebe += $reg[$i]['totalpago'] - $reg[$i]['abonototal'];

            $this->SetFont('Courier', '', 7);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(8, 5, $a++, 1, 0, 'C');
            $this->CellFitSpace(30, 5, $reg[$i]["codventa"], 1, 0, 'C');
            $this->CellFitSpace(18, 5, $reg[$i]['nrocaja'], 1, 0, 'C');


            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(17, 5, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(17, 5, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(17, 5, utf8_decode("VENCIDA"), 1, 0, 'C');
            }
            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(20, 5, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(20, 5, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(20, 5, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito'])), 1, 0, 'C');
            }
            $this->CellFitSpace(26, 5, date("d-m-Y h:i:s", strtotime($reg[$i]['fechaventa'])), 1, 0, 'C');
            $this->CellFitSpace(25, 5, $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','), 1, 0, 'C');
            $this->CellFitSpace(25, 5, $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','), 1, 0, 'C');
            $this->CellFitSpace(20, 5, $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['abonototal'], 2, '.', ','), 1, 0, 'C');
            $this->Ln();

        }

        $this->Cell(8, 5, '', 0, 0, 'C');
        $this->Cell(30, 5, '', 0, 0, 'C');
        $this->Cell(18, 5, '', 0, 0, 'C');
        $this->Cell(17, 5, '', 0, 0, 'C');
        $this->Cell(20, 5, '', 0, 0, 'C');
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(26, 5, 'TOTAL GENERAL', 1, 0, 'C', true);
        $this->SetFont('Courier', 'B', 7);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalFactura, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode($simbolo.number_format($TotalCredito, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(85, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(100, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(85, 6, '', 0, 0, '');
        $this->Ln(4);
    }
    ############################### FUNCION LISTAR CREDITOS POR CLIENTES ##############################

    ################################## FUNCION LISTAR CREDITOS POR FECHAS #################################
    public function TablaCreditosFechas()
    {
        $tra = new Login();
        $reg = $tra->BuscarCreditosFechas();

        //Logo
        if (isset($reg[0]['rucsucursal'])) {
            if (file_exists("fotos/".$reg[0]['rucsucursal'].".png")) {

                $logo = "./fotos/".$reg[0]['rucsucursal'].".png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            } else {
                $logo = "./assets/images/logo_white_2.png";
                $this->Image($logo, 35, 12, 80, 25, "PNG");
            }
        } else {
            $logo = "./assets/images/logo_white_2.png";
            $this->Image($logo, 35, 12, 80, 25, "PNG");
        }

        //Arial bold 15
        $this->SetFont('Courier', 'B', 20);
        //Titulo
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 3, '', 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, 'CR�DITOS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"], 0, 0, 'C');
        $this->Ln();
        //Movernos a la derecha
        $this->Cell(130);
        $this->Cell(180, 10, utf8_decode('Y SUCURSAL '.$reg[0]['razonsocial']), 0, 0, 'C');
        $this->Ln(20);


        $con = new Login();
        $con = $con->ConfiguracionPorId();
        $simbolo = ($_SESSION['acceso'] == "administradorG" ? $con[0]['simbolo'] : $_SESSION["simbolo"]);

        if($_SESSION['acceso'] == "administradorG") {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TEL�FONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $con[0]['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $con[0]['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($con[0]['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($con[0]['emailsucursal']), 0, 0, '');
            $this->Ln(8);

        } else {

            $this->SetFont('Courier', 'B', 10);
            $this->SetFillColor(2, 157, 116);
            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'DNI RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['cedresponsable'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'NOMBRE RESPONSABLE :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['nomresponsable']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['celresponsable'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'RUC SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['rucsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'RAZON SOCIAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['razonsocial']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'TEL�FONO :', 0, 0, '');
            $this->CellFitSpace(55, 5, $_SESSION['tlfsucursal'], 0, 1, '');

            $this->Cell(15, 5, '', 0, 0, '');
            $this->CellFitSpace(42, 5, 'CELULAR :', 0, 0, '');
            $this->CellFitSpace(42, 5, $_SESSION['celsucursal'], 0, 0, '');
            $this->CellFitSpace(45, 5, 'DIRECCION SUCURSAL :', 0, 0, '');
            $this->CellFitSpace(100, 5, utf8_decode($_SESSION['direcsucursal']), 0, 0, '');
            $this->CellFitSpace(30, 5, 'EMAIL :', 0, 0, '');
            $this->CellFitSpace(55, 5, utf8_decode($_SESSION['emailsucursal']), 0, 0, '');
            $this->Ln(8);
        }

        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(252, 205, 90); // establece el color del fondo de la celda (en este caso es NARANJA)
        $this->CellFitSpace(8, 8, 'NUM.', 1, 0, 'C', true);
        $this->CellFitSpace(30, 8, 'DNI', 1, 0, 'C', true);
        $this->CellFitSpace(80, 8, 'NOMBRE CLIENTE', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'NUM. CAJA', 1, 0, 'C', true);
        $this->CellFitSpace(25, 8, 'STATUS', 1, 0, 'C', true);
        $this->CellFitSpace(20, 8, 'DIAS VENC', 1, 0, 'C', true);
        $this->CellFitSpace(40, 8, 'NUM. FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(35, 8, 'FECHA VENTA', 1, 0, 'C', true);
        $this->CellFitSpace(27, 8, 'TOTAL FACTURA', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'TOTAL ABONO', 1, 0, 'C', true);
        $this->CellFitSpace(22, 8, 'TOTAL DEBE', 1, 1, 'C', true);

        $TotalFactura = 0;
        $TotalCredito = 0;
        $TotalDebe = 0;
        $a = 1;
        for($i = 0;$i < sizeof($reg);$i++) {
            $TotalFactura += $reg[$i]['totalpago'];
            $TotalCredito += $reg[$i]['abonototal'];
            $TotalDebe += $reg[$i]['totalpago'] - $reg[$i]['abonototal'];

            $this->SetFont('Courier', '', 9);
            $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es negro)
            $this->Cell(8, 5, $a++, 1, 0, 'C');
            $this->CellFitSpace(30, 6, $reg[$i]['cedcliente'], 1, 0, 'C');
            $this->CellFitSpace(80, 6, $reg[$i]["nomcliente"], 1, 0, 'C');
            $this->CellFitSpace(20, 6, $reg[$i]['nrocaja'], 1, 0, 'C');
            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(25, 6, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(25, 6, utf8_decode($reg[$i]['statusventa']), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(25, 6, utf8_decode("VENCIDA"), 1, 0, 'C');
            }
            if($reg[$i]['fechavencecredito'] == '0000-00-00') {
                $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) {
                $this->CellFitSpace(20, 6, utf8_decode("0"), 1, 0, 'C');
            } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) {
                $this->CellFitSpace(20, 6, utf8_decode(Dias_Transcurridos(date("Y-m-d"), $reg[$i]['fechavencecredito'])), 1, 0, 'C');
            }
            $this->CellFitSpace(40, 6, $reg[$i]["codventa"], 1, 0, 'C');
            $this->CellFitSpace(35, 6, date("d-m-Y h:i:s", strtotime($reg[$i]['fechaventa'])), 1, 0, 'C');
            $this->CellFitSpace(27, 6, $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','), 1, 0, 'C');
            $this->CellFitSpace(22, 6, $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','), 1, 0, 'C');
            $this->CellFitSpace(22, 6, $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['abonototal'], 2, '.', ','), 1, 0, 'C');
            $this->Ln();

        }

        $this->Cell(8, 6, '', 0, 0, 'C');
        $this->Cell(30, 6, '', 0, 0, 'C');
        $this->Cell(80, 6, '', 0, 0, 'C');
        $this->Cell(20, 6, '', 0, 0, 'C');
        $this->Cell(25, 6, '', 0, 0, 'C');
        $this->Cell(20, 6, '', 0, 0, 'C');
        $this->Cell(40, 6, '', 0, 0, 'C');
        $this->SetFont('Courier', 'B', 9);
        $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(35, 6, 'TOTAL GENERAL', 1, 0, 'C', true);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
        $this->Cell(27, 6, utf8_decode($simbolo.number_format($TotalFactura, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(22, 6, utf8_decode($simbolo.number_format($TotalCredito, 2, '.', ',')), 1, 0, 'C');
        $this->Cell(22, 6, utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')), 1, 0, 'C');
        $this->Ln();


        $this->Ln(12);
        $this->SetFont('Courier', 'B', 9);
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]), 0, 0, '');
        $this->Cell(120, 6, 'RECIBIDO:__________________________________', 0, 0, '');
        $this->Ln();
        $this->Cell(5, 6, '', 0, 0, '');
        $this->Cell(200, 6, 'FECHA/HORA ELABORACION:  '.date('d-m-Y h:i:s A'), 0, 0, '');
        $this->Cell(120, 6, '', 0, 0, '');
        $this->Ln(4);
    }

    ################################## FUNCION LISTAR CREDITOS POR FECHAS #################################

    ####################################### CLASE CREDITOS DE VENTAS ###########################################

































































    ######################### AQUI COMIENZA CODIGO PARA AJUSTAR TEXTO #########################

    ########### FUNCION PARA CODIGO DE BARRA CON CODE39 ############
    public function Code39($x, $y, $code, $ext = true, $cks = false, $w = 0.4, $h = 20, $wide = true)
    {

        //Display code
        $this->SetFont('Arial', '', 10);
        $this->Text($x, $y + $h + 4, $code);

        if($ext) {
            //Extended encoding
            $code = $this->encode_code39_ext($code);
        } else {
            //Convert to upper case
            $code = strtoupper($code);
            //Check validity
            if(!preg_match('|^[0-9A-Z. $/+%-]*$|', $code)) {
                $this->Error('Invalid barcode value: '.$code);
            }
        }

        //Compute checksum
        if ($cks) {
            $code .= $this->checksum_code39($code);
        }

        //Add start and stop characters
        $code = '*'.$code.'*';

        //Conversion tables
        $narrow_encoding = array(
            '0' => '101001101101', '1' => '110100101011', '2' => '101100101011',
            '3' => '110110010101', '4' => '101001101011', '5' => '110100110101',
            '6' => '101100110101', '7' => '101001011011', '8' => '110100101101',
            '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011',
            'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101',
            'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101',
            'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011',
            'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011',
            'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011',
            'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001',
            'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101',
            'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101',
            '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101',
            '*' => '100101101101', '$' => '100100100101', '/' => '100100101001',
            '+' => '100101001001', '%' => '101001001001' );

        $wide_encoding = array(
            '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111',
            '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101',
            '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101',
            '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111',
            'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101',
            'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101',
            'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111',
            'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111',
            'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111',
            'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001',
            'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101',
            'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101',
            '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101',
            '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001',
            '+' => '100010100010001', '%' => '101000100010001');

        $encoding = $wide ? $wide_encoding : $narrow_encoding;

        //Inter-character spacing
        $gap = ($w > 0.29) ? '00' : '0';

        //Convert to bars
        $encode = '';
        for ($i = 0; $i < strlen($code); $i++) {
            $encode .= $encoding[$code[$i]].$gap;
        }

        //Draw bars
        $this->draw_code39($encode, $x, $y, $w, $h);
    }

    public function checksum_code39($code)
    {

        //Compute the modulo 43 checksum

        $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
                                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
                                'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',
                                'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
        $sum = 0;
        for ($i = 0 ; $i < strlen($code); $i++) {
            $a = array_keys($chars, $code[$i]);
            $sum += $a[0];
        }
        $r = $sum % 43;
        return $chars[$r];
    }

    public function encode_code39_ext($code)
    {

        //Encode characters in extended mode

        $encode = array(
            chr(0) => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C',
            chr(4) => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G',
            chr(8) => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => '�K',
            chr(12) => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O',
            chr(16) => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S',
            chr(20) => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W',
            chr(24) => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A',
            chr(28) => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E',
            chr(32) => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C',
            chr(36) => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G',
            chr(40) => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K',
            chr(44) => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O',
            chr(48) => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3',
            chr(52) => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7',
            chr(56) => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F',
            chr(60) => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J',
            chr(64) => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C',
            chr(68) => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G',
            chr(72) => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K',
            chr(76) => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O',
            chr(80) => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S',
            chr(84) => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W',
            chr(88) => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K',
            chr(92) => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O',
            chr(96) => '%W', chr(97) => '+A', chr(98) => '+B', chr(99) => '+C',
            chr(100) => '+D', chr(101) => '+E', chr(102) => '+F', chr(103) => '+G',
            chr(104) => '+H', chr(105) => '+I', chr(106) => '+J', chr(107) => '+K',
            chr(108) => '+L', chr(109) => '+M', chr(110) => '+N', chr(111) => '+O',
            chr(112) => '+P', chr(113) => '+Q', chr(114) => '+R', chr(115) => '+S',
            chr(116) => '+T', chr(117) => '+U', chr(118) => '+V', chr(119) => '+W',
            chr(120) => '+X', chr(121) => '+Y', chr(122) => '+Z', chr(123) => '%P',
            chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

        $code_ext = '';
        for ($i = 0 ; $i < strlen($code); $i++) {
            if (ord($code[$i]) > 127) {
                $this->Error('Invalid character: '.$code[$i]);
            }
            $code_ext .= $encode[$code[$i]];
        }
        return $code_ext;
    }

    public function draw_code39($code, $x, $y, $w, $h)
    {

        //Draw bars

        for($i = 0; $i < strlen($code); $i++) {
            if($code[$i] == '1') {
                $this->Rect($x + $i * $w, $y, $w, $h, 'F');
            }
        }
    }


    ########### FUNCION PARA CODIGO DE BARRA CON EAN13 ############
    public function EAN13($x, $y, $barcode, $h = 16, $w = .35)
    {
        $this->Barcode($x, $y, $barcode, $h, $w, 13);
    }
    public function UPC_A($x, $y, $barcode, $h = 16, $w = .35)
    {
        $this->Barcode($x, $y, $barcode, $h, $w, 12);
    }
    public function GetCheckDigit($barcode)
    {
        //Compute the check digit
        $sum = 0;
        for($i = 1;$i <= 11;$i += 2) {
            $sum += 3 * $barcode[$i];
        }
        for($i = 0;$i <= 10;$i += 2) {
            $sum += $barcode[$i];
        }
        $r = $sum % 10;
        if($r > 0) {
            $r = 10 - $r;
        }
        return $r;
    }
    public function TestCheckDigit($barcode)
    {
        //Test validity of check digit
        $sum = 0;
        for($i = 1;$i <= 11;$i += 2) {
            $sum += 3 * $barcode[$i];
        }
        for($i = 0;$i <= 10;$i += 2) {
            $sum += $barcode[$i];
        }
        return ($sum + $barcode[12]) % 10 == 0;
    }
    public function Barcode($x, $y, $barcode, $h, $w, $len)
    {
        //Padding
        $barcode = str_pad($barcode, $len - 1, '0', STR_PAD_LEFT);
        if($len == 12) {
            $barcode = '0'.$barcode;
        }
        //Add or control the check digit
        if(strlen($barcode) == 12) {
            $barcode .= $this->GetCheckDigit($barcode);
        } elseif(!$this->TestCheckDigit($barcode)) {
            $this->Error('Incorrect check digit');
        }
        //Convert digits to bars
        $codes = array(
        'A' => array(
        '0' => '0001101','1' => '0011001','2' => '0010011','3' => '0111101','4' => '0100011',
        '5' => '0110001','6' => '0101111','7' => '0111011','8' => '0110111','9' => '0001011'),
        'B' => array(
        '0' => '0100111','1' => '0110011','2' => '0011011','3' => '0100001','4' => '0011101',
        '5' => '0111001','6' => '0000101','7' => '0010001','8' => '0001001','9' => '0010111'),
        'C' => array(
        '0' => '1110010','1' => '1100110','2' => '1101100','3' => '1000010','4' => '1011100',
        '5' => '1001110','6' => '1010000','7' => '1000100','8' => '1001000','9' => '1110100')
        );
        $parities = array(
        '0' => array('A','A','A','A','A','A'),
        '1' => array('A','A','B','A','B','B'),
        '2' => array('A','A','B','B','A','B'),
        '3' => array('A','A','B','B','B','A'),
        '4' => array('A','B','A','A','B','B'),
        '5' => array('A','B','B','A','A','B'),
        '6' => array('A','B','B','B','A','A'),
        '7' => array('A','B','A','B','A','B'),
        '8' => array('A','B','A','B','B','A'),
        '9' => array('A','B','B','A','B','A')
        );
        $code = '101';
        $p = $parities[$barcode[0]];
        for($i = 1;$i <= 6;$i++) {
            $code .= $codes[$p[$i - 1]][$barcode[$i]];
        }
        $code .= '01010';
        for($i = 7;$i <= 12;$i++) {
            $code .= $codes['C'][$barcode[$i]];
        }
        $code .= '101';
        //Draw bars
        for($i = 0;$i < strlen($code);$i++) {
            if($code[$i] == '1') {
                $this->Rect($x + $i * $w, $y, $w, $h, 'F');
            }
        }
        //Print text uder barcode
        $this->SetFont('Arial', '', 12);
        $this->Text($x, $y + $h + 11 / $this->k, substr($barcode, -$len));
    }





    public function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style == 'F') {
            $op = 'f';
        } elseif($style == 'FD' || $style == 'DF') {
            $op = 'B';
        } else {
            $op = 'S';
        }
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r ;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));

        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r ;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r ;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r ;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    public function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }


    public function GetMultiCellHeight($w, $h, $txt, $border = null, $align = 'J')
    {
        // Calculate MultiCell with automatic or explicit line breaks height
        // $border is un-used, but I kept it in the parameters to keep the call
        //   to this function consistent with MultiCell()
        $cw = &$this->CurrentFont['cw'];
        if($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $height = 0;
        while($i < $nb) {
            // Get next character
            $c = $s[$i];
            if($c == "\n") {
                // Explicit line break
                if($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                //Increase Height
                $height += $h;
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                continue;
            }
            if($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if($l > $wmax) {
                // Automatic line break
                if($sep == -1) {
                    if($i == $j) {
                        $i++;
                    }
                    if($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    //Increase Height
                    $height += $h;
                } else {
                    if($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    //Increase Height
                    $height += $h;
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
            } else {
                $i++;
            }
        }
        // Last chunk
        if($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        //Increase Height
        $height += $h;

        return $height;
    }

    public function MultiAlignCell($w, $h, $text, $border = 0, $ln = 0, $align = 'L', $fill = false)
    {
        // Store reset values for (x,y) positions
        $x = $this->GetX() + $w;
        $y = $this->GetY();

        // Make a call to FPDF's MultiCell
        $this->MultiCell($w, $h, $text, $border, $align, $fill);

        // Reset the line position to the right, like in Cell
        if($ln == 0) {
            $this->SetXY($x, $y);
        }
    }


    public function MultiCellText($w, $h, $txt, $border = 0, $ln = 0, $align = 'J', $fill = false)
    {
        // Custom Tomaz Ahlin
        if($ln == 0) {
            $current_y = $this->GetY();
            $current_x = $this->GetX();
        }

        // Output text with automatic or explicit line breaks
        $cw = &$this->CurrentFont['cw'];
        if($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $b = 0;
        if($border) {
            if($border == 1) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if(strpos($border, 'L') !== false) {
                    $b2 .= 'L';
                }
                if(strpos($border, 'R') !== false) {
                    $b2 .= 'R';
                }
                $b = (strpos($border, 'T') !== false) ? $b2.'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while($i < $nb) {
            // Get next character
            $c = $s[$i];
            if($c == "\n") {
                // Explicit line break
                if($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl == 2) {
                    $b = $b2;
                }
                continue;
            }
            if($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if($l > $wmax) {
                // Automatic line break
                if($sep == -1) {
                    if($i == $j) {
                        $i++;
                    }
                    if($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                } else {
                    if($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl == 2) {
                    $b = $b2;
                }
            } else {
                $i++;
            }
        }
        // Last chunk
        if($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if($border && strpos($border, 'B') !== false) {
            $b .= 'B';
        }
        $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
        $this->x = $this->lMargin;

        // Custom Tomaz Ahlin
        if($ln == 0) {
            $this->SetXY($current_x + $w, $current_y);
        }
    }











    public function CellFit($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {

        //Get string width

        $str_width = $this->GetStringWidth($txt);


        //Calculate ratio to fit cell

        if($w == 0) {

            $w = $this->w - $this->rMargin - $this->x;
        }

        $ratio = ($w - $this->cMargin * 2) / $str_width;


        $fit = ($ratio < 1 || ($ratio > 1 && $force));

        if ($fit) {

            if ($scale) {

                //Calculate horizontal scaling

                $horiz_scale = $ratio * 100.0;

                //Set horizontal scaling

                $this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));

            } else {

                //Calculate character spacing in points

                $char_space = ($w - $this->cMargin * 2 - $str_width) / max($this->MBGetStringLength($txt) - 1, 1) * $this->k;

                //Set character spacing

                $this->_out(sprintf('BT %.2F Tc ET', $char_space));

            }

            //Override user alignment (since text will fill up cell)

            $align = '';

        }


        //Pass on to Cell method

        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);


        //Reset character spacing/horizontal scaling

        if ($fit) {

            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
        }

    }


    public function CellFitSpace($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {

        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, false);

    }


    //Patch to also work with CJK double-byte text

    public function MBGetStringLength($s)
    {

        if($this->CurrentFont['type'] == 'Type0') {

            $len = 0;

            $nbbytes = strlen($s);

            for ($i = 0; $i < $nbbytes; $i++) {

                if (ord($s[$i]) < 128) {

                    $len++;
                } else {

                    $len++;

                    $i++;

                }

            }

            return $len;

        } else {

            return strlen($s);
        }

    }

    ################################## FIN DEL CODIGO PARA AJUSTAR TEXTO EN CELDAS #########################################





    public function saveFont()
    {

        $saved = array();

        $saved[ 'family' ] = $this->FontFamily;
        $saved[ 'style' ] = $this->FontStyle;
        $saved[ 'sizePt' ] = $this->FontSizePt;
        $saved[ 'size' ] = $this->FontSize;
        $saved[ 'curr' ] = &$this->CurrentFont;

        return $saved;

    }

    public function restoreFont($saved)
    {

        $this->FontFamily = $saved[ 'family' ];
        $this->FontStyle = $saved[ 'style' ];
        $this->FontSizePt = $saved[ 'sizePt' ];
        $this->FontSize = $saved[ 'size' ];
        $this->CurrentFont = &$saved[ 'curr' ];

        if($this->page > 0) {
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont[ 'i' ], $this->FontSizePt));
        }

    }

    public function newFlowingBlock($w, $h, $b = 0, $a = 'J', $f = 0)
    {

        // cell width in points
        $this->flowingBlockAttr[ 'width' ] = $w * $this->k;

        // line height in user units
        $this->flowingBlockAttr[ 'height' ] = $h;

        $this->flowingBlockAttr[ 'lineCount' ] = 0;

        $this->flowingBlockAttr[ 'border' ] = $b;
        $this->flowingBlockAttr[ 'align' ] = $a;
        $this->flowingBlockAttr[ 'fill' ] = $f;

        $this->flowingBlockAttr[ 'font' ] = array();
        $this->flowingBlockAttr[ 'content' ] = array();
        $this->flowingBlockAttr[ 'contentWidth' ] = 0;

    }

    public function finishFlowingBlock()
    {

        $maxWidth = &$this->flowingBlockAttr[ 'width' ];

        $lineHeight = &$this->flowingBlockAttr[ 'height' ];

        $border = &$this->flowingBlockAttr[ 'border' ];
        $align = &$this->flowingBlockAttr[ 'align' ];
        $fill = &$this->flowingBlockAttr[ 'fill' ];

        $content = &$this->flowingBlockAttr[ 'content' ];
        $font = &$this->flowingBlockAttr[ 'font' ];

        // set normal spacing
        $this->_out(sprintf('%.3F Tw', 0));

        // print out each chunk

        // the amount of space taken up so far in user units
        $usedWidth = 0;

        foreach ($content as $k => $chunk) {

            $b = '';

            if (is_int(strpos($border, 'B'))) {
                $b .= 'B';
            }

            if ($k == 0 && is_int(strpos($border, 'L'))) {
                $b .= 'L';
            }

            if ($k == count($content) - 1 && is_int(strpos($border, 'R'))) {
                $b .= 'R';
            }

            $this->restoreFont($font[ $k ]);

            // if it's the last chunk of this line, move to the next line after
            if ($k == count($content) - 1) {
                $this->Cell(($maxWidth / $this->k) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill);
            } else {
                $this->Cell($this->GetStringWidth($chunk), $lineHeight, $chunk, $b, 0, $align, $fill);
            }

            $usedWidth += $this->GetStringWidth($chunk);

        }

    }

    public function WriteFlowingBlock($s)
    {

        // width of all the content so far in points
        $contentWidth = &$this->flowingBlockAttr[ 'contentWidth' ];

        // cell width in points
        $maxWidth = &$this->flowingBlockAttr[ 'width' ];

        $lineCount = &$this->flowingBlockAttr[ 'lineCount' ];

        // line height in user units
        $lineHeight = &$this->flowingBlockAttr[ 'height' ];

        $border = &$this->flowingBlockAttr[ 'border' ];
        $align = &$this->flowingBlockAttr[ 'align' ];
        $fill = &$this->flowingBlockAttr[ 'fill' ];

        $content = &$this->flowingBlockAttr[ 'content' ];
        $font = &$this->flowingBlockAttr[ 'font' ];

        $font[] = $this->saveFont();
        $content[] = '';

        $currContent = &$content[ count($content) - 1 ];

        // where the line should be cutoff if it is to be justified
        $cutoffWidth = $contentWidth;

        // for every character in the string
        for ($i = 0; $i < strlen($s); $i++) {

            // extract the current character
            $c = $s[ $i ];

            // get the width of the character in points
            $cw = $this->CurrentFont[ 'cw' ][ $c ] * ($this->FontSizePt / 1000);

            if ($c == ' ') {

                $currContent .= ' ';
                $cutoffWidth = $contentWidth;

                $contentWidth += $cw;

                continue;

            }

            // try adding another char
            if ($contentWidth + $cw > $maxWidth) {

                // won't fit, output what we have
                $lineCount++;

                // contains any content that didn't make it into this print
                $savedContent = '';
                $savedFont = array();

                // first, cut off and save any partial words at the end of the string
                $words = explode(' ', $currContent);

                // if it looks like we didn't finish any words for this chunk
                if (count($words) == 1) {

                    // save and crop off the content currently on the stack
                    $savedContent = array_pop($content);
                    $savedFont = array_pop($font);

                    // trim any trailing spaces off the last bit of content
                    $currContent = &$content[ count($content) - 1 ];

                    $currContent = rtrim($currContent);

                }

                // otherwise, we need to find which bit to cut off
                else {

                    $lastContent = '';

                    for ($w = 0; $w < count($words) - 1; $w++) {
                        $lastContent .= "{$words[ $w ]} ";
                    }

                    $savedContent = $words[ count($words) - 1 ];
                    $savedFont = $this->saveFont();

                    // replace the current content with the cropped version
                    $currContent = rtrim($lastContent);

                }

                // update $contentWidth and $cutoffWidth since they changed with cropping
                $contentWidth = 0;

                foreach ($content as $k => $chunk) {

                    $this->restoreFont($font[ $k ]);

                    $contentWidth += $this->GetStringWidth($chunk) * $this->k;

                }

                $cutoffWidth = $contentWidth;

                // if it's justified, we need to find the char spacing
                if($align == 'J') {

                    // count how many spaces there are in the entire content string
                    $numSpaces = 0;

                    foreach ($content as $chunk) {
                        $numSpaces += substr_count($chunk, ' ');
                    }

                    // if there's more than one space, find word spacing in points
                    if ($numSpaces > 0) {
                        $this->ws = ($maxWidth - $cutoffWidth) / $numSpaces;
                    } else {
                        $this->ws = 0;
                    }

                    $this->_out(sprintf('%.3F Tw', $this->ws));

                }

                // otherwise, we want normal spacing
                else {
                    $this->_out(sprintf('%.3F Tw', 0));
                }

                // print out each chunk
                $usedWidth = 0;

                foreach ($content as $k => $chunk) {

                    $this->restoreFont($font[ $k ]);

                    $stringWidth = $this->GetStringWidth($chunk) + ($this->ws * substr_count($chunk, ' ') / $this->k);

                    // determine which borders should be used
                    $b = '';

                    if ($lineCount == 1 && is_int(strpos($border, 'T'))) {
                        $b .= 'T';
                    }

                    if ($k == 0 && is_int(strpos($border, 'L'))) {
                        $b .= 'L';
                    }

                    if ($k == count($content) - 1 && is_int(strpos($border, 'R'))) {
                        $b .= 'R';
                    }

                    // if it's the last chunk of this line, move to the next line after
                    if ($k == count($content) - 1) {
                        $this->Cell(($maxWidth / $this->k) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill);
                    } else {

                        $this->Cell($stringWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 0, $align, $fill);
                        $this->x -= 2 * $this->cMargin;

                    }

                    $usedWidth += $stringWidth;

                }

                // move on to the next line, reset variables, tack on saved content and current char
                $this->restoreFont($savedFont);

                $font = array( $savedFont );
                $content = array( $savedContent . $s[ $i ] );

                $currContent = &$content[ 0 ];

                $contentWidth = $this->GetStringWidth($currContent) * $this->k;
                $cutoffWidth = $contentWidth;

            }

            // another character will fit, so add it on
            else {

                $contentWidth += $cw;
                $currContent .= $s[ $i ];

            }

        }

    }

    ########### FUNCION PARA CODIGO DE BARRA CON CODABAR ############
    public function Codabar($xpos, $ypos, $code, $start = 'A', $end = 'A', $basewidth = 0.12, $height = 10)
    {
        $barChar = array(
            '0' => array(6.5, 4.4, 6.5, 3.4, 6.5, 7.3, 2.9),
            '1' => array(6.5, 4.4, 6.5, 8.4, 4.9, 4.3, 6.5),
            '2' => array(6.5, 4.0, 6.5, 9.4, 6.5, 3.0, 8.6),
            '3' => array(17.9, 24.3, 6.5, 6.4, 6.5, 3.4, 6.5),
            '4' => array(6.5, 2.4, 8.9, 6.4, 6.5, 4.3, 6.5),
            '5' => array(5.9,	2.4, 6.5, 6.4, 6.5, 4.3, 6.5),
            '6' => array(6.5, 8.3, 6.5, 6.4, 6.5, 6.4, 7.9),
            '7' => array(6.5, 8.3, 6.5, 2.4, 7.9, 6.4, 6.5),
            '8' => array(6.5, 8.3, 5.9, 10.4, 6.5, 6.4, 6.5),
            '9' => array(7.6, 5.0, 6.5, 8.4, 6.5, 3.0, 6.5),
            '$' => array(6.5, 5.0, 18.6, 24.4, 6.5, 10.0, 6.5),
            '-' => array(6.5, 5.0, 6.5, 4.4, 8.6, 10.0, 6.5),
            ':' => array(16.7, 9.3, 6.5, 9.3, 16.7, 9.3, 14.7),
            '/' => array(14.7, 9.3, 16.7, 9.3, 6.5, 9.3, 16.7),
            '.' => array(13.6, 10.1, 14.9, 10.1, 17.2, 10.1, 6.5),
            '+' => array(6.5, 10.1, 17.2, 10.1, 14.9, 10.1, 13.6),
            'A' => array(6.5, 8.0, 19.6, 19.4, 6.5, 16.1, 6.5),
            'T' => array(6.5, 8.0, 19.6, 19.4, 6.5, 16.1, 6.5),
            'B' => array(6.5, 16.1, 6.5, 19.4, 6.5, 8.0, 19.6),
            'N' => array(6.5, 16.1, 6.5, 19.4, 6.5, 8.0, 19.6),
            'C' => array(6.5, 8.0, 6.5, 19.4, 6.5, 16.1, 19.6),
            '*' => array(6.5, 8.0, 6.5, 19.4, 6.5, 16.1, 19.6),
            'D' => array(6.5, 8.0, 6.5, 19.4, 19.6, 16.1, 6.5),
            'E' => array(6.5, 8.0, 6.5, 19.4, 19.6, 16.1, 6.5),
        );
        $this->SetFont('Arial', '', 8.5);
        $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco 259)
        $this->Text($xpos, $ypos + $height + 2, $code);
        $this->SetFillColor(0);
        $code = strtoupper($start.$code.$end);
        for($i = 0; $i < strlen($code); $i++) {
            $char = $code[$i];
            if(!isset($barChar[$char])) {
                $this->Error('Invalid character in barcode: '.$char);
            }
            $seq = $barChar[$char];
            for($bar = 0; $bar < 7; $bar++) {
                $lineWidth = $basewidth * $seq[$bar] / 4;
                if($bar % 2 == 0) {
                    $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
                }
                $xpos += $lineWidth;
            }
            $xpos += $basewidth * 10.4 / 6.5;
        }
    }

    public function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'R') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'L') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'U') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'D') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } else {
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        }
        if ($this->ColorFlag) {
            $s = 'q '.$this->TextColor.' '.$s.' Q';
        }
        $this->_out($s);
    }

    public function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle = 0)
    {
        $font_angle += 90 + $txt_angle;
        $txt_angle *= M_PI / 180;
        $font_angle *= M_PI / 180;

        $txt_dx = cos($txt_angle);
        $txt_dy = sin($txt_angle);
        $font_dx = cos($font_angle);
        $font_dy = sin($font_angle);

        $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', $txt_dx, $txt_dy, $font_dx, $font_dy, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->ColorFlag) {
            $s = 'q '.$this->TextColor.' '.$s.' Q';
        }
        $this->_out($s);
    }
    // FIN Class PDF
}
