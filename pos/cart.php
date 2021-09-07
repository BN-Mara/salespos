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
        header("location: index.php?page=sales");
    }

}

if(isset($_POST['check_extra_imei'])){
    $pdt_id =  $_POST['id_product'];
    $imei_c = $_POST['imei'] ;
    $pos_c = $response->getPOSByUsername($_SESSION['user']['username']);
    //die($pdt_id.$pos_c.$imei_c);
    $imei =  $response->checkProductImeiPOS($pdt_id,$pos_c,$imei_c);
    
        $dataR = ['imei'=>$imei];
        echo json_encode($dataR);
    
   
}
if(isset($_POST['check_extra_iccid'])){
    $pdt_id =  $_POST['id_product'];
    $iccid_c = $_POST['iccid'];
    //die($pdt_id.$pos_c.$iccid_c);
    $pos_c = $response->getPOSByUsername($_SESSION['user']['username']);
    $iccid = $response->checkProductIccidPOS($pdt_id,$pos_c,$iccid_c);
    $dataR = ['iccid'=>$iccid];
    echo json_encode($dataR);
}
if(isset($_POST['check_extra_msisdn'])){
    $pdt_id =  $_POST['id_product'];
    $msisdn_c = $_POST['msisdn'];
    $pos_c = $response->getPOSByUsername($_SESSION['user']['username']);
    $msisdn = $response->checkProductMsisdnPOS($pdt_id,$pos_c,$msisdn_c);
    $dataR = ['msisdn'=>$msisdn];
    echo json_encode($dataR);
    
}

if(isset($_POST['check_extra_serial'])){

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
    header("location: index.php?page=sales");

}
if(isset($_POST['setclient'])){
    $_SESSION['id_client'] = $_POST['setclient'];

    $client_name = $response->getOneClientById($_POST['setclient']);
    //var_dump($client_name);
    $_SESSION['client_name'] = $client_name['lastname']." ".$client_name['firstname'];
    $_SESSION['client_phone'] = $client_name['phone'];
    unset($_SESSION['newclient_name']);
    unset($_SESSION['newclient_phone']);
    echo json_encode($client_name);
    //header("location: index.php?page=sales");

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
            if(!empty($_SESSION["cart_item"])) {
                if(in_array($productByCode["code"],array_keys($_SESSION["cart_item"]))) {
                    foreach($_SESSION["cart_item"] as $k => $v) {
                        if($productByCode["code"] == $k) {
                            if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                $_SESSION["cart_item"][$k]["quantity"] = 0;
                            }
                            $_SESSION["cart_item"][$k]["quantity"] = $_POST["qt"];
                        }
                    }
                } else {
                    $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                }
                header("location: index.php?page=sales");
            } else {
                $_SESSION["cart_item"] = $itemArray;
                header("location: index.php?page=sales");
            }
        }else{
            $_SESSION['info'] = '<h3>Attention!</h3>Le Stock du produit choisi est insuffisant..<br><br>';
            header("location: index.php?page=sales");
        }

    }

}

