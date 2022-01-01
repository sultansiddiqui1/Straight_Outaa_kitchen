<html>

<head>
    <title>
        Chef Details
    </title>
</head>
<style>
    .data {
        text-align: center;
        max-width: 50%;
        flex-wrap: nowrap;
        margin: auto;
        vertical-align: middle;
    }
    
    hr {
        height: 5px;
        background-color: black;
        border-radius: 50%;
    }
    
    .text {
        margin-top: 50px;
    }
    
    .text b {
        font-size: 35px;
    }
    
    img {
        border-radius: 100%;
    }
</style>

<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("con.php");
// echo("$_POST[No_of_hrs_worked]");


// if (isset($_POST["search"])) {
$chefID = $_GET['Chef'];
// database search SQL code


$search1 = "SELECT * FROM Chef WHERE Chef_ID like '$chefID'";
// $search2 = "SELECT * FROM Chef WHERE SignatureDish like '$food_name'";


$result = mysqli_query($conn, $search1);
$queryResults = mysqli_num_rows($result);
if ($queryResults > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $a = $row["Chef_ID"];
        $b = $row["No_of_hrs_worked"];
        $c = $row["SignatureDish"];
        $d = $row["Years_worked"];
        $e=$row["Resturantid"];
    }
}?>
    <div class="data"></div>
        <img src="hum_photo.jpg" width="300px" height="300px"><br>
        <hr width="500px">
        <div class="text">
            <b>Chef ID:</b><br>
            <?php echo "<b style=\"color:blue\">" . $a ."</b>"; ?>
            <br><b>Number Of Hours Worked:</b><br>
            <?php echo "<b style=\"color:blue\">" . $b ."</b>"; ?>
            <br><b>Signature Dish:</b><br>
            <?php echo "<b style=\"color:blue\">" . $c ."</b>"; ?>
            <br><b>Years Worked:</b><br>
            <?php echo "<b style=\"color:blue\">" . $d ."</b>"; ?>
            <br><b>Restaurant ID:</b><br>
            <?php echo "<b style=\"color:blue\">" . $e ."</b>"; ?>
        </div>
        <br>
        <br>
        <button><a href="index.html" style="text-decoration: none;">
            Search Page
        </a></button>
    </div>
</body>

</html>