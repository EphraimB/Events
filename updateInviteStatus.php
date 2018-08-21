<?php
session_start();

require_once 'config.php';

global $link;

$action = $_GET['action'];
$session_user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'];

if($action == "Decline"){
  $query_decline = "UPDATE invite SET status_id=1 WHERE user_id='$session_user_id' AND event_id='$event_id'";
  $result_decline = mysqli_query($link, $query_decline);
}

if($action == "Accept"){
  $query_accept = "UPDATE invite SET status_id=2 WHERE user_id='$session_user_id' AND event_id='$event_id'";
  $result_accept = mysqli_query($link, $query_accept);
}

if($result_decline || $result_accept){
  $clearNotification_query = "UPDATE notifications SET cleared=1 WHERE user_id='$session_user_id' AND event_id='$event_id'";
  $clearNotification_result = mysqli_query($link, $clearNotification_query);

  if($clearNotification_query){
    header("location: index.php");
  }
}
?>
