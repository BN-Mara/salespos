<?php
session_start();
include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});
?>
<?php


if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{
    $transC= new TransferController();
    if(isset($_POST['action'])){
        if($_POST['action'] == "approve"){
            $transC->approveTransfer();
        }elseif($_POST['action'] == "cancel"){
            $transC->cancelTransfer();
        } 

    }
    else if(isset($_POST['detailId'])){
        $transC->getDetails();
        //var_dump($_POST);
        //return;

    }
    else{

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
    
    public function approveTransfer(){
        $idTransRef = $_POST['id_trans_reference'];
        $msg = $_POST['message'];
        $checkSts = $this->dao->getTransferStatus($idTransRef);
        if($checkSts == "APPROVED" || $checkSts == "CANCELED"){
            $info = "This transfer cannot be approved, because it is already approved or canceled.";
            $data = ["info"=>$info];
            echo json_encode($data);
            return false;
            exit;
        }
        $res = $this->dao->getStockAndRefTransferByIdRef($idTransRef);
        if($res){
            foreach($res as $rs){
                $stock  = new Stock();
                $stock->setIdProduct($rs['id_product']);
                $stock->setQuantity($rs['quantity']);
                $stock->setIdPos($rs['id_pos_to']);
                $test = $this->dao->getStockByIdProductAndIdPOS($stock->getIdProduct(),$stock->getIdPos());
                if($test){
                    $this->dao->editProductStock($stock);
                    $this->dao->addStockTransaction($stock, $rs['addedBy']);
                }else{
                    $this->dao->addStock($stock);
                    $this->dao->addStockTransaction($stock, $rs['addedBy']);
                }
                $this->dao->updateProduitQuantity($rs['quantity'],$rs['id_product'],$rs['id_pos_from']);
                //$imei = $this->dao->getImeiByIdProductAndIdPOS($rs['id_product'],$rs['id_pos_from']);

                $extra  = $this->dao->getTransferExtraByIdTransfer($rs['id_transfer'],$rs['id_product']);
                foreach($extra as $ex){
                   
                    $this->dao->updateImeiPOS($rs['id_pos_from'],$rs['id_pos_to'],$ex['imei']);
                    $this->dao->updateiccidPOS($rs['id_pos_from'],$rs['id_pos_to'],$ex['iccid']);
                    //$this->dao->   
               } 
                
            }

            $updt = $this->dao->approveStockTransfer($idTransRef,$_SESSION['current_user'],$msg);
            if($updt  ==  "success"){
                $info = "Transfer approved successfully";
                //$_SESSION['info'] = $info;
                $data = json_encode(["info"=>$info]);
                //header("location:../admin/layout.php?page=addStock");
                echo $data;
            }else{
                echo $updt;
            }
            
        }

    }
    public function cancelTransfer(){
        $idTransRef = $_POST['id_trans_reference'];
        $msg = $_POST['message'];
        $checkSts = $this->dao->getTransferStatus($idTransRef);
        if($checkSts == "APPROVED"){
            $info = "This Transfer is already Approved";
            $data = json_encode(["info"=>$info]);
            echo $data;
            return;
        }else if($checkSts == "CANCELED"){
            $info = "This Transfer is already CANCELED";
            $data = json_encode(["info"=>$info]);
            echo $data;
            return;
        }else{
            $res =  $this->dao->cancelStockTransfer($idTransRef,$_SESSION['current_user'],$msg);
            if($res == "success"){
                $info = "Transfer canceled.";
                //$_SESSION['info'] = $info;
                $data = json_encode(["info"=>$info]);
                echo $data;
                //header("location:../admin/layout.php?page=addStock");

            }else{
                echo $res;
            }
            

        }
    }
    public function getDetails(){
        $id = $_POST['detailId'];
        $res = $this->dao->getStockTransferByIdRef($id);
        echo json_encode($res);
    }
}