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
        $restrictions[$col] = array("type" => "AND", "val" => $val);
        return $this;
    }
    
    public function explicit($sub) {
        $restrictions[] = array("type" => "EXP", "val" => $sub);
    }
    
    public function fetch() {
        return Object::allFromQuery($this->buildQuery(), $this->type);
    }
    
    public function single() {
        return Object::fromQuery($this->buildQuery(), $this->type);
    }
    
    protected function buildQuery() {
        $res = "SELECT * FROM " . $this->table;
        
        if(sizeof($this->restrictions) == 0) return $res;
        
        $res = $res . " ";
        
        $first = true;
        foreach($restrictions as $key => $res) {
            if(!$first) $res = $res . " AND ";
            $first = false;
            if($res["type"] === "AND")
                $res = $res . "`" . $key . "`" . " = " . $res["val"];
            else if($res["type"] === "EXP")
                $res = $res . $res["val"];
        }
        
        return $res;
    }
}

?>
