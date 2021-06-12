<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 28/06/2020
 * Time: 21:00
 */
session_start();
session_unset();

header("location:index.php");
