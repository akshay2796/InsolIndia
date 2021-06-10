<?php 
error_reporting(E_ALL);
ob_start();
session_start();
include("../library_varrsha/class.pdo.php");
include("../library_varrsha/class.inputfilter.php");
include("../library_varrsha/function.php");
include("../global_functions.php");

sleep(1);
session_destroy();
header("Location:login.php");
exit();
?>