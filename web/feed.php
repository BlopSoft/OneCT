<?php
	require_once "../include/config.php";

	$all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .(int)$_SESSION['user']['user_id']));

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
							<p>Картинка:</p>
							<input type="file" name="file" class="file" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp">
						</details>
						<?php if(isset($_SESSION['error'])): ?>
							<p class="error"><?php echo($_SESSION['error']); ?></p>
							<?php unset($_SESSION['error']) ?>
						<?php endif; ?>
					</form>
				<?php endif; ?>

				<?php $data = mysqli_query($db, 'SELECT * FROM post ORDER BY date DESC LIMIT 10 OFFSET ' .(int)$_GET['p'] * 10); ?>

				<?php while($list = mysqli_fetch_assoc($data)): ?>
					
					<?php $likes = mysqli_num_rows(mysqli_query($db, 'SELECT * FROM likes WHERE post_id = ' .$list['id'])); ?>
					<?php $yourlike = mysqli_num_rows(mysqli_query($db, 'SELECT * FROM likes WHERE post_id = ' .$list['id']. ' AND user_id = ' .$_SESSION['user']['user_id'])); ?>

					<div class="post" id="post<?php echo($list['id']); ?>">

						<?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['id_user'])); ?>
						<b>
							<a class="user" href="user.php?id=<?php echo($list['id_user']); ?>">
								<?php echo($user['name']); ?>
							</a>
						</b>

						<?php if($all['priv'] >= 2): ?>
							<div class="buttons">
								<a href="../method/delpost.php?id=<?php echo($list['id']); ?>">
									<span class="material-symbols-outlined">
										close
									</span>
								</a>
							</div>
						<?php endif; ?><br>

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
								echo('<img class="img" src="' .$list['img']. '">');
							}
						?>

						<p><?php echo(strip_tags($list['post'])); ?></p>

						<?php if(isset($_SESSION['user'])): ?>
							<div class="buttons" <?php if($yourlike != 0){ echo('id="selected"'); }; ?>>
								<a href="../method/likepost.php?id=<?php echo($list['id']); ?>">
									<span class="material-symbols-outlined">
										thumb_up
									</span>
									<span class="likecount"><?php echo($likes); ?></span>
								</a>
							</div>
						<?php endif; ?><br>
					</div>
				<?php endwhile; ?>
				<div class="pages">
					<?php if((int)$_GET['p'] >= 1): ?>
						<a class="back" href="?p=<?php echo((int)$_GET['p'] - 1); ?>">Предыдущая страница</a>
					<?php endif; ?>
					<?php if(mysqli_num_rows($data) == 10): ?>
						<a class="next" href="?p=<?php echo((int)$_GET['p'] + 1); ?>">Следующая страница</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>
