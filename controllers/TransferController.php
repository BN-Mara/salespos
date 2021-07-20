<?php
session_start();
include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});
?>
<?php

//echo $_POST['catId'];

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{
    $userC= new TransferController();
    if($_POST['action'] == "add"){
        $userC->createTransfer();

    }
    else if($_POST['action'] == "approve"){
        $userC->approveTransfer();
    }
    

}

class TransferController{
    private $dao;
    private $fm;
    public function __construct()
    {
        $this->dao = new Dao_Carte();
        $this->fm = new Format();
        
    }
    public function createTransfer(){

    }
    public function approveTransfer(){

    }
}