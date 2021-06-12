<?php include_once '../models/Dao_Carte.php' ?>
<?php
//session_start();

if(isset($_SESSION['current_user']) and ($_SESSION['current_user_role'] == "ADMIN")){
 $permission ="granted";
 $response=new Dao_Carte();
 //$_SESSION['current_user_login_id'];
 $row=$response->updateGranted($_SESSION['current_user_login_id']);
 	
}else{
    //die("eror");
	$error = "Vous n'etes pas permis d'acceder � cette page";
	header("Location:login.php?error=".$error);
}


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	$error = "Votre session est expir�, merci de vous reconnecter";
	header("Location:login.php?error=".$error);
	return;
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}

?>