<?php 
    require_once '../include/config.php';

    if($_SESSION['user']['admin'] != 1){
        header("Location: $url");
    }
?>

<a href="index.php">Назад</a><br><br>
<p>Функция обновления не реализована, но можно импортировать новый дамп базы данных без вайпа всей базы данных</p>