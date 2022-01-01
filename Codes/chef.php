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
        $chefID = $_GET['chef_id'];

        // database search SQL code
        $search = "SELECT * FROM Chef WHERE Chef_ID like '$chefID'";
        $result = mysqli_query($conn, $search);
        $queryResults = mysqli_num_rows($result);

        if ($queryResults > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // $Food=$row["Food"];
        ?>
                <tr>
                    <td>
                        <a href='details_food.php?Chef=<?php echo $row["Chef_ID"]; ?>' method='get'>
                            <?php echo $row["Chef_ID"]; ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $row["No_of_hrs_worked"]; ?>
                    </td>
                    <td>
                        <?php echo $row["SignatureDish"]; ?>
                    </td>
                    <td>
                        <?php echo $row["Years_worked"]; ?>
                    </td>
                    <td>
                        <?php echo $row["Resturantid"]; ?>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<script type='text/javascript'>alert('No Data Found');</script>";
        }
        // }
        ?>

</body>

</html>
