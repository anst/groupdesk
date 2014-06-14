<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/app/api/autoloader.php';

class UserManager {

    public static function addRoutes($app) {
        $app->route("/api/login", function($app) {
            $user = User::login($_GET["username"], $_GET["password"]);
            echo is_null($user) ? "null" : $user->json(true);
        });
        
        $app->route("/api/logout", function($app) {
            echo User::logout() ? "true" : "false";
        });
        
        $app->route("/api/current", function($app) {
            $user = User::current();
            if (is_null($user)) {
                echo "null";
            } else {
                echo $user->json(true);
            }
        });
        
        $app->route("/api/gravatar", function($app) {
            $user = User::current();
            if (is_null($user)) {
                echo "default.png";
            } else {
                echo get_gravatar(User::current()->get('email'), $_GET['img']);
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
