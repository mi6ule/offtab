<?php
include '../config/runConfig.php';


try {
    $discountCode = $_GET['discountCode'];
    date_default_timezone_set('Asia/Tehran');
    $res = query("SELECT * FROM discountCode WHERE active=:active AND code=:discountCode LIMIT 1",
                array(
                    ':active'=>true,
                    ':discountCode'=>$discountCode
                    )
                );
    $res = $res->fetchAll();
 
    if($res){
        $now = date("Y-m-d H:i:s");
        $valid = false;
        if($res[0]['valid'] && $res[0]['expiry']>$now){
           $valid=true;
        }
        $qualify = array(
            "valid"=>$valid
        );
        response($qualify,200);
    }
    else{
        throw new Exception("404");
    }
}
catch(Exception $e) {
    echo $e;
    errorHandler($e);
}