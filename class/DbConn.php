<?php

require_once('classconexion.php');

class DbConn extends Db
{
    private static $conn = null;
    function __construct()
    {
        parent::__construct();
        if (!self::$conn) self::$conn = $this->dbh;
    }

    static function query($sql)
    {
        echo $sql;
        return self::$conn->query($sql);
    }

    static function execute($sql, $params)
    {
        $stmt = self::$conn->prepare($sql);
        return $stmt->execute($params);
    }

    static function fetchOne($sql, $params)
    {
        $stmt = self::$conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static function fetchAll($sql, $params)
    {
        $stmt = self::$conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

new DbConn();

?>