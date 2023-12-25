<?php
    require_once 'db.php';

    session_start();

    $sitename = "OneConnect Pre Beta";
    $favicon = "favicon.png";
    $style = "md3";
    $antispam = 30;

    // Выполнение конфига

    $db = mysqli_connect(
        $dbconn['server'], 
        $dbconn['user'], 
        $dbconn['pass'], 
        $dbconn['db']
    );

    mysqli_set_charset($db,"utf8mb4");

    if($db == false){
        echo('Ошибка подключение базы данных');
        echo mysqli_connect_error();
    }
?>