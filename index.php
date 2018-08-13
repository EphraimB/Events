<?php

session_start();

require_once 'config.php';

global $link;


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

$query = "SELECT * FROM events LEFT OUTER JOIN userEvents ON events.event_id=userEvents.event_id LEFT OUTER JOIN users ON userEvents.user_id=users.user_id WHERE userEvents.user_id='$session_user_id'";
$result = mysqli_query($link, $query);

$invited_query = "SELECT * FROM invite WHERE user_id='$session_user_id' AND status_id=0";
$invited_result = mysqli_query($link, $invited_query);

$invitedEvents_query = "SELECT * FROM invite LEFT OUTER JOIN events ON invite.event_id=events.event_id WHERE user_id='$session_user_id' AND status_id=2";
$invitedEvents_results = mysqli_query($link, $invitedEvents_query);

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
		<script type="text/javascript">
			$(document).ready(function(){
				$("#myModal").modal('show');
			});
		</script>
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
            <li class="nav-item active">
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
        <h1 class="text-center">Events</h1>
      </header>
      <main>
        <?php
				if(mysqli_num_rows($invited_result) > 0){
					echo '
					<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  					<div class="modal-dialog" role="document">
    					<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title">Invitation</h5>
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
        					</button>
      					</div>
      					<div class="modal-body">
        					<p>You got an invitation.</p>
      					</div>
      					<div class="modal-footer">
									<a class="btn btn-danger" href="updateInviteStatus.php?action=Decline">Decline</a>
        					<a class="btn btn-success" href="updateInviteStatus.php?action=Accept">Accept</a>
      					</div>
    					</div>
  					</div>
					</div>';
				}

        if(mysqli_num_rows($result) > 0){

        ?>
        <br>
        <br>
				<h3 class="text-center">Personal</h3>
				<br>
        <div class="row font-weight-bold mb-4">
          <div class="col-4 col-lg">Title</div>
          <div class="col-5 col-lg">Description</div>
          <div class="col-lg-2 d-none d-lg-block">Location</div>
          <div class="col-lg d-none d-lg-block">Start date</div>
          <div class="col-lg d-none d-lg-block">End date</div>
          <div class="col-lg d-none d-lg-block">Edit</div>
          <div class="col-lg d-none d-lg-block">Delete</div>
          <div class="col-lg d-none d-lg-block">Invite</div>
					<div class="col-lg d-none d-lg-block"></div>
        </div>

        <?php
        while($row = mysqli_fetch_array($result)){
          $event_id = $row['event_id'];
          $userEvents_id = $row['id'];
          $title = $row['title'];
          $description = $row['description'];
          $location = $row['location'];
          $startDate = $row['startDate'];
          $startDateFormatted = date("m/d/Y", strtotime($startDate));
          $startTimeFormatted = date("h:i A", strtotime($startDate));
          $endDate = $row['endDate'];
          $endDateFormatted = date("m/d/Y", strtotime($endDate));
          $endTimeFormatted = date("h:i A", strtotime($endDate));

          /*ini_set("allow_url_fopen", 1);

          $json = file_get_contents('http://www.mapquestapi.com/geocoding/v1/address?key=yv7CrKLXnF6OAfUF7VCzo8qPq7TfjSLT&location='.urlencode($location));
          $obj = json_decode($json, true);

          $mapUrl = $obj["results"][0]["locations"][0]["mapUrl"];*/

          ?>

        <div class="row mb-4">
          <div class="col-4 col-lg"><?php echo $title ?></div>
          <div class="col-5 col-lg"><?php echo $description ?></div>
          <div class="col-lg-2 d-none d-lg-block"><?php echo $location ?></div>
          <div class="col-lg d-none d-lg-block"><?php echo $startDateFormatted."<br>".$startTimeFormatted ?></div>
          <div class="col-lg d-none d-lg-block"><?php echo $endDateFormatted."<br>".$endTimeFormatted ?></div>
          <div class="col-lg d-none d-lg-block"><a href="updateEvent.php?event_id=<?php echo $event_id ?>" class="btn btn-warning material-icons">edit</a></div>
          <div class="col-lg d-none d-lg-block"><a href="deleteEvent.php?event_id=<?php echo $event_id ?>&userEvents_id=<?php echo $userEvents_id ?>" class="btn btn-danger material-icons">delete</a></div>
          <div class="col-lg d-none d-lg-block"><a href="invite.php?event_id=<?php echo $event_id ?>" class="btn btn-primary material-icons">mail</a></div>
          <div class="col-2 col-lg"><a href="moreInfo.php?event_id=<?php echo $event_id ?>&userEvents_id=<?php echo $userEvents_id ?>&invitedEvent=false" class="material-icons">info</a></div>
        </div>
        <?php
          }
          }
          else{
            echo "
            <br>
            <br>
            <p class='text-lead text-center'>No personal events</p>";
          }

					if(mysqli_num_rows($invitedEvents_results) > 0){
						?>
		        <br>
		        <br>
						<h3 class="text-center">Invited</h3>
						<br>
		        <div class="row font-weight-bold mb-4">
		          <div class="col-4 col-lg">Title</div>
		          <div class="col-5 col-lg">Description</div>
		          <div class="col-lg-2 d-none d-lg-block">Location</div>
		          <div class="col-lg d-none d-lg-block">Start date</div>
		          <div class="col-lg d-none d-lg-block">End date</div>
							<div class="col-lg d-none d-lg-block"></div>
		        </div>

		        <?php
		        while($invited_row = mysqli_fetch_array($invitedEvents_results)){
		          $event_id = $invited_row['event_id'];
		          $userEvents_id = $invited_row['id'];
		          $title = $invited_row['title'];
		          $description = $invited_row['description'];
		          $location = $invited_row['location'];
		          $startDate = $invited_row['startDate'];
		          $startDateFormatted = date("m/d/Y", strtotime($startDate));
		          $startTimeFormatted = date("h:i A", strtotime($startDate));
		          $endDate = $invited_row['endDate'];
		          $endDateFormatted = date("m/d/Y", strtotime($endDate));
		          $endTimeFormatted = date("h:i A", strtotime($endDate));

							?>

						<div class="row mb-4">
							<div class="col-4 col-lg"><?php echo $title ?></div>
							<div class="col-5 col-lg"><?php echo $description ?></div>
							<div class="col-lg-2 d-none d-lg-block"><?php echo $location ?></div>
							<div class="col-lg d-none d-lg-block"><?php echo $startDateFormatted."<br>".$startTimeFormatted ?></div>
							<div class="col-lg d-none d-lg-block"><?php echo $endDateFormatted."<br>".$endTimeFormatted ?></div>
							<div class="col-2 col-lg"><a href="moreInfo.php?event_id=<?php echo $event_id ?>&userEvents_id=<?php echo $userEvents_id ?>&invitedEvent=true" class="material-icons">info</a></div>
						</div>
						<?php
							}
							}
							else{
								echo "
								<br>
								<br>
								<p class='text-lead text-center'>No invited events</p>";
							}
        ?>
        <br>
        <br>
        <div class="text-center text-white">
          <a class="btn btn-primary" href="addEvent.php">Add event</a>
        </div>
      </main>
    </div>

    <script src="js/script.js"></script>
  </body>
</html>
