<?php
	require_once "../include/config.php";

	if(empty($_SESSION['user'])){
		header("Location: login.php");
	}

	$change = "UPDATE users SET pass = '" .password_hash($_POST['pass'], PASSWORD_DEFAULT). "' WHERE id = '" .$_SESSION['user']['user_id']. "'";
	$user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT pass FROM users where id = ' .(int)$_SESSION['user']['user_id']));

	if(isset($_POST['do_change'])){
		if(!password_verify($_POST['oldpass'], $user['pass'])){
			$error = 'Старый пароль не верный!';
		}

		if($_POST['pass'] != $_POST['pass2']){
			$error = '2 пароль не верный';
		}

		if(empty(trim($_POST['pass']))){
			$error = 'Пароль пустой';
		}
		
		if(empty($error)){
			mysqli_query($db, $change);
			header("Location: logout.php");
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
			<h1>После смены пароля вы должны перезайти в аккаунт!</h1>
			<form action="pass.php" method="POST">
				<p>
					<p>Старый Пароль: </p>
					<input type="password" name="oldpass">
				</p>
				<p>
					<p>Новый Пароль: </p>
					<input type="password" name="pass">
				</p>
				<p>
					<p>Повторите новый пароль:</p>
					<input type="password" name="pass2">
				</p>
				<p>
					<button type="submit" name="do_change">Изменить пароль</button>
				</p>
			</form>
			<p><?php echo($error); ?></p>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>
<?php mysqli_close($db);