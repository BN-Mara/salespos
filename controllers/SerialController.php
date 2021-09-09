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

/*if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{
    
    $userC= new SerialController();
    if(isset($_POST['uploadcsv'])){
        $userC->uploadFromCSV();

    }else{
        $userC->makeSerial();

    }
    

}*/
class SerialController
{
    public function __construct()
    {
    }
    public function uploadFromCSV(){
        $ct = 0;
        $ct_inserted = 0;
        if ($_FILES["serial_csv"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }else{
            $tmpName = $_FILES['serial_csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));
            //die(var_dump($csvAsArray));
            
            //$hd = explode(",", $csvAsArray[0][0]);
            $hd[0] = trim($csvAsArray[0][0]);
            $hd[1]  = trim($csvAsArray[0][1]);
            $hd[2] = trim($csvAsArray[0][2]);
            //die("this");

            $serialsArray = [];
            $mCount = 0;
            if($hd[0] == "product_code" && $hd[1] == "serial" && $hd[2] == "pos" ){
            foreach($csvAsArray as  $csv){
                
                    $serialsArray[$mCount] = $csv[1];
                    $mCount += 1;
                }
                

            }else{
                return -2;
                exit;
            }
            $condition = implode(', ', $serialsArray);
            $dao = new Dao_Carte();
            $test = $dao->checkExistingSerials($condition);
            if($test > 0){
                return -1;
                exit;
            }

            foreach($csvAsArray as  $csv){
            
                $newcsv = $csv;// explode(",", $csv[0]);
                //die(var_dump($newcsv));

                if($hd[0] == "product_code" && $hd[1] == "serial" && $hd[2] == "pos" ){
                    
                    if($ct > 0){
                        $dao = new Dao_Carte();
                        $p = new Serial();
                        $idP = $dao->getProductByCode($newcsv[0]);
                        $checExistSerial = $dao->checkExistingSerial($newcsv[1]);
                        //$chkExist = $dao->checkProductSerialPOS($idP,$newcsv[2],$newcsv[1]);
                        $chkPos = $dao->getOnePOSById($newcsv[2]);
                        if($checExistSerial == 0){
                            if($idP && $chkPos){
                                                  
                                $p->setIdProduct($idP);
                                $p->setSerial($newcsv[1]);
                                $p->setIdPos($newcsv[2]);
                                $p->setAddedBy($_SESSION['current_user']);
                                $this->createSerial($p);
                                $ct_inserted +=1;
                            

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
                    //exit;
                    break;
                }
            }
            //header("location:../admin/layout.php?page=imeis");


        }
        return $ct_inserted;

    }
    public function createSerial(Serial $serial){
        //die(var_dump($imei));
        $dao = new Dao_Carte();
        $response = $dao->addSerial($serial);
    }
    public function makeSerial()
    {
        $serial = new Serial();
        ///
        $dao = new Dao_Carte();
        //
        $fm = new Format();


//end bn-mara
        $id_product = $fm->validation($_POST['id_product']);
        $seriald = $fm->validation($_POST['serial']);
        $id_pos = $fm->validation($_POST['id_pos']);
        $action = $fm->validation($_POST['action']);

        $addedBy = $_SESSION['current_user'];


        //*****************************************

        $serial->setIdProduct($id_product);
        $serial->setSerial($seriald);
        $serial->setIdPos($id_pos);
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


                $response = $dao->addSerial($serial);
                //$dao->addStockTransaction($stock, $addedBy);
                $info = "Les Information ont été ajoutées avec succès";
                $_SESSION['info'] = $info;

                if ($response == "success") {
                    //die($action);

                    header("location:../admin/layout.php?page=addSerial");
                }


            //}
        }
        if($action == "modifier"){
            $id = $fm->validation($_POST['bnid']);
            $response = $dao->editSerial($serial);
            //$dao->addStockTransaction($stock, $addedBy);
            $info = "La Modification a été effectuée avec succès";

            if ($response == "success") {
                //die($action);
                $_SESSION['info'] = $info;

                header("location:../admin/layout.php?page=addSerial");
            }
        }






    }

}
