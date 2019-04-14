<?php 

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cp476_projectdb');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

date_default_timezone_set('America/Toronto');

//Gets the time the user was last active.
function fetch_user_last_activity($user_id, $link) {
	$sql = "SELECT * FROM login_details WHERE user_id = '$user_id' ORDER BY last_activity DESC LIMIT 1";

	if($stmt = mysqli_prepare($link, $sql)) {
		// Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
        	mysqli_stmt_store_result($stmt);
                         
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $login_details_id, $user_id, $last_activity, $is_type);
            while(mysqli_stmt_fetch($stmt)) {

            	return $last_activity;
            }
        } 
    } 

}

//Gets chat history of all users in a channel
function fetch_user_chat_history($from_user_id, $to_channel_id, $link) {

    $sql = "SELECT * FROM chat_message WHERE (from_user_id = '" . $from_user_id ."' AND to_channel_id = '" . $to_channel_id ."')
    OR (to_channel_id = '" . $to_channel_id ."')
    ORDER BY timestamp ASC";


    $output = "";
    if($stmt = mysqli_prepare($link, $sql)) {
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
                         
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $sql_chat_message_id, $sql_to_channel_id, $sql_from_user_id, $sql_chat_message, $sql_timestamp, $sql_status);
            $output .= '<ul id="chat_history_list" class="list-unstyled">';
            while(mysqli_stmt_fetch($stmt)) {
                if($sql_from_user_id == $from_user_id) {
                    $user_name = '<b class="text-success">'.$_SESSION['username'].'</b>';
                } else {
                    $user_name = '<b class="text-danger">' . get_user_name($sql_from_user_id, $link) .'</b>'; 
                }

                $output .= '
                  <li style="border-bottom:1px dotted #ccc">
                   <p>'.$user_name.' - '.$sql_chat_message.'
                    <div align="right">
                     - <small><em>'.$sql_timestamp.'</em></small>
                    </div>
                   </p>
                  </li>';
            }

        } 
    }

    $output .= "</ul>";

    return $output;

}

//Updates the session list for currently joined channels
function update_session_channel_list($ch_name, $link) {

    $sql = "SELECT * FROM channel_details WHERE ( channel_name = '" . $ch_name . "' )";

    $choutput = "";

    if($stmt = mysqli_prepare($link, $sql)) {
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
                         
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $new_chid, $new_chname);
            while(mysqli_stmt_fetch($stmt)) {

                array_push($_SESSION["channel_list"], array($new_chid, $new_chname));
                $choutput .= '<li class="" id="channel_item" data-channelid="' . $new_chid . '"><a href="#" class="channel_list_'. $new_chid . '"><i class="fas fa-book"></i>'. $new_chname . '</a></li>';
            }

        } 
    }

    return $choutput;
}

// Gets the logged in username
function get_user_name($user_id, $link) {
    $sql = "SELECT username FROM users WHERE id = '$user_id'";

    if($stmt = mysqli_prepare($link, $sql)) {
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
                         
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $param_username);
            while(mysqli_stmt_fetch($stmt)) {

                return $param_username;
            }
        } 
    }
} 



?>