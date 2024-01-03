<?php
	require_once "../include/config.php";

	if(isset($_SESSION['user'])){
        header("Location: user.php?id=" .$_SESSION['user']['user_id']);
    }

	if(!isset($_SESSION['user'])){
        $_SESSION['theme'] = $style;
    }
?>

<html>
<head>
	<?php include "../include/html/head.php" ?>
    <title><?php echo($sitename); ?></title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
			<h1>Добро пожаловать в <?php echo($sitename); ?>!</h1>
			<p>Для использования платформы <?php echo($sitename); ?> необходимо пройти авторизацию</p>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>