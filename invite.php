<?php

session_start();

require_once 'config.php';

global $link;


$event_id = $_GET['event_id'];

$session_username = $_SESSION['username'];

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
          while($user = mysqli_fetch_array($allUsers_result)[0]){
            $allUsersEmail = mysqli_fetch_array($allUsersEmailResult)[0];

            if($user != $session_username && $allUsersEmail != $email){
              $allUsersEmail_hash = md5(strtolower(trim($allUsersEmail)));
          ?>
            <a class="list-group-item list-group-item-action text-center" href="#"><img class="align-middle circle-img" src="https://www.gravatar.com/avatar/<? echo $allUsersEmail_hash ?>?s=30">&emsp;<span><? echo $user ?></span></a>
          <?php
          }
        }
        ?>
        </div>
      </main>
    </div>

    <script src="js/script.js"></script>
  </body>
  </html>
