<?php
require_once "../bd.php";
    $title = "Добавление клиента";
    require_once "../head.php";

    if(
        isset($_POST['fio'])
        && ($FIO = $_POST['fio'])
        && (isset($_POST['tel']))
        && ($tel = $_POST['tel'])
        && (isset($_POST['address']))
        && ($address = $_POST['address'])
    ){
        $passport = $_POST['passport'] ?? null;
        $passportSearch = $passport ? " OR `number_passport` = '$passport'" : "";
        $result = $mysqli -> query("SELECT * FROM `klient` WHERE `klient_fon` = '$tel'$passportSearch");
        $count = $result -> num_rows;

        if($count === 0){
            $passportSQLStr = $passport ? "'$passport'" : "NULL";

            $result = $mysqli -> query("INSERT INTO `klient` VALUES (NULL, '$FIO', '$tel', $passportSQLStr, '$address')");

            if($result){
                $resultCode = "success";
                $message = "Запись успешно добавлена";
            }else{
                $resultCode = "danger";
                $message = "Ошибка при добавлении записи";
            }

        }else{
            $resultCode = "warning";
            $message = "Клиент с такими данными уже существует в системе";
        }
    }elseif($_SERVER['REQUEST_METHOD'] === "POST"){
        $resultCode = "warning";
        $message = "Заполните значения";
    }

?>

<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "klient";
include '../header.php';
?>
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post">
      <div class="form-group">
        <label for="exampleInputFIO">ФИО клиента</label>
        <input type="text" class="form-control" id="exampleInputFIO" name="fio">
      </div>
      <div class="form-group">
        <label for="exampleInputTel">Телефон</label>
        <input type="tel" class="form-control" id="exampleInputTel" name="tel">
      </div>
      <div class="form-group">
        <label for="exampleInputPassport">Номер паспорта</label>
        <input type="text" class="form-control" id="exampleInputPassport" name="passport">
      </div>
      <div class="form-group">
        <label for="exampleInputAdres">Адрес</label>
        <input type="text" class="form-control" id="exampleInputAdres" name="address">
      </div>
      <button type="submit" class="btn btn-secondary">Добавить</button>
      <a href="view.php" class="btn btn-secondary">Назад</a>
</form>
</div>

<?php
include '../footer.php';
?>
</body>
</html>