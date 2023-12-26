<?php
	require_once "../include/config.php";

	if(isset($_SESSION['user'])){
		header("Location: index.php");
	}

	if(isset($_POST['do_login'])){
		$text = array('text' => "");

		$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users where email ='" .mysqli_real_escape_string($db, $_POST['email']). "'"));

		if(!password_verify($_POST['pass'], $user['pass'])){
			$text['text'] = "Пароль не верный!";
		}

		if(empty($user)){
			$text['text'] = "Пользователь не найден!";
		}

		if(empty(trim($text['text']))){
			$_SESSION['user'] = $user['id'];
			header("Location: index.php");
		}
	}
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Вход</title>
</head>
<body>
	<div class="header">
		<a href="reg.php">Регистрироваться</a>
	</div>
	<div class="main_app">
		<div class="main">
			<form action="login.php" method="POST">
				<p>
					<p>Логин:</p>
					<input type="email" name="email">
				</p>
				<p>
					<p>Пароль:</p>
					<input type="password" name="pass">
				</p>
				<p>
					<button type="submit" name="do_login">Войти</button>
				</p>
			</form>
			<p><?php echo($text['text']); ?></p>
		</div>
	</div>
</body>
</html>
