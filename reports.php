<?php include('header.php'); ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Resources</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'resources_left_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
        	<h2>Reports</h2>
          <div class="row">
           <div class="col-md-6 col-sm-6 col-xs-12 reso_sect eqH"> <!--======Loop Div=========-->
				<div class="reso_sect_img publicationImg" style="position: relative;">
					   <img src="<?php echo SITE_IMAGES.'blankImg-lh.png'; ?>" style="width:100%;" />
						<a href="downloads/report.pdf" target="_blank">
							<div class="ImgBoxOuter">
								<span class="ImgBoxInner"><img src="<?php echo SITE_IMAGES.'report.jpg'; ?>" class="imgSize img-zoom" alt=""/></span>
							</div>
						</a>                               
					</div>
				<div class="reso_sect_text">
					<h3>
						<a href="downloads/report.pdf" target="_blank">Effective Implementation of Insolvency and Bankruptcy Code</a>
					</h3>
					<p>
						Launched on the occasion of ASSOCHAM INSOL India Conference on Insolvency held on 28-29 April 2017 in New Delhi with the Society of Insolvency Practitioners of India as Knowledge Partner and Edelweiss as Summit Partner.						
					</p>
					<h4>
						<i class="fa fa-calendar" aria-hidden="true"></i>
						<span>28 April, 2017</span>
					</h4>
					
				</div>
			</div>
			</div>
           
        </div>
    </div>
</div>
<?php include('footer.php'); ?>