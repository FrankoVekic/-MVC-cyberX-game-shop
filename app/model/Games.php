<?php 

class Games 
{
    //CRUD - R
    public static function read()
    {
        $conn = DB::getInstance();
        $query = $conn->prepare('select * from smjer');
        $query->execute();
        
        return $query->fetchAll();
    }
}