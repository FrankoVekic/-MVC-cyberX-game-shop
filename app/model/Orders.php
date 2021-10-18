<?php 

class Orders{
   
    public static function checkOrders()
    {
        $conn = DB::connect();
        $query = $conn->prepare("
        select concat(a.name,' ', a.surname) as buyer, b.country, b.id, b.order_date, b.address, b.city, d.name, c.quantity 
        from users a
        inner join orders b 
        on a.id = b.buyer
        inner join game_order c 
        on c.orders = b.id
        inner join games d 
        on d.id = c.games order by b.id asc;
        ");
        $query->execute();
        return $query->fetchAll();
    }
}