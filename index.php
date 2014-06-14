<?php
require_once dirname(__FILE__).'/app/app.php';
require_once dirname(__FILE__) . '/app/api/autoloader.php';


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
$app->route('/students_app', function($app) { 
  return $app->render("students_app.html",[]);
});
$app->route('/teachers_app', function($app) { 
  return $app->render("teachers_app.html",[]);
});
$app->route('/students_app/room', function($app) { 
  return $app->render("students_room_view.html",[]);
});
$app->route('/students_class', function($app) { 
  return $app->render("students_class_view.html",[]);
});

$app->route("/api/user", function($app, $api_query) {
    
$app->route('/wysiwyg', function($app) { 
  return $app->render("wysiwyg.html",[]);
});

UserManager::addRoutes($app);
MashapeManager::addRoutes($app);

$app->run();
?>