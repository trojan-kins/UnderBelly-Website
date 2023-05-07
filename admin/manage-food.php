<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1 class = "dash-color">Manage Food</h1>
        <br><br><br>

        <!-- Button to add Admin -->
        <a href="<?php echo SITEURL;?>admin/add-food.php" class = "btn-primary">Add Food</a>

        <br><br><br>

        <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }
            
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset ($_SESSION['delete']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }

            if (isset($_SESSION['unauthorize'])) {
                echo $_SESSION['unauthorize'];
                unset ($_SESSION['unauthorize']);
            }

            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }
        ?>

        <table class = "tbl-full">
            <tr>
                <th>Sr.No</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>


            <?php
            
            // Create SQl query to get all the Food 
            $sql = "SELECT * FROM tbl_food1";

            // Execute teh query
            $res = mysqli_query($conn, $sql);

            // Count the rows to check weather we have food available or not
            $count = mysqli_num_rows($res);


            //Seriel number value
            $sn = 1; 


            if ($count > 0) {
                // We have food in our Data base
                // Get the food from Database and display
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get the value from individual columns
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                    ?>

                    <tr>
                        <td><?php echo $sn++;?></td>
                        <td><?php echo $title;?></td>
                        <td>₹<?php echo $price;?></td>
                        <td>
                            <?php 
                            
                            // Check weather we have image or not
                            if ($image_name == "") {
                                // We do not have image, Error messaeg
                                echo "<div class = 'error'>Image Not Added Yet</div>";
                            }
                            else {
                                // We have image
                                ?>
                                
                                <img src="<?php echo SITEURL; ?>assets/imgs/food/<?php echo $image_name; ?>" alt="" width = "150px">

                                <?php
                            }
                            
                            ?>
                        </td>
                        <td><?php echo $featured;?></td>
                        <td><?php echo $active;?></td>
                        <td>
                            <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?> " class = "btn-secondary">Update Food</a>
                            <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?> &image_name=<?php echo $image_name;?> " class = "btn-danger">Delete Food</a>
                        </td>
                    </tr>

                    <?php

                }

            }
            else {
                // Food not Added in Data base
                echo "<tr><td colspan = '7' class = 'error'>Food Not Added Yet</td></tr>";
            }

            
            ?>

        </table>
    </div>

</div>



<?php include('partials/footer.php'); ?>