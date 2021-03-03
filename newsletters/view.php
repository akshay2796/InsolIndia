<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../header.php'); 
include("../checklogin.php");


$ID = $_GET['nid'];
?>
<html>
<body style="margin: 0; padding:0;">
<?php

echo newsletterFormat($ID, "NEWSLETTER",'');
include('../footer.php'); 
?>