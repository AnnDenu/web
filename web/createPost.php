<?php
include "config.php";
include "DB.php";
//Какой метод был использован для запроса страницы, то есть post
if (isset($_POST['create'])) {
    // uploaddir принимает и обрабатывает загруженный при помощи формы фотографии
    $uploaddir = 'img/';
    //переменна имени принимает значение метода POST
    $name = $_POST['name'];
    //переменна id пользователя принимает значение метода POST
    $id_user = $_POST['id_user'];
    //переменна описания статей принимает значение метода POST
    $description = $_POST['description'];

    $picture = $uploaddir . basename($_FILES['picture']['name']);
    //получение данных в бд, при изменении
    $data = (new db())->createPost($name, $id_user, $description, $picture);
    echo '<pre>';
    //Проверка
    echo '<pre>';
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $picture)) {
        //перенаправление на страницу постов
  header("Location: /");
    } else {
    echo "Возможная атака с помощью файловой загрузки!\n";
    }
    
    echo 'Некоторая отладочная информация:';
    //вывод информации о картинке
    print_r($_FILES);
    exit;
    //если изменение прошло успешно, то покажет готовую html страничку
} else{?>
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
                                                    <h1>Добавление статьи</h1>
                                                    <form class="form" method="post" action="" name="create" enctype="multipart/form-data">
                                                        <div class="form-outline mb-4">
                                                            <label>Заголовок</label>
                                                            <input class="form-control" type="text" name="name" required />
                                                        </div>
                                                        <input type="hidden" name="id_user" value="<?=$_SESSION['user_id']?>" />
                                                        <div class="form-outline mb-4">
                                                            <label>Содержание</label>
                                                            <textarea class="form-control" type="text" rows="6" name="description" required> </textarea>
                                                        </div>
                                                        <div class="form-outline mb-4">
                                                            <label>Изображение</label>
                                                            <input class="form-control" type="file" name="picture" required />
                                                        </div>
                                                        <div class="mb-3"><button class="btn btn-dark w-100" type="submit" name="create" value="create">Добавить</button></div>
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
<?php
}
?>