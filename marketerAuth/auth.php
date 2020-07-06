<?php
// include '../../config/runConfig.php';

try{
    $found = false;
    foreach (getallheaders() as $name => $value) {
        if($name==="token"){
            $found = true;
            $res = query("SELECT id FROM marketer WHERE token=:token AND active=true LIMIT 1",
                array(':token'=> $value)
                );
            $res = $res->fetchAll();
            if(isset($res[0]['id'])){
                $GLOBALS['marketerID'] = $res[0]['id'];
            }
            else{
                throw new Exception("403");
            }
        }
    }
    if(!$found){
        throw new Exception("403");
    }
}
catch(Exception $e) {
    errorHandler($e);
}






