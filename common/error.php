<?php
function errorHandler($err){
    $errorList = array(
        "Not Found!" => "404",
        "Access Forbidden!"=> "403",
        "Bad Request!"=> "400"
    );
    $error = $err->getMessage();
    $errorMsg = array_search($error,$errorList,true);
    $errOBJ = array(
        "type" => "ERROR",
        "status"=> (int)$error,
        "message"=> $errorMsg
    );
    response($errOBJ,(int)$error);
    exit();
}