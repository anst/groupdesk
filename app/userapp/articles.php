<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');	

	use \UserApp\Widget\User;
	require("app_init.php");

	$valid_token = false;

	if(isset($_COOKIE["ua_session_token"])){
		$token = $_COOKIE["ua_session_token"];

		try{
			$valid_token = User::loginWithToken($token);
		}catch(\UserApp\Exceptions\ServiceException $exception){
			$valid_token = false;
		}
	}

	if(!$valid_token){
		echo "Invalid token";
	}else{
		// TODO: find articles and serialize to JSON
		echo '[{ "id": 1, "title": "Title 1", "body": "Body 2" }, { "id": 2, "title": "Title 2", "body": "Body 2" }]';
	}
?>
