<?php
include '../config/runConfig.php';


try {
    $json = file_get_contents('php://input');
    $jsonData = json_decode($json, true);
    validation($jsonData,['mobile','address','postalCode','city','state','bankInfo','discountCode','marketerCode','color','size','productCode']);
    $resFind = query("SELECT id,exist,detail,price,percentOfMarketer FROM product WHERE code=:code AND active=:active LIMIT 1",
                array(
                    ':code'=>$jsonData['productCode'],
                    ':active'=>true
                    )
                );
    $resFind = $resFind->fetchAll();
    $dcPrice = 0;
    if(isset($jsonData['discountCode'])){
        $resDC = query("SELECT * FROM discountCode WHERE code=:code AND active=:active AND valid=:valid AND productID=:productID LIMIT 1",
                    array(
                    ':code'=>$jsonData['discountCode'],
                    ':active'=>true,
                    ':valid'=>true,
                    ':productID'=>$resFind[0]['id']
                    )
        );
        $resDC = $resDC->fetchAll();
        $now = date("Y-m-d H:i:s");
        if($resDC){
            if($resDC[0]['valid'] && $resDC[0]['expiry']>$now){
                $dcPrice=(int)$resDC[0]['price'];
                $resUpdateDC = query("UPDATE discountCode SET valid=:valid WHERE code=:code AND active=:active LIMIT 1",
                        array(
                            ':valid'=>false,
                            ':code'=>$jsonData['discountCode'],
                            ':active'=>true
                            )
                );
            }
        }
    }
    $price = $resFind[0]['price'];
    $paidPrice = $price - $dcPrice;
    $exist = $resFind[0]['exist'] -1;
    $items = json_decode($resFind[0]['detail'],true);
    $check = false;
    foreach($items as $key=>$value) {
        if ( $jsonData['color'] == $value['color'] && $jsonData['size']==$value['size'] && $value['exist'] > 0 ) {
            $items[$key]['exist'] = $value['exist'] -1;
            $check = true;
            break;
        }
    }
    if(!$check) throw new Exception("404");
    $resInsert = query("INSERT INTO `order` (fullname,basePrice,paidPrice,mobile,address,postalCode,city,state,detail,bankInfo,discountCode,marketerCode,productID,code,active) VALUES (:fullname,:basePrice,:paidPrice,:mobile,:address,:postalCode,:city,:state,:detail,:bankInfo,:discountCode,:marketerCode,:productID,:code,:active)",
                array(
                    ':fullname'=>$jsonData['fullname'],
                    ':basePrice'=>$price,
                    ':paidPrice'=>$paidPrice,
                    ':mobile'=>$jsonData['mobile'],
                    ':address'=>$jsonData['address'],
                    ':postalCode'=>$jsonData['postalCode'],
                    ':city'=>$jsonData['city'],
                    ':state'=>$jsonData['state'],
                    ':bankInfo'=>$jsonData['bankInfo'],
                    ':detail'=>json_encode(array("color"=>$jsonData['color'],"size"=>$jsonData['size']),true),
                    ':discountCode'=>isset($jsonData['discountCode']) ? $jsonData['discountCode'] : null,
                    ':marketerCode'=>isset($jsonData['marketerCode']) ? $jsonData['marketerCode'] : null,
                    ':productID'=>$resFind[0]['id'],
                    ':code'=> createRandom(8),
                    ':active'=> true
                )
    );
    $resUpdate = query("UPDATE product SET detail=:detail,exist=:exist WHERE code=:code AND active=:active",
                array(
                    ':exist'=>$exist,
                    ':detail'=> json_encode($items,true),
                    ':code'=>$jsonData['productCode'],
                    ':active'=>true
                    )
    );
    if(isset($jsonData['marketerCode'])){
        $costOfMarketer = (int)$paidPrice * floatval ($resFind[0]['percentOfMarketer']);
        $resMarketerUpdate = query("UPDATE marketer SET wallet=wallet + :costOfMarketer WHERE code=:code AND active=:active",
                array(
                    ':costOfMarketer'=>$costOfMarketer,
                    ':code'=>$jsonData['marketerCode'],
                    ':active'=>true
                    )
        );
    }
    response("created",201);
}
catch(Exception $e) {
    errorHandler($e);
}