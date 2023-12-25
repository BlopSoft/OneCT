<?php
	require_once "include/config.php";
?>

<!DOCTYPE html
<html lang='ru'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	<link rel="shortcut icon" href="<?php echo($favicon); ?>" type="image/x-icon">
    <title>Все пользователи</title>
    <link rel="stylesheet" href="<?php echo($style); ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
	<div class="header">
		<?php if(isset($_SESSION['user'])): ?>
			<a href="feed.php">Стена</a>
			<a href="index.php">Домой</a>
		<?php else : ?>
			<a href="feed.php">Стена</a>
			<a href="login.php">Войти</a>
			<a href="reg.php">Регистрироваться</a>
		<?php endif; ?>
	</div>
	<div class="main_app">
		<div class="main">
			<?php 
				$countUsers = mysqli_fetch_assoc(mysqli_query($db, 'SELECT COUNT(*) FROM users')); 
				echo '<p>На сайте всего: ' .$countUsers['COUNT(*)']. ' пользователей</p>'; 

				$allUsers = mysqli_query($db, 'SELECT id, name, priv, gif, color FROM users');
				
				while($list = mysqli_fetch_assoc($allUsers)){
					echo('<div class="user">');
						echo('<a href="user.php?id=' .$list['id']. '">');
							echo('<h1 style="color: '. $list['color']. '">');
								echo(strip_tags($list['name']));

								if(!empty(trim($list['gif']))){
									echo('<img height="32px" src="' .$list['gif']. '">');
								} else {
									echo('');
								} 

								if ($list['priv'] == 1){ 
									echo('<span title="Аккаунт официальный" class="material-symbols-outlined">done</span>'); 
								} else {
									echo('');
								}

							echo('</h1>');
						echo('</a>');
					echo('</div>');
				}
			?>
		</div>
	</div>
</body>
</html>
