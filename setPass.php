<?php

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        header('location: index.html');
        exit();
    }
    if(isset($_POST['submit'])){
        
    $con = new mysqli('localhost', 'id8770852_sandman', 'qwerty123', 'id8770852_userdb');
    $email = $con->real_escape_string($_POST['email']);
    $password = $con->real_escape_string($_POST['password']);
    $password2 = $con->real_escape_string($_POST['password2']);

    if ($password != $password2) {
        header('location: newpassword.php?mp=false');
    }

    #Encrypt password 
    $password = password_hash($password,PASSWORD_BCRYPT);

    #Terminate token and so reset link
    $con->query("UPDATE users SET keyToken='' WHERE email='$email'");

    #UPDATE password
    $con->query("UPDATE users SET password='$password' WHERE email='$email'");

    header('location: login.php/?resetStatus=success');
    }
?>