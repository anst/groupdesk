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
            "Rooms" => array(
                "type" => "Direct-Children",
                "name" => "Rooms",
                "key" => "ID",
                "target" => array(
                    "table" => "rooms",
                    "type" => "Room",
                    "key" => "AssignmentID"
                )
            ),
            "Group" => [
                "type" => "Direct-Parent",
                "name" => "Group",
                "key" => "GroupID",
                "target" => [
                    "key" => "ID",
                    "table" => "groups",
                    "type" => "Group"
                ]
            ]
        );
    }
    
    public static function create($group, $name, $desc, $dueDate = null) {
        return new Assignment(array(
           "Name" => $name,
           "GroupID" => $group["ID"],
           "CreationDate" => date("Y-m-d H:i:s"),
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
