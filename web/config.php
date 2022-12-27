<?php
//подключение к БД
session_start();
    define('USER', '20269');
    define('PASSWORD', 'xiiiiq');
    define('HOST', '10.100.3.80');
    define('DATABASE', '20269_blog');
    try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        // если что то пойдёт не так, то будет выведена ошибка и сообщение
        exit("Error: " . $e->getMessage());
    }
?>
