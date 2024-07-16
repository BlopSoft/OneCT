<?php
    require_once '../include/db.php';

    $url = 'http://' .$_SERVER['HTTP_HOST'] /* . '/onect' */;
    $antispam = 60;

    $db = new PDO("mysql:host=" .$dbconn['server']. ";dbname=" .$dbconn['db'],
        $dbconn['user'],
        $dbconn['pass']
    );

    $db->exec("set names utf8mb4");

    if($db == false){
        echo('Ошибка подключение базы данных');
    }

    // Проверка token в таблице users

    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'token'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) $stmt = $db->query("ALTER TABLE users ADD token VARCHAR(64) NULL");
?>