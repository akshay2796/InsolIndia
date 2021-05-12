<?php include 'header.php';
//define("PAGE_MAIN","governance_list.php");
//define("PAGE_LIST","governance_detail.php");

?>

<div class="clearfix banner">
    <div class="container">
        <h1>Governance</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-12 col-sm-12">
            <ul class="governanceList">
                <?php
$SQLmenu = "";
$SQLmenu .= " SELECT * FROM " . GOVERNANCE_TYPE_TBL . " as G ";
$SQLmenu .= " WHERE status = 'ACTIVE' order by position ASC  ";
$stmt = $dCON->prepare($SQLmenu);
$stmt->execute();
$dsMENU = $stmt->fetchAll();
$numMENU = count($dsMENU);

if ($numMENU > intval(0)) {
    foreach ($dsMENU as $menuLIST) {
        $menutypeID = (stripslashes($menuLIST['type_id']));
        $menutypeURLKEY = (stripslashes($menuLIST['url_key']));
        $menutypeNAME = (stripslashes($menuLIST['type_name']));

        $menursSUBTYPE = getDetails(GOVERNANCE_SUBTYPE_TBL, '*', "status~~~type_id", "ACTIVE~~~$menutypeID", '=~~~=~~~=', '', '', "");
        $menucountSUBTYPE = "";
        $menucountSUBTYPE = count($menursSUBTYPE);

        if ($menucountSUBTYPE == intval(0)) {
            $menumasterURL = SITE_ROOT . urlRewrite("governance_list.php", array("url_key" => $menutypeURLKEY));
        }
        if ($menucountSUBTYPE == intval(0)) {
            ?>

                <li>
                    <a href="<?php echo $menumasterURL; ?>"
                        style="padding: 0px !important;display:flex;align-items: center;justify-content: center;"
                        class="eqH">
                        <div style="padding: 25px"><?php echo $menutypeNAME; ?></div>
                    </a>
                </li>

                <?php
} else {
            foreach ($menursSUBTYPE as $sbmenuLIST) {
                $submenutypeNAME = htmlentities((stripslashes($sbmenuLIST['subtype_name'])));
                $submenuURLKEY = (stripslashes($sbmenuLIST['url_key']));
                $submenumasterURL = SITE_ROOT . urlRewrite("governance_sub_list.php", array("master_url" => $menutypeURLKEY, "url_key" => $submenuURLKEY));
                ?>
                <li>
                    <a href="<?php echo $submenumasterURL; ?>"
                        style="padding: 0px !important;display:flex;align-items: center;justify-content: center;"
                        class="eqH">
                        <div style="padding: 25px"><?php echo $submenutypeNAME; ?></div>
                    </a>
                </li>
                <?php
}
        }

    }
}
?>
                <!--li>
					<a href="<?php echo SITE_ROOT . urlRewrite("board_governor.php"); ?>">Board of Governors</a>
				</li>
				<li>
					<a href="<?php echo SITE_ROOT . urlRewrite("judges_advisory_roundtable.php"); ?>">Judges Advisory Board</a>
				</li>
				<li>
					<a href="<?php echo SITE_ROOT . urlRewrite("academic_committees.php"); ?>">Academics Committee</a>
				</li>
				<li>
					<a href="<?php echo SITE_ROOT . urlRewrite("young-members-committee.php"); ?>">Young Members Committee</a>
				</li-->
            </ul>


        </div>

    </div>
</div>
</div>
<?php include 'footer.php';?>