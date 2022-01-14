<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="process.php" method="POST">
        <h2>LOGIN</h2>
        <?php if (isset($_GET['error'])) { ?>

            <p class="error"><?php echo $_GET['error']; ?></p>

        <?php } ?>
        <p></p>
        <label for="">Username:</label>
        <input type="text" name="user" required placeholder="Enter (Hint at GitHub)"><br>
        <label for="">Password:</label>
        <input type="password" name="pass" required placeholder="Enter (Hint at GitHub)"><br>
        <input type="Submit" id="btn" value="Log In" />
    </form>
</body>

</html>
?>
