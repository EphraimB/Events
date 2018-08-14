<?php
session_start();

$deselectedUser = $_GET['deselectedUser'];
$fromEvent_id = $_GET['fromEvent_id'];


if(($key = array_search($deselectedUser, array_column($_SESSION['selectedUsers'], 0))) !== false){
  $_SESSION['selectedUsers'] = array_values($_SESSION['selectedUsers']);
  unset($_SESSION['selectedUsers'][$key]);
}

header("location: invite.php?event_id=$fromEvent_id");

?>
