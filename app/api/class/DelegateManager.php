<?php

require_once("Util.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * A delegate manager - primarily for dealing with anonymous functions.
 *
 * @author Tres
 */
class DelegateManager {
    private $handlers;
    
    public function __construct() {
        $this->handlers = array();
    }
    
    public function add($name, $req, $handle)
    {
        if($req == null) $req = array();
        $this->handlers[$name] = $handle;
        $this->handlers[$name . "-req"] = $req;
    }
    
    public function call($name, $args)
    {
        if(isset($this->handlers[$name]))
        {
            if(Util::containsAll($args, $this->handlers[$name . "-req"]))
                $this->handlers[$name]($args);
        }
    }
}

?>
