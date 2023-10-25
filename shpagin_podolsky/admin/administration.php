<?php
require_once "utils.php";
checkAuth();


$title = "Админ панель";
require_once "../head.php";
require_once "../bd.php";

function disabledDelete($id){
    return $id === $_SESSION['auth']['id_admin'];
}

$tableRows = $mysqli -> query("SELECT * FROM `admin`");
$auth = $_SESSION['auth'];
?>
<body class="d-flex flex-column min-vh-100">
    <header class="d-flex flex-wrap justify-content-space-between py-3 mb-4 border-bottom">
        <span> Вы авторизованы как <?= $auth['fio']?> </span>
        <a type="button" class="btn btn-info" href="logout.php">Выйти</a>
        <a type="button" class="btn btn-info" href="../index.php">На главную</a>

    </header>
    <div class="container text-center">
        <?php if(isset($_SESSION['message']) && isset($_SESSION['resultCode'])){ ?>
            <div class="alert alert-<?=$_SESSION['resultCode']?>" role="alert">
                <?=$_SESSION['message']?>
                <?php unset($_SESSION['message']); unset($_SESSION['resultCode']); ?>
            </div>
        <?php } ?>

        <?php if($tableRows && $tableRows -> num_rows > 0 ){?>
            <table class="table dict">
                <thead>
                <tr>
                    <th scope="col">Логин</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Роль</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Телефон</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
                </thead>
                <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row)?>
                    <tr>
                        <td ><?= $login?></td>
                        <td ><?= $fio?></td>
                        <td ><?= $role?></td>
                        <td ><?= $email?></td>
                        <td ><?= $phone?></td>
                        <td class="btns">
                            <a type="button" class="btn btn-secondary" href="edit.php?id=<?=$id_admin?>">Редактировать</a>
                            <a type="button" class="btn btn-secondary <?= disabledDelete($id_admin) ? 'disabled' : '' ?>" href="delete.php?id=<?=$id_admin?>" onclick='return confirm(`Вы действительно хотите удалить запись "<?="$login"?>"?`);'>Удалить</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php }else{?>
            <div class="alert alert-warning" role="alert">
                Нет записей
            </div>
            <a type="button" class="btn btn-success" href="add.php">Добавить</a>
        <?php } ?>
    </div>
</body>
</html>