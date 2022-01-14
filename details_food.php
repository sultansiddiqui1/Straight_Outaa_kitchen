<html>

<head>
    <title>
        Food Details
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
</style>

<body>
    <?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("con.php");
    // echo("$_POST[No_of_hrs_worked]");


    // if (isset($_POST["search"])) {
    $food_name = $_GET['Food'];
    // database search SQL code


    $search1 = "SELECT * FROM Menu WHERE DishID=$food_name";
    // $search2 = "SELECT * FROM Chef WHERE SignatureDish like '$food_name'";


    $result = mysqli_query($conn, $search1);
    $queryResults = mysqli_num_rows($result);
    if ($queryResults > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a = $row["Food"];
            echo ".$a.";
            $b = $row["DishID"];
            echo ".$b.";
            $c = $row["Drinks"];
            echo ".$c.";
            $d = $row["TodaysSpecial"];
            echo ".$d.";
            
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
        <img src="photo.jpg" width="300px" height="300px"><br>
        <hr width="500px">
        <div class="text">
            <b>Name:</b>
            <?php echo "<b style=\"color:blue\">" . $a ."</b>"; ?>
            <br><b>Food ID:</b>
            <?php echo "<b style=\"color:blue\">" . $b . "</b>"; ?>
            <br><b>Drinks With It:</b>
            <?php echo "<b style=\"color:blue\">" . $c . "</b>" ?>
            <br><b>Today's Special:</b>
            <?php echo "<b style=\"color:blue\">" . $d . "</b>" ?>
            <!-- <br><b>ID of Special Chef for this:</b> -->
            <!-- <?php echo "<b style=\"color:blue\">" . $ChefID . "</b>" ?>
            <br><b>Experience of Chef(Years):</b>
            <?php echo "<b style=\"color:blue\">" . $Expe . "</b>" ?>    -->
        </div>
        <br>
        <br>
        <button><a href="index.html" style="text-decoration: none;">
                Search Page
            </a></button>
    </div>
</body>

</html>