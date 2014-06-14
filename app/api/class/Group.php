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
        return [
            "Teacher" => [
                "key" => "TeacherID",
                "name" => "Teacher",
                "type" => "Direct-Parent",
                "target" => [
                    "table" => "users",
                    "type" => "User",
                    "key" => "ID"
                ]
            ],
            "Students" => [
                "name" => "Students",
                "type" => "Indirect",
                "local" => [
                    "key" => "ID"
                ],
                "join" => [
                    "localkey" => "GroupID",
                    "remotekey" => "UserID",
                    "table" => "groups_users"
                ],
                "remote" => [
                    "key" => "ID",
                    "table" => "users",
                    "type" => "User"
                ]
            ]
        ];
    }
    
    public static function create($creator, $name, $desc) {
        return new Group(array(
           "TeacherID" => $creator["ID"],
            "Title" => $name,
            "Description" => $desc
        ));
    }
    
    public static function all() {
        return Object::allFromTable("groups", false, false, "Group");
    }
    
    public static function id($id) {
        return Object::fromTable("groups", "ID", $id, "Group");
    }
    
    public function getTable() {
        return "groups";
    }
}

?>
