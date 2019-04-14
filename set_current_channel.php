<?php 
	
	require_once('config.php');
	session_start();

	$currentChannel = $_POST['channel_id'];

	$_SESSION['currentChannel'] = $currentChannel;

?>