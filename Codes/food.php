<html>

<head>
    <title>
        Food Table
    </title>
</head>

<body>
<table border="2">
  <tr>
    <td>DishID</td>
    <td>Food</td>
    <td>Drinks</td>
    <td>Todaay's Special</td>
</tr>
<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("con2.php");
    // echo("$_POST[No_of_hrs_worked]");


    // if (isset($_POST["search"])) {
    $food_name = $_GET['food_name'];

    // database search SQL code
    $search = "SELECT * FROM Menu WHERE Food like '$food_name'";
    $result = mysqli_query($conn, $search);
    $queryResults = mysqli_num_rows($result);

    if ($queryResults > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // $Food=$row["Dishid"];
            ?>
            <tr>
            <td>
            <a href='details_food.php?Food=<?php echo $row["DishID"]; ?>' method='get'>
            <?php echo $row["DishID"]; ?>
            </a>

        </td>
            <td>
                <?php echo $row["Food"]; ?>
            </td>
            <td>
                <?php echo $row["Drinks"]; ?>
            </td>
            <td>
                <?php echo $row["TodaysSpecial"]; ?>
            </td>
        </tr>
            <?php
        }
    }
    else{
        echo "<script type='text/javascript'>alert('No Data Found');</script>";
    }
    // }
    ?>
 
</body>

</html>
