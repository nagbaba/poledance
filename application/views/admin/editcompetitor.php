<?php if($this->session->flashdata('upload_error') != '') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('<?php echo $this->session->flashdata('upload_error');?>', 'e-pole judge', '');
});
	
</script>
<?php }?>
<script type="text/javascript">
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
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Edit Competitor Details </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="updateeditcompetitorform" id="updateeditcompetitorform" method="post" action="<?php echo base_url();?>admin/user/editcompetitor/update/<?php echo $this->uri->segment(4);?>/" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="19">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="5%" height="45">&nbsp;</td>
        <td width="11%" align="left"><span class="box_title">First Name <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="34%" height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['FirstName'];?>" class="tb3" style="width:280px;" tabindex="1" name="FirstName" id="FirstName" maxlength="50"  onkeyup="trimFirstSpace('FirstName');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td width="12%" height="45" align="left"><span class="box_title">Last Name <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="32%" height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['LastName'];?>" class="tb3" style="width:280px;" tabindex="2" name="LastName" id="LastName" maxlength="50" onkeyup="trimFirstSpace('LastName');" onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
      </tr>
      
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Nick Name</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['NickName'];?>" class="tb3" style="width:280px;" tabindex="3" name="NickName" id="NickName" maxlength="50" onkeyup="trimFirstSpace('NickName');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Address Line 1</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['AddressLine1'];?>" class="tb3" style="width:280px;" tabindex="4" name="AddressLine1" id="AddressLine1" maxlength="255" onkeyup="trimFirstSpace('AddressLine1');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Address Line 2</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['AddressLine2'];?>" class="tb3" style="width:280px;" tabindex="5" name="AddressLine2" id="AddressLine2" maxlength="255" onkeyup="trimFirstSpace('AddressLine2');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Email Address <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['EmailAddress'];?>" class="tb3" style="width:280px; text-transform:lowercase;" tabindex="6" name="EmailAddress" id="EmailAddress" maxlength="80" onkeyup="trimFirstSpace('EmailAddress');" onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Country <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['Country'];?>" class="tb3" style="width:280px;" tabindex="7" name="Country" id="Country" maxlength="50" onkeyup="trimFirstSpace('Country');" onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Phone Number <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['PhoneNumber'];?>" class="tb3" style="width:280px;" tabindex="8" name="PhoneNumber" id="PhoneNumber" maxlength="15" onkeyup="trimFirstSpace('PhoneNumber');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        </tr>
      <tr>
        <td height="41">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Mobile Number</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $CompetitorDetails['MobileNumber'];?>" class="tb3" style="width:280px;" tabindex="9" name="MobileNumber" id="MobileNumber" maxlength="15" onkeyup="trimFirstSpace('MobileNumber');"  onkeypress="enterPage('updatecompetitorbutton', event);"/></td>
        
        </tr>
      
      <tr>
        <td height="134">&nbsp;</td>
        <td height="134" align="left"><span class="box_title">Profile Image</span></td>
        <td height="134" align="center"><span class="box_title">:</span></td>
        <td height="134" align="left"><?php if($CompetitorDetails['ProfileImage'] !='') { ?>
            <img src="<?php echo base_url(); ?>uploads/CompetitiorImages/<?php echo $CompetitorDetails['ProfileImage'];?>" width="100px" height="100px" border="0"/>
            <?php } else { ?>
            <img src="<?php echo base_url(); ?>images/NoPhoto.jpg" width="100px" height="100px" border="0"/>
            <?php } ?></td>
        <td height="116" align="left"><span class="box_title">Biography</span></td>
        <td height="116" align="center"><span class="box_title">:</span></td>
        <td height="116" align="left"><textarea name="Bio" id="Bio" class="tb3" cols="40" rows="5" style="resize:none; width:350px; height:100px;" tabindex="11"><?php echo stripslashes($CompetitorDetails['Bio']);?></textarea></td>
      </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td height="24" align="left">&nbsp;</td>
        <td height="24" align="center">&nbsp;</td>
        <td height="24" align="left" valign="top"><input type="file" name="ProfileImage" id="ProfileImage" class="tb1" size="20" tabindex="12" /></td>
        <td height="24" align="left">&nbsp;</td>
        <td height="24" align="center">&nbsp;</td>
        <td height="24" align="left">&nbsp;</td>
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
            <td width="69%" align="left"><span class="btn_bx"><input type="button" name="clear" id="clear" value="Cancel" tabindex="14" onclick="location.href='<?php echo base_url();?>admin/user/managecompetitor/'"/></span></td>
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