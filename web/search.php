<?php
	require_once "../include/config.php";

	if(empty($_SESSION['user'])){
		header("Location: login.php");
	}
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Все пользователи</title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
			<?php $allUsers = mysqli_query($db, 'SELECT id, name, priv, img100 FROM users'); ?>
				
			<?php while($list = mysqli_fetch_assoc($allUsers)): ?>
				<table>
					<tr>
						<?php if($list['img100'] != NULL): ?>
							<td><img class="img100" src="<?php echo($list['img100']); ?>"></td>
						<?php endif; ?>
						<td class="info">
							<a href="user.php?id=<?php echo($list['id']); ?>">
								<h1>
									<?php
										echo(strip_tags($list['name']));

										if ($list['priv'] == 1){ 
											echo('<span> </span>');
											echo('<span title="Аккаунт официальный" class="material-symbols-outlined">done</span>'); 
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
</body>
</html>
