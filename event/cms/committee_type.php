<?php 
error_reporting(E_ALL);
include("header.php");


define("PAGE_MAIN","committee_type.php");	
define("PAGE_AJAX","ajax_committee_type.php");

?>


<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css">


<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    
    $("#frm").validate({
        errorElement: "span",
        rules: {
            type_name: "required"
        },
        messages: {
            type_name: ""
        },
        submitHandler: function() {
            var value = $("#frm").serialize();
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveData&" + value,
			   beforeSend: function() { 
                    $("#INPROCESS").html("");                    
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               },
               success: function(msg){                   
                   //alert(msg);
                   var cond = $("#con").val();
                   
                   setTimeout(function(){
                        $("#INPROCESS").html("");                        
                        var spl_txt = msg.split("~~~"); 
                        
                        var colorStyle = "";
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            
                            $("#id").val("");
                            $("#con").val("add");
                            $("#MOD").html("Add");
                            $("#type_name").val("");                              
                            colorStyle = "success"; 
                        } 
                        else
                        {
                            colorStyle = "error";
                        }
                        
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                        //$("#INPROCESS").html("<div id='" + colorStyle + "' >" + spl_txt[2] + "</div>"); 
                        
                        setTimeout(function(){
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' />&nbsp;<input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>");
                            $(".expendableBox").slideUp();
							$('.showHideBtn').html("(+)");
							$(".addWrapper .boxHeading").addClass("expendBtn");
                            $(".addWrapper .boxHeading").removeClass("collapseBtn");
                            if( parseInt(spl_txt[1]) == parseInt(1) ) 
                            {
                                setTimeout(function(){
                                    $('#txtHint').listData();
                                },700);
                                
                                if ( cond == "modify" )
                                {
                                    $(".expendableBox").slideUp();
									$('.showHideBtn').html("(+)");
                                    $(".addWrapper .boxHeading").addClass("expendBtn");
                                    $(".addWrapper .boxHeading").removeClass("collapseBtn");
                                } 
                             
                                
                            } 
                        
                        },1000);
                                               
                    },1000); 
               }
            });
        }
    });
    
    
    $("#cancel").live("click", function(){    
        //location.href='<?php echo PAGE_MAIN; ?>';  
        window.location.reload('<?php echo PAGE_MAIN; ?>')
     });
    
    
    
    
    $.fn.listData = function() {
        var args = arguments[0] || {}; // It's your object of arguments        
        var pageNo = args.pageNo || 1; 
        var search_location = encodeURIComponent(args.search_location || "");
        ///alert(search_val);
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=listData&page=" + pageNo + "&search_location=" + search_location,
            beforeSend: function(){  
                //$("#txtHint").animate({ scrollTop: 200 }, "slow");
                $('#txtHint').html("<img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif' border='0' class='txtHintLoader'>");
            },
            success: function(msg){
                $('#txtHint').html(msg);
            }
        });
    }; 
     
    $('#txtHint').listData();
    
     
    
    //Paging Link
    $(".paging").live("click", function(){
        var value = $(this).attr("id");
        var search_location = $("#search_location").val();
        $('#txtHint').listData({pageNo: value, search_location: search_location}); 
    });
    
    //Paging Selectbox
    
    $("#page").live("change", function(){
        var pg = $(this).val(); 
        var search_location = $("#search_location").val();
         
        $('#txtHint').listData({pageNo: pg, search_location: search_location});
    });
   
    
    
    $.fn.modifyData = function() {
        var args = arguments[0] || {};
        var type_id = args.type_id || "";
        
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=modifyData&type_id=" + type_id,
            beforeSend: function(){  
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#INPROCESS_DELETE_2_" + type_id).hide();
                $("#INPROCESS_DELETE_1_" + type_id).html("<img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif' border='0'>").show();        
            },
            success: function(msg){
                
                //alert(msg)
                   
                $("#INPROCESS_DELETE_1_" + type_id).html("").hide();
                $("#INPROCESS_DELETE_2_" + type_id).show();
                
                var spl_txt = msg.split("~~~");
                $("#MOD").html("Modify");
                $("#con").val("modify");
                $("#id").val(spl_txt[1]);
                                
                $("#type_name").val(spl_txt[2]);       
                //$("#description").val(spl_txt[3]);   
                //alert(spl_txt[3]);
               
            }
        }); 
    }; 
    
    //Paging Link
    $(".paging").live("click", function(){
        var value = $(this).attr("id");
        var search_location = $("#search_location").val();
        $('#txtHint').listData({pageNo: value, search_location: search_location}); 
    });
    
    //Paging Selectbox
    
    $("#page").live("change", function(){
        var pg = $(this).val(); 
        var search_location = $("#search_location").val();
         
        $('#txtHint').listData({pageNo: pg, search_location: search_location});
    });
   
   
    
    
    $.fn.deleteSelected = function() {
        var args = arguments[0] || {};  // It's your object of arguments 
        var nock = $(".cb-element:checked").size();
        
        if(nock == 0)
        {
            alert("Please check atleast one status");
        }
        else
        {
            var a = confirm("Are you sure you wish to delete?");
            if(a)
            {
                var formvalue = $("#frmDel").serialize();
                
                
                $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX; ?>",
                   data: "type=deleteSelected&" + formvalue,
                   beforeSend: function(){  
                        $(".INPROCESS_DEL").html("<label class='selectAllBtn'><input type='checkbox'  disabled='disabled'/></label><div id='inprocess'><input type='button' value='Delete Selected' id='delete_all' class='process' /></div>");
                   },
				   //return false;
                   success: function(msg){
                        
                        //alert(msg);               
                        setTimeout(function(){
                                              
                            var colorStyle = "";
                            colorStyle = "success";
                            
                            $(".INPROCESS_DEL").html("<label class='selectAllBtn'><input type='checkbox'  disabled='disabled'/></label><div id='inprocess'><input type='button' value='" + msg + "' id='delete_all' class='" + colorStyle + "' />");
                        
                            setTimeout(function(){
                                $("#inprocess").fadeOut();
                                $(".INPROCESS_DEL").html("<input type='button' class='deleteSelectedBtn greyBtn' value='Delete Selected'  id='delete_all' disabled='' />");
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
        var ID = args.type_id;
        
        //alert(ID);
        var c = confirm("Are you sure you wish to delete?");
        if(c)
        {                  
            $.ajax({
                type: "POST",
                url: "<?php echo PAGE_AJAX; ?>",
                data: "type=deleteData&did=" + ID,
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
                        colorStyle = "successTxt1";                   
                    } 
                    else
                    {
                        colorStyle = "errorTxt1";
                    }
                    
                    
                    $("#INPROCESS_DELETE_1_" + ID).html("<div id='inprocess' class='del_msg'><div id='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");
                    
                    setTimeout(function(){
                        
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {                                
                            $("#txtHint").listData();
                            //$("#listItem_"+ID).hide();
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
                    $("#INPROCESS_STATUS_1_" + ID).html("<img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif' border='0' />");
      
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
 
});
</script>


        
<h1>Committee Member Type</h1>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="" />
<input type="hidden" name="con" id="con" value="add" />

<div class="addWrapper master">
    <div class="boxHeading expendBtn"> <span id="MOD">Add</span> <a href="javascript:void(0)" class="showHideBtn">(+)</a></div>
    <div class="clear"></div>
    <div class="containerPad expendableBox">
        <div class="fullWidth noGap">                    	
            <div class="width3">
                <label class="mainLabel">Name <span>*</span></label>
                <input type="text" class="txtBox" value="" name="type_name" id="type_name" maxlength="150" AUTOCOMPLETE = "OFF" />
            </div>         
        </div><!--fullWidth end-->    
                
            
        <div class="fullWidth noGap">           
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' />
                <input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>
            </div>               
        </div><!--fullWidth end--> 
    </div><!--containerPad end-->
</div><!--addWrapper end-->
</form>


<div class="listWrapper" id="txtHint">
	
</div><!--addWrapper end-->     

        

        
<?php include("footer.php");?>   
