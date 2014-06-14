<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/app/api/autoloader.php';

class MashapeManager {

    public static function addRoutes($app) {
        $app->route("/api/school", function($app) {
            if (!isset($_GET['name'])) {
                return;
            }
            Mashape::retrieveSchools();
            echo json_encode(Mashape::getMatchingSchools($_GET['name']));
        });
        
        $app->route("/api/convert", function($app) {
            if (!isset($_GET['name']) && !isset($_GET['data'])) {
                return;
            }
            $url = Mashape::convertFile($_GET['name'], $_GET['data']);
            echo $url;
        });
    }

}

?>
