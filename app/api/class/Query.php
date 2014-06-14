<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/app/api/autoloader.php';

/**
 * Description of Query
 *
 * @author Tres
 */
class Query {
    private $restrictions = array();
    private $type = "Object";
    private $table = null;
    private $rec = 1;
    
    public function __construct($type = "Object", $table = null, $rec = 1, $restrict = array()) {
        $this->restrictions = $restrict;
        $this->type = $type;
        $this->table = $table;
        $this->rec = $rec;
    }
    
    public static function create($type, $table) {
        return new Query($type, $table);
    }
    
    public function where($col, $val) {
        $this->restrictions[$col] = array("type" => "AND", "val" => $val);
        return $this;
    }
    
    public function explicit($sub) {
        $this->restrictions[] = array("type" => "EXP", "val" => $sub);
    }
    
    public function fetch() {
        return Object::allFromQuery($this->buildQuery("SELECT *"), $this->type);
    }
    
    public function single() {
        return Object::fromQuery($this->buildQuery("SELECT *"), $this->type);
    }
    
    public function exists() {
        return null !== $this->single();
    }
    
    public function delete() {
        return Database::query($this->buildQuery("DELETE"));
    }
    
    public function buildQuery($op) {
        $res = "$op FROM " . $this->table;
        
        if(sizeof($this->restrictions) == 0) return $res;
        
        $res = $res . " WHERE ";
        
        $first = true;
        foreach($this->restrictions as $key => $val) {
            if(!$first) $res = $res . " AND ";
            $first = false;
            if($val["type"] === "AND")
                $res = $res . "`" . $key . "`" . " = \"" . $val["val"] . "\"";
            else if($val["type"] === "EXP")
                $res = $res . $val["val"];
        }
        
        return $res;
    }
}

?>