if(isset($_GET['action'])){
    if($_GET['action'] == 'remove'){
        if(!empty($_SESSION["cart_item"])) {
            foreach($_SESSION["cart_item"] as $k => $v) {
                if($_GET["code"] == $k)
                    unset($_SESSION["cart_item"][$k]);
                if(empty($_SESSION["cart_item"]))
                    unset($_SESSION["cart_item"]);
            }
            header("location: index.php?page=sales");
        }
    }
}
if(isset($_POST['valider']) ){
    if(isset($_SESSION['newclient_name']) && isset($_SESSION['newclient_phone'])){
        $name = explode(" ",$_SESSION['newclient_name']);
        $client = new Client();
        if(count($name) > 2){
            $client->setNom($name[0]);
        $client->setPostom($name[1]);
        $client->setPrenom($name[2]);

        }
        else if(count($name) == 2){
            $client->setNom($name[0]);
            $client->setPrenom($name[1]);

        }else{
            $client->setNom($name[0]);
            $client->setPrenom($name[0]);

        }
        
        $client->setTel($_SESSION['newclient_phone']);
        $client->setAddedBy($_SESSION['user']['username']);
        $res = $response->addClient($client);
        //die($res);
        $_SESSION['id_client'] = $res;

    }
    if(!isset($_SESSION['id_client'])){
        $_SESSION['info'] = '<h3>ERREUR!</h3>Choisissez un client<br><br>';
        //echo "test client";
        echo "<script>window.location.href='index.php?page=sales';</script>";
    }else{
        if(!empty($_SESSION["cart_item"])){
            $order_id = addOrder($_SESSION['id_client']);
            $total_price = 0;
            $total_quantity = 0;
            addImei();
            foreach ($_SESSION["cart_item"] as $item) {
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

                    validerCOmmande($item["id_produit"],$item["quantity"],$item["price"],$item_price, $_SESSION['id_client'], $imeis,$order_id);

                //echo "$ " . number_format($item_price, 2);
                $total_quantity += $item["quantity"];
                $total_price += ($item["price"] * $item["quantity"]);
            }
            $user = $_SESSION['user'];
            $cart = $_SESSION['cart_item'];
            $clienid = $_SESSION['id_client'];
            session_unset();
            $_SESSION['user'] = $user;

            $download = downloadForm($cart,$clienid,$order_id);

            $_SESSION['info_success']='<h3>Success!</h3>Commande effectuée avec succès<br><br>';

        }else{
            $_SESSION['info'] = "<h3>ERREUR!</h3> votre commade est vide, ajouter au moins un produit<br><br>";
        }


        echo "<script>window.location.href='index.php?page=sales';</script>";


    }

}
if(isset($_POST['recharge'])){
    $saleCrt = new SalesCredit();
    $cmd = new Commande();
    $dao = new Dao_Carte();
    $orderRef = new SaleReference();
    if( $_POST['typecredit'] == "voucher"){
        $unite = $_POST['credit'];
        $nbre = $_POST['qte'];

        $stock_qt = getStockAvailableQt($unite);

        if($nbre > $stock_qt ){

            $_SESSION['info']='<h3>Erreur!</h3>Le Stock du produit choisi est insuffisant..<br><br>';

            echo "<script>window.location.href='index.php?page=balance';</script>";

        }else{

            $price = $dao->getProductPriceById($unite);

            $total = $nbre * $price;

            $orderRef->setIdClient(1002);
            $orderRef->setNbreArticle($nbre);
            $orderRef->setAddedBy($_SESSION['user']['username']);
            $orderRef->setTotal($total);
            $id_ref = $dao->addOrderReference($orderRef);


            $cmd->setIdProduct($unite);
            $cmd->setIdRef($id_ref);

            //$saleCrt->setIdProduct($unite);
            $cmd->setAddedBy($_SESSION['user']['username']);
            $cmd->setQuantity($nbre);
            $cmd->setUnitPrice($price);
            $cmd->setTotalPrice($total);
            $cmd->setIdClient(1002);
            $cmd->setImeis("");


        }



        //$saleCrt->setAmount(0);
        //$saleCrt->setQuantity($nbre);
        //$saleCrt->setPhone("");
        //$saleCrt->setTotal($total);

    }else{
        $tel = $_POST['mytel'];
        $amt = $_POST['amount'];
        $product_info = $dao->getEVoucherProduct();
        $price = $product_info[0]['price'];
        $id = $product_info[0]['id_product'];

        $stock_qt = getStockAvailableQt($id);

        if($amt > $stock_qt ){

            $_SESSION['info']='<h3>Attention!</h3>Le Stock du produit choisi est insuffisant..<br><br>';

            echo "<script>window.location.href='index.php?page=balance';</script>";

        }else{
            $total = $amt * $price/100;

            $orderRef->setIdClient(1002);
            $orderRef->setNbreArticle(1);
            $orderRef->setAddedBy($_SESSION['user']['username']);
            $orderRef->setTotal($total);
            $id_ref = $dao->addOrderReference($orderRef);

            $cmd->setIdProduct($id);
            $cmd->setIdRef($id_ref);
            $cmd->setQuantity($amt);
            $cmd->setUnitPrice($price);
            $cmd->setTotalPrice($total);
            $cmd->setIdClient(1002);
            $cmd->setImeis("");
            //$saleCrt->setIdProduct($id);
            $cmd->setAddedBy($_SESSION['user']['username']);

        }



        //$saleCrt->setAmount($amt);
        //$saleCrt->setQuantity(0);
        //$saleCrt->setPhone($tel);
        //$saleCrt->setTotal($total);


    }
    $dao->addOrder($cmd);
    $dao->updateProduitQuantity($cmd->getQuantity(),$cmd->getIdProduct(),$_SESSION['pos']);


    $_SESSION['info_success']='<h3>Success!</h3>Commande effectuée avec succès<br><br>';

    echo "<script>window.location.href='index.php?page=balance';</script>";


}

