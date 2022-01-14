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
        $CustomerID = $_POST['Comment'];
        $Orders = $_POST['Rating'];
        $Address = $_POST['DishID'];
        $Num = $_POST['CustomerID'];
        // database insert SQL code
        $sql = "INSERT INTO `Reviews` (Comment,Rating,DishID,CustomerID) VALUES ('$CustomerID','$Orders','$Address','$Num')";
        if (mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('Added Successfully');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Error');</script>";
        }
        // echo $sql;
    }
}
?>