<?php
	require_once "include/config.php";

	$all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = "' .$_SESSION['user']. '"'));
?>

<!DOCTYPE html
<html lang="ru">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	<link rel="shortcut icon" href="<?php echo($favicon); ?>" type="image/x-icon">
    <title>Изменение аккаунта</title>
    <link rel="stylesheet" href="<?php echo($style); ?>">
</head>
<body>
	<div class="header">
		<a href="allusers.php">Все пользователи</a>
		<a href="index.php">Домой</a>
	</div>
	<div class="main_app">
		<div class="main">
			<form action="change.php" method="POST">
				<p>
					<p>Ник:</p>
					<input name="username" value="<?php echo $all['name']; ?>">
				</p>
				<p>
					<p>Описание:</p>
					<textarea name="descr"><?php echo $all['descr']; ?></textarea>
				</p>
				<p>
					<p>Цвет имени:</p>
					<input name="color" value="<?php echo $all['color']; ?>">
				</p>
				<p>
					<p>gif-статус:</p>
					<textarea name="gif"><?php echo $all['gif']; ?></textarea>
				</p>
				<p>
					<p>Разрешить публиковать посты другим:</p>
					<p>Можно:
					<input type="radio" name="yespost" value="1">
					Нельзя:
					<input type="radio" name="yespost" value="0"></p>
				</p>
				<p>
					<button type="submit" name="do_change">Изменить</button>
				</p>
				<a href="/delete.php">Удаление аккаунта</a>
			</form>
			<?php 
				$change = "UPDATE users SET 
					name = '" .mysqli_real_escape_string($db, strip_tags($_POST['username'])). "', 
					descr = '" .mysqli_real_escape_string($db, strip_tags($_POST['descr']))."', 
					gif = '" .mysqli_real_escape_string($db, $_POST['gif']). "', 
					yespost = '" .$_POST['yespost']. "', 
					color = '" .mysqli_real_escape_string($db, $_POST['color']). "' 
					WHERE id = '" .$_SESSION['user']. "'";
			
				if(isset($_POST['do_change'])){
					if(mysqli_query($db, $change)){
						echo('<p>Информация изменена!</p>');
					} else {
						echo('<p>Произошла ошибка</p>');
					}
				}
			?>
		</div>
	</div>
</body>
</html>