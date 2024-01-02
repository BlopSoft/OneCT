<div class="header">
    <a class="sitename"><?php echo($sitename); ?></a>
    <?php if(isset($_SESSION['user'])): ?>
        <a class="href" href="logout.php">Выйти</a>
        <a class="href" href="search.php">Поиск</a>
        <a class="href" href="feed.php">Стена</a>
        <a class="href" href="<?php echo($url); ?>/web/index.php">Домой</a>
    <?php else : ?>
        <a class="href" href="login.php">Войти</a>
        <a class="href" href="register.php">Регистрироваться</a>
    <?php endif; ?>
</div>