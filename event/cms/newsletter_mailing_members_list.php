<?php 
error_reporting(0);
include("header.php");

define("PAGE_MAIN","newsletter_mailing_members.php");	
define("PAGE_AJAX","ajax_newsletter_mailing_members.php");
define("PAGE_LIST","newsletter_mailing_members_list.php");
?> 

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css"> 

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
                //alert(msg)
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
        
                
        var search_test_mail_name = queryString['search_test_mail_name'] || "";
        var search_fdate = queryString['search_fdate'] || "";    
        var search_tdate = queryString['search_tdate'] || "";
                   
        
        var search_val = "search_test_mail_name=" + search_test_mail_name;
        search_val = search_val + "&search_fdate=" + search_fdate;
        search_val = search_val + "&search_tdate=" + search_tdate;
        
        return search_val; 
        
    }
    
    
    function load(num) {  
        num = decodeURIComponent(num);
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
        
            var search_test_mail_name = queryString['search_test_mail_name'] || "";
            var search_fdate = queryString['search_fdate'] || "";    
            var search_tdate = queryString['search_tdate'] || "";
            
            var pageNo = queryString['pageNo'] || 1;           
            
            var search_val = "search_test_mail_name=" + search_test_mail_name;
            search_val = search_val + "&search_fdate=" + search_fdate;
            search_val = search_val + "&search_tdate=" + search_tdate;
            
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
    
    
    
    
    $.fn.deleteSelected = function() {
        var args = arguments[0] || {};  // It's your object of arguments 
        var nock = $(".cb-element:checked").size();
        if(nock == 0)
        {
            alert("Please check atleast one");
        }
        else
        {
            var a = confirm("Are you sure you wish to delete?");
            if(a)
            {
                var formvalue = $("#frmDel").serialize();
                
                //alert(formvalue)
                
                $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX; ?>",
                   data: "type=deleteSelected&" + formvalue,
                   beforeSend: function(){  
                        $("#INPROCESS_DEL").html("<div id='inprocess'><input type='button' value='Delete Selected' id='delete_all' class='process' /></div>");
                   },
                   success: function(msg){
                        
                        //alert(msg);                     
                        //return false;
                        
                        setTimeout(function(){
                                              
                            var colorStyle = "";
                            colorStyle = "successTxt";
        
                            $("#INPROCESS_DEL").html("<div id='inprocess'><input type='button' value='" + msg + "' id='delete_all' class='" + colorStyle + "' /></div>");
                            
                            setTimeout(function(){
                                $("#inprocess").fadeOut();
                                $("#INPROCESS_DEL").html(" <input type='button'  class='process' value='Delete Selected' disabled='' id='delete_all' />");
                            },1000);  
                            
                            setTimeout(function(){
                                $('#txtHint').listData(); 
                            },1000); 
                                                 
                        },1000);
                        
                         
                   }
                });
            }
        }
    };
    
    
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
            	        $("#INPROCESS_DELETE_1_"+ID).html("<img src='<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>loader-small.gif' border='0' />");
                        $("#INPROCESS_DELETE_1_"+ID).show();                        
                        $("#INPROCESS_DELETE_2_"+ID).hide();                        
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
    
    $.fn.setStatus = function() {
        
        var args = arguments[0] || {};  // It's your object of arguments 
        var ID = args.ID;
        var VAL = args.VAL; 
        //alert(ID);
        
                         
        $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=setStatus&ID=" + ID + "&VAL="+VAL,
        	   beforeSend: function(){
                    $("#INPROCESS_STATUS_2_" + ID).hide();
                    $("#INPROCESS_STATUS_1_" + ID).show();
                    $("#INPROCESS_STATUS_1_" + ID).html("<img src='<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>loader-small.gif' border='0' />");
      
               },
              
               success: function(msg){ 
                    
                    //alert(msg)
                    var spl_txt = msg.split("~~~");
                    if( parseInt(spl_txt[1]) == parseInt(1) )
                    {
                        colorStyle = "successTxt1";                   
                    } 
                    else
                    {
                        colorStyle = "errorTxt1";
                    }
                    
                    
                    $("#INPROCESS_STATUS_1_" + ID).html("<div id='inprocess' class='del_msg'><div id='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");
                    
                    setTimeout(function(){
                        
                         $("#INPROCESS_STATUS_1_" + ID).hide();
                         $("#INPROCESS_STATUS_2_" + ID).html("");
                         
                         var TL = "";
                         var IM = "";
                         
                         if ( $.trim(VAL) == "INACTIVE" )
                         {
                            VL = "ACTIVE";
                            TL = "Click to Active";
                            IM = '<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>inactive.png" alt="' + TL + '" title="' + TL + '" >';
                         }
                         else
                         {
                            VL = "INACTIVE";
                            TL = "Click to Inactive";
                            IM = '<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" alt="' + TL + '" title="' + TL + '" >';
                            
                         }
                               
                         var dw = "";
                         dw = dw + '<a href="javascript:void(0);" value="' + ID + '" myvalue="' + VL + '" class="setStatus">';
                         dw = dw + IM;
                         dw = dw + '</a>';
                         
                         //alert(dw);
                         $("#INPROCESS_STATUS_2_" + ID).html(dw);
                         $("#INPROCESS_STATUS_2_" + ID).show(); 
                        
                    }, 2000);     
                    
               }
               
               
        }); 
    
    };
    
    
    
    
    $("#reset").click(function(){ 
        $(this).loadSamePageViaAjax();
    });
    
    
     $.fn.loadSamePageViaAjax = function() {       
        
        $("#search_test_mail_name").val("");
        $("#search_fdate").val("");
        $("#search_tdate").val("");
         
        var search_val = $("#frm").serialize();
        search_val = search_val + "&SPageLoad=" + Math.random();
        $.history.load(search_val); 
    };

});

