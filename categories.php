<?php include('partials-front/menu.php');?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                // Create SQL query to display category from Database
                $sql = "SELECT * FROM tbl_category1 WHERE active='Yes'";
                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count the rows to check the availability of category
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    // Category available
                    while ($row = mysqli_fetch_assoc($res)) {
                        // Get the vaues like title Image name and Id
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                // Check weather image is available or not
                                if ($image_name == "") {
                                    // Display Message
                                    echo "<div class='error'>Image not Available</div>"; 
                                }
                                else{
                                    // Image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>assets/imgs/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                                
                                ?>

                                
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                        
                    }
                }
                else{
                    // Category not availbable
                    echo "<div class='error'>Category not Found</div>";
                }

            ?>



            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


<?php include('partials-front/footer.php');?>