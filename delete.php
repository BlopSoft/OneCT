<?php
	require_once "include/config.php";

	$delete = 'DELETE FROM users WHERE id = "' .$_SESSION['user']. '"';

	if(isset($_POST['do_del'])){
		if(mysqli_query($db, $delete)){
			unset($_SESSION['user']);
			header("Location: index.php");
		}
	}

	if(isset($_POST['do_no'])){
		header("Location: index.php");
	}

?>

<!DOCTYPE html
<html lang="ru">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	<link rel="shortcut icon" href="<?php echo($favicon); ?>" type="image/x-icon">
    <title>Удаление аккаунта</title>
    <link rel="stylesheet" href="<?php echo($style); ?>">
</head>
<body>
	<div class="header">
		<a href="allusers.php">Все пользователи</a>
		<a href="index.php">Домой</a>
	</div>
	<div class="main_app">
		<div class="main">
			<form action="delete.php" method="POST">
				<p>
					<h1>ВЫ ТОЧНО ХОТИТЕ УДАЛИТЬ АККАУНТ?</h1>
				</p>
				<p>
					<button type="submit" name="do_del">Да</button>
					<button type="submit" name="do_no">Нет</button>
				</p>
			</form>
		</div>
	</div>
</body>
</html>