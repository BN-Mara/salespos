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
    $userC= new POSController();
    $userC->makePOS();

}
class POSController
{
    public function __construct()
    {
    }
    public function makePOS()
    {
        $pos=new Pos();
        ///
        $dao=new Dao_Carte();
        //
        $fm=new Format();


//end bn-mara
        $noms = $fm->validation($_POST['nom']);
        $city = $fm->validation($_POST['city']);
        $province = $fm->validation($_POST['province']);
        $addedBy = $_SESSION['current_user'];
        $action = $fm->validation($_POST['action']);



        //*****************************************

        $pos->setDesignation($noms);
        $pos->setCity($city);
        $pos->setProvince($province);
        $pos->setAddedBy($addedBy);
        $pos->setIsDeleted(0);
        // $myuser->setMatricule($matricule);
        // $myuser->setFonction($fonction);
        // $myuser->setDirection($direction);

        if($action == "ajouter"){

                $response=$dao->addPOS($pos);
                $info = "Les Information ont été ajoutées avec succès";
                $_SESSION['info'] = $info;

            if($response=="success")
            {
                //die($action);

                header("location:../admin/layout.php?page=addPos");
            }
        }


        if($action == "modifier"){
            $id = $fm->validation($_POST['bnid']);
            $response=$dao->editPOS($pos,$id);
            $info = "La Modification a été effectuée avec succès";

            if($response=="success")
            {
                //die($action);
                $_SESSION['info'] = $info;

                header("location:../admin/layout.php?page=editUser&id=$id");
            }
        }


    }

}
