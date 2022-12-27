<?php
//подключение к БД и к файлу, где хранятся функции добавления, удаления и вывод постов
include "config.php";
include "DB.php";
//Какой метод был использован для запроса страницы, то есть get и определяем, была ли установлена переменная значением, отличным от null
if($_SERVER["REQUEST_METHOD"] === "GET" AND isset($_GET["id_post"]))
    $post = $_GET['id_post'];
    $data = (new db())->getPostON($post);
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            <meta name="description" content="" />
            <meta name="keywords" content="" />
            <title>Статьи</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        </head>
        <body>
        <div>
            <div>
                <header class="header">
                    <div class="container-fluid">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                                <li class="nav-item"><a class="nav-link active" href="index.php">Статьи</a></li>
                                <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true) { ?>
                                    <a class="nav-item"> <a class="nav-link"></a> <?=$_SESSION['log_user']?> </a></li>
                                    <li class="nav-item"><a class="nav-link" href="logout.php">Выход</a></li>
                                <?php } else{?>
                                    <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                                    <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
                                <?php }?>
                            </ul>
                        </nav>
                    </div>
                </header>
            </div>
            <div id="page">
                <div id="content">
                    <div class="box">
                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <a class="btn btn-dark" type="button" href="/"> Назад </a>
                                </div>
                                <?php foreach ($data as $data){ $users = $data->id_user;?>
                            </div>
                            <div class="card bg-light g-2">
                                <div class="card-body">

                                        <h5 class="card-title"> <?=$data->name?></h5>
                                        <img src="<?=$data->picture?>" alt="" width="50%">
                                        <p class="card-text">
                                            Описание статьи: <?=$data->description?>
                                        </p>
                                            </div>

                                    <?php } ?>
                                </div>
                                <div class="col-3">
                                    <?php if (isset($_SESSION["login"]) && $_SESSION["user_id"] === $users) { ?>
                                        <a class="btn btn-dark" type="button" href="updatePost.php?id_post=<?=$post?>"> Изменить </a>
                                        <button onclick="deletePost(<?=$post?>)" type="button" class="btn btn-primary">Удалить</button>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        </div>
        <script>
//функция удаления постов
            function deletePost(id_post)
            {
                $.ajax({
                    url: 'deletePost.php',         /* Куда пойдет запрос */
                    method: 'get',             /* Метод передачи (post или get) */
                    dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
                    data: {id_post: id_post},     /* Параметры передаваемые в запросе. */
                    success: function(){   /* функция которая будет выполнена после успешного запроса.  */
                        location = "index.php";
                    }
                });
            }

        </script>
        </body>
        </html>
?>