<?php



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
}

