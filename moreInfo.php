<?php

session_start();

require_once 'config.php';

global $link;


$event_id = $_GET['event_id'];
$userEvents_id = $_GET['userEvents_id'];
$invitedEvent = $_GET['invitedEvent'];

$session_username = $_SESSION['username'];


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

$pendingUsers_query = "SELECT * FROM invite LEFT OUTER JOIN users ON invite.user_id=users.user_id WHERE invite.status_id=0 AND invite.event_id='$event_id'";
$pendingUsers_result = mysqli_query($link, $pendingUsers_query);

$pendingUsersCount_query = "SELECT COUNT(*) FROM invite WHERE event_id='$event_id' AND status_id=0";
$pendingUsersCount_result = mysqli_query($link, $pendingUsersCount_query);

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
        <span class="navbar-brand mb-0 h1 material-icons" style="font-size: 1.5rem;">events</span>
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
								<a class="dropdown-item responsive-t" href="profile.php?user_id=<?php echo $session_user_id ?>"><i class="material-icons align-text-top responsive-t">account_circle</i>&ensp;Profile</a>
								<a class="dropdown-item responsive-t" href="settings.php"><i class="material-icons align-text-top responsive-t">settings</i>&ensp;Settings</a>
                <a class="dropdown-item responsive-t" href="index.php?logout=1">Logout</a>
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
					<?php
					if($darkTheme == 0){
					?>
					<div class="card mx-lg-0 mx-auto" style="width: 18rem;">
						<?php
					}
					else if($darkTheme == 1){
					?>
					<div class="card mx-lg-0 mx-auto bg-dark" style="width: 18rem;">
					<?php
					}
						ini_set("allow_url_fopen", 1);

	          $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($location).'&key=AIzaSyDK-fy6hmPp1VEu8bSeKJoXkqWWgUO0dEo');
	          $obj = json_decode($json, true);

	          $mapLatitude = $obj["results"][0]["geometry"]["location"]["lat"];
						$mapLongitude = $obj["results"][0]["geometry"]["location"]["lng"];
						echo '<img class="card-img-top" src="https://maps.googleapis.com/maps/api/staticmap?markers=color:red|'.$mapLatitude.','.$mapLongitude.'&zoom=15&size=300x300&key=AIzaSyDK-fy6hmPp1VEu8bSeKJoXkqWWgUO0dEo">';
						?>
						<div class="card-body">
          		<p class="text-center card-text"><i class="material-icons align-text-top">location_on</i> <?php echo '<a class="card-link" href="https://www.google.com/maps/search/?api=1&query='.urlencode($location).'">'.$location ?></a></p>
          		<p class="text-center card-text"><i class="material-icons align-text-top">access_time</i> <?php echo $startDateFormatted ?> at <?php echo $startTimeFormatted ?></p>
          		<p class="text-center card-text">to <?php echo $endDateFormatted ?> at <?php echo $endTimeFormatted ?></p>
						</div>
					</div>
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
					<?php
					}
					if($invitedEvent == "truebutpending"){
						echo '
						<div class="row justify-content-center">
							<div class="col-5 col-lg-2"><a class="btn btn-danger" href="updateInviteStatus.php?action=Decline&event_id='.$event_id.'">Decline</a></div>
							<div class="col-5 col-lg-2"><a class="btn btn-success" href="updateInviteStatus.php?action=Accept&event_id='.$event_id.'">Accept</a></div>
						</div>
						';
					}
				  ?>
					<br>
					<br>
					<h4 class="col font-weight-bold">Pending (<?php echo mysqli_fetch_array($pendingUsersCount_result)[0] ?>)</h4>
					<br>
					<?php
 				 	while($pendingUser = mysqli_fetch_array($pendingUsers_result)){
						$pendingUserId = $pendingUser['user_id'];
 					 	$pendingUsername = $pendingUser['username'];
 					 	$pendingUserEmail = $pendingUser['email'];
 					 	$pendingUserEmailHash = md5(strtolower(trim($pendingUserEmail)));

						if($darkTheme == 0){
						?>
						<a href="profile.php?user_id=<?php echo $pendingUserId ?>" style="color: black; text-decoration: none;">
						<div class="card bg-light m-2 attendee-card" style="display: inline-block;">

						<?php
						}
						else if($darkTheme == 1){
						?>
						<a href="profile.php?user_id=<?php echo $pendingUserId ?>" style="color: white; text-decoration: none;">
						<div class="card bg-dark m-2 attendee-card" style="display: inline-block;">
						<?php
						}
						?>
							 <img class="card-img-top circle-img p-3" src="https://www.gravatar.com/avatar/<?php echo $pendingUserEmailHash ?>?d=mp&s=300">
							 <div class="card-body">
								 <p class="card-text text-center"><?php echo $pendingUsername ?></p>
							 </div>
						</div>
						<?php
					}
					?>
					<br>
					<br>
					<h4 class="col font-weight-bold">Not going (<?php echo mysqli_fetch_array($declinedUsersCount_result)[0] ?>)</h4>
					<br>
					<?php
 				 	while($declinedUser = mysqli_fetch_array($declinedUsers_result)){
						$declinedUserId = $declinedUser['user_id'];
 					 	$declinedUsername = $declinedUser['username'];
 					 	$declinedUserEmail = $declinedUser['email'];
 					 	$declinedUserEmailHash = md5(strtolower(trim($declinedUserEmail)));

						if($darkTheme == 0){
						?>
						<a href="profile.php?user_id=<?php echo $declinedUserId ?>" style="color: black; text-decoration: none;">
						<div class="card bg-light m-2 attendee-card" style="display: inline-block;">

						<?php
						}
						else if($darkTheme == 1){
						?>
						<a href="profile.php?user_id=<?php echo $declinedUserId ?>" style="color: white; text-decoration: none;">
						<div class="card bg-dark m-2 attendee-card" style="display: inline-block;">
						<?php
						}
						?>
							 <img class="card-img-top circle-img p-3" src="https://www.gravatar.com/avatar/<?php echo $declinedUserEmailHash ?>?d=mp&s=300">
							 <div class="card-body">
								 <p class="card-text text-center"><?php echo $declinedUsername ?></p>
							 </div>
						</div>
						<?php
						}
					?>

          <?php
          }
         ?>
				 <br>
				 <br>
				 <h4 class="col font-weight-bold">Going (<?php echo mysqli_fetch_array($attendingUsersCount_result)[0] + 1 ?>)</h4>
				 <br>
				 <?php
				 while($hostUser = mysqli_fetch_array($hostUser_result)){
					 $hostUser_id = $hostUser['user_id'];
					 $hostUsername = $hostUser['username'];
					 $hostEmail = $hostUser['email'];
					 $hostEmailHash = md5(strtolower(trim($hostEmail)));

					 if($darkTheme == 0){
				 	 ?>
					 <a href="profile.php?user_id=<?php echo $hostUser_id ?>" style="color: black; text-decoration: none;">
				 		<div class="card bg-light m-2 attendee-card" style="display: inline-block;">

					<?php
					}
					else if($darkTheme == 1){
					?>
					<a href="profile.php?user_id=<?php echo $hostUser_id ?>" style="color: white; text-decoration: none;">
					<div class="card bg-dark m-2 attendee-card" style="display: inline-block;">
					<?php
					}
					?>
						<img class="card-img-top circle-img p-3" src="https://www.gravatar.com/avatar/<?php echo $hostEmailHash ?>?d=mp&s=300">
						<div class="card-body">
							<p class="card-text text-center"><?php echo $hostUsername ?></p>
						</div>
						<?php } ?>
					</div>
				</a>
				 <?php
				 while($attendingUser = mysqli_fetch_array($attendingUsers_result)){
					 $attendingUserId = $attendingUser['user_id'];
					 $attendingUsername = $attendingUser['username'];
					 $attendingUserEmail = $attendingUser['email'];
					 $attendingUserEmailHash = md5(strtolower(trim($attendingUserEmail)));

					 if($darkTheme == 0){
				 ?>
				 <a href="profile.php?user_id=<?php echo $attendingUserId ?>" style="color: black; text-decoration: none;">
				 	<div class="card bg-light m-2 attendee-card" style="display: inline-block;">
					<?php
					}
					else if($darkTheme == 1){
					?>
					<a href="profile.php?user_id=<?php echo $attendingUserId ?>" style="color: white; text-decoration: none;">
					<div class="card bg-dark m-2 attendee-card" style="display: inline-block;">
					<?php
					}
					?>
						 <img class="card-img-top circle-img p-3" src="https://www.gravatar.com/avatar/<?php echo $attendingUserEmailHash ?>?d=mp&s=300">
						 <div class="card-body">
							 <p class="card-text text-center"><?php echo $attendingUsername ?></p>
						 </div>
					</div>
				</a>
					 <?php
				 		}
						?>
						<br>
						<br>
						<br>
						<br>
						<?php
						$commentsCount_query = "SELECT COUNT(*) FROM comments WHERE event_id='$event_id'";
						$commentsCount_result = mysqli_query($link, $commentsCount_query);
						?>
						<form action="submitComment.php">
							<h3 class="text-center">Comments (<?php echo mysqli_fetch_array($commentsCount_result)[0] ?>)</h3>
							<input type="hidden" name="event_id" value="<?php echo $event_id ?>">
							<input type="hidden" name="userEvents_id" value="<?php echo $userEvents_id ?>">
							<input type="hidden" name="invitedEvent" value="<?php echo $invitedEvent ?>">
							<textarea class="col-12" name="commentField"></textarea>
							<br>
							<input class="btn btn-primary" type="submit">
						</form>
						<br>
					 <?php
					 $getComments_query = "SELECT * FROM comments LEFT OUTER JOIN users ON comments.user_id=users.user_id WHERE event_id='$event_id' ORDER BY dateTime_commented DESC";
					 $getComments_result = mysqli_query($link, $getComments_query);

					 date_default_timezone_set('US/Eastern');
					 if(mysqli_num_rows($getComments_result) > 0){
						 $commentNumber = 0;
						 	while($comment = mysqli_fetch_array($getComments_result)){
								$userComment = $comment['comment'];
								$username = $comment['username'];
								$datetime = $comment['dateTime_commented'];

								$now  = date('Y-m-d h:i:s');
								$datetime1 = new DateTime($datetime);
								$datetime2 = new DateTime($now);
								$interval = $datetime1->diff($datetime2);
								/*$hours = $interval->h;
								$hours = $hours + ($interval->days*24);*/

								$commentNumber++;

								if($darkTheme == 0){
								echo "
								<div class='card bg-light text-center' style='width: 18rem;'>
									<div class='card-header'>
										Comment #$commentNumber
									</div>
									<div class='card-body'>
										<p class='card-text text-left'>".$userComment."</p>
									</div>
									<div class='card-footer text-muted'>";
									if($interval->format('%a')=="0"){
										if($interval->format('%h')=="1"){
											echo "By ".$username." ".$interval->format('%h hour')." ago";
										}
										else{
											echo "By ".$username." ".$interval->format('%h hours')." ago";
										}
									}
									else{
										echo "By ".$username." ".$interval->format('%a days')." ago";
									}
									echo "</div>
								</div>
								<br>";
								}
								else if($darkTheme == 1){
									echo "
									<div class='card bg-dark text-center' style='width: 18rem;'>
										<div class='card-header'>
											Comment #$commentNumber
										</div>
										<div class='card-body'>
											<p class='card-text text-left'>".$userComment."</p>
										</div>
										<div class='card-footer text-muted'>";
										if($interval->format('%a')=="0"){
											if($interval->format('%h')=="1"){
												echo "By ".$username." ".$interval->format('%h hour')." ago";
											}
											else{
												echo "By ".$username." ".$interval->format('%h hours')." ago";
											}
										}
										else{
											echo "By ".$username." ".$interval->format('%a days')." ago";
										}
										echo "</div>
									</div>
									<br>";
								}
							}
					 }
					 ?>
      </main>
    </div>
  </body>
</html>
