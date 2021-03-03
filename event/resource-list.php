<?php 
include('header.php'); 
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Resources</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-12 col-sm-12">
        	<ul class="governanceList">
				<?php
                $SQL_CAT  = "";
                $SQL_CAT .= " SELECT * FROM " . RESOURCES_CATEGORY_TBL . " AS TC WHERE `status` = 'ACTIVE' "; 
                $SQL_CAT .= " ORDER BY position ASC "; 
                $stmtL_Cat = $dCON->prepare( $SQL_CAT );
                $stmtL_Cat->execute();
                $rowRCat = $stmtL_Cat->fetchAll();
                $stmtL_Cat->closeCursor();
                //echo count($rowCat);
				foreach($rowRCat as $rsCat)
				{
					$R_cat_id = "";
					$R_cat_name = "";
					$R_cat_url_key = "";

					$R_cat_id = intval($rsCat['category_id']);
					$R_cat_name = stripslashes($rsCat['category_name']);
					$R_cat_url_key = stripslashes($rsCat['url_key']);
					$R_cat_url = SITE_ROOT . urlRewrite("resources.php", array("cat_url_key" => $R_cat_url_key));
				?>
				   <li>
						<a href="<?php echo $R_cat_url; ?>"><?php echo $R_cat_name; ?></a>
					</li>     
				<?php
				}
				?>   

				
			</ul>
            

        </div>
        
        </div>
    </div>
</div>
<?php include('footer.php'); ?>