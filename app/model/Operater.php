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

    public static function registration($name,$surname,$email,$password,$confirmPassword)
    {
        $conn = DB::getInstance();
        $query = $conn->prepare('SELECT * FROM operater WHERE email=:email');
        $query->execute(['email'=>$email]);
        $operater = $query->fetch();
        
        if($operater!=null){
            return false;
        }
        else {
        $passwordhash = password_hash($password,PASSWORD_BCRYPT);
        $query = $conn->prepare("INSERT INTO operater (email,password,name,surname,role) VALUES (:email,:password,:name,:surname,'oper');");
        $query->bindParam(":email",$email);
        $query->bindParam(":name",$name);
        $query->bindParam(":surname",$surname);
        $query->bindParam(":password",$passwordhash);
        $query->execute();
        return true;
        }
    }
}