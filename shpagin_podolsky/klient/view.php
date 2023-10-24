<?php
    $title = "Клиенты";
    require_once "../head.php";
?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "klient";
        require_once '../header.php';
        require_once 'utils.php';

        $filter = '';
        if(isset($_POST['filter_name_klient']) && ($nameKlientF = $_POST['filter_name_klient'])){
            $filter .= " WHERE `name_klient` LIKE '%$nameKlientF%'";
            $hideAddress = true;
        }

        if(isset($_POST['filter_number_passport']) && ($numberPassportF = $_POST['filter_number_passport'])){
            if($filter === ''){
                $filter.= " WHERE ";
            }else{
                $filter.= " AND ";
            }

            $filter.= "`number_passport` = $numberPassportF";
            $hideNumberPassport = true;

        }

        $tableRows = $mysqli -> query("SELECT * FROM `klient` $filter");
    ?>
    <div class="container text-center">
        <form method="post">
            <label>
                ФИО клиента
                <input type="text" name="filter_name_klient" value="<?= $nameKlientF ?? ''?>">
            </label>
            <button name="action" value="filter">Отбор</button>
        </form>

        <form method="post">
            <label>
                Номер паспорта
                <input type="text" name="filter_number_passport" value="<?= $numberPassportF ?? ''?>">
            </label>

            <button name="action" value="filter">Отбор</button>
        </form>

        <a href="view.php">Сбросить</a>
        <?php if($tableRows && $tableRows -> num_rows > 0 ){?>
        <table class="table dict">
            <thead>
                <tr>
                    <th scope="col">Имя клиента</th>
                    <th scope="col">Телефон</th>
                    <th scope="col" class="<?= isset($hideNumberPassport) && $hideNumberPassport ? 'd-none' : ''?>">Номер паспорта</th>
                    <th scope="col" class="<?= isset($hideAddress) && $hideAddress ? 'd-none' : ''?>">Адрес</th>
                    <th scope="col"><a type="button" class="btn btn-success" href="add.php">Добавить</a></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $tableRows -> fetch_assoc()){ extract($row)?>
                <tr>
                    <td ><?= $name_klient?></td>
                    <td ><?= $klient_fon?></td>
                    <td class="<?= isset($hideNumberPassport) && $hideNumberPassport ? 'd-none' : ''?>"><?= $number_passport?></td>
                    <td class="<?= isset($hideAddress) && $hideAddress ? 'd-none' : ''?>"><?= $adress?></td>
                    <td class="btns"> 
                        <a type="button" class="btn btn-secondary" href="edit.php?id=<?=$id_klient?>">Редактировать</a>
                        <a type="button" class="btn btn-secondary <?= disabledDelete($id_klient) ? 'disabled' : '' ?>" href="delete.php?id=<?=$id_klient?>" onclick='return confirm(`Вы действительно хотите удалить запись "<?="$name_klient - $klient_fon"?>"?`);'>Удалить</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }else{?>
            <div class="alert alert-warning" role="alert">
                Нет записей
            </div>
        <?php } ?>
    </div>

<?php
    include '../footer.php';
?>

</body>
</html>