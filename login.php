<?php
	require_once "include/config.php";

	if(isset($_POST['do_login'])){
		$errors = array();
		$user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users where email ="' .$_POST['email']. '"'));

		if(count($user) != 0){
			if(password_verify($_POST['pass'], $user['pass'])){
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
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	<link rel="shortcut icon" href="<?php echo($favicon); ?>" type="image/x-icon">
    <title>Вход</title>
    <link rel="stylesheet" href="<?php echo($style); ?>">
</head>
<body>
	<div class="header">
		<a href="reg.php">Регестрироваться</a>
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