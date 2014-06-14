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
            $room->insert();

            header('Location: /assignment/' . $assignmentID);
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
            header('Location: /assignment/' . $room["AssignmentID"]);
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
            
            if($room->hasIndirect("Students", $student)) {
                echo "false";
                return false;
            }
            
            $room->addIndirect("Students", $student);
            header('Location: /room/' . $id);
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
            
            if(!$room->hasIndirect("Students", $student)) {
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
            if(isset($_GET["assignment"])) {
                $assignment = Assignment::id($_GET["assignment"]);
                
                if(is_null($assignment)) {
                    echo "null";
                    return;
                }
                
                echo json_encode($assignment["Rooms"], JSON_PRETTY_PRINT);
            } else {
                $arr = Room::all();
                echo json_encode($arr, JSON_PRETTY_PRINT);
            }
        });
        
        $app->route("/api/room/announcements", function($app) {
            $id = $_GET["id"];
            
            $room = Room::id($id);
            if(is_null($room)) {
                echo "null";
                return;
            }
            
            $room->resolve();
            echo json_encode($room["Announcements"], JSON_PRETTY_PRINT);
        });
    }
}
?>
