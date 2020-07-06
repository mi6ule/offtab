<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['name','description','image']);
    $res = query("INSERT INTO page (name,code,description,image,active) VALUES (:name,:code,:description,:image,:active)",
                array(
                    ':name'=> $jsonData['name'],
                    ':code'=> createRandom(8),
                    ':active'=> true,
                    ':description'=> $jsonData['description'],
                    ':image'=> $jsonData['image']
                    )
    );
    response("created",201);
}
catch(Exception $e) {
    errorHandler($e);
}
