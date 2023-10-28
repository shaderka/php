<?php
require_once "../bd.php";

function getClientById($id){
    global $mysqli;
    $result = $mysqli -> query("SELECT * FROM `klient` WHERE `id_klient` = $id");
    return $result -> fetch_assoc();
}

$validate = isset($_GET['id'])
            && ($id = $_GET['id'])
            && (is_numeric($id))
            && ($id = (int)$id)
            && ($oldData = getClientById($id));
if(!$validate){
    echo "Неверные данные";
    die();
}

extract($oldData);


$title = "Редактирование записи \"$name_klient - $klient_fon\"";
require_once "../head.php";

if(
    isset($_POST['fio'])
    && ($newFIO = $_POST['fio'])
    && (isset($_POST['tel']))
    && ($newTel = $_POST['tel'])
    && (isset($_POST['address']))
    && ($newAddress = $_POST['address'])
    && (isset($_FILES['img']) && ($imgData = $_FILES['img']))
){
    $imgName = $imgData['tmp_name'] ?? false;
    $newPassport = $_POST['passport'] ?? null;
    $passportSearch = $newPassport ? " OR `number_passport` = '$newPassport'" : "";
    $result = $mysqli -> query("SELECT * FROM `klient` WHERE (`klient_fon` = '$newTel'$passportSearch) AND  `id_klient` != $id_klient");
    $count = $result -> num_rows;

    if($count === 0){
        $passportSQLStr = $newPassport ? "'$newPassport'" : "NULL";

        $imgnameSQLStr = '';
        if($imgName){
            $image = @file_get_contents($imgName);
            if($image) {
                $imageType = $imgData['type'];
                $imgnameSQLStr = "data:$imageType;base64, ".base64_encode($image);
                $imgnameSQLStr = ", `image` = '$imgnameSQLStr'";
                unset($image);
            }else{
                $resultCode = "danger";
                $message = "Ошибка при загрузке изображения";
            }
        }

        $result = $mysqli -> query("UPDATE `klient` SET `name_klient` = '$newFIO', `klient_fon` = '$newTel',
                    `number_passport` = $passportSQLStr, `adress` = '$newAddress' $imgnameSQLStr WHERE `id_klient` = $id_klient");

        unset($imgnameSQLStr);
        if($result){
            $resultCode = "success";
            $message = "Запись успешно изменена";
            extract(getClientById($id_klient));
        }else{
            $resultCode = "danger";
            $message = "Ошибка при изменении записи: ". $mysqli->error;
        }

    }else{
        $resultCode = "warning";
        $message = "Клиент с такими данными уже существует в системе";
    }
}elseif($_SERVER['REQUEST_METHOD'] === "POST"){
    $resultCode = "warning";
    $message = "Заполните значения";
}

?>

<body class="d-flex flex-column min-vh-100">
<?php
$current_page = "klient";
include '../header.php';
?>
<div class="container text-center">
    <?php if(isset($resultCode) && isset($message)) {?>
        <div class="alert alert-<?=$resultCode?>" role="alert">
            <?= $message?>
        </div>
    <?php } ?>
    <form method="post" class="form" enctype="multipart/form-data">
        <div class="form-group imgSelect">
            <img src="<?= $image ?>" id="img" class="img-thumbnail" alt="">
            <input type="file" class="form-control" accept="image/jpeg, image/png" name="img" id="InputImg" onchange="readURL(this)">
        </div>
        <div class="form-group">
            <label for="exampleInputFIO">ФИО клиента</label>
            <input type="text" class="form-control" id="exampleInputFIO" name="fio" value="<?=$name_klient?>">
        </div>
        <div class="form-group">
            <label for="exampleInputTel">Телефон</label>
            <input type="tel" class="form-control" id="exampleInputTel" name="tel" value="<?=$klient_fon?>">
        </div>
        <div class="form-group">
            <label for="exampleInputPassport">Номер паспорта</label>
            <input type="text" class="form-control" id="exampleInputPassport" name="passport" value="<?=$number_passport ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputAdres">Адрес</label>
            <input type="text" class="form-control" id="exampleInputAdres" name="address" value="<?=$adress?>">
        </div>
        <button type="submit" class="btn btn-secondary">Изменить</button>
        <a href="view.php" class="btn btn-secondary">Назад</a>
    </form>
</div>

<?php
include '../footer.php';
?>
</body>
<script>

function readURL(evt) {
    var file = evt.files;
    if(file.length > 0){
        var reader = new FileReader();

        reader.onload = function(event) {
            document.getElementById('img').setAttribute("src",event.target.result);
        };

        reader.readAsDataURL(file[0])
    }
}
</script>
</html>