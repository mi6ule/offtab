<?php
function response($data,$status){
    header('Content-Type: application/json');
    // header(':', true, $status);
    // header('X-PHP-Response-Code: '+$status, true, $status);
    http_response_code($status);
    if(!isset($data['type'])){
        $resOBJ = array(
            "type" => "DATA",
            "status"=> $status,
            "message"=> "Ok!",
            "detail"=>$data
        );
        $JSON = json_encode($resOBJ);
    }
    else{
        $JSON = json_encode($data);
    }
    echo $JSON;
}
