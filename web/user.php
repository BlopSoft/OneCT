<?php
	require_once "../include/config.php";

	$all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = "' .(int)$_GET['id']. '"'));

	if($_SESSION['user'] == (int)$_GET['id']){
		header("Location: index.php");
	}

	if(isset($_POST['do_post'])){
		$errors = array('error' => "");
		
		if($enable_antispam == true){
			$stenka = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM post WHERE id_who = '" .$_SESSION['user']. "' ORDER BY id DESC"));
			$date = round((time() - strtotime($stenka['date'])));

			if($date < $antispam){
				$errors[] = "Не выкладывай слишком часто посты!";
			}
		}

		if(!$all['yespost'] == 1){
			$errors[] = 'OneConnect error: "Хочешь бана мамкин хакер?"';
		}

		if(!isset($_SESSION['user'])){
			$errors[] = 'OneConnect error: "Задолбал мамкин хакер"';
		}

		if(empty(trim(strip_tags($_POST['post'])))){
			$errors[] = "В посте нету текста!"; 
		}
		if(empty($errors)){
			$post = "INSERT INTO post(id_user, id_who, post) VALUES (
				'" .$_GET['id']. "',
				'" .$_SESSION['user']. "',
				'" .mysqli_real_escape_string($db, strip_tags($_POST['post'])). "
			')";

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
    <title>Пользователь <?php echo($all['name']); ?></title>
</head>
<body>
	<div class="header">
		<?php if(isset($_SESSION['user'])): ?>
			<a href="allusers.php">Все пользователи</a>
			<a href="feed.php">Стена</a>
			<a href="index.php">Домой</a>
		<?php else : ?>
			<a href="allusers.php">Все пользователи</a>
			<a href="feed.php">Стена</a>
			<a href="login.php">Войти</a>
			<a href="reg.php">Регистрироваться</a>
		<?php endif; ?>
	</div>
	<div class="main_app">
		<div class="main">
			<h1>
				<?php 
					echo(strip_tags($all['name'])); 

					if ($all['priv'] == 1){ 
						echo('<span title="Аккаунт официальный" class="material-symbols-outlined">done</span>'); 
					}
				?>
			</h1>
			<h1>Описание: <?php echo(strip_tags($all['descr'])); ?></h1>
		</div>
			<h1 class="head">Стена</h1>
			<div class="wall">
			<form action="user.php?id=<?php echo($_GET['id']); ?>" method="post" class="posting">
				<?php if(isset($_SESSION['user'])): ?>
					<?php if($all['yespost'] == "1"): ?>
						<textarea name="post" class="postarea"></textarea>
						<button type="submit" name="do_post" class="do_post">Опубликовать</button>
						<?php 
							if(!empty($errors)){
								echo ('<p>'.array_shift($errors).'</p>');
							}
						?>
					<?php else : ?>
						<p>Пользователь запретил добавлять посты других пользователей на свою стену</p>
					<?php endif; ?>
				<?php else : ?>
					<p>Нужно зарегистрироваться или войти в аккаунт чтобы публиковать посты в стену</p>
				<?php endif; ?>
			</form>
			<?php
				$stena = mysqli_query($db, "SELECT * FROM post WHERE id_user = '" .(int)$_GET['id']. "' ORDER BY pin DESC, date DESC"); 		
						
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
	</div>
</body>
</html>
