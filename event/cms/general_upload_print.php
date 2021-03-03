<?php
session_start();
error_reporting(0);
include("ajax_include.php");
$ID = $_REQUEST['ID'];


echo generaluploadFormat($ID,$via = "NO");

?>

<script language="javascript" type="text/javascript">

function printBForm()
{
    window.print();
}

printBForm();
</script>