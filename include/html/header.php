<?php
    if(isset($_SESSION['user'])){
        $checkban = mysqli_fetch_assoc(mysqli_query($db, 'SELECT ban FROM users WHERE id = ' .(int)$_SESSION['user']['user_id']));

        if($_SESSION['user']['ban'] == 1 or $checkban['ban'] == 1){
            $_SESSION['user']['ban'] = 1;
            header("Location: ban.php");
        }
    }
?>

<div class="header">
    <a class="sitename"><?php echo($sitename); ?></a>
    <?php if(isset($_SESSION['user'])): ?>
        <a class="href" href="logout.php"><?php echo($lang_logout); ?></a>
        <a class="href" href="search.php"><?php echo($lang_search); ?></a>
        <a class="href" href="feed.php"><?php echo($lang_wall); ?></a>
        <a class="href" href="index.php"><?php echo($lang_home); ?></a>
    <?php else : ?>
        <a class="href" href="login.php"><?php echo($lang_login); ?></a>
        <a class="href" href="register.php"><?php echo($lang_register); ?></a>
    <?php endif; ?>
</div>
