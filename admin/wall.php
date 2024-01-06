<?php 
    require_once '../include/config.php';

    if($_SESSION['user']['admin'] != 1){
        header("Location: $url");
    }

    $wall = mysqli_query($db, 'SELECT * FROM post ORDER BY date DESC');
?>

<a href="index.php">Назад</a><br><br>
<table border="1" width="100%">
    <thead>
        <tr>
            <td>Действия</td>
            <td>ID</td>
            <td>Имя пользователя</td>
            <td>Имя отправителя</td>
            <td>Текст</td>
            <td>Дата</td>
            <td>Изображение</td>
        </tr>
    </thead>
    <tbody>
        <?php while($list = mysqli_fetch_assoc($wall)): ?>
            <tr>
                <td>
                    <a href="delete.php?type=post&id=<?php echo($list['id']); ?>">Удалить</a>
                </td>
                <td><?php echo($list['id']); ?></td>
                <?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['id_user'])); ?>
                <td><?php echo($user['name']); ?></td>
                <?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['id_who'])); ?>
                <td><?php echo($user['name']); ?></td>
                <td><?php echo($list['post']); ?></td>
                <td><?php echo(date('d M Y в H:i', $list['date'])); ?></td>
                <?php if($list['img'] != NULL): ?>
                    <td><img width="128px" src="<?php echo($list['img']); ?>"></td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>