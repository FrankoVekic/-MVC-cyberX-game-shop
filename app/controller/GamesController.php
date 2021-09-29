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
        if($page===0){
            $page=1;
        }

        $gameCount = Games::gameCount();
        $pageCount = ceil($gameCount/App::config('dpp'));
        
        if($page>$pageCount){
            $page=$pageCount;
        }
        
        $this->view->render($this->viewDir . 'index',[
            'games'=>Games::read($page),
            'page'=>$page,
            'pageCount'=>$pageCount
        ]);
    }

    public function cart()
    {
        $this->view->render($this->viewDir . 'cart');
    }
    /*
    public function add()
    {
        if(isset($_POST['add'])){
            if(isset($_SESSION['shopping_cart'])){
              $game_array_id = array_column($_SESSION['shopping_cart'],'game_id');
              if(!in_array($_GET['id'],$game_array_id)){
                $get = count($_SESSION['shopping_cart']);
                $game_array = array(
                'game_id' => $_GET['id'],
                'game_name' => $_POST['hidden_name'],
                'game_price' => $_POST['hidden_price'],
                'game_quantity' => $_POST['quantity'],
                'game_image' => $_POST['hidden_image'],
                'game_console' => $_POST['hidden_console']
                );
                $_SESSION["shopping_cart"][$get] = $game_array;
              }
            }
            else {
              $game_array = array(
                'game_id' => $_GET['id'],
                'game_name' => $_POST['hidden_name'],
                'game_price' => $_POST['hidden_price'],
                'game_quantity' => $_POST['quantity'],
                'game_image' => $_POST['hidden_image'],
                'game_console' => $_POST['hidden_console']
              );
              $_SESSION['shopping_cart'][0] = $game_array;
            }
        }
    }
    */

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
}