<?php
ob_start();
include 'header.php';
if (LOGGED_IN == "NO") {
    $goto_url = SITE_ROOT . urlRewrite("login.php") . "?ref=members";

    header("Location: $goto_url");

}

//=================================================NEW DATA===========================================================
if (isset($_REQUEST['name'])) {
    $name = trustme($_REQUEST['name']);
}
if (isset($_REQUEST['occupation'])) {
    $occupation = trustme($_REQUEST['occupation']);
}

$search = "";

if ($name != "") {
    $search .= " and (first_name like :name";
    $search .= " OR middle_name like :name";
    $search .= " OR last_name like :name)";

}
if ($occupation != "") {
    $search .= " and (i_am like :occupation";
    $search .= " OR other_i_am like :occupation)";

}

$SQL = "";
$SQL .= " SELECT A.* ";
$SQL .= " FROM " . BECOME_MEMBER_TBL . " as A WHERE status = 'ACTIVE' and payment_status = 'SUCCESSFUL' $search order by first_name";

$SQL_PG = " SELECT COUNT(*) AS CT FROM " . BECOME_MEMBER_TBL . " WHERE status = 'ACTIVE' and payment_status = 'SUCCESSFUL' $search  order by first_name ";

$stmt1 = $dCON->prepare($SQL_PG);
//echo "$SQL===$search_fdate========$search_tdate";

if ($name != "") {
    $stmt1->bindParam(":name", $nam);
    $nam = "%{$name}%";
}

if ($occupation != "") {
    $stmt1->bindParam(":occupation", $occup);
    $occup = "%{$occupation}%";
}

$stmt1->execute();
$noOfRecords_row = $stmt1->fetch();
$noOfRecords = $noOfRecords_row['CT'];
$rowsPerPage = 50;
$pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
$stmt2 = $dCON->prepare($pg_query[0]);

if ($name != "") {
    $stmt2->bindParam(":name", $nam);
    $nam = "%{$name}%";
}

if ($occupation != "") {
    $stmt2->bindParam(":occupation", $occup);
    $occup = "%{$occupation}%";
}

$stmt2->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt2->bindParam(":RPP", $RPP, PDO::PARAM_INT);
$offset = $pg_query[1];
$RPP = $rowsPerPage;
$paging = $pg->getAjaxPagingLink($noOfRecords, $rowsPerPage);
$dA = $noOfRecords;
$stmt2->execute();
$row = $stmt2->fetchAll();
$availDATA = count($row);
//echo '<pre>'; print_r($row);
//print_r($stmt2->errorInfo());

?>


<style>
	.mytbl td{border-top: 0px !important; border-bottom: 1px solid #ccc !important;}
</style>

<div class="clearfix banner">
	<div class="container">
    	<h1>Membership Directory</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page members">
       <!--h2>MEMBERS LIST OF INSOL INDIA</h2-->

          	<form class="form-inline pull-right" method="GET">
			  <div class="form-group">
				<label class="sr-only" for="name">name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Search by Name" >
			  </div>
			  <div class="form-group">
				<label class="sr-only" for="occupation">Occupation</label>
				<input type="text" class="form-control" id="occupation" name="occupation" placeholder="Search By Occupation" >
			  </div>
			  <button type="submit" class="btn btn-primary">Search</button>
              <?php
if (($name != "") || ($occupation != "")) {
    ?>
                    <input type="reset" value="Clear Search" class="btn btn-primary" style="background-color: #23408C;" onClick="document.location.href='<?php echo SITE_ROOT . urlRewrite("members.php") ?>';" >
              <?php }?>

			</form>


           <div class="table">
            <table width="100%" class="table table-striped mytbl" cellpadding="0" cellspacing="0">
                <?php

if (($name != "") || ($occupation != "")) {
    ?>
                                   <b>Your Searched: </b>
                                <?php
if ($name != "") {
        ?>
                                        Name : <?php echo $name;if ($occupation != "") {echo ", ";} ?>
                                    <?php

    }
    if ($occupation != "") {

        ?>
                                         Occupation : <?php echo $occupation; ?>
                                    <?php

    }
}
$name = "";
$occupation = "";
if ($availDATA > intval(0)) {
    ?>
                    <tbody>
                       <tr style="border-top: 0;">
						</tr>
                        <?php

    if (intval($_REQUEST['page']) > intval(0)) {
        $count = intval(abs(intval($_REQUEST['page']) - 1)) * intval($rowsPerPage) + 1;
    } else {
        $count = 1;
    }

    foreach ($row as $rs) {

        $first_name = "";
        $middle_name = "";
        $last_name = "";
        $email = "";
        $name = "";
        $i_am = "";
        $other_i_am = "";

        $first_name = ucwords(strtolower(stripslashes($rs["first_name"])));
        $middle_name = ucwords(strtolower(stripslashes($rs["middle_name"])));
        $last_name = ucwords(strtolower(stripslashes($rs["last_name"])));
        $email = stripslashes($rs["email"]);
        $name = $first_name;
        if ($middle_name != '') {
            $name = $name . " " . $middle_name;
        }
        $name = $name . " " . $last_name;

        $i_am = stripslashes($rs["i_am"]);
        $i_am = str_replace("Other", "", $i_am);

        $other_i_am = stripslashes($rs["other_i_am"]);
        if ($other_i_am != '') {
            if ($i_am != '') {
                $i_am = $i_am . ", " . $other_i_am;
            } else {
                $i_am = $other_i_am;
            }

        }
        ?>
                            <tr>
								<td width="40px" class="mem_td"><span class="img-circle" style="width: 30px; height:30px; background: #23408C; text-align: center; display: inline-block; line-height: 30px; color: #ffffff;"><?php echo $count; ?></span></td>
								<td style="padding-bottom: 8px;">
                               <h3 class="subsubHead" style="margin: 6px 0 5px;"><?php echo $name; ?> <span style="font-size: 13px; color: #666; font-weight: normal;">| <?php echo $email; ?></span></h3>
                               		<?php echo $i_am; ?>
                               </td>
                                <!--td width="50%"></td-->
                            </tr>
                        <?php
$count++;
    }

    ?>
                    </tbody>



                </table>

            <?php
if (trim($paging[0]) != "") {
        ?>
                                <div id="bottomPagging">
                                    <div class="pagingList">
                                        <label>PAGE</label>
                                        <ul>
                                            <?php echo $paging[0]; ?>
                                        </ul>
                                    </div>
                                    <div class="clr"></div>
                                </div>

                            <?php
}
} else {

    echo "<h3>Not Found</h3>";
    echo '</table>';

}
?>
           </div>
        </div>

    </div>

<?php include 'footer.php';?>