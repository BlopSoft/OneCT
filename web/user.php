<?php
	require_once "../include/config.php";

	$all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .(int)$_SESSION['user']['user_id']));

	$data = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .(int)$_GET['id']));
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
	<script src="js/main.js"></script>
    <title><?php echo($lang_user_head . $data['name']); ?></title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
			<?php if((int)$_GET['id'] == $_SESSION['user']['user_id']): ?>
				<div class="changeuser">
					<?php if($all['priv'] == 3): ?>
						<a href="../admin"><?php echo($lang_admin); ?></a>
						| 
					<?php endif; ?>
					<a href="upload.php"><?php echo($lang_change_avatar); ?></a>
					 | 
					<a href="edit.php"><?php echo($lang_settings); ?></a>
				</div>
			<?php endif ?>
			<table class="user">
				<tr>
					<?php if($data['img200'] != NULL): ?>
						<td>
							<img class="img100" src="<?php echo($data['img200']); ?>">
						</td>
					<?php else: ?>
						<td><img class="img100" src="../imgs/blankimg.jpg"></td>
					<?php endif; ?>
					<td class="info">
						<h1>
							<?php 
								echo(strip_tags($data['name']).' '); 

								if($data['priv'] >= 1){
									echo('<img src="../imgs/verif.gif">');
								}
							?>
						</h1>
					</td>
				</tr>
			</table>
			<h1><?php echo($lang_description); ?><?php echo(preg_replace('/(https?:\/\/\S+)/', '<a href="$1">$1</a>', $data['descr'])); ?></h1>
		</div>
		<h1 class="head"><?php echo($lang_wall); ?></h1>
		<div class="wall">
			<?php if(isset($_SESSION['user']) and $data['yespost'] == 1 or (int)$_GET['id'] == $_SESSION['user']['user_id']): ?>
				<form action="../methods/makepost.php" method="post" class="posting" enctype="multipart/form-data">
					<input type="hidden" name="access_token" value="<?php echo($_SESSION['user']['access_token']); ?>">
					<input type="hidden" name="owner_id" value="<?php echo((int)$_GET['id']); ?>">
					<textarea name="text" class="postarea" minlength="3"></textarea>
					<button type="submit" name="do_post" class="do_post"><?php echo($lang_publish); ?></button>
					<div class="detail">
						<a class="openmenu" href="javascript:showmenu();">
							<img src="../imgs/close.gif" id="detailicon">
							<?php echo($lang_attach); ?>
						</a>
						<div id="menu">
							<p><?php echo($lang_image); ?></p>
							<input type="file" name="file" class="file" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp">
						</div>
					</div>
					<?php if(isset($_SESSION['error'])): ?>
						<p class="error"><?php echo($_SESSION['error']); ?></p>
						<?php unset($_SESSION['error']) ?>
					<?php endif; ?>
				</form> 
			<?php endif; ?>
			
			<?php $data = mysqli_query($db, 'SELECT * FROM post WHERE id_user = ' .(int)$_GET['id']. ' ORDER BY pin DESC, date DESC LIMIT 10 OFFSET ' .(int)$_GET['p'] * 10); ?>
			
			<?php while($list = mysqli_fetch_assoc($data)): ?>

				<?php $likes = mysqli_num_rows(mysqli_query($db, 'SELECT * FROM likes WHERE post_id = ' .$list['id'])); ?>

				<div class="block" id="post<?php echo($list['id']); ?>">

					<?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['id_user'])); ?>
					
					<b>
						<a class="user" href="user.php?id=<?php echo($list['id_user']); ?>">
							<?php echo($user['name']); ?>
						</a>
					</b>

					<?php
						if($list['pin'] == 1){
							echo($lang_pinned);
						}
					?>

					<?php if($list['id_user'] == $_SESSION['user']['user_id'] or $list['id_who'] == $_SESSION['user']['user_id'] or $all['priv'] >= 2): ?>
						<div class="buttons">
							<a href="../methods/pinpost.php?id=<?php echo($list['id']); ?>">
								<img src="../imgs/pin.gif" alt="pin ">
							</a>
							<a href="../methods/delpost.php?id=<?php echo($list['id']); ?>">
								<img src="../imgs/del.gif" alt="delete ">
							</a>
						</div>
					<?php endif; ?><br>

					<span class="date">
						<?php echo(date($lang_date, $list['date'])); ?>
					</span><br>

					<?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['id_who'])); ?>
					<b><?php echo($lang_byname); ?>
						<a class="user" href="user.php?id=<?php echo($list['id_who']); ?>">
							<?php echo($user['name']); ?>
						</a>
					</b>

					<?php 
						if($list['img'] != NULL){
							echo('<img class="img" src="' .$list['img']. '">');
						}
					?>

					<p><?php echo(preg_replace('/(https?:\/\/\S+)/', '<a href="$1">$1</a>', strip_tags($list['post']))); ?></p>

					<?php if(isset($_SESSION['user'])): ?>
						<?php $yourlike = mysqli_num_rows(mysqli_query($db, 'SELECT * FROM likes WHERE post_id = ' .$list['id']. ' AND user_id = ' .$_SESSION['user']['user_id'])); ?>

						<div class="buttons" <?php if($yourlike != 0) echo('id="selected"'); ?>>
							<a href="../methods/likepost.php?id=<?php echo($list['id']); ?>">
								<img src="../imgs/like<?php if($yourlike != 0) echo('_sel'); ?>.gif" alt="like ">
								<span class="likecount"><?php echo($likes); ?></span>
							</a>
						</div>
					<?php else: ?>
						<div class="buttons">
							<a class="like">
								<img src="../imgs/like.gif" alt="like ">
								<span class="likecount"><?php echo($likes); ?></span>
							</a>
						</div>
					<?php endif; ?><br>
				</div>
				<div class="opencom">
					<a href="comments.php?id=<?php echo($list['id']); ?>">
						Открыть комментарии (<?php echo(mysqli_num_rows(mysqli_query($db, 'SELECT * FROM comments WHERE post_id = ' .(int)$list['id']))); ?>)
					</a>
				</div>
			<?php endwhile; ?>

			<?php if(mysqli_num_rows($data) == 0): ?>
				<h1 class="error"><?php echo($lang_nowall); ?></h1>
			<?php endif; ?>

			<div class="pages">
				<?php if((int)$_GET['p'] >= 1): ?>
					<a class="back" href="?id=<?php echo((int)$_GET['id']); ?>&p=<?php echo((int)$_GET['p'] - 1); ?>"><?php echo($lang_previous); ?></a>
				<?php endif; ?>
				<?php if(mysqli_num_rows($data) == 10): ?>
					<a class="next" href="?id=<?php echo((int)$_GET['id']); ?>&p=<?php echo((int)$_GET['p'] + 1); ?>"><?php echo($lang_next); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>

<?php mysqli_close($db);