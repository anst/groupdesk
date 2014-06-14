<?php

require_once 'Object.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author blacksmithgu
 */
class User extends Object {
    public static $STUDENT = 0;
    public static $TEACHER = 1;
    public static $ADMIN = 2;
    
    public function getRelationships() {
        if($this->get("Type") == User::$STUDENT) {
            return array(
                "Groups" => array(
                    "type" => "Indirect",
                    "local" => array("key" => "ID"),
                    "name" => "Groups",
                    "join" => array(
                        "localkey" => "StudentID",
                        "remotekey" => "GroupID",
                        "table" => "groups_users"
                    ),
                    "remote" => array(
                        "key" => "ID",
                        "table" => "groups",
                        "type" => "Group"
                    )
                )
            );
        } else { // Teacher; ignore admin.
            return array(
                "Groups" => array(
                    "type" => "Direct-Children",
                    "key" => "ID",
                    "name" => "Groups",
                    "target" => array(
                        "table" => "groups",
                        "type" => "Group",
                        "key" => "TeacherID"
                    )
                )
            );
        }
    }
    
    public static function all() {
        return Object::allFromTable("users", false, false, "User");
    }
    
    public static function id($id) {
        return Object::fromTable("users", "ID", $id, "User");
    }
}
