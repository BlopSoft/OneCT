<?php
	require_once "../include/config.php";

	if(empty($_SESSION['user'])){
		header("Location: login.php");
	}

	$data = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .$_SESSION['user']['user_id']));

	$change = "UPDATE users SET 
		name = '" .mysqli_real_escape_string($db, strip_tags($_POST['username'])). "', 
		descr = '" .mysqli_real_escape_string($db, strip_tags($_POST['descr']))."', 
		yespost = '" .(int)$_POST['yespost']. "'
		WHERE id = '" .$_SESSION['user']['user_id']. "'";
	
	if(isset($_POST['do_change'])){
		if(empty(trim(strip_tags($_POST['username'])))){
			$error = 'Ник пустой';
		}
		
		if(empty($error)){
			if(mysqli_query($db, $change)){
				header("Location: $url");
			}
		}
	}
?>
<html>
<head>
	<?php include '../include/html/head.php'; ?>
    <title><?php echo($lang_settings); ?></title>
</head>
<body>
	<?php include '../include/html/header.php'; ?>
	<div class="main_app">
		<div class="main">
			<form action="edit.php" method="POST">
				<p>
					<p><?php echo($lang_nickname); ?></p>
					<input type="text" name="username" value="<?php echo $data['name']; ?>">
				</p>
				<p>
					<p><?php echo($lang_description); ?></p>
					<textarea name="descr"><?php echo $data['descr']; ?></textarea>
				</p>
				<p>
					<p><?php echo($lang_yespost); ?></p>
					<select name="yespost">
						<option <?php if($data['yespost'] == 0) echo('selected'); ?> value="0"><?php echo($lang_no); ?></option>
						<option <?php if($data['yespost'] == 1) echo('selected'); ?> value="1"><?php echo($lang_yes); ?></option>
					</select>
				</p>
				<p>
					<button type="submit" name="do_change"><?php echo($lang_change); ?></button>
				</p>
			</form>
			<p><?php echo($error); ?></p><br>
			<a href="pass.php"><?php echo($lang_changepass); ?></a>
		</div>
	</div>
	<?php include "../include/html/footer.php" ?>
</body>
</html>
<?php mysqli_close($db);