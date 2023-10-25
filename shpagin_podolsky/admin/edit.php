<?php
require_once "utils.php";
checkAuth();

$validate = isset($_GET['id'])
            && ($id = $_GET['id'])
            && (is_numeric($id))
            && ($id = (int) $id)
            && ($id = (int) $id)
            && ($oldData = getAdmin($id));

if(!$validate){
    echo "Неверные параметры";
    die();
}

extract($oldData);

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
    $result = $mysqli -> query("SELECT * FROM `admin` WHERE (`login` = '$login' OR `email` = '$email' OR `phone` = '$phone') AND `id_admin` != $id");

    if($result -> num_rows === 0){
        $passHash = md5($pass);
        $result = $mysqli -> query("UPDATE `admin` SET `login` = '$login', `pass` = '$passHash', `fio` = '$fio', `role` = '$role', `email` = '$email', `phone` = '$phone' WHERE `id_admin` = $id");
        if($result){
            $resultCode = "success";
            $message = "Запись успешно обновлена";
        }else{
            $resultCode = "danger";
            $message = "Ошибка при обновлении записи: ".$mysqli -> error;
        }
    }else{
        $resultCode = "warning";
        $message = "Значения повторяются";
    }
}elseif($_SERVER['REQUEST_METHOD'] === "POST"){
    $resultCode = "warning";
    $message = "Заполните значения";
}

extract(getAdmin($id));
?>
<body class="d-flex flex-column min-vh-100">
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post" class="form">
        <div class="form-group">
            <label for="inputLogin">Логин</label>
            <input type="text" class="form-control" id="inputLogin" name="login" value="<?=$login?>">
        </div>
        <div class="form-group">
            <label for="inputPass">Пароль</label>
            <input type="text" class="form-control" id="inputPass" name="pass" value="<?=$pass?>">
        </div>
        <div class="form-group">
            <label for="inputFIO">ФИО</label>
            <input type="text" class="form-control" id="inputFIO" name="fio" value="<?=$fio?>">
        </div>
        <div class="form-group">
            <label for="inputRole">Роль</label>
            <input type="text" class="form-control" id="inputRole" name="role" value="<?=$role?>">
        </div>
        <div class="form-group">
            <label for="inputEmail">E-mail</label>
            <input type="email" class="form-control" id="inputEmail" name="email" value="<?=$email?>">
        </div>
        <div class="form-group">
            <label for="inputPhone">Телефон</label>
            <input type="text" class="form-control" id="inputPhone" name="phone" value="<?=$phone?>">
        </div>
        <button type="submit" class="btn btn-secondary">Изменить</button>
        <a href="administration.php" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>