<?php

session_start();

$selectedUser = $_GET['selectedUser'];
$fromEvent_id = $_GET['fromEvent_id'];

if(in_array($selectedUser, $_SESSION['selectedUsers'])){
  $_SESSION['exists'] = $selectedUser;
}
else{
  array_push($_SESSION['selectedUsers'], $selectedUser);
}

header("location: invite.php?event_id=$fromEvent_id");

?>
