<?php
    $title = "Добавление клиента";
    require_once "../head.php";

?>

<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "oper_klient";
include '../header.php';
?>
<div class="container text-center">
     <form>
      <div class="form-group">
            <label for="exampleFormControlSelect1">Номер счета</label>
                <select class="form-control" id="exampleFormControlSelect1" name="shet_id">
                     <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect2">Вид операции</label>
                <select class="form-control" id="exampleFormControlSelect2" name="s_operation_id">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
          </div>
          <div class="form-group">
            <label for="exampleInputDOper">Дата операции</label>
            <input type="date" class="form-control" id="exampleInputDOper" name="d_oper">
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