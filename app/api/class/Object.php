<?php

require_once 'Database.php';

class Object implements ArrayAccess {
    protected $data = array();
    protected $changes = array();
    
    public function __construct($data = array()) {
        foreach($data as $key => $value)
            if(!is_numeric($key)) $this->data[$key] = $value;
    }
    
    public static function fromQuery($query) {
        $res = Database::query($query);
        
        if(!$res) return null;
        
        $arr = mysqli_fetch_array($res);
        
        return $arr == null ? null : new Object($arr);
    }
    
    public static function allFromQuery($query) {
        $res = Database::query(query);
        
        if(!$res) return null;
        return self::buildArr($res);
    }
    
    public static function fromTable($table, $col = false, $val = false) {
        if($col === false)
            return static::fromQuery("SELECT * FROM $table LIMIT 1");
        else
            return static::fromQuery("SELECT * FROM $table WHERE $col='$val'");
    }
    
    public static function allFromTable($table, $col = false, $value = false) {
        if($col === false)
            return static::allFromQuery("SELECT * FROM $table");
        else
            return static::allFromQuery("SELECT * FROM $table WHERE $col='$val'");
    }
    
    protected static function buildArr($res)
    {
        $vals = array(); $index = 0;
        while($row = mysqli_fetch_array($res))
            $vals[$index++] = new Object($row);
        return $index == 0 ? null : $vals;
    }
    
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset) {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value) {
        $changes[] = $offset;
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
    
    public function set($offset, $value) {
        $this[$offset] = $value;
    }
    
    public function setSneaky($offset, $value) {
        $this->data[$offset] = $value;
    }
    
    public function get($offset) {
        return $this[$offset];
    }
    
    public function json() {
        return json_encode($this->data);
    }
    
    public function resolveRelationships($depth = 1) {
        if($depth <= 0) return;
        
        foreach(getRelationships() as $relKey => $relationship) {
            switch($relationship["type"]) {
                case "Direct":
                    $obj = static::grabObject($relationship, get($relKey));
                    $obj->resolveRelationships($depth - 1);
                    setSneaky($relKey, $obj);
                    break;
                case "Indirect":
                    $obj = static::grabJoinObject($relationship, $this[$relationship["local"]["variable"]]);
                    $obj->resolveRelationships($depth - 1);
                    setSneaky($relKey, $obj); // TODO
                    break;
            }
        }
    }
    
    public static function grabObject($relationship, $value) {
        return static::fromTable($relationship["object"], $relationship["variable"], $value);
    }
    
    public static function grabJoinObject($relationship, $variable) {
        $res = array();
        
        $temp = static::allFromTable($relationship["join"], $relationShip["local"]["join"], $variable);
        
        foreach($temp as $key => $value)
            $res[] = static::grabObject(array(
                "object" => $relationship["remote"]["table"],
                "variable" => $relationship["remote"]["variable"]
            ), $value[$relationship["remote"]["join"]]);
        
        return $res;
    }
    
    /*
     * Types:
     * Direct:
     * variable - The remote variable to search on
     * object - The name of the remote object (as a table)
     * 
     * Indirect:
     * join - The join-through table to search on
     * local - An array:
     *  variable - The local variable that corresponds to the join
     *  join - The join variable that corresponds
     * remote - An array:
     *  variable - The variable in that object
     *  join - The join variable that corresponds
     *  table - The remote table.
     * 
     */
    public function getRelationships() {
        return array();
    }
}

?>
