<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("class/classconexion.php");

class Misc extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function update()
    {
        $sql = "ALTER TABLE `productos` ADD COLUMN `precioventablister` float(10,2) AFTER `statusp`, ADD COLUMN `blisterunidad` int(11) AFTER `precioventablister`, ADD COLUMN `stockblister` int(11) AFTER `blisterunidad`;";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        $sql = "ALTER TABLE `productos` CHANGE COLUMN `ivaproducto` `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'SI';";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        $sql = "UPDATE productos SET ivaproducto = 'SI';";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();


        echo 'Actualización con éxito';

    }
}

try {
    $upd = new Misc();
    $upd->update();

} catch (Exception $e) {
    echo 'Se detectó el siguiente error: ',  $e->getMessage(), "\n";
}
