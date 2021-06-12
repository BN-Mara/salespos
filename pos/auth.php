<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 29/06/2020
 * Time: 10:15
 */

session_start();

include_once '../models/Dao_Carte.php';
require_once("../models/Client.php");

$response=new Dao_Carte();

if(isset($_POST['login'])){
    //check username and password then set to session
    $c_usnm = $_POST['usrname'];
    $c_psswd = $_POST['psw'];
    $chk = $response->getOneUserByPassword($c_usnm,$c_psswd);
    //var_dump($chk);
    if($chk){
        $_SESSION['user'] = $chk;
        header("location:index.php");

    }else{

        $_SESSION['info'] = "<p>identification incorrecte!</p>";
        header("location:login.php");
    }

}