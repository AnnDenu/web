<?php
//проверяет удалялся ли уже данный файл, если да, не будет удалять его ещё раз
require_once "DB.php";
//удаление с методом get
return (new db())->deleteComment($_GET['id_comment']);
?>