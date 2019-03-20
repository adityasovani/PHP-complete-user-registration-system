<?php
    session_start();
    $_SESSION['errMsg']="";
    if(!isset($_SESSION['email'])){
        $_SESSION['errMsg'] = "You need to be logged in to view this content";
        header('location: login.php');
    }
    $con = new mysqli()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">E-commerce</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Laptops</a></li>
      <li><a href="#">Clothing</a></li>
      <li><a href="#">Games</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      <?php 
      $_SESSION['isLogout'] = true;
      ?>
    </ul>
  </div>
</nav>
    <div class="jumbotron text-center">
      <?php 
        $echo = $_SESSION['email'];
        echo $echo;
      ?>
    </div>
</body>
</html>