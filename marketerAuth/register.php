<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['fullname','mobile','address','city','state','password']);
    $res = query("INSERT INTO marketer (fullname,code,wallet,active,token,mobile,address,city,state,password) VALUES (:fullname,:code,:wallet,:active,:token,:mobile,:address,:city,:state,:password)",
                array(
                    ':fullname'=> $jsonData['fullname'],
                    ':code'=> createRandom(8),
                    ':wallet'=> 0,
                    ':active'=> true,
                    ':token'=> createRandom(64),
                    ':mobile'=> $jsonData['mobile'],
                    ':address'=> $jsonData['address'],
                    ':city'=> $jsonData['city'],
                    ':state'=> $jsonData['state'],
                    ':password'=> md5($jsonData['password'])
                    )
    );
    response("created",201);
}
catch(Exception $e) {
    errorHandler($e);
}
