<?php
	require_once "../include/config.php";

	if(empty($_SESSION['user'])){
		header("Location: login.php");
	}
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title><?php echo($lang_search); ?></title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
			<form action="search.php" method="get">
				<input type="text" placeholder="<?php echo($lang_search); ?>" value="<?php echo($_GET['q']) ?>" name="q">
			</form>

			<?php 
				if(isset($_GET['q'])){
					$allUsers = mysqli_query($db, 'SELECT id, name, priv, img200 FROM users WHERE name LIKE "%' .mysqli_real_escape_string($db, $_GET['q']). '%" ORDER BY id DESC'); 
				} else {
					$allUsers = mysqli_query($db, 'SELECT id, name, priv, img200 FROM users ORDER BY id DESC'); 
				}
			?>

			<p><?php echo($lang_find . mysqli_num_rows($allUsers) . $lang_find_users); ?></p>

			<?php while($list = mysqli_fetch_assoc($allUsers)): ?>
				<table class="user">
					<tr>
						<?php if($list['img200'] != NULL): ?>
							<td><img class="img100" src="<?php echo($list['img200']); ?>"></td>
						<?php else: ?>
							<td><img class="img100" src="../imgs/blankimg.jpg"></td>
						<?php endif; ?>
						<td class="info">
							<a href="user.php?id=<?php echo($list['id']); ?>">
								<h1>
									<?php
										echo(strip_tags($list['name']).' ');

										if ($list['priv'] >= 1){ 
											echo('<img src="../imgs/verif.gif">');
										}
									?>
								</h1>
							</a>
						</td>
					</tr>
				</table>
			<?php endwhile; ?>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>

<?php mysqli_close($db);