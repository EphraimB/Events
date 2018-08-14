<?php

session_start();

require_once 'config.php';

global $link;

$session_username = $_SESSION['username'];
$event_id = $_GET['event_id'];

foreach(array_column($_SESSION['selectedUsers'], 0) as $selectedUser){
  //echo $selectedUser;
  $user_id_query = "SELECT * FROM users WHERE username='$selectedUser'";
  $user_id_result = mysqli_query($link, $user_id_query);

  if($user_id_result){
    $selectedUser_id = mysqli_fetch_array($user_id_result)[0];

    $query = "INSERT INTO invite(user_id, event_id, status_id)
          VALUES ('$selectedUser_id', '$event_id', 0)";
    $result = mysqli_query($link, $query);

    if($result){
      $_SESSION['inviteSuccessful'] = 1;
      unset($_SESSION['selectedUsers']);
      header("location: index.php");
    }
  }
}

?>
