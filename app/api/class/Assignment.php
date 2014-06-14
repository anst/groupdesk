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
            ),
            "Rooms" => array(
                "type" => "Direct-Children",
                "name" => "Rooms",
                "key" => "ID",
                "target" => array(
                    "table" => "rooms",
                    "type" => "Room",
                    "key" => "AssignmentID"
                )
            )
        );
    }
    
    public static function create($creator, $name, $desc, $dueDate = null) {
        return new Assignment(array(
           "Name" => $name,
           "TeacherID" => $creator,
           "CreationDate" => date("Y-m-d H:i:s"),
            "DueDate" => $dueDate,
            "Description" => $desc
        ));
    }
    
    public static function all() {
        return Object::allFromTable("assignments", false, false, "Assignment");
    }
    
    public static function id($id) {
        return Object::fromTable("assignments", "ID", $id, "Assignment");
    }
    
    public function getTable() {
        return "assignments";
    }
}

?>
