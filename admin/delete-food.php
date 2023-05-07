<?php

    include('../config/constants.php');

    // echo "DELETE PAGE"
    // Check weather the id and image_name value is set or not
    if (isset($_GET['id']) AND isset($_GET['image_name'])) {
        // Get the value and delete
        // echo "Get value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the physical image file if available 

        if ($image_name != "") {
            // Image is available. So remove it
            $path = "../assets/imgs/food/".$image_name;
            // Remove the image
            $remove = unlink($path);

            // If failed to remove Image then add an error message and stop the process
            if ($remove == false) {
                // Set the Session message
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File</div>";

                // Redirect to manage food page
                header('location:'.SITEURL.'admin/manage-food.php');

                // Stop the process
                die();
            }
        }

        // Delete food from database
        // SQL Query delete data from databse
        $sql = "DELETE FROM tbl_food1 WHERE id=$id";


        // Execute teh query
        $res = mysqli_query($conn, $sql);


        //Check weather the data deleted from database or not 
        if ($res==true) {
            // Set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            
            // Redirect to manage category
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else {
            // Set fail message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            
            // Redirect to manage category
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else {
        // Redirect to manage category page
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>