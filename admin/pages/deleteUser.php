<?php
session_start();
include_once '../models/Dao_Carte.php';

$response=new Dao_Carte();
$chkPg = $response->checkPagesByUsername($_SESSION['current_user'], "deleteUser");
if($chkPg){
  if(isset($_GET['id'])){
    $id = $_GET['id'];
      
      $row=$response->deleteOneUserById($id);
     if($row=="success"){
      $info = "utilisateur a été supprimé avec succès";
      $_SESSION['info'] = $info;
     }
     
      echo '<script>window.location.href="layout.php?page=users"</script>';
      return;
    
    }

}else{
  $info = "Vous n\'etes pas autorise pour cette tache!";
      $_SESSION['info'] = $info;
      echo '<script>window.location.href="layout.php?page=users"</script>';
      return;

}



?>