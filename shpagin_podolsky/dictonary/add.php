<?php
    require_once "../bd.php";

    $validated = isset($_GET['table'])
        && ($curent_table = $_GET['table'])
        && in_array($curent_table, DICTONARY_TABLES);

    if(!$validated){
        echo "Неверные параметры";
        die();
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
    Добро пожаловать
</div>

<?php
include '../footer.php';
?>
</body>
</html>
