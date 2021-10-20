<?php 

class OrdersController extends AuthorizeController
{
    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'orders' . DIRECTORY_SEPARATOR;
    
    private $goodOrders;

    public function index()
    {
        if(Request::isAdmin()){
            $orders = Orders::checkOrders();
            $this->goodOrders=[];
            foreach($orders as $order){
                if(!$this->orderExists($order->id)){
                    $order->games=[];
                    $game=new stdClass();
                    $game->name=$order->name;
                    $game->quantity = $order->quantity;
                    $order->games[]=$game;
                    $this->goodOrders[]=$order;
                }else{
                    foreach($this->goodOrders as $go){                  
                        if($order->id==$go->id){   
                            $game=new stdClass();
                            $game->name=$order->name;
                            $game->quantity = $order->quantity;
                            $go->games[]=$game;               
                            break;          
                        }                 
                    }
                }
            }
            $this->view->render($this->viewDir . 'index',[
                'orders'=>$this->goodOrders,
                'message'=>'Orders table'
            ]);
        }
        else {
            $this->view->render('private' . DIRECTORY_SEPARATOR . 'index');
        }
    }

    private function orderExists($id)
    {
        foreach($this->goodOrders as $o){
            if($o->id==$id){
                return true;
            }
        }
        return false;
    }
}