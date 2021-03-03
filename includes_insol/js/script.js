// JavaScript Document
function getViewportWidth()
{
       if (window.innerWidth)
       {
               return window.innerWidth;
       }
       else if (document.body && document.body.offsetWidth)
       {
               return document.body.offsetWidth;
       }
       else
       {
               return 0;
       }
}

function getViewportHeight()
{
       if (window.innerHeight)
       {
               return window.innerHeight;
       }
       else if (document.body && document.body.offsetHeight)
       {
               return document.body.offsetHeight;
       }
       else
       {
               return 0;
       }
}
//var $ = jQuery.noConflict();

// script for menu slide
$(document).ready(function(){
	$('.menuBtn').click(function(){		
		if($('.menuWrapper').hasClass("slideMe"))
		{
			$('.menuWrapper').removeClass("slideMe");
			$('.mainWrapper').removeClass("slideMe");
			$('.smallScreenClickDisable').removeClass("slideMe");			
		}
		else
		{		
			$('.menuWrapper').addClass("slideMe");
			$('.mainWrapper').addClass("slideMe");
			$('.smallScreenClickDisable').addClass("slideMe");			
		}		
	});
	
	$('.navHover').hover(function(){		
		if($('.menuWrapper').hasClass("slideMe"))
		{
			$('.menuWrapper').removeClass("slideMe");		
			$('.mainWrapper').removeClass("slideMe");
			tellMeImgSizes();
		}		
	});
	
	
	$('.productBox').click(function(){
			if ($('.topSubLinkContainer').is(":visible")) 
			{
				$('.topSubLinkContainer').slideUp();
			} else 
			{				
				$('.topSubLinkContainer').stop().slideDown();
			}							
		});
		
		$('.productBox').click(function(e) {
			e.stopPropagation();
		});
		
		$('.topSubLinkContainer').click(function(e) {
			e.stopPropagation();
		});
		
		$(document).click(function() {
			$('.topSubLinkContainer').slideUp();
		});
	
	
	$("#mainMenu").navgoco({		
		// Add Active class to clicked menu item
		onClickAfter: function(e, submenu) {
			//e.preventDefault();
			$('#mainMenu').find('li').removeClass('active');
			var li =  $(this).parent();
			var lis = li.parents('li');
			li.addClass('active');
			lis.addClass('active');
		},
	});
});



// script for list page add bod slide
$(document).ready(function(){	
	$(".expendBtn").live("click" , function(){
		$(".expendableBox").slideDown();
		$(this).addClass("collapseBtn");
		$(this).removeClass("expendBtn");
		$(this).find('.showHideBtn').html("(-)");
		
	});
	
	$(".collapseBtn").live("click" , function(){
		$(".expendableBox").slideUp();
		$(this).removeClass("collapseBtn");
		$(this).addClass("expendBtn");
		$(this).find('.showHideBtn').html("(+)");
	});
	
	$(".searchBtn").live("click", function(){
		$('html, body').animate({ scrollTop: 0}, "slow");								 
	});
	
});

var tellMeTheSizes=function()
{
	if(parseInt(getViewportWidth()) < parseInt(800))
	  {
		  	$('.navHover').addClass("smallClick");			
			
	  }
	  else
	  {
		    $('.navHover').removeClass("smallClick");	
	  }
	  
}



window.onload=function()
{
       tellMeTheSizes();	   
}

window.onresize=function()
{
       tellMeTheSizes();	   
}