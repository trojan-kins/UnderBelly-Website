<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1 class = "dash-color">Manage Admin</h1>
        <br>

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];  //Displaying session message
                unset($_SESSION['add']);  //Removing Session message 
            } 
            
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];  //Displaying session message
                unset($_SESSION['delete']);  //Removing Session message 
            } 
            
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];  //Displaying session message
                unset($_SESSION['update']);  //Removing Session message 
            } 
            
            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];  //Displaying session message
                unset($_SESSION['user-not-found']);  //Removing Session message 
            } 
            
            if(isset($_SESSION['pwd-not-match']))
            {
                echo $_SESSION['pwd-not-match'];  //Displaying session message
                unset($_SESSION['pwd-not-match']);  //Removing Session message 
            }

            if(isset($_SESSION['change-pwd']))
            {
                echo $_SESSION['change-pwd'];  //Displaying session message
                unset($_SESSION['change-pwd']);  //Removing Session message 
            } 
        ?>

        <br><br>
        <!-- Button to add Admin -->
        <a href="add-admin.php" class = "btn-primary">Add Admin</a>
        <br><br><br>

        <table class = "tbl-full">
            <tr>
                <th>Sr.No</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php 
                // Querry to get all admin 
                $sql = "SELECT * FROM tbl_admin1";
                // Execute the querry
                $res = mysqli_query($conn, $sql);

                // Check weather the quesry is executed or not
                if ($res == TRUE) {
                    // Count rows to check weather we have data in data base or not
                    $count = mysqli_num_rows($res);  //Function to get all the rows in database

                    $sn = 1;  //Create variable and assign the value

                    // Check the numbe rof rows 
                    if ($count>0) {
                        // i.e we have data in database
                        while ($rows = mysqli_fetch_assoc($res)) {
                            // Using while loop to get all the data from database
                            // And while loop will run as long as we have data in database

                            // Get individual data
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $username = $rows['username'];

                            // Display the values in our table 
                            ?>

                            <tr>
                                <td><?php echo $sn++ ?></td>
                                <td><?php echo $full_name?></td>
                                <td><?php echo $username?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-password.php ?id=<?php echo $id; ?> " class = "btn-primary">Change Password</a>
                                    <a href="<?php echo SITEURL; ?>admin/update-admin.php ?id=<?php echo $id; ?> " class = "btn-secondary">Update Admin</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php ?id=<?php echo $id; ?> " class = "btn-danger">Delete Admin</a>
                                </td>
                            </tr>

                            <?php

                        }
                    }
                    else{
                        // we do not have data in database
                    }

                }
            ?>
        </table>
        
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>