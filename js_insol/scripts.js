 $(document).ready(function() {
	
	 $('.single-item-rtl').slick({
			autoplay: true,
			infinite: true,
			draggable: true,
			arrows: true,
			touchMove: true,
			autoplaySpeed:5000,
			fade: true,
			slide: 'div',
			cssEase: 'linear'
		});
		
		
		$('.about-slider').slick({
			autoplay: true,
			infinite: true,
			draggable: true,
			arrows: true,
			touchMove: true,
			autoplaySpeed:5000,
			slide: 'div',
			cssEase: 'linear',
			responsive: [
				{
				  breakpoint: 992,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					arrows: false,
				  }
				},
				{
				  breakpoint: 601,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					arrows: false,
				  }
				},
				{
				  breakpoint: 376,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					arrows: false,
				  }
				}
			]
		});
		$(".single-item-rtl").css('display','block');
	 
	 
		
		$('.project_slider').slick({
			autoplay: true,
			infinite: true,
			draggable: true,
			arrows: true,
			touchMove: true,
			autoplaySpeed:5000,
			slide: 'div',
			slidesToShow: 2,
			slidesToScroll: 1,
			cssEase: 'linear',
			responsive: [
				{
				  breakpoint: 992,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					arrows: false,
				  }
				},
				{
				  breakpoint: 601,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					arrows: false,
				  }
				},
				{
				  breakpoint: 376,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					arrows: false,
				  }
				}
			]
		});
		
		$('.series_carosel').slick({
			autoplay: true,
			infinite: true,
			draggable: true,
			arrows: true,
			touchMove: true,
			autoplaySpeed:5000,
			slide: 'div',
			slidesToShow: 2,
			slidesToScroll: 1,
			cssEase: 'linear',
			responsive: [
				{
				  breakpoint: 992,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					arrows: true,
				  }
				},
				{
				  breakpoint: 601,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					arrows: true,
				  }
				},
				{
				  breakpoint: 376,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					arrows: true,
				  }
				}
			]
		});
	 
	 
	 

});