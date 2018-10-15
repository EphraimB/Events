<?php

session_start();

require_once 'config.php';

global $link;

$session_username = $_SESSION['username'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$theme = $_GET['theme'];


if($theme == "dark"){
  $toggleDark_query = "UPDATE users SET darkTheme=1 WHERE user_id='$session_user_id'";
  $toggleDark_result = mysqli_query($link, $toggleDark_query);
}

if($theme == "light"){
  $toggleLight_query = "UPDATE users SET darkTheme=0 WHERE user_id='$session_user_id'";
  $toggleLight_result = mysqli_query($link, $toggleLight_query);
}

if($toggleDark_result || $toggleLight_result){
    header("location: settings.php");
}

?>
