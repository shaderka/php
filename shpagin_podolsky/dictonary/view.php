<?php
    $title = "Справочники";
    require_once "../head.php";
?>
<body class="d-flex flex-column min-vh-100">
    <?php
        $current_page = "dictonary";
        require_once '../header.php';
        $curent_table = isset($_GET['table']) && in_array($_GET['table'], DICTONARY_TABLES)
                        ? $_GET['table'] : "s_accoount";

        $result = $mysqli->query("SELECT * FROM $curent_table");

        $tableRows = [];
        while($row = $result->fetch_assoc()){
            $row = array_values($row);
            $tableRows[] = [
                "id" => $row[0],
                "name" => $row[1]
            ];
        }
        
    ?>
    <div class="container text-center">
    <div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-black bg-white" style="width: 280px;">
            <span class="fs-4">Список справочников</span>
            <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="/shpagin_podolsky/dictonary/view.php?table=s_accoount" class="nav-link <?= $curent_table == "s_accoount" ? "active" : "" ?>">
                            Виды счета
                        </a>
                    </li>
                    <li>
                        <a href="/shpagin_podolsky/dictonary/view.php?table=s_operation" class="nav-link <?= $curent_table == "s_operation" ? "active" : "" ?>">
                            Виды операций
                        </a>
                    </li>
                </ul>
            <hr>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-8">
    <table class="table dict">
        <thead>
            <tr>
                <th scope="col" width="65%">Название</th>
                <th scope="col"><a type="button" class="btn btn-success" href="/shpagin_podolsky/dictonary/add.php?table=<?=$curent_table?>">Добавить</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tableRows as $row) { ?>
            <tr>
                <td width="65%"><?= $row["name"] ?></td>
                <td class="btns"> 
                    <a type="button" class="btn btn-secondary">Редактировать</a> 
                    <a type="button" class="btn btn-secondary" href="/shpagin_podolsky/dictonary/delete.php?table=<?=$curent_table?>&id=<?=$row["id"]?>">Удалить</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
  </div>
</div>

<?php
    include '../footer.php';
?>

</body>
</html>