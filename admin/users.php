<?php 
    require_once '../include/config.php';

    include 'checkuser.php';

    $users = mysqli_query($db, 'SELECT * FROM users');
?>

<a href="index.php">Назад</a><br><br>
<table border="1" width="100%">
    <thead>
        <tr>
            <td>Действия</td>
            <td>ID</td>
            <td>Email</td>
            <td>Имя</td>
            <td>Описание</td>
            <td>Бан</td>
            <td>Привилегия</td>
            <td>Аватарка</td>
        </tr>
    </thead>
    <tbody>
        <?php while($list = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td>
                    <a href="delete.php?type=user&id=<?php echo($list['id']); ?>">Удалить</a> | 
                    <a href="edit.php?type=user&id=<?php echo($list['id']); ?>">Изменить</a>
                </td>
                <td><?php echo($list['id']); ?></td>
                <td><?php echo($list['email']); ?></td>
                <td><?php echo($list['name']); ?></td>
                <td><?php echo($list['descr']); ?></td>
                <td><?php echo($list['ban']); ?></td>
                <td><?php echo($list['priv']); ?></td>
                <td><img src="<?php echo($list['img50']); ?>"></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>