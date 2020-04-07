<?php

// Php file that creates a new connection to be used for database interaction

$hn = 'localhost';  
$un = 'root';
$pw = '';
$db = 'achievers';  // local database


$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error)
     die($conn->connect_error);

 ?>
 