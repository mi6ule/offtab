<?php
include '../config/runConfig.php';


try {
    $newName = createRandom(32);
    $nameOBJ = array(
        "name" => $newName
    );
    response($nameOBJ,201);
}
catch(Exception $e) {
    errorHandler($e);
}
