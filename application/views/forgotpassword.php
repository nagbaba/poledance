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
<style type="text/css">
span.btn_bx      						{ background:url(../../images/l_btn_left.jpg) no-repeat left top ; height:40px ; line-height:35px ; float:left ; padding:0 0 0 7px ; width:auto; cursor:pointer; text-decoration:none;}
span.btn_bx input 						{ background:url(../../images/l_btn_right.jpg) no-repeat right top; height:40px; line-height:35px ; float:left ; color:#ffffff ; font-size:14px ; border:none ; width:auto; padding:0px 9px 0px 0px; cursor:pointer;text-decoration:none;}
.tb1 {
	background-image:url(../../images/form_bg.jpg);
	background-repeat:repeat-x;
	border:1px solid #d1c7ac;
	width: 230px;
	height:24px;
	color:#C7C7C7;
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
<table width="98%" height="48" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="31"><span style="width:100%; margin:0px; float:left; font-size:16px; font-weight:bold;  font-family:Arial, Helvetica, sans-serif; padding-top:8px; color:#a5004a; border-bottom:2px dotted #a5004a; padding-left:5px;">
	<img src="<?php echo base_url(); ?>images/forgot.png" width="32" height="32" alt="Reset Password" title="Reset Password" /><span style="padding-left:10px;">Forgot your password ?</span></span></td>
  </tr>
  <tr>
    <td height="31">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
           <tr>
            <td height="24"><span style="font-size:13px; color:#DD77A2; font-family: Arial, Helvetica, sans-serif;">To reset your password, type the full email address you use to sign in to Poledance Application.</span></td>
          </tr>
           <tr>
             <td height="25">&nbsp;</td>
           </tr>
          <tr>
            <td height="40" id="PasswordContent" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td width="25%" height="40"><span style="color:#646464; font-size:18px; font-family: Arial, Helvetica, sans-serif;" >Email Address : </span></td>
                <td width="50%" align="left"><INPUT type="text" name="EmailAddress"  class="tb1" id="EmailAddress" maxlength="80" tabindex="1" onkeyup="trimFirstSpace('EmailAddress');" value="enter your email address" onFocus="if(this.value == 'enter your email address') {this.value = ''; this.style.color='#384F01';}" onBlur="if (this.value == '') {this.value = 'enter your email address'; this.style.color='#C7C7C7'; }" style="text-transform:lowercase;" /></td>
              
			    <td width="25%" align="left">	
				 <span class="btn_bx"><input type="button" name="sendforgotpasswordbutton" id="sendforgotpasswordbutton" value="Send" onClick="return forgotPasswordValidate();" tabindex="2"></span>
			 	  </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="19">&nbsp;</td>
          </tr>
          </table></td>  </tr>
</table>
</body>
</html>