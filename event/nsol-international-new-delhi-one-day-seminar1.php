<?php include('header.php'); ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Events</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page events_list">
        <h2>NSOL International New Delhi One Day Seminar</h2>
        <h4>
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span>Saturday 23 April 2016</span> | <i class="fa fa-map-marker" aria-hidden="true"></i>
            <span>India Habitat Centre, Lodhi Road New Delhi, India 110003</span>
        </h4>
        
        <h5>Seminar Co-Chair's Welcome</h5>
        <p>On behalf of INSOL International, INSOL India, and The Society of Insolvency Practitioners of India (SIPI), we are very pleased to welcome you to New Delhi for this One Day International Seminar.</p>
    	<p>INSOL International is a worldwide federation of national association of accountants and lawyers who specialize in turnaround and insolvency. There are currently over forty member associations with over 9,900 professionals participating as members of INSOL International. While INSOL India is INSOL International's direct associate wing, SIPI is working from a different platform, covering, inter alia, similar objectives.</p>
        <p>On behalf of INSOL International, INSOL India, and The Society of Insolvency Practitioners of India (SIPI), we are very pleased to welcome you to New Delhi for this One Day International Seminar.</p>
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