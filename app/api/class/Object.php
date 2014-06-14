<?php

require_once 'Database.php';

class Object implements ArrayAccess, JsonSerializable {
    protected $data = array();
    protected $ref = array();
    protected $changes = array();
    
    public function __construct($data = array()) {
        foreach($data as $key => $value)
            if(!is_numeric($key)) $this->data[$key] = $value;
    }
    
    public static function fromQuery($query, $type = "Object") {
        $res = Database::query($query);
        
        if(!$res) return null;
        
        $arr = mysqli_fetch_array($res);
        
        return $arr == null ? null : new $type($arr);
    }
    
    public static function allFromQuery($query, $type = "Object") {
        $res = Database::query($query);
        
        if(!$res) return null;
        return self::buildArr($res, $type);
    }
    
    public static function fromTable($table, $col = false, $value = false, $type = "Object") {
        if($col === false)
            return static::fromQuery("SELECT * FROM $table LIMIT 1", $type);
        else
            return static::fromQuery("SELECT * FROM $table WHERE $col='$value'", $type);
    }
    
    public static function allFromTable($table, $col = false, $value = false, $type = "Object") {
        if($col === false)
            return static::allFromQuery("SELECT * FROM $table", $type);
        else
            return static::allFromQuery("SELECT * FROM $table WHERE $col='$value'", $type);
    }
    
    protected static function buildArr($res, $type = "Object")
    {
        $vals = array(); $index = 0;
        while($row = mysqli_fetch_array($res))
            $vals[$index++] = new $type($row);
        return $index == 0 ? null : $vals;
    }
    
    public function offsetExists($offset) {
        return isset($this->data[$offset]) || isset($this->ref[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : $this->ref[$offset];
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
        $this->ref[$offset] = $value;
    }
    
    public function get($offset) {
        return $this[$offset];
    }
    
    public function json($pretty = false) {
        return json_encode($this, $pretty ? JSON_PRETTY_PRINT : 0);
    }
    
    public function resolve($depth = 1) {
        if($depth <= 0) return;
        
        foreach($this->getRelationships() as $relationship) {
            if($relationship["type"] === "Direct-Parent") {
                $obj = static::grabObject($relationship, $this->get($relationship["key"]), $relationship["target"]["type"]);

                $obj->resolve($depth - 1);
                $this->setSneaky($relationship["name"], $obj);
            }
            else if($relationship["type"] === "Direct-Children") {
                $obj = static::grabChildren($relationship, $this[$relationship["key"]], $relationship["target"]["type"]);
                if(is_null($obj)) {
                    $this->setSneaky($relationship["name"], array());
                    continue;
                }
                foreach($obj as $key => $value)
                    $value->resolve($depth - 1);
                $this->setSneaky($relationship["name"], $obj);
            }
            else if($relationship["type"] === "Indirect") {
                $obj = static::grabJoinObject($relationship, $this[$relationship["local"]["key"]], $relationship["remote"]["type"]);

                foreach($obj as $value)
                    $value->resolve($depth - 1);
                $this->setSneaky($relationship["name"], $obj);
                break;
            } else {
                echo $relationship["type"];
            }
        }
    }
    
    public static function grabObject($relationship, $value, $type = "Object") {
        return static::fromTable($relationship["target"]["table"], $relationship["target"]["key"], $value, $type);
    }
    
    public static function grabChildren($relationship, $value, $type = "Object") {
        return static::allFromTable($relationship["target"]["table"], $relationship["target"]["key"], $value, $type);
    }
    
    public static function grabJoinObject($relationship, $variable, $type = "Object") {
        $result = array();
        
        $temp = static::allFromTable($relationship["join"]["table"], $relationship["join"]["localkey"], $variable);
        
        if(!$temp || is_null($temp)) return $result;
        
        foreach($temp as $res)
            $result[] = static::fromTable($relationship["remote"]["table"], $relationship["remote"]["key"], $res[$relationship["join"]["remotekey"]], $type);

        return $result;
    }
    
    public function insert($table = null) {
        $cols = "(";
        $vals = "(";
        if(is_null($table)) $table = $this->getTable();
        
        foreach($this->data as $key => $value)
        {
            $cols .= (strlen($cols) == 1 ? "" : ",") . $key;
            $vals .= (strlen($vals) == 1 ? "" : ",") . "'$value'";
        }

        $cols .= ")";
        $vals .= ")";
        Database::query("INSERT INTO $table $cols VALUES $vals");
        
        return Database::id();
    }
    
    public function update($table = null, $uni = null) {
        $updateCore = "";
        
        if(is_null($uni)) $uni = $this->getUnique();
        if(is_null($table)) $table = $this->getTable();
        
        $uniVal = $this->data[$uni];
        foreach($this->data as $key => $value)
        {
            if(strcmp($key, $uni) == 0) continue; // Disallow updating the PK
            $updateCore .= (strlen($updateCore) == 0 ? "" : ",") . $key . "='" . Database::sanitize($value) . "'";
        }
        return Database::query("UPDATE $table SET $updateCore WHERE $uni='$uniVal'");
    }
    
    public function delete($table = null, $uni = null) {
        if(is_null($table)) $table = $this->getTable();
        if(is_null($uni)) $uni = $this->getUnique();
        
        $uniVal = $this->get($uni);
        Database::query("DELETE FROM $table WHERE $uni='$uniVal'");
    }
    
    // Now we deal with more silly stuff.
    public function addIndirect($target, $object) {
        $rel = $this->getRelationships()[$target];
        
        $inst = new Object();
        
        // We're not even going to check for indirects.
        $inst->set($rel["join"]["localkey"], $this[$rel["local"]["key"]]);
        $inst->set($rel["join"]["remotekey"], $object[$rel["remote"]["key"]]);
        
        $inst->insert($rel["join"]["table"]);
        
        echo Database::last();
    }
    
    public function hasIndirect($target, $object) {
        $rel = $this->getRelationships()[$target];
        
        $temp = Query::create("Object", $rel["join"]["table"])->where($rel["join"]["localkey"], $this[$rel["local"]["key"]]);
        $temp = $temp->where($rel["join"]["remotekey"], $object[$rel["remote"]["key"]]);
        
        return $temp->exists();
    }
    
    public function removeIndirect($target, $object) {
        $rel = $this->getRelationships()[$target];
        
        $temp = Query::create("Object", $rel["join"]["table"])->where($rel["join"]["localkey"], $this[$rel["local"]["key"]]);
        $temp = $temp->where($rel["join"]["remotekey"], $object[$rel["remote"]["key"]]);
        
        $res = $temp->single();
        
        if(!is_null($res)) {
            $temp->delete();
            return true;
        }
        
        return false;
    }
    
    /*
     * Types:
     * Direct-Parent:
     * key - Local key to use.
     * target - An array:
     *  table - The table to pull from; should be removed later.
     *  type - The object type to be created.
     *  key - The remote variable to search on
     * 
     * Direct-Children:
     * key - The local variable to search on.
     * target - An array:
     *  table - The table with the children.
     *  type - The type of the children.
     *  key - The variable which is the child reference variable.
     * 
     * Indirect:
     * local - An array:
     *  key - The local variable that corresponds to the join.
     * join - An array:
     *  localkey - The local key
     *  remotekey - The remote key
     *  table - The table.
     * remote - An array:
     *  key - The variable in that object
     *  table - The remote table.
     *  type - The table type.
     * 
     */
    public function getRelationships() {
        return array();
    }
    
    public function getUnique() {
        return "ID";
    }
    
    public function getTable() {
        return null;
    }

    public function jsonSerialize() {
        return array_merge($this->data, $this->ref);
    }
}

?>
