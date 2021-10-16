<?php 

class Checkout 
{
    public static function order($buyer,$date,$address,$city,$country)
    {
        $conn = DB::connect();
        $query = $conn->prepare("INSERT INTO orders (buyer,order_date,address,city,country) VALUES (:buyer,:order_date,:address,:city,:country);");
        $query->bindParam(":buyer",$buyer);
        $query->bindParam(":address",$address);
        $query->bindParam(":order_date",$date);
        $query->bindParam(":city",$city);
        $query->bindParam(":country",$country);
        $query->execute();
        return true;

    }

    //find last inserted order id---
    public static function orderGame($orders,$games,$quantity)
    {
        $conn = DB::connect();
        $query = $conn->prepare("INSERT INTO game_order (orders,games,quantity) VALUES (:orders,:games,:quantity);");
        $query->bindParam(":orders",$orders);
        $query->bindParam(":games",$games);
        $query->bindParam(":quantity",$quantity);
        $query->execute();
        return true;
    }
}