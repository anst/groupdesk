<?php

class AssignmentManager {
    public static function addRoutes($app) {
        $app->route("/api/assignment/create", function($app) {
            $creatorID = $_GET["teacher"];
            $name = $_GET["name"];
            $desc = $_GET["desc"];
            $dueDate = $_GET["due"];
            
            $creator = User::id($creatorID);
            
            if(is_null($creator))
                echo "null";
            
            $assign = Assignment::create($creator, $name, $desc, $dueDate);
            
            if(isset($assign))
                echo Assignment::id($assign->insert())->json(true);
            else
                echo "null";
        });
        
        $app->route("/api/assignment/delete", function($app) {
            $id = $_GET["id"];
            
            $group = Assignment::id($id);
            $group->delete();
            
            echo Database::last();
            
            echo "true";
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
