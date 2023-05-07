<?php include('partials-front/menu.php');?>

<?php

    // Check weather id is passed or not
    if(isset($_GET['category_id'])){
        // Category id is set and get the id
        $category_id = $_GET['category_id'];

        // Get the category Title based on Category ID
        $sql = "SELECT title FROM tbl_category1 WHERE id='$category_id'";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Get the value from database
        $row = mysqli_fetch_assoc($res);

        // Get the title
        $category_title = $row['title'];
    }
    else {
        // Category not passed
        // Redirect to home page
        header('location:'.SITEURL);
    }

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
            // Create sql query to get food based on selected category
            $sql2 = "SELECT * FROM tbl_food1 WHERE category_id=$category_id";

            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Count the rows
            $count2 = mysqli_num_rows($res2);

            // Check weather food is available
            if ($count2 > 0) {
                // Food available
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $id = $row2['id'];
                    $title= $row2['title'];
                    $price= $row2['price'];
                    $description= $row2['description'];
                    $image_name= $row2['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                        <?php
                                // Check weather image is available or not
                                if ($image_name == "") {
                                    // Display Message
                                    echo "<div class='error'>Image not Available</div>"; 
                                }
                                else{
                                    // Image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>assets/imgs/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }

                            ?>

                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">₹<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else {
                // Food not available
                echo "<div class='error'>Food Not Available</div>";
            }
            
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>