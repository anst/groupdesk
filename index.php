<?php
require_once dirname(__FILE__).'/app/app.php';
require_once dirname(__FILE__) . '/app/api/autoloader.php';

$app = new app('app');

$app->route('/', function($app) {
        $user = User::current(); 
        if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			return $app->render("teachers_app.html", $user->toArray());
		} else {
			return $app->render("students_app.html", $user->toArray());
		}

	}
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

$app->route('/room/<string>', function($app, $roomid) {
        $user = User::current(); 
        if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			return $app->render("teachers_app.html",$user->toArray());
		} else {
			return $app->render("students_room_view.html",$user->toArray());
		}

	}
});

$app->route('/class/<string>', function($app, $classid) { 
        $user = User::current(); 
        if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			return $app->render("teachers_app.html",$user->toArray());
		} else {
			return $app->render("students_class_view.html",$user->toArray());
		}

	}
});

$app->route('/wysiwyg', function($app) { 
  return $app->render("wysiwyg.html",[]);
});

UserManager::addRoutes($app);
GroupManager::addRoutes($app);
MashapeManager::addRoutes($app);
RoomManager::addRoutes($app);

$app->run();
?>