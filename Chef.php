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
        $num_hr = $_POST['No_of_hrs_worked'];
        $sig_dish = $_POST['SignatureDish'];
        $Yw = $_POST['Years_worked'];
        // database insert SQL code
        $sql = "INSERT INTO `Chef` (No_of_hrs_worked,SignatureDish,Years_worked) VALUES ('$num_hr','$sig_dish','$Yw')";
        if (mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('Added Successfully');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Error');</script>";
        }
        // echo $sql;
    }
}
?>
