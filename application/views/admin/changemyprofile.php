<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">My Profile </h1>
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
                <td colspan="2" align="left" id="MyprofileSuccess">&nbsp;</td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td width="420" height="46" align="right"><span class="box_title">First Name  <span class="asterick">*</span></span></td>
                <td width="46" height="46" align="center"><label>:</label></td>
                <td colspan="2" align="left"><input type="text" value="<?php echo $AdminDetails['FirstName'];?>" class="tb3" style="width:300px;" tabindex="1" name="FirstName" id="FirstName" maxlength="50" onkeyup="trimFirstSpace('FirstName');" onkeypress="enterPage('myprofilebutton', event);"/></td>
              
			    <td width="23" align="left">&nbsp;                 </td>
              </tr>
              <tr>
                <td height="44" align="right"><span class="box_title">Last Name  <span class="asterick">*</span></span></td>
                <td height="44" align="center"><label>:</label></td>
                <td colspan="2" align="left"><input type="text" value="<?php echo $AdminDetails['LastName'];?>" class="tb3" style="width:300px;" tabindex="2" name="LastName" id="LastName" maxlength="50" onkeyup="trimFirstSpace('LastName');" onkeypress="enterPage('myprofilebutton', event);"/></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td height="42" align="right"><span class="box_title">Email Address  <span class="asterick">*</span></span></td>
                <td align="center"><label>:</label></td>
                <td colspan="2" align="left"><input type="text" value="<?php echo $AdminDetails['EmailAddress'];?>" class="tb3" style="width:300px;" tabindex="3" name="EmailAddress" id="EmailAddress" maxlength="80" onkeyup="trimFirstSpace('EmailAddress');" onkeypress="enterPage('myprofilebutton', event);"/></td>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td height="19" colspan="2" align="right">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="39" colspan="2" align="left"><span class="asterickmandatory"><span class="asterick">*</span> - indicates a required field.</span></td>
                <td width="85" align="left"><span class="btn_bx">
                  <input type="button" name="myprofilebutton" id="myprofilebutton" value="Update" onClick="return validateMyProfile();" tabindex="3"></span></td>
                <td width="594"  align="left"><span class="btn_bx">
                  <input type="button" name="clear" id="clear" value="Cancel" tabindex="5" onclick="location.href='<?php echo base_url();?>admin/home/homepage/'"/>
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