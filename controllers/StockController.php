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
    $userC= new StockController();
    $userC->makeStock();

}
class StockController
{
    public function __construct()
    {
    }
    public function makeStock()
    {
        $stock = new Stock();
        ///
        $dao = new Dao_Carte();
        //
        $fm = new Format();


//end bn-mara
        $id_product = $fm->validation($_POST['id_product']);
        $qte = $fm->validation($_POST['qte']);
        $id_pos = $fm->validation($_POST['id_pos']);
        $action = $fm->validation($_POST['action']);

        $addedBy = $_SESSION['current_user'];


        //*****************************************

        $stock->setIdProduct($id_product);
        $stock->setQuantity($qte);
        $stock->setIdPos($id_pos);
        // $myuser->setMatricule($matricule);
        // $myuser->setFonction($fonction);
        // $myuser->setDirection($direction);

        if($action == "ajouter"){

        $row = $dao->getStockByIdProductAndIdPOS($stock->getIdProduct(),$stock->getIdPos());
        if ($row) {

            //$id = $fm->validation($_POST['bnid']);
            $response = $dao->editProductStock($stock);
            $dao->addStockTransaction($stock, $addedBy);
            $info = "La Modification a été effectuée avec succès";

            if ($response == "success") {
                //die($action);
                $_SESSION['info'] = $info;

                header("location:../admin/layout.php?page=addStock");
            }


        } else {


            $response = $dao->addStock($stock);
            $dao->addStockTransaction($stock, $addedBy);
            $info = "Les Information ont été ajoutées avec succès";
            $_SESSION['info'] = $info;

            if ($response == "success") {
                //die($action);

                header("location:../admin/layout.php?page=addStock");
            }


        }
    }






    }

}
