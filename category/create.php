<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['name','icon','pageID']);
    $res = query("INSERT INTO category (name,code,icon,pageID,active) VALUES (:name,:code,:icon,:pageID,:active)",
                array(
                    ':name'=> $jsonData['name'],
                    ':code'=> createRandom(8),
                    ':active'=> true,
                    ':icon'=> $jsonData['icon'],
                    ':pageID'=> $jsonData['pageID']
                    )
    );
    response("created",201);
}
catch(Exception $e) {
    errorHandler($e);
}
