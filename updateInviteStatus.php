<?php
session_start();

require_once 'config.php';

global $link;

$action = $_GET['action'];

if($action == "Decline"){
  $query_decline = "UPDATE invite SET status_id=1";
  $result_decline = mysqli_query($link, $query_decline);
}

if($action == "Accept"){
  $query_accept = "UPDATE invite SET status_id=2";
  $result_accept = mysqli_query($link, $query_accept);
}

if($result_decline || $result_accept){
  header("location: index.php");
}
?>
