<?php 

class ControlpanelController extends AuthorizeController
{
    public function index() 
    {
        $this->view->render('private' . DIRECTORY_SEPARATOR . 'index',[
        'games'=>Games::readPreorder() 
        ]);
    }
}