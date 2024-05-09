<?php
session_start();
require_once("config.php");
if($_SESSION['key']!="VotersKey"){

    echo"<script>location.assign('./Admin/logout.php')</script>";
    die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voters Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<body>
    
<div class="container-fluid">
   <div class="row bg-primary text-white text-center" id="blue">
    <div class="col-2">
      <img src="../Assets/images/vote-box-11350_256.gif" width="90px">

    </div>
       <div class="col-12 my-auto">
        <h3>ONLINE VOTING SYSTEM -<small>Welcome <?php echo $_SESSION['username']; ?> ! </small></h3>
       </div>
   </div>

