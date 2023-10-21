<?php
require_once "../bd.php";

$validated = isset($_GET['table'])
                && ($curent_table = $_GET['table'])
                && in_array($curent_table, DICTONARY_TABLES)
                && isset($_GET['id']) && is_numeric($_GET['id']);

if(!$validated){
    echo "Ошибка в параметрах";
    die();
}

try {
    $mysqli->query("DELETE FROM $curent_table WHERE `".DICTONARY_TABLES_STRUCT[$curent_table]['id']."` = {$_GET['id']}");
}catch (Exception $e){
    echo "Ошибка при удалении записи";
    die();
}

header("Location: view.php?table=$curent_table");
exit;