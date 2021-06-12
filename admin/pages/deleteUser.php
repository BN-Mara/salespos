<?php
include_once '../models/Dao_Carte.php';

if(isset($_GET['id'])){
$id = $_GET['id'];
  $response=new Dao_Carte();
  $row=$response->deleteOneUserById($id);
 if($row=="success"){
  $info = "utilisateur a été supprimé avec succès";
  $_SESSION['info'] = $info;
 }
 
  echo '<script>window.location.href="layout.php?page=users"</script>';
  return;

}

?>