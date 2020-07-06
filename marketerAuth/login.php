<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['mobile','password']);
    $mobile=$jsonData['mobile'];
    $password=md5($jsonData['password']);
    $res = query("SELECT token FROM marketer WHERE mobile=:mobile AND password=:password AND active=true LIMIT 1",
                array(
                    ':mobile'=>$mobile,
                    ':password'=>$password
                    )
                );
    $res = $res->fetchAll();
    if($res){
        response($res[0],200);
    }
    else{
        throw new Exception("404");
    }
}
catch(Exception $e) {
    errorHandler($e);
}