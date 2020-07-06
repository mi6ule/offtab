<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['expiry','productID','price','count']);
    $count = $jsonData['count'];
    $date = strtotime($jsonData['expiry']);
    while($count>0){
        $res = query("INSERT INTO discountCode (expiry,code,price,valid,productID,active) VALUES (:expiry,:code,:price,:valid,:productID,:active)",
            array(
                ':expiry'=> date('Y-m-d H:i:s', $date),
                ':code'=> createRandom(8),
                ':active'=> true,
                ':valid'=> true,
                ':productID'=> $jsonData['productID'],
                ':price'=> $jsonData['price'],
                )
        );
        $count = $count-1;
    }
    response("created",201);
}
catch(Exception $e) {
    echo $e;
    errorHandler($e);
}
