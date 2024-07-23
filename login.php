<?php
$errorMessage = '';
if (isset($_GET['Err'])) {
    $errorMessage = 'Login failed';
}

?>
<html>
<head><link rel="stylesheet" href="login_style.css"></head>
<body>
    <div style="color: red;"><?php echo $errorMessage; ?></div>
    <br>
    <form method="post" action="login_action.php">
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