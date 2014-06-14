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
         return [
             "Students" => [
                "name" => "Students",
                "type" => "Indirect",
                "local" => [
                    "key" => "ID"
                ],
                "join" => [
                    "localkey" => "RoomID",
                    "remotekey" => "UserID",
                    "table" => "rooms_students"
                ],
                "remote" => [
                    "key" => "ID",
                    "table" => "users",
                    "type" => "User"
                ]
            ],
            "Announcements" => [
                "name" => "Announcements",
                "type" => "Indirect",
                "local" => [
                    "key" => "ID"
                ],
                "join" => [
                    "localkey" => "RoomID",
                    "remotekey" => "AnnouncementID",
                    "table" => "announcements_rooms"
                ],
                "remote" => [
                    "key" => "ID",
                    "table" => "announcements",
                    "type" => "Announcement"
                ]
            ],
            "Assignment" => [
                "name" => "Assignments",
                "type" => "Direct-Parent",
                "key" => "AssignmentID",
                "target" => [
                    "table" => "assignments",
                    "type" => "Assignment",
                    "key" => "ID"
                ]
            ]
         ];
    }
    
    public static function create($name, $assignment) {
        return new Room([
            "Name" => $name,
            "AssignmentID" => $assignment["ID"]
        ]);
    }
    
    public static function all() {
        return Object::allFromTable("rooms", false, false, "Room");
    }
    
    public static function id($id) {
        return Object::fromTable("rooms", "ID", $id, "Room");
    }
    
    public function getTable() {
        return "rooms";
    }
}

?>
