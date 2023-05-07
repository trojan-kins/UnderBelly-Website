<?php include('partials/menu.php');?>

    <div class="main-content">
        <div class="wrapper">
            <h1 class="dash-color">Update Category</h1>
            <br><br>

            <?php
            
                // Check weather the id is set or not
                if (isset($_GET['id'])) {
                    // Get the id and all other detail
                    // echo "Get Data";
                    $id = $_GET['id'];

                    // Create SQl query to get all details
                    $sql = "SELECT * FROM tbl_category1 WHERE id=$id";

                    // Execute the query
                    $res = mysqli_query($conn, $sql);

                    // Counting the rows 
                    $count = mysqli_num_rows($res);

                    if ($count == 1) {
                        // Get all the data 
                        $row = mysqli_fetch_assoc($res);

                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    }
                    else {
                        // Redirect to manage-category with session message
                        $_SESSION['no-category-found'] = "<div class='error'>Categry not Found</div>";
                        // Redirect
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }

                }
                else{
                    // Redirect to manage category
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            
            ?>


            <form action="" method = "POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value= "<?php echo $title;?>" placeholder="Enter New title">
                        </td>    
                    </tr>

                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php
                                if($current_image != ""){
                                    // Display the Image 
                                    ?>
                                    <img src="<?php echo SITEURL;?>/assets/imgs/category/<?php echo $current_image;?>" width = "150px">
                                    <?php
                                }
                                else {
                                    // Display Error
                                    echo "<div class='error'>Image not added</div>";
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>New Image: </td>
                        <td>
                            <input type="file" name="image" id="">
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value = "Yes" id="">Yes

                            <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value = "No" id="">No
                        </td>
                    </tr>    

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value = "Yes" id="">Yes

                            <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value = "No" id="">No
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="submit" name= "submit" value="Update Category" class= "btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <?php

                if (isset($_POST['submit'])) {
                    // echo "Clicked";
                    // 1. Get all the values from our form 
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['current_image'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];
                    
                    // 2. Updating New Image if Selected
                    // Check weather the image is selected or not
                    if (isset($_FILES['image']['name'])) {
                        // Get the image detail
                        $image_name = $_FILES['image']['name'];

                        // Checking weather image is available or not
                        if($image_name != ""){
                            // Auto Rename our Image
                            // Get the Extention of our image(jpeg, png, gif, etc) e.g "Food1.jpg"
                            $ext = end(explode('.', $image_name));
            
                            // Rename the Image
                            $image_name = "Food_Category_".rand(000, 999).'.'.$ext;  //e.g. Food_Category_328.jpg
                            
            
                            $source_path = $_FILES['image']['tmp_name'];
            
                            $destination_path = "../assets/imgs/category/".$image_name;
            
                            // Finally upload the image
                            $upload = move_uploaded_file($source_path, $destination_path);
            
                            // Check weather the image is uploaded or not
                            // If Image is not uploaded then we will stop the process and redirect with error message
                            if($upload == false){
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
            
                                // Redirect to Add Category Page
                                header('location:'.SITEURL.'admin/manage-category.php');
            
                                // Stop the process
                                die();
                            }

                            // B. Remove the current Image if available
                            
                            if ($current_image!="") {

                                $remove_path = "../assets/imgs/category/".$current_image;

                                $remove = unlink($remove_path);

                                // Check weather the image is removed or not 
                                // If failed to remove then display message and stop the process
                                if ($remove == false) {
                                    // Failed to remove
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                    die();  //Stop the process
                                }
                            }
                        }
                        else {
                            $image_name = $current_image;
                        }
                    }
                    else {
                        $image_name = $current_image;
                    }


                    // 3.Update the Data base 
                    $sql2 = "UPDATE tbl_category1 SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                        WHERE id= $id
                    ";

                    // Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    // 4.redirec to manage category with message
                    // Check weather query executed or not
                    if ($res2 == true) {
                        // Category updated 
                        $_SESSION['update'] = "<div class='success'>Category updated successfully</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else {
                        // Failed to update category
                        $_SESSION['update'] = "<div class='error'>Failed to Update Category</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }


                }

            ?>
        </div>
    </div>

<?php include('partials/footer.php');?>