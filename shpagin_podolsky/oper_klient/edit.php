<?php
require_once "../bd.php";
$title = "Редактирование операции";
require_once "../head.php";

function getOperKlientById($id){
    global $mysqli;
    $result = $mysqli -> query("SELECT * FROM `oper_klient` WHERE `id_operklient` = $id");
    return $result -> fetch_assoc();
}

$validated = isset($_GET['id'])
            && ($id = $_GET['id'])
            && (is_numeric($id))
            && ($id = (int) $id)
            && ($oldData = getOperKlientById($id));

if(!$validated){
    echo "Неверные параметры";
    die();
}

extract($oldData);

if(
    isset($_POST['d_oper'])
    && ($d_oper = $_POST['d_oper'])
    && (isset($_POST['sum_oper']))
    && ($sumOper = $_POST['sum_oper'])
    && (isset($_POST['shet_id']))
    && ($schet = $_POST['shet_id'])
    && (isset($_POST['s_operation_id']))
    && ($vid_oper = $_POST['s_operation_id'])
){

    $result = $mysqli -> query("SELECT * FROM `oper_klient` WHERE `id_schet` = $schet AND `id_operation` = $vid_oper AND `date_operation` = '$d_oper' AND `id_operklient` != $id");

    if($result -> num_rows === 0){
        $result = $mysqli -> query("UPDATE `oper_klient` SET `id_schet` = $schet, `id_operation` = $vid_oper, `date_operation` = '$d_oper', `price_operation` = $sumOper WHERE `id_operklient` = $id");

        if($result){
            $resultCode = "success";
            $message = "Запись успешно обновлена";
            extract(getOperKlientById($id));
        }else{
            $resultCode = "danger";
            $message = "Ошибка при обновлении записи";
        }
    }else{
        $resultCode = "warning";
        $message = "Дублирование операции";
    }



}elseif($_SERVER['REQUEST_METHOD'] === "POST"){
    $resultCode = "warning";
    $message = "Заполните обязательные поля";
}

$id_schet_old = $id_schet;
$id_operation_old = $id_operation;
?>

<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "oper_klient";
include '../header.php';

$nomeraTable = $mysqli -> query("SELECT `id_schet`,`number_account`, `name_klient` FROM `klient`,`schet` WHERE `schet`.`id_klient`=`klient`.`id_klient` ORDER BY `name_klient`");
$sOperationTable = $mysqli -> query("SELECT * FROM `s_operation` ORDER BY `name_operation`");
?>
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post" class="form">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Номер счета</label>
            <select class="form-control" id="exampleFormControlSelect1" name="shet_id">
                <?php while($row = $nomeraTable -> fetch_assoc()){ extract($row)?>
                    <option value="<?=$id_schet?>" <?= $id_schet_old == $id_schet ? "selected" : ''?>><?= "$number_account - $name_klient"?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Вид операции</label>
            <select class="form-control" id="exampleFormControlSelect2" name="s_operation_id">
                <?php while($row = $sOperationTable -> fetch_assoc()){ extract($row)?>
                    <option value="<?=$id_operation?>"<?= $id_operation_old == $id_operation ? "selected" : ''?>><?= "$name_operation"?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputDOper">Дата операции</label>
            <input type="datetime-local" class="form-control" id="exampleInputDOper" name="d_oper" value="<?=$date_operation?>">
        </div>
        <div class="form-group">
            <label for="exampleInputSumOper">Сумма операции</label>
            <input type="number" class="form-control" id="exampleInputSumOper" name="sum_oper" value="<?=$price_operation?>">
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