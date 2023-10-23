<?php
   require_once "../bd.php";
   $title = "Добавление операции";
   require_once "../head.php";

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

        $result = $mysqli -> query("SELECT * FROM `oper_klient` WHERE `id_schet` = $schet AND `id_operation` = $vid_oper AND `date_operation` = '$d_oper'");

        if($result -> num_rows === 0){

             $result = $mysqli -> query("INSERT INTO `oper_klient` VALUES (NULL, $schet, $vid_oper, '$d_oper', $sumOper)");

             if($result){
                 $resultCode = "success";
                 $message = "Запись успешно добавлена";
             }else{
                 $resultCode = "danger";
                 $message = "Ошибка при добавлении записи";
             }
        }else{
            $resultCode = "warning";
            $message = "Дублирование операции";
        }

    }elseif($_SERVER['REQUEST_METHOD'] === "POST"){
        $resultCode = "warning";
        $message = "Заполните обязательные поля";
    }
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
                        <option value="<?=$id_schet?>"><?= "$number_account - $name_klient"?></option>
                     <?php } ?>
                </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Вид операции</label>
                <select class="form-control" id="exampleFormControlSelect2" name="s_operation_id">
                  <?php while($row = $sOperationTable -> fetch_assoc()){ extract($row)?>
                    <option value="<?=$id_operation?>"><?= "$name_operation"?></option>
                  <?php } ?>
                </select>
          </div>
          <div class="form-group">
            <label for="exampleInputDOper">Дата операции</label>
            <input type="datetime-local" class="form-control" id="exampleInputDOper" name="d_oper">
          </div>
          <div class="form-group">
            <label for="exampleInputSumOper">Сумма операции</label>
            <input type="number" class="form-control" id="exampleInputSumOper" name="sum_oper">
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