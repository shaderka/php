<?php
    require_once "../bd.php";
    $title = "Добавление клиента";
    require_once "../head.php";

    if(
        isset($_POST['shet_number'])
        && ($nomer = $_POST['shet_number'])
        && (isset($_POST['d_open']))
        && ($d_open = $_POST['d_open'])
    ){
        $d_close = $_POST['d_close'] ?? null;
        $price_open = $_POST['sum'] ?? null;
        $klient = $_POST['client_id'];
        $vid_schet = $_POST['s_accoount_id'];
        $result = $mysqli -> query("SELECT * FROM `schet` WHERE `number_account` = $nomer");
        $count = $result -> num_rows;

        if($count === 0){
            $dCloseSQLStr = $d_close ? "'$d_close'" : "NULL";
            $sumSQLStr = $price_open ? "$price_open" : "NULL";

            $result = $mysqli -> query("INSERT INTO `schet` VALUES (NULL, $klient, $vid_schet, $nomer, '$d_open', $dCloseSQLStr, $sumSQLStr)");

            if($result){
                $resultCode = "success";
                $message = "Запись успешно добавлена";
            }else{
                $resultCode = "danger";
                $message = "Ошибка при добавлении записи";
            }

        }else{
            $resultCode = "warning";
            $message = "Этот номер счета уже используется";
        }
    }elseif($_SERVER['REQUEST_METHOD'] === "POST"){
        $resultCode = "warning";
        $message = "Заполните обязательные поля";
    }
?>

<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "sheta";
include '../header.php';

$klientTable = $mysqli -> query("SELECT `id_klient`, `name_klient`, `klient_fon` FROM `klient` ORDER BY `name_klient`");
$sAccoountTable = $mysqli -> query("SELECT * FROM `s_accoount` ORDER BY `name_account`");
?>
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post">
      <div class="form-group">
        <label for="exampleFormControlSelect1">Клиент</label>
            <select class="form-control" id="exampleFormControlSelect1" name="client_id">
                <?php while($row = $klientTable -> fetch_assoc()){ extract($row)?>
                    <option value="<?=$id_klient?>"><?= "$name_klient - $klient_fon"?></option>
                <?php } ?>
            </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect2">Вид счета</label>
            <select class="form-control" id="exampleFormControlSelect2" name="s_accoount_id">
                <?php while($row = $sAccoountTable -> fetch_assoc()){ extract($row)?>
                    <option value="<?=$id_account?>"><?= "$name_account"?></option>
                <?php } ?>
            </select>
      </div>
      <div class="form-group">
        <label for="exampleInputNomer">Номер счета</label>
        <input type="number" class="form-control" id="exampleInputNomer" name="shet_number">
      </div>
      <div class="form-group">
        <label for="exampleInputDOpen">Дата открытия счета</label>
        <input type="date" class="form-control" min="<?php echo date('Y-m-d') ?>" id="exampleInputDOpen" name="d_open">
      </div>
      <div class="form-group">
        <label for="exampleInputDClose">Дата закрытия счета</label>
        <input type="date" class="form-control" min="<?php echo date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d')))) ?>" id="exampleInputDClose" name="d_close">
      </div>
      <div class="form-group">
        <label for="exampleInputSum">Начальная сумма на счете</label>
        <input type="number" class="form-control" id="exampleInputSum" name="sum">
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