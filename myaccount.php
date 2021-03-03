<?php
ob_start();
include("header.php");
define("PAGE_COMMON", "ajax_common.php");

//echo $_SESSION['BOND_UID'] ; "==========";
include("checklogin.php");
?>

    

<div class="clearfix banner">
	<div class="container" >
    	<h1>My Account</h1>
    </div>
</div>    
<div class="container">
   <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'account_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
        	<?php echo "<h2>Welcome " . $_SESSION['FULLNAME'] . "</h2>"; ?>
           	<h3 class="subsubHead">Membership Number : <?php echo $_SESSION['REG_NUMBER']; ?></h3>
			<p>Subscription validity : <?php echo date("d M Y",strtotime($_SESSION['START_DATE'])); ?> To <?php echo date("d M Y",strtotime($_SESSION['END_DATE'])); ?> </p>           
        </div>
    </div>
   
    
</div>


    	
      
<?php include("footer.php"); ?>