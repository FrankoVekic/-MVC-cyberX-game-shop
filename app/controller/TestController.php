<?php 

class TestController 
{
    public function password()
    {
        echo password_hash('a',PASSWORD_BCRYPT);
    }
}