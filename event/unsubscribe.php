<?php 
include("header.php"); 


$member_id = trustme($_REQUEST['id']); 
$email = trustme($_REQUEST['email']); 


$stmt = $dCON->prepare("SELECT COUNT(*) as ct FROM ".BECOME_MEMBER_TBL." WHERE email = ? and member_id = ? ");
$stmt->bindParam(1, $email);
$stmt->bindParam(2, $member_id);
$stmt->execute();
$row_stmt = $stmt->fetchAll();
$stmt->closeCursor();    
$COUNT = (int) $row_stmt[0]['ct'];

if($COUNT > 0)
{
    $sth = $dCON->prepare("UPDATE ".BECOME_MEMBER_TBL." SET subscribe = 'NO' WHERE email = ? and member_id = ? ");
    $sth->bindParam(1, $email);
    $sth->bindParam(2, $member_id);
    $rs = $sth->execute();
    $sth->closeCursor();
    
}
else
{
    $rs = 2;
} 

switch($rs)
{
    case "1":
        $Msg ="You have been successfully unsubscribed.";
    break;
    case "2":
        $Msg = "Email address does not exists";
    break;
    default:
        $Msg = "Sorry cannot process your request";
    break;
}

?>



<form name="frmUn" id="frmUn" method="post" action="unsubscribemsg.php">
    <input type="hidden" name="msg" id="msg" value="<?php echo $Msg; ?>" class="input" style="width: 180px;" />
 </form>

<script>
    $(document).ready(function(){
       $("#frmUn").submit();
    });
</script>



<!--div class="clearfix banner">
	<div class="container">
    	<h1>Unsubscrib to Newsletter</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page media_page pagination__list">
        <h3 class="subsubHead">Processing please wait.........</h3>
    </div>
</div-->
 
<?php
include("footer.php");
?>