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

$notifications_query = "SELECT * FROM notifications LEFT OUTER JOIN events ON notifications.event_id=events.event_id LEFT OUTER JOIN userevents ON notifications.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE notifications.user_id='$session_user_id' AND cleared=0";
$notifications_result = mysqli_query($link, $notifications_query);

$notificationsCount_query = "SELECT COUNT(*) FROM notifications WHERE user_id='$session_user_id' AND cleared=0";
$notificationsCount_result = mysqli_query($link, $notificationsCount_query);

$notifications = mysqli_fetch_array($notificationsCount_result)[0];

$darkTheme_query = "SELECT darkTheme FROM users WHERE user_id='$session_user_id'";
$darkTheme_result = mysqli_query($link, $darkTheme_query);

$darkTheme = mysqli_fetch_array($darkTheme_result)[0];

$userProfile_query = "SELECT * FROM users WHERE username='$session_username'";
$userProfile_result = mysqli_query($link, $userProfile_query);

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
      <br>
      <header>
        <h1 class="text-center">Settings</h1>
      </header>
      <br>
      <main>
        <?php
        if($darkTheme == 0){
        ?>
        <div class="card mx-lg-3 mx-auto bg-light float-lg-left mr-3" style="width: 20rem;">
        <?php
        }

        else if($darkTheme == 1){
        ?>
        <div class="card mx-lg-3 mx-auto bg-dark float-lg-left mr-3" style="width: 20rem;">
          <?php
          }
          ?>
          <div class="card-header">
            <div class="card-title text-center">
              <h4>User profile</h4>
            </div>
          </div>
          <div class="card-body">
              <?php
              while($userProfile = mysqli_fetch_array($userProfile_result)){
                $username = $userProfile['username'];
                $email = $userProfile['email'];
                $birthday = $userProfile['birthday'];
                $birthdayFormatted = date("Y-m-d", strtotime($birthday));
                $address = $userProfile['address'];

              ?>
              <form action="server.php" method="post">
                <div class="form-group text-center">
                  <label class="font-weight-bold" for="username">Username</label>
                  <input tabindex="-1" id="username" class="form-control text-center" name="username" value="<?php echo $username ?>" readonly>
                </div>
                <div class="form-group text-center">
                  <label class="font-weight-bold" for="email">Email</label>
                  <input type="email" id="email" class="form-control text-center" name="email" value="<?php echo $email ?>">
                </div>
                <div class="form-group text-center">
                  <label class="font-weight-bold" for="birthday">Birthday</label>
                  <input type="date" id="birthday" class="form-control text-center" name="birthday" value="<?php echo $birthdayFormatted ?>">
                </div>
                <div class="form-group text-center">
                  <label class="font-weight-bold" for="address">Address</label>
                  <input id="address" class="form-control text-center" name="address" value="<?php echo $address ?>">
                </div>
                <div class="text-center">
                  <button type="submit" name="userProfile_btn" class="btn btn-primary">Save changes</button>
                </div>
              </form>
              <?php
              }
              ?>
          </div>
        </div>

        <?php
        if($darkTheme == 0){
        ?>
        <div class="card bg-light mx-lg-0 mx-auto" style="width: 20rem;">
        <?php
        }

        else if($darkTheme == 1){
        ?>
        <div class="card bg-dark mx-lg-0 mx-auto" style="width: 20rem;">
          <?php
          }
          ?>
          <div class="card-header">
            <div class="card-title text-center">
              <h4>Theme</h4>
            </div>
          </div>
          <div class="card-body">
            <form action="darkThemeToggle.php">
              <div class="form-group text-center">
                <label class="font-weight-bold" for="theme">Theme</label>
                <select class="form-control" name="theme">
                  <?php
                  if($darkTheme == 0){
                  ?>
                  <option value="light">Light</option>
                  <option value="dark">Dark</option>
                  <?php
                  }
                  else if($darkTheme == 1){
                  ?>
                  <option value="dark">Dark</option>
                  <option value="light">Light</option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <br>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
  </body>
  </html>
