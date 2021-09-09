<?php
session_start();
include_once '../helper/Format.php';
include_once '../controllers/IccidController.php';
include_once '../controllers/ImeiController.php';
include_once '../controllers/SerialController.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});
?>
<?php

//echo $_POST['catId'];

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{
    $userC= new StockController();
    $userC->makeStock();

}
class StockController
{
    public function __construct()
    {
    }
    public function makeStock()
    {
        $stock = new Stock();
        ///
        $dao = new Dao_Carte();
        //
        $fm = new Format();


//end bn-mara
        $id_product = $fm->validation($_POST['id_product']);
        $id_product2 = explode(',',$id_product);
        $id_product = $id_product[0];

        $qte = $fm->validation($_POST['qte']);
        $id_pos = $fm->validation($_POST['id_pos']);
        $action = $fm->validation($_POST['action']);

        $addedBy = $_SESSION['current_user'];


        //*****************************************

        $stock->setIdProduct($id_product);
        $stock->setQuantity($qte);
        $stock->setIdPos($id_pos);
        // $myuser->setMatricule($matricule);
        // $myuser->setFonction($fonction);
        // $myuser->setDirection($direction);
        if($id_product2[1] != 4){
            if($id_product2[1] != 3){
            if(isset($_FILES["imei_csv"]) && isset($_FILES["iccid_csv"])){
                //upload imeis
                $imeiC = new ImeiController();
                $iccidC = new IccidController();
                $uploadImei = $imeiC->uploadFromCSV();
                $uploadIccid = $iccidC->uploadFromCSV();
                
                if($uploadImei == -1){
                    $info = "ce fichier contient des Imeis non valids ou deja importes!";
                    $_SESSION['infoerror'] = $info;
                     header("location:../admin/layout.php?page=addStock");
                    return;
                    exit;
                }else if($uploadIccid == -1){
                    $info = "ce fichier contient des Iccids non valids ou deja importes!";
                    $_SESSION['infoerror'] = $info;
                     header("location:../admin/layout.php?page=addStock");
                    return;
                    exit;
                }else if($uploadIccid == -2){
                    $info = "le format du fichier n est pas valid!";
                    $_SESSION['infoerror'] = $info;
                     header("location:../admin/layout.php?page=addStock");
                    return;
                    exit;
                }else if($uploadIccid == 0){
                    $info = "Ce fichier contient de  POS ou code produit non valid";
                    $_SESSION['infoerror'] = $info;
                     header("location:../admin/layout.php?page=addStock");
                    return;
                    exit;
                }
                $stock->setQuantity($uploadImei);
    
            }else{
                $info = "Importer les Imeis et Iccids des SIMs des ce produit, svp!";
                $_SESSION['infoerror'] = $info;
                header("location:../admin/layout.php?page=addStock");
                return;
                exit;
            }
            }
            else{
                if(isset($_FILES["serial_csv"])){
                $serial = new SerialController();
                $uploadSerial = $serial->uploadFromCSV();
                
                    if($uploadSerial == -1){
                        $info = "ce fichier contient des Serials non valids ou deja importes!";
                        $_SESSION['infoerror'] = $info;
                        header("location:../admin/layout.php?page=addStock");
                        return;
                        exit;
                    }else if($uploadSerial == -2){
                        $info = "le format du fichier n'est pas valid!";
                        $_SESSION['infoerror'] = $info;
                         header("location:../admin/layout.php?page=addStock");
                        return;
                        exit;
                    }else if($uploadSerial == 0){
                        $info = "Ce fichier contient de  POS ou code produit non valid";
                        $_SESSION['infoerror'] = $info;
                         header("location:../admin/layout.php?page=addStock");
                        return;
                        exit;
                    }
                    $stock->setQuantity($uploadSerial);
                
                }else{
                    $info = "Importer les serials du scratch, svp!";
                    $_SESSION['infoerror'] = $info;
                    header("location:../admin/layout.php?page=addStock");
                    return;
                    exit;
                }
                
            }

        }
        

        if($action == "ajouter"){

        $row = $dao->getStockByIdProductAndIdPOS($stock->getIdProduct(),$stock->getIdPos());
        if ($row) {

            //$id = $fm->validation($_POST['bnid']);
            $response = $dao->editProductStock($stock);
            $dao->addStockTransaction($stock, $addedBy);
            $info = "La Modification a été effectuée avec succès";

            if ($response == "success") {
                //die($action);
                $_SESSION['info'] = $info;

                header("location:../admin/layout.php?page=addStock");
            }


        } else {


            $response = $dao->addStock($stock);
            $dao->addStockTransaction($stock, $addedBy);
            $info = "Les Information ont été ajoutées avec succès";
            $_SESSION['info'] = $info;

            if ($response == "success") {
                //die($action);

                header("location:../admin/layout.php?page=addStock");
            }


        }
    }






    }

}
