<?php 

class App 
{
    public static function start()
    {
        $paths = Request::getPath();
        //echo $paths . '<br>';
        $parts = explode('/',$paths);
        //echo '<pre>';
        //print_r($parts);
        //echo '</pre>';

        $class = '';
        if(!isset($parts[1]) || $parts[1] == ''){
            $class = 'Index';
        }
        else {
            $class = ucfirst($parts[1]);
        }
        $class .='Controller';
        //echo $class;

        $method = ''; //implementacijski je to i dalje funkcija 
        if(!isset($parts[2]) || $parts[2] == ''){
            $method = 'index';
        }
        else {
            $method = ucfirst($parts[2]);
        }
        //echo $class . '->' . $method;
        if(class_exists($class) && method_exists($class,$method)){
            $instance = new $class();
            $instance->$method();
        }
        else {
            //error page
            echo 'Can not find what you are looking for' . 
            $class . '->' . $method;
        }
    }

    public static function config($key)
    {
        $config = include BP_APP . 'config.php';
        return $config[$key];
    }

}