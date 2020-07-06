<?php
include '../config/runConfig.php';


try {
    include '../commnon/pagination.php';
    $pageID = $_GET['pageID'];
    $res = query("SELECT category.name,category.code,category.icon,page.name as page
                  FROM category
                  INNER JOIN page 
                  ON (page.id=category.pageID) 
                  WHERE category.pageID=:pageID AND category.active=:active
                ".$pagination,
                array(
                    ':pageID'=>$pageID,
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


