<?php
	require_once "../include/config.php";
?>

<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title>Авторы</title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
            <h2>Сам OneConnect написан одним человеком с использованием идей других людей из телеграмм канала БлопСофта, сам человек это:</h2>
			<table class="user">
				<tr>
					<td><img class="img100" src="https://avatars.githubusercontent.com/u/85364286?v=4"></td>
					<td class="info">
						<a href="https://github.com/KovshKomeij">
							<h1>Дибоф (KovshKomeij или dibof228)</h1>
						</a>
					</td>
				</tr>
			</table>

            <h2>В <?php echo($sitename); ?> модераторами являются:</h2>

            <?php $allUsers = mysqli_query($db, 'SELECT id, name, priv, img200 FROM users WHERE priv > 1'); ?>
				
			<?php while($list = mysqli_fetch_assoc($allUsers)): ?>
				<table class="user">
					<tr>
						<?php if($list['img200'] != NULL): ?>
							<td><img class="img100" src="<?php echo($list['img200']); ?>"></td>
						<?php endif; ?>
						<td class="info">
							<a href="user.php?id=<?php echo($list['id']); ?>">
								<h1>
									<?php
										echo(strip_tags($list['name']));

										
									?>
                                    <span> </span>
									<span title="Аккаунт официальный" class="material-symbols-outlined">done</span>
								</h1>
							</a>
						</td>
					</tr>
				</table>
			<?php endwhile; ?>

            <h2>Сам OneConnect использует лицензию BSD 3-Clause и если вы хотите форкнуть OneConnect то вы должны указать авторство оригинального продукта, закрывать исходники своего форка OneConnect можно.</h2>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>
