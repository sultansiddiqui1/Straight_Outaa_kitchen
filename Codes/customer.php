<html>

<head>
    <title>
        Customer Table
    </title>
</head>

<body>
<table border="2">
  <tr>
    <td>Customer ID</td>
    <td>Orders</td>
    <td>Address</td>
    <td>Number of Orders</td>
</tr>
<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("con2.php");
    // echo("$_POST[No_of_hrs_worked]");


    // if (isset($_POST["search"])) {
    $customer_id = $_GET['customer_id'];

    // database search SQL code
    $search = "SELECT * FROM Customer WHERE CustomerID like '$customer_id'";
    $result = mysqli_query($conn, $search);
    $queryResults = mysqli_num_rows($result);

    if ($queryResults > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
            <td>
            <a href='details_food.php?CustomerID=<?php echo $row["CustomerID"]; ?>' method='get'>
                <?php echo $row["CustomerID"]; ?>
        </a>
            </td>
            <td>
                <?php echo $row["Orders"]; ?>
            </td>
            <td>
                <?php echo $row["Address"]; ?>
            </td>
            <td>
                <?php echo $row["No_of_orders"]; ?>
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
