<?php

// Intermediary file for ajax use.

require_once('config.php');

session_start();

echo fetch_user_chat_history($_SESSION['id'], $_POST['to_channel_id'], $link);

?>