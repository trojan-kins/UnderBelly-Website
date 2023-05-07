<?php include('partials-front/menu.php');?>

<html class = "background">
    <head>
        <title>Login - UB Website</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="login">
            <div class="container">

                <h1 class = "text-center">Login</h1>
                <br><br>
    
                <?php 
                
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];  //Displaying session message
                    unset($_SESSION['login']);  //Removing Session message 
                }
                
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];  //Displaying session message
                    unset($_SESSION['no-login-message']);  //Removing Session message 
                }
                
                ?>
                <br>
                <!-- Login Form Starts here -->
    
                <form action="" method="post" class = "text-center login-form">
                    <p>Full Name:
                        <input class = "text-box" type="text" name="full_name" id="" placeholder = "Enter Full Name">
                    </p>
                    <p>Reg NO.:
                        <input class = "text-box" type="text" name="reg_no" id="" placeholder = "Enter Registration Number">
                    </p>
                    <p>Email:
                    </p>
                    <textarea name="custome_email" id="" cols="30" rows="5"></textarea>
                    <br>
                    <p>Password:
                        <input class = "text-box" type="password" name="password" id="" placeholder = "Enter Password">
                    </p>
                    <br>
                    <input type="submit" value="Login" name= "submit" class = "btn-primary btn">
                    <br><br>
                </form>
    
                <!-- Login Form Ends here -->
    
                <p class = "text-center"><a href="www.underbelly.com">UNDERBELLY</a></p>
            </div>
        </div>
    </body>
</html>


<?php 

    // Check weather the sbmit button is clicked or not
    if (isset($_POST['submit'])) {
        // Process for Login
        // 1. Get the data from login form
        // Using mysqli_real_escape_string for special characters to be considered as string

        // $username = mysqli_real_escape_string($conn, $_POST['username']);
        $reg_no = mysqli_real_escape_string($conn, $_POST['reg_no']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        // 2. SQL to check weather the user with username and password exist or not
        $sql = "SELECT * FROM login_user AND password = '$password' AND reg_no = '$reg_no'" ;


        // 3. Executing the query
        $res = mysqli_query($conn, $sql);

        // 4. Count rows to check weatehr the user ecxists or not
        $count = mysqli_num_rows($res);

        if($count == 1)
        {
            // User available and Login Success 
            $_SESSION['login'] = "<div class = 'success'>Login Sucessful</div>";
            $_SESSION['user'] = $username; //To check weather the user is loged in or loged out

            // Redirecting to home page dashboard
            header('location:'.SITEURL.'index.php');
        }
        else{
            // User not available and Login Failed
            $_SESSION['login'] = "<div class = 'error text-center'>Username or Password did not match</div>";

            // Redirecting to home page dashboard
            header('location:'.SITEURL.'user-login.php');
        }
    }

?>