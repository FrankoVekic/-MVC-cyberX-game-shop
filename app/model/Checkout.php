<?php 

class Checkout 
{
    public static function order($buyer,$date,$address,$city,$country)
    {
        $conn = DB::connect();
        $query = $conn->prepare("INSERT INTO orders (buyer,order_date,address,city,country) 
        VALUES (:buyer,:order_date,:address,:city,:country);");
        $query->bindParam(":buyer",$buyer);
        $query->bindParam(":address",$address);
        $query->bindParam(":order_date",$date);
        $query->bindParam(":city",$city);
        $query->bindParam(":country",$country);
        $query->execute();

        $_SESSION['lastId'] = $conn->lastInsertId();
    }

    //find last inserted order id---
    public static function orderGame($game,$quantity)
    {   
        $conn = DB::connect();
        $id = $_SESSION['lastId'];
        $query=$conn->prepare("
        INSERT INTO game_order (orders, games, quantity) 
        VALUES ($id,$game,$quantity);
        ");
        $query->execute();
    }
}