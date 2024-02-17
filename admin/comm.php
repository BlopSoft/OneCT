<?php 
    require_once '../include/config.php';

    include 'checkuser.php';

    $wall = mysqli_query($db, 'SELECT * FROM comments ORDER BY date DESC');
?>

<a href="index.php">Назад</a><br><br>
<table border="1" width="100%">
    <thead>
        <tr>
            <td>Действия</td>
            <td>ID</td>
            <td>ID поста</td>
            <td>Имя отправителя</td>
            <td>Текст</td>
            <td>Дата</td>
        </tr>
    </thead>
    <tbody>
        <?php while($list = mysqli_fetch_assoc($wall)): ?>
            <tr>
                <td>
                    <a href="delete.php?type=comm&id=<?php echo($list['id']); ?>">Удалить</a>
                </td>
                <td><?php echo($list['id']); ?></td>
                <td><?php echo($list['post_id']); ?></td>
                <?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['user_id'])); ?>
                <td><?php echo($user['name']); ?></td>
                <td><?php echo($list['text']); ?></td>
                <td><?php echo(date('d M Y в H:i', $list['date'])); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>