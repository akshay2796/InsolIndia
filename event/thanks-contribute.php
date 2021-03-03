<?php
ob_start();
include('header.php');
if(LOGGED_IN == "NO") 
{  
    $goto_url = SITE_ROOT .urlRewrite("login.php");

    header("Location: $goto_url");
   
}
define("PAGE_AJAX", "ajax_common.php");
 ?>
   <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script> 

 <div class="clearfix banner">
	<div class="container">
		<h1>Thank You</h1>
	</div>
</div>

<div class="container">
	<div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'account_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9">
		  <h2>Thank You For Contribution</h2>
            

        </div>
	</div>
</div>



<?php include('footer.php'); ?>