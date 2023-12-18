<?php
	require_once "../include/config.php";

	$delete = 'DELETE FROM post WHERE id = "' .(int)$_GET['id']. '"';
    $postinf = mysqli_query($db, 'SELECT * FROM post WHERE id = "' .(int)$_GET['id']. '" AND id_user = "' .$_SESSION['user']. '"');

	if(mysqli_num_rows($postinf) == 1){
		if(mysqli_query($db, $delete)){
			header("Location: " .$_SERVER['HTTP_REFERER']);
		} else {
			header("Location: " .$_SERVER['HTTP_REFERER']);
		}
	} else {
		header("Location: " .$_SERVER['HTTP_REFERER']);
	}
?>