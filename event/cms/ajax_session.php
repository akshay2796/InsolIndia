<?php 
//error_reporting(E_ALL);
session_start();

if(!isset($_SESSION['USERID_DPG']))
{
     
    header("Location: login.php?msg=".urlencode("Please Login To Access Control Panel"));
    exit();
}
//ini_set("memory_limit","1024M");
?>