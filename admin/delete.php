<?php 
    require_once '../include/config.php';

    if($_SESSION['user']['admin'] != 1){
        mysqli_query($db, "INSERT INTO banlist (user_id, reason) VALUES (" .$_SESSION['user']['user_id']. ", 'Был забанен за попытку взлома OneConnect')");
        header("Location: $url");
    }

    if($_GET['type'] == 'user'){
        mysqli_query($db, 'DELETE FROM users WHERE id = ' .(int)$_GET['id']);
        header("Location: users.php");
    } elseif($_GET['type'] == 'post'){
        mysqli_query($db, 'DELETE FROM post WHERE id = ' .(int)$_GET['id']);
        header("Location: wall.php");
    } elseif($_GET['type'] == 'ban'){
        mysqli_query($db, 'DELETE FROM banlist WHERE id = ' .(int)$_GET['id']);
        header("Location: banlist.php");
    }
?>