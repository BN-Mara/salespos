<?php include_once '../models/Dao_Carte.php' ?>
<?php
 session_start();
  $response=new Dao_Carte();
 //$_SESSION['current_user_login_id'];
 $row=$response->updateLogout($_SESSION['current_user_login_id']);
  
  //die ($_SESSION['current_user_login_id']);
  //echo "Logout Successfully ";
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // function that Destroys Session 
  header("Location:login.php");
?>