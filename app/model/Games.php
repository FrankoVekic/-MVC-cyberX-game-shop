<?php 

class Games 
{
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
    //CRUD - R
    public static function read()
    {
        $conn = DB::connect();
        $query = $conn->prepare('select * from games');
        $query->execute();
        
        return $query->fetchAll();
    }
    //CRUD - U
    public static function update($params)
    {
        $conn = DB::connect();
        $query = $conn->prepare('update games set
         name=:name,
         price=:price,
         description=:description,
         quantity=:quantity,
         memory_required=:memory_required,
         console=:console
         where id=:id');
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

    public static function findGame($id)
    {
        $conn = DB::connect();
        $query = $conn->prepare('select * from games where id=:id');
        $query->execute(['id'=>$id]);
        return $query->fetch();
    }
}