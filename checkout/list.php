<?php
include '../config/runConfig.php';


try {
    include '../common/pagination.php';
    $res = query("SELECT `checkout`.code,`checkout`.status,`checkout`.created_at as datetime,`marketer`.fullname,`marketer`.wallet 
                  FROM checkout 
                  INNER JOIN `marketer` ON (`marketer`.id=`checkout`.marketerID)
                  WHERE `checkout`.active=:active 
                ".$pagination,
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
