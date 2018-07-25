<?php

session_start();

$selectedUser = $_GET['selectedUser'];
$fromEvent_id = $_GET['fromEvent_id'];


array_push($_SESSION['selectedUsers'], $selectedUser);

header("location: invite.php?event_id=$fromEvent_id");

?>
