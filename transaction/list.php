<?php
include '../config/runConfig.php';


try {
    $res = query("SELECT `transaction`.code,`transaction`.detail,`transaction`.price,`transaction`.created_at as datetime,`marketer`.fullname 
                  FROM transaction 
                  INNER JOIN `marketer` ON (`marketer`.id=`transaction`.marketerID)
                  WHERE `transaction`.active=:active 
                ",
                array(
                    ':active'=>true
                    )
                );
    $res = $res->fetchAll();
    if($res){
        response($res,200);
    }
    else{
        throw new Exception("404");
    }
}
catch(Exception $e) {
    errorHandler($e);
}