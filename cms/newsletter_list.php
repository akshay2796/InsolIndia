<?php 
error_reporting(E_ALL);
include("header.php");	
define("PAGE_AJAX","ajax_newsletter.php");
define("PAGE_LIST","newsletter_list.php");

?> 

<script language="javascript" type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.history.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){     
     $.fn.listData = function() {
        var args = arguments[0] || {}; // It's your object of arguments        
        var pageNo = args.pageNo || 1;
		var search_val = args.search_val || '';
        //alert(search_val);
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=listData&" + search_val + "&page=" + pageNo,
            beforeSend: function(){  
                 $("#txtHint").html("<div class='ajaxLoader'><img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif' align='center' border='0'></div>");            		       
			},
            success: function(msg){
                //alert(msg);
			    setTimeout(function(){
                    $('#txtHint').html(msg);  					 
                    //$('#frm')[0].reset();
                },200);                
            }
        });
    };
   
    $("#frm").validate({
       submitHandler: function(form) {
            var search_val = $("#frm").serialize();
            search_val = search_val + "&SPageLoad=" + Math.random();
            $.history.load(search_val);
        }      
    });
     
    function loadUrl()
    {
        var num =  location.hash.replace("#", "");
        num = unescape(num);
        var queryString = {};
        num.replace(
            new RegExp("([^?=&]+)(=([^&]*))?", "g"),
            function($0, $1, $2, $3) { 
                queryString[$1] = $3; 
            }
        );
        
        var search_volume_name = queryString['search_volume_name'] || "";
        var search_newsletter_issue = queryString['search_newsletter_issue'] || "";
        var search_subject = queryString['search_subject'] || "";
        var search_from_date = queryString['search_from_date'] || "";
        var search_to_date = queryString['search_to_date'] || "";
       
        var search_val = "search_volume_name=" + search_volume_name;
        search_val = search_val + "&search_newsletter_issue=" + search_newsletter_issue;
        search_val = search_val + "&search_subject=" + search_subject;
        search_val = search_val + "&search_from_date=" + search_from_date;
        search_val = search_val + "&search_to_date=" + search_to_date;
        
        return search_val; 
        
    }
    
    function load(num) {  
        
        var queryString = {};
            num.replace(
                new RegExp("([^?=&]+)(=([^&]*))?", "g"),
                function($0, $1, $2, $3) { 
                queryString[$1] = $3; 
            
            }
        );
        if(num == "1x"){
            var search_val = $('#frm').serialize();  
            pageNo = 1;
            //alert("if")
        }
        else
        {
            var search_volume_name = queryString['search_volume_name'] || "";
            var search_newsletter_issue = queryString['search_newsletter_issue'] || "";
            
            var search_subject = queryString['search_subject'] || "";     
            var search_from_date = queryString['search_from_date'] || "";
            var search_to_date = queryString['search_to_date'] || "";
            var pageNo = queryString['pageNo'] || 1;
            
            var search_val = "search_volume_name=" + search_volume_name;
            search_val = search_val + "&search_newsletter_issue=" + search_newsletter_issue;
            search_val = search_val + "&search_subject=" + search_subject;
            search_val = search_val + "&search_from_date=" + search_from_date;
            search_val = search_val + "&search_to_date=" + search_to_date;
        } 
       
         
        $("#txtHint").listData({search_val: search_val,pageNo : pageNo});        
    }
    
    $.history.init(function(url) {
        load(url == "" ? "1x" : url);
    });
			
	$("#prev").live("click", function() {
        var aUrl = loadUrl();
        var hidden_date = $(this).attr("value"); 
        var search_val = aUrl;
        $.history.load(search_val); 
    });
   
    $("#next").live("click", function(){
        var aUrl = loadUrl();
        var hidden_date = $(this).attr("value"); 
        var search_val = aUrl;
        $.history.load(search_val);
    });
    
    //Paging Link
    $(".paging").live("click", function(){
        var value = $(this).attr("id");
        //alert(value);
        var aUrl = loadUrl();  
        search_val = aUrl;
        //alert(search_val);
        search_val = search_val + "&pageNo=" + value;
        $.history.load(search_val);
    });
    
    //Paging Selectbox
    
    $("#page").live("change", function(){
        var pg = $(this).val(); 
        //alert(pg);
        
        var aUrl = loadUrl();  
        search_val = aUrl;
        search_val = search_val + "&pageNo=" + pg;
        $.history.load(search_val);
    });
  
    
    
    
    $.fn.deleteData = function() {
        var args = arguments[0] || {};  // It's your object of arguments 
        var ID = args.ID; 
        //alert(ID);
        
        var c = confirm("Are you sure you wish to delete?");
        if(c)
        {                  
            $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX; ?>",
                   data: "type=deleteData&ID=" + ID,
            	   beforeSend: function(){
            	        $("#INPROCESS_DELETE_2_" + ID).hide();
                        $("#INPROCESS_DELETE_1_" + ID).show();
                        $("#INPROCESS_DELETE_1_" + ID).html("<img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif' border='0' />");
                                              
                   },
                  
                   success: function(msg){ 
                        
                        //alert(msg); 
                       
                        var spl_txt = msg.split("~~~");
                        if(spl_txt[1] == '1')
                        {
                            colorStyle = "successTxt";                   
                        } 
                        else
                        {
                            colorStyle = "errorTxt";
                        }
                        
                        
                        $("#INPROCESS_DELETE_1_" + ID).html("<div id='inprocess' class='del_msg'><div id='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");
                        
                        setTimeout(function(){
                            
                            if( parseInt(spl_txt[1]) == parseInt(1) )
                            {                                
                                
                                //alert(parseInt(spl_txt[2]));
                                
                                if( parseInt(spl_txt[3]) == parseInt(0) )
                                {
                                    $("#txtHint").listData();
                                }
                                else
                                {
                                    //$("#listItem_"+ID).hide();  
                                    $("#txtHint").listData();  
                                }
                                
                            }
                            else
                            {     
                                $("#INPROCESS_DELETE_2_"+ID).show();
                                $("#INPROCESS_DELETE_1_"+ID).hide();
                            }
                            
                        }, 2000);   
                        
                   }
                   
                   
            });
        }
                   
    };
    
    $("#reset").click(function(){ 
        $(this).loadSamePageViaAjax();
    });
    
    
     $.fn.loadSamePageViaAjax = function() {
       
        $("#search_volume_name").val("");
        $("#search_newsletter_issue").val("");
        $("#search_subject").val("");       
        $("#search_from_date").val("");       
        $("#search_to_date").val("");     
         
        var search_val = $("#frm").serialize();
        search_val = search_val + "&SPageLoad=" + Math.random();
                                
        $.history.load(search_val); 
    };
    
   
});

