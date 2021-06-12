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
    $userC= new ImeiController();
    $userC->makeImei();

}
class ImeiController
{
    public function __construct()
    {
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

            $row = $dao->getImeiByIdProductAndIdPOS($iemi->getIdProduct(),$iemi->getIdPos());
            if ($row) {

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


                $response = $dao->addImei($iemi);
                //$dao->addStockTransaction($stock, $addedBy);
                $info = "Les Information ont été ajoutées avec succès";
                $_SESSION['info'] = $info;

                if ($response == "success") {
                    //die($action);

                    header("location:../admin/layout.php?page=addImei");
                }


            }
        }






    }

}
