<?php

session_start();
    if(isset($_SESSION['email']) || isset($_SESSION['isLogout'])){
        session_abort();
        header('location: login.php');
    }
?>