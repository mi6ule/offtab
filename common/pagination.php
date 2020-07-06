<?php
$per = 10;
$part = isset($_GET['part']) ? (int)$_GET['part'] : 1;
$page = $per * ($part - 1);
$pagination = " LIMIT ".$page.",".$per."";
