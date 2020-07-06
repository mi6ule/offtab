<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['price','detail','marketerCode','checkoutCode']);
    $resFind = query("SELECT * FROM marketer WHERE code=:code AND active=:active LIMIT 1",
                array(
                    ':code'=>$jsonData['marketerCode'],
                    ':active'=>true
                    )
                );
    $resFind = $resFind->fetchAll();
    $price = (int)$jsonData['price'];
    $total =(int)$resFind[0]['wallet'] - $price;
    $res = query("INSERT INTO transaction (price,code,detail,marketerID,active) VALUES (:price,:code,:detail,:marketerID,:active)",
                array(
                    ':price'=> $jsonData['price'],
                    ':code'=> createRandom(8),
                    ':active'=> true,
                    ':detail'=> $jsonData['detail'],
                    ':marketerID'=> $resFind[0]['id']
                    )
    );
    $resUpdate = query("UPDATE marketer SET wallet=:wallet WHERE code=:code AND active=:active",
                array(
                    ':wallet'=>$total,
                    ':code'=>$jsonData['marketerCode'],
                    ':active'=>true
                    )
    );
    $resUpdateCheckOut = query("UPDATE checkout SET status=:status WHERE code=:code AND active=:active",
                array(
                    ':status'=>2,
                    ':code'=>$jsonData['checkoutCode'],
                    ':active'=>true
                    )
    );
    $resMarketerUpdate = query("UPDATE marketer SET status=:status WHERE id=:id AND active=:active",
                array(
                    ':status'=>1,
                    ':id'=>$resFind[0]['id'],
                    ':active'=>true
                    )
    );
    response("created",201);
}
catch(Exception $e) {
    errorHandler($e);
}
