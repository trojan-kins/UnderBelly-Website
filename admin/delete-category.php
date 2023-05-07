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
            $path = "../assets/imgs/category/".$image_name;
            // Remove the image
            $remove = unlink($path);

            // If failed to remove Image then add an error message and stop the process
            if ($remove == false) {
                // Set the Session message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image</div>";

                // Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');

                // Stop the process
                die();
            }
        }

        // Delete data from database
        // SQL Query delete data from databse
        $sql = "DELETE FROM tbl_category1 WHERE id=$id";


        // Execute teh query
        $res = mysqli_query($conn, $sql);


        //Check weather the data deleted from database or not 
        if ($res==true) {
            // Set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            
            // Redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else {
            // Set fail message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            
            // Redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else {
        // Redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>