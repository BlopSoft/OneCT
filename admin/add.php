<?php 
    require_once '../include/config.php';

    if($_SESSION['user']['admin'] != 1){
        header("Location: $url");
    }

    $users = mysqli_query($db, 'SELECT * FROM users');
    
    if(isset($_POST['ban'])){
        mysqli_query($db, "INSERT INTO banlist (user_id, reason) VALUES (" .$_POST['user']. ", '" .$_POST['reason']. "')");
        header("Location: banlist.php");
    }
?>

<form action="add.php?type=ban" method="post">
    <a href="banlist.php">Назад</a><br><br>
    <table border="1" width="100%">
        <thead>
            <tr>
                <td>Забанить</td>
                <td>Причина</td>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>
                        <select name="user">
                            <?php while($list = mysqli_fetch_assoc($users)): ?>
                                <option value="<?php echo($list['id']); ?>"><?php echo($list['name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                    <td><textarea name="reason"></textarea></td>
                </tr>
        </tbody>
    </table><br>
    <button type="submit" name="ban">Забанить</button>
</form>