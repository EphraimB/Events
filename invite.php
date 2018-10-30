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

$user_id_query = "SELECT * FROM users WHERE username='$session_username'";
$user_id_result = mysqli_query($link, $user_id_query);

$invitedUsers = [];
$usersFriends = [];

$user_id_invited_query = "SELECT * FROM invite LEFT OUTER JOIN users ON invite.user_id=users.user_id WHERE invite.event_id='$event_id' AND invite.status_id=2";
$user_id_invited_result = mysqli_query($link, $user_id_invited_query);

$_SESSION['user_id'] = mysqli_fetch_array($user_id_result)[0];
$session_user_id = $_SESSION['user_id'];

$query = "SELECT * FROM events WHERE event_id='$event_id'";
$result = mysqli_query($link, $query);

$allUsers_query = "SELECT * FROM users WHERE user_id<>'$session_user_id'";
$allUsers_result = mysqli_query($link, $allUsers_query);

$allUsersEmailQuery = "SELECT email FROM users WHERE user_id<>'$session_user_id'";
$allUsersEmailResult = mysqli_query($link, $allUsersEmailQuery);

$allFriends_query = "SELECT * FROM friends LEFT OUTER JOIN users ON friends.friend_id=users.user_id WHERE friends.user_id='$session_user_id'";
$allFriends_result = mysqli_query($link, $allUsers_query);

$allFriendsOtherWay_query = "SELECT * FROM friends LEFT OUTER JOIN users ON friends.user_id=users.user_id WHERE friends.friend_id='$session_user_id'";
$allFriendsOtherWay_result = mysqli_query($link, $allFriendsOtherWay_query);

if(!isset($_SESSION['selectedUsers'])){
  $_SESSION['selectedUsers'] = [];
}

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
					while($friends = mysqli_fetch_array($allFriends_result)['username']){
						array_push($usersFriends, $friends);
					}

					/*while($friendsOtherWay = mysqli_fetch_array($allFriendsOtherWay_result)['username']){
						array_push($usersFriends, $friendsOtherWay);
					}*/
					var_dump($usersFriends);

					while($invited = mysqli_fetch_array($user_id_invited_result)['username']){
						array_push($invitedUsers, $invited);
					}

					while($user = mysqli_fetch_array($allUsers_result)){
						$allUsersUsername = $user['username'];
            $allUsersEmail = mysqli_fetch_array($allUsersEmailResult)[0];

            if(in_array($allUsersUsername, $invitedUsers) == 0){
              $allUsersEmail_hash = md5(strtolower(trim($allUsersEmail)));

							if(in_array($allUsersUsername, $usersFriends) == 1){
								if($darkTheme == 0){
          			?>
              		<a class="selectedUser list-group-item bg-light list-group-item-action text-center" href="selectUsers.php?selectedUser=<?php echo $allUsersUsername ?>&selectedUserEmail_hash=<?php echo $allUsersEmail_hash ?>&fromEvent_id=<?php echo $event_id ?>">
								<?php
								}
								else if($darkTheme == 1){
								?>
									<a class="selectedUser list-group-item bg-dark list-group-item-action text-center" href="selectUsers.php?selectedUser=<?php echo $allUsersUsername ?>&selectedUserEmail_hash=<?php echo $allUsersEmail_hash ?>&fromEvent_id=<?php echo $event_id ?>" style="color: white">
								<?php
								}
								?>
								<img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<?php echo $allUsersEmail_hash ?>?d=mp&s=30">&emsp;<span><?php echo $allUsersUsername ?></span>
								</a>
          		<?php
          	}
        	}
				}
        	?>
        </div>
        <br>
        <br>

				<?php
					if($darkTheme == 0){
					?>
					<a class="list-group-item bg-light list-group-item-action text-center" data-toggle="modal" data-target="#emailInviteModal" href="#"><i class="material-icons align-text-top">email</i>&emsp;Email Invite</a>
					<?php
					}
					else if($darkTheme == 1){
					?>
					<a class="list-group-item bg-dark list-group-item-action text-center" data-toggle="modal" data-target="#emailInviteModal" href="#" style="color: white"><i class="material-icons align-text-top">email</i>&emsp;Email Invite</a>
	        <?php
					}
					?>
						<!-- Modal -->
						<div class="modal fade" id="emailInviteModal" tabindex="-1" role="dialog" aria-labelledby="emailInviteModalLabel" aria-hidden="true">
	  					<div class="modal-dialog" role="document">
								<?php
								if($darkTheme == 0){
								?>
	    					<div class="modal-content">
								<?php
								}
								else if($darkTheme == 1){
								?>
								<div class="modal-content bg-dark">
								<?php
								}
								?>
	      					<div class="modal-header">
	        					<h5 class="modal-title" id="emailInviteModalLabel">Email Invite</h5>
										<?php
										if($darkTheme == 0){
										?>
	        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<?php
										}
										else if($darkTheme == 1){
										?>
										<button type="button" class="close bg-light" data-dismiss="modal" aria-label="Close">
										<?php
										}
										?>
	          					<span aria-hidden="true">&times;</span>
	        					</button>
	      					</div>
									<form action="emailInvite.php">
	      						<div class="modal-body">
											<input type="hidden" name="fromEvent_id" value="<?php echo $event_id ?>">
											<div class="form-group">
												<label for="inputEmail">Email Address</label>
												<input type="email" name="email" class="form-control" id="inputEmail">
											</div>
	      						</div>
	      						<div class="modal-footer">
	        						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        						<button type="submit" class="btn btn-primary">Send Invite</button>
	      						</div>
									</form>
	    					</div>
	  					</div>
						</div>
						<!-- Modal end -->
						<br>
						<br>
						<?php
		        if(isset($_SESSION['selectedUsers'])){
		          if(count($_SESSION['selectedUsers']) > 0){
		            foreach($_SESSION['selectedUsers'] as $selectedUser){
									if($darkTheme == 0){
		              	echo '<div class="card bg-light" style="width: 10rem; display: inline-block;">';
									}

									else if($darkTheme == 1){
										echo '<div class="card bg-dark" style="width: 10rem; display: inline-block;">';
									}
		                echo '
										<a href="deselectUsers.php?deselectedUser='.$selectedUser[0].'&fromEvent_id='.$event_id.'" class="close bg-light" aria-label="Close">
		                  <span aria-hidden="true">&times;</span>
		                  </a>
		                  <img class="card-img-top" src="https://www.gravatar.com/avatar/'.$selectedUser[1].'?d=mp&s=300">
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
				<br>
      </div>

    <script src="js/script.js"></script>
  </body>
  </html>
