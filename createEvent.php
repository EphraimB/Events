<?php
session_start();

require_once 'config.php';

$title = $description = $location = $startDate = $endDate = "";
$title_err = $description_err = $location_err = $startDate_err = $endDate_err = "";


$session_username = $_SESSION['username'];

global $link;

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

if(empty(trim($_POST["endDate"]))){
  $endDate_err = "Enter a end date.";
  $_SESSION['addEvent_error'] = $endDate_err;
  header("location: addEvent.php");
}
else{
  $endDate = trim($_POST["endDate"]);
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

if(empty(trim($_POST["title"])) && empty(trim($_POST["endDate"]))){
  $title_endDate_err = "Enter a title and end date.";
  $_SESSION['addEvent_error'] = $title_endDate_err;
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

if(empty(trim($_POST["description"])) && empty(trim($_POST["endDate"]))){
  $description_endDate_err = "Enter a description and end date.";
  $_SESSION['addEvent_error'] = $description_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["location"])) && empty(trim($_POST["startDate"]))){
  $location_startDate_err = "Enter a location and start date.";
  $_SESSION['addEvent_error'] = $location_startDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["location"])) && empty(trim($_POST["endDate"]))){
  $location_endDate_err = "Enter a location and end date.";
  $_SESSION['addEvent_error'] = $location_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
  $startDate_endDate_err = "Enter a start date and end date.";
  $_SESSION['addEvent_error'] = $startDate_endDate_err;
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

if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["endDate"]))){
  $title_description_endDate_err = "Enter a title, description, and end date.";
  $_SESSION['addEvent_error'] = $title_description_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["title"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
  $title_startDate_endDate_err = "Enter a title, start date, and end date.";
  $_SESSION['addEvent_error'] = $title_startDate_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
  $description_startDate_endDate_err = "Enter a description, startDate, and end date.";
  $_SESSION['addEvent_error'] = $title_description_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"]))){
  $title_description_location_startDate_err = "Enter a title, description, location, and start date.";
  $_SESSION['addEvent_error'] = $title_description_location_startDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["endDate"]))){
  $title_description_location_endDate_err = "Enter a title, description, location, and end date.";
  $_SESSION['addEvent_error'] = $title_description_location_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
  $description_location_startDate_endDate_err = "Enter a description, location, start date, and end date.";
  $_SESSION['addEvent_error'] = $description_location_startDate_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["title"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
  $title_location_startDate_endDate_err = "Enter a title, location, start date, and end date.";
  $_SESSION['addEvent_error'] = $title_location_startDate_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
  $title_description_startDate_endDate_err = "Enter a title, description, start date, and end date.";
  $_SESSION['addEvent_error'] = $title_description_startDate_endDate_err;
  header("location: addEvent.php");
}

if(empty(trim($_POST["title"])) && empty(trim($_POST["description"])) && empty(trim($_POST["location"])) && empty(trim($_POST["startDate"])) && empty(trim($_POST["endDate"]))){
  $title_description_location_startDate_endDate_err = "Enter a title, description, location, start date, and end date.";
  $_SESSION['addEvent_error'] = $title_description_location_startDate_endDate_err;
  header("location: addEvent.php");
}

?>
