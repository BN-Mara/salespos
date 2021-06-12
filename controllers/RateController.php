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
    $userC= new RateController();
    $userC->makeRate();

}
class RateController
{
    public function __construct()
    {
    }
    public function makeRate()
    {
        $xrate=new Xrate();
        ///
        $dao=new Dao_Carte();
        //
        $fm=new Format();


//end bn-mara
        $rate = $fm->validation($_POST['rate']);
        $action = $fm->validation($_POST['action']);

        //*****************************************

        $xrate->setRate($rate);
        $xrate->setAddedBy($_SESSION['current_user']);


        if($action == "ajouter"){

                $response=$dao->addRate($xrate);
                $info = "Les Information ont été ajoutées avec succès";
                $_SESSION['info'] = $info;

            if($response=="success")
            {
                //die($action);

                header("location:../admin/layout.php?page=addRate");
            }
        }


        if($action == "modifier"){
            $id = $fm->validation($_POST['bnid']);
            $response=$dao->editRate($xrate,$id);
            $info = "La Modification a été effectuée avec succès";

            if($response=="success")
            {
                //die($action);
                $_SESSION['info'] = $info;

                header("location:../admin/layout.php?page=editRate&id=$id");
            }
        }


    }

}
