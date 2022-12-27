<?php
    include "config.php";
//Какой метод был использован для аутентификации, то есть post
    if (isset($_POST['auth'])) {
        //переменная логин принимает значение метода POST
        $login = $_POST['login'];
        //переменная пароль принимает значение метода POST
        $password = $_POST['password'];

        $query = $connection->prepare("SELECT * FROM users WHERE login=:login");

        $query->bindParam("login", $login, PDO::PARAM_STR);
        $query->execute();
        //Выражение $result =$query относится к вызову метода 
        //запроса с использованием fetch объекта и последующей передачей 
        //$query созданного ранее
        $result = $query->fetch(PDO::FETCH_ASSOC);
        //если неверно, то выводится сообщение ниже
        if (!$result) {
            echo '<p class="error">Неверные пароль или имя пользователя!</p>';
        } else {
            //если верно, то вводим логин и пароль, а далее вас перекидывает на главную страницу
            if (password_verify($password, $result['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['log_user'] = $result['login'];
                header('Location: index.php');
            }
        }
    }
?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card px-5 py-5" id="form1">
<form class="form" method="post" action="" name="signin-form">
  <div class="form-outline mb-4">
    <label>Username</label>
    <input class="form-control" type="text" name="login" pattern="[a-zA-Z0-9]+" required />
  </div>
  <div class="form-outline mb-4">
    <label>Password</label>
    <input class="form-control" type="password" name="password" required />
  </div>
    <div class="mb-3"><button class="btn btn-dark w-100" type="submit" name="auth" value="auth">Log In</button></div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>