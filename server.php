<?php

session_start();

require_once 'config.php';

$username = $password = $confirm_password = $email = $confirm_email = $birthday = $address = "";
$username_err = $password_err = $confirm_password_err = $email_err = $confirm_email_err = $birthday_err = $address_err = "";

$title = $description = $location = $startDate = $startTime = $endDate = $endTime = "";
$title_err = $description_err = $location_err = $startDate_err = $startTime_err = $endDate_err = $endTime_err = "";

if(isset($_POST['register_btn'])){
  register();
}

if(isset($_POST['login_btn'])){
  login();
}

if(isset($_POST["addEvent_button"])){
  addEvent();
}

if(isset($_POST['editEvent_button'])){
  editEvent();
}

if(isset($_SESSION['facebookPicture'])){
  facebookRegister();
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

  if(empty(trim($_POST['address']))){
    $address_err = "Please enter your address.";
    $_SESSION['reg_error'] = $address_err;
    header("location: register.php");
  }
  else{
    $address = trim($_POST['address']);
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

  if(empty(trim($_POST["username"])) && empty(trim($_POST['address']))){
    $username_address_err = "Please enter your username and address.";
    $_SESSION['reg_error'] = $username_address_err;
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

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password'])) && empty(trim($_POST['address']))){
    $username_password_address_err = "Please enter your username, password, and address.";
    $_SESSION['reg_error'] = $username_password_address_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password'])) && empty(trim($_POST['email'])) && empty(trim($_POST['birthday']))){
    $username_password_email_birthday_err = "Please enter your username, password, email, and birthday.";
    $_SESSION['reg_error'] = $username_password_email_birthday_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password'])) && empty(trim($_POST['email'])) && empty(trim($_POST['address']))){
    $username_password_email_address_err = "Please enter your username, password, email, and address.";
    $_SESSION['reg_error'] = $username_password_email_address_err;
    header("location: register.php");
  }

  if(empty(trim($_POST['password'])) && empty(trim($_POST['email'])) && empty(trim($_POST['birthday'])) && empty(trim($_POST['address']))){
    $password_email_birthday_address_err = "Please enter your password, email, birthday, and address.";
    $_SESSION['reg_error'] = $password_email_birthday_address_err;
    header("location: register.php");
  }

  if(empty(trim($_POST["username"])) && empty(trim($_POST['password'])) && empty(trim($_POST['email'])) && empty(trim($_POST['birthday'])) && empty(trim($_POST['address']))){
    $username_password_email_birthday_address_err = "Please enter your username, password, email, birthday, and address.";
    $_SESSION['reg_error'] = $username_password_email_birthday_address_err;
    header("location: register.php");
  }

  if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($confirm_email_err) && empty($birthday_err) && empty($address_err)){
    $encrypt_password = password_hash($password, PASSWORD_DEFAULT);

    $registerQuery = "INSERT INTO users(username, password, email, birthday, address, createdAt)
              VALUES ('$username', '$encrypt_password', '$email', '$birthday', '$address', now())";
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

function addEvent(){
  global $link;


  $session_user_id = $_SESSION['user_id'];


  if(empty(trim($_POST["title"]))){
    $title_err = "Enter a title.";
    $_SESSION['addEvent_error'] = $title_err;
    header("location: addEvent.php");
  }
  else{
    $title = trim($_POST["title"]);
  }

  if(empty(trim($_POST["description"]))){
    $description_err = "Enter a description.";
    $_SESSION['addEvent_error'] = $description_err;
    header("location: addEvent.php");
  }
  else{
    $description = trim($_POST["description"]);
  }

  if(empty(trim($_POST["location"]))){
    $location_err = "Enter a location.";
    $_SESSION['addEvent_error'] = $location_err;
    header("location: addEvent.php");
  }
  else{
    $location = trim($_POST["location"]);
  }

  if(empty(trim($_POST["startDate"]))){
    $startDate_err = "Enter a start date.";
    $_SESSION['addEvent_error'] = $startDate_err;
    header("location: addEvent.php");
  }
  else{
    $startDate = trim($_POST["startDate"]);
  }

  if(empty(trim($_POST["startTime"]))){
    $startTime_err = "Enter a start time.";
    $_SESSION['addEvent_error'] = $startTime_err;
    header("location: addEvent.php");
  }
  else{
    $startTime = trim($_POST["startTime"]);
  }

  if(empty(trim($_POST["endDate"]))){
    $endDate_err = "Enter a end date.";
    $_SESSION['addEvent_error'] = $endDate_err;
    header("location: addEvent.php");
  }
  else{
    $endDate = trim($_POST["endDate"]);
  }

  if(empty(trim($_POST["endTime"]))){
    $endTime_err = "Enter a end time.";
    $_SESSION['addEvent_error'] = $endTime_err;
    header("location: addEvent.php");
  }
  else{
    $endTime = trim($_POST["endTime"]);
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"]))){
    $title_description_err = "Enter a title and description.";
    $_SESSION['addEvent_error'] = $title_description_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"]))){
    $title_location_err = "Enter a title and location.";
    $_SESSION['addEvent_error'] = $title_location_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startDate"]))){
    $title_startDate_err = "Enter a title and start date.";
    $_SESSION['addEvent_error'] = $title_startDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startTime"]))){
    $title_startTime_err = "Enter a title and start time.";
    $_SESSION['addEvent_error'] = $title_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["endDate"]))){
    $title_endDate_err = "Enter a title and end date.";
    $_SESSION['addEvent_error'] = $title_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["endTime"]))){
    $title_endTime_err = "Enter a title and end time.";
    $_SESSION['addEvent_error'] = $title_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"]))){
    $description_location_err = "Enter a description and location.";
    $_SESSION['addEvent_error'] = $description_location_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"]))){
    $description_startDate_err = "Enter a description and start date.";
    $_SESSION['addEvent_error'] = $description_startDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startTime"]))){
    $description_startTime_err = "Enter a description and start time.";
    $_SESSION['addEvent_error'] = $description_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["endDate"]))){
    $description_endDate_err = "Enter a description and end date.";
    $_SESSION['addEvent_error'] = $description_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["endTime"]))){
    $description_endTime_err = "Enter a description and end time.";
    $_SESSION['addEvent_error'] = $description_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["startDate"]))){
    $location_startDate_err = "Enter a location and start date.";
    $_SESSION['addEvent_error'] = $location_startDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["startTime"]))){
    $location_startTime_err = "Enter a location and start time.";
    $_SESSION['addEvent_error'] = $location_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["endDate"]))){
    $location_endDate_err = "Enter a location and end date.";
    $_SESSION['addEvent_error'] = $location_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["endTime"]))){
    $location_endTime_err = "Enter a location and end time.";
    $_SESSION['addEvent_error'] = $location_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $startDate_startTime_err = "Enter a start date and start time.";
    $_SESSION['addEvent_error'] = $startDate_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $startDate_endDate_err = "Enter a start date and end date.";
    $_SESSION['addEvent_error'] = $startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $startDate_endTime_err = "Enter a start date and end time.";
    $_SESSION['addEvent_error'] = $startDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["endDate"])) && empty(trim($_POST["endTime"]))){
    $endDate_endTime_err = "Enter a end date and end time.";
    $_SESSION['addEvent_error'] = $endDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"]))){
    $title_description_location_err = "Enter a title, description, and location.";
    $_SESSION['addEvent_error'] = $title_description_location_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"]))){
    $title_description_startDate_err = "Enter a title, description, and start date.";
    $_SESSION['addEvent_error'] = $title_description_startDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startTime"]))){
    $title_description_startTime_err = "Enter a title, description, and start date.";
    $_SESSION['addEvent_error'] = $title_description_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["endDate"]))){
    $title_description_endDate_err = "Enter a title, description, and end date.";
    $_SESSION['addEvent_error'] = $title_description_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["endTime"]))){
    $title_description_endTime_err = "Enter a title, description, and end time.";
    $_SESSION['addEvent_error'] = $title_description_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_startDate_endDate_err = "Enter a title, start date, and end date.";
    $_SESSION['addEvent_error'] = $title_startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_startDate_startTime_err = "Enter a title, start date, and start time.";
    $_SESSION['addEvent_error'] = $title_startDate_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["endDate"])) && empty(trim($_POST["endTime"]))){
    $title_endDate_endTime_err = "Enter a title, end date, and end time.";
    $_SESSION['addEvent_error'] = $title_endDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $description_startDate_startTime_err = "Enter a description, startDate, and start time.";
    $_SESSION['addEvent_error'] = $description_startDate_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $description_startDate_endDate_err = "Enter a description, startDate, and end date.";
    $_SESSION['addEvent_error'] = $description_startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $description_startDate_endTime_err = "Enter a description, startDate, and end time.";
    $_SESSION['addEvent_error'] = $description_startDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"]))){
    $title_description_location_startDate_err = "Enter a title, description, location, and start date.";
    $_SESSION['addEvent_error'] = $title_description_location_startDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startTime"]))){
    $title_description_location_startTime_err = "Enter a title, description, location, and start time.";
    $_SESSION['addEvent_error'] = $title_description_location_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["endDate"]))){
    $title_description_location_endDate_err = "Enter a title, description, location, and end date.";
    $_SESSION['addEvent_error'] = $title_description_location_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["endTime"]))){
    $title_description_location_endTime_err = "Enter a title, description, location, and end time.";
    $_SESSION['addEvent_error'] = $title_description_location_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $description_location_startDate_startTime_err = "Enter a description, location, start date, and start time.";
    $_SESSION['addEvent_error'] = $description_location_startDate_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $description_location_startDate_endDate_err = "Enter a description, location, start date, and end date.";
    $_SESSION['addEvent_error'] = $description_location_startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $description_location_startDate_endTime_err = "Enter a description, location, start date, and end time.";
    $_SESSION['addEvent_error'] = $description_location_startDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_location_startDate_endDate_err = "Enter a title, location, start date, and end date.";
    $_SESSION['addEvent_error'] = $title_location_startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_location_startDate_startTime_err = "Enter a title, location, start date, and start time.";
    $_SESSION['addEvent_error'] = $title_location_startDate_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $title_location_startDate_endTime_err = "Enter a title, location, start date, and end time.";
    $_SESSION['addEvent_error'] = $title_location_startDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_description_startDate_startTime_err = "Enter a title, description, start date, and start time.";
    $_SESSION['addEvent_error'] = $title_description_startDate_startTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_description_startDate_endDate_err = "Enter a title, description, start date, and end date.";
    $_SESSION['addEvent_error'] = $title_description_startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $title_description_startDate_endTime_err = "Enter a title, description, start date, and end time.";
    $_SESSION['addEvent_error'] = $title_description_startDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_description_location_startDate_startTime_err = "Enter a title, description, location, start date, and start time.";
    $_SESSION['addEvent_error'] = $title_description_location_startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_description_location_startDate_endDate_err = "Enter a title, description, location, start date, and end date.";
    $_SESSION['addEvent_error'] = $title_description_location_startDate_endDate_err;
    header("location: addEvent.php");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $title_description_location_startDate_endTime_err = "Enter a title, description, location, start date, start time, end date, and end time.";
    $_SESSION['addEvent_error'] = $title_description_location_startDate_endTime_err;
    header("location: addEvent.php");
  }

  if(empty($title_err) && empty($description_err) && empty($location_err) && empty($startDate_err) && empty($startTime_err) && empty($endDate_err) && empty($endTime_err)){
    $startDateTime = $startDate.' '.$startTime;
    $endDateTime = $endDate.' '.$endTime;

    $addEvent_query = "INSERT INTO events(title, description, location, startDate, endDate)
                    VALUES ('$title', '$description', '$location', '$startDateTime', '$endDateTime')";
    $addEvent_result = mysqli_query($link, $addEvent_query);
  }

  if($addEvent_result){
    $userEvents_query = "INSERT INTO userEvents(user_id, event_id)
                    VALUES ('$session_user_id', LAST_INSERT_ID())";
    $userEvents_result = mysqli_query($link, $userEvents_query);

    if($userEvents_result){
      unset($_SESSION['addEvent_error']);
      header("location: index.php");

      mysqli_close($link);
    }
    else{
      echo "Problem";
    }
  }
}

