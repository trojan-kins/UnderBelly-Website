<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="dash-color">Add Food</h1>
        <br><br>

        <?php
        
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }

        ?>



        <form action="" method="post" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="" id="" placeholder="Title of the food"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price"></td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                        <?php
                            // Create php code to display Categories from database
                            // 1. Create SQL to get all active categories from database
                            $sql = "SELECT * FROM tbl_category1 WHERE active='Yes'";

                            // Executing query
                            $res = mysqli_query($conn, $sql);

                            // Count rows to check weather we have categories or not
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                // we have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    // Get the details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else {
                                // We do not have category
                                ?>
                                <option value="0">No Categories Found</option>
                                <?php
                            }


                            // Display on Drop down
                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" id="">Yes
                        <input type="radio" name="featured" value="No" id="">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" id="">Yes
                        <input type="radio" name="active" value="NoS" id="">No
                    </td>
                </tr>

                <tr>
                    <td colspan= "2">
                        <input type="submit" name="submit" value="Add Food" class= "btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        
        // Check weather the button is clicked or not
        if (isset($_POST['submit'])) {
            // Add the food in database
            // echo "Button Clicked";

            // 1. Get the data from the FORM 
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            
            // Check weather button for Featured and Active are checked or not
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            }
            else {
                $featured = "No";  //Setting default value
            }
            
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            }
            else {
                $active = "No";  //Setting default value
            }
            
            // 2.Uploaad the image if selected
            // Check weather the image is clicked or not  
            if (isset($_FILES['image']['name'])) {
                // Get the details of the selected
                $image_name = $_FILES['image']['name'];

                // Check weather the image is selected or not and upload image only if selected
                if ($image_name != "") {
                    // Image is selected
                    // A. Rename the image
                    // Get the extention of selected image (jpg, png, gif, etc.)
                    $ext = end(explode('.', $image_name));

                    // Create New name for Image
                    $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;

                    // B. Upload the image
                    // Get the source path and destination path

                    // Source path is the current location of the image
                    $src = $_FILES['image']['tmp_name'];

                    // Destination path for image to be uploaded
                    $dst = "../assets/imgs/food/".$image_name;

                    // Finally upload the food Image
                    $upload = move_uploaded_file($src, $dst);


                    // Check weather image uploaded or not
                    if ($upload == false) {
                        // Failed to upload the image
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";

                        // Redirect it to Add food page with error message
                        header('location:'.SITEURL.'admin/add-food.php');

                        die();  //Stop the process
                    }

                }
            }
            else {
                $image_name = "";  //Setting default value as null
            }
            


            // 3.Insert into Database

            // Create a SQL query to Save and Add food
            // For numerical value we do not need to pass value in quotes 
            $sql2 = "INSERT INTO tbl_food1 SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                -- WHERE id=$_id
            ";


            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Check weather data is inserted or not
            // 4.Redirect with message to manage food page

            if ($res2 == true) {
                // Data Inserted
                $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                // Redirect to manage food
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else{
                // Failed to insert data
                $_SESSION['add'] = "<div class='error'>Failed to add food</div>";
                // Redirect to manage food
                header('location:'.SITEURL.'admin/manage-food.php');
            }

        }
        
        ?>

    </div>
</div>




<?php include('partials/footer.php')?>