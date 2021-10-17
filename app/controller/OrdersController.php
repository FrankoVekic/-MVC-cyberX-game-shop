<?php 

class OrdersController extends AuthorizeController
{
    private $viewDir = 'private' . DIRECTORY_SEPARATOR . 'orders' . DIRECTORY_SEPARATOR;

    public function index()
    {
        if(Request::isAdmin()){
            $this->view->render($this->viewDir . 'index');
        }
        else {
            $this->view->render('private' . DIRECTORY_SEPARATOR . 'index');
        }
        $this->view->render($this->viewDir . 'index');
    }
}