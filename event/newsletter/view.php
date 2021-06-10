<?php
ob_start();
error_reporting(0);
session_start();

$PAGENAME = strtolower(basename($_SERVER['PHP_SELF']));
include("../library_insol/class.pdo.php");
include("../library_insol/class.inputfilter.php");
include("../library_insol/class.pagination.php");
include("../library_insol/function.php");
include("../global_functions.php");

$ID = intval(base64_decode($_REQUEST['nid']));

if($ID == intval(0)){
    header("location: ".SITE_ROOT); 
}
?>
<html>
<body style="margin: 0; padding:0;">

<?php
echo newsletterFormat($ID, "NEWSLETTER");

?>
</body>
</html>