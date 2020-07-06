<?php
include '../config/runConfig.php';

//Permission
include '../marketerAuth/auth.php';


try {
    include '../common/pagination.php';
    $id = $GLOBALS['marketerID'];
    $res = query("SELECT `checkout`.code,`checkout`.status,`checkout`.created_at as datetime,`marketer`.fullname,`marketer`.wallet 
                  FROM checkout 
                  INNER JOIN `marketer` ON (`marketer`.id=`checkout`.marketerID)
                  WHERE `checkout`.active=:active AND `checkout`.marketerID=:marketerID
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
