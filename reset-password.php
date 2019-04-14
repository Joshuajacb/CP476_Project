<?php

//Works. Not linked to anywhere.

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = $email = "";
$new_password_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<?php include 'header.php'; ?>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php include 'sidebar.php'; ?>

        <!-- Page Content  -->
        <div id="content-wrapper">

            <?php include 'top-nav.php'; ?>

            <div class="chat-container">

                <div class="row">
                    
                    <div class="title col-md-12">
                        <h3>Reset Password</h3>
                    </div>

                </div>
                
                <div class="row" style="height:100%">
                    
                    <div class="col-sm-9">
                        
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                            <div class="form-row">
                                <div class="form-group col-md-6 <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                                    <span class="help-block"><?php echo $new_password_err; ?></span>
                                </div>
                                <div class="form-group col-md-6 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                    <a class="btn btn-link" href="welcome.php">Cancel</a>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="col-sm-3">
                        
                        <div class="docs-container">
                            
                            <div class="user-info">
                                <div class="profile-pic">
                                    <img src="img/blogLogo.png" alt="">
                                </div>
                                <h4><?php echo htmlspecialchars($_SESSION["username"]); ?></h4>
                                <p>Waterloo, ON</p>
                                <div class="socials">
                                    <div class="facebook">
                                        <a href="#"><i class="fab fa-facebook-square fa-2x"></i></a>
                                    </div>
                                    <div class="twitter">
                                        <a href="#"><i class="fab fa-twitter-square fa-2x"></i></a>
                                    </div>
                                    <div class="email">
                                        <a href="#"><i class="fas fa-envelope-square fa-2x"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="doc-list list-group">
                                <h5>Channel Documents: </h5>
                                <a href="#" class="list-group-item list-group-item-action">
                                Cras justo odio
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
                                <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                                <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                                <a href="#" class="list-group-item list-group-item-action" tabindex="-1" aria-disabled="true">Vestibulum at eros</a>
                            </div>

                        </div>

                    </div>

                </div>
                

            </div>



            
        </div>
    </div>


    <?php include 'footer.php'; ?>

    </body>
</html>