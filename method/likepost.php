<?php
	require_once "../include/config.php";
	include '../include/user.php';

	$like = 'INSERT INTO likes (post_id, user_id) VALUES (' .(int)$_GET['id']. ', ' .$_SESSION['user']['user_id']. ')';
	$unlike = 'DELETE FROM likes WHERE post_id = ' .(int)$_GET['id']. ' AND user_id =' .$_SESSION['user']['user_id'];
    $likeinf = mysqli_query($db, 'SELECT * FROM likes WHERE post_id = ' .(int)$_GET['id']. ' AND user_id =' .$_SESSION['user']['user_id']);
	$likedata = mysqli_fetch_assoc($likeinf);

	if(token_data($_SESSION['user']['access_token'])['error'] == 0){
		if(!empty($likedata)){
			mysqli_query($db, $unlike);
			header("Location: " .$_SERVER['HTTP_REFERER']. "#post" .(int)$_GET['id']);
		} elseif(empty($likedata)){
			mysqli_query($db, $like);
			header("Location: " .$_SERVER['HTTP_REFERER']. "#post" .(int)$_GET['id']);
		}
	} else {
		$error = "Bad request / token";
	}

	echo($error);
?>