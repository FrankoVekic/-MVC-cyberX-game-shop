<?php 

class Games 
{
    //CRUD - R
    public static function read()
    {
        $conn = DB::connect();
        $query = $conn->prepare('select * from games');
        $query->execute();
        
        return $query->fetchAll();
    }
}