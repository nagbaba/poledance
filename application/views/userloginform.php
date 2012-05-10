<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pole Dance</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.alerts.css">
<script> var base_url ='<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common_functions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/event.js"></script>
<script>
function jlogform()
{
	$("#loginTitle").html('Judges Login');
	$("#judgesloginform").show();
	$("#eventadminloginform").hide();
	$("#competitorloginform").hide();
	
	$("#EmailAddress").val('Email Address');
	$("#Password").val('Password');
	
	/*$("#JudgesEmailAddress").val('Email Address');
	$("#JudgesPassword").val('Password');*/
	
	
}
function elogform()
{
	$("#loginTitle").html('Event Admin Login');
	$("#eventadminloginform").show();
	$("#judgesloginform").hide();
	$("#competitorloginform").hide();
	
	$("#JudgesEmailAddress").val('Email Address');
	$("#JudgesPassword").val('Password');
	
}
function clogform()
{
	$("#loginTitle").html('Competitors Login');
	$("#competitorloginform").show();
	$("#eventadminloginform").hide();
	$("#judgesloginform").hide();
	
	$("#CompetitorsEmailAddress").val('Email Address');
	$("#CompetitorsPassword").val('Password');
	
}
</script>

<style type="text/css">
span.btn_bx      						{ background:url(../../images/l_btn_left.jpg) no-repeat left top ; height:40px ; line-height:35px ; float:left ; padding:0 0 0 3px ; width:auto; cursor:pointer; text-decoration:none;}
span.btn_bx input 						{ background:url(../../images/l_btn_right.jpg) no-repeat right top; height:40px; line-height:35px ; float:left ; color:#ffffff ; font-size:14px ; border:none ; width:auto; padding:0px 5px 0px 0px; cursor:pointer;text-decoration:none;}
.tb1 {
	background-image:url(../../images/form_bg.jpg);
	background-repeat:repeat-x;
	border:1px solid #d1c7ac;
	width: 230px;
	height:24px;
	color:#637288;
	padding:5px;
	margin-right:4px;
	margin-bottom:8px;
	font-size:15px;
	font-family:Arial, Helvetica, sans-serif;
	line-height:25px;
	margin-top:10px;
}
.forgotpwmsg{color:#DD77A2; font-size:16px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;}

</style>
</head>
<body>
<table width="98%" height="93" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="31"><table width="100%" border="0">
      <tr>
       
        <td width="2%"><input type="radio" name="radio" id="radio2" value="radio" checked="checked"  onclick="elogform();" /></td>
        <td width="35%"><span style="font-size:13px; color:#DD77A2; font-family: Arial, Helvetica, sans-serif;">Event Admin</span></td>
        <td width="2%"><input type="radio" name="radio" id="radio" value="radio" onclick="jlogform();" /></td>
        <td width="37%"><span style="font-size:13px; color:#DD77A2; font-family: Arial, Helvetica, sans-serif;">Judges login</span></td>
		 <td width="2%"><input type="radio" name="radio" id="radio" value="radio" onclick="clogform();" /></td>
        <td width="37%"><span style="font-size:13px; color:#DD77A2; font-family: Arial, Helvetica, sans-serif;">Competitors login</span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="31"><span id="loginTitle" style="width:100%; margin:0px; float:left; font-size:16px; font-weight:bold;  font-family:Arial, Helvetica, sans-serif; padding-top:8px; padding-bottom:5px; color:#a5004a; border-bottom:2px dotted #a5004a;">Event Admin Login</span></td>
  </tr>
  <tr>
    <td height="31">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
         
          <tr>
            <td height="40" id="eventadminloginform" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;" >Email Address : </span></td>
                <td width="68%" align="left">
               <input type="text" name="EmailAddress" id="EmailAddress" maxlength="80" tabindex="1" value="Email Address"   onFocus="if(this.value == 'Email Address') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Email Address'; this.style.color='#637288'; }" onkeypress="enterPage('EventAdminLoginButton',event);" onkeyup="trimFirstSpace('EmailAddress');" class="tb1"/>
                </td>
              </tr>
              <tr>
                <td width="32%" height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;" >Password : </span></td>
                <td align="left"><input type="password" name="Password" id="Password" maxlength="30"  tabindex="2" value="Password"   onFocus="if(this.value == 'Password') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Password'; this.style.color='#637288'; }" onkeypress="enterPage('EventAdminLoginButton', event);" onkeyup="trimFirstSpace('Password');" class="tb1"/></td>
		      </tr>
               <tr>
                <td height="49">&nbsp;</td>
                <td align="left"><span class="btn_bx">
                  <input type="button" value="Click to Login" name="EventAdminLoginButton" id="EventAdminLoginButton" onClick="return eventAdminLoigValidate('E');" tabindex="3" /></span>
                </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="19" id="judgesloginform" style="display:none;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;" >Email Address : </span></td>
                <td width="68%" align="left">
               <input type="text" name="JudgesEmailAddress" id="JudgesEmailAddress" maxlength="80" tabindex="4" value="Email Address"   onFocus="if(this.value == 'Email Address') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Email Address'; this.style.color='#637288'; }" onkeypress="enterPage('JudgesLoginButton',event);" onkeyup="trimFirstSpace('JudgesEmailAddress');"  class="tb1"/>
                </td>
              </tr>
              <tr>
                <td width="32%" height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;" >Password : </span></td>
                <td align="left"><input type="password" name="JudgesPassword" id="JudgesPassword" maxlength="30"  tabindex="5" value="Password"   onFocus="if(this.value == 'Password') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Password'; this.style.color='#637288'; }" onkeypress="enterPage('JudgesLoginButton', event);" onkeyup="trimFirstSpace('JudgesPassword');" class="tb1"/></td>
		      </tr>
               <tr>
                <td height="49">&nbsp;</td>
                <td align="left"><span class="btn_bx">
                  <input type="button" value="Click to Login" name="JudgesLoginButton" id="JudgesLoginButton" onClick="return judgesLoigValidate('J');" tabindex="6" /></span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
    <td height="31">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          
          <tr>
            <td height="40" id="competitorloginform" style="display:none;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;" >Email Address : </span></td>
                <td width="68%" align="left">
               <input type="text" name="CompetitorsEmailAddress" id="CompetitorsEmailAddress" maxlength="80" tabindex="1" value="Email Address"   onFocus="if(this.value == 'Email Address') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Email Address'; this.style.color='#637288'; }" onkeypress="enterPage('CompetitorsLoginButton',event);" onkeyup="trimFirstSpace('EmailAddress');" class="tb1"/>
                </td>
              </tr>
              <tr>
                <td width="32%" height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;" >Password : </span></td>
                <td align="left"><input type="password" name="CompetitorsPassword" id="CompetitorsPassword" maxlength="30"  tabindex="2" value="Password"   onFocus="if(this.value == 'Password') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Password'; this.style.color='#637288'; }" onkeypress="enterPage('CompetitorsLoginButton', event);" onkeyup="trimFirstSpace('Password');" class="tb1"/></td>
		      </tr>
               <tr>
                <td height="49">&nbsp;</td>
                <td align="left"><span class="btn_bx">
                  <input type="button" value="Click to Login" name="CompetitorsLoginButton" id="CompetitorsLoginButton" onClick="return competitorsLoigValidate('C');" tabindex="3" /></span>
                </td>
              </tr>
            </table></td>
          </tr>
          </table></td>  </tr>
</table>
</body>
</html>