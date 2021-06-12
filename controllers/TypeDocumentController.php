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
    $typeDocumentC= new TypeDocumentController();
    $typeDocumentC->makeTypeDocument();

}
class TypeDocumentController
{
    public function __construct()
    {
    }
    public function makeTypeDocument()
    {
        $typeDocument = new TypeDocument();
        ///
        $dao=new Dao_Carte();
        //
        $fm=new Format();


//end bn-mara
        $type_document = $fm->validation($_POST['type_document']);
        $descr = $fm->validation($_POST['description']);
        $addBy = $_SESSION['current_user'];
        $action=$fm->validation($_POST['action']);

        $type_document = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$reference);

        $type_document = strtoupper($type_document);



        //*****************************************

        $typeDocument->setTypeDocument($type_document);
        $typeDocument->setDescription($descr);


        $typeDocument->setAjouterPar($addBy);
        $typeDocument->setModifierPar($addBy);

        if($action == "ajouter"){
            $response=$dao->addTypeDocument($typeDocument);
            $info = "Type Document a été ajouté avec succès";
        }

        if($action == "modifier"){
            $id = $fm->validation($_POST['bnid']);
            $response=$dao->editTypeDocument($typeDocument,$id);
            $info = "Type Document a été modifié avec succès";
        }


        if($response=="success")
        {
            //die($action);

            header("location:../admin/layout.php?page=ajoutTypeDocument&info=".$info);
        }

    }

}
