<?php

require_once("Database.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Represents any abstract object in a database. Useful for being extend from, for a variety of classes.
 * Notice: Can only be currently used when a unique identifier exists in the database.
 * @author Tres
 */
class Row {
 
    protected $data;
    
    public function __construct($dat) {
        $realArr = array();
        foreach($dat as $key => $value)
            if(!is_numeric($key)) $realArr[$key] = $value;
        $this->data = $realArr;
    }
    
    public static function fromCustom($query)
    {
        return self::intCustomFrom("Row", $query);
    }
    
    public static function fromTable($table) {
        
    }
    
    public static function allFromCustom($query)
    {
        return self::intCustomAllFrom("Row", $query);
    }

    protected static function intFrom($type, $table, $col, $val)
    {
        $res = Database::query("SELECT * FROM $table WHERE $col='$val'");
        if(!$res) return null;
        $arr = mysqli_fetch_array($res);
        return $arr == null ? null : new $type($arr);
    }
    
    protected static function intAllFrom($type, $table, $col, $val)
    {
        $res = Database::query("SELECT * FROM $table WHERE $col='$val'");
        if(!$res) return null;
        return self::buildArr($type, $res);
    }
    
    protected static function intAllFromRegex($type, $table, $col, $regex)
    {
        $res = Database::query("SELECT * FROM $table WHERE $col REGEXP '$regex'");
        if(!$res) return null;
        return self::buildArr($type, $res);
    }

    protected static function buildArr($type, $res)
    {
        $vals = array(); $index = 0;
        while($row = mysqli_fetch_array($res))
            $vals[$index++] = new $type($row);
        return $index == 0 ? null : $vals;
    }
    
    protected static function intCustomFrom($type, $query)
    {
        $res = Database::query($query);
        if(!$res) return null;
        $arr = mysqli_fetch_array($res);
        return $arr == null ? null : new $type($arr);
    }
    
    protected static function intCustomAllFrom($type, $query)
    {
        $res = Database::query($query);
        if(!$res) return null;
        return self::buildArr($type, $res);
    }
    
    public function get($name)
    {
        return $this->data[$name];
    }
    
    public function set($name, $val)
    {
        $this->data[$name] = $val;
    }
    
    public function getTable() { return "none"; }
    public function getUnique() { return "id"; }
    
    public function getSpecialSaveValues()
    {
        return array();
    }
    
    // For updating a value
    protected function intPush()
    {
        $updateCore = "";
        $table = $this->getTable();
        $uni = $this->getUnique(); $uniVal = $this->get($uni);
        foreach($this->data as $key => $value)
        {
            if(strcmp($key, $uni) == 0) continue;
            $updateCore .= (strlen($updateCore) == 0 ? "" : ",") . $key . "='" . Database::sanitize($value) . "'";
        }
        return Database::query("UPDATE $table SET $updateCore WHERE $uni='$uniVal'");
    }
    
    // Assumes all neccessary fields are provided.
    protected function intSave()
    {
        $cols = "(";
        $vals = "(";
        $table = $this->getTable();
        foreach($this->data as $key => $value)
        {
            $cols .= (strlen($cols) == 1 ? "" : ",") . $key;
            $vals .= (strlen($vals) == 1 ? "" : ",") . "'$value'";
        }
        foreach($this->getSpecialSaveValues() as $key => $value)
        {
            if(array_key_exists($key, $this->data)) continue;
            $cols .= (strlen($cols) == 1 ? "" : ",") . $key;
            $vals .= (strlen($vals) == 1 ? "" : ",") . $value;
        }
        $cols .= ")";
        $vals .= ")";
        Database::query("INSERT INTO $table $cols VALUES $vals");
    }
    
    protected function intDelete()
    {
        $uni = $this->getUnique();
        $uniVal = $this->get($uni);
        $table = $this->getTable();
        Database::query("DELETE FROM $table WHERE $uni='$uniVal'");
    }
}

?>
