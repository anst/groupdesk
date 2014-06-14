<?php

class RoomManager {
    public static function addRoutes($app) {
        // Verified working
        $app->route("/api/room/create", function($app) {
            $name = $_GET["name"];
            $assignmentID = $_GET["assignment"];
            
            $assignment = Assignment::id($assignmentID);
            
            if(is_null($assignment)) {
                echo null;
                return;
            }
            
            $room = Room::create($name, $assignment);
            echo Room::id($room->insert())->json(true);
        });
        
        // Verified working
        $app->route("/api/room/delete", function($app) {
            $id = $_GET["id"];
            
            $room = Room::id($id);
            if(is_null($room)) {
                echo "false";
                return;
            }
            
            $room->delete();
            echo "true";
        });
        
        $app->route("/api/room/addstudent", function($app) {
            $id = $_GET["id"];
            $studentID = $_GET["student"];
            
            $student = User::id($studentID);
            
            $room = Room::id($id);
            if(is_null($room) || is_null($student)) {
                echo "false";
                return;
            }
            
            $room->addIndirect("Students", $student);
            echo "true";
        });
        
        $app->route("/api/room/removestudent", function($app) {
            $id = $_GET["id"];
            $studentID = $_GET["student"];
            
            $student = User::id($studentID);
            $room = Room::id($id);
            
            if(is_null($room) || is_null($student)) {
                echo "false";
                return;
            }
            
            $room->removeIndirect("Students", $student);
            echo "true";
        });
        
        $app->route("/api/room/students", function($app) {
            $id = $_GET["id"];
            $room = Room::id($id);
            
            if(is_null($room)) {
                echo "null";
                return;
            }
            
            $room->resolve();
            echo json_encode($room["Students"]);
        });
        
        $app->route("/api/room/list", function($app) {
            $arr = Room::all();
            
            echo json_encode($arr, JSON_PRETTY_PRINT);
        });
    }
}
?>
