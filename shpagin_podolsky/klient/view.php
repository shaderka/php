<?php
    $title = "Клиенты";
    require_once "../head.php";
?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "klient";
        require_once '../header.php';
        require_once 'utils.php';
        $tableRows = $mysqli -> query("SELECT * FROM `klient`");
    ?>
    <div class="container text-center">
        <table class="table dict">
            <thead>
                <tr>
                    <th scope="col">Имя клиента</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Номер паспорта</th>
                    <th scope="col">Адрес</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row)?>
                <tr>
                    <td ><?= $name_klient?></td>
                    <td ><?= $klient_fon?></td>
                    <td ><?= $number_passport?></td>
                    <td ><?= $adress?></td>
                    <td class="btns"> 
                        <a type="button" class="btn btn-secondary" href="edit.php?id=<?=$id_klient?>">Редактировать</a>
                        <a type="button" class="btn btn-secondary <?= disabledDelete($id_klient) ? 'disabled' : '' ?>" href="delete.php?id=<?=$id_klient?>" onclick='return confirm(`Вы действительно хотите удалить запись "<?="$name_klient - $klient_fon"?>"?`);'>Удалить</a>
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