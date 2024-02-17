<?php include "../lang/$lang"; ?>
<div class="footer">
    <div class="links">
        <a href="<?php echo($url); ?>/web/terms.php" class="link"><?php echo($lang_terms); ?></a>
        <a href="<?php echo($url); ?>/web/authors.php" class="link"><?php echo($lang_authors); ?></a>
    </div>
    <p>php: <?php echo(phpversion()); ?> | MySQL: <?php echo(mysqli_get_server_info($db)); ?></p>

    <p> | 
        <?php
            foreach ($links as $name => $link){
                echo('<a href="'. $link .'">'. $name .'</a> | ');
            }
        ?>
    </p>
</div>