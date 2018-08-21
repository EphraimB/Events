<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];
$currentTheme = $_GET['currentTheme'];


if($currentTheme == "light"){
  $toggleDark_query = "UPDATE users SET darkTheme=1";
  $toggleDark_result = mysqli_query($link, $toggleDark_query);
}

if($currentTheme == "dark"){
  $toggleLight_query = "UPDATE users SET darkTheme=0";
  $toggleLight_result = mysqli_query($link, $toggleLight_query);
}

if($toggleDark_result || $toggleLight_result){
  header("location: index.php");
}

?>
