<?php
session_start();
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
    <script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script>
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="img/baseline-event-black-18/1x/baseline_event_black_18dp.png">
  </head>
  <body>
    <div class="container">
      <br>
      <header>
        <h1 class="text-center">Register</h1>
      </header>
      <br>
      <main>
        <form action="server.php" method="post">
          <?php
            if(isset($_SESSION['reg_error'])){
              echo '<div class="alert alert-danger" role="alert">';
                echo $_SESSION['reg_error'];
              echo '</div>';
            }
          ?>
          <div class="form-group text-center">
            <label class="font-weight-bold">Username:</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Password:</label>
            <input type="password" class="form-control" name="password">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Confirm Password:</label>
            <input type="password" class="form-control" name="confirm_password">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Email:</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Confirm Email:</label>
            <input type="email" class="form-control" name="confirm_email">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Birthday:</label>
            <input type="date" class="form-control text-center" name="birthday">
          </div>
          <div class="form-group text-center">
            <label class="font-weight-bold">Address:</label>
            <input type="search" id="place-search-input" placeholder="Start Searching..." class="form-control" name="address">
          </div>
          <br>
          <p>If you already have an account: <a href="login.php">Login</a></p>
          <br>
          <div class="text-center">
            <button type="register" class="btn btn-primary" name="register_btn">Submit</button>
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
