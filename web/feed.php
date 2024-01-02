<?php
	require_once "../include/config.php";

	if(empty($_SESSION['user'])){
		header("Location: login.php");
	}
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Стена</title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
		<div class="main_app">
		<div class="wall">
				<?php if(isset($_SESSION['user'])): ?>
					<form action="../method/makepost.php" method="post" class="posting" enctype="multipart/form-data">
						<input type="hidden" name="access_token" value="<?php echo($_SESSION['user']['access_token']); ?>">
						<input type="hidden" name="owner_id" value="<?php echo($_SESSION['user']['user_id']); ?>">
						<textarea name="text" class="postarea" minlength="3"></textarea>
						<button type="submit" name="do_post" class="do_post">Опубликовать</button>
						<details class="detail">
							<summary>Прикрепить</summary>
							<input type="file" name="file">
						</details>
					</form>
				<?php endif; ?>
				<?php 
					$data = mysqli_query($db, 'SELECT * FROM post ORDER BY date DESC LIMIT 10 OFFSET ' .(int)$_GET['p'] * 10);
				?>
				<?php while($list = mysqli_fetch_assoc($data)): ?>
					<div class="post">

						<?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['id_user'])); ?>
						<b>
							<a class="user" href="user.php?id=<?php echo($list['id_user']); ?>">
								<?php echo($user['name']); ?>
							</a>
						</b>

						<span class="date">
							<?php echo(date('d M Y в H:i', $list['date'])); ?>
						</span><br>

						<?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['id_who'])); ?>
						<b>От имени: 
							<a class="user" href="user.php?id=<?php echo($list['id_who']); ?>">
								<?php echo($user['name']); ?>
							</a>
						</b>

						<?php 
							if($list['img'] != NULL){
								echo('<img src="' .$list['img']. '">');
							}
						?>

						<p><?php echo(strip_tags($list['post'])); ?></p>
					</div>
				<?php endwhile; ?>
				<?php if((int)$_GET['p'] >= 1): ?>
					<a class="back" href="?id=<?php echo((int)$_GET['id']); ?>&p=<?php echo((int)$_GET['p'] - 1); ?>">Предыдущая страница</a>
				<?php endif; ?>
				<a class="next" href="?p=<?php echo((int)$_GET['p'] + 1); ?>">Следующая страница</a>
			</div>
		</div>
	</div>
</body>
</html>
