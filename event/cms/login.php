<?php 
ob_start();
error_reporting(0);
include("../library_insol/class.pdo.php");
include("../global_functions.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>favicon.ico" rel="shortcut icon" type="image/png" />
<title><?php echo $_SESSION["COMPANY_NAME"]; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>mobile.css" media="screen and (min-width:100px) and (max-width:500px)" />
<script type="text/javascript">
function clearText(field){
	if (field.defaultValue == field.value) field.value = '';
	else if (field.value == '') field.value = field.defaultValue;
	}
</script>
</head>

<body onLoad="document.frm1.username.focus();">
<?php 
if(isset($_REQUEST['msg'])){$msg=$_REQUEST['msg'];} else {$msg="";}
?>

<form id="frm1" name="frm1" method="post" action="login_submit.php" onSubmit="return validate();">
<input name="mid" type="hidden" id='mid' value="<?php echo $_REQUEST['mid'];?>" readonly='' style="display: none;"/>

<table class="loginWrap" cellpadding="0" cellspacing="0">
    <tr>
    	<td align="center" valign="middle">    
        	<table class="loginTable" cellpadding="0" cellspacing="0">
                <tr>
                    <th><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>logo.png" width="auto"/></th>
                </tr>
                <?php 
                if(isset($_REQUEST['msg'])){$msg=$_REQUEST['msg'];?>
                    <tr><td height="10" class="login_msg" align="center" style="padding:0px;"><?php echo $msg;?></td></tr>
                <?php 
                } 
                else 
                { 
                    echo "<tr><td height='0' style='padding:0px;'>&nbsp;</td></tr>";
                }
                ?>
                
                <tr>
                	<td><input name="username_insol" type="text" id='username' value="Login ID" onFocus="clearText(this)" onBlur="clearText(this)" autocomplete="off" class="loginTxtBox" /></td>
                </tr>
                <tr>
                	<td><input name="password_insol" type="password" id="password" value="Password" onFocus="clearText(this)" onBlur="clearText(this)" class="loginPassBox" /></td>
                </tr>
                <tr>
                	<td><input type="submit" value="Submit" name="Submit" class="loginsubmitBtn"/></td>
                </tr>
                
                <tr>
                	<td>&nbsp;</td>
                </tr>
                
                <tr>
                	<td class="loginFooter">copyright &copy; <?php echo $_SESSION["COMPANY_NAME"]; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>
 


<script language="javascript" type="text/javascript">
function validate()
{
	var form = document.frm1;
	if((form.username.value == "")||(form.username.value == "Login ID"))
	{
		alert("Please enter Login ID");
		form.username.focus();
		return false;
	}
    
	if((form.password.value == "")||(form.password.value == "Password"))
	{
		alert("Please enter password");
		form.password.focus();
		return false;
	}
	return true;
}
</script>

</body>
</html>

