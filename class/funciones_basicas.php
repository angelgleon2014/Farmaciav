<?php

## funcion para prevenir ataques XSS
function limpiar($tags)
{
    $tags = strip_tags($tags);
    $tags = stripslashes($tags);
    $tags = htmlentities($tags);
    return $tags;
}

#####CONTRASE�A DE-ENCRIPTAR

function encrypt($string, $key)
{
    $result = '';
    $key = $key.'2013';
    for($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}

function decrypt($string, $key)
{
    $result = '';
    $key = $key.'2013';
    $string = base64_decode($string);
    for($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result .= $char;
    }
    return $result;
}



function limpiarEntrada($texto)
{

    //creamos un arreglo que sirva de patrones para eliminar partes no deseadas en las cadenas
    $busqueda = array(
    '@<script[^>]*?>.*?</script>@si',   // quitar javascript
    '@<[\/\!]*?[^<>]*?>@si',            // quitar tags de HTML
    '@<style[^>]*?>.*?</style>@siU',    // quitar estilos
    '@<![\s\S]*?--[ \t\n\r]*>@'         // quitar comentarios multil�nea
    );

    //utilizamos la funci�n preg_replace que busca en una cadena patrones para sustituir
    $salida = preg_replace($busqueda, '', $texto);
    //devolvemos la cadena sin los patrones encontrados
    return $salida;
}


function edad($fecha_nac)
{
    //Esta funcion toma una fecha de nacimiento
    //desde una base de datos mysql
    //en formato aaaa/mm/dd y calcula la edad en numeros enteros

    $dia = date("j");
    $mes = date("n");
    $anno = date("Y");

    //descomponer fecha de nacimiento
    $dia_nac = substr($fecha_nac, 8, 2);
    $mes_nac = substr($fecha_nac, 5, 2);
    $anno_nac = substr($fecha_nac, 0, 4);


    if($mes_nac > $mes) {
        $calc_edad = $anno - $anno_nac - 1;
    } else {
        if($mes == $mes_nac and $dia_nac > $dia) {
            $calc_edad = $anno - $anno_nac - 1;
        } else {
            $calc_edad = $anno - $anno_nac;
        }
    }
    return $calc_edad;
}



function estado($muestra)
{

    if($muestra == "administradorG") {
        echo "ADMINISTRADOR GENERAL";
    } elseif ($muestra == "administradorS") {
        echo "ADMINISTRADOR SUCURSAL";
    } elseif ($muestra == "cajero") {
        echo "CAJERO(A)";
    } elseif ($muestra == "bodega") {
        echo "BODEGA";
    }
}

function convertir($string)
{
    $string = str_replace(
        array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'),
        array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', ' DIC'),
        $string
    );
    return $string;
}

function meses($string)
{
    $string = str_replace(
        array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
        array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', ' DICIEMBRE'),
        $string
    );
    return $string;
}

function dias($string)
{
    $string = str_replace(
        array('0', '1', '2', '3', '4', '5', '6'),
        array('DOM..', 'LUN.', 'MART.', 'MIERC.', 'JUEV.', 'VIER.', 'SAB.'),
        $string
    );
    return $string;
}

function generar_clave($longitud)
{
    $cadena = "[^A-Z0-9]";
    return substr(
        preg_replace($cadena, "", sha1(md5(rand()))) .
           preg_replace($cadena, "", sha1(md5(rand()))) .
           preg_replace($cadena, "", sha1(md5(rand()))),
        0,
        $longitud
    );
}

//M�todo con rand()
function GenerateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function GenerateRandomStringg($length = 49)
{
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//M�todo con str_shuffle()
function generateRandomString2($length = 50)
{
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}



function random_string($length)
{
    switch(true) {
        case function_exists('mcrypt_create_iv'):
            $r = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            break;
        case function_exists('openssl_random_pseudo_bytes'):
            $r = openssl_random_pseudo_bytes($length);
            break;
        case is_readable('/dev/urandom'): // deceze
            $r = file_get_contents('/dev/urandom', false, null, 0, $length);
            break;
        default:
            $i = 0;
            $r = '';
            while($i++ < $length) {
                $r .= chr(mt_rand(0, 255));
            }
            break;
    }
    return substr(bin2hex($r), 0, $length);
}


function formatear($valor)
{
    $a = explode(".", $valor);
    $b = substr($a[1], 0, 2);
    $numero = $a[0].".".$b;

    return $numero;
}

function formatear2($number, $digitos)
{
    $raiz = 10;
    $multiplicador = pow($raiz, $digitos);
    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
    return number_format($resultado, $digitos, '.', '.');

}

function rount($number, $digitos)
{
    $raiz = 10;
    $multiplicador = pow($raiz, $digitos);
    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
    return number_format($resultado, $digitos, '.', '');

}

function removeEmptyElements(&$element)
{
    if (is_array($element)) {
        if ($key = key($element)) {
            $element[$key] = array_filter($element);
        }

        if (count($element) != count($element, COUNT_RECURSIVE)) {
            $element = array_filter(current($element), __FUNCTION__);
        }

        $element = array_filter($element);

        return $element;
    } else {
        return empty($element) ? false : $element;
    }
}

########### CALCULAR DIAS TRANSCURRIDOS ENTRE DOS FECHAS CONTANDO PURO DIAS HABILES #########
function fechas($start, $end)
{
    $range = array();

    if (is_string($start) === true) {
        $start = strtotime($start);
    }
    if (is_string($end) === true) {
        $end = strtotime($end);
    }

    if ($start > $end) {
        return createDateRangeArray($end, $start);
    }

    do {
        $range[] = date('Y-m-d', $start);
        $start = strtotime("+ 1 day", $start);
    } while($start <= $end);

    return $range;
}
########### CALCULAR DIAS TRANSCURRIDOS ENTRE DOS FECHAS #########
function Dias_Transcurridos($fecha_i, $fecha_f)
{
    $dias	= (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
    $dias 	= abs($dias);
    $dias = floor($dias);
    return $dias;
}
########### CACLULAR DIAS DE RETRASO ENTRE DOS FECHAS #########
function atraso($fecha)
{
    return floor((time() - strtotime($fecha)) / (60 * 60 * 24));
}

function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
    //
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el l�mite a 6 d�gitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya lleg� al l�mite m�ximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres d�gitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres d�gitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (true === array_key_exists($key, $xarray)) {  // busco si la centena es n�mero redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Mill�n, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100) {
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                } else {
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                }
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            } else { // entra aqu� si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma l�gica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {

                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (true === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20) {
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                } else {
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                }
                                $xy = 3;
                            } else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10) {
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } else {
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                }
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") { // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena .= " DE";
        }

        if (substr(trim($xcadena), -7, 7) == "ILLONES") { // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena .= " DE";
        }

        // ----------- esta l�nea la puedes cambiar de acuerdo a tus necesidades o a tu pa�s -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1") {
                        $xcadena .= "UN BILLON ";
                    } else {
                        $xcadena .= " BILLONES ";
                    }
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1") {
                        $xcadena .= "UN MILLON ";
                    } else {
                        $xcadena .= " MILLONES ";
                    }
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO SOLES $xdecimales/100 M.N.";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN SOL $xdecimales/100 M.N. ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena .= " SOLES $xdecimales/100 M.N. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para M�xico se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta funci�n regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3) {
        $xsub = "";
    }
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6) {
        $xsub = "MIL";
    }
    //
    return $xsub;
}


function getSubString($string, $length = null)
{
    //Si no se especifica la longitud por defecto es 50
    if ($length == null) {
        $length = 40;
    }
    //Primero eliminamos las etiquetas html y luego cortamos el string
    $stringDisplay = substr(strip_tags($string), 0, $length);
    //Si el texto es mayor que la longitud se agrega puntos suspensivos
    if (strlen(strip_tags($string)) > $length) {
        $stringDisplay .= '.';
    }
    return $stringDisplay;
}
