<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$darkTheme_query = "SELECT darkTheme FROM users WHERE user_id='$session_user_id'";
$darkTheme_result = mysqli_query($link, $darkTheme_query);

$darkTheme = mysqli_fetch_array($darkTheme_result)[0];

$query="SELECT * FROM chat LEFT OUTER JOIN users ON chat.user_id=users.user_id WHERE DATE(time)=CURDATE() ORDER BY id ASC";
$result = mysqli_query($link, $query);

echo '<p class="font-weight-bold text-center">---Today---</p>';
while ($row = mysqli_fetch_array($result)) {
        $chat_user_id = $row['user_id'];
        $username = $row["username"];
        $text = $row["text"];
        $time = date('g:i A', strtotime($row["time"])); //outputs date as # #Hour#:#Minute#

        $emailQuery = "SELECT email FROM users WHERE username='$username'";
        $emailResult = mysqli_query($link, $emailQuery);

        $email = mysqli_fetch_array($emailResult)[0];

        $email_hash = md5(strtolower(trim($email)));

        if($chat_user_id == $session_user_id){
          if($darkTheme == 0){
            echo '
            <div class="message darker">
              <div>
                <img src="https://www.gravatar.com/avatar/'.$email_hash.'?d=mp&s=3500" alt="Avatar" class="right">
                <p class="text-right font-weight-bold">'.$username.'</p>
              </div>
              <p>'.$text.'</p>
              <span class="time-left">'.$time.'</span>
            </div>
            ';
          }

          else if($darkTheme == 1){
            echo '
            <div class="message darker bg-dark">
              <div>
                <img src="https://www.gravatar.com/avatar/'.$email_hash.'?d=mp&s=3500" alt="Avatar" class="right">
                <p class="text-right font-weight-bold">'.$username.'</p>
              </div>
              <p>'.$text.'</p>
              <span class="time-left">'.$time.'</span>
            </div>
            ';
          }
        }

        else{
          if($darkTheme == 0){
            echo '
            <div class="message">
              <div>
                <img src="https://www.gravatar.com/avatar/'.$email_hash.'?d=mp&s=500" alt="Avatar">
                <p class="font-weight-bold">'.$username.'</p>
              </div>
              <p>'.$text.'</p>
              <span class="time-right">'.$time.'</span>
            </div>
            ';
          }
          else if($darkTheme == 1){
            echo '
            <div class="message bg-secondary">
              <div>
                <img src="https://www.gravatar.com/avatar/'.$email_hash.'?d=mp&s=500" alt="Avatar">
                <p class="font-weight-bold">'.$username.'</p>
              </div>
              <p>'.$text.'</p>
              <span class="time-right">'.$time.'</span>
            </div>
            ';
          }
        }
    }
?>
