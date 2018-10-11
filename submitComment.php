<?php
session_start();

require_once 'config.php';

global $link;

$comment = $_GET['commentField'];
$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'];
$userEvents_id = $_GET['userEvents_id'];
$invitedEvent = $_GET['invitedEvent'];


$query = "INSERT INTO comments(user_id, event_id, comment, dateTime_commented)
        VALUES ('$user_id', '$event_id', '$comment', now())";
$result = mysqli_query($link, $query);

if($result){
  header("location: moreInfo.php?event_id=$event_id&userEvents_id=$userEvents_id&invitedEvent=$invitedEvent");
}
?>
