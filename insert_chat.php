<?php 
	
	require_once('config.php');
	session_start();

	$chid = $_POST['to_channel_id'];
	$fuid = $_SESSION['id'];
	$cm = $_POST['ch_message'];
	$st = '1';

	if(!empty(trim($cm))) {
		$sql = "INSERT INTO chat_message (to_channel_id, from_user_id, chat_message, status) 
		VALUES (" . $chid . ", " . $fuid . ", '" . $cm . "', " . $st . ")";

		$stmt = mysqli_prepare($link, $sql);

		if(mysqli_stmt_execute($stmt)) {
			echo fetch_user_chat_history($_SESSION['id'], $_POST['to_channel_id'], $link);
		}
	}
	
?>
