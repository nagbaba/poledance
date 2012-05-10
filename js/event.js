// Login Validation
function eventAdminLoigValidate(UserType)
{
	var EmailAddress = $('#EmailAddress').val();
	var Password = $('#Password').val();
	
	var sURL = base_url+'home/checkeventadminlogin/';
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	
	if($('#EmailAddress').val()=="" || $('#EmailAddress').val()=="Email Address")
    {
   		jAlert('Please enter your email address.', 'Pole Dance', 'EmailAddress');
		return false;
    }
	else if(!filter.test($('#EmailAddress').val())){
		jAlert('Please enter valid email address.', 'Pole Dance', 'EmailAddress');
		return false;	
	}
	if($('#Password').val()=="" || $('#Password').val()=="Password")
    {
		jAlert('Please enter your password.', 'Pole Dance', 'Password');		
		return false;
    }
	else
	{
		$.ajax({  
			type: "POST",
			url: sURL,  
			data: {"EmailAddress":EmailAddress,"Password":Password, "UserType":UserType},  
			success: function(msg)
			{  
				//alert(msg); return false; 
					if(msg == 'Invalid'){
						jAlert('Invalid Username / Password.', 'Pole Dance', 'Password');
						return false;
					}
					else if(msg == 'InActive')
					{
						jAlert('Your account has been deactivated.', 'Pole Dance', 'Password');
						return false;
					}
					else {
							window.parent.location.href = base_url+'admin/home/eventadminhomepage/';
						}
			 }
			});
	}
}

// judges  login validation
function judgesLoigValidate(UserType)
{
	var EmailAddress = $('#JudgesEmailAddress').val();
	var Password = $('#JudgesPassword').val();
	
	var sURL = base_url+'home/checkjudgeslogin/';
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	
	if($('#JudgesEmailAddress').val()=="" || $('#JudgesEmailAddress').val()=="Email Address")
    {
   		jAlert('Please enter your email address.', 'Pole Dance', 'JudgesEmailAddress');
		return false;
    }
	else if(!filter.test($('#JudgesEmailAddress').val())){
		jAlert('Please enter valid email address.', 'Pole Dance', 'JudgesEmailAddress');
		return false;	
	}
	if($('#JudgesPassword').val()=="" || $('#JudgesPassword').val()=="Password")
    {
		jAlert('Please enter your password.', 'Pole Dance', 'JudgesPassword');		
		return false;
    }
	else
	{
		$.ajax({  
			type: "POST",
			url: sURL,  
			data: {"EmailAddress":EmailAddress,"Password":Password, "UserType":UserType},  
			success: function(msg)
			{  
				//alert(msg); return false; 
					if(msg == 'Invalid'){
						jAlert('Invalid Username / Password.', 'Pole Dance', 'JudgesPassword');
						return false;
					}
					else if(msg == 'InActive')
					{
						jAlert('Your account has been deactivated.', 'Pole Dance', 'JudgesPassword');
						return false;
					}
					else {
						window.parent.location.href = base_url+'competition/startedcompetitionlist/';
					}
			 }
			});
	}
}

// competitors login validation
function competitorsLoigValidate(UserType)
{
	var EmailAddress = $('#CompetitorsEmailAddress').val();
	var Password = $('#CompetitorsPassword').val();
	
	var sURL = base_url+'home/checkcompetitorslogin/';
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	
	if($('#CompetitorsEmailAddress').val()=="" || $('#CompetitorsEmailAddress').val()=="Email Address")
    {
   		jAlert('Please enter your email address.', 'Pole Dance', 'CompetitorsEmailAddress');
		return false;
    }
	else if(!filter.test($('#CompetitorsEmailAddress').val())){
		jAlert('Please enter valid email address.', 'Pole Dance', 'CompetitorsEmailAddress');
		return false;	
	}
	if($('#CompetitorsPassword').val()=="" || $('#CompetitorsPassword').val()=="Password")
    {
		jAlert('Please enter your password.', 'Pole Dance', 'CompetitorsPassword');		
		return false;
    }
	else
	{
		$.ajax({  
			type: "POST",
			url: sURL,  
			data: {"EmailAddress":EmailAddress,"Password":Password, "UserType":UserType},  
			success: function(msg)
			{  
				//alert(msg); return false; 
					if(msg == 'Invalid'){
						jAlert('Invalid Username / Password.', 'Pole Dance', 'CompetitorsPassword');
						return false;
					}
					else if(msg == 'InActive')
					{
						jAlert('Your account has been deactivated.', 'Pole Dance', 'CompetitorsPassword');
						return false;
					}
					else {
						window.parent.location.href = base_url+'competitor/profile';
					}
			 }
			});
	}
}

// forgot password Validation
function forgotPasswordValidate()
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	var sURL = base_url+'home/sendPassword/';
	var EmailAddress = $('#EmailAddress').val();
	if($('#EmailAddress').val()=="" || $('#EmailAddress').val()== "enter your email address" )
    {
		jAlert('Please enter your email address.', 'Pole Dance', 'EmailAddress');
		return false;
    }
	else if(!filter.test($('#EmailAddress').val())){
		jAlert('Please enter valid email address.', 'Pole Dance', 'EmailAddress');
		return false;	
	}
	else
	{
		$('#PasswordContent').html('<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height="39" align="center"><img src="'+base_url+'images/pinkloading.gif" border="0" width="100" height="65"></td></tr></table>');
		
		$.ajax({  
			type: "POST",
			url: sURL,  
			data: {"EmailAddress":EmailAddress },  
			success: function(msg)
			{  
				if(msg == 'notindb')
				{
					$('#PasswordContent').html('<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="50%" height="40"><span class="forgotpwmsg">This Email Address is not available.</span></td><td width="50%" align="left"><span class="btn_bx"><input type="button" name="sendagain" id="sendagain" value="Back" onClick="return forgotPasswordTable(\''+base_url+'\');" tabindex="3"></span> </td></tr></table>');
					return false;
				}
				else if(msg == 'fail')
				{
					$('#PasswordContent').html('<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="70%" height="40"><span class="forgotpwmsg">Fail to send Pole Dance account login details.</span></td><td width="30%" align="left"><span class="btn_bx"><input type="button" name="sendagain" id="sendagain" value="Back" onClick="return forgotPasswordTable(\''+base_url+'\');" tabindex="3"></span> </td></tr></table>');
					return false;
				}
				else
				{
					$('#PasswordContent').html('<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height="40"><span class="forgotpwmsg">Your login details are successfully sent to your email address.</span><span class="btn_bx" style="float:right;"><input type="button" name="sendagain" id="sendagain" value="Back" onClick="return forgotPasswordTable(\''+base_url+'\');" tabindex="3"></span></td></tr></table>');
					return false;
				}
					
			 }
		});	
	}
}

function forgotPasswordTable()
{
	$('#PasswordContent').html('<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="25%" height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;">Email Address : </span></td><td width="50" align="left"><INPUT type="text" name="EmailAddress"  class="tb1" id="EmailAddress" maxlength="80" tabindex="1" onkeyup="trimFirstSpace(\'EmailAddress\');" value="enter your email address" onFocus="if(this.value == \'enter your email address\') {this.value = \'\'; this.style.color=\'#384F01\';}" onBlur="if(this.value == \'\'){this.value = \'enter your email address\'; this.style.color=\'#C7C7C7\'; }" style="text-transform:lowercase;" /></td><td width="25%" align="left"><span class="btn_bx"><input type="button" name="sendforgotpasswordbutton" id="sendforgotpasswordbutton" value="Send" onClick="return forgotPasswordValidate();" tabindex="2"></span></span></td></tr></table>');
}