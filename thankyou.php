<?php 
error_reporting(E_ALL);
ob_start();

include('header.php'); 
$ty = $_REQUEST['ty'];

if($ty !='')
{

?>


<div class="clearfix banner">
	<div class="container">
    	<h1>Resources</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'membership_left_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
            <?php 
            if($ty == "member")
            {
            ?>
    			<h2>Thank You</h2>
    			<p>Thank you for your interest in the membership of INSOL India. We have received your membership form.  The request has been forwarded to membership committee. We will let you know soon.</p>
            <?php
            }
            ?>
         </div>
    </div>
</div>
<?php
}
else
{
    header("Location:index.php");

}
?>
<?php include('footer.php'); ?>
