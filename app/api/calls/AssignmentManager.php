<?php

class AssignmentManager {
    public static function addRoutes($app) {
        $app->route("/api/assignment/create", function($app) {
            $groupID = $_GET["group"];
            $name = $_GET["name"];
            $desc = $_GET["desc"];
            $dueDate = null;
            
            $group = User::id($groupID);
            
            if(is_null($group)) 
            {
                echo "null";
                return;
            }
            
            $assign = Assignment::create($group, $name, $desc, $dueDate);
            $assign->insert();

            header('Location: /class/' . $groupID);
        });
        
        $app->route("/api/assignment/delete", function($app) {
            $id = $_GET["id"];
            
            $group = Assignment::id($id);
            $group->delete();
            
            header('Location: /class/' . $group["GroupID"]);
        });
        
        $app->route("/api/group/addstudent", function($app) {
            $assignId = $_GET["id"];
            $studentId = $_GET["student"];
            
            $assign = Assignment::id($assignId);
            $student = User::id($studentId);
            
            $assign->addIndirect("Students", $student);
            
            echo "true";
        });
        
        $app->route("/api/group/removestudent", function($app) {
            $assignID = $_GET["id"];
            $studentID = $_GET["student"];
            
            $assign = Group::id($assignID);
            $student = User::id($studentID);
            
            $res = $assign->removeIndirect("Students", $student);
            
            echo $res ? "true" : "false";
        });
        
        $app->route("/api/asssignment/list", function($app) {
            $arr = Assignment::all();

            echo json_encode($arr, JSON_PRETTY_PRINT);
        });
    }
}
?>
