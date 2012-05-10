// Login Validation
function LoginValidate()
{
	var loginname = $('#EmailAddress').val();
	
	var password = $('#AdminPassword').val();
	
	var sURL = base_url+'admin/home/checkadminlogin';
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	
	if($('#EmailAddress').val()=="")
    {
   		jAlert('Please enter your email address.', 'Pole Dance', 'EmailAddress');
		return false;
    }
	else if(!filter.test($('#EmailAddress').val())){
		jAlert('Please enter valid email address.', 'Pole Dance', 'EmailAddress');
		return false;	
	}
	
	if($('#AdminPassword').val()=="")
    {
		jAlert('Please enter your password.', 'Pole Dance', 'AdminPassword');		
		return false;
    }
	
	else
	{
		$.ajax({  
			type: "POST",
			url: sURL,  
			data: {"loginname":loginname,"password":password},  
			success: function(msg)
			{  
				//alert(msg); return false;
					if(msg == 'Invalid'){
						jAlert('Invalid Username / Password.', 'Pole Dance', 'AdminPassword');
						return false;
					}else {
						window.location.href = base_url+'admin/home/homepage/';
					}
			 }
			});
	}
}

// hide success message
function emptySuccessMSG()
{
	$('#passwordSuccess').html('');
}

// reset the change password fields
function resetChangePassword()
{
	$('#OldPassword').val('');
	$('#NewPassword').val('');
	$('#CNewPassword').val('');	
	$('#passwordSuccess').html('');
}

// reset the change password fields
function resetMyprofile()
{
	$('#MyprofileSuccess').html('');
}

// validate changepassword form
function validateChangePassword(UserType)
{
	if(UserType == 'MA'){ var sURL = base_url+'admin/home/getchangepassword/';}
		else if(UserType == 'E'){var sURL = base_url+'admin/home/getchangeeventadminpassword/';}
	
	
	if($('#OldPassword').val()==""){
   		jAlert('Please enter current password.', 'Pole Dance', 'OldPassword');
		return false;
    }
	if($('#NewPassword').val()==""){
   		jAlert('Please enter new password.', 'Pole Dance', 'NewPassword');
		return false;
    }
	else{
		if($("#NewPassword").val().length < 5)
		{
			jAlert('New password must have at least 5 characters.', 'Pole Dance', 'NewPassword');
			return false;	
		}
	}
	if($('#CNewPassword').val()==""){
   		jAlert('Please enter confirm new password.', 'Pole Dance', 'CNewPassword');
		return false;
    }
	if($('#NewPassword').val() != $('#CNewPassword').val() ){
   		jAlert('Confirm password is mismatch.', 'Pole Dance', 'CNewPassword');
		return false;
    }
	//$('#passwordSuccess').html('<img src="'+siteURL+'images/load.gif" border="0" width="200" height="19">');
	$.ajax({ 
			type: "POST",
			url: sURL,  
			data: {"OldPassword":$('#OldPassword').val(), "NewPassword":$('#NewPassword').val()},  
			success: function(msg)
			{  
				//alert(msg); return false;
				
				if(msg == 'mismatch')
				{
					jAlert('The current password is incorrect.', 'Pole Dance', 'OldPassword');
					return false;
				}
				else if(msg == 'samePasswordNotAccepted')
				{
					jAlert(' Current Password and the New Password details are same.', 'Pole Dance', 'NewPassword');
					return false;
				}
				else
				{
					$('#OldPassword').val('');
					$('#NewPassword').val('');
					$('#CNewPassword').val('');
					$('#passwordSuccess').html('<img src="'+base_url+'images/tick2.png" height="32" width="32"/>&nbsp;&nbsp;<span class="success">Your password has been successfully changed.</span>');
						
				}
			 }
			});
}

// validate myprofile form
function validateMyProfile()
{
	$('#MyprofileSuccess').html('');
	var sURL = base_url+'admin/home/getchangemyprofile/';
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
	if($('#EmailAddress').val()==""){
   		jAlert('Please enter email address.', 'Pole Dance', 'EmailAddress');
		return false;
    }
	else if(!filter.test($('#EmailAddress').val())){
		jAlert('Please enter valid email address.', 'Pole Dance', 'EmailAddress');
		return false;	
	}
	
	$.ajax({ 
			type: "POST",
			url: sURL,  
			data: {"FirstName":$('#FirstName').val(), "LastName":$('#LastName').val(), "EmailAddress":$('#EmailAddress').val()},  
			success: function(msg)
			{  
				if(msg == 'Exist')
				{
					jAlert('This email address is already exist.', 'Pole Dance', 'EmailAddress');
					return false;
				}
				else
				{
					$('#MyprofileSuccess').html('<img src="'+base_url+'images/tick2.png" height="32" width="32"/>&nbsp;&nbsp;<span class="success">Your profile has been successfully changed.</span>');
						
				}
			 }
			});
}
