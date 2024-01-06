<?php
    if($_SESSION['user']['ban'] == 1){
        header("Location: ban.php");
    }
?>
<div class="header">
    <a class="sitename"><?php echo($sitename); ?></a>
    <?php if(isset($_SESSION['user'])): ?>
        <a class="href" href="logout.php">Выйти</a>
        <a class="href" href="search.php">Поиск</a>
        <a class="href" href="feed.php">Стена</a>
        <a class="href" href="index.php">Домой</a>
    <?php else : ?>
        <a class="href" href="login.php">Войти</a>
        <a class="href" href="register.php">Регистрироваться</a>
    <?php endif; ?>
</div>