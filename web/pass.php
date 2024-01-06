<?php
	require_once "../include/config.php";

	if(empty($_SESSION['user'])){
		header("Location: login.php");
	}

	$change = "UPDATE users SET pass = '" .password_hash($_POST['pass'], PASSWORD_DEFAULT). "' WHERE id = '" .$_SESSION['user']['user_id']. "'";
	
	if(isset($_POST['do_change'])){
		if($_POST['pass'] != $_POST['pass2']){
			$error = '2 пароль не верный';
		}

		if(empty(trim($_POST['pass']))){
			$error = 'Пароль пустой';
		}
		
		if(empty($error)){
			mysqli_query($db, $change);
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
			<form action="pass.php" method="POST">
				<p>
					<p>Пароль: </p>
					<input type="password" name="pass">
				</p>
				<p>
					<p>Повторите пароль:</p>
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