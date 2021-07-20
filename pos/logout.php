<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 28/06/2020
 * Time: 21:00
 */
//session_start();
require_once("../controllers/auth.php");
$auth = new AuthenticationController();
//die($_SESSION['current_user_login_id']);
$auth->updateLogout();
session_unset();
session_destroy();
header("location:index.php");
