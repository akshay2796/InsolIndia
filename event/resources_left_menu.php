
<?php
if($page_name =='resources.php')
{
    $SQLCAT  = "";
    $SQLCAT .= " SELECT * FROM " . RESOURCES_CATEGORY_TBL . " AS TC WHERE `status` = 'ACTIVE' "; 
    $SQLCAT .= " ORDER BY position ASC "; 
    $stmtCat = $dCON->prepare( $SQLCAT );
    $stmtCat->execute();
    $rowRCat = $stmtCat->fetchAll();
    $stmtCat->closeCursor();
    //echo count($rowCat);
    if(intval(count($rowRCat)) > intval(0))
    {
    ?>
        <ul>
            <?php
            foreach($rowRCat as $rsRCat)
            {
                $R_cat_id = "";
                $R_cat_name = "";
                $R_cat_url_key = "";
                $R_cat_url = "";
                
                $R_cat_id = intval($rsRCat['category_id']);
                $R_cat_name = stripslashes($rsRCat['category_name']);
                $R_cat_url_key = stripslashes($rsRCat['url_key']);
                $R_cat_url = SITE_ROOT . urlRewrite("resources.php", array("cat_url_key" => $R_cat_url_key));
            ?>  
            	<li>
            		<i class="fa fa-angle-right" aria-hidden="true"></i>
            		<a href="<?php echo $R_cat_url ?>" <?php if(intval($R_cat_id) == intval($category_id)){echo 'class="active"';} ?>><?php echo $R_cat_name; ?></a>
            	</li>
             <?php
             }
             ?> 
        </ul>
    <?php
    }
}
else
{
?>

    <ul>
          
    	<li>
    		<i class="fa fa-angle-right" aria-hidden="true"></i>
    		<a href="<?php echo SITE_ROOT ?>law-regulations-and-rules.php" <?php if($page_name == "law-regulations-and-rules.php"){echo 'class="active"';} ?>>Law, Regulations and Rules</a>
    	</li>
    	<li>
    		<i class="fa fa-angle-right" aria-hidden="true"></i>
    		<a href="<?php echo SITE_ROOT ?>reports.php" <?php if($page_name == "reports.php"){echo 'class="active"';} ?>>Reports</a>
    	</li>
    	<li>
    		<i class="fa fa-angle-right" aria-hidden="true"></i>
    		<a href="<?php echo SITE_ROOT ?>articles.php" <?php if($page_name == "articles.php"){echo 'class="active"';} ?>>Articles</a>
    	</li>
    	<li>
    		<i class="fa fa-angle-right" aria-hidden="true"></i>
    		<a href="<?php echo SITE_ROOT ?>papers.php" <?php if($page_name == "papers.php"){echo 'class="active"';} ?>>Papers</a>
    	</li>
    	<li>
    		<i class="fa fa-angle-right" aria-hidden="true"></i>
    		<a href="<?php echo SITE_ROOT ?>blogs.php" <?php if($page_name == "blogs.php"){echo 'class="active"';} ?>>Blogs</a>
    	</li>
          
          
    </ul>
<?php
}
?>