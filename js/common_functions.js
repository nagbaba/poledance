<!-- Type valid charecter -->
function checkValidChar(e,flg) 
{
	var keynum
	var keychar
	//var numcheck
	
	// For Internet Explorer
	if (window.event){ keynum = e.keyCode }
	
	// For Netscape/Firefox/Opera
	else if (e.which){ keynum = e.which	}
	
	keychar = String.fromCharCode(keynum)

	//List of special characters you want to restrict
	
	switch(flg)
	{
		case 1: // Allow alphabets and not number and not special character
			var blockChar = ( keynum >= 33 && keynum <= 47 ) || 
							( keynum >= 58 && keynum <= 64 ) || 
							( keynum >= 91 && keynum <= 96 ) || 
							( keynum >= 123 && keynum <= 126 );
			break;
			
		case 2: // Email Validation - Allow  @ _ - .
			var blockChar = ( keynum >= 33 && keynum <= 44 )   || 
							( keynum >= 58 && keynum <= 63 )   || 
							( keynum >= 91 && keynum <= 94 )   || 
							( keynum >= 123 && keynum <= 126 ) ||
							( keynum == 47 ) || ( keynum == 96 );
			break;
			
		case 3: // Allow alphabets and number and  -(hyphen)  and  not other special charecter/
			var blockChar = ( keynum >= 33 && keynum <= 44 )   || 
							( keynum >= 58 && keynum <= 64 )   || 
							( keynum >= 91 && keynum <= 96 )   || 
							( keynum >= 123 && keynum <= 126 ) ||
							( keynum == 46);
			break;
	
		case 4: // Allow Only Alphabet
			var blockChar = ( keynum >= 33 && keynum <= 64 ) || 
							( keynum >= 91 && keynum <= 96 ) || 
							( keynum >= 123 && keynum <= 126 );
			break;
		
		case 5: // Allow Only Number and not others
			var blockChar = ( keynum >= 33 && keynum <= 47 ) || 
							( keynum >= 58 && keynum <= 126 );
			break;
		
		case 6: // Allow Only Number and ( ) - and not others
			var blockChar = ( keynum >= 33 && keynum <= 39 ) || 
							( keynum >= 42 && keynum <= 44 ) || 
							( keynum >= 46 && keynum <= 47 ) || 
							( keynum >= 58 && keynum <= 126 );
			break;
	}
	
	if (blockChar){	return false;}
		else{return true; }
}

//javascript validation
function checkSpecialChar(fieldname, flg) 
{		
	switch(flg)
	{
		case 1: // Allow Only Alphabet and numbers
			 var iChars = "`~!@#$%^&*()+=-_[]\\\';,./{}|\":<>?";
		break;
		
		case 2: // Email Validation - Allow  @ _ - .
			 var iChars = "`~!#$%^&*()+=[]\\\';,/{}|\":<>?";
		break;
		
		case 4: // Allow Only Alphabet
			 var iChars = "`~!@#$%^&*()+=-_[]\\\';,./{}|\":<>?0123456789";
		break;
		
		case 5: // Allow Only Number and not others
			 var iChars = "`~!@#$%^&*()+=-_[]\\\';,./{}|\":<>?abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		break;
		
		case 6: // Allow Only Number, - and not others
			 var iChars = "`~!@#$%^&*()+=_[]\\\';,./{}|\":<>?abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		break;
	}
	
	for (var i = 0; i < $('#'+fieldname).val().length; i++) 
	{
		if (iChars.indexOf($('#'+fieldname).val().charAt(i)) != -1)
		{	
			return false;
		}
	}
}

// trim input field
function trimFirstSpace(field)
{
        var re=/^\s+$|^\s+/g;
	
        var fieldval=$('#'+field).val();
   
		var splchar = fieldval.match(re);

        if(splchar && !fieldval.match("\n"))
        {
			var trimstr=fieldval.replace(re, "");
			$('#'+field).val(trimstr);
		
			jAlert('Space should not be allowed in the first position.', 'Pole Dance', field);
			return false;
        }
}

// check all check box
function toggleChecked(status) {
	$(".checkbox").each( function() {
		$(this).attr("checked",status);
	})
}

function chkMainBox()
{
	var TotalChkBox = $("input[name='CompetitorICode[]']").size();
	var TotalSelectedBox = $("input[name='CompetitorICode[]']").filter(":checked").size();
	if(TotalChkBox == TotalSelectedBox){ $('#chckHead').attr("checked",'checked'); } else { $('#chckHead').attr("checked",''); }
}

function enterPage(buttonName,e)
{
	 var key;
     if(window.event)
     key = window.event.keyCode;     //IE
     	else
        key = e.which;     //firefox
	 
	 if (key == 13)
     {
		//Get the button the user wants to have clicked
        var btn = document.getElementById(buttonName);
        if (btn != null)
        { //If we find the button click it
        	btn.click();
			if(window.event)
                event.keyCode = 0;
            }
        }
}


// active and deactive users / physician / etc...
function StatusActive(TableName, EditId, UpdateValue, Who, siteURL, EditFieldName)
{
	switch(UpdateValue)
	{
		case 1:
				 var msg="Do you want to set this"+' '+ Who+' '+"as Inactive?";
				 break;
		case 0:
				var msg="Do you want to Activate this"+' '+ Who +"?";
				break;
	}
	
	jConfirm(msg, 'Pole Dance', function(r) {
		if(r == true)
		{
			var sURL = siteURL+"images/spinner.gif";
			var pURL = siteURL+"admin/home/statuschange/";
			
			$('#status'+EditId).html("<img src="+ sURL +" border='0'>"); 
	
			$.ajax({  
					type: "POST",
					url: pURL,  
					data: {"TableName":TableName, "EditId":EditId, "UpdateValue":UpdateValue, "Who":Who, "EditFieldName":EditFieldName },  
					success: function(msg)
					{ 
						//	alert(msg);
						$('#status'+EditId).html(msg);
					}
			});
		}
	});
	
}


