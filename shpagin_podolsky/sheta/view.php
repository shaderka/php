<?php
    $title = "Счета";
    require_once "../head.php";
?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "sheta";
        require_once '../header.php';
        require_once 'utils.php';
        
        $tableRows = $mysqli -> query("SELECT id_schet ,name_klient, name_account, number_account, date_open, date_close, price_open FROM `schet`, `s_accoount`, `klient` WHERE klient.id_klient = schet.id_klient AND schet.id_account=s_accoount.id_account");

        function isDisabled($id){
            
        }
    ?>
    <div class="container text-center">
        <table class="table dict">
            <thead>
                <tr>
                    <th scope="col">ФИО клиента</th>
                    <th scope="col">Вид счета</th>
                    <th scope="col">Номер счета</th>
                    <th scope="col">Дата открытия счета</th>
                    <th scope="col">Дата закрытия счета</th>
                    <th scope="col">Начальная сумма на счете</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row)?>
                <tr>
                    <td ><?= $row['name_klient']?></td>
                    <td ><?= $row['name_account']?></td>
                    <td ><?= $row['number_account']?></td>
                    <td ><?= $row['date_open']?></td>
                    <td ><?= $row['date_close']?></td>
                    <td ><?= $row['price_open']?></td>
                    <td class="btns"> 
                        <a type="button" class="btn btn-secondary" href="edit.php?id=<?=$id_schet?>">Редактировать</a> 
                        <a type="button" class="btn btn-secondary <?= disabledDelete($id_schet) ? 'disabled' : '' ?>" href="delete.php?id=<?=$id_schet?>">Удалить</a>
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
</html>