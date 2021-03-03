function shareReview(){
$(".reviewShare .shareHere ").css({display: "none"}); // Opera Fix
$(".reviewShare").hover(function(){
		//$(this).find('.shareHere:first').css({visibility: "visible",display: "none"}).slideDown();
		$(this).find('.shareHere:first').css({visibility: "visible",display: "block"}).stop().animate({left:'55px'});
		},function(){
		$(this).find('.shareHere:first').css({visibility: "hidden",display: "none"}).stop().animate({left:'0px'});
		});
}


$(document).ready(function () {
	$(".reviewBtnList .commentHere ").css({display: "none"}); // Opera Fix
	$(".reviewComment").click(function(){ 
			if ($(this).find('.commentHere:first').is(":visible")) 
			{
				$(this).find('.commentHere:first').slideUp();
				//alert("yes");
			} else 
			{
				$('.commentHere').slideUp();
				$(this).find('.commentHere:first').slideDown();
				//alert("no");
			}
		});
		
		$('.reviewComment').click(function(e) {
			e.stopPropagation();
		});
		
		$('.commentHere').click(function(e) {
			e.stopPropagation();
		});

		$(document).click(function() {
			$('.commentHere').slideUp();
		});
		
		shareReview(); // for share review
					
});