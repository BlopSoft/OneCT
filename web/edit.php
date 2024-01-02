<?php
	require_once "../include/config.php";

	if(empty($_SESSION['user'])){
		header("Location: login.php");
	}

	$data = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .$_SESSION['user']['user_id']));

	$change = "UPDATE users SET 
		name = '" .mysqli_real_escape_string($db, strip_tags($_POST['username'])). "', 
		descr = '" .mysqli_real_escape_string($db, strip_tags($_POST['descr']))."', 
		yespost = '" .(int)$_POST['yespost']. "'
		WHERE id = '" .$_SESSION['user']['user_id']. "'";
	
	if(isset($_POST['do_change'])){
		if(mysqli_query($db, $change)){
			$_SESSION['theme'] = $_POST['theme'];
			header("Location: $url");
		}
	}
?>
<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Изменение аккаунта</title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
			<form action="edit.php" method="POST">
				<p>
					<p>Имя: </p>
					<input type="text" name="username" value="<?php echo $data['name']; ?>">
				</p>
				<p>
					<p>Описание:</p>
					<textarea name="descr"><?php echo $data['descr']; ?></textarea>
				</p>
				<p>
					<p>Разрешить писать на моей стене:</p>
					<select name="yespost">
						<option value="0">Нельзя</option>
						<option value="1">Можно</option>
					</select>
				</p>
				<p>
					<p>Тема оформления:</p>
					<select name="theme">
						<option value="md1">Material Design 1</option>
						<option value="md3">Material You</option>
					</select>
				</p>
				<p>
					<button type="submit" name="do_change">Изменить</button>
				</p>
			</form>
		</div>
	</div>
</body>
</html>