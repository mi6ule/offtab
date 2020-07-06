<?php
include '../config/runConfig.php';

//Permission
include '../marketerAuth/auth.php';


try {
    $id = $GLOBALS['marketerID'];
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,[]);
    $resMarketer = query("SELECT * FROM `marketer` WHERE id=:id AND active=:active LIMIT 1",
                    array(
                        ':id'=>$id,
                        ':active'=>true
                     )
    );
    $resMarketer = $resMarketer->fetchAll();
    if($resMarketer[0]['status']==1 && $resMarketer[0]['wallet']>0){
        $res = query("INSERT INTO checkout (marketerID,status,code,active) VALUES (:marketerID,:status,:code,:active)",
                    array(
                        ':marketerID'=> $id,
                        ':code'=> createRandom(8),
                        ':active'=> true,
                        ':status'=> 1
                        )
        );
        $resMarketerUpdate = query("UPDATE marketer SET status=:status WHERE id=:id AND active=:active",
                array(
                    ':status'=>2,
                    ':id'=>$id,
                    ':active'=>true
                    )
        );
    }
    else{
        throw new Exception("403");
    }
    response("created",201);
}
catch(Exception $e) {
    errorHandler($e);
}
