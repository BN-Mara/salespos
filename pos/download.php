<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 07/07/2020
 * Time: 08:56
 */


// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-master/examples/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Benjamin Nseye Mara');
$pdf->SetTitle('MingrationCtrl');
$pdf->SetSubject('Informations du Migrant');
$pdf->SetKeywords('migrant, MigrationCtrl, mara, BN-Mara');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
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

        $html .= "Nom: <b>".$result['nom']."</b><br>";
        $html .="Post-nom: <b>".$result['postnom']."</b><br>";
        $html .="Prenom: <b>".$result['prenom']."</b><br>";
        $html .="Sexe: <b>".$result['sexe']."</b><br>";
        $html .="Date de naissance: <b>".date("d/m/Y", strtotime($result['date_naissance']))."</b><br>";
        $html .="Nationalite: <b>".$result['nationalite']."</b><br>";
        $html .="Telephone: <b>".$result['phone']."</b><br>";
        $html .="email: <b>".$result['email']."</b><br><br>";
        $html .="<b>".$result['document']."</b>"."<br>";
        $html .="Numero".$result['document'].": <b>".$result['numerodoc']."</b><br>";
        $html .="Date d'emission: <b>".date("d/m/Y", strtotime($result['docemission']))."</b><br>";
        $html .="Date d'expiration: <b>".date("d/m/Y", strtotime($result['docexpiration']))."</b><br><br>";
        $html .="<b>Visa</b>"."<br>";
        $html .="Numero du Visa: <b>".$result['numerovisa']."</b><br>";
        $html .="Date d'emission: <b>".date("d/m/Y", strtotime($result['visaemission']))."</b><br>";
        $html .="Date d'expiration: <b>".date("d/m/Y", strtotime($result['visaexpiration']))."</b><br>";
//nombre des jours restant
        $datetime1 = time();
        $datetime2 = strtotime($result['visaexpiration']);
        $difference = ($datetime2 - $datetime1);
        $difference = floor($difference / 86400);

        $html .="<br><b> Entree</b><br>";
        $html .="Date d'entree: <b>".date("d/m/Y", strtotime($result['date_entree']))."</b><br>";
        $html .="Province: <b>".$result['province']."</b><br>";
        $html .="Frontiere: <b>".$result['port']."</b><br>";
        $html .="Motif: <b>".$result['motif']."</b><br>";
        $html .="<br><b> Sortie</b><br>";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
