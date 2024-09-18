<?php
require_once 'User.php';
$user_id = User::login($_POST["login"], $_POST["password"]);
if (!empty($user_id)) {
    // Set a session variable to indicate that the loading page should be displayed
    $_SESSION['show_loading'] = true;
    header('location: welcome_action.php');
    exit;
} else {
    header('location: index.php?Err');
}
