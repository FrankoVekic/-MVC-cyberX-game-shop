<?php 

class IndexController extends Controller
{
    public function index()
    {
        $this->view->render('index');
    }

    public function aboutus()
    {
        $this->view->render('aboutus',[
            'name'=>'Franko',
            'data' => [1,2,3,2,2,2,3]
        ]);
    }

    public function login()
    {
        if(Request::isAuthorized()){
            $cp = new ControlpanelController;
            $cp->index();
            return;
        }
        $this->loginView('','Enter required information!');
    }

    public function logout()
    {
        unset($_SESSION['authorized']);
        session_destroy();
        $this->index();
    }

    public function authorisation()
    {
        if(!isset($_POST['email']) || !isset($_POST['password'])){
            $this->login();
            return;
        }
        //here we know if email and password are set
        if(strlen(trim($_POST['email'])) ===0){
            $this->loginView('','Email is required');
            return;
        }
        if(strlen(trim($_POST['password'])) ===0){
            $this->loginView($_POST['email'],'Password is required');
            return;
    }
    $operater = Operater::authorize($_POST['email'],$_POST['password']);
    if($operater == null){
        $this->loginView($_POST['email'],'Incorrect input.');
        return;
    }

    //here i know if the user is logged in
    $_SESSION['authorized']=$operater;
    $cp = new ControlpanelController();
    $cp->index();
  }

  private function loginView($email,$message)
    { 
        $this->view->render('login',
        ['email'=>$email,
         'message'=>$message]);
    }
}