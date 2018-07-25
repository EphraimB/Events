<?php
session_start();

$deselectedUser = $_GET['deselectedUser'];
$fromEvent_id = $_GET['fromEvent_id'];


if(($key = array_search($deselectedUser, $_SESSION['selectedUsers'])) !== false) {
  unset($_SESSION['selectedUsers'][$key]);
}

header("location: invite.php?event_id=$fromEvent_id");

?>
