<?php
	
	// Include config file
	require_once "config.php";

	session_start();

	$sql = "SELECT id, username FROM users";

	if($stmt = mysqli_prepare($link, $sql)) {
		// Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
        	mysqli_stmt_store_result($stmt);
            $online_list = "";
            $offline_list = "";
            $divider = "<div class='dropdown-divider'></div>";         
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id, $username);
            while(mysqli_stmt_fetch($stmt)) {

            	$online_status = "";
            	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '-10 second');
            	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            	$user_last_activity = fetch_user_last_activity($id, $link);

            	if($user_last_activity > $current_timestamp) {
            		$online_status = "user-online";
            		$online_list .= "<a class='dropdown-item' id='" . $online_status . "' href='#'>" . $username . "</a>";
            	} else {
            		$online_status = "user-offline";
            		$offline_list .= "<a class='dropdown-item' id='" . $online_status . "' href='#'>" . $username . "</a>";
            	}
            }
        } 
    } 

	echo $online_list . $divider . $offline_list;


?>
