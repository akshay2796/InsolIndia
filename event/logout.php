<?php
ob_start();
error_reporting(0);
session_start();
include("library_insol/class.pdo.php");
include("library_insol/class.inputfilter.php");
include("library_insol/function.php");
include("global_functions.php");



session_destroy();
session_regenerate_id();

header("Location:".SITE_ROOT);
//header("Location:uc.html");
?>