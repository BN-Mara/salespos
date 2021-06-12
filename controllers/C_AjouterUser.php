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
 $userC= new UserController();
 $userC->makeUser();

}
class UserController
{
  public function __construct()
    {
    }
  public function makeUser()
  {
	$myuser=new User();
    ///
    $dao=new Dao_Carte();
    //
    $fm=new Format();


//end bn-mara	
    $noms = $fm->validation($_POST['noms']);
    $username = $fm->validation($_POST['username']);
      $chk_username = $dao->findUsername($username);

    $role = $fm->validation($_POST['role']);
    $password = $fm->validation($_POST['password']);
     // $matricule = $fm->validation($_POST['matricule']);
    //$phone = $fm->validation($_POST['phone']);
    $status = $fm->validation($_POST['status']);
	$action = $fm->validation($_POST['action']);
      //$fonction = $fm->validation($_POST['fonction']);
      //$direction = $fm->validation($_POST['direction']);
    $pages = $_POST['pages'];
    $pages1 = "";
    foreach ($pages as $key) {
        $pages1 .= $key.";";
    }
    $addedBy = $_SESSION['current_user'];
    
	
	//*****************************************
	
	$myuser->setNoms($noms);
    $myuser->setUsername($username);
    $myuser->setRole($role);
    $myuser->setPassword($password);
    //$myuser->setPhone($phone);
    $myuser->setStatus($status);
    $myuser->setPages($pages1);
    $myuser->setAddedBy($addedBy);
     // $myuser->setMatricule($matricule);
     // $myuser->setFonction($fonction);
     // $myuser->setDirection($direction);
	
	if($action == "ajouter"){
        if($chk_username){

            $error = "Nom d'utilisateur ".$username." existe deja, trouver un autre";
            $_SESSION['infoerror'] = $error;
            header("location:../admin/layout.php?page=addUser");
            return;
        }else{
            $response=$dao->AddUser($myuser);
            $info = "Les Information ont été ajoutées avec succès";
            $_SESSION['info'] = $info;
        }
        if($response=="success")
        {
        //die($action);
        
        header("location:../admin/layout.php?page=addUser");
        }
	}

   
    if($action == "modifier"){
	 $id = $fm->validation($_POST['bnid']);
	 $response=$dao->editUser($myuser,$id);	
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
   