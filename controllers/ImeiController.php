<?php
/*session_start();
include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});
?>
<?php
*/
//echo $_POST['catId'];
/*
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{
    
    $userC= new ImeiController();
    if(isset($_POST['uploadcsv'])){
        $userC->uploadFromCSV();

    }else{
        $userC->makeImei();

    }
    

}
*/
class ImeiController
{
    public function __construct()
    {
    }
    public function uploadFromCSV(){
        $ct = 0;
        $ct_inserted  = 0;
        if ($_FILES["imei_csv"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }else{
            $tmpName = $_FILES['imei_csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));
            //die(var_dump($csvAsArray));
            
            //$hd = explode(",", $csvAsArray[0][0]);
            $hd[0] = trim($csvAsArray[0][0]);
            $hd[1]  = trim($csvAsArray[0][1]);
            $hd[2] = trim($csvAsArray[0][2]);

            $imeisArray = [];
            $mCount = 0;
            if($hd[0] == "product_code" && $hd[1] == "imei" && $hd[2] == "pos" ){
            foreach($csvAsArray as  $csv){
                
                    $imeisArray[$mCount] = $csv[1];
                    $mCount += 1;
                }

            }else{
                return -2; //bad format
                exit;
            }
            $condition = implode(', ', $imeisArray);
            $dao = new Dao_Carte();
            $test = $dao->checkExistingImeis($condition);
            if($test > 0){
                return -1;
                exit;
            }
            foreach($csvAsArray as  $csv){
            
                $newcsv = $csv;// explode(",", $csv[0]);
                //die(var_dump($newcsv));

                if($hd[0] == "product_code" && $hd[1] == "imei" && $hd[2] == "pos" ){
                    
                    if($ct > 0){
                        $dao = new Dao_Carte();
                        $p = new Imei();
                        $idP = $dao->getProductByCode($newcsv[0]);
                        $chkPos = $dao->getOnePOSById($newcsv[2]);
                        $checkExistImei = $dao->checkExistingImei($newcsv[1]);
                        //$chkExist = $dao->checkProductImeiPOS($idP,$newcsv[2],$newcsv[1]);
                        if($checkExistImei == 0){
                            if($idP && $chkPos){
                                                      
                                        $p->setIdProduct($idP);
                                        $p->setImei($newcsv[1]);
                                        $p->setIdPos($newcsv[2]);
                                        $p->setAddedBy($_SESSION['current_user']);
                                        $this->createImei($p);
                                        $ct_inserted += 1;
                                    
                                }else{
                                    //die("exist");
                                }
                        }
                        
                        
                        
                    }
                    $ct +=1;
                }
                else{
                    //header("location:../admin/layout.php?page=imeis");
                    //return false;
                    break;
                    //exit;
                }
            }
            //header("location:../admin/layout.php?page=imeis");


        }
        return $ct_inserted;

    }
    public function createImei(Imei $imei){
        //die(var_dump($imei));
        $dao = new Dao_Carte();
        $response = $dao->addImei($imei);
    }
    public function makeImei()
    {
        $iemi = new Imei();
        ///
        $dao = new Dao_Carte();
        //
        $fm = new Format();


//end bn-mara
        $id_product = $fm->validation($_POST['id_product']);
        $imei = $fm->validation($_POST['imei']);
        $id_pos = $fm->validation($_POST['id_pos']);
        $action = $fm->validation($_POST['action']);

        $addedBy = $_SESSION['current_user'];


        //*****************************************

        $iemi->setIdProduct($id_product);
        $iemi->setImei($imei);
        $iemi->setIdPos($id_pos);
        // $myuser->setMatricule($matricule);
        // $myuser->setFonction($fonction);
        // $myuser->setDirection($direction);

        if($action == "ajouter"){

            //$row = $dao->getImeiByIdProductAndIdPOS($iemi->getIdProduct(),$iemi->getIdPos());
            //$ro
            /*if ($row) {

                //$id = $fm->validation($_POST['bnid']);
                $response = $dao->editImei($iemi);
                //$dao->addStockTransaction($stock, $addedBy);
                $info = "La Modification a été effectuée avec succès";

                if ($response == "success") {
                    //die($action);
                    $_SESSION['info'] = $info;

                    header("location:../admin/layout.php?page=addImei");
                }


            } else {
                */


                $response = $dao->addImei($iemi);
                //$dao->addStockTransaction($stock, $addedBy);
                $info = "Les Information ont été ajoutées avec succès";
                $_SESSION['info'] = $info;

                if ($response == "success") {
                    //die($action);

                    header("location:../admin/layout.php?page=addImei");
                }


            //}
        }
        if($action == "modifier"){
            $id = $fm->validation($_POST['bnid']);
            $response = $dao->editImei($iemi);
            //$dao->addStockTransaction($stock, $addedBy);
            $info = "La Modification a été effectuée avec succès";

            if ($response == "success") {
                //die($action);
                $_SESSION['info'] = $info;

                header("location:../admin/layout.php?page=addImei");
            }
        }






    }

}
