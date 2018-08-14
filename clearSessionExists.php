<?php

session_start();

$fromEvent_id = $_GET['fromEvent_id'];
$redirectedFrom = $_GET['redirectedFrom'];


if($redirectedFrom == "invite"){
  unset($_SESSION['exists']);
  header("location: invite.php?event_id=$fromEvent_id");
}

if($redirectedFrom == "index"){
  unset($_SESSION['inviteSuccessful']);
  header("location: index.php");
}

?>
