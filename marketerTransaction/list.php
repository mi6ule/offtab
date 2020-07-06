<?php
include '../config/runConfig.php';

//Permission
include '../marketerAuth/auth.php';


try {
    include '../common/pagination.php';
    $id = $GLOBALS['marketerID'];
    $res = query("SELECT `transaction`.code,`transaction`.detail,`transaction`.price,`transaction`.created_at as datetime,`marketer`.fullname 
                  FROM transaction 
                  INNER JOIN `marketer` ON (`marketer`.id=`transaction`.marketerID)
                  WHERE `transaction`.active=:active AND `transaction`.marketerID=:marketerID
                ".$pagination,
                array(
                    ':marketerID'=>$id,
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
