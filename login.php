<?php
session_start();

require_once 'vendor/autoload.php'; // change path as needed

$fb = new Facebook\Facebook([
  'app_id' => '292677644669875',
  'app_secret' => '02a3954f09e40fd21915931561f391d0',
  'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/Events/fb-callback.php', $permissions);
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
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://raw.github.com/noizwaves/bootstrap-social-buttons/v1.0.0/social-buttons.css" rel="stylesheet">
    <link rel="icon" href="img/baseline_event_black_18dp.png">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <div class="container">
      <br>
      <header>
        <h1 class="text-center">Login</h1>
      </header>
      <br>
      <br>
      <main>
        <form action="server.php" method="post">
          <?php
            if(isset($_SESSION['login_error'])){
              echo '<div class="alert alert-danger" role="alert">';
                echo $_SESSION['login_error'];
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
          <br>
          <p>If you didn't make an account yet: <a href="register.php">Register</a></p>
          <br>
          <div class="text-center">
            <button type="register" class="btn btn-primary" name="login_btn">Submit</button>
            <button class="btn btn-social btn-facebook" style="background-color: #3B5998;"><a class="btn btn-social btn-facebook" style="color: white;" href="<?php echo $loginUrl ?>"><i class="fa fa-facebook"></i> | Connect with Facebook</a></button>
          </div>
        </form>
      </main>
    </div>
  </body>
</html>
