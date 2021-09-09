<?php
session_start();
ob_start();
include_once '../models/Dao_Carte.php';
require_once("../models/Client.php");
require_once("../models/Commande.php");
require_once("../models/SaleReference.php");
require_once("../models/SalesCredit.php");
require_once("../models/ProductExchange.php");
require_once("../models/SaleImei.php");
require_once('../TCPDF-master/tcpdf.php');
require_once('../models/TransferExtra.php');
require_once('../models/StockTransfer.php');
require_once('../models/StockTransferReference.php');

if($_SESSION['user']['role'] != "POS_SUPERVISOR"){
    $info = "Vous n'etes pas Permis. contacter l'admin ";
    $_SESSION['info'] = $info;

    header("location: index.php");
    return;  
}
 
$response=new Dao_Carte();
$produits = $response->getAll();

if(isset($_POST['idRef'])){
$data = $response->detailSalesPOS($_POST['idRef']);
$arr = array();

$data = json_encode($data);
//die(var_dump($data));
echo $data;

}

if(isset($_POST['new_cust']) || isset($_POST['new_cust_pl'])){

    $c_name = $_POST['noms'];
    $c_prename = $_POST['prenom'];
    $c_postname = $_POST['postnom'];
    $c_address = $_POST['address'];
    $c_tel = $_POST['tel'];
    $c_ref = $_POST['idcard'];
    $client = new Client();
    $client->setNom($c_name);
    $client->setPostom($c_postname);
    $client->setPrenom($c_prename);
    $client->setAdresse($c_address);
    $client->setTel($c_tel);
    $client->setIdcard($c_ref);
    $client->setAddedBy($_SESSION['user']['username']);
    $res = $response->addClient($client);
    $clients = $response->getAllCustomer();
    if(isset($_POST['new_cust_pl'])){
        header("location: index.php?page=plainte");
    }else{
        header("location: index.php?page=stockTransfert");
    }

}

if(isset($_POST['check_extra_imei'])){
    $pdt_id =  $_POST['id_product'];
    $imei_c = $_POST['imei'] ;
    $pos_c = $response->getPOSByUsername($_SESSION['user']['username']);
    //die($pdt_id.$pos_c.$imei_c);
    $imei =  $response->checkProductImeiPOS($pdt_id,$pos_c,$imei_c);
    $checkSold = $response->checkExistingSaleExtra("imei",$imei_c);
    //die($checkSold);
        $dataR = ['imei'=>$imei,"sold"=>$checkSold];
        echo json_encode($dataR);
    
   
}
if(isset($_POST['check_extra_iccid'])){
    $pdt_id =  $_POST['id_product'];
    $iccid_c = $_POST['iccid'];
    //die($pdt_id.$pos_c.$iccid_c);
    $pos_c = $response->getPOSByUsername($_SESSION['user']['username']);
    $iccid = $response->checkProductIccidPOS($pdt_id,$pos_c,$iccid_c);
    $checkSold = $response->checkExistingSaleExtra("iccid",$iccid_c);
    $dataR = ['iccid'=>$iccid,"sold"=>$checkSold];
    echo json_encode($dataR);
}
if(isset($_POST['check_extra_msisdn'])){
    $pdt_id =  $_POST['id_product'];
    $msisdn_c = $_POST['msisdn'];
    $pos_c = $response->getPOSByUsername($_SESSION['user']['username']);
    $msisdn = $response->checkProductMsisdnPOS($pdt_id,$pos_c,$msisdn_c);
    $checkSold = $response->checkExistingSaleExtra("msisdn",$msisdn_c);

    $dataR = ['msisdn'=>$msisdn,"sold"=>$checkSold];
    echo json_encode($dataR);
    
}

