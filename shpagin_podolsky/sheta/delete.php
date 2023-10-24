<?php
require_once '../bd.php';
require_once 'utils.php';

$validate = isset($_GET['id'])
            && ($id = $_GET['id'])
            && (is_numeric($id))
            && ($id = (int) $id)
            &&  !disabledDelete($id);

if($validate){
    try {
        $mysqli -> query("DELETE FROM `schet` WHERE `id_schet` = $id");
    }catch (Exception $e){
        echo "Ошибка";
    }
}

header('Location: view.php');
exit;