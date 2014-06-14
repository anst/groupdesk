<?php

require_once 'Object.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Assignment
 *
 * @author Tres
 */
class Assignment extends Object {
    public function getRelationships() {
        return array(
            "Teacher" => array(
                "type" => "Direct-Parent",
                "name" => "Teacher",
                "key" => "TeacherID",
                "target" => array(
                    "key" => "ID",
                    "table" => "users",
                    "type" => "Object"
                )
            )
        );
    }
    
    public static function all() {
        return Object::allFromTable("assignments", false, false, "Assignment");
    }
    
    public static function id($id) {
        return Object::fromTable("assignments", "ID", $id, "Assignment");
    }
}

?>
