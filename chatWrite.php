<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$text = $_GET['text'];

$query = "INSERT INTO chat (user_id, text, time)
      VALUES (\"$session_user_id\", \"$text\", now())";
$result = mysqli_query($link, $query);
?>