function facebookRegister(){
  global $link;

  $facebookEmail = $_SESSION['facebookEmail'];
  //$facebookBirthday = $_SESSION['facebookBirthday'];
  //$facebookAddress = $_SESSION['facebookAddress'];

  $matchingUser_query = "SELECT * FROM users WHERE email='$facebookEmail'";
  $matchingUser_result = mysqli_query($link, $matchingUser_query);

  if(mysqli_num_rows($matchingUser_result) == 1){
    $_SESSION['username'] = mysqli_fetch_array($matchingUser_result)['username'];
    header("location: index.php");
  }

  else if(mysqli_num_rows($matchingUser_result) < 1){
    $session_username = $_SESSION['username'];

    $addUser_query = "INSERT INTO users(username, password, email, birthday, address, createdAt)
                    VALUES ('$session_username', '', '$facebookEmail', '', '', now())";
    $addUser_result = mysqli_query($link, $addUser_query);

    header("location: login.php");
  }
}

function editEvent(){
  global $link;

  $session_user_id = $_SESSION['user_id'];
  $event_id = $_GET['event_id'];


  if(empty(trim($_POST["title"]))){
    $title_err = "Enter a title.";
    $_SESSION['updateEvent_error'] = $title_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }
  else{
    $title = trim($_POST["title"]);
  }

  if(empty(trim($_POST["description"]))){
    $description_err = "Enter a description.";
    $_SESSION['updateEvent_error'] = $description_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }
  else{
    $description = trim($_POST["description"]);
  }

  if(empty(trim($_POST["location"]))){
    $location_err = "Enter a location.";
    $_SESSION['updateEvent_error'] = $location_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }
  else{
    $location = trim($_POST["location"]);
  }

  if(empty(trim($_POST["startDate"]))){
    $startDate_err = "Enter a start date.";
    $_SESSION['updateEvent_error'] = $startDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }
  else{
    $startDate = trim($_POST["startDate"]);
  }

  if(empty(trim($_POST["startTime"]))){
    $startTime_err = "Enter a start time.";
    $_SESSION['updateEvent_error'] = $startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }
  else{
    $startTime = trim($_POST["startTime"]);
  }

  if(empty(trim($_POST["endDate"]))){
    $endDate_err = "Enter a end date.";
    $_SESSION['updateEvent_error'] = $endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }
  else{
    $endDate = trim($_POST["endDate"]);
  }

  if(empty(trim($_POST["endTime"]))){
    $endTime_err = "Enter a end time.";
    $_SESSION['updateEvent_error'] = $endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }
  else{
    $endTime = trim($_POST["endTime"]);
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"]))){
    $title_description_err = "Enter a title and description.";
    $_SESSION['updateEvent_error'] = $title_description_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"]))){
    $title_location_err = "Enter a title and location.";
    $_SESSION['updateEvent_error'] = $title_location_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startDate"]))){
    $title_startDate_err = "Enter a title and start date.";
    $_SESSION['updateEvent_error'] = $title_startDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startTime"]))){
    $title_startTime_err = "Enter a title and start time.";
    $_SESSION['updateEvent_error'] = $title_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["endDate"]))){
    $title_endDate_err = "Enter a title and end date.";
    $_SESSION['updateEvent_error'] = $title_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["endTime"]))){
    $title_endTime_err = "Enter a title and end time.";
    $_SESSION['updateEvent_error'] = $title_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"]))){
    $description_location_err = "Enter a description and location.";
    $_SESSION['updateEvent_error'] = $description_location_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"]))){
    $description_startDate_err = "Enter a description and start date.";
    $_SESSION['updateEvent_error'] = $description_startDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startTime"]))){
    $description_startTime_err = "Enter a description and start time.";
    $_SESSION['updateEvent_error'] = $description_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["endDate"]))){
    $description_endDate_err = "Enter a description and end date.";
    $_SESSION['updateEvent_error'] = $description_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["endTime"]))){
    $description_endTime_err = "Enter a description and end time.";
    $_SESSION['updateEvent_error'] = $description_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["startDate"]))){
    $location_startDate_err = "Enter a location and start date.";
    $_SESSION['updateEvent_error'] = $location_startDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["startTime"]))){
    $location_startTime_err = "Enter a location and start time.";
    $_SESSION['updateEvent_error'] = $location_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["endDate"]))){
    $location_endDate_err = "Enter a location and end date.";
    $_SESSION['updateEvent_error'] = $location_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["location"])) && empty(trim($_POST["endTime"]))){
    $location_endTime_err = "Enter a location and end time.";
    $_SESSION['updateEvent_error'] = $location_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $startDate_startTime_err = "Enter a start date and start time.";
    $_SESSION['updateEvent_error'] = $startDate_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $startDate_endDate_err = "Enter a start date and end date.";
    $_SESSION['updateEvent_error'] = $startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $startDate_endTime_err = "Enter a start date and end time.";
    $_SESSION['updateEvent_error'] = $startDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["endDate"])) && empty(trim($_POST["endTime"]))){
    $endDate_endTime_err = "Enter a end date and end time.";
    $_SESSION['updateEvent_error'] = $endDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"]))){
    $title_description_location_err = "Enter a title, description, and location.";
    $_SESSION['updateEvent_error'] = $title_description_location_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"]))){
    $title_description_startDate_err = "Enter a title, description, and start date.";
    $_SESSION['updateEvent_error'] = $title_description_startDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startTime"]))){
    $title_description_startTime_err = "Enter a title, description, and start date.";
    $_SESSION['updateEvent_error'] = $title_description_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["endDate"]))){
    $title_description_endDate_err = "Enter a title, description, and end date.";
    $_SESSION['updateEvent_error'] = $title_description_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["endTime"]))){
    $title_description_endTime_err = "Enter a title, description, and end time.";
    $_SESSION['updateEvent_error'] = $title_description_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_startDate_endDate_err = "Enter a title, start date, and end date.";
    $_SESSION['updateEvent_error'] = $title_startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_startDate_startTime_err = "Enter a title, start date, and start time.";
    $_SESSION['updateEvent_error'] = $title_startDate_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["endDate"])) && empty(trim($_POST["endTime"]))){
    $title_endDate_endTime_err = "Enter a title, end date, and end time.";
    $_SESSION['updateEvent_error'] = $title_endDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $description_startDate_startTime_err = "Enter a description, startDate, and start time.";
    $_SESSION['updateEvent_error'] = $description_startDate_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $description_startDate_endDate_err = "Enter a description, startDate, and end date.";
    $_SESSION['updateEvent_error'] = $description_startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $description_startDate_endTime_err = "Enter a description, startDate, and end time.";
    $_SESSION['updateEvent_error'] = $description_startDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"]))){
    $title_description_location_startDate_err = "Enter a title, description, location, and start date.";
    $_SESSION['updateEvent_error'] = $title_description_location_startDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startTime"]))){
    $title_description_location_startTime_err = "Enter a title, description, location, and start time.";
    $_SESSION['updateEvent_error'] = $title_description_location_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["endDate"]))){
    $title_description_location_endDate_err = "Enter a title, description, location, and end date.";
    $_SESSION['updateEvent_error'] = $title_description_location_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["endTime"]))){
    $title_description_location_endTime_err = "Enter a title, description, location, and end time.";
    $_SESSION['updateEvent_error'] = $title_description_location_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $description_location_startDate_startTime_err = "Enter a description, location, start date, and start time.";
    $_SESSION['updateEvent_error'] = $description_location_startDate_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $description_location_startDate_endDate_err = "Enter a description, location, start date, and end date.";
    $_SESSION['updateEvent_error'] = $description_location_startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $description_location_startDate_endTime_err = "Enter a description, location, start date, and end time.";
    $_SESSION['updateEvent_error'] = $description_location_startDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_location_startDate_endDate_err = "Enter a title, location, start date, and end date.";
    $_SESSION['updateEvent_error'] = $title_location_startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_location_startDate_startTime_err = "Enter a title, location, start date, and start time.";
    $_SESSION['updateEvent_error'] = $title_location_startDate_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $title_location_startDate_endTime_err = "Enter a title, location, start date, and end time.";
    $_SESSION['updateEvent_error'] = $title_location_startDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_description_startDate_startTime_err = "Enter a title, description, start date, and start time.";
    $_SESSION['updateEvent_error'] = $title_description_startDate_startTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_description_startDate_endDate_err = "Enter a title, description, start date, and end date.";
    $_SESSION['updateEvent_error'] = $title_description_startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $title_description_startDate_endTime_err = "Enter a title, description, start date, and end time.";
    $_SESSION['updateEvent_error'] = $title_description_startDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["startTime"]))){
    $title_description_location_startDate_startTime_err = "Enter a title, description, location, start date, and start time.";
    $_SESSION['updateEvent_error'] = $title_description_location_startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
    $title_description_location_startDate_endDate_err = "Enter a title, description, location, start date, and end date.";
    $_SESSION['updateEvent_error'] = $title_description_location_startDate_endDate_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endTime"]))){
    $title_description_location_startDate_endTime_err = "Enter a title, description, location, start date, start time, end date, and end time.";
    $_SESSION['updateEvent_error'] = $title_description_location_startDate_endTime_err;
    header("location: updateEvent.php?event_id=".$event_id."");
  }

  if(empty($title_err) && empty($description_err) && empty($location_err) && empty($startDate_err) && empty($startTime_err) && empty($endDate_err) && empty($endTime_err)){
    $startDateTime = $startDate.' '.$startTime;
    $endDateTime = $endDate.' '.$endTime;

    $editEvent_query = "UPDATE events SET title='$title', description='$description', location='$location', startDate='$startDateTime', endDate='$endDateTime' WHERE event_id='$event_id'";
    $editEvent_result = mysqli_query($link, $editEvent_query);
  }

  if($editEvent_result){
    unset($_SESSION['updateEvent_error']);
    header("location: index.php");

    mysqli_close($link);
  }
  else{
    echo "Problem";
  }
}

?>
