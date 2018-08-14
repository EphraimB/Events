<?php

session_start();

$selectedUser = $_GET['selectedUser'];
$selectedUserEmail_hash = $_GET['selectedUserEmail_hash'];
$fromEvent_id = $_GET['fromEvent_id'];

if(in_array($selectedUser, array_column($_SESSION['selectedUsers'], 0))){
  $_SESSION['exists'] = $selectedUser;
}
else{
  array_push($_SESSION['selectedUsers'], [$selectedUser, $selectedUserEmail_hash]);
}

header("location: invite.php?event_id=$fromEvent_id");

?>
