<?php 

    // Include constants.php
    include('../config/constants.php');

    // 1. Get the ID of the admin to be deleted
    $id = $_GET['id'];

    // 2. Create the SQL query to delete Admin
    $sql = "DELETE FROM tbl_admin1 WHERE id = $id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check weather the query executed successfully or not
    if ($res == TRUE) {
        // Query executed successfully and admin deleted
        // echo "Admin Deleted";
        // Creating session variable to display message 
        $_SESSION['delete'] = "<div class = 'error'>Admin Deleted Successfully</div>";
        // Redirecting to admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        // Failed to delete admin
        // echo "Failed to Delete Admin";
        
        $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Admin. Try again Later </div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    // 3. Redirect to manage-admin page with message(success/error)
?>