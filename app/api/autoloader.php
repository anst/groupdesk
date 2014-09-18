<?php
set_time_limit(0);
session_start();

spl_autoload_register(function($class) {
    if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/api/class/' . $class . '.php'))
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/api/class/' . $class . '.php'; 
});

spl_autoload_register(function($class) {
    if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/api/calls/' . $class . '.php'))
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/api/calls/' . $class . '.php';
});

?>
