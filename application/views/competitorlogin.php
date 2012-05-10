<form name="judgeslogin" id="judgeslogin" action="" method="post">
<h1>Competitors Login</h1>
<div class="txt_bx_b"><span class="txt_bx"><input type="text" name="CompetitorsEmailAddress" id="CompetitorsEmailAddress" maxlength="80" tabindex="4" value="Email Address"   onFocus="if(this.value == 'Email Address') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Email Address'; this.style.color='#637288'; }" onkeypress="enterPage('JudgesLoginButton',event);" onkeyup="trimFirstSpace('JudgesEmailAddress');" /></span><div class="clear"></div></div>

<div class="txt_bx_b1"><span class="txt_bx"><input type="password" name="CompetitorsPassword" id="CompetitorsPassword" maxlength="30"  tabindex="5" value="Password"   onFocus="if(this.value == 'Password') {this.value = ''; this.style.color='#637288';}" onBlur="if(this.value == '') {this.value = 'Password'; this.style.color='#637288'; }" onkeypress="enterPage('JudgesLoginButton', event);" onkeyup="trimFirstSpace('JudgesPassword');" />
</span><div class="clear"></div></div>
<div>

	<div class="log_link_txt"><br><a href="#?w=600" rel="forgot_password" class="poplight" style="font-size:11px; font-weight:bold; color:#4e2f8c; text-decoration:none; float:left;">Forgot Password ?</a></div>
	<div class="login"><span class="btn_bx"><input type="button" value="Click to Login" name="CompetitorsLoginButton" id="CompetitorsLoginButton" onClick="return competitorsLoigValidate('C');" tabindex="6" /></span></div>
	<div class="clear"></div>
</div>
</form>