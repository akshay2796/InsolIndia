<?php
session_start();
error_reporting(E_ALL);
include("ajax_include.php");
$ID = $_REQUEST['ID'];

echo newsletterFormat($ID,$via = "NO");


?>

<script language="javascript" type="text/javascript">

function printBForm()
{
    window.print();
}

printBForm();
</script>