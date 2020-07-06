<?php
include '../config/runConfig.php';


try {
    include '../common/pagination.php';
    $catID = $_GET['catID'];
    $res = query("SELECT product.name,product.code,product.image,product.description,product.detail,product.exist,product.price,category.name as categoryName,category.code as categoryCode
                  FROM product
                  INNER JOIN category 
                  ON (category.id=product.catID) 
                  WHERE product.catID=:catID AND product.active=:active
                ".$pagination,
                array(
                    ':catID'=>$catID,
                    ':active'=>true
                    )
                );
    $res = $res->fetchAll();
    if($res){
        foreach($res as $key=>$value){
            $res[$key]['image']=json_decode($value['image'],true);
            $res[$key]['detail']=json_decode($value['detail'],true);
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