if(isset($_POST['check_extra_serial'])){
    $pdt_id =  $_POST['id_product'];
    $serial_c = $_POST['serial'] ;
    $pos_c = $response->getPOSByUsername($_SESSION['user']['username']);
    //die($pdt_id.$pos_c.$imei_c);
    $serial =  $response->checkProductSerialPOS($pdt_id,$pos_c,$serial_c);
    $checkSold = $response->checkExistingSaleExtra("serial",$serial_c);
    
        $dataR = ['serial'=>$serial,"sold"=>$checkSold];

        echo json_encode($dataR);

}

if(isset($_POST['getname'])){
    //unset($_SESSION['client_phone']);
    $name = $_POST['getname'];
    $row = $response->findClientByName($name);
    if($row){
    foreach ($row as $item) {
        $fname = $item['firstname'];
        $mname = $item['middlename'];
        $lname = $item['lastname'];
        $id = $item['id_client'];
        $func = "valid_client(".$id.")";
        echo '<li class="list-group-item" onclick="'.$func.'">'.$lname." ".$mname." ".$fname."</li>";
    }
    }else{

        $_SESSION['newclient_name'] = $name;
        unset($_SESSION['client_name']);
        echo "no";
    }
}
if(isset($_POST['getphone'])){
    unset($_SESSION['client_phone']);
    $phone = $_POST['getphone'];
    $row = $response->findClientByPhone($phone);
    if($row)
        foreach ($row as $item) {
            $fname = $item['firstname'];
            $mname = $item['middlename'];
            $lname = $item['lastname'];
            $id = $item['id_client'];
            $func = "valid_client(".$id.")";
            echo '<li class="list-group-item" onclick="'.$func.'">'.$lname." ".$mname." ".$fname."</li>";

        }else{

        $_SESSION['newclient_phone'] = $phone;
        unset($_SESSION['client_phone']);
        echo "no";

    }

}


if(isset($_POST['validerClient'])){
    $_SESSION['id_client'] = $_POST['client'];

    $client_name = $response->getOneClientById($_POST['client']);
    //var_dump($client_name);
    $_SESSION['client_name'] = $client_name['lastname'];
    header("location: index.php?page=stockTransfert");

}
if(isset($_POST['setpos'])){
    $_SESSION['id_pos_to'] = $_POST['setpos'];
  
    $data = ['pos'=>$_POST['setpos']];
    echo json_encode($data);

}

if(isset($_POST['addtocart'])){
    if(!empty($_POST["qt"])) {
        $productByCode = $response->getOneProductById($_POST['produit']);
        //var_dump($productByCode);
        $taux = $response->getRate();
        $price_taux = $productByCode["price"] * $taux[0]['rate'];
        $itemArray = array($productByCode["code"]=>array('id_produit'=>$productByCode["id_product"],'name'=>$productByCode["designation"], 'code'=>$productByCode["code"], 'quantity'=>$_POST["qt"], 'price'=>$price_taux,'category'=>$productByCode["id_category"]));
        $id_pos = $response->getOnePOSByUser($_SESSION['user']['username']);
        $_SESSION['pos'] = $id_pos;
        $product_stock = $response->getStockByIdProductAndIdPOS($_POST['produit'],$id_pos);

        //die($product_stock["quantity"]);
        $p_qt = $product_stock["quantity"];
        if($_POST['qt'] <= $p_qt ){
            if(!empty($_SESSION["transfer_item"])) {
                if(in_array($productByCode["code"],array_keys($_SESSION["transfer_item"]))) {
                    foreach($_SESSION["transfer_item"] as $k => $v) {
                        if($productByCode["code"] == $k) {
                            if(empty($_SESSION["transfer_item"][$k]["quantity"])) {
                                $_SESSION["transfer_item"][$k]["quantity"] = 0;
                            }
                            $_SESSION["transfer_item"][$k]["quantity"] = $_POST["qt"];
                        }
                    }
                } else {
                    $_SESSION["transfer_item"] = array_merge($_SESSION["transfer_item"],$itemArray);
                }
                header("location: index.php?page=stockTransfert");
            } else {
                $_SESSION["transfer_item"] = $itemArray;
                header("location: index.php?page=stockTransfert");
            }
        }else{
            $_SESSION['info'] = '<h3>Attention!</h3>Le Stock du produit choisi est insuffisant..<br><br>';
            header("location: index.php?page=stockTransfert");
        }

    }

}

