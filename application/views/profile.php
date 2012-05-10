<script type="text/javascript">
	$(document).ready(function() {
		$('#Password').val('');
	});

// edit judges 
function validateEditCompetitor()
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	var EditCompetitorICode 	 = $('#EditCompetitorICode').val();
	var LoginCredentialICode = $('#LoginCredentialICode').val();
		
	if($('#FirstName').val()==""){
   		jAlert('Please enter first name.', 'Pole Dance', 'FirstName');
		return false;
    }
	else{
		if(checkSpecialChar('FirstName', 4) == false){
			jAlert('Please enter valid first name.', 'Pole Dance', 'FirstName');
			return false;
		}		
	}
	if($('#LastName').val()==""){
   		jAlert('Please enter last name.', 'Pole Dance', 'LastName');
		return false;
    }
	else{
		if(checkSpecialChar('LastName', 4) == false){
			jAlert('Please enter valid last name.', 'Pole Dance', 'LastName');
			return false;
		}		
	}
	/*if($('#AddressLine1').val()==""){
   		jAlert('Please enter address line 1.', 'Pole Dance', 'AddressLine1');
		return false;
    }*/
	if($('#EmailAddress').val()==""){
   		jAlert('Please enter email address.', 'Pole Dance', 'EmailAddress');
		return false;
    }
	else if(!filter.test($('#EmailAddress').val())){
		jAlert('Please enter valid email address.', 'Pole Dance', 'EmailAddress');
		return false;	
	}
	if($('#Country').val()==""){
   		jAlert('Please enter country name.', 'Pole Dance', 'Country');
		return false;
    }
	else{
		if(checkSpecialChar('Country', 4) == false){
			jAlert('Please enter valid country name.', 'Pole Dance', 'Country');
			return false;
		}		
	}
	if($('#PhoneNumber').val()==""){
   		jAlert('Please enter phone number.', 'Pole Dance', 'PhoneNumber');
		return false;
    }
	else
	{ 
		var phoneVal = $('#PhoneNumber').val();
		if(!phoneRegExp.test(phoneVal))
		{
			jAlert('Please enter valid phone number.', 'Pole Dance', 'PhoneNumber');
			return false;
		}
		var numbers = phoneVal.split("").length;	
		if ( numbers  < 8 || numbers > 15 ) {
          	jAlert('Phone Number should be 8 to 14 digits.', 'Pole Dance', 'PhoneNumber');
			return false;
        }
	}
	if($('#MobileNumber').val()!=""){
		if(!mobileRegExp.test($('#MobileNumber').val()))
	  	{
			jAlert('Mobile Number should be 10 digits. Ex: 123 456 7890.', 'Pole Dance', 'MobileNumber');
			return false;	
	  	}
	}
	
	
	
	if($('#Password').val()!= ""){
	
		if($("#Password").val().length < 5)
		{
			jAlert('Password must have at least 5 characters.', 'Pole Dance', 'Password');
			return false;	
		}
	
		if($('#ConfirmPassword').val()==""){
			jAlert('Please enter confirm password.', 'Pole Dance', 'ConfirmPassword');
			return false;
		}
		if($('#Password').val() != $('#ConfirmPassword').val() ){
			jAlert('Confirm Password is mismatch.', 'Pole Dance', 'ConfirmPassword');
			return false;
		}
	}

	
	if($('#ProfileImage').val() != ""){
		var ext = $('#ProfileImage').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			jAlert('Invalid file type. Upload only .gif, .png, .jpg and .jpeg.', 'Pole Dance', 'ProfileImage');
			return false;
		}
	}
	
	var EmailAddress = $('#EmailAddress').val();
	
	var checkEmailIdExist = base_url+'admin/user/checkEmailIdExist/'+LoginCredentialICode+'/';
	
	$.ajax({  
			type: "POST",
			url: checkEmailIdExist,  
			data: {"EmailAddress": EmailAddress },  
			success: function(msg)
			{  
				//alert(msg); return false;
				if(msg == 'Exist')
				{
					jAlert('This Email Address is already exist.', 'Pole Dance', 'EmailAddress');
					return false;
				}
				else
				{
					$("#updateeditcompetitorform").submit();
				}
			 }
		});
}
</script>

