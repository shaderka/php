<?php
function disabledDelete($id){
    global $mysqli;
    $result = $mysqli -> query("SELECT * FROM `oper_klient` WHERE `id_schet` = $id");
    return $result -> num_rows > 0;
}