<?php 

class IndexController extends Controller
{
    
    public function index()
    {
        if(Request::isAdmin()){
            $this->view->render('private' . DIRECTORY_SEPARATOR . 'index');
        }
        else {
            $this->view->render('index');
        }
    }

    public function erdiagram()
    {
        $this->view->render('erdiagram');
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

    //this has to be changed

   public function register()
    {
        $this->registerView('','','','Enter required information!');
    }  

    public function logout()
    {
        unset($_SESSION['authorized']);
        session_destroy();
        $this->index();
    }

    public function registration()
    {
        if(!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirmPassword'])){
            $this->register();
            return;
        } 

        //registerView($name,$surname,$email,$message)

        //here we know if email and password are set
        if(strlen(trim($_POST['name'])) ===0){
            $this->registerView('',$_POST['surname'],$_POST['email'],'Name empty!');
            return;
        }
        if(strlen(trim($_POST['email'])) ===0){
            $this->registerView($_POST['name'],$_POST['surname'],'','Email empty!');
            return;
        }
        if(strlen(trim($_POST['surname'])) ===0){
            $this->registerView($_POST['name'],'',$_POST['email'],'Surname empty!');
            return;
        }
        if(strlen(trim($_POST['password'])) ===0){
            $this->registerView($_POST['name'],$_POST['surname'],$_POST['email'],'Password is required');
            return;
     }
        if($_POST['password'] != $_POST['confirmPassword']){
            $this->registerView($_POST['name'],$_POST['surname'],$_POST['email'],'Passwords must match.');
            return;
        }
    //checking if email is already in use
    $operater = Operater::registration($_POST['name'],$_POST['surname'],$_POST['email'],$_POST['password'],$_POST['confirmPassword']);
    if($operater == false){
        $this->registerView('','','','Incorrect input, try again.');
        return;
    }
    if($operater == true){
        $this->loginView($_POST['email'],'Registered successfully.');
        return;
    } 
}

    public function authorisation()
    {
        if(!isset($_POST['email']) || !isset($_POST['password'])){
            $this->login();
            return;
        }
        if(strlen(trim($_POST['email'])) ===0){
            $this->loginView('','Email is required');
            return;
        }
        if(strlen(trim($_POST['password'])) ===0){
            $this->loginView($_POST['email'],'Password is required');
            return;
    }
    $user = Operater::authorize($_POST['email'],$_POST['password']);
    if($user == null){
        $this->loginView($_POST['email'],'Incorrect input.');
        return;
    }

    //here i know if the user is logged in
    $_SESSION['authorized']=$user;
    $cp = new ControlpanelController();
    $cp->index();
  }

  private function loginView($email,$message)
    { 
        $this->view->render('login',
        ['email'=>$email,
         'message'=>$message]);
    }

private function registerView($name,$surname,$email,$message)
{ 
    $this->view->render('register',
    ['email'=>$email,
    'name'=>$name,
    'surname'=>$surname,
     'message'=>$message]);
}

}