</script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.datepick.js"></script>
<script type="text/javascript">

$(function() {
  
    $('#search_from_date').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '2014:<?php echo date("Y"); ?>'
    });  
    
    $('#search_to_date').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '2014:<?php echo date("Y"); ?>'
    });
	
});





function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>
<style type="text/css">
@import "<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery.datepick.css";
</style>




<h1>Newsletter List</h1>
    
<div class="addWrapper">
    <div class="boxHeading">Search </div>
    <div class="clear"></div>
    <div class="containerPad">
        <form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
            <div class="fullWidth noGap">
                <div class="width5">
                	<label class="mainLabel">Volume</label>
                    <input name="search_volume_name" id="search_volume_name" type="text" class="txtBox" />
                </div> 
                
                <div class="width5">
                	<label class="mainLabel">Issue</label>
                    <input name="search_newsletter_issue" id="search_newsletter_issue" type="text" class="txtBox" />
                </div> 
                
                <div class="width5">
                	<label class="mainLabel">Subject</label>
                    <input name="search_subject" id="search_subject" type="text" class="txtBox orderPrefix" maxlength=""/>
                </div>
                <div class="width3">
                    <label class="mainLabel">Date <small>From - To </small></label>
                    <div class="txt2Box">
                        <input type="text" class="txtBox hw" id="search_from_date" name="search_from_date" value=""  placeholder="From" />
                        &nbsp;/&nbsp;<input type="text" class="txtBox hw" name="search_to_date" id="search_to_date" value=""  placeholder="To"/>
                    </div>
                </div>  
            </div><!--fullWidth end-->
            
            <div class="fullWidth searchBtnWrap noGap"> 
                <div class="submitWrapLoadFull" id="INPROCESS">                        
                    <input type="submit" value="Search" name="submit" id="submit" class="submitBtn" />
                    <input type="submit" value="Clear Search" name="reset" id="reset" class="cancelBtn" />           
                </div>
    		</div>
            
        
        </form>
                     
    </div><!--containerPad end-->
</div><!--addWrapper end-->

<div id="listWrapper" style="min-height:300px;"> 
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width:300px;">
        <tr>
            <td valign="top" align="left" id="txtHint" ></td>
        </tr>    
    </table>
</div> 
    

<?php
include("footer.php"); 

?>