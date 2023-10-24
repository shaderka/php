<?php
require_once '../bd.php';

$validate = isset($_GET['id'])
            && ($id = $_GET['id'])
            && (is_numeric($id))
            && ($id = (int) $id);

if($validate){
    try {
        $mysqli -> query("DELETE FROM `oper_klient` WHERE `id_operklient` = $id");
    }catch (Exception $e){
        echo "Ошибка";
    }
}

header('Location: view.php');
exit;