<?php 

class GamesController extends AuthorizeController
{
    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR;

    private $game;
    private $message;

    public function index()
    {
        if(!isset($_GET['page'])){
            $page=1;
        }
        else {
            $page=(int)$_GET['page'];
        }
        

        if(!isset($_GET['search'])){
            $search='';
        }else {
            $search = $_GET['search'];
        }

        $gameCount = Games::gameCount($search);
        $pageCount = ceil($gameCount/App::config('dpp'));
        
        if($page>$pageCount){
            $page=$pageCount;
        }
        if($page==0){
            $page=1;
        }
        
        $this->view->render($this->viewDir . 'index',[
            'games'=>Games::read($page,$search),
            'page'=>$page,
            'search'=>$search,
            'pageCount'=>$pageCount
        ]);
    }

    public function cart()
    {
        if(empty($_SESSION['cart'])){
            $this->view->render($this->viewDir . 'cart',[
                'message'=>'Cart is empty.'
            ]);
        }
        else if(!empty($_SESSION['cart'])) {
        $this->view->render($this->viewDir . 'cart',[
            'message'=>'Your Shopping Cart'
        ]);
    }
}
    
    public function add()
    {
        
        if(isset($_POST['id'])){

            $game = Games::findGame($_POST['id']);
            
            if(isset($_SESSION['cart'])){
           
            $game_id = array_column($_SESSION['cart'],'id');
           
                if(!in_array($_POST['id'],$game_id)){
                     $count = count($_SESSION['cart']);

                    $_SESSION['cart'][$count] = [
                        'id'=>$_POST['id'],
                        'name'=>$game->name,
                        'price'=>$game->price,
                        'description'=>$game->description,
                        'memory_required'=>$game->memory_required,
                        'quantity'=> $_POST['quantity'],
                        'maxquan'=>$game->quantity,
                        'console'=>$game->console,
                        'image'=>$game->image
                    ];
                $this->view->render($this->viewDir . 'cart',[
                    'message'=>'Your Shopping Cart'
                ]);
            }else {
                for($i=0;$i<count($game_id); $i++){
                    if($game_id[$i] == $_POST['id']){
                        $_SESSION['cart'][$i]['quantity'] += $_POST['quantity'];
                    }
                    $this->view->render($this->viewDir . 'cart',[
                        'message'=>'Your Shopping Cart'
                    ]);
                }
            }
        }
        else {
            $game_array = [
                'id'=>$_POST['id'],
                'name'=>$game->name,
                'price'=>$game->price,
                'description'=>$game->description,
                'quantity'=> $_POST['quantity'],
                'maxquan'=>$game->quantity,
                'memory_required'=>$game->memory_required,
                'console'=>$game->console,
                'image'=>$game->image
            ];
            $_SESSION['cart'][0] = $game_array;

            $this->cart();
        }
    }
    else {
        $this->cart();
    }
}

    public function change()
    {
        $this->game = Games::findGame($_GET['id']);
        if($this->game==null){
            $this->index();
        }else {
        $this->view->render($this->viewDir . 'change',[
            "game" =>$this->game,
            'message'=>'Change game data'
        ]);
        }
    }
    private function nameControl()
    {
        if(!isset($this->game->name)){
            $this->message = "Name is required";
            return false;
        }
        if(strlen(trim($this->game->name)) === 0){
            $this->message="Name is required";
            return false;
        }
        if(strlen(trim($this->game->name))>30){
            $this->message="Max number of letters is 30";
            return false;
        }
        if(!preg_match("/[a-z0-9.]/i", $this->game->name)){
            $this->message="You can only write letters and numbers";
            return false;
        }
        return true;
    }

    private function priceControl()
    {
        if(!isset($this->game->price)){
            $this->message="Price is required";
            return false;
        }
        if(strlen(trim($this->game->price))===0){
            $this->message="Price is required";
            return false;
        }
        $num=(float) str_replace(array('.', ','), array('', '.'), 
        $this->game->price);
        
        if($num<=0){
            $this->message="Price must be a possitive number";
            return false;
        }
        return true;
    }

    private function descControl()
    {
        if(!isset($this->game->description)){
            $this->message = "Name is required";
            return false;
        }
        if(strlen(trim($this->game->description)) === 0){
            $this->message="Name is required";
            return false;
        }
        if(strlen(trim($this->game->description))>2000){
            $this->message="Max number of letters is 2000";
            return false;
        }
        return true;
    }

    private function quanControl()
    {
        if(!isset($this->game->quantity)){
            $this->message="Quantity is required";
            return false;
        }
        if(strlen(trim($this->game->quantity))===0){
            $this->message="Quantity is required";
            return false;
        }
        $num=(float) str_replace(array('.', ','), array('', '.'), 
        $this->game->quantity);
        
        if($num<=0){
            $this->message="Quantity must be a possitive number";
            return false;
        }
        return true;
    }

    private function memoryControl()
    {
        if(!isset($this->game->memory_required)){
            $this->message="You didin't enter the required memory";
            return false;
        }
        if(strlen(trim($this->game->memory_required))===0){
            $this->message="You didin't enter the required memory";
            return false;
        }
        $num=(float) str_replace(array('.', ','), array('', '.'), 
        $this->game->memory_required);
        
        if($num<=0){
            $this->message="Memory required must be a possitive number";
            return false;
        }
        return true;
    }

    private function consoleControl()
    {
        if(!isset($this->game->console)){
            $this->message="Chose a console";
            return false;
        }
        return true;
    }
    public function updateCart()
    {
        $this->view->render($this->viewDir . 'update');
    }
    public function set()
    {
        if(!isset($_GET['id'])){
            $this->cart();
            return;
        }
        else {
            if($_POST['newquan'] =='' || !is_numeric($_POST['newquan'])){
                $quan=1;
            foreach($_SESSION['cart'] as $games => $value){
                if($value['id'] == $_GET['id']){
                    $_SESSION['cart'][$games]['quantity']=$quan;
                    $this->cart();
                    }
                }
            }else {
                foreach($_SESSION['cart'] as $games => $value){
                    if($value['id'] == $_GET['id']){
                        $_SESSION['cart'][$games]['quantity']=$_POST['newquan'];
                        $this->cart();
                }
            }
        }
    }

    }
    public function update()
    {
        if(!$_POST){
            $this->index();
            return;
        }
        
        $this->game=(object)$_POST;
        
        if($this->nameControl() 
        && $this->priceControl()
        && $this->descControl() 
        && $this->quanControl() 
        && $this->memoryControl() 
        && $this->consoleControl()
        )
        {
            Games::update((array)($this->game));
            $this->index();
        }
        else 
        {
            $this->view->render($this->viewDir . 'change',[
                "game" =>$this->game,
                'message'=>$this->message
            ]);
        }
    }
    public function remove()
    {
           foreach($_SESSION['cart'] as $game=>$value){
               if($value['id'] == $_GET['id']){
                   unset($_SESSION['cart'][$game]);
                   $this->cart();
               } 
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
        public function clear()
        {
            unset($_SESSION['cart']);
            $this->cart();
        }
    }
