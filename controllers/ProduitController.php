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
    if(isset($_POST["uploadcsv"])){
        $fichierC->uploadFromCSV();
    }else{
        $fichierC->makeFichier();

    }
    

}
class FichierController
{
    public function __construct()
    {
    }

    public function uploadFromCSV(){
        if ($_FILES["csv"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }else{
            $tmpName = $_FILES['csv']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));
            //die(var_dump($csvAsArray));
            $ct = 0;
            foreach($csvAsArray as  $csv){
            
                $newcsv = explode(";", $csv[0]);
                if($newcsv[0] !="designation" && $newcsv[1] == "price" && $newcsv[2] != "category" ){
                    header("location:../admin/layout.php?page=produits");
                    return false;
                    exit;
                }
                else{
                    if($ct > 0){
                        $p = new Product();
                        $p->setDesignation($newcsv[0]);
                        $p->setPrice($newcsv[1]);
                        $p->setIdCategory($newcsv[2]);
                        $this->createProduct($p);
                    }
                    $ct +=1;
                }
            }
            header("location:../admin/layout.php?page=produits");


        }

    }
    public function createProduct(Product $product){
        $dao = new Dao_Carte();
        $produit_type1 = $dao->getProductTypeById($product->getIdCategory());
        $code = $dao->generateProductCode($produit_type1['designation']);

        $product->setCode($code);
        $product->setAddedBy($_SESSION['current_user']);
        $response = $dao->addProduit($product);

    }
    public function makeFichier()
    {
        $product=new Product();
        ///
        $dao=new Dao_Carte();
        //
        $fm=new Format();


//end bn-mara
        //$code = $fm->validation($_POST['code']);

        //$find = $dao->findCodeProduit($code);
            //$descr = $fm->validation($_POST['description']);
            $addBy = $_SESSION['current_user'];
            $action = $fm->validation($_POST['action']);
            $price = $fm->validation($_POST['price']);
            $name = $fm->validation($_POST['name']);
            //$nom_fichier = $dao->getTypeById($id_type_document);
            //$qt = $fm->validation($_POST['qt']);
            $produit_type = $fm->validation($_POST['produit_type']);

            //*****************************************
        $produit_type1 = $dao->getProductTypeById($produit_type);
        $code = $dao->generateProductCode($produit_type1['designation']);
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
                
                   /* $_SESSION['infoerror'] = "Code produit existe deja";
                   header("location:../admin/layout.php?page=ajoutProduit");
                    */

                    $response = $dao->addProduit($product);
                    //$resp = $dao->addProduitStock($product->getCode(),$product->getQuantity(),$addBy);
                    $_SESSION['info']  = "Les Informations ont été ajoutées avec succès";
                    if ($response == "success") {

                        header("location:../admin/layout.php?page=ajoutProduit");
                    }
                    else
                        echo "error";

                

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
