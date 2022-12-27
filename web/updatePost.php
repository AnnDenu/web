<?php
include "config.php";
include "DB.php";
if($_SERVER["REQUEST_METHOD"] === "GET" AND isset($_GET["id_post"])){
    $post = $_GET['id_post'];
    $data = (new db())->getPostON($post);
    if (count($data) > 0) {
        // генерирация ошибки при попытке использования с переменными других типов или неинициализированными переменными
        foreach($data as $data){
        $name = $data->name;
        $description = $data->description;
        $user = $data->id_user;
        $picture = $data->picture;
    }
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
                            <div class="card bg-light g-2">
                                <div class="card-body">
                                    <div class="container mt-5">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <div class="card px-5 py-5" id="form1">
                                                    <h1>Редактирование статьи</h1>
                                                    <form class="form" method="post" action="" name="create" enctype="multipart/form-data">
                                                        <div class="form-outline mb-4">
                                                            <label>Заголовок</label>
                                                            <input class="form-control" type="text" name="name" value="<?=$name?>" required />
                                                        </div>
                                                        <div class="form-outline mb-4">
                                                            <label>Содержание</label>
                                                            <textarea class="form-control" type="text" rows="6" name="description" required> <?=$description?> </textarea>
                                                        </div>
                                                        <input type="hidden" name="id_user" value="<?=$user?>" />
                                                        <div class="form-outline mb-4">
                                                        <img src="<?=$picture?>" alt="" width="90%">
                                                            <label>Фотография</label>
                                                            <input class="form-control" type="file" name="picture" value="img/<?=$picture?>" required />
                                                        </div>
                                                        <div class="mb-3"><button class="btn btn-dark w-100" type="submit" name="create" value="create">Изменить</button></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </body>
        </html>
    <?php }
    else{
        echo "Услуга не найдена";
    }
}
    elseif (isset($_POST['create'])) {
        // uploaddir принимает и обрабатывает загруженный при помощи формы фотграфию
        $uploaddir = 'img/';
        $pictures = $uploaddir . basename($_FILES['picture']['name']);
        //В базу данных переходит изменение статьи
        $sql = "UPDATE post SET name = :name, description = :description, id_user = :id_user, picture = :pictures WHERE id_post = :post";
        //присоединяется и подготавливает SQL выражение к выполнению
        $custom = $connection->prepare($sql);
        // Связываем параметр с заданным значением
        $custom->bindValue(":post", $_GET['id_post']);
        $custom->bindValue(":name", $_POST["name"]);
        $custom->bindValue(":description", $_POST["description"]);
        $custom->bindValue(":id_user", $_POST['id_user']);
        $custom->bindValue(":pictures", $pictures);

        $custom->execute();
        //ПРоверка
        echo '<pre>';
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $pictures)) {
            //перенаправление на страницу постов
      header("Location: /");
        } else {
        echo "Возможная атака с помощью файловой загрузки!\n";
        }
        
        echo 'Некоторая отладочная информация:';
        print_r($_FILES);

        //
    }
    else{
        echo "Некорректные данные";
    }
?>
