<?php
error_reporting(0);
session_start();
include("library_insol/class.pdo.php");
include('library_insol/class.phpmailernew.php');
include("global_functions.php");

$file = trim($_POST['file']);
$title = trim($_POST['title']);
$description = trim($_POST['msg']);

$TO_EMAIL = "newsletter@insolindia.com";
$FROM_EMAIL =  $_SESSION["INFO_EMAIL"];

$SUBJECT="Newsletter Contribution Received";
//$arr = json_decode($file);
$arr = $_SESSION['img_array'];
/*
        $body="";
        $body.="<table border='1' cellpadding='10'>";
        $body.="<thead>";
        $body.="<tr><th>Title</th><th>Description</th></tr>";
        
        $body.="</thead>";
        $body.="<tbody>";
        $body.="<tr><td>$title</td><td>$description</td></tr>";
        $body.="</tbody>";
        $body.="</table>";
*/
$mMAIL = "";    
    $mMAIL .= "
    <style type='text/css' media='screen'>
        .newletterContent img{width:100% !important; height:auto !important;}
    </style>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background: #eaeaea'>
        <tbody>
            <tr>
                <td bgcolor='#eaeaea' align='center'>
                    <table width='848' border='0' cellspacing='0' cellpadding='0' align='center' style='font-family: arial; border: 1px solid #EAEAEA;'>
                        <tbody>
                            <tr>
                                <td style='line-height:0px;'><img src='".SITE_IMAGES."header.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                            </tr>
                            <tr>
                                <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; font-size: 18px; padding: 12px 25px; font-weight:bold;'>Hi,<br> ".$_SESSION['FULLNAME']." has Contributed to Our Newsletter</td>
                            </tr>
                           
                            <tr>
                                <td valign='top' class='newletterContent' bgcolor='#fff' style='padding: 15px 25px;'>
                                <h2>";
                                $mMAIL .= $title."
                                </h2>";
                                $mMAIL .= $description. "</td>
                            </tr>
                			
                            <tr>
                                <td bgcolor='#ffffff' style='background: #d9d9d9; padding: 25px; color: #000; font-size: 11px;'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size: 11px;'>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br>Contact No. 011 49785744 
                                                    Email: <a href='mailto:contact@insolindia.com' target='_blank' style='color: #000; text-decoration: none;'>contact@insolindia.com</a> | Website: <a href='http://www.insolindia.com' style='color: #000; text-decoration: none;' target='_blank'>www.insolindia.com</a>
                                                </td>";
                                              
                                            $mMAIL .= "</tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>";
if(count($arr)>0)
{
	$value_attach ="";
	foreach ($arr as $key => $value) {

		if(file_exists(FLD_NEWSLETTER_CONTRIBUTE."/".$value))
		{
			$attachment= FLD_NEWSLETTER_CONTRIBUTE."/".$value;
			if($value_attach!='')
			{
				$value_attach.=",";
			}
			$value_attach.=$attachment;

		}
	//echo"<br>";
	}

	$mail = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $mMAIL, $value_attach, "");
	if($mail)
	{
		echo "Mail Has Been Sent Successfully";
	}
	else{
		echo"Something Went Wrong";
	}
unset($_SESSION['img_array']);
}
else
{
	$mail = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $mMAIL, "", "");
	if($mail)
	{
		echo "Mail Has Been Sent Successfully";
	}
	else{
		echo"Something Went Wrong";
	}
}

?>