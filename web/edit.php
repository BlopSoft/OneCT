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
					<input placeholder="Имя" name="username" value="<?php echo $data['name']; ?>"><br><br>
					<textarea placeholder="Описание" name="descr"><?php echo $data['descr']; ?></textarea><br><br>
					<select name="yespost">
						<option selected value="0">Разрешить писать на моей стене</option>
						<option value="0">Нельзя</option>
						<option value="1">Можно</option>
					</select><br><br>
					<select name="theme">
						<option selected value="md3">Тема оформления</option>
						<option value="md1">Material Design 1</option>
						<option value="md3">Material You</option>
					</select><br><br>
					<button type="submit" name="do_change">Изменить</button>
			</form>
		</div>
	</div>
</body>
</html>