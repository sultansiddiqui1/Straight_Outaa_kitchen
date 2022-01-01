<?php
session_start();
$servername = "localhost";
$usr = "group15read_only";
$pass = "DRngFU";
$db = "group15";

$conn = new mysqli($servername, $usr, $pass, $db);
if ($conn) {
    echo "<script type='text/javascript'>alert('Connected Successfully')</script>";
} else {
    echo "<script type='text/javascript'>alert('Connection Error')</script>";
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    //echo "Inside loop";
    $uname = $_POST['user'];
    $pass = $_POST['pass'];

    $_SESSION['valid'] = true;
    $_SESSION['timeout'] = time();
    $_SESSION['user'] = '$uname';

    //echo $pass;
    $sql = "SELECT * FROM login WHERE username='$uname' AND password='$pass'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] === $uname && $row['password'] = $pass) {
            header("Location: ../main.html");
        }
        exit();
    } else {
        header("Location:index.php?error=Invalid Username or Password");
        exit();
    }
}
?>
