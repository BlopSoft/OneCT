<?php
	require_once "../include/config.php";
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Стена</title>
</head>
<body>
	<div class="header">
		<?php if(isset($_SESSION['user'])): ?>
			<a href="allusers.php">Все пользователи</a>
			<a href="index.php">Домой</a>
		<?php else : ?>
			<a href="allusers.php">Все пользователи</a>
			<a href="login.php">Войти</a>
			<a href="reg.php">Регистрироваться</a>
		<?php endif; ?>
	</div>
	<div class="main_app">
		<?php
			$stena = mysqli_query($db, "SELECT * FROM post ORDER BY date DESC"); 		
					
			while($list = mysqli_fetch_assoc($stena)):
			?>
			<div class="post">
				<?php $user = mysqli_fetch_assoc(mysqli_query($db, "SELECT name, id FROM users WHERE id = '" .$list['id_user']. "'")); ?>

				<b>
					<a class="user" href="user.php?id=' .$user['id']. '">
						<?php echo(strip_tags($user['name'])); ?>
					</a>
				</b>

				<?php 
					if($list['pin'] == 1){
						echo('  Закреплено');
					} 
				?>

				<span class="date">
					<?php echo($list['date']); ?>
				</span><br>	

				<?php $user = mysqli_fetch_assoc(mysqli_query($db, "SELECT name, id FROM users WHERE id = '" .$list['id_who']. "'")); ?>

				<b>От имени: 
					<a class="user" href="user.php?id=' .$user['id']. '">
						<?php echo(strip_tags($user['name'])); ?>
					</a>
				</b>

				<?php 
					if(!empty(trim($list['img']))){
						echo('<img width="100%" src="' .$list['img']. '">');
					} 
				?>

				<p><?php echo(strip_tags($list['post'])); ?></p>
			</div>
		<?php
			endwhile;
		?>
	</div>
</body>
</html>
