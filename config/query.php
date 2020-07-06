<?php
$GLOBALS['conn'] = $conn;
function query($query,$binds="null") {
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->execute($binds);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    $conn =null;
    return $stmt;
}