<?php
	require_once "../include/config.php";
	include '../include/user.php';

	$pin = 'UPDATE post SET pin = 1 WHERE id = "' .(int)$_GET['id']. '"';
	$unpin = 'UPDATE post SET pin = 0 WHERE id = "' .(int)$_GET['id']. '"';
    $postinf = mysqli_query($db, 'SELECT * FROM post WHERE id = ' .(int)$_GET['id']);

	if(token_data($_SESSION['user']['access_token'])['error'] == 0){
		if(mysqli_fetch_assoc($postinf)['pin'] == 1){
			mysqli_query($db, $unpin);
			header("Location: " .$_SERVER['HTTP_REFERER']);
		} elseif (mysqli_fetch_assoc($postinf)['pin'] == 0){
			mysqli_query($db, $pin);
			header("Location: " .$_SERVER['HTTP_REFERER']);
		}
	} else {
		$error = "Bad request / token";
	}

	echo($error);
?>