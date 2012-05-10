<script type="text/javascript">
	function validateAddNewjudges()
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	
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
	if($('#Password').val()==""){
   		jAlert('Please enter password.', 'Pole Dance', 'Password');
		return false;
    }
	else{
		if($("#Password").val().length < 5)
		{
			jAlert('Password must have at least 5 characters.', 'Pole Dance', 'Password');
			return false;	
		}
	}
	if($('#ConfirmPassword').val()==""){
   		jAlert('Please enter confirm password.', 'Pole Dance', 'ConfirmPassword');
		return false;
    }
	if($('#Password').val() != $('#ConfirmPassword').val() ){
   		jAlert('Confirm Password is mismatch.', 'Pole Dance', 'ConfirmPassword');
		return false;
    }
	if($('#ProfileImage').val() != ""){
		var ext = $('#ProfileImage').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			jAlert('Invalid file type. Upload only .gif, .png, .jpg and .jpeg.', 'Pole Dance', 'ProfileImage');
			return false;
		}
	}
	
	
	var checkEmailIdExist = base_url+'home/checkEmailIdExist';
	var EmailAddress = $('#EmailAddress').val();
	
	$.ajax({  
			type: "POST",
			url: checkEmailIdExist,  
			data: {"EmailAddress": EmailAddress },  
			success: function(msg)
			{  
				if(msg == 'Exist')
				{
					jAlert('This Email Address is already exist.', 'Pole Dance', 'EmailAddress');
					$('#EmailAddress').css('color','red');
					return false;
				}
				else
				{
					$("#addjudgesform").submit();
				}
			 }
		});
}
</script>
<?php if($this->session->flashdata('register_msg') != '') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('This email id is already taken.', 'Pole Dance', '');
});	
</script>
<?php } ?>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
		<table width="100%" border="0">
      <tbody><tr>
        <td width="24%">&nbsp;</td>
		<td width="2%"></td>
        <td width="35%"><a href="<?php echo base_url();?>home/register" style="font-size:13px; color:#DD77A2; font-family: Arial, Helvetica, sans-serif;">Competitor</a></td>
        <td width="2%"></td>
        <td width="37%"><a href="<?php echo base_url();?>home/register_judges" style="font-size:13px; color:#DD77A2; font-family: Arial, Helvetica, sans-serif;">Judges</span></td>
        </tr>
		<tr>&nbsp;&nbsp;</tr>
    </tbody></table>
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Register as a Judge</h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="addjudgesform" id="addjudgesform" method="post" action="<?php echo base_url();?>home/addjudges/insert/" enctype="multipart/form-data">
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
       
        <td  align="left"><span class="box_title">First Name <span class="asterick">*</span></span></td>
        <td  align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="1" name="FirstName" id="FirstName" maxlength="50"  onkeyup="trimFirstSpace('FirstName');" onkeypress="enterPage('addnewjudgesbutton', event);" /></td>
        <td height="45" align="left"><span class="box_title">Last Name <span class="asterick">*</span></span></td>
        <td  align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="2" name="LastName" id="LastName" maxlength="50" onkeyup="trimFirstSpace('LastName');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
      </tr>
      
      <tr>
       
        <td height="45" align="left"><span class="box_title">Address Line 1</span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="3" name="AddressLine1" id="AddressLine1" maxlength="255" onkeyup="trimFirstSpace('AddressLine1');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Address Line 2</span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="4" name="AddressLine2" id="AddressLine2" maxlength="255" onkeyup="trimFirstSpace('AddressLine2');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
      </tr>
      <tr>
       
        <td height="45" align="left"><span class="box_title">Email Address<span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px; text-transform:lowercase;" tabindex="5" name="EmailAddress" id="EmailAddress" maxlength="80" onkeyup="trimFirstSpace('EmailAddress');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Country<span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp;</span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="6" name="Country" id="Country" maxlength="50" onkeyup="trimFirstSpace('Country');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
      </tr>
      <tr>
       
        <td height="45" align="left"><span class="box_title">Phone Number<span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="7" name="PhoneNumber" id="PhoneNumber" maxlength="15" onkeyup="trimFirstSpace('PhoneNumber');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Mobile Number</span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="text" value="" class="tb3" style="width:280px;" tabindex="8" name="MobileNumber" id="MobileNumber" maxlength="15" onkeyup="trimFirstSpace('MobileNumber');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
      </tr>
      <tr>
       
        <td height="45" align="left"><span class="box_title">Password<span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="password" value="" class="tb3" style="width:275px; height:19px; line-height:18px;" tabindex="9" name="Password" id="Password" maxlength="30"  onkeyup="trimFirstSpace('Password');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Confirm Password<span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="45" align="left"><input type="password" value="" class="tb3" style="width:275px; height:19px; line-height:18px;" tabindex="10" name="ConfirmPassword" id="ConfirmPassword" maxlength="30" onkeyup="trimFirstSpace('ConfirmPassword');"  onkeypress="enterPage('addnewjudgesbutton', event);"/></td>
      </tr>
      <tr>
       
		 <td height="42" align="left" valign="top" style="padding-top:10px;"><span class="box_title">Profile Image</span></td>
        <td height="42" align="center" valign="top" style="padding-top:10px;"><span class="box_title">:&nbsp; </span></td>
        <td height="42" align="left" valign="top" style="padding-top:6px;"><input type="file" name="ProfileImage" id="ProfileImage" class="tb3" size="20" tabindex="11" /></td>
       
      </tr>
      <tr>
       
        <td height="45" align="left"><span class="box_title">Biography</span></td>
        <td height="42" align="center"><span class="box_title">:&nbsp; </span></td>
        <td height="42" align="left"><textarea name="Bio" id="Bio" class="tb3" cols="40" rows="5" style="resize:none; width:350px; height:100px;" tabindex="11"></textarea></td>
       
      </tr>
      
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="45" colspan="7"><table width="100%" height="42" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="19%" align="left"><span class="asterickmandatory"><span class="asterick">*</span> - indicates a required field.</span></td>
            <td width="8%" align="left"><span class="btn_bx"><input type="button" name="addnewjudgesbutton" id="addnewjudgesbutton" value="Submit" onClick="return validateAddNewjudges();" tabindex="12"></span></td>
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