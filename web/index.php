<?php
include "config.php";
include "DB.php";
//получение данных из бд
$data = (new db())->getPosts();
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
                        <li class="nav-item"><a class="nav-link active" href="/">Статьи</a></li>
                        <!-- Если логин верный, то показывается логин user -->
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
                            <h1>Статьи</h1>
                        </div>
                        <div class="col-3">
                            <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true) { ?>
                                <a class="btn btn-dark" type="button" href="createPost.php"> Добавить статью </a>
                            <?php }?>
                        </div>
                    </div>
                    <div class="row bg-secondary">
                        <?php
                        //вывод данных
                        foreach($data as $row)
                        {?>
                            <div class="card bg-light g-2">
                                <div class="card-body">
                                    <p class="card-text"><?=$row['description']?><br>
                                    </p>
                                    <a href="post.php?id_post=<?=$row['id_post']?>" class="btn btn-primary">Читать дальше</a>
                                </div>
                            </div>
                            <?php
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
