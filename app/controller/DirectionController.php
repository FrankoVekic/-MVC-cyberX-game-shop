<?php 

class DirectionController extends AuthorizeController
{

    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'direction' . DIRECTORY_SEPARATOR;

    public function games() 
    {
        $this->view->render($this->viewDir . 'games');
    } 

    public function admin() 
    {
        $this->view->render($this->viewDir . 'admin');
    } 
}