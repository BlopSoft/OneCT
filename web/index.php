<?php
	require_once "../include/config.php";

	if(isset($_SESSION['user'])){
		$all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .(int)$_SESSION['user']['user_id']));

		if($all['ban'] == 1){
			$_SESSION['user']['ban'] = 1;
			header("Location: ban.php");
		} else { 
			header("Location: user.php?id=" .$_SESSION['user']['user_id']);
		}
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
			<?php echo($lang_welcome); ?>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>
<?php mysqli_close($db);