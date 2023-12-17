<?php
	require_once "include/config.php";

	$all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = "' .$_GET['id']. '"'));

	if($_SESSION['user'] == $_GET['id']){
		header("Location: index.php");
	}

	if(isset($_POST['do_post'])){
		$stenka = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM post WHERE id_who = '" .$_SESSION['user']. "' ORDER BY id DESC"));
		$date = round((time() - strtotime($stenka['date'])));
		$errors = array();

		if(!$all['yespost'] == 1){
			$errors[] = 'OneConnect error: "Хочешь бана мамкин хакер?"';
		}

		if(!isset($_SESSION['user'])){
			$errors[] = 'OneConnect error: "Задолбал мамкин хакер"';
		}

		if(empty(trim(strip_tags($_POST['post'])))){
			$errors[] = "В посте нету текста!"; 
		}

		if($date < $antispam){
			$errors[] = "Не выкладывай слишком часто посты!";
	   	}

		if(empty($errors)){
			$post = "INSERT INTO post(id_user, id_who, post) VALUES (
				'" .$_GET['id']. "',
				'" .$_SESSION['user']. "',
				'" .strip_tags($_POST['post']). "')";

			if(mysqli_query($db, $post)){
				header("Location: ");
			}
		}
	}
?>

<!DOCTYPE html
<html lang='ru'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	<link rel="shortcut icon" href="<?php echo($favicon); ?>" type="image/x-icon">
    <title>Пользователь <?php echo($all['name']); ?></title>
    <link rel="stylesheet" href="<?php echo($style); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
			<a href="reg.php">Регестрироваться</a>
		<?php endif; ?>
	</div>
	<div class="main">
		<h1 style="color: <?php echo($all['color']); ?>;">
			<?php echo(strip_tags($all['name'])); ?>
			<?php 
				if(!empty(trim($all['gif']))){
					echo('<img height="32px" src="' .$all['gif']. '">');
				} else {
					echo('');
				} 
			?>
			<?php 
				if ($all['priv'] == 1){ 
					echo('<span title="Аккаунт официальный" class="material-symbols-outlined">done</span>'); 
				} else {
					echo('');
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
				<p>Нужно зарегестрироваться или войти в аккаунт чтобы публиковать посты в стену</p>
			<?php endif; ?>
		</form>
		<?php
			$stena = mysqli_query($db, "SELECT * FROM post WHERE id_user = '" .$_GET['id']. "' ORDER BY pin DESC, date DESC");	 		
			
			while($list = mysqli_fetch_assoc($stena)){
				echo('<div class="post">');

				$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT name, id FROM users WHERE id = '" .$list['id_user']. "'"));
					
					echo('<b>');
						echo('<a class="user" href="user.php?id=' .$user['id']. '">');
							echo(strip_tags($user['name']));
						echo('</a>');
					echo('</b>');

					if($list['pin'] == 1){
						echo('  Закреплено');
					} else {
						echo('');
					}

					echo('<br>');

					echo('<span class="date">');
						echo($list['date']);
					echo('</span><br>');	

				$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT name, id FROM users WHERE id = '" .$list['id_who']. "'"));

					echo('<b>От имени: ');
						echo('<a class="user" href="user.php?id=' .$user['id']. '">');
							echo(strip_tags($user['name']));
						echo('</a>');
					echo('</b>');

						if(!empty(trim($list['img']))){
							echo('<img width="100%" src="' .$list['img']. '">');
						} else {
							echo('');
						}

						echo('<p>' .strip_tags($list['post']). '</p>');
				echo('</div>');
			};
		?>
	</div>
</body>
</html>