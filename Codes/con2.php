<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "group15read_only";
$pass = "DRngFU";
$db = "group15";

$conn = new mysqli($servername, $username, $pass, $db);
if($conn->connect_error){
 echo "<script type='text/javascript'>alert('Connection Failed');</script>";
}
else{
     echo "<script type='text/javascript'>alert('Connection Successful');</script>";
}
?>
