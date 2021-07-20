<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 29/06/2020
 * Time: 15:24
 */
session_start();
 ob_start();
include_once '../models/Dao_Carte.php';
require_once("../models/Plainte.php");
require_once("../models/PlainteExtra.php");
require_once('../TCPDF-master/tcpdf.php');
require_once('../helper/Format.php');
$response =new Dao_Carte();
$fm = new Format();



if(isset($_POST['send'])){
    //die("sent");
    $client = $fm->validation($_POST['client']);
    $desc = $fm->validation($_POST['description']);
    $consern = $fm->validation($_POST['plainte_type']);
    $addedby = $_SESSION['user']['username'];
    $pl_subtype = $fm->validation($_POST['plainte_subtype']);
    $pl_status = $fm->validation($_POST['status']);

    $pl_num = issetValue('pl_numero');
    if($pl_num == "")
    $pl_num = issetValue('pl_numero1');

    $pl_facture = issetValue('pl_facture');
    $pl_serial = issetValue('plainte_type');
    $pl_imei = issetValue('pl_imei');
    $pl_solution = issetValue('solution');
    $pl_evc = issetValue('pl_evc');
    $plainte = new Plainte();
    $plainte->setIdClient($client);
    $plainte->setIdSubtype($pl_subtype);
    $plainte->setIdType($consern);
    $plainte->setDescription($desc);
    $plainte->setAddedBy($addedby);
    $plainte->setSolution($pl_solution);
    $plainte->setStatus($pl_status);

    $plExtra = new PlainteExtra();
    $plExtra->setImei($pl_imei);
    $plExtra->setSerial($pl_serial);
    $plExtra->setMsisdn($pl_num);
    $plExtra->setFacture($pl_facture);
    $plExtra->setEvc($pl_evc);

    $res = $response->addPlainte($plainte);
    $idPl = $res;
    $plainte->setIdPlainte($res);
    $plExtra->setIdPlainte($res);
    $res = $response->addPlainteExtra($plExtra);
    if($res === "success"){
		//downloadForm($plainte);
        $json = ['num'=>$idPl,"msg"=>"success"];
        $json = json_encode($json);
		echo $json;
        //$_SESSION['info_success'] = "<p>Plainte à été envoyée avec succès<p>";
       // echo "<script>window.location.href='index.php?page=plainte';</script>";
    }
    else
    {
        //$_SESSION['info'] = "<p>Erreur de l'envoie, réessayez plus tard...<p>";
        //echo "<script>window.location.href='index.php?page=plainte';</script>";
    }
}

function issetValue($index){
    
    if(isset($_POST[$index])){
        return $_POST[$index];
    }else{
        return "";
    }
}

if(isset($_POST['id_cat'])){
    $pl_type = $_POST['id_cat'];
   $row = $response->getPlainteSubTypeByType($pl_type);
    if($row){
        $row = json_encode($row);
        echo $row;

    }else
        echo "no value ".$pl_type;
}

function mysendmail($msg_to,$sbj,$msg){
    $to = $msg_to;
    $subject = $sbj;
    $txt = $msg;
    $headers = "From: benjaminNseye@outlook.com" . "\r\n" .
        "CC: nseyeb@protec-tic.com". "\r\n" .
        "MIME-Version: 1.0". "\r\n" .
        "Content-Type: text/html; charset=UTF-8". "\r\n" ;

    if(mail($to,$subject,$txt,$headers))
        return true;
    else
        return false;

}

function downloadForm(Plainte $plainte){

    //Include the main TCPDF library (search for installation path).

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Benjamin Nseye Mara');
$pdf->SetTitle('Formulaire Plainte');
$pdf->SetSubject('Plainte detail');
$pdf->SetKeywords('plainte, mara, BN-Mara');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', "by addedBy", array(0,64,255), array(0,64,128));
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
    $result = $dao->getOneClientById($plainte->getIdClient());
    $plainte_type = $dao->getOnePlainteTypeById($plainte->getIdType());
        $html = '<h1 align="center">FORMULAIRE PLAINTE No '.$plainte->getIdPlainte().'</h1>';
        $html .= "Nom: <b>".$result['lastname']."</b><br>";
        $html .="Post-nom: <b>".$result['midlename']."</b><br>";
        $html .="Prenom: <b>".$result['firstname']."</b><br>";
        $html .="Telephone: <b>".$result['phone']."</b><br>";
        $html .="Type:<b>".$plainte_type['designation']."</b><br>";
        $html .="<br><br>".$plainte->getDescription()."<br>"."<br>";
    $html .="<br><br>";
    $html .='<table><tr><td>Signature du client</td><td><span style="text-align: right">'.date("d/m/yy")."</span></td></tr>"."</table>";
    //$html .='<br><br><span>'.'Signature du client'."</span><br>"."<br>";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$file_name="Plainte".$result['lastname'].$plainte->getIdType();
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($file_name, 'I');
    //$pdf->Output();

//============================================================+
// END OF FILE
//============================================================+

}
?>