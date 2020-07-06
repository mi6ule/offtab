<?php
function validation($inputs,$requires){
    foreach($requires as $rq){
        if(!isset($inputs[$rq]))
        throw new Exception("400");
    }
}