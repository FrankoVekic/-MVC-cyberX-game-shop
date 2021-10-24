<?php 

class AdminController extends AuthorizeController
{

    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
    private $imgDir = BP . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'order' . DIRECTORY_SEPARATOR;

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
        $this->game->image='';
    }

    public function index() 
    {
        /*
        $games = Games::read();
        $nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $nf->setPattern(",#.00 kn");
            
        foreach($games as $game){
                $game->price = $nf->format($game->price);
        }
        */
        if(Request::isAdmin()){
            $this->view->render($this->viewDir . 'index',[
                'games'=>Games::readAdmin()]);
        }
        else {
            $this->view->render('private' . DIRECTORY_SEPARATOR . 'index');
        }
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
        if(Request::isAdmin()){
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
            $this->view->render($this->viewDir . 'index',[
                'games'=>Games::readAdmin(),
                'errorMsg'=> 'Game successfully added',
                'color'=>'green'
        ]);
        }
        else 
        {
            $this->view->render($this->viewDir . 'new',[
                "game" =>$this->game,
                'message'=>$this->message
            ]);
        }
    }
    else {
        $this->view->render('private' . DIRECTORY_SEPARATOR . 'index');
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
            $this->message = "Description is required";
            return false;
        }
        if(strlen(trim($this->game->description)) === 0){
            $this->message="Description is required";
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
    public function delete()
    {
        if(!isset($_GET['id'])){
            $this->index();
        }else {
            $id = $_GET['id'];
            if(Games::checkRow($id)){
                $this->view->render($this->viewDir . 'index',[
                    'games'=>Games::readAdmin(),
                    'errorMsg'=> 'Game can not be deleted.',
                    'color'=>'red'
            ]);
            }
            else {
                Games::delete($id);
                if(file_exists($this->imgDir . $_GET['id'] . '.jpg')){
                unlink($this->imgDir . $_GET['id'] . '.jpg');
                }
                $this->view->render($this->viewDir . 'index',[
                    'games'=>Games::readAdmin(),
                    'errorMsg'=> 'Game successfully deleted.',
                    'color'=>'green'
            ]);
            }
        }
    }

    public function change()
    {
    if(Request::isAdmin() && isset($_GET['id'])){
        $this->game = Games::findGame($_GET['id']);
        if($this->game==null){
            $this->index();
        }else {
        $this->view->render($this->viewDir . 'change',[
            "game" =>$this->game,
            'message'=>'Change game data'
        ]);
        }
    }else {
        $this->view->render('private' . DIRECTORY_SEPARATOR . 'index');
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
            $file = $_FILES['image']['name'];
            if (!$file){
                $img = $_SESSION['image'];
                Games::update((array)($this->game),$img);
                unset($_SESSION['image']);
            }else {
                $img = $this->game->id . '.jpg';
                Games::update((array)($this->game),$img);
        }
            if(isset($_FILES['image'])){
                move_uploaded_file($_FILES['image']['tmp_name'],
                $this->imgDir . $this->game->id . '.jpg');
            }
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
