<?php
require_once dirname(__FILE__).'/app/app.php';


$app = new app('app');
$app->route('/', function($app) { 
	return $app->render("home.html",['sup'=>'sohacks swag']);
});
$app->route('/<string>', function($app, $api_query) {
});
$app->run();
?>