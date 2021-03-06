<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/app/api/autoloader.php';

class UserManager {

    public static function addRoutes($app) {
        $app->route("/api/register", function($app) {
            $pass = $_GET["password"];
            $first = $_GET["first"];
            $last = $_GET["last"];
            $school = $_GET["school"];
            $email = $_GET["email"];
            $groupID = isset($_GET["group"]) ? $_GET["group"] : null;
            
            $type = isset($_GET["type"]) ? $_GET["type"] : 0;
            
            $user = User::create($email,$pass, $first, $last, $school, $type);
            $user_res = User::id($user->insert());
            
            User::loginCurrent($user_res);
            
            if(!is_null($groupID)) {
                $group = Group::id($groupID);
                if(!is_null($group))
                    $group->addIndirect("Students", $user_res);
            }
            
            header("Location: /");
        });
        
        $app->route("/api/login", function($app) {
            $user = User::login($_GET["email"], $_GET["password"]);
            if(is_null($user))
                header("Location: /login");
            else
                header("Location: /");
        });
        
        $app->route("/api/logout", function($app) {
            User::logout();
            header("Location: /");
        });
        
        $app->route("/api/user/current", function($app) {
            $user = User::current();
            if (is_null($user)) {
                echo "null";
            } else {
                echo $user->json(true);
            }
        });
        
        $app->route("/api/user/groups", function($app) {
            $user = User::current();
            if(is_null($user))
                echo "null";
            else
                echo json_encode($user["Groups"]);
        });
        
        $app->route("/api/user/list", function($app) {
            $arr = User::all();
            
            echo json_encode($arr, JSON_PRETTY_PRINT);
        });
        $app->route("/api/gravatar", function($app) {
            $user = User::current();
            if (is_null($user)) {
                echo "default.png";
            } else {
                echo get_gravatar(User::current()['Email'], $_GET['img']);
            }
        });
    }
    
    function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
    }

}

?>
