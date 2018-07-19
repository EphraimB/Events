<?php
session_start();

require_once 'config.php';

global $link;

$event_id = $_GET['event_id'];
$userEvents_id = $_GET['userEvents_id'];

$query = "DELETE FROM events WHERE event_id=$event_id";
$result = mysqli_query($link, $query);

if($result){
  $delete_userEvents_query = "DELETE FROM userEvents WHERE id=$userEvents_id";
  $delete_userEvents_result = mysqli_query($link, $delete_userEvents_query);

  if($delete_userEvents_result){
    header("location: index.php");

    mysqli_close($link);
  }
}

?>
