<?php
$errorMessage = '';
if (isset($_GET['Err'])) {
    $errorMessage = 'Login failed ';
}

?>
<html>

<head>
    <link rel="stylesheet" href="css/index_style.css">
    <title>Login</title>
</head>

<body>
    <div style="color: red;"><?php echo $errorMessage; ?></div>
    <br>
    <form method="post" action="index_action.php">
        <fieldset>
            <br>
            <div style="text-align: center;">
                Welcome, <span style="color: blue;">authenticate</span>
            </div>
            <br>
            <label style="display: inline-block; width: 130px; ">Login</label>
            <input type="text" name="login">
            <br>
            <label style="display: inline-block; width: 130px; ">Password</label>
            <input type="password" name="password">
            <br><br>
            <input style="background-color: DAE8FC;" type="submit" value="OK">
        </fieldset>
    </form>
</body>

</html>