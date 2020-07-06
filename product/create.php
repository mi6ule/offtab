<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['name','image','description','detail','exist','price','percentOfMarketer','catID']);
    $res = query("INSERT INTO product (name,image,description,detail,exist,price,percentOfMarketer,catID,code,active) VALUES (:name,:image,:description,:detail,:exist,:price,:percentOfMarketer,:catID,:code,:active)",
                array(
                    ':name'=> $jsonData['name'],
                    ':code'=> createRandom(8),
                    ':active'=> true,
                    ':image'=> json_encode($jsonData['image'],true),
                    ':description'=> $jsonData['description'],
                    ':detail'=> json_encode($jsonData['detail'],true),
                    ':exist'=> $jsonData['exist'],
                    ':price'=> $jsonData['price'],
                    ':percentOfMarketer'=> $jsonData['percentOfMarketer'],
                    ':catID'=> $jsonData['catID'],
                    )
    );
    response("created",201);
}
catch(Exception $e) {
    echo $e;
    errorHandler($e);
}
