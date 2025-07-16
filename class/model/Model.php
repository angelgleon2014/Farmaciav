<?php

error_reporting(E_ALL);

$inc = get_include_path();

set_include_path(substr(__DIR__, 0, strpos(__DIR__, "model")));

require_once('DbConn.php');

set_include_path($inc);


/**
 * @param $where array of arrays of the shape [column, operator, value]
 * For example Model::findOne(['price', '=', 12], ['name', 'LIKE', 'John%']);
 */
function constructWhere($where)
{
    $whereClauses = [];
    $values = [];
    foreach ($where as $cond) {
        $whereClauses[] = ' ' . $cond[0] . ' ' . $cond[1] . ' ? ';
        $values[] = $cond[2];
    }

    return [join(' AND ', $whereClauses), $values];
};

abstract class Model implements ArrayAccess, IteratorAggregate
{

    protected static $table_name = '';
    protected $primary_key = '';
    public $data = array();
    private $fromDb = false;


    function __construct($props)
    {
        $this->data = [];
        foreach($props as $k => $v) $this->data[$k] = $v;
    }

    /**
     * @param $where array of arrays of the shape [column, operator, value]
     * For example Model::findOne(['price', '=', 12], ['name', 'LIKE', 'John%']);
     */

    static function findOne($where)
    {

        [$whereStr, $values] = constructWhere($where);

        $sql = "SELECT * FROM "
            . static::$table_name
            . " WHERE "
            . $whereStr
            . " LIMIT 1";

        $res = new static(DbConn::fetchOne($sql, $values));
        $res->fromDb = true;
        return $res;
    }


    /**
     * @param $where array of arrays of the shape [column, operator, value]
     * For example Model::findOne(['price', '=', 12], ['name', 'LIKE', 'John%']);
     */
    static function findAll($where)
    {
        [$whereStr, $values] = constructWhere($where);

        $sql = "SELECT * FROM "
            . static::$table_name
            . " WHERE "
            . $whereStr;

        $all = DbConn::fetchAll($sql, $values);
        $res = [];
        foreach ($all as $row){
            $r = new static($row);
            $r->fromDb = true;
            $res[] = $r;
        }
        return $res;
    }

    public function save()
    {

        if ($this->fromDb) {
            $setterStrs = [];
            $values = [];
            foreach ($this->data as $k => $v) {
                $setterStrs[] = " $k = ? ";
                $values[] = $v;
            }

            $setterStr = join(",", $setterStrs);

            $sql = "UPDATE " . static::$table_name
                . " SET $setterStr"
                . " WHERE $this->primary_key=?";
            
            $values[] = $this[$this->primary_key];

            return DbConn::execute($sql, $values);
        } else {
            $columnsStrs = [];
            $valuesStrs = [];
            $values = [];
            foreach ($this->data as $k => $v) {
                $columnsStrs[] = " $k ";
                $valuesStrs[] = " ? ";
                $values[] = $v;
            }

            $columnsStr = "(" . join(",", $columnsStrs) . ")";
            $valuesStr = "(" . join(",", $valuesStrs) . ")";
            return DbConn::execute(
                "INSERT INTO " . static::$table_name . $columnsStr
                    . " VALUES $valuesStr",
                $values
            );
        }
    }

    public function delete()
    {
        return DbConn::execute(
            "DELETE FROM " . static::$table_name . " WHERE $this->primary_key= ? ",
            [$this[$this->primary_key]]
        );
    }

    public function print($dbCols = null)
    {
        if ($dbCols) $cols = $dbCols;
        else {
            $cols = [];
            foreach ($this->data as $k => $_v) {
                $cols[] = $k;
            }
        }

        sort($cols);

        echo "<table style='border: 1px solid black'><tr>";

        foreach ($cols as $col) {
            echo "<th style='border: 1px solid black'>$col</th>";
        }
        echo "</tr><tr>";

        foreach ($cols as $col) {
            echo "<td style='border: 1px solid black'>" . $this->data[$col] . "</td>";
        }
        echo "</tr></table><br>";
    }

    public function toJson()
    {
        return json_encode($this->data);
    }

    public function offsetSet($offset, $value): void
    {
        // TODO: Prevent mutating primary key
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->data);
    }
}
