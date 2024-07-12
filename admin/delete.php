<?php 
    require_once '../include/config.php';

    include 'checkuser.php';

    if(isset($_POST['delete'])){
        if($_SESSION['user']['admin'] != 1){
            mysqli_query($db, "UPDATE users SET ban = 1 WHERE id = " .(int)$_SESSION['user']['user_id']);
            mysqli_query($db, "INSERT INTO banlist (user_id, reason) VALUES (" .$_SESSION['user']['user_id']. ", 'Был забанен за попытку взлома OneConnect')");
            header("Location: $url");
        }

        if($_GET['type'] == 'user'){
            mysqli_query($db, 'DELETE FROM users WHERE id = ' .(int)$_GET['id']);
            mysqli_query($db, 'DELETE FROM post WHERE id_user = ' .(int)$_GET['id']);
            mysqli_query($db, 'DELETE FROM post WHERE id_who = ' .(int)$_GET['id']);
            mysqli_query($db, 'DELETE FROM comments WHERE user_id = ' .(int)$_GET['id']);
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
    }
?>

<form action="" method="post">
    <b>Вы точно хотите подтвердить действие?</b><br><br>
    <input type="hidden" name="delete" value="1">
    <button type="submit">Да</button> | <a href="index.php">Уйти</a>
</form>