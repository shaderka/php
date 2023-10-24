<?php
    require_once "../bd.php";

    $validated = isset($_GET['table'])
        && ($curent_table = $_GET['table'])
        && in_array($curent_table, DICTONARY_TABLES);

    if(!$validated){
        echo "Неверные параметры";
        die();
    }

    if(isset($_POST["name"]) && ($newRecName = $_POST["name"])){
        $result = $mysqli -> query("SELECT * FROM $curent_table WHERE `".DICTONARY_TABLES_STRUCT[$curent_table]['name']."` = '$newRecName'");

        $count = mysqli_num_rows($result);

        if($count == 0){
            $result = $mysqli -> query("INSERT INTO `$curent_table` VALUES (NULL, '$newRecName')");

            if($result){
                $resultCode = "success";
                $message = "Запись \"$newRecName\" успешно добавлена";
            }else{
                $resultCode = "danger";
                $message = "Ошибка при добавлении записи";
            }

        }else{
            $resultCode = "warning";
            $message = "Запись с таким названием уже есть";
        } 
    }elseif($_SERVER['REQUEST_METHOD'] === "POST"){
            $resultCode = "warning";
            $message = "Заполните значения";
    }

    $title = "Добавление записи в справочник \"".DICTONARY_TABLES_NAME[$curent_table]."\"";
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
    <form method="post" class="form">
        <div class="form-group">
            <label for="formGroupExampleInput">Название</label>
            <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Введите новую запись">
        </div>
        <button type="submit" class="btn btn-secondary">Сохранить</button>
        <a href="/shpagin_podolsky/dictonary/view.php?table=<?=$curent_table?>" class="btn btn-secondary">Назад</a>
    </form>
</div>

<?php
include '../footer.php';
?>
</body>
</html>
