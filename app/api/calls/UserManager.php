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
            if(is_null($user))
                echo "null";
            else
                echo $user->json(true);
        });
    }

}

?>
