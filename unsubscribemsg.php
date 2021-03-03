<?php 
include("header.php"); 


$msg = trustme($_REQUEST['msg']); 

?>



<div class="clearfix banner">
	<div class="container">
    	<h1>Unsubscribe to Newsletter</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page media_page pagination__list">
        <h3 class="subsubHead"><?php echo $msg;?></h3>
    </div>
</div>
 
<?php
include("footer.php");
?>