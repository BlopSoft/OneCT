<?php 
    require_once '../include/config.php';

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }

    $data = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .$_SESSION['user']['user_id']));

    if($data['ban'] != 1){
        $_SESSION['user']['ban'] = 0;
        header("Location: index.php");
    }

    $bandata = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM banlist WHERE user_id = ' .$_SESSION['user']['user_id']));

?>

<html>
<head>
    <?php include '../include/html/head.php'; ?>
    <title>Бан аккаунта</title>
</head>
<body>
    <div class="main_app">
        <div class="main">
            <h1>Вы были забанены в <?php echo($sitename); ?></h1>

            <?php if(!empty($bandata['reason'])): ?>
                <h3>По причине: <?php echo($bandata['reason']); ?></h3>
            <?php else: ?>
                <h3>По не указанной причине</h3>
            <?php endif; ?>

            <h3>На всегда</h3>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($db);