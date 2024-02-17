<?php 
    require_once '../include/config.php';

    include 'checkuser.php';
?>

<h1><?php echo($sitename); ?> Admin panel</h1>
<a href="../">Домой</a> | 
<a href="update.php">Проверить обновление</a> | 
<a href="users.php">Список пользователей</a> | 
<a href="wall.php">Список постов</a> | 
<a href="comm.php">Список комментариев</a> | 
<a href="banlist.php">Бан лист</a>