<?php 
$dev = $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? true : false;

if($dev){
    $database = [
        'host'=>'localhost',
        'dbName'=>'cyberx',
        'username'=>'root',
        'password'=>''       
    ];
    $url = 'http://edunovapp23.xyz/';
}
else {
    $database = [
        'host'=>'localhost',
        'dbName'=>'aurelije_cyberx',
        'username'=>'aurelije_pp23',
        'password'=>'Edunova1.'        
    ];
    $url = 'https://polaznik02.edunova.hr/';
}

return [
    'dev' => $dev,
    'appName' => 'CyberX Games',
    'url' => $url,
    'database'=>$database
];