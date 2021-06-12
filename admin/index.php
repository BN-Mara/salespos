<?php
session_start();
if(isset($_SESSION['current_user']))
header("location:layout.php");
	else
header("location:login.php");
?>