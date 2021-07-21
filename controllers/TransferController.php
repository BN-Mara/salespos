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
    public function createTransfer(stockTransfer $stockTransfer){
        $this->dao->transferStockToPOS($stockTransfer);

    }
    public function approveTransfer(){

    }
    public function addToTransferCart(){

    }
}