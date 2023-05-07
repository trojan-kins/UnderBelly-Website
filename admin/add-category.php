<?php include('partials/menu.php');?>


<div class="main-content">
    <div class="wrapper">
        <h1 class = "dash-color">Add Category</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add'])){
                echo ($_SESSION['add']);
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload'])){
                echo ($_SESSION['upload']);
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Add Category Form Start -->
        <form action="" method="POST" enctype = "multipart/form-data">
            
            <table class = "tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" id="" placeholder = "Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value = "Yes">Yes
                        <input type="radio" name="featured" value = "No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value = "Yes">Yes
                        <input type="radio" name="active" value = "No">No
                    </td>
                </tr>

                <tr>
                    <td colspan = "2">
                        <input type="submit" name = "submit" value="Add Category" class = "btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Category Form Start -->


        <?php
        
        // Check weather the submit button is clicked or not
        if (isset($_POST['submit'])) {
            // echo "Clicked";


            // 1.Get the value from the Category Form
            $title = $_POST['title'];

            // For radio input type, we need to check weather the button is selected or not
            if (isset($_POST['featured'])) {
                // Get the value from FORM 
                $featured = $_POST['featured'];

            }
            else{
                // Set the default value
                $featured = "No";
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            }
            else{
                $active = "No";
            }

            // Check weather the Image is selected or not and set the value for Image-Name accordingly
            // print_r($_FILES['image']);

            // die();  //Break the code here


            if (isset($_FILES['image']['name'])) {
                // Upload the Image
                // To uplaod Image we need Image name, Source path and destimation path
                $image_name = $_FILES['image']['name'];
                
                // Upload the image only if image is selected
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
                        header('location:'.SITEURL.'admin/add-category.php');
    
                        // Stop the process
                        die();
                    }
                }

            }
            else{
                // Don't Upload the Image and Set the image_name value as blank
                $image_name = "";
            }

            // 2. Creating a SQL query to insert category into database
            $sql = "INSERT INTO tbl_category1 SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
            ";

            // 3.Execute thr Query and save in database
            $res = mysqli_query($conn, $sql);


            // 4. Check weather the query executed or not and data added or not
            if ($res == TRUE) {
                // Query executed and Category added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                // Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');

            }
            else{
                // Failed to add category
                $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                // Redirect to manage category page
                header('location:'.SITEURL.'admin/add-category.php');
            }

        }
        
        ?>


    </div>
</div>


<?php include('partials/footer.php');?>