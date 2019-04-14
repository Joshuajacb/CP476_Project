<?php 
	// Incomplete feature.

	require_once('config.php');
	session_start();

	$channel_name = $_POST['channel_name'];
	$uid = $_SESSION['id'];


	$sql = "INSERT INTO channel_details (channel_name) VALUES " . $channel_name . "";
	

	$stmt = mysqli_prepare($link, $sql);

	if(mysqli_stmt_execute($stmt)) {
		
		$update_chus_table = "INSERT INTO channel_users (channel_id, user_id) VALUES (" . $channel_name . ", " . $uid . ")";
		$stmt2 = mysqli_prepare($link, $update_chus_table);
		mysqli_stmt_execute($stmt2);
		header("location: dashboard.php");
	}
?>
