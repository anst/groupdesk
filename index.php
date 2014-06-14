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

$app->route('/class/add', function($app) {
  $user = User::current(); 
  if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			return $app->render("teachers_add_group.html",$user->toArray());
		} else {
			return $app->render("students_app.html",$user->toArray()); //probably should change this
		}
	}
});

$app->route('/assignment/<string>/add', function($app, $classid) {
        $user = User::current(); 
        if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			$res = $user->toArray();
			$res["classid"] = $classid;
			return $app->render("teachers_add_assignment.html", $res);
		} else {
			return $app->render("students_capp.html",$user->toArray());
		}

	}
});

$app->route('/room/<string>', function($app, $roomid) {
  $user = User::current(); 
  if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			return $app->render("students_room_view.html",$user->toArray());
		} else {
			return $app->render("students_room_view.html",$user->toArray());
		}

	}
});

$app->route('/room/<string>/add', function($app, $assid) {
  $user = User::current(); 
  if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			$res = $user->toArray();
			$res["classid"] = $assid;
			return $app->render("teachers_add_room.html", $res);
		} else {
			return $app->render("students_app.html",$user->toArray());
		}

	}
});

$app->route('/class/join', function($app) {
  $user = User::current(); 
  if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			return $app->render("teachers_app.html", $user->toArray());
		} else {
			return $app->render("students_join_group.html", $user->toArray());
		}
	}
});

$app->route('/class/<string>', function($app, $classid) { 
        $user = User::current(); 
        if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		$res = $user->toArray();
		$Group = Group::id($classid);
		$Group->resolve();
		$res["Group"] = $Group->toArray();
		if($user["Type"] == 1) {
			return $app->render("teachers_class_view.html", $res);
		} else {
			return $app->render("students_class_view.html", $res);
		}

	}
});

$app->route('/assignment/<string>', function($app, $assid) { 
        $user = User::current(); 
        if(!is_null($user)) $user->resolve();
	if(is_null($user)) {
		return $app->render("home.html",[]);
	} else {
		if($user["Type"] == 1) {
			$res = $user->toArray();
			$Assignment = Assignment::id($assid);
			$Assignment->resolve();
			$res["Assignment"] = $Assignment->toArray();
			return $app->render("teachers_assignment_view.html", $res);
		} else {
			return $app->render("students_app.html",$user->toArray());//probably replace this later
		}

	}
});


UserManager::addRoutes($app);
GroupManager::addRoutes($app);
MashapeManager::addRoutes($app);
RoomManager::addRoutes($app);
AssignmentManager::addRoutes($app);

$app->run();
?>