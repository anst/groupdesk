<?php

require_once 'Object.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author Tres
 */
class Group extends Object {
    public function getRelationships() {
        return parent::getRelationships();
    }
    
    public static function all() {
        return Object::allFromTable("groups", false, false, "Group");
    }
    
    public static function id($id) {
        return Object::fromTable("groups", "ID", $id, "Group");
    }
}

?>
