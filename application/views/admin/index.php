<?php // echo base_url(); //exit;?>

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link href="<?php echo base_url(); ?>css/master_stylesheet.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.alerts.css">
<script> var base_url ='<?php echo base_url();?>';</script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/jquery-1.4.3.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/common_functions.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/jquery.alerts.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo base_url(); ?>js/home.js" type="text/javascript"></script>
</head>
<body style="background-image:">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" height="150" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center">
		
		<div id="head_inner"><div class="logo"><img src="<?php echo base_url();?>images/logo.jpg" alt="" width="228" height="143" border="0" usemap="#Map2"><map name="Map2"><area shape="circle" coords="91,41,94" href="<?php echo base_url().'admin/'; ?>"></map></div>
		<h3>Online Judging System for </h3> <h4>Pole Dance & Fitness Competitions</h4><div class="clear"></div></div>
		
		
       
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="1px"></td>
  </tr>
  <tr>
    <td height="15" background="<?php echo base_url(); ?>images/background.png">&nbsp;</td>
  </tr>
  <tr>
    <td height="42"></td>
  </tr>
  <tr>
    <td height="15">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="content">
           <div class="box" style="width: 450px; min-height: 300px; margin-top:40px; margin-left: auto; margin-right: auto;">
           <div class="left"></div>
           <div class="right"></div>
           <div class="heading">
           <h1 style="background-image: url(&quot;<?php echo base_url(); ?>images/lockscreen.png&quot; ); color:#575757;">Please enter your login details.</h1>
        </div>
        
       <div class="content" style="min-height: 150px;">
        <form action="" method="post" enctype="multipart/form-data" id="masteradminloginform" name="masteradminloginform">
      <table style="width: 100%;">
        <tbody><tr>
          <td width="33%" rowspan="3" valign="top" style="text-align: center;" ><img src="<?php echo base_url(); ?>images/login.png" title="Please enter your login details."></td>
        </tr>
        <tr>
          <td width="67%"><h1>Email Address:</h1>
           <INPUT type="text" name="EmailAddress"  class="tb1" id="EmailAddress" maxlength="80" tabindex="1" onkeypress="enterPage('loginbutton', event);" onkeyup="trimFirstSpace('EmailAddress');" value=""  style="width:230px;"/>
			
            <br />
           <h1>Password:</h1>
            <input name="AdminPassword" class="tb2" id="AdminPassword" onkeypress="enterPage('loginbutton', event);" onkeyup="trimFirstSpace('AdminPassword');" tabindex="2" maxlength="30" type="password" value="">
			</td>
        </tr>
        
        <tr>
          <td align="center"><div class="login" style="padding-left:20px;"><span class="btn_bx"><input type="button" name="loginbutton" id="loginbutton" value="Login" onClick="return LoginValidate();" tabindex="3"></span></div> </td>
        </tr>
      </tbody></table>
    </form>
  </div>
</div>
</div></td>
  </tr>
</table>    </td>
  </tr>
  <tr>
    <td height="26">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" background="<?php echo base_url(); ?>images/background.png">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><div id="footer">Copyright 2011 Complete Internet Services Pty Ltd. All Rights Reserved. </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
