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


var tellMeTheSizes=function()
{
	  var listImgH = $('.ImgBoxOuter').height();
	  var listImgW = $('.ImgBoxOuter').width(); 
	  $('.ImgBoxInner').width(listImgW);
	  $('.ImgBoxInner').height(listImgH);
	  $('.ImgBoxInner .imgSize').css({'max-width': listImgW , 'max-height': listImgH});
	  
	 
}

window.onload=function()
{
	   tellMeTheSizes();
	   $('.ImgBoxOuter').fadeIn();
}
window.onresize=function()
{
	   tellMeTheSizes();
}
