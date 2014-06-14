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
            $group->insert();
            
            header('Location: /');
            
            /*if(isset($group))
                echo Group::id($group->insert())->json(true);
            else
                echo "null";*/
        });
        
        $app->route("/api/group/delete", function($app) {
            $id = $_GET["id"];
            
            $group = Group::id($id);
            $group->delete();
            
            Query::create("Object", "groups_users")->where("GroupID", $group["ID"])->delete();
            
            header("Location: /");
        });
        
        $app->route("/api/group/update", function($app) {
            $title = $_GET["title"];
            $desc = $_GET["desc"];
            
            $id = $_GET["id"];
            
            $group = Group::id($id);
            if(is_null($group)) {
                echo "false";
                return;
            }
            
            $group["Title"] = $title;
            $group["Description"] = $desc;
            
            $group->update();
            echo "true";
        });
        
        $app->route("/api/group/addstudent", function($app) {
            $groupId = $_GET["id"];
            $studentId = $_GET["student"];
            
            $group = Group::id($groupId);
            $student = User::id($studentId);
            
            if(is_null($group) || is_null($student)) {
                header("Location: /");
                return;
            }
            
            if($group->hasIndirect("Students", $student)) {
                header("Location: /");
                return;
            }
            
            $group->addIndirect("Students", $student);
            
            header("Location: /");
        });
        
        $app->route("/api/group/removestudent", function($app) {
            $groupID = $_GET["id"];
            $studentID = $_GET["student"];
            
            $group = Group::id($groupID);
            $student = User::id($studentID);
            
            if(is_null($group) || is_null($student)) {
                header("Location: /");
                return;
            }
            
            if(!$group->hasIndirect("Students", $student)) {
                header("Location: /");
                return;
            }
            
            $res = $group->removeIndirect("Students", $student);
            
            header("Location: /");
        });
        
        $app->route("/api/group/students", function($app) {
            $id = $_GET["id"];
            
            $group = Group::id($id);
            
            if(is_null($group)) {
                header("Location: /");
                return;
            }
            
            $group->resolve();
            echo json_encode($group["Students"], JSON_PRETTY_PRINT);
        });
        
        $app->route("/api/group/list", function($app) {
            if(isset($_GET["teacher"])) {
                $teacher = User::id($_GET["teacher"]);
                if(is_null($teacher)) {
                    echo "null";
                    return;
                }
                
                $teacher->resolve();
                echo json_encode($teacher["Groups"], JSON_PRETTY_PRINT);
            } else {
                $arr = Group::all();
                echo json_encode($arr, JSON_PRETTY_PRINT);
            }
        });
    }
}
?>
