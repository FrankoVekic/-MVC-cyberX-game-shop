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

    //CRUD - C
    public static function create($params)
    {
        $conn=DB::connect();
        $query = $conn->prepare("
        insert into games(name,price,description,quantity,memory_required,console)
        values (:name,:price,:description,:quantity,:memory_required,:console);
        ");
        $query->execute($params);
    }
    //CRUD - D
    public static function delete($id)
    {
        if(isset($id)){
        $conn = DB::connect();
        $query = $conn->prepare("delete from games where id =$id;");
        $query->execute();
        }
    }
}