<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("DICTONARY_TABLES", ["s_accoount", "s_operation"]);
define("DICTONARY_TABLES_STRUCT",
    [
        "s_accoount" => ["id" => "id_account", "name" => "name_account", "ref_table" => "schet"],
        "s_operation" => ["id" => "id_operation", "name" => "name_operation", "ref_table" => "oper_klient"]
    ]);
define("DICTONARY_TABLES_NAME", ["s_accoount" => "Виды аккаунтов", "s_operation" => "Виды операций"]);


$mysqli = mysqli_connect("localhost", "root", "root", "shpagin_podolskiy", "3306");

if ($mysqli === false) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}