<?php include('header.php'); ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>INSOL India is an independent leadership body</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
    	<div class="gallery_list">
        	<p>
            	<a href="gallery.php">
                	<span data-hover="back to previous page">back to previous page</span>
                </a>
            </p>
        </div>
        <ul class="gallery-list">  
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>                 
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                </a>
            </li>
            
        </ul>
        
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".gallery-list").lightGallery({
			autoplay: true,
			selector: 'li a',
			width: '1142px',
			height: '100%',
			mode: 'lg-fade',
			addClass: 'fixed-size',
			counter: false,
			download: false,
			startClass: '',
			enableSwipe: true,
			enableDrag: false,
			speed: 500,
			share: false,
			autoplayControls: false,
			actualSize: false
		}); 
	});
</script>
<?php include('footer.php'); ?>