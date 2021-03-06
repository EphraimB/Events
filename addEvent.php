<?php

session_start();

require_once 'config.php';


$session_username = $_SESSION['username'];

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

if(isset($_GET['logout'])) {
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

$query = "SELECT * FROM events, userEvents, users WHERE username='$session_username'";
$result = mysqli_query($link, $query);

$notifications_query = "SELECT * FROM notifications LEFT OUTER JOIN events ON notifications.event_id=events.event_id LEFT OUTER JOIN userevents ON notifications.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE notifications.user_id='$session_user_id' AND cleared=0";
$notifications_result = mysqli_query($link, $notifications_query);

$notificationsCount_query = "SELECT COUNT(*) FROM notifications WHERE user_id='$session_user_id' AND cleared=0";
$notificationsCount_result = mysqli_query($link, $notificationsCount_query);

$notifications = mysqli_fetch_array($notificationsCount_result)[0];

$darkTheme_query = "SELECT darkTheme FROM users WHERE user_id='$session_user_id'";
$darkTheme_result = mysqli_query($link, $darkTheme_query);

$darkTheme = mysqli_fetch_array($darkTheme_result)[0];
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
    <script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script>
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.css"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/baseline-event-black-18/1x/baseline_event_black_18dp.png">
  </head>
	<?php
	if($darkTheme == 0){
	?>
	<body>
	<?php
	}
	else if($darkTheme == 1){
	?>
	<body style="background-color: black; color: white">
	<?php
	}
	?>
    <div class="container">
			<?php
			if($darkTheme == 0){
			?>
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<?php
			}
			else if($darkTheme == 1){
			?>
				<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<?php
			}
			?>
        <span class="navbar-brand mb-0 h1 material-icons" style="font-size: 1.5rem;">event</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php">My Events</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="attending.php">Attending</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="pending.php">Pending</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="findFriends.php">Find Friends</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="calendar.php?month=<?php echo date('m', strtotime("now")); ?>&day=<?php echo date('d', strtotime("now")); ?>&year=<?php echo date('Y', strtotime("now")); ?>">Calendar</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="chat.php">Chat</a>
						</li>
          </ul>
					<hr class="d-block d-lg-none">
          <ul class="navbar-nav mr-right">
            <div class="dropdown">
							<?php
							if($darkTheme == 0){
							?>
								<a class="nav-item dropdown dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php
							}
							else if($darkTheme == 1){
							?>
								<a class="nav-item dropdown dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php
							}

							if(!isset($_SESSION['facebookPicture'])){
							?>
								<img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<?php echo $email_hash ?>?d=mp&s=30">&nbsp;<?php echo $_SESSION['username']; ?>
								<?php
								}

								if(isset($_SESSION['facebookPicture'])){
								?>
								<img class="align-middle circle-img" width="30" height="30" src="https://graph.facebook.com/<?php echo $_SESSION['facebookPicture'] ?>/picture">&nbsp;<?php echo $_SESSION['username']; ?>
								<?php
								}
								?>
							</a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<a class="dropdown-item" href="profile.php?user_id=<?php echo $session_user_id ?>"><i class="material-icons align-text-top">account_circle</i>&ensp;Profile</a>
								<a class="dropdown-item" href="settings.php"><i class="material-icons align-text-top">settings</i>&ensp;Settings</a>
                <a class="dropdown-item" href="index.php?logout=1">Logout</a>
              </div>
            </div>
						&emsp;
						<div class="dropdown">
							<?php
							if($notifications == 0){
								if($darkTheme == 0){
							?>
								<a class="nav-item dropdown text-dark material-icons" style="font-size: 1.5rem;" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications_none</a>
								<?php
								}
								else if($darkTheme == 1){
								?>
									<a class="nav-item dropdown text-white material-icons" style="font-size: 1.5rem;" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications_none</a>
								<?php
								}
								?>
							<div class="dropdown-menu dropdown-menu-right p-3" style="width: 300px" aria-labelledby="notificationsMenuLink">
								<p>No notifications.</p>
							</div>
							<?php
							}
							else{
								if($darkTheme == 0){
							?>
								<a class="nav-item dropdown text-dark material-icons" style="font-size: 1.5rem;" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications</a>
								<?php
								}
								else if($darkTheme == 1){
								?>
									<a class="nav-item dropdown text-white material-icons" style="font-size: 1.5rem;" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications</a>
								<?php
								}
								?>
							<div class="dropdown-menu dropdown-menu-right p-3" style="width: 300px" aria-labelledby="notificationsMenuLink">
								<?php
								while($notification = mysqli_fetch_array($notifications_result)){
									$event_name = $notification['title'];
									$invitedFrom = $notification['username'];

									echo '<p>You have a pending event named '.$event_name.' from '.$invitedFrom.'</p>';
								}
								?>
								<div class="text-right">
									<a href="clearNotifications.php" class="material-icons" style="font-size: 1.5rem;">clear_all</a>
								</div>
							</div>
							<?php
							}
							?>
						</div>
          </ul>
        </div>
      </nav>
      <br>
      <header>
        <h1 class="text-center">Add event</h1>
      </header>
      <br>
      <br>
      <main>
        <form action="server.php" method="post" enctype="multipart/form-data">
          <?php
            if(isset($_SESSION['addEvent_error'])){
              echo '<div class="alert alert-danger" role="alert">';
                echo $_SESSION['addEvent_error'];
              echo '</div>';
            }
          ?>
					<div class="form-group text-center">
						<label class="font-weight-bold">Banner image</label>
						<input type="file" class="form-control" id="bannerImage" name="bannerImage">
					</div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Title</label>
            <input type="text" class="form-control" name="title">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Description</label>
            <input type="text" class="form-control" name="description">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Location</label>
						<input type="text" id="location" class="form-control" name="location">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Start date &amp; time</label>
            <div class="form-row">
              <input type="date" class="form-control text-center col-6" name="startDate">
              <input type="time" class="form-control text-center col-6" name="startTime">
            </div>
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">End date &amp; time</label>
            <div class="form-row">
              <input type="date" class="form-control text-center col-6" name="endDate">
              <input type="time" class="form-control text-center col-6" name="endTime">
            </div>
          </div>
          <br>
          <div class="text-center">
            <button type="register" class="btn btn-primary" name="addEvent_button">Submit</button>
          </div>
        </form>
				<br>
      </main>
    </div>
      <script>
			//Google Maps API
			$(document).ready(function() {
   			google.maps.event.addDomListener(window, 'load', initialize);
			});

			function initialize() {
    		var input = document.getElementById('location');
    		var autocomplete = new google.maps.places.Autocomplete(input);
			}
      </script>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK-fy6hmPp1VEu8bSeKJoXkqWWgUO0dEo&libraries=places"></script>
  </body>
</html>
