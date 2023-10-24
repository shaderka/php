<?php
    $title = "Счета";
    require_once "../head.php";
?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "sheta";
        require_once '../header.php';
        require_once 'utils.php';

        $filter = '';
        if(isset($_POST['action']) && $_POST['action'] === "filter_shet_number"){
            if(isset($_POST['filter_shet_number']) && $_POST['filter_shet_number']){
                $filter = " AND `number_account` LIKE '%{$_POST['filter_shet_number']}%'";
                $shetNumberF = $_POST['filter_shet_number'];
                $hideDClodeColumn = true;
            }


        }

        if(isset($_POST['action']) && $_POST['action'] === "filter_data_interval"){
            $filter = " AND `date_open` = '{$_POST['filter_d_open']}' AND `date_close` = '{$_POST['filter_d_close']}'";
            $dOpenF = $_POST['filter_d_open'];
            $dCloseF = $_POST['filter_d_close'];
            $hideVidShetColumn = true;
        }

        
        $tableRows = $mysqli -> query("SELECT id_schet ,name_klient, name_account, number_account, date_open, date_close, price_open FROM `schet`, `s_accoount`, `klient` WHERE klient.id_klient = schet.id_klient AND schet.id_account=s_accoount.id_account $filter ORDER BY number_account");
    ?>
    <div class="container text-center">
        <form method="post" class="poisk">
            <div class="poisk-el nomer-scheta">
                <label>
                    Номер счета
                <input type="text" class="form-control" name="filter_shet_number" value="<?= $shetNumberF ?? ''?>">
                </label>
                <button name="action" class="btn btn-secondary" value="filter_shet_number">Отбор</button>
            </div>

            <div class="poisk-el date-int">
                <label>
                    Дата открытия счета
                <input type="date" class="form-control" name="filter_d_open" value="<?= $dOpenF ?? ''?>">
                </label>
                <label>
                    Дата закрытия счета
                <input type="date" max="<?= date("Y-m-d") ?>" class="form-control" name="filter_d_close" value="<?= $dCloseF ?? ''?>">
                </label>
                <button name="action" class="btn btn-secondary" value="filter_data_interval">Отбор</button>
            </div>
            

            <a href="view.php" class="btn btn-secondary poisk-el" >Сбросить</a>
        </form>
        <?php if($tableRows && $tableRows -> num_rows > 0){?>
        <table class="table dict">
            <thead>
                <tr>
                    <th data-sort scope="col" onclick="sortTable(0, this, 'str')">ФИО клиента</th>
                    <th scope="col" class="<?= isset($hideVidShetColumn) && $hideVidShetColumn ? 'd-none' : ''?>">Вид счета</th>
                    <th data-sort scope="col" onclick="sortTable(2, this, 'num')">Номер счета</th>
                    <th data-sort scope="col" onclick="sortTable(3, this, 'str')">Дата открытия счета</th>
                    <th scope="col" class="<?= isset($hideDClodeColumn) && $hideDClodeColumn ? 'd-none' : ''?>">Дата закрытия счета</th>
                    <th scope="col">Начальная сумма на счете</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row)?>
                <tr>
                    <td ><?= $name_klient?></td>
                    <td class="<?= isset($hideVidShetColumn) && $hideVidShetColumn ? 'd-none' : ''?>"><?= $name_account?></td>
                    <td ><?= $number_account?></td>
                    <td ><?= $date_open ? date("d.m.Y",strtotime($date_open)) : ''?></td>
                    <td class="<?= isset($hideDClodeColumn) && $hideDClodeColumn ? 'd-none' : ''?>"><?= $date_close ? date("d.m.Y",strtotime($date_close)) : ''?></td>
                    <td ><?= $price_open?></td>
                    <td class="btns"> 
                        <a type="button" class="btn btn-secondary" href="edit.php?id=<?=$id_schet?>">Редактировать</a> 
                        <a type="button" class="btn btn-secondary <?= disabledDelete($id_schet) ? 'disabled' : '' ?>" href="delete.php?id=<?=$id_schet?>" onclick='return confirm(`Вы действительно хотите удалить запись "<?=$number_account?>"?`);'>Удалить</a>
                    </td>
                </tr>
                <?php }; ?>
            </tbody>
        </table>
        <?php }else{ ?>
            <div class="alert alert-warning" role="alert">
                Нет записей
            </div>
        <?php } ?>
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