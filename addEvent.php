<?php

session_start();

require_once 'config.php';


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

$query = "SELECT * FROM events, userEvents, users WHERE username='$session_username'";
$result = mysqli_query($link, $query);

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
              <a class="nav-link" href="index.php">Home</a>
            </li>
          </ul>
          <ul class="navbar-nav mr-right">
            <div class="dropdown">
              <a class="nav-item dropdown dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<? echo $email_hash ?>?s=30">&nbsp;<?php echo $_SESSION['username']; ?></a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="index.php?logout=1">Logout</a>
              </div>
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
        <form action="server.php" method="post">
          <?php
            if(isset($_SESSION['addEvent_error'])){
              echo '<div class="alert alert-danger" role="alert">';
                echo $_SESSION['addEvent_error'];
              echo '</div>';
            }
          ?>
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
            <input type="search" id="place-search-input" placeholder="Start Searching..." class="form-control" name="location">
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
      </main>
    </div>

      <script>
      placeSearch({
        key: 'yv7CrKLXnF6OAfUF7VCzo8qPq7TfjSLT',
        container: document.querySelector('#place-search-input')
      });
      </script>
  </body>
</html>
