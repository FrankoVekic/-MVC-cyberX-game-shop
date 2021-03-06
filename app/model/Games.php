<?php 

class Games 
{

    public static function gameCount($search)
    {
        $conn = DB::connect();
        $query = $conn->prepare(
            'select count(id) from games a 
            where name like :search;'
        );
        
        $search = '%' . $search . '%';
        $query->bindParam('search',$search);
        $query->execute();
        return $query->fetchColumn();
    }
    //CRUD - C
    public static function create($params)
    {
        $conn=DB::connect();
        $query = $conn->prepare("
        insert into games(name,price,description,quantity,memory_required,console,image)
        values (:name,:price,:description,:quantity,:memory_required,:console,'noimg.png');
        ");
        $query->execute($params);
    }
    //CRUD - R
    public static function read($page,$search)
    {
        $dpp = App::config('dpp');
        $from = $page * $dpp - $dpp;
        $conn = DB::connect();
        $query = $conn->prepare('select * from games where name like :search limit :from,:dpp;');

        $search = '%' . $search . '%';
        $query->bindValue('from',$from, PDO::PARAM_INT);
        $query->bindValue('dpp',$dpp, PDO::PARAM_INT);

        $query->bindParam('search',$search);
        $query->execute();
        return $query->fetchAll();
    }
    
    public static function readAdmin()
    {
        $conn = DB::connect();
        $query = $conn->prepare('select * from games');
        $query->execute();
        
        return $query->fetchAll();
    }

    public static function readPreorder()
    {
        $conn = DB::connect();
        $query = $conn->prepare('select * from games order by id desc limit 3;');
        $query->execute();
        
        return $query->fetchAll();
    }
    //CRUD - U
    public static function update($params,$img)
    {
        $conn = DB::connect();

        $query = $conn->prepare("update games set
         name=:name,
         price=:price,
         description=:description,
         quantity=:quantity,
         memory_required=:memory_required,
         console=:console,
         image='$img'
         where id=:id");
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

    public static function checkRow($id)
    {
        $conn = DB::connect();
        $query = $conn->prepare("select games from game_order where games = $id;");
        $query->execute();
        $exists = $query->fetch();

        if($exists == null){
            return false;
        }
        else {
            return true;
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