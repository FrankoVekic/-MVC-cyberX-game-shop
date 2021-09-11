<?php 

class Operater 
{
    public static function authorize($email,$password)
    {
        $conn = DB::getInstance();
        $query = $conn->prepare('SELECT * FROM operater WHERE email=:email');
        $query->execute(['email'=>$email]);
        $operater = $query->fetch();

        if($operater==null){
            return null;
        }
        if(!password_verify($password,$operater->password)){
            return null;
        }
        unset($operater->$password);
        return $operater;     
    }
}