<?php 

    // AUTHORIZATION - Access Control
    // Check weather the users are loged in or not
    if (!isset($_SESSION['user'])) {  //If user session is not set
        // User is not logged in
        // Redirect to the login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to access Login panel</div>"; 
        // Redirect to login Page
        header('location:'.SITEURL.'admin/login.php');
    }

?>