<?php
error_reporting(0);
include "header.php";
?>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH; ?>jquery-ui-1.10.4.css">

<script language="javascript" type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery.history.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery.datepick.js"></script>
<style type="text/css">
@import "<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH; ?>jquery.datepick.css";
</style>


<!----FANCY BOX SCRIPT START --->
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fancybox/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
<!----FANCY BOX SCRIPT END --->




<h1>Year Wise Member Contribution</h1>

    <table cellpadding="0" cellspacing="0" width="100%" border="1">

                        <tr>
                            <th width="4%" align="left">S No.</th>
                            <th width="33%" align="left">Year</th>
                            <th width="29%" align="left">Count</th>
							<td width="34%" align="center"><b>Export to Excel</b></td>
                        </tr>
						<?php
$SQL = "";
$SQL .= " SELECT YEAR(add_time) as year, COUNT(*) as cnt FROM tbl_become_member_receipt WHERE STATUS='ACTIVE' group by YEAR(add_time) ";
$stmt = $dCON->prepare($SQL);
$stmt->execute();
$row = $stmt->fetchAll();
$stmt->closeCursor();

$sno = 1;
foreach ($row as $rs) {
    ?>

                        <tr class="expiredCoupons trhover">

                                <td><?php echo $sno ?>.</td>
                                <td> <a href="year_contribution.php?year=<?php echo $rs['year']; ?>"><?php echo $rs['year']; ?></a></td>
                                <td><?php echo $rs['cnt']; ?></td>
								<td align="center">
								<a href="year_contribution_excel_member.php?year=<?php echo $rs['year']; ?>" style="color:#D9414D;font-weight: bold;">
                                               <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>excel_icon.png" border="0" title="Export to Excel" alt="Export to Excel" align="absmiddle" /></a>
								</td>
                        </tr><?php $sno++;?><?php }?>

     </table>
    <div class="clear"></div>

<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// echo $actual_link;
if ($actual_link == 'https://www.rightickets.co.uk/insolindia/cms/year_contribution.php') {

} elseif ($actual_link == 'https://rightickets.co.uk/insolindia/cms/year_contribution.php') {

} else {
    ?>

  <h1>Month Wise Renewals</h1>
    <table cellpadding="0" cellspacing="0" width="100%" border="1">

                        <tr>
                            <th width="4%" align="left">S No.</th>
                            <th width="33%" align="left">Year</th>
                            <th width="29%" align="left">Count</th>
							<td width="34%" align="center"><b>Export to Excel</b></td>
                        </tr>
						<?php
$year = $_GET['year'];
    //         echo $year;
    $SQL = "";
    $SQL .= " SELECT MONTHNAME(add_date) as month, MONTH(add_date) as mon, COUNT(*) as cnt FROM renew_member_detail WHERE YEAR(add_date) = $year group by MONTH(add_date) ";
    $connect = mysqli_connect("localhost", "ryanearf_insolindia", "ryanearf_akshay", "Friendship.101");
    $result2 = mysqli_query($connect, $SQL);
    while ($show3 = mysqli_fetch_array($result2)) {

        $sno = 1;

        ?>
                        <tr class="expiredCoupons trhover">
                                <td><?php echo $sno ?>.</td>
                                <td><?php echo $show3['month']; ?></td>
                                <td><?php echo $show3['cnt']; ?></td>
								<td align="center">
								<a href="month_wise_renewal.php?year=<?php echo $year; ?>&month=<?php echo $show3['mon']; ?>" style="color:#D9414D;font-weight: bold;">
                                               <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>excel_icon.png" border="0" title="Export to Excel" alt="Export to Excel" align="absmiddle" /></a>
								</td>
                        </tr><?php $sno++;?><?php }?>
     </table>


<?php
}
include "footer.php";

?>