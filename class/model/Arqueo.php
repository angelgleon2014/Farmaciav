<?php

require_once('Model.php');

$inc = get_include_path();

set_include_path(substr(__DIR__, 0, strpos(__DIR__, "model")));

require_once('class.php');

set_include_path($inc);

class Arqueo extends Model
{
    protected static $table_name = 'arqueocaja';
    protected $primary_key = 'codarqueo';

    public static function findCurrent()
    {
        $l = new Login();
        $caja = $l->VerificaCaja()[0];
        return Arqueo::findOne([['codcaja', '=', $caja['codcaja']], ['statusarqueo', '=', 1]]);
    }
    
}

?>
