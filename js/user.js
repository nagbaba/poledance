// Add User Validation
function validateNewEventadmin()
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
			jAlert('Mobile Number should be 10 digits. Ex: 123 456 7890', 'Pole Dance', 'MobileNumber');
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
	if($('#EventName').val()==""){
   		jAlert('Please enter event name.', 'Pole Dance', 'EventName');
		return false;
    }
	
	
	var checkEmailIdExist = base_url+'admin/user/checkEmailIdExist/';
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
					return false;
				}
				else
				{
					$("#addeventadminform").submit();
				}
			 }
		});
}

// edit user 
function validateEditEventadmin()
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	
	var EditEventAdminICode = $('#EditEventAdminICode').val();
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
			jAlert('Mobile Number should be 10 digits. Ex: 123 456 7890', 'Pole Dance', 'MobileNumber');
			return false;	
	  	}
	}
	if($('#EventName').val()==""){
   		jAlert('Please enter event name.', 'Pole Dance', 'EventName');
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
					$("#updateediteventadminform").submit();
				}
			 }
		});
}

//delete event admin fronm event_admin_master table
function deleteEventAdmin(EventAdminICode)
{
	jConfirm('Do you want to delete this user?', 'Pole Dance', function(r) {
	if(r == true)
	{
		window.location.href = base_url+'admin/user/deleteEventAdmin/'+EventAdminICode+'/';
	}
	});	
}

//delete judegs fronm judges_master table
function deleteJudges(JudgesICode)
{
	jConfirm('Do you want to delete this user?', 'Pole Dance', function(r) {
	if(r == true)
	{
		window.location.href = base_url+'admin/user/deleteJudges/'+JudgesICode+'/';
	}
	});	
}

//delete Competitor fronm competitor_master table
function deleteCompetitor(CompetitorICode)
{
	jConfirm('Do you want to delete this user?', 'Pole Dance', function(r) {
	if(r == true)
	{
		window.location.href = base_url+'admin/user/deleteCompetitor/'+CompetitorICode+'/';
	}
	});	
}

//delete Competition fronm competition_master table
function deleteCompetition(CompetitionICode)
{
	jConfirm('Do you want to delete this competition?', 'Pole Dance', function(r) {
	if(r == true)
	{
		window.location.href = base_url+'admin/user/deleteCompetition/'+CompetitionICode+'/';
	}
	});	
}

// add new division validate
function addDivisionValidate()
{
	var DivisionICode = $('#DivisionICode').val();
	
	if($('#DivisionName').val()==""){
   		jAlert('Please enter division name.', 'Pole Dance', 'DivisionName');
		return false;
    }
	else{
		if(checkSpecialChar('DivisionName', 1) == false){
			jAlert('Please enter valid division name.', 'Pole Dance', 'DivisionName');
			return false;
		}		
	}
	
	var DivisionName = $('#DivisionName').val();
	
	if(DivisionICode != ''){ var checkDivisionNameExist = base_url+'admin/user/checkDivisionNameExist/'+DivisionICode+'/';}
		else{ var checkDivisionNameExist = base_url+'admin/user/checkDivisionNameExist/';}
	
	$.ajax({  
			type: "POST",
			url: checkDivisionNameExist,  
			data: {"DivisionName": DivisionName },  
			success: function(msg)
			{  
				if(msg == 'Exist')
				{
					jAlert('This Division Name is already exist.', 'Pole Dance', 'DivisionName');
					return false;
				}
				else
				{
					//window.location.href = base_url+'admin/user/managedivision/';
					$("#adddivisionform").submit();
				}
			 }
		});
}

//delete division from division_master table
function deleteDivision(DivisionICode)
{
	jConfirm('Do you want to delete this division?', 'Pole Dance', function(r) {
	if(r == true)
	{
		window.location.href = base_url+'admin/user/deleteDivision/'+DivisionICode+'/';
	}
	});	
}

// Add New judges Validation
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
	
	
	var checkEmailIdExist = base_url+'admin/user/checkEmailIdExist/';
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
					return false;
				}
				else
				{
					$("#addjudgesform").submit();
				}
			 }
		});
}

// edit judges 
function validateEditJudges()
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;  // Email Validation
	
	var EditJudgesICode 	 = $('#EditJudgesICode').val();
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
					$("#updateeditjudgesform").submit();
				}
			 }
		});
}

// start competition 

function startcompetition(CompetitionICode)
{

 jConfirm('Do you want to start this competition?', 'Pole Dance', function(r) {
	if(r == true)
	{
		var startcompetition = base_url+'admin/user/managestartcompetitionAjax/';
		
		$.ajax({  
			type: "POST",
			url: startcompetition,  
			data: {"CompetitionICode": CompetitionICode },  
			success: function(msg)
			{
				if(msg == 'No Competitors')
				{
					jAlert('No competitors maped for this competition.', 'Pole Dance', 'CompetitionICode');
					return false;
				}
				else if(msg == 'No Judges')
				{
					jAlert('No judges maped for this competition.', 'Pole Dance', 'CompetitionICode');
					return false;
				}
				else
				{
					$('#ActionICon'+CompetitionICode).html(msg);		
				}
			}
			
		});
			
	}
	});	
}


function deleteConfigResult(ChampionshipICode, DivisionICode)
{
  
   jConfirm('Do you want to delete this result configuration?', 'Pole Dance', function(r) {
	if(r == true)
	{
		window.location.href = base_url+'admin/user/deleteConfigResult/'+ChampionshipICode+'/'+DivisionICode+'/';
	}
	});
}