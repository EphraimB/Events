<?php

session_start();

require_once 'config.php';

global $link;

$redirectedFrom = $_GET['redirectedfrom'];

$session_username = $_SESSION['username'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$currentTheme = $_GET['currentTheme'];

$event_id = $_GET['event_id'];
$userEvents_id = $_GET['userEvents_id'];
$invitedEvent = $_GET['invitedEvent'];


if($currentTheme == "light"){
  $toggleDark_query = "UPDATE users SET darkTheme=1 WHERE user_id='$session_user_id'";
  $toggleDark_result = mysqli_query($link, $toggleDark_query);
}

if($currentTheme == "dark"){
  $toggleLight_query = "UPDATE users SET darkTheme=0 WHERE user_id='$session_user_id'";
  $toggleLight_result = mysqli_query($link, $toggleLight_query);
}

if($toggleDark_result || $toggleLight_result){
  if($redirectedFrom == "index"){
    header("location: index.php");
  }

  else if($redirectedFrom == "attending"){
    header("location: attending.php");
  }

  else if($redirectedFrom == "pending"){
    header("location: pending.php");
  }

  else if($redirectedFrom == "moreInfo"){
    header("location: moreInfo.php?event_id=$event_id&userEvents_id=$userEvents_id&invitedEvent=$invitedEvent");
  }

  else if($redirectedFrom == "addEvent"){
    header("location: addEvent.php");
  }

  else if($redirectedFrom == "invite"){
    header("location: invite.php?event_id=$event_id");
  }

  else if($redirectedFrom == "updateEvent"){
    header("location: updateEvent.php?event_id=$event_id");
  }
}

?>
