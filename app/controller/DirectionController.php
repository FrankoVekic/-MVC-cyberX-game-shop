<?php 

class DirectionController extends AuthorizeController
{

    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'direction' . DIRECTORY_SEPARATOR;

    private $game;
    private $message;

    public function __construct()
    {
        parent::__construct();
        $this->game = new stdClass();
        $this->game->name="";
        $this->game->price="0,00";
        $this->game->description="";
        $this->game->quantity="0";
        $this->game->memory_required="0";
        $this->game->console=false;
    }

    public function admin() 
    {
        $this->view->render($this->viewDir . 'admin',['games'=>Games::read()]);
    } 

    public function add()
    {
        $this->view->render($this->viewDir . 'new',[
            "game" =>$this->game,
            'message'=>'Enter required data.'
        ]);
    }

    public function newGame()
    {
        if(!$_POST){
            $this->add();
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
            $this->game->price = str_replace(array('.', ','), array('', '.'), 
            $this->game->price);
            Games::create((array)($this->game));
            $this->admin();
        }
        else 
        {
            $this->view->render($this->viewDir . 'new',[
                "game" =>$this->game,
                'message'=>$this->message
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
        if(!preg_match("/^[a-zA-Z0-9]*$/" , $this->game->name)){
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
        if(!preg_match("/^[a-zA-Z0-9]*$/" , $this->game->description)){
            $this->message="You can only write letters and numbers";
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

    public function games() 
    {
        $this->view->render($this->viewDir . 'games');
    } 

    public function delete()
    {
        if(!isset($_GET['id'])){
            $this->admin();
        }else {
            $id = $_GET['id'];
            Games::delete($id);
            $this->admin();
        }
    }
}