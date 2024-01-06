<?php 
    require_once '../include/config.php';

    if($_SESSION['user']['admin'] != 1){
        header("Location: $url");
    }

    if($_GET['type'] == 'user'){
        $list = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM users WHERE id = ' .(int)$_GET['id']));
    
        if(isset($_POST['edit_user'])){
            if($_SESSION['user']['admin'] != 1){
                mysqli_query($db, "INSERT INTO banlist (user_id, reason) VALUES (" .$_SESSION['user']['user_id']. ", 'Был забанен за попытку взлома OneConnect')");
                header("Location: $url");
            }

            if(empty((int)$_POST['ban'])){
                $ban = 0;
            } else {
                $ban = (int)$_POST['ban'];
            }

            if(empty((int)$_POST['priv'])){
                $priv = $list['priv'];
            } else {
                $priv = (int)$_POST['priv'];
            }

            mysqli_query($db, "UPDATE users SET
                email = '" .$_POST['email']. "', 
                name = '" .$_POST['name']. "', 
                descr = '" .$_POST['desc']. "', 
                ban = " .$ban. ", 
                priv = " .$priv. " WHERE id = " .(int)$_GET['id']);

            if((int)$_POST['img'] == 1){
                unlink($list['img50']);
                unlink($list['img100']);
                unlink($list['img200']);
                unlink($list['img']);

                mysqli_query($db, "UPDATE users SET
                img50 = '', 
                img100 = '', 
                img200 = '', 
                img = '' WHERE id = " .(int)$_GET['id']);
            }

            header("Location: users.php");
        }

    }
?>

<?php if($_GET['type'] == 'user'): ?>
    <a href="users.php">Назад</a><br><br>
    <form action="edit.php?type=user&id=<?php echo((int)$_GET['id']); ?>" method="post">
        <table border="1" width="100%">
            <thead>
                <tr>
                    <td>ID</td>
                    <td><?php echo($list['id']) ?></td>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" value="<?php echo($list['email']) ?>"></td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td><input type="text" name="name" value="<?php echo($list['name']) ?>"></td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td><textarea name="desc"><?php echo($list['descr']) ?></textarea></td>
                </tr>
                <tr>
                    <td>Бан</td>
                    <td>
                        <input type="checkbox" name="ban" value="1">Забанить
                    </td>
                </tr>
                <tr>
                    <td>Привилегия</td>
                    <td>
                        <input type="radio" name="priv" value="0">Нету привилегии<br>
                        <input type="radio" name="priv" value="1">Галочка<br>
                        <input type="radio" name="priv" value="2">Модератор<br>
                        <input type="radio" name="priv" value="3">Владелец
                    </td>
                </tr>
                <?php if(!empty($list['img'])): ?>
                    <tr>
                        <td>Аватарка</td>
                        <td>
                            <img src="<?php echo($list['img50']) ?>">
                            <input type="checkbox" name="img" value="1">Удалить
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table><br>
        <button type="submit" name="edit_user">Изменить</button>
    </form>
<?php endif; ?>