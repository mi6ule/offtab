<?php
include 'randomClass.php';

use Utils\RandomStringGenerator;

function createRandom($length){
    // Create new instance of generator class.
    $generator = new RandomStringGenerator;
    // Set token length.
    $tokenLength = $length;
    // Call method to generate random string.
    $token = $generator->generate($tokenLength);
    return $token;
}