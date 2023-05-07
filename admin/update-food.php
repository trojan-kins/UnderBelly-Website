<?php include('partials/menu.php');?>

<?php

    // Check weather id is set or not
    if (isset($_GET['id'])) {
        // Get all the details
        $id = $_GET['id'];

        // SQL query to get Selected food
        $sql2 = "SELECT * FROM tbl_food1 WHERE id=$id";

        // Execute query
        $res2 = mysqli_query($conn, $sql2);

        // Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        // Get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }

    else {
        // Redirect to Manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>




<div class="main-content">
    <div class="wrapper">
        <h1 class="dash-color">Update Food</h1>
        
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>" placeholder="Update Food Tilte">
                    </td>
                </tr>
    
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5"> <?php echo $description;?></textarea>
                    </td>
                </tr>
    
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
    
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if (($current_image == "")) {
                                // Image is not available
                                echo "<div class='error'>Image Not Available</div>";
                            }
                            else {
                                // Image available
                                ?>
                                    <img src="<?php echo SITEURL;?>/assets/imgs/food/<?php echo $current_image;?>" alt="" width="150px">

                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" id="">

                            <?php
                                // Query to get Active categories
                                $sql = "SELECT * FROM tbl_category1 WHERE active='Yes'";

                                // Execute the quesried
                                $res = mysqli_query($conn, $sql);

                                // Count rows
                                $count = mysqli_num_rows($res);

                                // Check weather category is available or not
                                if ($count > 0) {
                                    // Categry available
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        // echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_category == $category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php
                                    }
                                }
                                else{
                                    // Category not available
                                    echo "<option value='0'>Category Not Available</option>";
                                }
                            
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes" id="">Yes
                        <input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No" id="">No
                    </td>
                </tr>
                
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes" id="">Yes
                        <input <?php if($active  == "No") {echo "checked";} ?> type="radio" name="active" value="No" id="">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update food" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>

        <?php
        
            if (isset($_POST['submit'])) {
                // echo "Button clicked";

                // 1. Get all the details from the form 
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Upload the iMAGE if selected
                // Check weather the upload button is clicked or not
                if (isset($_FILES['image']['name'])) {
                    // Get the image detail
                    $image_name = $_FILES['image']['name'];

                    // Checking weather image is available or not
                    if($image_name != ""){
                        // Auto Rename our Image
                        // Get the Extention of our image(jpeg, png, gif, etc) e.g "Food1.jpg"
                        $ext = end(explode('.', $image_name));
        
                        // Rename the Image
                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;  //e.g. Food_Category_328.jpg
                        
        
                        $src_path = $_FILES['image']['tmp_name'];
        
                        $dest_path = "../assets/imgs/food/".$image_name;
        
                        // Finally upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);
        
                        // Check weather the image is uploaded or not
                        // If Image is not uploaded then we will stop the process and redirect with error message
                        if($upload == false){
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
        
                            // Redirect to Add Category Page
                            header('location:'.SITEURL.'admin/manage-food.php');
        
                            // Stop the process
                            die();
                        }

                        // B. Remove the current Image if available
                        
                        if ($current_image!="") {

                            $remove_path = "../assets/imgs/food/".$current_image;

                            $remove = unlink($remove_path);

                            // Check weather the image is removed or not 
                            // If failed to remove then display message and stop the process
                            if ($remove == false) {
                                // Failed to remove
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
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



                // 4. Update the database
                $sql3 = "UPDATE tbl_food1 SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                // Execute the query
                $res3 = mysqli_query($conn, $sql3);

                // Check weatehr the query is executed or not
                if ($res3 == true) {
                    // Query Executed and food updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";

                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else {
                    $_SESSION['update'] = "<div class='error'>Failed to Update food</div>";

                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                // 5.Redirect to manage food with session message
            }
        
        
        ?>



    </div>
</div>


<?php include('partials/footer.php');?>