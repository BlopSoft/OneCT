<?php 
    require_once '../include/config.php';

    if($_SESSION['user']['admin'] != 1){
        header("Location: $url");
    }

    $ban = mysqli_query($db, 'SELECT * FROM banlist');
?>

<a href="index.php">Назад</a> | 
<a href="add.php?type=ban">Добавить</a><br><br>
<table border="1" width="100%">
    <thead>
        <tr>
            <td>Действия</td>
            <td>ID</td>
            <td>Имя пользователя</td>
            <td>Причина</td>
        </tr>
    </thead>
    <tbody>
        <?php while($list = mysqli_fetch_assoc($ban)): ?>
            <tr>
                <td>
                    <a href="delete.php?type=ban&id=<?php echo($list['id']); ?>">Удалить</a> | 
                    <a href="edit.php?type=ban&id=<?php echo($list['id']); ?>">Изменить</a>
                </td>
                <td><?php echo($list['id']); ?></td>
                <?php $user = mysqli_fetch_assoc(mysqli_query($db, 'SELECT name FROM users WHERE id = ' .$list['user_id'])); ?>
                <td><?php echo($user['name']); ?></td>
                <td><?php echo($list['reason']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>