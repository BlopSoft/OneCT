<?php 
    require_once '../include/config.php';

    if(!isset($_SESSION['user'])){
        header("Location: $url/web/login.php");
    }

    $all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .(int)$_SESSION['user']['user_id']));

    if($all['priv'] != 3){
        header("Location: $url");
    } else {
        $_SESSION['user']['admin'] = 1;
    }
?>

<h1><?php echo($sitename); ?> Admin panel</h1>
<a href="update.php">Проверить обновление</a> | 
<a href="users.php">Список пользователей</a> | 
<a href="wall.php">Список постов</a> | 
<a href="banlist.php">Бан лист</a>