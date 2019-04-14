<?php

	// Include config file
	require_once "config.php";

	session_start();

	$sql = "UPDATE login_details SET last_activity = NOW() WHERE login_details_id = '" . $_SESSION['login_details_id'] . "'";
	$stmt = mysqli_prepare($link, $sql);

	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);

?>