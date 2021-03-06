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

$upcomingQuery = "SELECT * FROM events LEFT OUTER JOIN userevents ON events.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE userevents.user_id='$session_user_id' AND events.endDate >= NOW()";
$upcomingResult = mysqli_query($link, $upcomingQuery);

$passedQuery = "SELECT * FROM events LEFT OUTER JOIN userevents ON events.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE userevents.user_id='$session_user_id' AND events.startDate <= NOW()";
$passedResult = mysqli_query($link, $passedQuery);

$invited_query = "SELECT * FROM invite WHERE user_id='$session_user_id' AND status_id=0";
$invited_result = mysqli_query($link, $invited_query);

$events_query = "SELECT * FROM events LEFT OUTER JOIN userevents ON events.event_id=userevents.event_id LEFT OUTER JOIN users ON userevents.user_id=users.user_id WHERE userevents.user_id='$session_user_id'";
$events_result = mysqli_query($link, $events_query);

$invitedEvents_query = "SELECT * FROM invite LEFT OUTER JOIN events ON invite.event_id=events.event_id WHERE user_id='$session_user_id' AND status_id=2";
$invitedEvents_result = mysqli_query($link, $invitedEvents_query);

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
    <link href="css/calendar.css" type="text/css" rel="stylesheet" />
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
						<li class="nav-item active">
              <a class="nav-link" href="calendar.php?month=<?php echo date('m', strtotime("now")); ?>&day=<?php echo date('d', strtotime("now")); ?>&year=<?php echo date('Y', strtotime("now")); ?>">Calendar <span class="sr-only">(current)</span></a>
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
        <h1 class="text-center">Calendar</h1>
      </header>
      <br>
      <main>
      <?php
      include 'calendarWidget.php';

      $calendar = new Calendar();

      echo $calendar->show();

      $todaysDate = date("Y-m-d", strtotime("now"));
      echo '<script>
            document.getElementById("li-'.$todaysDate.'").style.backgroundColor = "#B1B1B1";
            </script>
            ';

      while($event = mysqli_fetch_array($events_result)){
        $event_id = $event['event_id'];
        $userEvents_id = $event['id'];
        $event_title = $event['title'];
        $startDate = $event['startDate'];
        $startDateFormatted = date("Y-m-d", strtotime($startDate));

        echo '<script>
              var attribute = document.createElement("a");
              attribute.setAttribute("href", "moreInfo.php?event_id='.$event_id.'&userEvents_id='.$userEvents_id.'&invitedEvent=false")
              var parent = document.createElement("p");
              parent.setAttribute("class", "event myEvent");
              var node = document.createTextNode("'.$event_title.'");
              parent.appendChild(node);

              document.getElementById("li-'.$startDateFormatted.'").appendChild(attribute);
              attribute.appendChild(parent);
              </script>
              ';
            };

        while($invitedEvent = mysqli_fetch_array($invitedEvents_result)){
          $invitedEvent_id = $invitedEvent['event_id'];
          $invitedUserEvents_id = $invitedEvent['id'];
          $invitedEvent_title = $invitedEvent['title'];
          $invitedStartDate = $invitedEvent['startDate'];
          $invitedStartDateFormatted = date("Y-m-d", strtotime($invitedStartDate));

          echo '<script>
                var invitedAttribute = document.createElement("a");
                invitedAttribute.setAttribute("href", "moreInfo.php?event_id='.$invitedEvent_id.'&userEvents_id='.$invitedUserEvents_id.'&invitedEvent=true")
                var invitedParent = document.createElement("p");
                invitedParent.setAttribute("class", "event invitedEvent");
                var invitedNode = document.createTextNode("'.$invitedEvent_title.'");
                invitedParent.appendChild(invitedNode);

                document.getElementById("li-'.$invitedStartDateFormatted.'").appendChild(invitedAttribute);
                invitedAttribute.appendChild(invitedParent);
                </script>
                ';
        }
      ?>
      </main>
    </div>
  </body>
</html>
