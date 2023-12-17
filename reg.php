<?php
	require_once "include/config.php";
?>

<!DOCTYPE html
<html lang='ru'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	<link rel="shortcut icon" href="<?php echo($favicon); ?>" type="image/x-icon">
    <title>Регистрация</title>
    <link rel="stylesheet" href="<?php echo($style); ?>">
</head>
<body>
	<div class="header">
		<a href="login.php">Войти</a>
	</div>
	<div class="main">
		<form action="reg.php" method="POST">
			<p>
				<p>Ваш ник (Максимум 16 букв):</p>
				<input type="text" name="username" value="<?php echo $_POST['username']; ?>">
			</p>
			<p>
				<p>Ваша электронная почта:</p>
				<input type="email" name="email" value="<?php echo $_POST['email']; ?>">
			</p>
			<p>
				<p>Ваш пароль (Максимум 20 букв):</p>
				<input type="password" name="pass" value="<?php echo $_POST['pass']; ?>">
			</p>
			<p>
				<p>Повторить ваш пароль:</p>
				<input type="password" name="pass2">
			</p>
			<p>
				<p>Описание вашего аккаунта:</p>
				<textarea name="descr"></textarea>
			</p>
			<p>
				<button type="submit" name="do_signup">Зарегестрироваться</button>
			</p>
		</form>
		<?php 
			$checkemail = 'SELECT email FROM users WHERE email = "' .$_POST['email']. '"';
			$checkip = 'SELECT ip FROM users WHERE ip = "' .$_SERVER['REMOTE_ADDR']. '"';
			$createacc = 'INSERT INTO users(name, email, pass, ip, descr) VALUES (
				"' .$_POST['username']. '", 
				"' .$_POST['email']. '", 
				"' .password_hash($_POST['pass'], PASSWORD_DEFAULT). '", 
				"' .$_SERVER['REMOTE_ADDR']. '", 
				"' .$_POST['descr']. '")';
					
			if(isset($_POST['do_signup'])){
				$errors = array();
				if(trim($_POST['username']) == '' ){
					$errors[] = 'Введите свой ник!';
				}
				
				if(trim($_POST['email']) == '' ){
					$errors[] = 'Введите свою email почту!';
				}
				
				if(trim($_POST['pass']) == '' ){
					$errors[] = 'Введите свой пароль!';
				}	
				
				if($_POST['pass2'] != $_POST['pass'] ){
					$errors[] = 'Повторный пароль введён неверно!';
				}
				
				if(count((mysqli_fetch_assoc(mysqli_query($db, $checkemail)))) != 0){
					$errors[] = 'Email почта занятя!';
				}	
				
				if(count(mysqli_fetch_assoc(mysqli_query($db, $checkip))) != 0){
					$errors[] = 'Вы уже зарегестрированы!';
				}

				if(empty($errors)){
					if(mysqli_query($db, $createacc)){
						echo('<p>Вы успешно зарегестрироавны!</p>');
					}
				} else {
					echo ('<p>'.array_shift($errors).'</p>');
				}
			}	
		?>
	</div>
</body>
</html>