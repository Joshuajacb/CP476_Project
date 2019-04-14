<?php

require_once('config.php');

session_start();

$ch = $_POST['new_channel_name'];
echo $ch;
$ch = str_replace("'", "", $ch);
$uid = $_SESSION['id'];

if(!empty(trim($ch))) {
    $sql = "SELECT channel_name FROM channel_details WHERE channel_name = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_chname);
        
        // Set parameters
        $param_chname = trim($ch);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                $chname_err = "This channel already exists.";
            } else{
                $ch = trim($ch);
            }
        } 
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}

if(empty($chname_err)) {

    $sql2 = "INSERT INTO channel_details (channel_name) VALUES ( '" . $ch . "' )";

    $stmt2 = mysqli_prepare($link, $sql2);

    if(mysqli_stmt_execute($stmt2)) {

        $ch_id_result = mysqli_insert_id($link);

        $sql_query = "SELECT * FROM channel_details WHERE channel_name = '" . $ch . "'";

        $stmt3 = mysqli_prepare($link, $sql_query);
        if(mysqli_stmt_execute($stmt3)) {
            mysqli_stmt_store_result($stmt3);
            mysqli_stmt_bind_result($stmt3, $sql_ch_id, $ch_name);

            if(mysqli_stmt_num_rows($stmt3) == 1) {
                $update_chus_table = "INSERT INTO channel_users (channel_id, user_id) VALUES ( '" . $ch_id_result . "', '" . $uid . "' )";
                $stmt4 = mysqli_prepare($link, $update_chus_table);
                mysqli_stmt_execute($stmt4);
            } 

            echo update_session_channel_list($ch, $link);
        }
        
    }
}



?>