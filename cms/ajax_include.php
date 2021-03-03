<?php

include("../library_insol/class.pdo.php");
include("../library_insol/class.pagination.php");
include("../library_insol/class.inputfilter.php");
include("../library_insol/function.php");
include("../library_insol/class.phpmailernew.php");
include("../global_functions.php");

include("ajax_session.php");

/* AJAX check  */
/*
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	/* special ajax here 
    //session_destroy();
	//die("INVALID ACCESS");
}
*/
?>