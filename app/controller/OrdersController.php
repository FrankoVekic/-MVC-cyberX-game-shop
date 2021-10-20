<?php 

class OrdersController extends AuthorizeController
{
    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'orders' . DIRECTORY_SEPARATOR;
    
    private $goodOrders;

    public function index()
    {
        if(Request::isAdmin()){

            $orders = Orders::checkOrdersBetter();
            $this->goodOrders=[];
            foreach($orders as $o){
                if(!$this->orderExists($o->id)){
                    $o->games=[];
                    $g=new stdClass();
                    $g->name=$o->name;
                    $g->quantity = $o->quantity;
                    $o->games[]=$g;
                    $this->goodOrders[]=$o;
                }else{
                    foreach($this->goodOrders as $go){                  
                        if($o->id==$go->id){   
                            $g=new stdClass();
                            $g->name=$o->name;
                            $g->quantity = $o->quantity;
                            $go->games[]=$g;               
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