<?php
    $title = "Редактирование клиента";
    require_once "../head.php";

?>

<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "sheta";
include '../header.php';
?>
<div class="container text-center">
    <form>
      <div class="form-group">
        <label for="exampleFormControlSelect1">ФИО клиента</label>
            <select class="form-control" id="exampleFormControlSelect1" name="client_id">
                 <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
            </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect2">Вид счета</label>
            <select class="form-control" id="exampleFormControlSelect2" name="s_accoount_id">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
      </div>
      <div class="form-group">
        <label for="exampleInputNomer">Номер счета</label>
        <input type="number" class="form-control" id="exampleInputNomer" name="shet_number">
      </div>
      <div class="form-group">
        <label for="exampleInputDOpen">Дата открытия счета</label>
        <input type="date" class="form-control" id="exampleInputDOpen" name="d_open">
      </div>
      <div class="form-group">
        <label for="exampleInputDClose">Дата закрытия счета</label>
        <input type="date" class="form-control" id="exampleInputDClose" name="d_close">
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