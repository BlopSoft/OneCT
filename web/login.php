<?php
	require_once "../include/config.php";

	if(isset($_POST['do_login'])){
		$errors = array();
		$user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users where email ="' .mysqli_real_escape_string($db, $_POST['email']). '"'));

		if(count($user) != 0){
			if(password_verify(mysqli_real_escape_string($db, $_POST['pass']), $user['pass'])){
				$_SESSION['user'] = $user['id'];
				header("Location: index.php");
			} else {
				$errors[] = 'Пароль не верный!';
			}
		} else {
			$errors[] = 'Пользователь не найден!';
		}
	}
?>

<!DOCTYPE html
<html lang='ru'>
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
		</div>
		<div>
			<?php 
				if(!empty($errors))  {
					echo ('<p>'.array_shift($errors).'</p>');
				}
			?>
		</div>
	</div>
</body>
</html>
