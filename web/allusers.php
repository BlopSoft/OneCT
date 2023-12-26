<?php
	require_once "../include/config.php";
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Все пользователи</title>
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
				$allUsers = mysqli_query($db, 'SELECT id, name, priv, gif, color FROM users');
				
				while($list = mysqli_fetch_assoc($allUsers)){
					echo('<div class="user">');
						echo('<a href="user.php?id=' .$list['id']. '">');
							echo('<h1>');
								echo(strip_tags($list['name']));

								if ($list['priv'] == 1){ 
									echo('<span title="Аккаунт официальный" class="material-symbols-outlined">done</span>'); 
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
