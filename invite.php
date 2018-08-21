<?php

session_start();

require_once 'config.php';

global $link;


$event_id = $_GET['event_id'];

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

$allUsersEmailQuery = "SELECT email FROM users";
$allUsersEmailResult = mysqli_query($link, $allUsersEmailQuery);

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$query = "SELECT * FROM events WHERE event_id='$event_id'";
$result = mysqli_query($link, $query);

$allUsers_query = "SELECT username FROM users";
$allUsers_result = mysqli_query($link, $allUsers_query);

if(!isset($_SESSION['selectedUsers'])){
  $_SESSION['selectedUsers'] = [];
}

$notifications_query = "SELECT * FROM notifications LEFT OUTER JOIN events ON notifications.event_id=events.event_id LEFT OUTER JOIN userevents ON notifications.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE notifications.user_id='$session_user_id' AND cleared=0";
$notifications_result = mysqli_query($link, $notifications_query);

$notificationsCount_query = "SELECT COUNT(*) FROM notifications WHERE user_id='$session_user_id' AND cleared=0";
$notificationsCount_result = mysqli_query($link, $notificationsCount_query);

$notifications = mysqli_fetch_array($notificationsCount_result)[0];
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
							<a class="nav-link" href="index.php">My Events</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="attending.php">Attending</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="pending.php">Pending</a>
						</li>
          </ul>
					<hr class="d-block d-lg-none">
          <ul class="navbar-nav mr-right">
            <div class="dropdown">
              <a class="nav-item dropdown dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<?php echo $email_hash ?>?s=30">&nbsp;<?php echo $_SESSION['username']; ?></a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="index.php?logout=1">Logout</a>
              </div>
            </div>
						&emsp;
						<div class="dropdown">
							<?php
							if($notifications == 0){
							?>
							<a class="nav-item dropdown text-dark material-icons" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications_none</a>
							<div class="dropdown-menu dropdown-menu-right p-3" style="width: 300px" aria-labelledby="notificationsMenuLink">
								<p>No notifications.</p>
							</div>
							<?php
							}
							else{
							?>
							<a class="nav-item dropdown text-dark material-icons" href="#" role="button" id="notificationsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">notifications</a>
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
      if(isset($_SESSION['exists'])){
        echo '
        <div class="alert alert-danger" role="alert">
          '.$_SESSION["exists"].' already exists.
          <a href="clearSessionExists.php?redirectedFrom=invite&fromEvent_id='.$event_id.'" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>';
        }
        ?>
      <br>
      <header>
        <h1 class="text-center">Invite</h1>
      </header>
      <main>
        <br>
        <br>
        <div class="row justify-content-center">
          <input type="search" class="col-10 col-lg-6" id="search" placeholder="Search..." onkeyup="filterFunction()">
        </div>
        <div class="list-group" id="listGroup">
        <br>
        <br>
          <?php
					$invited_query = "SELECT * FROM invite LEFT OUTER JOIN users ON invite.user_id=users.user_id WHERE event_id='$event_id'";
					$invited_result = mysqli_query($link, $invited_query);

          while($user = mysqli_fetch_array($allUsers_result)[0]){
            $allUsersEmail = mysqli_fetch_array($allUsersEmailResult)[0];

            if($user != $session_username && $allUsersEmail != $email && $user != mysqli_fetch_array($invited_result)['username']){
              $allUsersEmail_hash = md5(strtolower(trim($allUsersEmail)));
          ?>
              <a class="list-group-item list-group-item-action text-center" href="selectUsers.php?selectedUser=<?php echo $user ?>&selectedUserEmail_hash=<?php echo $allUsersEmail_hash ?>&fromEvent_id=<?php echo $event_id ?>"><img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<?php echo $allUsersEmail_hash ?>?s=30">&emsp;<span><?php echo $user ?></span></a>
          <?php
          }
        }
        ?>
        </div>
        <br>
        <br>

        <?php
        if(isset($_SESSION['selectedUsers'])){
          if(count($_SESSION['selectedUsers']) > 0){
            foreach($_SESSION['selectedUsers'] as $selectedUser){
              echo '
              <div class="card" style="width: 10rem; display: inline-block;">
                <a href="deselectUsers.php?deselectedUser='.$selectedUser[0].'&fromEvent_id='.$event_id.'" class="close" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </a>
                  <img class="card-img-top" src="https://www.gravatar.com/avatar/'.$selectedUser[1].'?s=300">
                  <div class="card-body">
                    <p class="card-text text-center">'.$selectedUser[0].'</p>
                  </div>
                </div>';
              }
              echo '
              <br>
              <br>
              <div class="text-center">
                <a href="inviteSelected.php?event_id='.$event_id.'" class="btn btn-primary">Invite</a>
              </div>
              ';
            }
          }

          ?>
        </main>
      </div>

    <script src="js/script.js"></script>
  </body>
  </html>
