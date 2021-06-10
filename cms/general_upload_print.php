<?php
session_start();
error_reporting(0);
include("ajax_include.php");
$ID = $_REQUEST['ID'];
?>
<style>
    table,tbody,tr,td,img{
        /*display:block !important;*/
        width:100% !important;
        padding: 0px 0px !important;
    }
    #foot_icon img{
            display: block !important;
    width: auto !important;
    padding: 2px 1px !important;
    }
    
    #foot_icon tr {
    display: flex;
    flex-direction: column;
}
</style>
<?php
echo generaluploadFormat($ID,$via = "NO");

?>
<style>
    .newletterContent img {
    width: 100% !important;
    height: 940px !important;
}
</style>
<script language="javascript" type="text/javascript">

function printBForm()
{
    window.print();
}

printBForm();
</script>