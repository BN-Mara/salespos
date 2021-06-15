<?php
session_start();
include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{  
   
    if(isset($_POST['idRef'])){
        $dao = new Dao_Carte();
        $common = new CommonController($dao);
        $data = $common->getSalesDetails($_POST['idRef']);
        echo $data;
    }

}

class CommonController{
    private $dao;

    public function __construct(Dao_Carte $dao)
    {
        $this->dao = $dao;
    }
    public function getSalesDetails($idRef){
        $data = $this->dao->detailSalesPOS($idRef);
        $data = json_encode($data);
        return $data;

    }
    
}