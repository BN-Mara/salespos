<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 30/06/2020
 * Time: 08:42
 */
session_start();
include_once '../../models/Dao_Carte.php';

if(isset($_GET['id'])){
    $dao = new Dao_Carte();
    $id = $_GET['id'];
    $res = $dao->updatePlainteStatus($id);
    $_SESSION['info'] = "Statut a été changé avec succès";
    header("location: ../../layout.php?page=plaintes");
}