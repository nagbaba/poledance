<form name="eventadminlogin" id="eventadminlogin" action="" method="post">
<h1>Event Admin Login</h1>
<div class="txt_bx_b"><span class="txt_bx"><input type="text" name="EmailAddress" id="EmailAddress" maxlength="80" tabindex="1" value="Email Address"   onFocus="if(this.value == 'Email Address') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Email Address'; this.style.color='#637288'; }" onkeypress="enterPage('EventAdminLoginButton',event);" onkeyup="trimFirstSpace('EmailAddress');" /></span><div class="clear"></div></div>

<div class="txt_bx_b1"><span class="txt_bx"><input type="password" name="Password" id="Password" maxlength="30"  tabindex="2" value="Password"   onFocus="if(this.value == 'Password') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Password'; this.style.color='#637288'; }" onkeypress="enterPage('EventAdminLoginButton', event);" onkeyup="trimFirstSpace('Password');" />
</span><div class="clear"></div></div>
<div>

	<div class="log_link_txt"><br><a href="#?w=600" rel="forgot_password" class="poplight" style="font-size:11px; font-weight:bold; color:#4e2f8c; text-decoration:none; float:left;">Forgot Password ?</a></div>
	<div class="login"><span class="btn_bx"><input type="button" value="Click to Login" name="EventAdminLoginButton" id="EventAdminLoginButton" onClick="return eventAdminLoigValidate('E');" tabindex="3" /></span></div>
	<div class="clear"></div>
</div>
</form>