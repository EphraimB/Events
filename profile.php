<?php

session_start();

require_once 'config.php';

global $link;


$session_username = $_SESSION['username'];
$profileUserId = $_GET['user_id'];

$emailQuery = "SELECT email FROM users WHERE username='$session_username'";
$emailResult = mysqli_query($link, $emailQuery);

$email = mysqli_fetch_array($emailResult)[0];

$email_hash = md5(strtolower(trim($email)));

$profileEmailQuery = "SELECT email FROM users WHERE user_id='$profileUserId'";
$profileEmailResult = mysqli_query($link, $profileEmailQuery);

$profileEmail = mysqli_fetch_array($profileEmailResult)[0];

$profileEmail_hash = md5(strtolower(trim($profileEmail)));

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$notifications_query = "SELECT * FROM notifications LEFT OUTER JOIN events ON notifications.event_id=events.event_id LEFT OUTER JOIN userevents ON notifications.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE notifications.user_id='$session_user_id' AND cleared=0";
$notifications_result = mysqli_query($link, $notifications_query);

$notificationsCount_query = "SELECT COUNT(*) FROM notifications WHERE user_id='$session_user_id' AND cleared=0";
$notificationsCount_result = mysqli_query($link, $notificationsCount_query);

$notifications = mysqli_fetch_array($notificationsCount_result)[0];

$darkTheme_query = "SELECT darkTheme FROM users WHERE user_id='$session_user_id'";
$darkTheme_result = mysqli_query($link, $darkTheme_query);

$darkTheme = mysqli_fetch_array($darkTheme_result)[0];

$userProfile_query = "SELECT * FROM users WHERE user_id='$profileUserId'";
$userProfile_result = mysqli_query($link, $userProfile_query);

$friends_query = "SELECT * FROM friends LEFT OUTER JOIN users ON friends.friend_id=users.user_id WHERE friends.user_id='$profileUserId' OR friends.friend_id='$profileUserId'";
$friends_result = mysqli_query($link, $friends_query);

$friendsOtherWay_query = "SELECT * FROM friends LEFT OUTER JOIN users ON friends.user_id=users.user_id WHERE friends.friend_id='$profileUserId'";
$friendsOtherWay_result = mysqli_query($link, $friendsOtherWay_query);

$isFriend_query = "SELECT * FROM friends WHERE user_id='$session_user_id' AND friend_id='$profileUserId' OR friend_id='$session_user_id' AND user_id='$profileUserId'";
$isFriend_result = mysqli_query($link, $isFriend_query);
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
            <li class="nav-item active">
              <a class="nav-link" href="index.php">My Events <span class="sr-only">(current)</span></a>
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
        <h1 class="text-center">User Profile</h1>
      </header>
      <br>
      <main>
        <?php
        if($darkTheme == 0){
        ?>
        <div class="card">
        <?php
        }
        else if($darkTheme == 1){
        ?>
        <div class="card bg-dark">
        <?php
        }

        while($info = mysqli_fetch_array($userProfile_result)){
          $username = $info['username'];
          $address = $info['address'];
          $birthday = $info['birthday'];
          $birthdayFormatted = date('F d, Y', strtotime($birthday));
          $info_email = $info['email'];
          $memberSince = $info['createdAt'];
          $memberSinceFormatted = date('F d, Y', strtotime($memberSince));
        ?>
          <div class="card-header">
            <div class="row">
              <img class="circle-img col-3 d-lg-none" width="50" height="50" src="https://www.gravatar.com/avatar/<?php echo $profileEmail_hash ?>?s=500">
              <h3 class="card-title col-9"><?php echo $username ?></h3>
            </div>
          </div>
          <div class="card-body">
            <img class="align-middle float-right d-none d-lg-block" width="200" height="200" src="https://www.gravatar.com/avatar/<?php echo $profileEmail_hash ?>?s=500">
            <div class="row">
              <?php
              if(mysqli_num_rows($isFriend_result) || $profileUserId == $session_user_id){
              ?>
              <div class="col-12 col-lg-4">
                <p class="card-text font-weight-bold m-0">Address:</p>
                <a class="card-link" href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($address) ?>"><p class="card-text"><?php echo $address ?></p></a>
              </div>
              <br>
              <br>
              <br>
              <br>
              <div class="col-12 col-lg-4">
                <p class="card-text font-weight-bold m-0">Birthday:</p>
                <p class="card-text"><?php echo $birthdayFormatted ?></p>
              </div>
              <br>
              <br>
              <br>
              <div class="col-12 col-lg-4">
                <p class="card-text font-weight-bold m-0">Email:</p>
                <p class="card-text"><?php echo $info_email ?></p>
              </div>
              <br>
              <br>
              <br>
              <?php
              }
              ?>
              <div class="col-12 col-lg-4">
                <p class="card-text font-weight-bold m-0">Events member since:</p>
                <p class="card-text"><?php echo $memberSinceFormatted ?></p>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
        </div>
      <br>
      <?php
      if($darkTheme == 0){
      ?>
      <div class="card">
      <?php
      }
      else if($darkTheme == 1){
      ?>
      <div class="card bg-dark">
      <?php
      }
      ?>
        <div class="card-header">
          <h3 class="card-title">Friends</h3>
        </div>
        <div class="card-body">
          <div class="list-group">
            <?php
            while($friend = mysqli_fetch_array($friends_result)){
              $friend_user_id = $friend['friend_id'];
              $friend_username = $friend['username'];
              $friend_email = $friend['email'];
              $friend_email_hash = md5(strtolower(trim($friend_email)));


              if($friend_user_id == $profileUserId){
                while($friendOtherWay = mysqli_fetch_array($friendsOtherWay_result)){
                  $friendOtherWay_user_id = $friendOtherWay['user_id'];
                  $friendOtherWay_username = $friendOtherWay['username'];
                  $friendOtherWay_email = $friendOtherWay['email'];
                  $friendOtherWay_email_hash = md5(strtolower(trim($friendOtherWay_email)));


                  if($darkTheme == 0){
                  ?>
                    <a href="profile.php?user_id=<?php echo $friendOtherWay_user_id ?>" style="color: black; text-decoration: none;">
                    <li class="list-group-item">
                  <?php
                  }
                else if($darkTheme == 1){
                ?>
                  <a href="profile.php?user_id=<?php echo $friendOtherWay_user_id ?>" style="color: black;">
                  <li class="list-group-item bg-dark">
                <?php
                }
                ?>
                <div class="row">
                  <img class="align-middle col-auto" src="https://www.gravatar.com/avatar/<?php echo $friendOtherWay_email_hash ?>?s=150" width="50" height="50">
                  &ensp;<p class="col"><?php echo $friendOtherWay_username ?></p>
                </div>
                </li>
                </a>
                <?php
                }
              }
              else{
              if($darkTheme == 0){
              ?>
                <a href="profile.php?user_id=<?php echo $friend_user_id ?>" style="color: black;">
                <li class="list-group-item">
              <?php
              }
            else if($darkTheme == 1){
            ?>
              <a href="profile.php?user_id=<?php echo $friend_user_id ?>" style="color: black;">
              <li class="list-group-item bg-dark">
            <?php
            }
            ?>
            <div class="row">
              <img class="align-middle col-auto" src="https://www.gravatar.com/avatar/<?php echo $friend_email_hash ?>?s=150" width="50" height="50">
              &ensp;<p class="col"><?php echo $friend_username ?></p>
            </div>
            </li>
            <?php
            }
            }
            ?>
          </div>
        </div>
      </div>
      </main>
    </div>
  </body>
</html>
