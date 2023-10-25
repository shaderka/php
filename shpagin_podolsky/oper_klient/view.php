<?php
    $title = "Операции клиентов";
    require_once "../head.php";


?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "oper_klient";
        require_once '../header.php';

        $filter = '';

        $hideFIOklientColumn = true;

        if(isset($_POST['action'])){

            if($_POST['action'] === "filter_date_operation"){
                if(isset($_POST['filter_date_operation']) && $_POST['filter_date_operation']){
                    $filter = " AND `date_operation` <= '{$_POST['filter_date_operation']}'";
                    $dateOperationF = $_POST['filter_date_operation'];
                }else{
                    $message ="Укажите значения для отбора";
                }

            }

            if($_POST['action'] === "filter_price_operation"){
                if(isset($_POST['filter_price_operation']) && $_POST['filter_price_operation']){
                    $filter = " AND `price_operation` >= {$_POST['filter_price_operation']}";
                    $priceOperationF = $_POST['filter_price_operation'];
                }else{
                    $message ="Укажите значения для отбора";
                }
            }

            if($_POST['action'] === "filter_number_account" && $_POST['shet_id'] != "-1"){
                $filter = " AND `schet`.`id_schet` = {$_POST['shet_id']}";
                $shetIdF = $_POST['shet_id'];
            }

            if($_POST['action'] === "filter_number_account_and_vid_operation" && $_POST['shet_id'] != "-1" && $_POST['vid_id'] != "-1"){
                $filter = " AND `schet`.`id_schet` = {$_POST['shet_id']} AND `s_operation`.`id_operation` = {$_POST['vid_id']}";
                $shetIdF = $_POST['shet_id'];
                $operationIdF = $_POST['vid_id'];

                $hideFIOklientColumn = false;
            }
        }


        $tableSelectNumberAccountRows = $mysqli -> query("SELECT `schet`.`id_schet`, `schet`.`number_account` FROM `schet`, `oper_klient` WHERE oper_klient.id_schet = schet.id_schet GROUP BY `schet`.`id_schet` ORDER BY `schet`.`number_account`");

        $tableSelectVidShetRows = $mysqli -> query("SELECT `s_operation`.id_operation, `s_operation`.name_operation FROM `s_operation`, `oper_klient` WHERE s_operation.id_operation=oper_klient.id_operation GROUP BY `s_operation`.`id_operation` ORDER BY `s_operation`.`name_operation`");

        $tableRows = $mysqli -> query("SELECT id_operklient,number_account, name_operation, date_operation, price_operation, name_klient FROM `schet`, `s_operation`, `klient`, `oper_klient`WHERE oper_klient.id_schet = schet.id_schet AND s_operation.id_operation=oper_klient.id_operation AND `klient`.`id_klient` = `schet`.`id_klient` $filter ORDER BY date_operation");
    ?>
    <div class="container text-center">
        <form method="post">
            <div class="poisk">
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
            </div>
            
            <div class="poisk">
                <div class="poisk-el">
                    <label>
                        Номер счета
                        <select name="shet_id" class="form-control" onchange="frmSubmit(this)">
                            <option value="-1">Все</option>
                            <?php while($tableSelectNumberAccountRows && $row = $tableSelectNumberAccountRows -> fetch_assoc()){ extract($row);?>
                              <option value="<?= $id_schet ?>" <?= isset($shetIdF) && $shetIdF == $id_schet ? 'selected' : ''?>> <?= "$number_account";?> </option>
                            <?php } ?>
                        </select>
                    </label>
                    <button name="action" class="btn btn-secondary d-none" value="filter_number_account">Отбор</button>
                </div>

                <div class="poisk-el">
                    <label>
                        Вид операции
                        <select name="vid_id" class="form-control" onchange="frmSubmit(this)">
                            <option value="-1">Все</option>
                            <?php while($tableSelectVidShetRows && $row = $tableSelectVidShetRows -> fetch_assoc()){ extract($row);?>
                              <option value="<?= $id_operation ?>" <?= isset($operationIdF) && $operationIdF == $id_operation ? 'selected' : ''?>> <?= "$name_operation";?> </option>
                            <?php } ?>
                        </select>
                    </label>
                    <button name="action" class="btn btn-secondary d-none" value="filter_number_account_and_vid_operation">Отбор</button>
                </div>
            </div>
            

            
        </form>
        <?php if(isset($message) && $message){ ?>
        <div class="alert alert-warning" role="alert">
            <?=$message?>
        </div>
        <?php }; ?>
        <?php if($tableRows && $tableRows -> num_rows > 0){?>
        <table class="table dict">
            <thead>

                <tr>
                    <th data-sort scope="col" onclick="sortTable(0, this, 'num')">Номер счета</th>
                    <th data-sort scope="col" onclick="sortTable(1, this, 'str')">Вид операции</th>
                    <th scope="col" class="<?= $hideFIOklientColumn ? 'd-none' : ''?>" >ФИО клиента</th>
                    <th data-sort scope="col" onclick="sortTable(3, this, 'date')">Дата операции</th>
                    <th scope="col">Сумма операции</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row) ?>
                <tr>
                    <td ><?= $number_account?></td>
                    <td ><?= $name_operation?></td>
                    <td class="<?= $hideFIOklientColumn ? 'd-none' : ''?>" ><?= $name_klient?></td>
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
    <?php }else{ ?>
        <div class="alert alert-warning" role="alert">
                Нет записей
        </div>
        <a type="button" class="btn btn-success" href="add.php">Добавить</a>
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
         //   let notZero = x - y == 0 ? false : true; 
            if(type!='date'){
                return type == 'str' ? (desc ? (x < y ? 1 : -1) : (x < y ? -1 : 1)) : (desc ? (y - x) : (x - y));
            }  else {
                console.log(new Date(y));
                return desc ? (new Date(y)- new Date(x)) : (new Date(x) - new Date(y));
            }
            
        });

        bRows.map ( (bRow) => {
           // console.log(bRow.innerHTML);
            tbody.appendChild(bRow);
        } )
}

    function frmSubmit(evt) {
        var btn = evt.parentElement.parentElement.lastElementChild;
        btn.click();
    }
 
</script>
</html>