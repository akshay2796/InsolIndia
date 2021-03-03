<?php 
error_reporting(0);
session_start();
include("library_insol/class.pdo.php");
$arr []=array();
foreach ($_FILES as $index => $file) {

	$filename = $file['name'];
	$fileTempName = $file['tmp_name'];

	if(!empty($file['error'][$index]))
	{

		return false;
	}

	if(!empty($fileTempName) && is_uploaded_file($fileTempName))
	{
		//FLD_NEWSLETTER_CONTRIBUTE.$filename;
		
		move_uploaded_file($fileTempName,FLD_NEWSLETTER_CONTRIBUTE."/".$filename);
		$arr []= $filename;

	}
}
	//echo json_encode($arr);
   

?>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){  
        $(".deleteFILE").click(function(){
            var value = $(this).attr("value");
            //alert(value);
            $(this).deleteFILE({ID: value});  
        });
    });
</script>
<table class="imgBdr">
    <?php 
        $_SESSION['img_array'] = array();
        for($i=1; $i<count($arr); $i++)
        {
           array_push($_SESSION['img_array'], $arr[$i]); 
    ?>
    <tr>
        <td width="80%">
            <?php echo $arr[$i]; ?>
        </td>
        <td width="20%" style="text-align: right;">
            <a href="javascript:void(0);" value="<?php  echo $arr[$i]; ?>" class="deleteFILE"> X </a>
        </td>
    </tr>
    <?php
        }
    
    ?>
</table>


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