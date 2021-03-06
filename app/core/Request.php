<?php 

class Request 
{
    public static function getPath()
    {
        $paths = '/';
        if(isset($_SERVER['REDIRECT_PATH_INFO'])){
            $paths =  $_SERVER['REDIRECT_PATH_INFO'];
        }
        else if(isset($_SERVER['REQUEST_URI'])){
            $paths = $_SERVER['REQUEST_URI'];
        }
        //dodati bilo što gdje može biti taj podatak
        return $paths;
    }

    public static function isAuthorized()
    {
        return isset($_SESSION['authorized']);
    }

    public static function user()
    {
        return $_SESSION['authorized']->name . ' ' 
        . $_SESSION['authorized']->surname;
    }

    public static function userName()
    {
        return $_SESSION['authorized']->name;
    }

    public static function userSurname()
    {
        return $_SESSION['authorized']->surname;
    }

    public static function isAdmin()
    {
        if(isset($_SESSION['authorized'])){
            return $_SESSION['authorized']->role === 'admin';
        }
        else return;  
    }
}