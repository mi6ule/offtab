
<?php
include '../config/runConfig.php';


try {
    include '../common/pagination.php';
    $res = query("SELECT * FROM discountCode WHERE active=:active".$pagination,
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
