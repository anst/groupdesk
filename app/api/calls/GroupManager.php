<?php

class GroupManager {
    public static function addRoutes($app) {
        $app->route("/api/group/create", function($app) {
            $creatorID = $_GET["teacher"];
            $title = $_GET["title"];
            $desc = $_GET["desc"];
            
            $creator = User::id($creatorID);
            
            if(is_null($creator))
                echo "null";
            
            $group = Group::create($creator, $title, $desc);
            
            if(isset($group))
                echo Group::id($group->insert())->json(true);
            else
                echo "null";
        });
        
        $app->route("/api/group/delete", function($app) {
            $id = $_GET["id"];
            
            $group = Group::id($id);
            $group->delete();
            
            echo Database::last();
            
            echo "true";
        });
        
        $app->route("/api/group/addstudent", function($app) {
            $groupId = $_GET["id"];
            $studentId = $_GET["student"];
            
            $group = Group::id($groupId);
            $student = User::id($studentId);
            
            $group->addIndirect("Students", $student);
            
            echo "true";
        });
        
        $app->route("/api/group/removestudent", function($app) {
            $groupID = $_GET["id"];
            $studentID = $_GET["student"];
            
            $group = Group::id($groupID);
            $student = User::id($studentID);
            
            $res = $group->removeIndirect("Students", $student);
            
            echo $res ? "true" : "false";
        });
        
        $app->route("/api/group/list", function($app) {
            $arr = Group::all();

            echo json_encode($arr, JSON_PRETTY_PRINT);
        });
    }
}
?>
