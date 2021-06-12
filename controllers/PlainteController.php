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
    $userC= new PlainteController();
    $userC->makePlainte();

}
class PlainteController
{
    public function __construct()
    {
    }
    public function makePlainte()
    {
        $xrate=new Plainte();
        ///
        $dao=new Dao_Carte();
        //
        $fm=new Format();


//end bn-mara
        $solution = $fm->validation($_POST['solution']);
        $status = $fm->validation($_POST['status']);
        $action = $fm->validation($_POST['action']);

        //*****************************************

        //$xrate->setRate($rate);
        //$xrate->setAddedBy($_SESSION['current_user']);


     /*   if($action == "ajouter"){

            $response=$dao->addRate($xrate);
            $info = "Les Information ont été ajoutées avec succès";
            $_SESSION['info'] = $info;

            if($response=="success")
            {
                //die($action);

                header("location:../admin/layout.php?page=addRate");
            }
        }
*/

        if($action == "modifier"){
            $id = $fm->validation($_POST['bnid']);
            $response=$dao->updatePlainteSolution($solution,$status,$id);
            $info = "La Modification a été effectuée avec succès";

            if($response=="success")
            {
                //die($action);
                $_SESSION['info'] = $info;

                header("location:../admin/layout.php?page=setPlaintesolution&id=$id");
            }
        }


    }

}
