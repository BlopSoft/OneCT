<?php
	require_once "../include/config.php";

	$pin = 'UPDATE post SET pin = 1 WHERE id = "' .(int)$_GET['id']. '"';
	$unpin = 'UPDATE post SET pin = 0 WHERE id = "' .(int)$_GET['id']. '"';
    $postinf = mysqli_query($db, 'SELECT * FROM post WHERE id = "' .(int)$_GET['id']. '" AND id_user = "' .$_SESSION['user']. '"');

	if(mysqli_num_rows($postinf) == 1){
		if(mysqli_fetch_assoc($postinf)['pin'] == 1){
		 	if(mysqli_query($db, $unpin)){
		 		header("Location: " .$_SERVER['HTTP_REFERER']);
			} else {
				header("Location: " .$_SERVER['HTTP_REFERER']);
			}
		} elseif (mysqli_fetch_assoc($postinf)['pin'] == 0){
			if(mysqli_query($db, $pin)){
					header("Location: " .$_SERVER['HTTP_REFERER']);
			} else {
				header("Location: " .$_SERVER['HTTP_REFERER']);
			}
		} else {
			header("Location: " .$_SERVER['HTTP_REFERER']);
		}
	} else {
		header("Location: " .$_SERVER['HTTP_REFERER']);
	}
?>