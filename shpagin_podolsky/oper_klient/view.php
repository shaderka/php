<?php
    $title = "Операции клиентов";
    require_once "../head.php";


?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "oper_klient";
        require_once '../header.php';

        $filter = '';
        if(isset($_POST['action']) && $_POST['action'] === "filter_date_operation"){
            $filter = " AND `date_operation` <= '{$_POST['filter_date_operation']}'";
            $dateOperationF = $_POST['filter_date_operation'];
        }

        if(isset($_POST['action']) && $_POST['action'] === "filter_price_operation"){
            $filter = " AND `price_operation` >= {$_POST['filter_price_operation']}";
            $priceOperationF = $_POST['filter_price_operation'];
        }


        $tableRows = $mysqli -> query("SELECT id_operklient,number_account, name_operation, date_operation, price_operation FROM `schet`, `s_operation`, `oper_klient` WHERE oper_klient.id_schet = schet.id_schet AND s_operation.id_operation=oper_klient.id_operation $filter ORDER BY date_operation");
    ?>
    <div class="container text-center">
        <form method="post" class="poisk">
            <div class="poisk-el nomer-scheta">
                <label>
                    Дата операции по счету
                <input type="datetime-local" class="form-control" name="filter_date_operation" value="<?= $dateOperationF ?? ''?>">
                </label>
                <button name="action" class="btn btn-secondary" value="filter_date_operation">Отбор</button>
            </div>

            <div class="poisk-el nomer-scheta">
                <label>
                    Сумма операции
                <input type="number" class="form-control" name="filter_price_operation" value="<?= $priceOperationF ?? ''?>">
                </label>
                <button name="action" class="btn btn-secondary" value="filter_price_operation">Отбор</button>
            </div>

            <a href="view.php" class="btn btn-secondary poisk-el" >Сбросить</a>
        </form>
        <table class="table dict">
            <thead>
                <tr>
                    <th data-sort scope="col" onclick="sortTable(0, this, 'num')">Номер счета</th>
                    <th data-sort scope="col" onclick="sortTable(1, this, 'str')">Вид операции</th>
                    <th data-sort scope="col" onclick="sortTable(2, this, 'str')">Дата операции</th>
                    <th scope="col">Сумма операции</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row) ?>
                <tr>
                    <td ><?= $number_account?></td>
                    <td ><?= $name_operation?></td>
                    <td ><?= date("d.m.Y H:i:s",strtotime($date_operation))?></td>
                    <td ><?= $price_operation?></td>
                    <td class="btns"> 
                        <a type="button" class="btn btn-secondary" href="edit.php?id=<?=$id_operklient?>">Редактировать</a> 
                        <a type="button" class="btn btn-secondary" href="delete.php?id=<?=$id_operklient?>" onclick='return confirm(`Вы действительно хотите удалить запись "<?="$number_account - $name_operation - $date_operation"?>"?`);'>Удалить</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php
    include '../footer.php';
?>

</body>

<script>
    function sortTable(n, evt, type) {
    var table = document.querySelector('table'),
        thead = document.querySelector('thead'),
        tbody = document.querySelector('tbody'),
        hData = [...thead.querySelectorAll('th')],
        bRows = [...tbody.rows],
        desc = false;

        hData.map ( (head) => {
            if(head != evt ) {
                head.classList.remove('asc', 'desc');
            }
        } );

        desc = evt.classList.contains ('asc') ? true : false;
        evt.classList[desc ? 'remove' : 'add']('asc');
        evt.classList[desc ? 'add' : 'remove']('desc');
    

        tbody.innerHTML = '';

        bRows.sort( (a, b) => {
            let x = a.getElementsByTagName('td')[n].innerHTML.toLowerCase(),
                y= b.getElementsByTagName('td')[n].innerHTML.toLowerCase();
            let notZero = x - y == 0 ? false : true; 
            return type == 'str' ? (desc ? (x < y ? 1 : -1) : (x < y ? -1 : 1)) : (desc ? (y - x) : (x - y));
        });

        bRows.map ( (bRow) => {
            console.log(bRow.innerHTML);
            tbody.appendChild(bRow);
        } )
}
 
</script>
</html>