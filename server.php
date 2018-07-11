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
  }
  else{
    $username = trim($_POST["username"]);
  }

  if(empty(trim($_POST['password']))){
    $password_err = "Please enter a password.";
  }
  else{
    $password = trim($_POST['password']);
  }

  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = 'Please confirm password.';
  }
  else{
    $confirm_password = trim($_POST['confirm_password']);
  }

  if(empty(trim($_POST['email']))){
    $email_err = "Please enter your email.";
  }
  else{
    $email = trim($_POST['email']);
  }

  if(empty(trim($_POST["confirm_email"]))){
    $confirm_email_err = 'Please confirm your email.';
  }
  else{
    $confirm_email = trim($_POST['confirm_email']);
  }

  if(empty(trim($_POST['birthday']))){
    $birthday_err = "Please enter your birthday.";
  }
  else{
    $birthday = trim($_POST['birthday']);
  }

  if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($confirm_email_err) && empty($birthday_err)){
    $encrypt_password = md5($password);

    $registerQuery = "INSERT INTO users(username, password, email, birthday)
              VALUES ('$username', '$encrypt_password', '$email', '$birthday')";
    $resultRegisterQuery = mysqli_query($link, $registerQuery);
  }

  if($resultRegisterQuery){
    header("location: login.php");

    mysqli_close($link);
  }
}

function login(){
  global $link;

  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
  }
  else{
    $username = trim($_POST["username"]);
  }

  if(empty(trim($_POST['password']))){
    $password_err = "Please enter a password.";
  }
  else{
    $password = trim($_POST['password']);
  }

  if(empty($username_err) && empty($password_err)){
    $encrypt_password = md5($password);

    $loginQuery = "SELECT username, password FROM users WHERE username=$username AND password=$encrypt_password LIMIT 1";
    $resultLoginQuery = mysqli_query($link, $loginQuery);
  }

  if($resultLoginQuery){
    $_SESSION['username'] = $username;
    header("location: index.php");

    mysqli_close($link);
  }
  else{
    echo "Problem";
  }
}

?>
