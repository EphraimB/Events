<?php

session_start();

$fromEvent_id = $_GET['fromEvent_id'];

unset($_SESSION['exists']);

header("location: invite.php?event_id=$fromEvent_id");

?>
