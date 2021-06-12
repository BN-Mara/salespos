<?php

include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});
?>
<?php

//echo $_POST['catId'];

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{

    $migrant=new Migrant();
    ///
    $dao=new Dao_Carte();
    //
    $fm=new Format();

    //echo $_POST['catId'].''.$_POST['catName'];
// echo $_FILES['image']['name'];
//     var_dump($_POST);
    
    //$numero = $fm->validation($_POST['numero']);
//modify by bn-mara
	//generate and check for numero_serie
	//$find = true;
	
	/*while($find){
    $numero =  mt_rand(100000000,999999999);		
	$check=$dao->findNumero($numero);
	if($check == 0){
		$find = false;
	}
	}*/
//end bn-mara	
$nom = $fm->validation($_POST['nom']);
$postnom = $fm->validation($_POST['postnom']);
$prenom = $fm->validation($_POST['prenom']);
$sexe = $fm->validation($_POST['sexe']);
$naissance= $_POST['naissance'];
$phone = $fm->validation($_POST['phone']);
$email = $fm->validation($_POST['email']);
$document = $fm->validation($_POST['document']);
$numdoc = $fm->validation($_POST['numdoc']);
$docissue = $_POST['docissue'];
$docexp = $_POST['docexp'];
$numvisa = $fm->validation($_POST['numvisa']);
$visaissue = $_POST['visaissue'];
$visaexp= $_POST['visaexp'];
$date_entree = $_POST['date_entree'];
$sejour_jour = $fm->validation($_POST['sejour_jour']);
$sejour_mois = $fm->validation($_POST['sejour_mois']);
$province = $fm->validation($_POST['province']);
$motif = $fm->validation($_POST['motif']);
$port = $fm->validation($_POST['port']);
$nation = $fm->validation($_POST['nation']);
$adresse = $fm->validation($_POST['adresse']);

$imagebytestring = $_POST['imagebytestring'];
$codebarre= $fm->validation($_POST['codebarre']);
$codeformat = $fm->validation($_POST['codeformat']);
$imagebyte = base64_decode($imagebytestring);
$data = explode( ',', $imagebytestring );
$image_path = '../public/images/'.$nom.$numdoc.'.bmp';
file_put_contents($image_path, base64_decode($imagebytestring));
    //*********************************************

$naissance = date("y/m/d",strtotime($naissance));
$docexp = date("y/m/d",strtotime($docexp));
$docissue = date("y/m/d",strtotime($docissue));
$visaissue = date("y/m/d",strtotime($visaissue));
$visaexp = date("y/m/d",strtotime($visaexp));
$date_entree = date("y/m/d",strtotime($date_entree));


	
	//**********************************
	
    //$migrant->setNumeroserie($numero);
    $migrant->setNom($nom);
    $migrant->setPostnom($postnom);
    $migrant->setPrenom($prenom);
    $migrant->setSexe($sexe);
    $migrant->setDateNaissance($naissance);
    $migrant->setAdresse($adresse);
    $migrant->setPhone($phone);
	$migrant->setImageDoc($image_path);
	$migrant->setEmail($email);
	$migrant->setDocument($document);
	$migrant->setNumDocument($numdoc);
	//$migrant->setDocFromdate($docissue);
	$migrant->setDocFrom($docissue);
	$migrant->setDocEnd($docexp);
	$migrant->setNumVisa($numvisa);
	$migrant->setVisaFrom($visaissue);
	$migrant->setVisaEnd($visaexp);
	//$migrant->setVisaType($motif);
	$migrant->setDateEntree($date_entree);
	$migrant->setSejourJour($sejour_jour);
	$migrant->setSejourMois($sejour_mois);
	$migrant->setFrontiere( $port);
	$migrant->setCodebarre($codebarre);
	$migrant->setCodeformat($codeformat);
	$migrant->setMotif($motif);
    //************************************
	
		$response=$dao->addMigrant($migrant);

		echo $response;

    //if($response=="success")
   // {
          
		  //die($action);
        //echo "Data inserted";
		//send confirmation mail
			//$to = " maranseye@yahoo.fr";
         /* $subject = "DGMControl";
         $txt = "Bien venu au service MigrationCtrl. vous souhaite bon sejour en RDC";
         $headers = "From: benjaminNseye@outlook.com" . "\r\n" .
         "CC: nseyeb@protec-tic.com"; */
         //mail($email,$subject,$txt,$headers);
    //}



}