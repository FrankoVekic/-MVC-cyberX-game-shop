<?php 

class Orders{
   
    public static function checkOrders()
    {
        $conn = DB::connect();
        $query = $conn->prepare("
        select concat(a.name,' ', a.surname) as buyer, b.country, b.id, b.order_date, b.address, b.city 
        from users a
        inner join orders b 
        on a.id = b.buyer
        order by b.id asc;
        ");
        $query->execute();
        $orders = $query->fetchAll();

        //loše
        foreach($orders as $o){
            $query = $conn->prepare("
            select  d.name, c.quantity 
                from game_order c 
                on c.orders = b.id
                inner join games d 
                on d.id = c.games where c.orders = :order;
            ");
            $query->execute();
            $o->games=$query->fetchAll();
        }
        return $orders;
    }
}