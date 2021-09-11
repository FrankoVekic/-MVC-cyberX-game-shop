<?php 

class DB extends PDO
{
    private static $instance = null;

    private function __construct($database)
    {
        $dsn='mysql:host=' . $database['host'] . ';dbname=' . $database['dbName'];

        parent::__construct($dsn,$database['username'],$database['password']);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }

    public static function getInstance()
    {   
        //when we are not connected to db
        if(self::$instance==null){
            self::$instance = new self(App::config('database'));
        }
        return self::$instance;
    }
}