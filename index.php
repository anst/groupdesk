<?php
require_once dirname(__FILE__).'/app/app.php';


$app = new app('app');
$app->route('/', function($app) { 
	return $app->render("home.html",[]);
});
$app->route('/about', function($app) { 
	return $app->render("about.html",[]);
});
$app->route('/login', function($app) { 
	return $app->render("login.html",[]);
});
$app->route('/teachers', function($app) { 
	return $app->render("teachers.html",[]);
});
$app->route('/students', function($app) { 
	return $app->render("students.html",[]);
});
$app->run();
?>