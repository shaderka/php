<?php
require_once "../bd.php";

function getSchetById($id){
    global $mysqli;
    $result = $mysqli -> query("SELECT * FROM `schet` WHERE `id_schet` = $id");
    return $result -> fetch_assoc();
}

$validate = isset($_GET['id'])
            && ($id = $_GET['id'])
            && (is_numeric($id))
            && ($id = (int)$id)
            && ($oldData = getSchetById($id));
if(!$validate){
    echo "Неверные данные";
    die();
}

extract($oldData);

$title = "Редактирование записи \"$number_account\"";
require_once "../head.php";

if(
    isset($_POST['shet_number'])
    && ($newNomer = $_POST['shet_number'])
    && (isset($_POST['d_open']))
    && ($newD_open = $_POST['d_open'])
){
    $newD_close = $_POST['d_close'] ?? null;
    $newPrice_open = $_POST['sum'] ?? null;
    $newKlient = $_POST['client_id'];
    $newVid_schet = $_POST['s_accoount_id'];
    $result = $mysqli -> query("SELECT * FROM `schet` WHERE `number_account` = $newNomer AND `id_schet` != $id_schet");
    $count = $result -> num_rows;

    if($count === 0){
        $dCloseSQLStr = $newD_close ? "'$newD_close'" : "NULL";
        $sumSQLStr = $newPrice_open ? "$newPrice_open" : "NULL";

        $result = $mysqli -> query("UPDATE `schet` SET `id_klient` = $newKlient, `id_account` = $newVid_schet,
                    `number_account` = $newNomer, `date_open` = '$newD_open', `date_close` = $dCloseSQLStr, `price_open` = $sumSQLStr  WHERE `id_schet` = $id_schet");

        extract(getSchetById($id_schet));

        if($result){
            $resultCode = "success";
            $message = "Запись успешно изменена";
        }else{
            $resultCode = "danger";
            $message = "Ошибка при изменении записи: ". $mysqli->error;
        }

    }else{
        $resultCode = "warning";
        $message = "Этот номер счета уже используется";
    }
}elseif($_SERVER['REQUEST_METHOD'] === "POST"){
    $resultCode = "warning";
    $message = "Заполните обязательные поля";
}

$id_klient_old = $id_klient;
$id_account_old = $id_account;

?>

<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "sheta";
include '../header.php';

$klientTable = $mysqli -> query("SELECT * FROM `klient` ORDER BY `name_klient`");
$sAccoountTable = $mysqli -> query("SELECT * FROM `s_accoount` ORDER BY `name_account`");
?>
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post" class="form">
      <div class="form-group">
        <label for="exampleFormControlSelect1">ФИО клиента</label>
            <select class="form-control" id="exampleFormControlSelect1" name="client_id">
                 <?php while($row = $klientTable -> fetch_assoc()){ extract($row)?>
                    <option value="<?=$id_klient?>" <?= $id_klient_old == $id_klient ? 'selected' : ''?>><?= "$name_klient - $klient_fon"?></option>
                <?php } ?>
            </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect2">Вид счета</label>
            <select class="form-control" id="exampleFormControlSelect2" name="s_accoount_id">
                <?php while($row = $sAccoountTable -> fetch_assoc()){ extract($row)?>
                    <option value="<?=$id_account?>" <?= $id_account_old == $id_account ? 'selected' : ''?>><?= "$name_account"?></option>
                <?php } ?>
            </select>
      </div>
      <div class="form-group">
        <label for="exampleInputNomer">Номер счета</label>
        <input type="number" class="form-control" id="exampleInputNomer" name="shet_number" value="<?=$number_account?>">
      </div>
      <div class="form-group">
        <label for="exampleInputDOpen">Дата открытия счета</label>
        <input type="date" class="form-control" id="exampleInputDOpen" name="d_open" value="<?=$date_open?>">
      </div>
      <div class="form-group">
        <label for="exampleInputDClose">Дата закрытия счета</label>
        <input type="date" class="form-control" id="exampleInputDClose" name="d_close" value="<?=$date_close?>">
      </div>
      <div class="form-group">
        <label for="exampleInputSum">Начальная сумма на счете</label>
        <input type="number" class="form-control" id="exampleInputSum" name="sum" value="<?=$price_open?>">
      </div>
      <button type="submit" class="btn btn-secondary">Изменить</button>
      <a href="view.php" class="btn btn-secondary">Назад</a>
</form>
</div>

<?php
include '../footer.php';
?>
</body>
</html>