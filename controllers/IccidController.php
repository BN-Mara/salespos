<?php
require_once("FileError.php");
/*session_start();
include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});
?>
<?php
*/
//echo $_POST['catId'];

/*if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{
    $userC= new IccidController();
    if(isset($_POST['uploadcsv'])){
        $userC->uploadFromCSV();

    }
    else
    $userC->makeIccid();

}*/
class IccidController
{
    private $dao;
    public function __construct()
    {
        $this->dao  = new Dao_Carte();
    }

    public function checkIccids(){
        if ($_FILES["iccid_csv"]["error"] > 0) {
            $fileError = new FileError($_FILES["iccid_csv"]["error"] );
            $info = "Iccid file Return Code: " . $_FILES["iccid_csv"]["error"] . " ".$fileError->getMessage();
            $_SESSION['infoerror'] = $info;
            return -3;
            exit;

        }else{
            $tmpName = $_FILES['iccid_csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));
            //die(var_dump($csvAsArray));
           
            //$hd = explode(";", $csvAsArray[0][0]);
            if(isset($csvAsArray[0][0]) && isset($csvAsArray[0][1]) && isset($csvAsArray[0][2])
            && isset($csvAsArray[0][3]) && isset($csvAsArray[0][4]) && isset($csvAsArray[0][5])){
                $hd[0] = trim($csvAsArray[0][0]);
                $hd[1]  = trim($csvAsArray[0][1]);
                $hd[2] = trim($csvAsArray[0][2]);
                $hd[3] = trim($csvAsArray[0][3]);
                $hd[4] = trim($csvAsArray[0][4]);
                $hd[5] = trim($csvAsArray[0][5]);
            }else{
                return -2; // bad format
                exit;
            }

            $idP = $this->dao->getProductByCode($csvAsArray[1][0]);
            $chkPos = $this->dao->getOnePOSById($csvAsArray[1][5]);
            if(!$idP || !$chkPos){
                return 0;
                exit;
            }
            //die("this");
            $iccidsArray = [];
            $mCount = 0;
            $msisdnArray = [];
            $prodArray = [];
            $posArray = []; 
            if($hd[0] == "product_code" && $hd[1] == "iccid" && $hd[2] == "msisdn"
             && $hd[3] == "type" && $hd[4] == "profile" && $hd[5] == "pos" ){
                 $ctHead =  0;
            foreach($csvAsArray as  $csv){
               if($ctHead > 0){
             
                    $iccidsArray[$mCount] = "'".$csv[1]."'";
                    $msisdnArray[$mCount] = $csv[2] ;
                    //$prodArray[$mCount] =  $csv[0];
                    //$posArray[$mCount] = $csv[5] ;
                    $mCount += 1;
                }
                $ctHead += 1;
                    
                }

            }else{
                return -2; //bad format
                exit;
            }
            $condition = implode(', ', $iccidsArray);
            //$condition2 = implode(', ', $msisdnArray);
            //$condition3  = implode(', ', $prodArray);
            //$condition4 = implode(', ', $posArray);
            //die($condition);
            $test = $this->dao->checkExistingIccids($condition);
            //$test2 = $dao->checkExistingMsisdns($condition2);
            //die($condition);
            if($test > 0){
                return -1;
                exit;
            }else{
                return 1;
                exit;
            }
        }
       
}



    public function uploadFromCSV(){
        $ct = 0;
        $ct_inserted = 0;
        if ($_FILES["iccid_csv"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }else{
            $tmpName = $_FILES['iccid_csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));
            //die(var_dump($csvAsArray));
           
            //$hd = explode(";", $csvAsArray[0][0]);
            $hd[0] = trim($csvAsArray[0][0]);
            $hd[1]  = trim($csvAsArray[0][1]);
            $hd[2] = trim($csvAsArray[0][2]);
            $hd[3] = trim($csvAsArray[0][3]);
            $hd[4] = trim($csvAsArray[0][4]);
            $hd[5] = trim($csvAsArray[0][5]);
            //die("this");
            $iccidsArray = [];
            $mCount = 0;
            $msisdnArray = [];
            //$prodArray = [];
            //$posArray = []; 
            /*if($hd[0] == "product_code" && $hd[1] == "iccid" && $hd[2] == "msisdn"
             && $hd[3] == "type" && $hd[4] == "profile" && $hd[5] == "pos" ){
            /*foreach($csvAsArray as  $csv){
               
                    $iccidsArray[$mCount] = $csv[1];
                    $msisdnArray[$mCount] = $csv[2] ;
                    //$prodArray[$mCount] =  $csv[0];
                    //$posArray[$mCount] = $csv[5] ;
                    $mCount += 1;
                }*/

            /*}else{
                return -2; //bad format
                exit;
            }
            $condition = implode(', ', $iccidsArray);
            //$condition2 = implode(', ', $msisdnArray);
            //$condition3  = implode(', ', $prodArray);
            //$condition4 = implode(', ', $posArray);
            $dao = new Dao_Carte();
            $test = $dao->checkExistingIccids($condition);
            //$test2 = $dao->checkExistingMsisdns($condition2);
            die($condition);
            if($test > 0){
                return -1;
                exit;
            }*/





            foreach($csvAsArray as  $csv){
            
                $newcsv = $csv;//explode(",", $csv[0]);
                //die(var_dump($newcsv));

               // if($hd[0] == "product_code" && $hd[1] == "iccid" && $hd[2] == "msisdn" && $hd[3] == "type" && $hd[4] == "profile" && $hd[5] == "pos" ){
                    
                    if($ct > 0){
                        //$dao = new Dao_Carte();
                        $p = new Iccid();
                        $idP = $this->dao->getProductByCode($newcsv[0]);
                        //$chkPos = $dao->getOnePOSById($newcsv[5]);
                        //$chkExistIccid = $dao->checkExistingIccid($newcsv[1]);
                        //$chkExist = $dao->checkProductIccidPOS($idP,$newcsv[5],$newcsv[1]);
                        //$chkExistMsisdn = $dao->checkProductMsisdnPOS($idP,$newcsv[5],$newcsv[2]);
                        //($chkExistIccid == 0){
                            //if($idP && $chkPos){
                                                       
                                    $p->setIdProduct($idP);
                                    $p->setIccid($newcsv[1]);
                                    $p->setMsisdn($newcsv[2]);
                                    $p->setType($newcsv[3]);
                                    $p->setProfile($newcsv[4]);
                                    $p->setIdPos($newcsv[5]);
                                    $p->setAddedBy($_SESSION['current_user']);
                                    $this->createImei($p);
                                    $ct_inserted += 1;
            
                                  
    
                            //}

                       // }
                        
                                              
                    }
                    $ct +=1;
               // }
               // else{
                    //header("location:../admin/layout.php?page=iccids");
                    //break;
                    //return 0;
                    //exit;
                //}
            }
            //header("location:../admin/layout.php?page=iccids");
            //return false;


        }
        return $ct_inserted;

    }
    public function createImei(Iccid $iccid){
        //die(var_dump($imei));
        //$dao = new Dao_Carte();
        $response = $this->dao->addIccid($iccid);
    }
    public function makeIccid()
    {
        $iccidEnt = new Iccid();
        ///
       // $dao = new Dao_Carte();
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
                $response = $this->dao->editIccid($iccidEnt);
                //$dao->addStockTransaction($stock, $addedBy);
                $info = "La Modification a été effectuée avec succès";

                if ($response == "success") {
                    //die($action);
                    $_SESSION['info'] = $info;

                    header("location:../admin/layout.php?page=addIccid");
                }


            }
            if($action == "ajouter"){


                $response = $this->dao->addIccid($iccidEnt);
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
