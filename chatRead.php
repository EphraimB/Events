<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$query="SELECT * FROM chat LEFT OUTER JOIN users ON chat.user_id=users.user_id ORDER BY id ASC";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_array($result)) {
        $username = $row["username"];
        $text = $row["text"];
        $time = date('g:i A', strtotime($row["time"])); //outputs date as # #Hour#:#Minute#

        echo "<p>$time | $username: $text</p>\n";
    }
?>
