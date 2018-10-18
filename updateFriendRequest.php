<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];
$requested_user_id = $_GET['requested_user_id'];
$action = $_GET['action'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

if($action == "confirm"){
  $updateStatus_query = "UPDATE friends SET status_id=1 WHERE friend_id='$session_user_id' AND user_id='$requested_user_id'";
  $updateStatus_result = mysqli_query($link, $updateStatus_query);
}

else if($action == "delete"){
  $deleteRequest_query = "DELETE FROM friends WHERE friend_id='$session_user_id' AND user_id='$requested_user_id'";
  $deleteRequest_result = mysqli_query($link, $deleteRequest_query);
}

if($updateStatus_result || $deleteRequest_result){
  header("location: findFriends.php");
}
?>
