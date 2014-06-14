<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Room
 *
 * @author Tres
 */
class Room extends Object {
    public function getRelationships() {
        return parent::getRelationships();
    }
    
    public static function all() {
        return Object::allFromTable("rooms", false, false, "Room");
    }
    
    public static function id($id) {
        return Object::allFromTable("rooms", "ID", $id, "Room");
    }
}

?>
