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
    $userC= new IccidController();
    if(isset($_POST['uploadcsv'])){
        $userC->uploadFromCSV();

    }
    else
    $userC->makeIccid();

}
class IccidController
{
    public function __construct()
    {
    }
    public function uploadFromCSV(){
        if ($_FILES["csv"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }else{
            $tmpName = $_FILES['csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));
            //die(var_dump($csvAsArray));
            $ct = 0;
            //$hd = explode(";", $csvAsArray[0][0]);
            $hd[0] = trim($csvAsArray[0][0]);
            $hd[1]  = trim($csvAsArray[0][1]);
            $hd[2] = trim($csvAsArray[0][2]);
            $hd[3] = trim($csvAsArray[0][3]);
            $hd[4] = trim($csvAsArray[0][4]);
            $hd[5] = trim($csvAsArray[0][5]);
            //die("this");
            foreach($csvAsArray as  $csv){
            
                $newcsv = $csv;//explode(",", $csv[0]);
                //die(var_dump($newcsv));

                if($hd[0] == "product_code" && $hd[1] == "iccid" && $hd[2] == "msisdn" && $hd[3] == "type" && $hd[4] == "profile" && $hd[5] == "pos" ){
                    
                    if($ct > 0){
                        $dao = new Dao_Carte();
                        $p = new Iccid();
                        $idP = $dao->getProductByCode($newcsv[0]);
                        $chkPos = $dao->getOnePOSById($newcsv[5]);
                        $chkExist = $dao->checkProductIccidPOS($idP,$newcsv[5],$newcsv[1]);
                        $chkExistMsisdn = $dao->checkProductMsisdnPOS($idP,$newcsv[5],$newcsv[2]);
                        if($idP && $chkPos){
                            if($chkExist < 1 && $chkExistMsisdn  < 1){                            
                                $p->setIdProduct($idP);
                                $p->setIccid($newcsv[1]);
                                $p->setMsisdn($newcsv[2]);
                                $p->setType($newcsv[3]);
                                $p->setProfile($newcsv[4]);
                                $p->setIdPos($newcsv[5]);
                                $p->setAddedBy($_SESSION['current_user']);
                                $this->createImei($p);
        
                                }

                        }
                                              
                    }
                    $ct +=1;
                }
                else{
                    header("location:../admin/layout.php?page=iccids");
                    return false;
                    exit;
                }
            }
            header("location:../admin/layout.php?page=iccids");


        }

    }
    public function createImei(Iccid $iccid){
        //die(var_dump($imei));
        $dao = new Dao_Carte();
        $response = $dao->addIccid($iccid);
    }
    public function makeIccid()
    {
        $iccidEnt = new Iccid();
        ///
        $dao = new Dao_Carte();
        //
        $fm = new Format();


//end bn-mara
        $id_product = $fm->validation($_POST['id_product']);
        $iccid = $fm->validation($_POST['iccid']);
        $id_pos = $fm->validation($_POST['id_pos']);
        $action = $fm->validation($_POST['action']);

        $addedBy = $_SESSION['current_user'];
        $msisdn = $fm->validation($_POST['msisdn']);
        $type = $fm->validation($_POST['type']);
        $profile = $fm->validation($_POST['profile']);


        //*****************************************

       // $iemi->setIdProduct($id_product);
        //$iemi->setImei($imei);
        //$iemi->setIdPos($id_pos);
        // $myuser->setMatricule($matricule);
        // $myuser->setFonction($fonction);
        // $myuser->setDirection($direction);
        $iccidEnt->setIdProduct($id_product);
        $iccidEnt->setIdPos($id_pos);
        $iccidEnt->setIccid($iccid);
        $iccidEnt->setMsisdn($msisdn);
        $iccidEnt->setType($type);
        $iccidEnt->setProfile($profile);
        $iccidEnt->setAddedBy($addedBy);


        //if($action == "ajouter"){

           // $row = $dao->getIccidByIdProductAndIdPOS($iemi->getIdProduct(),$iemi->getIdPos());
            if ($action == "modifier") {

                //$id = $fm->validation($_POST['bnid']);
                $response = $dao->editIccid($iccidEnt);
                //$dao->addStockTransaction($stock, $addedBy);
                $info = "La Modification a été effectuée avec succès";

                if ($response == "success") {
                    //die($action);
                    $_SESSION['info'] = $info;

                    header("location:../admin/layout.php?page=addIccid");
                }


            }
            if($action == "ajouter"){


                $response = $dao->addIccid($iccidEnt);
                //$dao->addStockTransaction($stock, $addedBy);
                $info = "Les Information ont été ajoutées avec succès";
                $_SESSION['info'] = $info;

                if ($response == "success") {
                    //die($action);

                    header("location:../admin/layout.php?page=addIccid");
                }


           }
       // }






    }

}
