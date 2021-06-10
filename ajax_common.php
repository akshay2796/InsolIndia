<?php 
session_start();
ini_set("display_errors",0);
//ini_set("max_input_vars",10000); 
error_reporting(0); 
include("library_insol/all_include.php");
include("global_functions.php");
define("PAGE_COMMON", "ajax_common.php");


$type = trustme($_REQUEST['type']);

switch($type)
{
    case "changePass":
        changePass();
        break;
        
    case "deleteIMAGE":
        deleteIMAGE();
        break;
}
 



function changePass()
{
    global $dCON;
    
    $UID = intval($_SESSION['UID_INSOL']);
    
    $oldpass = trustme($_REQUEST['oldpass']);
    $new_password = trustme($_REQUEST['newpass']);
    $confirm_password = trustme($_REQUEST['repass']);
    
    if($new_password == $confirm_password)
    {
        
        $SQL  = "";
        $SQL .= " UPDATE " . BECOME_MEMBER_TBL . " SET ";  
        $SQL .= " password = '".$new_password. "'";
        $SQL .= " WHERE member_id = :member_id ";
        $SQL .= " AND password = '".$oldpass."' ";        
        //echo $SQL . $UID . "\n";
        $stmt = $dCON->prepare( $SQL );         
        $stmt->bindParam(":member_id", $_SESSION['UID_INSOL']); 
        $rs = $stmt->execute();
        $count = $stmt->rowCount();
        $stmt->closeCursor();        
        if( intval($count) > intval(0) )
        {
            $dbRES = 1;
        }
        else
        {
            $dbRES = 3;
        }       
        
    }
    else
    {
        $dbRES = 2;
    }
    
    switch($dbRES)
    {
        case "1":
            echo "~~~1~~~Password successfully changed";
            break;
        case "0":
            echo "~~~0~~~Sorry cannot process your request";
            break;
        case "2":
            echo "~~~2~~~Confirm password does not match";
            break;
        case "3":
            echo "~~~3~~~Kindly confirm the passwords again";
            break;
        
    }

}


function deleteIMAGE()
{
    global $dCON;
    
    $image = trim($_REQUEST['ID']);
   
    ///print_r($_SESSION['img_array']);
    $idx = array_search($image, $_SESSION['img_array']);
    
    unset($_SESSION['img_array'][$idx]);
    
    unlink( FLD_NEWSLETTER_CONTRIBUTE . "/" . $image);
   
    
    ?>
        <table class="imgBdr">
    <?php 
       $img_array = array_values($_SESSION['img_array']);
        for($i=0; $i<count($img_array); $i++)
        {
           
    ?>
            <tr>
                <td width="80%">
                    <?php echo $img_array[$i]; ?>
                </td>
                <td width="20%" style="text-align: right;">
                    <a href="javascript:void(0);" value="<?php  echo $img_array[$i]; ?>" class="deleteFILE"> X </a>
                </td>
            </tr>
    <?php
        }
    
    ?>
        </table>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){  
        $(".deleteFILE").click(function(){
            var value = $(this).attr("value");
            //alert(value);
            $(this).deleteFILE({ID: value});  
        });
    });
</script>

<style>
.imgBdr{
        background-color: transparent;
    border: 1px solid #ededec;
    margin-bottom: 20px;
    width: 60%;
}
.imgBdr tr{
    border-bottom:1px solid #ededec;
}
.imgBdr tr td{
    padding: 5px;
    font-size: 13px;
}
.imgBdr tr td a{
    display: inline-block;
    font-size: 16px;
    width: 25px;
    height: 25px;
    text-align: center;
    line-height: 25px;
    background-color: #efefef;
    color: #b71d20;
}
</style>
    
<?php
    
   
}


 





?>