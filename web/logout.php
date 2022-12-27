<?php
//начало сессии
session_start();
//уничтожение сессии
session_destroy();
//местонахождение в файле логин
header ('location: login.php');
?>