if(isset($_GET['action'])){
    if($_GET['action'] == 'remove'){
        if(!empty($_SESSION["transfer_item"])) {
            foreach($_SESSION["transfer_item"] as $k => $v) {
                if($_GET["code"] == $k)
                    unset($_SESSION["transfer_item"][$k]);
                if(empty($_SESSION["transfer_item"]))
                    unset($_SESSION["transfer_item"]);
            }
            header("location: index.php?page=stockTransfert");
        }
    }
}
if(isset($_POST['valider']) ){
    if($_SESSION['user']['role'] != "POS_SUPERVISOR"){
        $info = "Vous n'etes pas Permis. contacter l'admin ";
        $_SESSION['info'] = $info;

        header("location: index.php");
        return;  
    }
                      
    if(!isset($_SESSION['id_pos_to']) || $_SESSION['id_pos_to'] == ""){
        $info = "Choisissez le POS ";
        $_SESSION['info'] = $info;

        header("location: index.php?page=stockTransfert");
        return;
    }else{
        if($_SESSION['id_pos_to'] == $_SESSION['pos']){
            $info = "Impossible de transferer a votre POS, choisissez un autre";
            $_SESSION['info'] = $info;

            header("location: index.php?page=stockTransfert");
            return;

        }
        if(!empty($_SESSION["transfer_item"])){
            //$order_id = addOrder($_POST['id_pos']);
            $total_price = 0;
            $total_quantity = 0;
           
            foreach ($_SESSION["transfer_item"] as $item) {
                $item_price = $item["quantity"] * $item["price"];

                $imeis = "";
                    //$item_price = $item["quantity"]*$item["price"];
                    $check_qt = $item["quantity"];
                   /* for($i=0; $i < $item["quantity"]; $i++) {

                        $index = "imei_" . $item['id_produit'] . $i;
                        if(($check_qt - 1) > 0){
                            $imeis = $imeis.$_POST[$index].",";
                            $check_qt = $check_qt - 1;
                        }else{
                            $imeis = $imeis.$_POST[$index];
                        }

                    }*/
                    $trans_ref_id = addTransferReference();

                    validerTransfer($item["id_produit"],$item["quantity"],$item["price"],
                    $item_price, $imeis,$trans_ref_id,$item["category"]);

                //echo "$ " . number_format($item_price, 2);
                $total_quantity += $item["quantity"];
                $total_price += ($item["price"] * $item["quantity"]);
            }
            $user = $_SESSION['user'];
            $cart = $_SESSION['transfer_item'];
            $clienid = $_SESSION['id_pos_to'];
            session_unset();
            $_SESSION['user'] = $user;

            //$download = downloadForm($cart,$clienid,$order_id);

            $_SESSION['info_success']='<h3>Success!</h3>Commande effectuée avec succès<br><br>';

        }else{
            $_SESSION['info'] = "<h3>ERREUR!</h3> votre commade est vide, ajouter au moins un produit<br><br>";
        }


        echo "<script>window.location.href='index.php?page=stockTransfert';</script>";


    }

}

