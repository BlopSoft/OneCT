<?php
	require_once "../include/config.php";

	if(isset($_SESSION['user'])){
		header("Location: $url/web");
	}

	if(isset($_POST['do_login'])){
		$data = json_decode(file_get_contents($url. '/api/token.php?username=' .$_POST['username']. '&password=' .$_POST['password']. '&grant_type=password'), true);

		if(empty($data['error_code'])){
			$_SESSION['user'] = $data;

			header("Location: $url");
		} else {
			$error = $data['error_msg'];
		}
	}
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Вход</title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
			<form action="login.php" method="POST">
				<p>
					<p>Логин:</p>
					<input type="email" name="username">
				</p>
				<p>
					<p>Пароль:</p>
					<input type="password" name="password">
				</p>
				<p>
					<button type="submit" name="do_login">Войти</button>
				</p>
			</form>
			<p><?php echo($error); ?></p>
		</div>
	</div>
</body>
</html>