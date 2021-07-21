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
  if(isset($_POST['modifpw'])){
    $userC->changePassword();

  }else if(isset($_POST['modifpwpos'])){
    $userC->changePasswordPOS();
  }
  else{
    $userC->makeUser();

  }


}
class UserController
{
  public function __construct()
    {
    }

    public function changePassword(){
      $dao=new Dao_Carte();
      $fm=new Format();
      $pw = $fm->validation($_POST['modifpw']);
      $username = $_POST['username'];
      $res = $dao->changePassword($username,$pw,$_SESSION['current_user']);
      if($res=="success")
    {
        //die($action);
        $_SESSION['info'] = "le Mot de passe a ete modifie avec success";
        
        header("location:../admin/layout.php?page=userProfile");
    }
    }
    public function changePasswordPOS(){
      $dao=new Dao_Carte();
      $fm=new Format();
      $pw = $fm->validation($_POST['modifpwpos']);
      $username = $_POST['username'];
      $res = $dao->changePassword($username,$pw,$_SESSION['current_user']);
      if($res=="success")
    {
        //die($action);
        $_SESSION['info_success'] = "le Mot de passe a ete modifie avec success";
        
        header("location:../pos/index.php?page=profile");
    }
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
      $email = $fm->validation($_POST['email']);
      


    $role = $fm->validation($_POST['role']);
    
     // $matricule = $fm->validation($_POST['matricule']);
    $phone = $fm->validation($_POST['phone']);
    $status = $fm->validation($_POST['status']);
	$action = $fm->validation($_POST['action']);
  $pos = $fm->validation($_POST['pos']);
  
    $address = $fm->validation($_POST['address']);
      $pages1 = '';
      if(isset($_POST['pages'])){
        $pages = $_POST['pages'];
        $pages1 = "";
        foreach ($pages as $key) {
            $pages1 .= $key.";";
        }

      }
    
    $addedBy = $_SESSION['current_user'];
    
	
	//*****************************************
	
	$myuser->setNoms($noms);
    $myuser->setUsername($username);
    $myuser->setRole($role);
    $myuser->setAddress($address);
    $myuser->setEmail($email);
    
    $myuser->setPhone($phone);
    $myuser->setStatus($status);
    $myuser->setPages($pages1);
    $myuser->setAddedBy($addedBy);
    $myuser->setIdPos($pos);

	if($action == "ajouter"){
        if($chk_username){
          
            $error = "Nom d'utilisateur ".$username." existe deja, trouver un autre";
            $_SESSION['infoerror'] = $error;
            header("location:../admin/layout.php?page=addUser");
            return;
        }else if($email != "" && $email != null){
          $chk_email = $dao->findEmail($email);
          if($chk_email){
            $error = "l'adresse email ".$email." existe deja, trouver un autre";
            $_SESSION['infoerror'] = $error;
            header("location:../admin/layout.php?page=addUser");
            return;
            exit;
          }
        }
        else{
          $password = $fm->validation($_POST['password']);
          $myuser->setPassword($password);
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
   