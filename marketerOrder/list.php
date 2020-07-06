<?php
include '../config/runConfig.php';

//Permission
include '../marketerAuth/auth.php';


try {
    $id = $GLOBALS['marketerID'];
    $resMarketer = query("SELECT * FROM `marketer` WHERE id=:id AND active=:active LIMIT 1",
                    array(
                        ':id'=>$id,
                        ':active'=>true
                     )
    );
    $resMarketer = $resMarketer->fetchAll();
    $res = query("SELECT `product`.name,`product`.code,`product`.image,`product`.description,`product`.detail,`product`.price,`order`.code as orderCode, `order`.basePrice,`order`.paidPrice,`order`.fullname,`order`.mobile,`order`.address,`order`.postalCode,`order`.city,`order`.state,`order`.detail as orderDetail,`order`.bankInfo,`order`.discountCode,`order`.marketerCode,`order`.created_at as datetime,`marketer`.fullname as marketer
                  FROM `product`
                  INNER JOIN `order` 
                  ON (`product`.id=`order`.productID) 
                  INNER JOIN `marketer` 
                  ON (`marketer`.code=`order`.marketerCode) 
                  WHERE `order`.active=:active AND `marketer`.code=:marketerCode
                ",
                array(
                    ':marketerCode'=>$resMarketer[0]['code'],
                    ':active'=>true
                    )
                );
    $res = $res->fetchAll();
    if($res){
        foreach($res as $key=>$value){
            $res[$key]['image']=json_decode($value['image'],true);
            $res[$key]['detail']=json_decode($value['detail'],true);
            $res[$key]['orderDetail']=json_decode($value['orderDetail'],true);
        }
        response($res,200);
    }
    else{
        throw new Exception("404");
    }
}
catch(Exception $e) {
    errorHandler($e);
}


