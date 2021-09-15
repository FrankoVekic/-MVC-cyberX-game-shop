<?php 

class DirectionController extends AuthorizeController
{

    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'direction' . DIRECTORY_SEPARATOR;

    private $game;
    private $message;

    
    public function games() 
    {
        $this->view->render($this->viewDir . 'games',['games'=>Games::read()]);
    } 

    public function admin() 
    {
        $this->view->render($this->viewDir . 'admin');
    } 
}