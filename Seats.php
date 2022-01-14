<?php

session_start();

if (!isset($_SESSION['user'])) {

    header("Location:login/index.php");
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("con.php");
    // echo("$_POST[No_of_hrs_worked]");


    if (isset($_POST["submit"])) {
        $CustomerID = $_POST['TableID'];
        $Orders = $_POST['Available_seats'];
        // $Address = $_POST['DishID'];
        $Num = $_POST['CustomerID'];
        // database insert SQL code
        $sql = "INSERT INTO `Seats` (TableID,Available_seats) VALUES ('$CustomerID','$Orders','$Num')";
        if (mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('Added Successfully');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Error');</script>";
        }
        // echo $sql;
    }
}
?>
