<?php
    if(!isset($_SESSION['user'])){
        header("Location: $url/web/login.php");
    }

    $all = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .(int)$_SESSION['user']['user_id']));

    if($all['priv'] != 3){
        $_SESSION['user']['admin'] = 0;
        header("Location: $url");
    } else {
        $_SESSION['user']['admin'] = 1;
    }
?>