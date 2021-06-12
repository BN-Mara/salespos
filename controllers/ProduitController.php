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
    $fichierC= new FichierController();
    $fichierC->makeFichier();

}
class FichierController
{
    public function __construct()
    {
    }
    public function makeFichier()
    {
        $product=new Product();
        ///
        $dao=new Dao_Carte();
        //
        $fm=new Format();


//end bn-mara
        $code = $fm->validation($_POST['code']);
        $find = $dao->findCodeProduit($code);



            //$descr = $fm->validation($_POST['description']);
            $addBy = $_SESSION['current_user'];
            $action = $fm->validation($_POST['action']);
            $price = $fm->validation($_POST['price']);
            $name = $fm->validation($_POST['name']);
            //$nom_fichier = $dao->getTypeById($id_type_document);
            //$qt = $fm->validation($_POST['qt']);
            $produit_type = $fm->validation($_POST['produit_type']);



            //*****************************************

        $product->setDesignation($name);
            //$product->setDescription($descr);
        $product->setPrice($price);
        $product->setAddedBy($addBy);
            //$product->setModifierPar($addBy);
            //$product->setQuantity($qt);
        $product->setCode($code);
        $product->setIdCategory($produit_type);


            //$product->setModifPar($addBy);
            $response = new Dao_Carte();
            $info = "";

            if ($action == "ajouter") {
                if($find  > 0){
                    $_SESSION['infoerror'] = "Code produit existe deja";
                   header("location:../admin/layout.php?page=ajoutProduit");

                }else{

                    $response = $dao->addProduit($product);
                    //$resp = $dao->addProduitStock($product->getCode(),$product->getQuantity(),$addBy);
                    $_SESSION['info']  = "Les Informations ont été ajoutées avec succès";
                    if ($response == "success") {

                        header("location:../admin/layout.php?page=ajoutProduit");
                    }
                    else
                        echo "error";

                }

            }

            if ($action == "modifier") {

                $id = $fm->validation($_POST['bid']);
                $response = $dao->editProduit($product, $id);
                //$resp = $dao->editProduitStock($id,$fichier->getQuantity(),$addBy);
                $_SESSION['info'] = "La Modification a été effectuée avec succès";
                if ($response == "success") {

                    header("location:../admin/layout.php?page=editProduit&id=".$id);
                }


            }




    }

}
