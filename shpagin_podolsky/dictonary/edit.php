<?php
    require_once "../bd.php";

    $validated = isset($_GET['table'])
        && ($curent_table = $_GET['table'])
        && in_array($curent_table, DICTONARY_TABLES)
        && isset($_GET['id']) && is_numeric($_GET['id']);

    if(!$validated){
        echo "Неверные параметры";
        die();
    }

    $result = $mysqli -> query("SELECT * FROM $curent_table WHERE `".DICTONARY_TABLES_STRUCT[$curent_table]['id']."` = {$_GET['id']} LIMIT 1");

    if(!($rec = $result -> fetch_assoc())){
        echo "Нет такой записи";
        die();
    }

    $rec = array_values($rec);

    if(isset($_POST["name"]) && ($newRecName = $_POST["name"])){
        $result = $mysqli -> query("SELECT * FROM $curent_table WHERE `".DICTONARY_TABLES_STRUCT[$curent_table]['name']."` = '$newRecName' AND `".DICTONARY_TABLES_STRUCT[$curent_table]['id']."` != {$rec[0]}");

        $count = mysqli_num_rows($result);

        if($count === 0){
            $result = $mysqli -> query(
                "UPDATE $curent_table 
                SET `".DICTONARY_TABLES_STRUCT[$curent_table]['name']."` = '$newRecName'
                WHERE `".DICTONARY_TABLES_STRUCT[$curent_table]['id']."` = ".$_GET['id']
            );
            if($result){
                $resultCode = "success";
                $message = "Запись успешно изменена";
            }else{
                $resultCode = "danger";
                $message = "Ошибка при изменении записи";
            }
        }else{
            $resultCode = "warning";
            $message = "Запись с таким названием уже есть";
        }


    }elseif($_SERVER['REQUEST_METHOD'] === "POST"){
        $resultCode = "warning";
        $message = "Заполните значения";
    }

    $title = "Изменение записи №{$_GET['id']}";
    require_once "../head.php";
?>
<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "dictonary";
include '../header.php';
?>
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post">
        <div class="form-group">
            <label for="formGroupExampleInput">Название</label>
            <input type="text" class="form-control" value="<?= $rec[1]?>" name="name" id="formGroupExampleInput" placeholder="Введите новую запись">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-secondary">Сохранить</button>
            <a href="/shpagin_podolsky/dictonary/view.php?table=<?=$curent_table?>" class="btn btn-secondary">Назад</a>
        </div>
    </form>
</div>

<?php
include '../footer.php';
?>
</body>
</html>