<!-- Load TinyMCE -->
<script type="text/javascript" src="<?php echo base_url();?>js/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('#Bio').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo base_url();?>js/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	});
</script>
<!-- /TinyMCE -->
<?php if($this->session->flashdata('upload_error') != '') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('<?php echo $this->session->flashdata('upload_error');?>', 'e-pole judge', '');
});
	
</script>
<?php }?>
<?php if($this->session->flashdata('remove_video') == 'true') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('Your video has been removed', 'e-pole judge', '');
});
	
</script>
<?php }?>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Edit Profile Details </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="updateeditcompetitorform" id="updateeditcompetitorform" method="post" action="<?php echo base_url();?>competitor/edit_profile/update/<?php echo $CompetitorDetails['CompetitorICode'];?>" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
       
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
      </tr>
      <tr>
        
        <td width="11%" align="left"><span class="box_title">First Name <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="34%" height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['FirstName'];?>" class="tb3" style="width:280px;" tabindex="1" name="FirstName" id="FirstName" maxlength="50"  onkeyup="trimFirstSpace('FirstName');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td width="12%" height="45" align="left"><span class="box_title">Last Name <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="32%" height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['LastName'];?>" class="tb3" style="width:280px;" tabindex="2" name="LastName" id="LastName" maxlength="50" onkeyup="trimFirstSpace('LastName');" onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
      </tr>
      
      <tr>
       
        <td height="45" align="left"><span class="box_title">Nick Name</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['NickName'];?>" class="tb3" style="width:280px;" tabindex="3" name="NickName" id="NickName" maxlength="50" onkeyup="trimFirstSpace('NickName');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Address Line 1</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['AddressLine1'];?>" class="tb3" style="width:280px;" tabindex="4" name="AddressLine1" id="AddressLine1" maxlength="255" onkeyup="trimFirstSpace('AddressLine1');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        </tr>
      <tr>
       
        <td height="45" align="left"><span class="box_title">Address Line 2</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['AddressLine2'];?>" class="tb3" style="width:280px;" tabindex="5" name="AddressLine2" id="AddressLine2" maxlength="255" onkeyup="trimFirstSpace('AddressLine2');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Email Address <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['EmailAddress'];?>" class="tb3" style="width:280px; text-transform:lowercase;" tabindex="6" name="EmailAddress" id="EmailAddress" maxlength="80" onkeyup="trimFirstSpace('EmailAddress');" onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        </tr>
      <tr>
       
        <td height="45" align="left"><span class="box_title">Country <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['Country'];?>" class="tb3" style="width:280px;" tabindex="7" name="Country" id="Country" maxlength="50" onkeyup="trimFirstSpace('Country');" onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Phone Number <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['PhoneNumber'];?>" class="tb3" style="width:280px;" tabindex="8" name="PhoneNumber" id="PhoneNumber" maxlength="15" onkeyup="trimFirstSpace('PhoneNumber');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        </tr>
		<tr>
       
        <td height="45" align="left"><span class="box_title">Password <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="password" value="" class="tb3" style="width:275px; height:19px; line-height:18px;" tabindex="10" name="Password" id="Password" maxlength="30"  onkeyup="trimFirstSpace('Password');"  onkeypress="enterPage('addnewcompetitorbutton', event);"/></td>
		 <td height="45" align="left"><span class="box_title">Confirm Password <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="password" value="" class="tb3" style="width:275px; height:19px; line-height:18px;" tabindex="11" name="ConfirmPassword" id="ConfirmPassword" maxlength="30" onkeyup="trimFirstSpace('ConfirmPassword');"  onkeypress="enterPage('addnewcompetitorbutton', event);"/></td>
		
        </tr>
      <tr>
       
        <td height="45" align="left"><span class="box_title">Mobile Number</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['MobileNumber'];?>" class="tb3" style="width:280px;" tabindex="9" name="MobileNumber" id="MobileNumber" maxlength="15" onkeyup="trimFirstSpace('MobileNumber');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
		
        </tr>
      
      <tr>
       
        <td height="134" align="left"><span class="box_title">Profile Image</span></td>
        <td height="134" align="center"><span class="box_title">:</span></td>
        <td height="134" align="left"><?php if($CompetitorDetails['ProfileImage'] !=''  && file_exists("./uploads/CompetitiorImages/".$CompetitorDetails['ProfileImage'])) { ?>
            <img src="<?php echo base_url(); ?>uploads/CompetitiorImages/<?php echo $CompetitorDetails['ProfileImage'];?>" width="100px" height="100px" border="0"/>
            <?php } else { ?>
            <img src="<?php echo base_url(); ?>images/NoPhoto.jpg" width="100px" height="100px" border="0"/>
            <?php } ?></td>
			 <td width="11%" align="left"><span class="box_title">Embed Video </span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="34%" height="45" align="left">
			<input type="text" value="<?php echo $CompetitorDetails['embed_code'];?>" class="tb3" style="width:280px;" tabindex="9" name="embed_code" id="embed_code" maxlength="15"/>
		</td>
      </tr>
	   <?php if($CompetitorDetails['video'] !=''  && file_exists("./uploads/videos/".$CompetitorDetails['video'])) { ?>
	  <tr>
        <td height="45" align="left"><span class="box_title"></span></td>
        <td height="45" align="center"><span class="box_title"></span></td>
        <td height="45" align="left"></td>

        <td width="12%" height="45" align="left"><span class="box_title">Uploaded Video</span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="32%" height="45" align="left"><a href="<?php echo base_url().'competitor/video/'.$CompetitorDetails['CompetitorICode'];?>" rel="view_video" class="poplight">Click to see</a> | <a href="<?php echo base_url().'competitor/remove_video/'.$CompetitorDetails['CompetitorICode'];?>">Remove</a></td>
      </tr>
	<?php } ?>
	  <tr>
        
               <td height="116" align="left"><span class="box_title"></span></td>
        <td height="116" align="center"><span class="box_title"></span></td>
        <td height="116" align="left"><input type="file" name="ProfileImage" id="ProfileImage" class="tb1" size="20" tabindex="11" /></td>

        <td width="12%" height="45" align="left"><span class="box_title">Upload Video</span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="32%" height="45" align="left"><input type="file" name="video" id="video" class="tb1" size="20" tabindex="11" /></td>
      </tr>
	
      <tr>
       
        <td height="24" align="left">Biography</td>
        <td height="24" align="center">:</td>
        <td height="24" align="left" valign="top" colspan="4">
			<textarea name="Bio" id="Bio" class="tb3" cols="10" rows="5" style="resize:none; width:350px; height:100px;" tabindex="12"><?php echo 				stripslashes($CompetitorDetails['Bio']);?></textarea>
		</td>
      
      </tr>
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="45" colspan="7"><table width="100%" height="42" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="19%" align="left"><span class="asterickmandatory"><span class="asterick">*</span> - indicates a required field.</span></td>
            <td width="8%" align="left"><span class="btn_bx"><input type="button" name="updatecompetitorbutton" id="updatecompetitorbutton" value="Update" onClick="return validateEditCompetitor();" tabindex="13"></span> 
			
			 <input type="hidden" name="EditCompetitorICode" id="EditCompetitorICode" value="<?php echo $this->uri->segment(4);?>" />
			<input type="hidden" name="LoginCredentialICode" id="LoginCredentialICode" value="<?php echo $CompetitorDetails['LoginCredentialICode'];?>" /></td>
            <td width="69%" align="left"></td>
            <td width="4%" align="left">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
    </table>
	</form>
</div>
    </div>
  </div>
</div></td>
      </tr>
    </table>
<div id="view_video" class="popup_block" style="display:none;">
	<iframe src="<?php echo base_url().'competitor/video/'.$CompetitorDetails['CompetitorICode'];?>" frameBorder="0" width="100%" height="200px;" style="border:none;"></iframe>
</div>