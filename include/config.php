<?php
    require_once 'db.php';

    session_start();

    $url = 'http://' .$_SERVER['HTTP_HOST'] /* . '/onect' */;
    $sitename = 'OneConnect';
    $favicon = 'favicon.png';
    $style = 'md1';
    $enable_antispam = true;
    $antispam = 60;

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