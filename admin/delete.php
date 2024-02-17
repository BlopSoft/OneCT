<?php 
    require_once '../include/config.php';

    include 'checkuser.php';

    if($_GET['type'] == 'user'){
        mysqli_query($db, 'DELETE FROM users WHERE id = ' .(int)$_GET['id']);
        mysqli_query($db, 'DELETE FROM post WHERE id_user = ' .(int)$_GET['id']);
        header("Location: users.php");
    } elseif($_GET['type'] == 'post'){
        mysqli_query($db, 'DELETE FROM post WHERE id = ' .(int)$_GET['id']);
        mysqli_query($db, 'DELETE FROM likes WHERE post_id = ' .(int)$_GET['id']);
        mysqli_query($db, 'DELETE FROM comments WHERE post_id = ' .(int)$_GET['id']);
        header("Location: wall.php");
    } elseif($_GET['type'] == 'comm'){
        mysqli_query($db, 'DELETE FROM comments WHERE id = ' .(int)$_GET['id']);
        header("Location: comm.php");
    } elseif($_GET['type'] == 'ban'){
        $baninfo = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM banlist WHERE id = ' .(int)$_GET['id']));
        mysqli_query($db, 'DELETE FROM banlist WHERE id = ' .(int)$_GET['id']);
        mysqli_query($db, "UPDATE users SET ban = 0 WHERE id = " .(int)$baninfo['user_id']);
        header("Location: banlist.php");
    }
?>