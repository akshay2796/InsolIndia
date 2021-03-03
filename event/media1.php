<?php include('header.php'); ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Media</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page events_list">
    	<div class="gallery_list">
            <p>
                <a href="#">
                    <span data-hover="back to previous page">back to previous page</span>
                </a>
            </p>
        </div>
        <h2>A stronger Wellington, today and tomorrow</h2>
        <h4>
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span>13 September, 2016</span>
        	|
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Caden Anderson</span>
        </h4>
        
        <h5>The Kaikoura earthquake on 14 November was a wake-up call for Wellington. While science and history have told us to prepare for a big shake, there's no reminder quite as powerful as the real thing, says Mayor Justin Lester.</h5>
        <p>It could have been worse, of course, and our job now is to keep strengthening our city and communities so we can respond effectively and recover quickly if another one hits.</p>
        <p>We also want to make sure we're thinking about the other stresses - physical, social and economic - Wellington might face in the future. To do this, we're introducing the best local solutions with the support of leading thinkers from around the world.</p>
        <h5>Making our city safer</h5>
        <p>While buildings and infrastructure in the capital have generally been built tough, there's more we can do to keep people safe. Among the projects we're supporting this year is a joint fund with the Government to help Wellington building owners to secure unreinforced masonry on their properties.</p>
        <p>These Victorian and Edwardian buildings are precious and contribute hugely to the character of the city. In their existing condition, however, they present a serious hazard to people in the street. Falling masonry has been responsible for many earthquake-related deaths in New Zealand and overseas.</p>
        
        <div class="event_gallery">
        	<h2>IMAGE GALLERY (Click to expand)</h2>
        	<ul class="event-list">  
                <li>
                    <a href="images_insol/event_gallery.jpg">
                        <img src="images_insol/event_thumb.jpg" />
                    </a>
                </li>                 
                <li>
                    <a href="images_insol/event_gallery1.jpg">
                        <img src="images_insol/event_thumb1.jpg" />
                    </a>
                </li>
                <li>
                    <a href="images_insol/event_gallery.jpg">
                        <img src="images_insol/event_thumb.jpg" />
                    </a>
                </li>
                <li>
                    <a href="images_insol/event_gallery1.jpg">
                        <img src="images_insol/event_thumb1.jpg" />
                    </a>
                </li>
                <li>
                    <a href="images_insol/event_gallery.jpg">
                        <img src="images_insol/event_thumb.jpg" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".event-list").lightGallery({
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