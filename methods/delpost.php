<?php
	require_once "../include/config.php";
	include '../include/user.php';

	$delete = 'DELETE FROM post WHERE id = "' .(int)$_GET['id']. '"';
    $postinf = mysqli_query($db, 'SELECT * FROM post WHERE id = ' .(int)$_GET['id']);
	$postdata = mysqli_fetch_assoc($postinf);

	$user_data = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .$_SESSION['user']['user_id']));

	if(token_data($_SESSION['user']['access_token'])['error'] == 0){
		if($postdata['id_user'] or $postdata['id_who'] == $_SESSION['user']['user_id'] or $user_data['priv'] >= 2){
			if(mysqli_query($db, $delete)){
				mysqli_query($db, 'DELETE FROM likes WHERE post_id = ' .(int)$_GET['id']);
				mysqli_query($db, 'DELETE FROM comments WHERE post_id = ' .(int)$_GET['id']);
				unlink($postdata['img']);
				header("Location: " .$_SERVER['HTTP_REFERER']);
			}
		}
	} else {
		http_response_code(400);
		$error = "Bad request / token";
	}

	echo($error);
?>