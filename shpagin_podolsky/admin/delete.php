<?php
require_once "utils.php";
checkAuth();

require_once "../bd.php";

$validated = isset($_GET['id'])
            && ($id = $_GET['id'])
            && (is_numeric($id))
            && ($id = (int) $id);

if($validated){
    @$mysqli -> query("DELETE FROM `admin` WHERE `id_admin` = $id");
}

header("Location: administration.php");
exit;