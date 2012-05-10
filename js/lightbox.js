$(document).ready(function() {
	//Code goes here
	
	$('a.poplight[href^=#]').click(function() {		
    var popID = $(this).attr('rel'); //Get Popup Name
    var popURL = $(this).attr('href'); //Get Popup href to define size

    //Pull Query & Variables from href URL
    var query= popURL.split('?');
    var dim= query[1].split('&');
    var popWidth = dim[0].split('=')[1]; //Gets the first query string value

    //Fade in the Popup and add close button
    $('#' + popID).fadeIn().css({ 'width': Number( popWidth ),'height': 'auto' }).prepend('<a href="'+base_url+'" class="close"><img src='+base_url+'images/close_pop.png class="btn_close" title="Close Window" alt="Close" border="0" /></a>');

    //Define margin for center alignment (vertical   horizontal) - we add 80px to the height/width to accomodate for the padding  and border width defined in the css
    var popMargTop = ($('#' + popID).height() + 80) / 2;
    var popMargLeft = ($('#' + popID).width() + 80) / 2;

    //Apply Margin to Popup
    $('#' + popID).css({
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });

    //Fade in Background
    $('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
	
    $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
	
//	//Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 

    return false;
});
//Close Popups and Fade Layer
$('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
			
			//alert($('#forgot_password iframe').val());
			if($('#forgot_password iframe').contents().find('input[name=EmailAddress]').val()){
				if($('#forgot_password iframe').contents().find('input[name=EmailAddress]').val() != 'enter your email address'){
					$('#forgot_password iframe').contents().find('input[name=EmailAddress]').val('enter your email address');
					$('#forgot_password iframe').contents().find('input[name=EmailAddress]').css("color","#C7C7C7");
				}
			}
			
		/*	if($('#change_my_password iframe').contents().find('input[name=OldPassword]').val() || $('#change_my_password iframe').contents().find('input[name=NewPassword]').val() || $('#change_my_password iframe').contents().find('input[name=CNewPassword]').val() ){
				$('#change_my_password iframe').contents().find('input[name=OldPassword]').val('');
				$('#change_my_password iframe').contents().find('input[name=NewPassword]').val('');
				$('#change_my_password iframe').contents().find('input[name=CNewPassword]').val('');
			}*/
			
    $('#fade , .popup_block').fadeOut(function() {											    
										   //if(document.getElementById('EmailAddress'))document.getElementById('EmailAddress').value = '';
        $('#fade, a.close').remove();  //fade them both out
    });
    return false;
});


});