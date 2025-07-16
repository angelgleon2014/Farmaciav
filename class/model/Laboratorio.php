<?php

require_once('Model.php');

class Laboratorio extends Model
{
    protected static $table_name = 'laboratorios';
    protected $primary_key = 'codlaboratorio';
}

?>