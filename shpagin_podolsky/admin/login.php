<?php
session_start();
$title = "Логин";
require_once "../head.php";
require_once "../bd.php";

if(
    isset($_POST['login']) && ($login = $_POST['login'])
    && isset($_POST['pass']) && ($pass = $_POST['pass'])
){
    $passHash = md5($pass);
    $result = $mysqli -> query("SELECT * FROM `admin` WHERE `login` = '$login' AND `pass` = '$passHash'");
    if($result -> num_rows > 0){
        $_SESSION['auth'] = $result -> fetch_assoc();

        $_SESSION['message'] = "Вы успешно авторизованы";
        $_SESSION['resultCode'] = "success";

        header('Location: administration.php');
        exit;
    }else{
        $resultCode = "warning";
        $message = "Нет такого пользователя";
    }
}
elseif($_SERVER['REQUEST_METHOD'] === "POST"){
    $resultCode = "warning";
    $message = "Заполните значения";
}

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
                <input type="text" class="form-control" id="inputLogin" name="login">
            </div>
            <div class="form-group">
                <label for="inputPass">Пароль</label>
                <input type="text" class="form-control" id="inputPass" name="pass">
            </div>
            <button type="submit" class="btn btn-secondary">Вход</button>
            <a href="../index.php" class="btn btn-secondary">На главную</a>
        </form>
    </div>
</body>
</html>