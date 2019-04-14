<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, user_icon FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $user_icon);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            $update_sql = "INSERT INTO login_details (user_id) VALUES ('" . $id . "')";
                            $stmt2 = mysqli_prepare($link, $update_sql);
                            mysqli_stmt_execute($stmt2);

                             

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["user_icon"] = $user_icon;                        
                            $_SESSION["login_details_id"] = mysqli_insert_id($link);
                            $_SESSION["currentChannel"] = ''; //default value for now

                            $channel_sql = "SELECT * FROM channel_users WHERE user_id = '" . $id . "'";
                            $user_channel_list = array();  

                            $stmtA = mysqli_prepare($link, $channel_sql);
                            mysqli_stmt_execute($stmtA);
                            mysqli_stmt_store_result($stmtA);
                            mysqli_stmt_bind_result($stmtA, $channel_id, $channel_user_id, $ch_key);  

                            $channel_names = array();
                            $sql4 = "SELECT * FROM channel_details";
                            $stmtV = mysqli_prepare($link, $sql4);
                            mysqli_stmt_execute($stmtV);
                            mysqli_stmt_store_result($stmtV);
                            mysqli_stmt_bind_result($stmtV, $id, $name);

                            $count_sql = "SELECT * FROM channel_details";
                            $result = mysqli_query($link, $count_sql);
                            $channel_count = mysqli_num_rows($result);

                            while(mysqli_stmt_fetch($stmtV)) {
                                array_push($channel_names, array($id, $name));
                            }

                            while(mysqli_stmt_fetch($stmtA)) {
                                for($i = 0; $i < $channel_count; $i++) {
                                    if($channel_names[$i][0] == $channel_id) {
                                        array_push($user_channel_list, array($channel_id, $channel_names[$i][1]));
                                    }
                                }
                            }
                            $_SESSION['channel_list'] = $user_channel_list;

                            // Redirect user to welcome page
                            header("location: dashboard.php");

                            mysqli_stmt_close($stmt2);
                            mysqli_stmt_close($stmtA);
                            mysqli_stmt_close($stmtV);
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
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

$randomNum = rand(1,16);
$imageMin = "img/login-backgrounds/min/bg". $randomNum ."-min.jpg";
$imageMain = "img/login-backgrounds/bg" . $randomNum . ".jpg";


?>
 
<!DOCTYPE html>
<html lang="en" class="asyncImage" data-src="<?php echo $imageMain; ?>">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">

        html { background: url(<?php echo $imageMin; ?>) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; }
        body{ background: none; font: 14px sans-serif; }

        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center ">
            <div class="col-4 login-box">
                
                <h2>Login</h2>
                <p>Please fill in your credentials to login.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                    <p>Don't have an account? <a class="login-sign-up" href="register.php">Sign up now</a>.</p>
                </form>

            </div>
        </div>
    </div> 

    <?php include 'footer.php'; ?>
</body>
</html>