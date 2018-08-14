<?php

session_start();

require_once 'config.php';

global $link;


$event_id = $_GET['event_id'];
$invitedEvent = $_GET['invitedEvent'];

$session_username = $_SESSION['username'];


if (isset($_GET['logout'])) {
	session_destroy();
	unset($session_username);
	header("location: login.php");
}

if(!isset($session_username) || empty($session_username)){
  header("location: login.php");
}

$emailQuery = "SELECT email FROM users WHERE username='$session_username'";
$emailResult = mysqli_query($link, $emailQuery);

$email = mysqli_fetch_array($emailResult)[0];

$email_hash = md5(strtolower(trim($email)));

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$query = "SELECT * FROM events WHERE event_id='$event_id'";
$result = mysqli_query($link, $query);

$attendingUsers_query = "SELECT * FROM invite LEFT OUTER JOIN users ON invite.user_id=users.user_id WHERE invite.status_id=2 AND invite.event_id='$event_id'";
$attendingUsers_result = mysqli_query($link, $attendingUsers_query);

$hostUser_query = "SELECT * FROM userevents LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE userevents.event_id='$event_id'";
$hostUser_result = mysqli_query($link, $hostUser_query);

$attendingUsersCount_query = "SELECT COUNT(*) FROM invite WHERE event_id='$event_id' AND status_id=2";
$attendingUsersCount_result = mysqli_query($link, $attendingUsersCount_query);

$declinedUsers_query = "SELECT * FROM invite LEFT OUTER JOIN users ON invite.user_id=users.user_id WHERE invite.status_id=1 AND invite.event_id='$event_id'";
$declinedUsers_result = mysqli_query($link, $declinedUsers_query);

$declinedUsersCount_query = "SELECT COUNT(*) FROM invite WHERE event_id='$event_id' AND status_id=1";
$declinedUsersCount_result = mysqli_query($link, $declinedUsersCount_query);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/baseline_event_black_18dp.png">
  </head>
  <body>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <span class="navbar-brand mb-0 h1"><img src="img/baseline_event_black_18dp.png"></span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
          </ul>
          <ul class="navbar-nav mr-right">
            <div class="dropdown">
              <a class="nav-item dropdown dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<?php echo $email_hash ?>?s=30">&nbsp;<?php echo $_SESSION['username']; ?></a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="index.php?logout=1">Logout</a>
              </div>
            </div>
          </ul>
        </div>
      </nav>
      <br>
      <header>
        <h1 class="text-center">More info</h1>
      </header>
      <main>
        <?php
        while($row = mysqli_fetch_array($result)){
          $title = $row['title'];
          $description = $row['description'];
          $location = $row['location'];
          $startDate = $row['startDate'];
          $startDateFormatted = date("m/d/Y", strtotime($startDate));
          $startTimeFormatted = date("h:i A", strtotime($startDate));
          $endDate = $row['endDate'];
          $endDateFormatted = date("m/d/Y", strtotime($endDate));
          $endTimeFormatted = date("h:i A", strtotime($endDate));
          ?>

          <br>
          <br>
          <h3 class="text-center"><?php echo $title ?></h3>
          <p class="text-center"><?php echo $description ?></p>
          <p class="text-center">Located at <?php echo $location ?></p>
          <p class="text-center">Starts at <?php echo $startDateFormatted ?> at <?php echo $startTimeFormatted ?></p>
          <p class="text-center">Ends at <?php echo $endDateFormatted ?> at <?php echo $endTimeFormatted ?></p>
          <br>
          <br>
          <br>
          <br>
					<style>
					 @media only screen and (max-width: 991px){
						 .attendee-card{
							 width: 7rem;
						 }
					 }
					 @media only screen and (min-width: 992px){
						 .attendee-card{
							 width: 10rem;
						 }
					 }
				 </style>
					<?php
					if($invitedEvent == "false"){
					?>
          <div class="row justify-content-center">
            <div class="col-3 col-lg-2"><a href="updateEvent.php?event_id=<?php echo $event_id ?>" class="btn btn-warning material-icons">edit</a></div>
            <div class="col-3 col-lg-2"><a href="deleteEvent.php?event_id=<?php echo $event_id ?>&userEvents_id=<?php echo $userEvents_id ?>" class="btn btn-danger material-icons">delete</a></div>
						<div class="col-3 col-lg-2"><a href="invite.php?event_id=<?php echo $event_id ?>" class="btn btn-primary material-icons">mail</a></div>
          </div>
					<br>
					<br>
					<h4 class="col font-weight-bold">Declined (<?php echo mysqli_fetch_array($declinedUsersCount_result)[0] ?>)</h4>
					<br>
					<?php
 				 	while($declinedUser = mysqli_fetch_array($declinedUsers_result)){
 					 	$declinedUsername = $declinedUser['username'];
 					 	$declinedUserEmail = $declinedUser['email'];
 					 	$declinedUserEmailHash = md5(strtolower(trim($declinedUserEmail)));
						?>
						<div class="card bg-light m-2 attendee-card" style="display: inline-block;">
							 <img class="card-img-top circle-img p-3" src="https://www.gravatar.com/avatar/<?php echo $declinedUserEmailHash ?>?s=300">
							 <div class="card-body">
								 <p class="card-text text-center"><?php echo $declinedUsername ?></p>
							 </div>
						</div>
						<?php
						}
					}
					?>

          <?php
          }
         ?>
				 <br>
				 <br>
				 <h4 class="col font-weight-bold">Attendees (<?php echo mysqli_fetch_array($attendingUsersCount_result)[0] + 1 ?>)</h4>
				 <br>
				 <div class="card bg-light m-2 attendee-card" style="display: inline-block;">
					 <?php
					 while($hostUser = mysqli_fetch_array($hostUser_result)){
						 $hostUsername = $hostUser['username'];
						 $hostEmail = $hostUser['email'];
						 $hostEmailHash = md5(strtolower(trim($hostEmail)));
					 ?>
						<img class="card-img-top circle-img p-3" src="https://www.gravatar.com/avatar/<?php echo $hostEmailHash ?>?s=300">
						<div class="card-body">
							<p class="card-text text-center"><?php echo $hostUsername ?></p>
						</div>
						<?php } ?>
					</div>
				 <?php
				 while($attendingUser = mysqli_fetch_array($attendingUsers_result)){
					 $attendingUsername = $attendingUser['username'];
					 $attendingUserEmail = $attendingUser['email'];
					 $attendingUserEmailHash = md5(strtolower(trim($attendingUserEmail)));

				 ?>
				 	<div class="card bg-light m-2 attendee-card" style="display: inline-block;">
						 <img class="card-img-top circle-img p-3" src="https://www.gravatar.com/avatar/<?php echo $attendingUserEmailHash ?>?s=300">
						 <div class="card-body">
							 <p class="card-text text-center"><?php echo $attendingUsername ?></p>
						 </div>
					</div>
					 <?php
				 		}
						?>
      </main>
    </div>
  </body>
</html>
