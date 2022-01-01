<html>

<head>
    <title>
        Customer Details
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
    $CustomerID = $_GET['CustomerID'];
    // database search SQL code


    $search1 = "SELECT * FROM Customer WHERE CustomerID like '$CustomerID'";
    // $search2 = "SELECT * FROM Chef WHERE SignatureDish like '$food_name'";


    $result = mysqli_query($conn, $search1);
    $queryResults = mysqli_num_rows($result);
    if ($queryResults > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a = $row["CustomerID"];
            $b = $row["Orders"];
            $c = $row["Address"];
            $d = $row["No_of_orders"];
        }
    }

    // $result = mysqli_query($conn, $search2);
    // $queryResults = mysqli_num_rows($result);
    // if ($queryResults > 0) {
    //     // while ($row = mysqli_fetch_assoc($result)) {
    //         $ChefID=$_GET['Chef_ID'];
    //         $Expe=$_GET['Years_worked'];
    //     }
    // }


    // }
    ?>
    <div class="data">
        <img src="hum_photo.jpg" width="300px" height="300px"><br>
        <hr width="500px">
        <div class="text">
            <b>Customer ID(Phone Number):</b><br>
            <?php echo "<b style=\"color:blue\">" . $a ."</b>"; ?>
            <br><b>Food Ordered:</b><br>
            <?php echo "<b style=\"color:blue\">" . $b ."</b>"; ?>
            <br><b>Address:</b><br>
            <?php echo "<b style=\"color:blue\">" . $c ."</b>"; ?>
            <br><b>Number Of Orders:</b><br>
            <?php echo "<b style=\"color:blue\">" . $d ."</b>"; ?>
        </div>
        <br>
        <br>
        <button><a href="index.html" style="text-decoration: none;">
                Search Page
            </a></button>
    </div>
</body>

</html>