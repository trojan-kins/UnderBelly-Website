<?php 

    include('../config/constants.php');

    // 1. Destroying the session
    session_destroy();  //Unsets $_SESSION['user']

    // 2. Redirecting to the login page
    header('location:'.SITEURL.'admin/login.php');
?>