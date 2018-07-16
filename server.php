<?php

session_start();

require_once 'config.php';

$username = $password = $confirm_password = $email = $confirm_email = $birthday = "";
$username_err = $password_err = $confirm_password_err = $email_err = $confirm_email_err = $birthday_err = "";

if(isset($_POST['register_btn'])){
  register();
}

if(isset($_POST['login_btn'])){
  login();
}

function register(){
  global $link;

  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
    $_SESSION['reg_error'] = $username_err;
    header("location: register.php");
  }
  else{
    $username = trim($_POST["username"]);
  }

  if(empty(trim($_POST['password']))){
    $password_err = "Please enter a password.";
    $_SESSION['reg_error'] = $password_err;
    header("location: register.php");
  }
  else{
    $password = trim($_POST['password']);
  }

  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = 'Please confirm password.';
    $_SESSION['reg_error'] = $confirm_password_err;
    header("location: register.php");
  }
  else{
    $confirm_password = trim($_POST['confirm_password']);
  }

  if(empty(trim($_POST['email']))){
    $email_err = "Please enter your email.";
    $_SESSION['reg_error'] = $email_err;
    header("location: register.php");
  }
  else{
    $email = trim($_POST['email']);
  }

  if(empty(trim($_POST["confirm_email"]))){
    $confirm_email_err = 'Please confirm your email.';
    $_SESSION['reg_error'] = $confirm_email_err;
    header("location: register.php");
  }
  else{
    $confirm_email = trim($_POST['confirm_email']);
  }

  if(empty(trim($_POST['birthday']))){
    $birthday_err = "Please enter your birthday.";
    $_SESSION['reg_error'] = $birthday_err;
    header("location: register.php");
  }
  else{
    $birthday = trim($_POST['birthday']);
  }

  if(empty(trim($_POST['confirm_password'])) && empty(trim($_POST['confirm_email']))){
    $confirm_password_email_err = "Please confirm your password, and email.";
    $_SESSION['reg_error'] = $confirm_password_email_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['confirm_password']))){
    $username_confirm_password_err = "Please enter your username and confirm your password.";
    $_SESSION['reg_error'] = $username_confirm_password_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['confirm_email']))){
    $username_confirm_email_err = "Please enter your username and confirm your email.";
    $_SESSION['reg_error'] = $username_confirm_email_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['confirm_password'])) && empty(trim($_POST['confirm_email']))){
    $username_confirm_password_email_err = "Please enter your username and confirm your password, and email.";
    $_SESSION['reg_error'] = $username_confirm_password_email_err;
    header("location: register.php");
  }

  if(empty(trim($_POST['email'])) && empty(trim($_POST['birthday']))){
    $email_birthday_err = "Please enter your email, and birthday.";
    $_SESSION['reg_error'] = $email_birthday_err;
    header("location: register.php");
  }

  if(empty(trim($_POST['password'])) && empty(trim($_POST['email'])) && empty(trim($_POST['birthday']))){
    $password_email_birthday_err = "Please enter your password, email, and birthday.";
    $_SESSION['reg_error'] = $password_email_birthday_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password']))){
    $username_password_err = "Please enter your username, and password.";
    $_SESSION['reg_error'] = $username_password_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password'])) && empty(trim($_POST['email']))){
    $username_password_email_err = "Please enter your username, password, and email.";
    $_SESSION['reg_error'] = $username_password_email_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password'])) && empty(trim($_POST['email'])) && empty(trim($_POST['birthday']))){
    $username_password_email_birthday_err = "Please enter your username, password, email, and birthday.";
    $_SESSION['reg_error'] = $username_password_email_birthday_err;
    header("location: register.php");
  }

  if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($confirm_email_err) && empty($birthday_err)){
    $encrypt_password = password_hash($password, PASSWORD_DEFAULT);

    $registerQuery = "INSERT INTO users(username, password, email, birthday, createdAt)
              VALUES ('$username', '$encrypt_password', '$email', '$birthday', now())";
    $resultRegisterQuery = mysqli_query($link, $registerQuery);
  }

  if($resultRegisterQuery){
    unset($_SESSION['reg_error']);
    header("location: login.php");

    mysqli_close($link);
  }
}

function login(){
  global $link;

  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
    $_SESSION['login_error'] = $username_err;
    header("location: login.php");
  }
  else{
    $username = trim($_POST["username"]);
  }

  if(empty(trim($_POST['password']))){
    $password_err = "Please enter a password.";
    $_SESSION['login_error'] = $password_err;
    header("location: login.php");
  }
  else{
    $password = trim($_POST['password']);
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password']))){
    $username_password_err = "Please enter a username and password.";
    $_SESSION['login_error'] = $username_password_err;
    header("location: login.php");
  }

  if(empty($username_err) && empty($password_err)){
    $verify_encrypt_password = password_hash($password, PASSWORD_DEFAULT);

    $loginQuery = "SELECT * FROM users WHERE username='$username'";
    $resultLoginQuery = mysqli_query($link, $loginQuery);

    if($resultLoginQuery){
      if(mysqli_num_rows($resultLoginQuery) == 0){
        $_SESSION['login_error'] = "Wrong Username/Password combination.";
        header("location: login.php");
      }

      if(mysqli_num_rows($resultLoginQuery) == 1){
        if(password_verify($password, mysqli_fetch_array($resultLoginQuery)[2])){
          $updateQuery = "UPDATE users SET lastLogin=now() WHERE username='$username'";
          $resultUpdateQuery = mysqli_query($link, $updateQuery);

          if($resultUpdateQuery){
            $_SESSION['username'] = $username;
            unset($_SESSION['login_error']);
            header("location: index.php");
          }
          else{
            $_SESSION['login_error'] = "An error occured.";
            header("location: login.php");
          }
        }
        else{
          $_SESSION['login_error'] = "Wrong Username/Password combination.";
          header("location: login.php");
        }
      }
      mysqli_close($link);
    }
    else{
      $_SESSION['login_error'] = "An error occured.";
      header("location: login.php");
    }
  }
}

?>