function addImei($idTrans){
    $saleimeis = new TransferExtra();
    $response = new Dao_Carte();
    if(isset($_SESSION["transfer_item"])){
        $total_quantity = 0;
        $imeis = "";

        foreach ($_SESSION["transfer_item"] as $item){
        //$item_price = $item["quantity"]*$item["price"];
            $item["quantity"];
            for($i=0; $i < $item["quantity"]; $i++) {

                $index_i = "imei_" . $item['id_produit'] . $i;
                $index_s  = "num_" . $item['id_produit'] . $i;
                $index_ic  = "iccid_" . $item['id_produit'] . $i;
                $index_srl = "serial_" . $item['id_produit'] . $i;
                //$imeis = $imeis.",".$_POST[$index_i];
                $index_evc = "evc_".$item['id_product'].$i;

                $saleimeis->setMsisdn(issetValue($index_s));
                $saleimeis->setIccid(issetValue($index_ic));
                $saleimeis->setSerial(issetValue($index_srl));
                $saleimeis->setIdTranfer($idTrans);
                $saleimeis->setIdProduct($item['id_produit']);
                $saleimeis->setImei(issetValue($index_i));
                $saleimeis->setEvcnumber(issetValue($index_evc));
                $response->addTransferExtra($saleimeis);
                if($item['category'] == 4){
                    break;
                }
            }
        }
    }

}

function issetValue($index){
    if(isset($_POST[$index])){
        return $_POST[$index];
    }else{
        return "";
    }
}


function addTransExtra($idTrans,$id_product,$qte,$category){
    $saleimeis = new TransferExtra();
    $response = new Dao_Carte();
 
        $total_quantity = 0;
        $imeis = "";

   
            for($i=0; $i < $qte; $i++) {

                $index_i = "imei_" . $id_product . $i;
                $index_s  = "num_" . $id_product . $i;
                $index_ic  = "iccid_" . $id_product . $i;
                $index_srl = "serial_" . $id_product . $i;
                //$imeis = $imeis.",".$_POST[$index_i];
                $index_evc = "evc_".$id_product.$i;
                $saleimeis->setMsisdn(issetValue($index_s));
                $saleimeis->setIccid(issetValue($index_ic));
                $saleimeis->setSerial(issetValue($index_srl));
                $saleimeis->setIdTranfer($idTrans);
                $saleimeis->setIdProduct($id_product);
                $saleimeis->setImei(issetValue($index_i));
                $saleimeis->setEvcnumber(issetValue($index_evc));
                $response->addTransferExtra($saleimeis);
                if($category == 4){
                    break;
                }
            }
}

function validerTransfer($id_produit,$qt,$price,$total_price,$imeis,$id_trans_ref,$category){
   //die($id_produit);
    $stockTransfer = new StockTransfer();
    $response = new Dao_Carte();
    $stockTransfer->setIdProduct($id_produit);
    $stockTransfer->setIdTrensReference($id_trans_ref);
    $stockTransfer->setQuantity($qt);
    /*$commande->setIdProduct($id_produit);
    $commande->setQuantity($qt);
    $commande->setUnitPrice($price);
    $commande->setTotalPrice($total_price);
    $commande->setImeis($imeis);
    $commande->setIdRef($order_id);
    $commande->setAddedBy($_SESSION['user']['username']);*/
    $id = $response->addStockTransfer($stockTransfer);

    addTransExtra($id,$id_produit,$qt,$category);
    
    
    //$response->updateSaleImeiIdSale($id,$id_produit);
    //$response->updateProduitQuantity($qt,$id_produit,$_SESSION['pos']);


}

function getStockAvailableQt($id_product){
    $dao = new Dao_Carte();
    $id_pos = $dao->getOnePOSByUser($_SESSION['user']['username']);
    $_SESSION['pos'] = $id_pos;
    $product_stock = $dao->getStockByIdProductAndIdPOS($id_product,$id_pos);

    $qt = $product_stock['quantity'];
    return $qt;
}

function addTransferReference(){
    $ref = new StockTransferReference();
    $ref->setIdPosFrom($_SESSION['pos']);
    $ref->setIdPosTo($_SESSION['id_pos_to']);
    $ref->setStatus("PENDING");
    $ref->setAddedBy($_SESSION['user']['username']);
    $dao = new Dao_Carte();
    $ref_id = $dao->transferReference($ref);
    return $ref_id;  
}

