<?php
session_start();

include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});

if(isset($_POST['username']) && isset($_POST['password'])){
	 $auth = new AuthenticationController();
	 $auth->checkUser();
     
}	
else{
	      $error = "remplissez les champs";
	      header("location:../admin/login.php?error=".$error);
}
	
class AuthenticationController{

public function checkUser(){
	  $response=new Dao_Carte();
	  $fm=new Format();
	  $logins = new Logins();
	  $auth = new AuthenticationController();	
	  $username = $fm->validation($_POST['username']);
	  $pswd = $fm->validation($_POST['password']);
      $row=$response->findUsername($username);
	  //$log = $response->addLogin()
	//die(var_dump($row));
        if($row){

		    $current_user = $response->getOneUserByPassword($username,$pswd);
			if($current_user){


				   $_SESSION['current_user'] = $current_user['username'];
				   $_SESSION['current_user_role'] = $current_user['role'];
				   $_SESSION['current_user_status'] = $current_user['status'];
				//die($_SESSION['current_user_status']);
				   $resp =  new Dao_Carte();
				   $logins->setUser($current_user['username']);				   
				   $logins->setUsercheck('user');
				   $logins->setIp($auth->getUserIp());
				   $logs = $resp->addLogin($logins);				   
				   $_SESSION['current_user_login_id'] = $resp->getLoginId($current_user['username']);
				   //die($_SESSION['current_user_login_id']);
				   
	
				    if($current_user['status'] == 'DESACTIVE'){
					 $error="Utilisateur Inactif. Contacter l'Admin";
					 header("location:../admin/login.php?error=".$error);
				    }else{
					   header("location:../admin/");
				    }
				   
			      
			}else{
				 $error = "Mot de passe incorrect. ";
				 //die($error);
				 header("location:../admin/login.php?error=".$error);
			}
		 
		}else{
			       $logins->setUser($username);
				   $logins->setUsercheck('inconnu');
				   $logins->setIp($auth->getUserIp());
				   
				   $logs = $response->addLogin($logins);
				   //die($logs);
			 $error = "l' utilisateur n'existe pas, contacter l'admin";
			 header("location:../admin/login.php?error=".$error);
		}	  
}
public function getUserIp(){
	  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		  $ip = $_SERVER['HTTP_CLIENT_IP'];
	  }
		  
	  elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		 $ip= $_SERVER['HTTP_X_FORWARDED_FOR']; 
	  }
	  
	  else
	  {
		  $ip = $_SERVER['REMOTE_ADDR'];
	  }
	return $ip;
  }
}  
