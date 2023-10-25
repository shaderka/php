<?php

require_once "../bd.php";

function checkAuth(){
    session_start();
    if(empty($_SESSION['auth'])){
        header('Location: login.php');
        exit();
    }
}

function getAdmin($id){
    global $mysqli;
    $result = $mysqli -> query("SELECT * FROM `admin` WHERE `id_admin` = $id");
    return $result -> fetch_assoc();
}