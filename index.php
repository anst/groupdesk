<?php
require_once dirname(__FILE__).'/app/app.php';
require_once dirname(__FILE__) . '/app/api/autoloader.php';


$app = new app('app');
$app->route('/', function($app) { 
	return $app->render("home.html",['sup'=>'sohacks swag']);
});

$app->route("/api/user", function($app, $api_query) {
    
});

UserManager::addRoutes($app);
MashapeManager::addRoutes($app);

$app->run();
?>