if(isset($_POST["exchange"]))
{
    if(isset($_POST["plainte"]) && isset($_POST["facture"]) && isset($_POST["product"]) && isset($_POST["newproduct"])
    && isset($_POST["oldimei"]) && isset($_POST["newimei"])){
    $id_plainte = $_POST['plainte'];
    $id_ref = $_POST['facture'];
    $id_product = $_POST['product'];
    $id_newproduct = $_POST['newproduct'];
    $oldimei = $_POST['oldimei'];
    $newimei = $_POST['newimei'];

    if($id_newproduct != $id_product){
        //update stock
    }

    $pexchange = new ProductExchange();
    $pexchange->setIdPlainte($id_plainte);
    $pexchange->setAddedBy($_SESSION['user']['username']);
    $pexchange->setIdProduct($id_product);
    $pexchange->setNewproduct($id_newproduct);
    $pexchange->setIdReference($id_ref);
    $pexchange->setOldimei($oldimei);
    $pexchange->setNewimei($newimei);
    $dao = new Dao_Carte();
    $dao->addExchange($pexchange);
    $_SESSION['info_success']='<h3>Success!</h3>Echange effectué avec succès<br><br>';
}
else{
    $_SESSION['info']='<h3>Saisissez toutes les informations requises svp</h3><br><br>';
}

    echo "<script>window.location.href='index.php?page=exchange';</script>";

}
function addImei(){
    $saleimeis = new SaleImei();
    $response = new Dao_Carte();
    if(isset($_SESSION["cart_item"])){
        $total_quantity = 0;
        $imeis = "";

        foreach ($_SESSION["cart_item"] as $item){
        //$item_price = $item["quantity"]*$item["price"];
            $item["quantity"];
            for($i=0; $i < $item["quantity"]; $i++) {

                $index_i = "imei_" . $item['id_produit'] . $i;
                $index_s  = "num_" . $item['id_produit'] . $i;
                $index_ic  = "iccid_" . $item['id_produit'] . $i;
                $index_srl = "serial_" . $item['id_produit'] . $i;
                $index_evc = "evc_".$item['id_produit'].$i;
                //$imeis = $imeis.",".$_POST[$index_i];

                $saleimeis->setMsisdn(issetValue($index_s));
                $saleimeis->setIccid(issetValue($index_ic));
                $saleimeis->setSerial(issetValue($index_srl));
                $saleimeis->setIdSale(0);
                $saleimeis->setIdProduct($item['id_produit']);
                $saleimeis->setImei(issetValue($index_i));
                $saleimeis->setEvcnumber(issetValue($index_evc));
                $response->addSaleImei($saleimeis);
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

function validerCommande($id_produit,$qt,$price,$total_price,$id_client,$imeis,$order_id){
   //die($id_produit);
   $commande = new Commande();
    $response = new Dao_Carte();


    $commande->setIdClient($id_client);
    $commande->setIdProduct($id_produit);
    $commande->setQuantity($qt);
    $commande->setUnitPrice($price);
    $commande->setTotalPrice($total_price);
    $commande->setImeis($imeis);
    $commande->setIdRef($order_id);
    $commande->setAddedBy($_SESSION['user']['username']);
    $id = $response->addOrder($commande);
    $response->updateSaleImeiIdSale($id,$id_produit);
    $response->updateProduitQuantity($qt,$id_produit,$_SESSION['pos']);




}

function getStockAvailableQt($id_product){
    $dao = new Dao_Carte();
    $id_pos = $dao->getOnePOSByUser($_SESSION['user']['username']);
    $_SESSION['pos'] = $id_pos;
    $product_stock = $dao->getStockByIdProductAndIdPOS($id_product,$id_pos);

    $qt = $product_stock['quantity'];
    return $qt;


}

function addOrder($id_client){
    //die($id_produit);
    $total_price = 0;
    $total_quantity =0;
    foreach ($_SESSION["cart_item"] as $item){
        //$item_price = $item["quantity"]*$item["price"];

        $total_quantity += $item["quantity"];
        $total_price += ($item["price"]*$item["quantity"]);
    }

    $order = new SaleReference();
    $response = new Dao_Carte();

    $order->setIdClient($id_client);
    $order->setNbreArticle($total_quantity);
    $order->setTotal($total_price);
    $order->setAddedBy($_SESSION['user']['username']);
    $res = $response->addOrderReference($order);

    return $res;
    //$response->updateProduitQuantity($qt,$id_produit,$_SESSION['pos']);


}

function downloadForm($cart,$client,$order){
    error_reporting(0);
    //Include the main TCPDF library (search for installation path).

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Benjamin Nseye Mara');
    $pdf->SetTitle('Formulaire Plainte');
    $pdf->SetSubject('Plainte detail');
    $pdf->SetKeywords('sale, mara, BN-Mara');

// set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Facture", 'by '.$_SESSION['user']['names'], array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------

// set default font subsetting mode
    $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

// set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
    $dao = new Dao_Carte();
    $result = $dao->getOneClientById($client);
    $order_ref = $dao->getSaleReferenceById($order);
    


    //$plainte_type = $dao->getOnePlainteTypeById($plainte->getIdType());
    $html = '<h1 align="center">FACTURE N<sup>o</sup> '.$order_ref['reference'].' </h1>';
    $html .= '<table border="0">';
    $html .= "<tr><td>Nom: </td><td>".$result['lastname']."</td></tr>";
    $html .="<tr><td>Post-nom: </td><td>".$result['middlename']."</td></tr>";
    $html .="<tr><td>Prenom: </td><td>".$result['firstname']."</td></tr>";
    $html .="<tr><td>Telephone: </td><td>".$result['phone']."</td></tr>";
    $html .= "</table>";
    $total_quantity=0;
    $total_price=0;

    $html .= "<br><br>";

    $html .= '<table border="1">';
    $html .= '<tr><th>Produit</th><th>Quantité</th><th>Prix</th><th>Prix total</th></tr>';
    foreach ($cart as $item) {
        $item_price = $item["quantity"] * $item["price"];

        $imeis = "";
        //$item_price = $item["quantity"]*$item["price"];
        //$check_qt = $item["quantity"];
        /*for($i=0; $i < $item["quantity"]; $i++) {

            $index = "imei_" . $item['id_produit'] . $i;
            if(($check_qt - 1) > 0){
                $imeis = $imeis.$_POST[$index].",";
                $check_qt = $check_qt - 1;
            }else{
                $imeis = $imeis.$_POST[$index];
            }

        }*/

        $html .="<tr><td>".$item["name"]."</td>"."<td>".$item["quantity"]."</td> <td>".$item["price"]." CDF</td> <td>".$item_price." CDF</td> </tr>";

        //validerCOmmande($item["id_produit"],$item["quantity"],$item["price"],$item_price, $_SESSION['id_client'], $imeis,$order_id);

        //echo "$ " . number_format($item_price, 2);
        $total_quantity += $item["quantity"];
        $total_price += ($item["price"] * $item["quantity"]);
    }


    $html .='<tr><td colspan="2" style="background-color:#c9c2c1">Total payé</td><td colspan="2" style="background-color:#c9c2c1;text-align:right">'.$total_price." CDF</td></tr>";
    $html .="<br><br>";
    $html .='<table><tr><td>Signature du client</td><td><span style="text-align: right">'.date("d/m/yy")."</span></td></tr>"."</table>";
    //$html .='<br><br><span>'.'Signature du client'."</span><br>"."<br>";
    $html .= "</table>";

// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $file_name="Facture".$order.".pdf";
// ---------------------------------------------------------
ob_end_clean();
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    $pdf->Output($file_name, 'I');
    //$pdf->Output();
    return true;

//============================================================+
// END OF FILE
//============================================================+

}
?>