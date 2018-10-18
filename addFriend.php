<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];
$friend_user_id = $_GET['friend_user_id'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$addFriend_query = "INSERT INTO friends(friend_id, user_id, status_id)
              VALUES ('$friend_user_id', '$session_user_id', 0)";
$addFriend_result = mysqli_query($link, $addFriend_query);

if($addFriend_result){
  header("location: findFriends.php");
}
?>
