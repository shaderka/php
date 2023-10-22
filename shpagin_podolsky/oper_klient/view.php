<?php
    $title = "Операции клиентов";
    require_once "../head.php";


?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "oper_klient";
        require_once '../header.php';

        $tableRows = $mysqli -> query("SELECT id_operklient,number_account, name_operation, date_operation, price_operation FROM `schet`, `s_operation`, `oper_klient` WHERE oper_klient.id_schet = schet.id_schet AND s_operation.id_operation=oper_klient.id_operation");
    ?>
    <div class="container text-center">
        <table class="table dict">
            <thead>
                <tr>
                    <th scope="col">Номер счета</th>
                    <th scope="col">Вид операции</th>
                    <th scope="col">Дата операции</th>
                    <th scope="col">Сумма операции</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row) ?>
                <tr>
                    <td ><?= $number_account?></td>
                    <td ><?= $name_operation?></td>
                    <td ><?= $date_operation?></td>
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
</html>