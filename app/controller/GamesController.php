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

    public function pay()
    {
        if($this->checkName() &&
           $this->checkSurname() && 
           $this->checkCard() &&
           $this->checkExpiry() &&
           $this->checkCvv() &&
           $this->checkAddress() &&
           $this->checkCity() &&
           $this->checkZipCode() &&
           $this->checkCountry()
           
           ){
            
        if(isset($_SESSION['cart'])){
            Checkout::order($_POST['buyer'],$_POST['order_date'],$_POST['address'],$_POST['city'],$_POST['country']);
            foreach($_SESSION['cart'] as $game ){
                Checkout::orderGame($game['id'],$game['quantity']);
            }
            unset($_SESSION['cart']);
            $this->view->render($this->viewDir . 'cart',[
                'message'=>'Thank you for purchasing from us!'
            ]);
        }else {
            $this->view->render($this->viewDir . 'checkout',[
                'message'=>$this->message
            ]);
        }
        }else {
            $this->view->render($this->viewDir . 'checkout',[
                'message'=>$this->message
            ]);
        }
    }

    public function checkName()
    {
        if(!isset($_POST['name'])){
            $this->message ="Name can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['name'])) === 0){
            $this->message ="Name can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['name']))>50){
            $this->message ="Max number of letters is 50";
        }else {
            return true;
        }
        if(!preg_match("/^[a-zA-Z]*$/" , $_POST['name'])){
            $this->message ="Name can only contain letters.";
            return false;
        }
    }

    public function checkSurname()
    {
        if(!isset($_POST['surname'])){
            $this->message ="Surname can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['surname'])) === 0){
            $this->message ="Surname can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['surname']))>50){
            $this->message ="Max number of letters is 50";
        }
        if(!preg_match("/^[a-zA-Z]*$/" , $_POST['surname'])){
            $this->message ="Surname can only contain letters.";
            return false;
        }
        else {
            return true;
        }
    }
    public function checkCard()
    {
        if(!isset($_POST['card'])){
            $this->message ="Card can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['card'])) === 0){
            $this->message ="Card can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['card'])) != 16){
            $this->message ="Invalid card number";
            return false;
         }
         if(!preg_match('/^[0-9]*$/', $_POST['card'])){
            $this->message ="Invalid card number";
            return false;
         }
         return true;
    }

    public function checkExpiry()
    {
        if(!isset($_POST['expiry'])){
            $this->message ="Expiry can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['expiry'])) === 0){
            $this->message ="Expiry can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['expiry'])) != 4){
            $this->message ="Invalid expiry date";
            return false;
         }
         if(!preg_match('/^[0-9]*$/', $_POST['expiry'])){
            $this->message ="Invalid expiry date";
            return false;
         }
         return true;
    }

    public function checkCvv()
    {
        if(!isset($_POST['cvv'])){
            $this->message ="CVV can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['cvv'])) === 0){
            $this->message ="CVV can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['cvv'])) != 3){
            $this->message ="Invalid CVV";
            return false;
         }
         if(!preg_match('/^[0-9]*$/', $_POST['cvv'])){
            $this->message ="Invalid CVV";
            return false;
         }
         return true;
    }

    public function checkAddress()
    {
        if(!isset($_POST['address'])){
            $this->message ="Address can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['address'])) === 0){
            $this->message ="Address can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['address']))>50){
            $this->message ="Max number of letters is 50";
            return false;
        }
            return true;
    }

    public function checkCity()
    {
        if(!isset($_POST['city'])){
            $this->message ="City can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['city'])) === 0){
            $this->message ="City can't be empty.";
            return false;
        }
        if(!preg_match("/^[a-zA-Z]*$/" , $_POST['city'])){
            $this->message ="City can only contain letters.";
            return false;
        }
        if(strlen(trim($_POST['city']))>30){
            $this->message ="Invalid City";
            return false;
         }
         return true;
    }

    public function checkZipCode()
    {
        if(!isset($_POST['zipcode'])){
            $this->message ="Zip Code can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['zipcode'])) === 0){
            $this->message ="Zip Code can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['zipcode']))!=5){
            $this->message ="Invalid Zip Code";
            return false;
         }
         if(!preg_match('/^[0-9]*$/', $_POST['zipcode'])){
            $this->message ="Invalid Zip Code";
            return false;
         }
         return true;
    }

    public function checkCountry()
    {
        if(!isset($_POST['country'])){
            $this->message ="Country can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['country'])) === 0){
            $this->message ="Country can't be empty.";
            return false;
        }
        if(strlen(trim($_POST['country']))>30){
            $this->message ="Invalid Country";
            return false;
         }
         return true;
    }
    public function checkout()
    {
        $date = date('Y-m-d H:i:s');
        if(!empty($_SESSION['cart'])){
            $this->view->render($this->viewDir . 'checkout',[
            'message'=>'Enter required data',
            'date'=>$date
            ]);
        }else {
            $this->view->render($this->viewDir . 'cart',[
                'message'=>'Cart is empty.'
            ]);
        }
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
