
<?php
include '../config/runConfig.php';


try {
    $res = query("SELECT * FROM discountCode WHERE active=:active",
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