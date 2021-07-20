<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 29/06/2020
 * Time: 10:15
 */

session_start();

include_once '../helper/Format.php';
spl_autoload_register(function($classe){
    require "../models/".$classe.".php";
});

//$response=new Dao_Carte();

/*if(isset($_POST['login'])){
    //check username and password then set to session
    $c_usnm = $_POST['usrname'];
    $c_psswd = $_POST['psw'];
    $chk = $response->getOneUserByPassword($c_usnm,$c_psswd);
    //var_dump($chk);
    if($chk){
        $_SESSION['user'] = $chk;
        header("location:index.php");

    }else{

        $_SESSION['info'] = "<p>identification incorrecte!</p>";
        header("location:login.php");
    }

}*/
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST) && !empty($_POST) )
{
    if(isset($_POST['usrname']) && isset($_POST['psw'])){
        $auth = new AuthenticationController();
        $auth->checkUser();
        
    }	
    else{
             $error = "remplissez les champs";
             $_SESSION["info"] = $error;
             header("location:../pos/login.php");
    }

}


class AuthenticationController{

    public function checkUser(){
          $response=new Dao_Carte();
          $fm=new Format();
          $logins = new Logins();
          $auth = new AuthenticationController();	
          $username = $fm->validation($_POST['usrname']);
          $pswd = $fm->validation($_POST['psw']);
          $row=$response->findUsername($username);
          //$log = $response->addLogin()
        //die(var_dump($row));
            if($row){
    
                $current_user = $response->getOneUserByPassword($username,$pswd);
                if($current_user){
    
                        $_SESSION['user'] = $current_user;
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
                         $_SESSION['info'] = $error;
                         header("location:../pos/login.php");
                        }else{
                            $resp->updateGranted($_SESSION['current_user_login_id']);
                           header("location:../pos/");
                        }
                       
                      
                }else{
                     $error = "Mot de passe incorrect. ";
                     //die($error);
                     $_SESSION['info'] = $error;
                     header("location:../pos/login.php");
                }
             
            }else{
                       $logins->setUser($username);
                       $logins->setUsercheck('inconnu');
                       $logins->setIp($auth->getUserIp());
                       
                       $logs = $response->addLogin($logins);
                       //die($logs);
                 $error = "l' utilisateur n'existe pas, contacter l'admin";
                 $_SESSION['info'] = $error;
                 header("location:../pos/login.php");
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

    public function updateLogout(){
        
        $id = $_SESSION['current_user_login_id'];
        $resp =  new Dao_Carte();
        $resp->updateLogout($id);
    }

}  
    