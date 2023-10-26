<?php
require_once "utils.php";
checkAuth();

$title = "Добавить админа";
require_once "../head.php";
require_once "../bd.php";

if(
    isset($_POST['login'])
    && ($login = $_POST['login'])
    && isset($_POST['pass'])
    && ($pass = $_POST['pass'])
    && isset($_POST['fio'])
    && ($fio = $_POST['fio'])
    && isset($_POST['role'])
    && ($role= $_POST['role'])
    && isset($_POST['email'])
    && ($email = $_POST['email'])
    && isset($_POST['phone'])
    && ($phone = $_POST['phone'])
){
    $result = $mysqli -> query("SELECT * FROM `admin` WHERE `login` = '$login' OR `email` = '$email' OR `phone` = '$phone'");

    if($result -> num_rows === 0){
        $passHash = md5($pass);
        $result = $mysqli -> query("INSERT INTO `admin` VALUES(NULL, '$login', '$passHash', '$fio', '$role', '$email', '$phone')");
        if($result){
            $resultCode = "success";
            $message = "Запись успешно добавлена";
        }else{
            $resultCode = "danger";
            $message = "Ошибка при добавлении записи: ".$mysqli -> error;
        }
    }else{
        $resultCode = "warning";
        $message = "Значения повторяются";
    }
}elseif($_SERVER['REQUEST_METHOD'] === "POST"){
    $resultCode = "warning";
    $message = "Заполните значения";
}

?>
<body class="d-flex flex-column min-vh-100 login-form">
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post" class="form">
        <div class="form-group">
            <label for="inputLogin">Логин</label>
            <input type="text" class="form-control" id="inputLogin" name="login">
        </div>
        <div class="form-group">
            <label for="inputPass">Пароль</label>
            <input type="text" class="form-control" id="inputPass" name="pass">
        </div>
        <div class="form-group">
            <label for="inputFIO">ФИО</label>
            <input type="text" class="form-control" id="inputFIO" name="fio">
        </div>
        <div class="form-group">
            <label for="inputRole">Роль</label>
            <input type="text" class="form-control" id="inputRole" name="role">
        </div>
        <div class="form-group">
            <label for="inputEmail">E-mail</label>
            <input type="email" class="form-control" id="inputEmail" name="email">
        </div>
        <div class="form-group">
            <label for="inputPhone">Телефон</label>
            <input type="text" class="form-control" id="inputPhone" name="phone">
        </div>
        <button type="submit" class="btn btn-secondary">Добавить</button>
        <a href="administration.php" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>