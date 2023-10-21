<?php

define("DICTONARY_TABLES", ["s_accoount", "s_operation"]);
define("DICTONARY_TABLES_STRUCT",
    [
        "s_accoount" => ["id" => "id_account", "name" => "name_account"],
        "s_operation" => ["id" => "id_operation", "name" => "name_operation"]
    ]);
define("DICTONARY_TABLES_NAME", ["s_accoount" => "Виды аккаунтов", "s_operation" => "Виды операций"]);


$mysqli = mysqli_connect("localhost", "root", "", "shpagin_podolskiy", "3308");

if ($mysqli === false) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    die();
}