<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Announcement
 *
 * @author Tres
 */
class Announcement extends Object {
    public function getRelationships() {
        return [
            "Poster" => [
                "type" => "Direct-Parent",
                "name" => "Poster",
                "key" => "UserID",
                "target" => [
                    "key" => "ID",
                    "table" => "users",
                    "type" => "User"
                ]
            ]
        ];
    }
    
    public static function create($title, $content, $poster) {
        return new Announcement([
            "Title" => $title,
            "Content" => $content,
            "UserID" => $poster
        ]);
    }
    
    public static function all() {
        return Object::allFromTable("announcements", false, false, "Announcement");
    }
    
    public static function id($id) {
        return Object::fromTable("announcements", "ID", $id, "Announcement");
    }
}

?>
