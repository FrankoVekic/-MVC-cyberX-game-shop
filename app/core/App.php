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
        $id= 0;
        $id = ''; 
        if(!isset($parts[3]) || $parts[3] == ''){
            $id=0;
        }
        else {
            $id=$parts[3];
        }

        //echo $class . '->' . $method;
        if(class_exists($class) && method_exists($class,$method)){
            $instance = new $class();
            if($id==0){
                $instance->$method();
            }else {
                $instance->$method($id);
            }
        }
        else {
            //error page
            $view = new View();
            $view->render('error');
        }
    }

    public static function config($key)
    {
        $config = include BP_APP . 'config.php';
        return $config[$key];
    }

}