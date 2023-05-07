<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1 class ="dash-color">ADD ADMIN</h1>
        <br><br><br>

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];  //Checking weather the session is set or not
                unset($_SESSION['add']);  //Remove session message
            }
        ?>

        <form action="" method = "POST">

            <table class = "tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder = "Enter your Name"></td>
                </tr>
                <tr>
                    <td>User Name: </td>
                    <td><input type="text" name="username" placeholder = "Enter your User Name"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder = "Enter your password" ></td>
                </tr>
                <tr>
                    <td colspan = "2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php
    // Process the value Form and save it in database

    // Check weather the submit button is clicked or not 

    if(isset($_POST['submit']))
    {
        // Button Clicked
        // echo "Button Clicked";

        //1. Get data from FORM
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Password Encryption with md5

        //2. SQL query to save the data in tha data base
        $sql = "INSERT INTO tbl_admin1 SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        //3. Executing querry and saving data in tah database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());


        //4. Check weather the(Querry is executed) data is inserted or not and display appropriate message
        if($res == true)
        {
            // Data Inserted
            // echo "Data inserted";
            // Create a Session variable to display message 
            $_SESSION['add'] = "<div class = 'success'>Admin Added Successfully</div>";
            // Redirect page to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else{
            // Data not inserted
            // echo "Data not inserted";
            // Create a Session variable to display message 
            $_SESSION['add'] = "Failed to add admin";
            // Redirect page to Add admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }
?>
