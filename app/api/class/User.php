<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/app/api/autoloader.php';

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
    
    public static function create($user, $pass, $type = 0) {
        return new User(array(
            "Username" => $user,
            "Password" => $pass,
            "Type" => $type,
            "CreatedDate" => date("Y-m-d H:i:s")
        ));
    }
    
    public static function current() {
        if(!isset($_SESSION["UserID"])) return null;
        
        $user = User::id($_SESSION["UserID"]);
        
        if(isset($user)) $user->resolve();
        return $user;
    }
    
    public static function loginCurrent($user) {
        if(is_null($user)) return false;
        
        $_SESSION["UserID"] = $user["ID"];
        
        return $user;
    }
    
    public static function login($username, $password) {
        $user = Query::create("User", "users")->where("Username", $username)->where("Password", $password)->single();
        return static::loginCurrent($user);
    }
    
    public static function logout() {
        if(isset($_SESSION["UserID"])) {
            unset($_SESSION["UserID"]);
            return true;
        }
        
        return false;
    }
    
    public function getRelationships() {
        if($this->get("Type") == User::$STUDENT) {
            return array(
                "Groups" => array(
                    "type" => "Indirect",
                    "local" => array("key" => "ID"),
                    "name" => "Groups",
                    "join" => array(
                        "localkey" => "UserID",
                        "remotekey" => "GroupID",
                        "table" => "groups_users"
                    ),
                    "remote" => array(
                        "key" => "ID",
                        "table" => "groups",
                        "type" => "Group"
                    )
                ),
                "Rooms" => array(
                    "type" => "Indirect",
                    "local" => array("key" => "ID"),
                    "name" => "Rooms",
                    "join" => array(
                        "localkey" => "UserID",
                        "remotekey" => "RoomID",
                        "table" => "rooms_students"
                    ),
                    "remote" => array(
                        "key" => "ID",
                        "table" => "rooms",
                        "type" => "Room"
                    )
                ),
                "Announcements" => array(
                    "type" => "Direct-Children",
                    "name" => "Announcements",
                    "key" => "ID",
                    "target" => [
                        "key" => "UserID",
                        "type" => "Announcement",
                        "table" => "announcements"
                    ]
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
    
    public function getTable() {
        return "users";
    }
}
