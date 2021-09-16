<?php 

class DirectionController extends AuthorizeController
{

    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'direction' . DIRECTORY_SEPARATOR;

    private $game;
    private $message;

    public function add()
    {
        $this->view->render($this->viewDir . 'new',[
            "game" =>$this->game,
            'message'=>'Enter required data.'
        ]);
    }
    
    public function admin() 
    {
        $this->view->render($this->viewDir . 'admin',['games'=>Games::read()]);
    } 

    public function games() 
    {
        $this->view->render($this->viewDir . 'games');
    } 
}