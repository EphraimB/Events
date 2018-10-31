<?php

session_start();

require_once 'config.php';

global $link;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

$session_username = $_SESSION['username'];

$fromEvent_id = $_GET['fromEvent_id'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$emailQuery = "SELECT email FROM users WHERE username='$session_username'";
$emailResult = mysqli_query($link, $emailQuery);

$email = mysqli_fetch_array($emailResult)[0];

$email_hash = md5(strtolower(trim($email)));

$event_query = "SELECT * FROM events WHERE event_id='$fromEvent_id'";
$event_result = mysqli_query($link, $event_query);

while($row = mysqli_fetch_array($event_result)){
  $title = $row['title'];
  $upcomingLocation = $row['location'];
  $upcomingStartDate = $row['startDate'];
  $upcomingStartDateFormatted = date("m/d/Y", strtotime($upcomingStartDate));
  $upcomingStartTimeFormatted = date("h:i A", strtotime($upcomingStartDate));
  $upcomingEndDate = $row['endDate'];
  $upcomingEndDateFormatted = date("m/d/Y", strtotime($upcomingEndDate));
  $upcomingEndTimeFormatted = date("h:i A", strtotime($upcomingEndDate));
}

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$to = $_GET['email'];
$subject = "Event invite";
$message = "
<div style='display: flex;'>
  <img src='https://www.gravatar.com/avatar/".$email_hash."?d=mp&s=500' width='100' height='100'>
  &emsp;
  <div>
    <h1>".$session_username." invited you to join</h1>
    <p>".$title."
  </div>
</div>
<br>
<br>
<b>When:</b>
<br>
".$upcomingStartDateFormatted." at ".$upcomingStartTimeFormatted."
<br>
<br>
<b>Where:</b>
<br>
".$upcomingLocation."
<div style='text-align: center;'>
  <a href='localhost/Events/register.php'>Sign up</a>
</div>
";

ini_set('SMTP', 'smtp.gmail.com');
//ini_set('SMTP', 'localhost');
ini_set('smtp_port', 587);
//ini_set('smtp_port', 25);
ini_set('auth_username', 'events.paay@gmail.com');
ini_set('auth_password', "paayevents");
ini_set('force_sender', 'events.paay@gmail.com');
ini_set('sendmail_from', 'events.paay@gmail.com');

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'events.paay@gmail.com';                 // SMTP username
    $mail->Password = 'paayevents';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('events.paay@gmail.com');
    $mail->addAddress($to);               // Name is optional

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    echo 'Message has been sent';
    header("location: index.php");
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>