</script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.datepick.js"></script>
<script type="text/javascript">

$(function() {
  
    $('#search_fdate').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '2014:<?php echo date("Y", strtotime('+1 year')); ?>'
    });  
    
    $('#search_tdate').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '2014:<?php echo date("Y", strtotime('+1 year')); ?>'
    });
	
});


function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>
<style type="text/css">
@import "<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery.datepick.css";
</style>




<h1>Mailing List <div class="addProductBox"><a href="<?php echo PAGE_MAIN;?>" class="backBtn">Add New</a></div></h1>
<div class="addWrapper">
	<div class="boxHeading">Search</div>
    <div class="clear"></div>
    <div class="containerPad">
        <form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
            <div class="fullWidth noGap">
                <div class="width4">
                	<label class="mainLabel">Name</label>                             
                    <input type="text" class="txtBox" name="search_test_mail_name" id="search_test_mail_name" value="" maxlength="100"/>
                </div>
                 
                 <!--div class="width4">
                    <label class="mainLabel">Date <small>From - To </small></label>
                    <div class="txt2Box">
                        <input type="text" class="txtBox hw" id="search_fdate" name="search_fdate" value=""  placeholder="From" />
                        &nbsp;/&nbsp;<input type="text hw" class="txtBox" name="search_tdate" id="search_tdate" value=""  placeholder="To"/>
                    </div>
                </div-->
                <div class="width2" id="INPROCESS"> 
                    <label class="mainLabel">&nbsp;</label>                     
                    <input type="submit" value="Search" name="submit" id="submit" class="submitBtn" />
                    <input type="submit" value="Clear Search" name="reset" id="reset" class="cancelBtn" />           
                </div>
                
             </div>
              
        </form>
                     
    </div><!--containerPad end-->
</div><!--addWrapper end-->
 
<div id="listWrapper"> 
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="min-width:300px;">
        <tr>
            <td valign="top" align="left" id="txtHint" ></td>
        </tr>    
    </table>
</div> 
    
            
     

<?php
include("footer.php"); 

?>