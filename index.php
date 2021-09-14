<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

define('BP',__DIR__ . DIRECTORY_SEPARATOR);
define('BP_APP',__DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);

//echo BP;

$path = implode(
    PATH_SEPARATOR, 
    [
        BP_APP . 'model',
        BP_APP . 'controller',
        BP_APP . 'core'
    ]
);

//echo $path;

set_include_path($path);

spl_autoload_register(function($class){
    $path = explode(PATH_SEPARATOR,get_include_path());
    foreach($path as $p){
        //echo $class . ' - ' . $p . '<br>';
        if(file_exists($p . DIRECTORY_SEPARATOR . $class . '.php')){
            include $p . DIRECTORY_SEPARATOR . $class . '.php';
        }
    }
});

App::start();