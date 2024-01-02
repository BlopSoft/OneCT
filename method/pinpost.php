<?php
	require_once "../include/config.php";
	include '../include/user.php';

	$pin = 'UPDATE post SET pin = 1 WHERE id = "' .(int)$_GET['id']. '"';
	$unpin = 'UPDATE post SET pin = 0 WHERE id = "' .(int)$_GET['id']. '"';
    $postinf = mysqli_query($db, 'SELECT * FROM post WHERE id = ' .(int)$_GET['id']);
	$postdata = mysqli_fetch_assoc($postinf);

	if(token_data($_SESSION['user']['access_token'])['error'] == 0){
		if($postdata['id_user'] or $postdata['id_who'] == $_SESSION['user']['user_id']){
			if($postdata['pin'] == 1){
				mysqli_query($db, $unpin);
				header("Location: " .$_SERVER['HTTP_REFERER']);
			} elseif($postdata['pin'] == 0){
				mysqli_query($db, $pin);
				header("Location: " .$_SERVER['HTTP_REFERER']);
			}
		}
	} else {
		$error = "Bad request / token";
	}

	echo($error);
?>