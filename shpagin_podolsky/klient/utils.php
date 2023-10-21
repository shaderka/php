<?php
function disabledDelete($id){
    global $mysqli;
    $result = $mysqli -> query("SELECT * FROM `schet` WHERE `id_klient` = $id");
    return $result -> num_rows > 0;
}