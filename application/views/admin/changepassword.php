<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Change Password </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
	
	
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td height="39" align="left">&nbsp;</td>
                <td height="39" align="left">&nbsp;</td>
                <td colspan="2" align="left" id="passwordSuccess">&nbsp;</td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td width="420" height="46" align="right"><span class="box_title">Current Password <span class="asterick">*</span></span></td>
                <td width="46" height="46" align="center"><label>:</label></td>
                <td colspan="2" align="left"><input type="password" value="" class="tb2" style="width:300px;" tabindex="1" name="OldPassword" id="OldPassword" maxlength="30" onkeyup="trimFirstSpace('OldPassword');" onfocus="emptySuccessMSG();" onkeypress="enterPage('changepasswordbutton',event);"/></td>
              
			    <td width="23" align="left">&nbsp;                 </td>
              </tr>
              <tr>
                <td height="44" align="right"><span class="box_title">New Password <span class="asterick">*</span></span></td>
                <td height="44" align="center"><label>:</label></td>
                <td colspan="2" align="left"><input type="password" value="" class="tb2" style="width:300px;" tabindex="2" name="NewPassword" id="NewPassword" 
				maxlength="30" onkeyup="trimFirstSpace('NewPassword');"  onfocus="emptySuccessMSG();" onkeypress="enterPage('changepasswordbutton',event);"/></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td height="42" align="right"><span class="box_title">Confirm New Password  <span class="asterick">*</span></span></td>
                <td align="center"><label>:</label></td>
                <td colspan="2" align="left"><input type="password" value="" class="tb2" style="width:300px;" tabindex="3" name="CNewPassword" id="CNewPassword" maxlength="30" onkeyup="trimFirstSpace('CNewPassword');"  onfocus="emptySuccessMSG();" onkeypress="enterPage('changepasswordbutton',event);"/></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td height="19" colspan="2" align="right">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="39" colspan="2" align="left"><span class="asterickmandatory"><span class="asterick">*</span> - indicates a required field.</span></td>
                <td width="86" align="left"><span class="btn_bx">
                  <input type="button" name="changepasswordbutton" id="changepasswordbutton" value="Update" onClick="return validateChangePassword('<?php echo $this->session->userdata('UserType');?>');" tabindex="3"></span></td>
                <td width="593" align="left"><span class="btn_bx">
                  <input type="button" name="clear" id="clear" value="Clear" tabindex="5" onclick="return resetChangePassword();"/>
                </span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="21" colspan="2" align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
</div>
    </div>
  </div>
</div></td>
      </tr>
    </table>