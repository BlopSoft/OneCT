<?php
	require_once "../include/config.php";

	$all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = "' .$_SESSION['user']. '"'));

	mysqli_query($db, "UPDATE users SET ip = '" .$_SERVER['REMOTE_ADDR']."' WHERE id = '" .$_SESSION['user']. "'");

	if(isset($_POST['do_post'])){
		$errors = array('error' => "");

		if($enable_antispam == true){
			$stenka = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM post WHERE id_who = '" .$_SESSION['user']. "' ORDER BY pin DESC, date DESC"));
			$date = round((time() - strtotime($stenka['date'])));

			if($date < $antispam){
				$errors['error'] = "Не выкладывай слишком часто посты!";
			}
		}

		if(empty(trim(strip_tags($_POST['post']))) and empty(trim($_POST['img']))){
			$errors['error'] = "В посте ничего нету!"; 
		}

		if(empty($errors)){
			$post = "INSERT INTO post(id_user, id_who, post, img) VALUES (
				'" .$_SESSION['user']. "',
				'" .$_SESSION['user']. "',
				'" .mysqli_real_escape_string($db, strip_tags($_POST['post'])). "'
			)";

			if(mysqli_query($db, $post)){
				sleep(1);
				header("Location: ");
			}
		}
	}
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title><?php echo($sitename); ?></title>
</head>
<body>
	<div class="header">
		<?php if(isset($_SESSION['user'])): ?>
			<a href="allusers.php">Все пользователи</a>
			<a href="feed.php">Стена</a>
			<a href="logout.php">Выйти</a>
		<?php else : ?>
			<a href="allusers.php">Все пользователи</a>
			<a href="feed.php">Стена</a>
			<a href="login.php">Войти</a>
			<a href="reg.php">Регистрироваться</a>
		<?php endif; ?>
	</div>
	<div class="main_app">
		<div class="main">
			<?php if(isset($_SESSION['user'])): ?>
				<div class="changeuser">
					<a href="change.php">Изменить аккаунт</a>
				</div>
				<h1>
					<?php 
						echo(strip_tags($all['name']));

						if ($all['priv'] == 1){ 
							echo('<span title="Аккаунт официальный" class="material-symbols-outlined">done</span>'); 
						}
					?>
				</h1>
				<h1>Почта: <?php echo $all['email']; ?></h1>
				<h1>О себе: <?php echo(strip_tags($all['descr'])); ?></h1>
				</div>
				<h1 class="head">Стена</h1>
				<div class="wall">
					<form action="index.php" method="post" class="posting">
						<textarea name="post" class="postarea"></textarea>
						<button type="submit" name="do_post" class="do_post">Опубликовать</button>
						<?php 
							if(!empty($errors)){
								echo ('<p>'.array_shift($errors).'</p>');
							}
						?>
					</form>
					<?php
						$stena = mysqli_query($db, "SELECT * FROM post WHERE id_user = '" .$_SESSION['user']. "' ORDER BY pin DESC, date DESC");	 		
						
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

								<a href="../method/delpost.php?id=' .$list['id']. '">
									<span class="material-symbols-outlined">
										close
									</span>
								</a>

								<a href="../method/pinpost.php?id=' .$list['id']. '">
									<span class="material-symbols-outlined">
										push_pin
									</span><br>
								</a>

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
										echo('<img width="100%" src="' .($list['img']). '">');
									} 
								?>

								<p><?php echo(strip_tags($list['post'])); ?></p>
							</div>
						<?php
						endwhile;
					?>
				</div>
			<?php else : ?>
				<h1>Добро пожаловать в <?php echo($sitename); ?>!</h1>
				<p>Для использования платформы <?php echo($sitename); ?> необходимо пройти авторизацию</p>
			<?php endif; ?>
	</div>
</body>
</html>
