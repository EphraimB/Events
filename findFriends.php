<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];

$emailQuery = "SELECT email FROM users WHERE username='$session_username'";
$emailResult = mysqli_query($link, $emailQuery);

$email = mysqli_fetch_array($emailResult)[0];

$email_hash = md5(strtolower(trim($email)));

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$invited_query = "SELECT * FROM invite WHERE user_id='$session_user_id' AND status_id=0";
$invited_result = mysqli_query($link, $invited_query);

$notifications_query = "SELECT * FROM notifications LEFT OUTER JOIN events ON notifications.event_id=events.event_id LEFT OUTER JOIN userevents ON notifications.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE notifications.user_id='$session_user_id' AND cleared=0";
$notifications_result = mysqli_query($link, $notifications_query);

$notificationsCount_query = "SELECT COUNT(*) FROM notifications WHERE user_id='$session_user_id' AND cleared=0";
$notificationsCount_result = mysqli_query($link, $notificationsCount_query);

$notifications = mysqli_fetch_array($notificationsCount_result)[0];

$darkTheme_query = "SELECT darkTheme FROM users WHERE user_id='$session_user_id'";
$darkTheme_result = mysqli_query($link, $darkTheme_query);

$darkTheme = mysqli_fetch_array($darkTheme_result)[0];

$findFriends_query = "SELECT * FROM users WHERE user_id <> '$session_user_id'";
$findFriends_result = mysqli_query($link, $findFriends_query);

$friendRequests_query = "SELECT * FROM friends LEFT OUTER JOIN users ON friends.user_id=users.user_id WHERE friend_id='$session_user_id' AND status_id=0";
$friendRequests_result = mysqli_query($link, $friendRequests_query);

$friendRequested_query = "SELECT * FROM friends WHERE friend_id='$session_user_id' OR user_id='$session_user_id'";
$friendRequested_result = mysqli_query($link, $friendRequested_query);

$requestedFriends_user_id_array = [];
$requestedFriends_friend_id_array = [];
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
        <span class="navbar-brand mb-0 h1 material-icons">event</span>
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
							<a class="nav-link active" href="findFriends.php">Find Friends <span class="sr-only">(current)</span></a>
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
								<img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<?php echo $email_hash ?>?s=30">&nbsp;<?php echo $_SESSION['username']; ?>
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
									<a class="nav-item dropdown text-dark material-icons" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications_none</a>
								<?php
								}
								else if($darkTheme == 1){
								?>
									<a class="nav-item dropdown text-white material-icons" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications_none</a>
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
									<a class="nav-item dropdown text-dark material-icons" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications</a>
							<?php
							}
							else if($darkTheme == 1){
							?>
								<a class="nav-item dropdown text-white material-icons" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications</a>
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
									<a href="clearNotifications.php" class="material-icons">clear_all</a>
								</div>
							</div>
							<?php
							}
							?>
						</div>
          </ul>
        </div>
      </nav>
      <?php
      if(isset($_SESSION['inviteSuccessful'])){
        echo '
        <div class="alert alert-success" role="alert">
          Successfully sent an invitation.
          <a href="clearSessionExists.php?redirectedFrom=index" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>';
      }

      ?>
      <br>
      <header>
        <h1 class="text-center">Find Friends</h1>
      </header>
      <br>
      <main>
        <?php
        if(mysqli_num_rows($friendRequests_result) > 0){
        ?>
        <h4 class="text-center">Respond to your friend requests</h4>
        <div class="list-group">
          <?php
          while($friendRequest = mysqli_fetch_array($friendRequests_result)){
            $friendRequest_id = $friendRequest['id'];
            $friendRequest_user_id = $friendRequest['user_id'];
            $friendRequest_username = $friendRequest['username'];
            $friendRequest_email = $friendRequest['email'];
            $friendRequest_email_hash = md5(strtolower(trim($friendRequest_email)));

            if($darkTheme == 0){
            ?>
            <li class="list-group-item">
            <?php
            }
            else if($darkTheme == 1){
            ?>
            <li class="list-group-item bg-dark">
            <?php
            }
            ?>
            <div class="row">
              <img class="align-middle col-auto" src="https://www.gravatar.com/avatar/<?php echo $friendRequest_email_hash ?>?s=150" width="50" height="50">
              &ensp;<p class="col"><?php echo $friendRequest_username ?></p>
              <a href="updateFriendRequest.php?requested_user_id=<?php echo $friendRequest_user_id ?>&action=confirm" class="btn btn-primary col-1">Confirm</a>
              <a href="updateFriendRequest.php?requested_user_id=<?php echo $friendRequest_user_id ?>&action=delete" class="btn btn-secondary col-2 ml-2">Delete Request</a>
            </div>
          <?php
          }
          ?>
        </div>
        <?php
        }
        ?>
          <br>
          <h4 class="text-center">People you may know</h4>
          <div class="list-group">
          <?php
          while($friendRequested = mysqli_fetch_array($friendRequested_result)){
            $friendRequested_user_id = $friendRequested['user_id'];
            $friendRequested_friend_id = $friendRequested['friend_id'];

            array_push($requestedFriends_user_id_array, $friendRequested_user_id);
            array_push($requestedFriends_friend_id_array, $friendRequested_friend_id);
          }

          while($friend = mysqli_fetch_array($findFriends_result)){
            $friend_user_id = $friend['user_id'];
            $friend_username = $friend['username'];
            $friend_email = $friend['email'];
            $friend_email_hash = md5(strtolower(trim($friend_email)));


            if(in_array($friend_user_id, $requestedFriends_friend_id_array) == 0 && in_array($friend_user_id, $requestedFriends_user_id_array) == 0){ //The or statement is breaking this if statement
            if($darkTheme == 0){
          ?>
          <li class="list-group-item">
          <?php
          }
          else if($darkTheme == 1){
          ?>
          <li class="list-group-item bg-dark">
          <?php
          }
          ?>
            <div class="row">
              <img class="align-middle col-auto" src="https://www.gravatar.com/avatar/<?php echo $friend_email_hash ?>?s=150" width="50" height="50">
              &ensp;<p class="col"><?php echo $friend_username ?></p>
              <a href="addFriend.php?friend_user_id=<?php echo $friend_user_id ?>" class="btn btn-primary col-2 mr-5">Add friend <i class="material-icons align-text-top">person_add</i></a>
            </div>
          </li>
          <?php
          }
          }
          ?>
        </div>
        <br>
      </main>
    </div>
  </body>
</html>
