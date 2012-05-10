<?php if($this->session->flashdata('upload_error') != '') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('<?php echo $this->session->flashdata('upload_error');?>', 'e-pole judge', '');
});
	
</script>
<?php }?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Edit Judge Details </h1>
  </div>
  <div style="float:right; padding-top:10px; padding-right:100px;">&nbsp;</div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
	<form name="updateeditjudgesform" id="updateeditjudgesform" method="post" action="<?php echo base_url();?>admin/user/editjudges/update/<?php echo $this->uri->segment(4);?>/" enctype="multipart/form-data">
	<table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="19">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td height="19">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="5%" height="45">&nbsp;</td>
        <td width="11%" align="left"><span class="box_title">First Name <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="34%" height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['FirstName'];?>" class="tb3" style="width:280px;" tabindex="1" name="FirstName" id="FirstName" maxlength="50"  onkeyup="trimFirstSpace('FirstName');"  onkeypress="enterPage('updatejudgesbutton', event);"/></td>
        <td width="12%" height="45" align="left"><span class="box_title">Last Name <span class="asterick">*</span></span></td>
        <td width="3%" align="center"><span class="box_title">:</span></td>
        <td width="32%" height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['LastName'];?>" class="tb3" style="width:280px;" tabindex="2" name="LastName" id="LastName" maxlength="50" onkeyup="trimFirstSpace('LastName');" onkeypress="enterPage('updatejudgesbutton', event);"/></td>
      </tr>
      
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Address Line 1</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['AddressLine1'];?>" class="tb3" style="width:280px;" tabindex="3" name="AddressLine1" id="AddressLine1" maxlength="255" onkeyup="trimFirstSpace('AddressLine1');"  onkeypress="enterPage('updatejudgesbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Address Line 2</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['AddressLine2'];?>" class="tb3" style="width:280px;" tabindex="4" name="AddressLine2" id="AddressLine2" maxlength="255" onkeyup="trimFirstSpace('AddressLine2');"  onkeypress="enterPage('updatejudgesbutton', event);"/></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Email Address <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['EmailAddress'];?>" class="tb3" style="width:280px; text-transform:lowercase;" tabindex="5" name="EmailAddress" id="EmailAddress" maxlength="80" onkeyup="trimFirstSpace('EmailAddress');" onkeypress="enterPage('updatejudgesbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Country <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['Country'];?>" class="tb3" style="width:280px;" tabindex="6" name="Country" id="Country" maxlength="50" onkeyup="trimFirstSpace('Country');" onkeypress="enterPage('updatejudgesbutton', event);"/></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td height="45" align="left"><span class="box_title">Phone Number <span class="asterick">*</span></span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['PhoneNumber'];?>" class="tb3" style="width:280px;" tabindex="7" name="PhoneNumber" id="PhoneNumber" maxlength="15" onkeyup="trimFirstSpace('PhoneNumber');"  onkeypress="enterPage('updatejudgesbutton', event);"/></td>
        <td height="45" align="left"><span class="box_title">Mobile Number</span></td>
        <td height="45" align="center"><span class="box_title">:</span></td>
        <td height="45" align="left"><input type="text" value="<?php echo $JudgesDetails['MobileNumber'];?>" class="tb3" style="width:280px;" tabindex="8" name="MobileNumber" id="MobileNumber" maxlength="15" onkeyup="trimFirstSpace('MobileNumber');"  onkeypress="enterPage('updatejudgesbutton', event);"/></td>
      </tr>
      <tr>
        <td height="134">&nbsp;</td>
        <td height="134" align="left"><span class="box_title">Profile Image</span></td>
        <td height="134" align="center"><span class="box_title">:</span></td>
        <td height="134" align="left">
			<?php if($JudgesDetails['ProfileImage'] !='') { ?>
        		 <img src="<?php echo base_url(); ?>uploads/JudgesImages/<?php echo $JudgesDetails['ProfileImage'];?>" width="100px" height="100px" border="0"/>
          <?php } else { ?>
          		<img src="<?php echo base_url(); ?>images/NoPhoto.jpg" width="100px" height="100px" border="0"/>
          <?php } ?></td>
        <td height="134" align="left"><span class="box_title">Biography</span></td>
        <td height="134" align="center"><span class="box_title">:</span></td>
        <td height="134" align="left"><textarea name="Bio" id="Bio" class="tb3" cols="40" rows="5" style="resize:none; width:350px; height:100px;" tabindex="9"><?php echo stripslashes($JudgesDetails['Bio']);?></textarea></td>
      </tr>
      <tr>
        <td height="45">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="left" valign="top"><input type="file" name="ProfileImage" id="ProfileImage" class="tb1" size="20" tabindex="10" /></td>
        <td align="left" valign="top"><span style="padding-top:10px;"><span class="box_title">Head judge</span></span></td>
        <td valign="top" align="center"><span class="box_title">:</span></td>
        <td align="left" valign="top"><input type="checkbox" name="IsHead" id="IsHead" value="1" <?php if($JudgesDetails['IsHead'] == 1){echo "checked"; } ?> /></td>
      </tr>
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="45" colspan="7"><table width="100%" height="42" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="19%" align="left"><span class="asterickmandatory"><span class="asterick">*</span> - indicates a required field.</span></td>
            <td width="8%" align="left"><span class="btn_bx"><input type="button" name="updatejudgesbutton" id="updatejudgesbutton" value="Update" onClick="return validateEditJudges('E');" tabindex="10"></span> 
			
			 <input type="hidden" name="EditJudgesICode" id="EditJudgesICode" value="<?php echo $this->uri->segment(4);?>" />
			<input type="hidden" name="LoginCredentialICode" id="LoginCredentialICode" value="<?php echo $JudgesDetails['LoginCredentialICode'];?>" /></td>
            <td width="69%" align="left"><span class="btn_bx"><input type="button" name="clear" id="clear" value="Cancel" tabindex="11" onclick="location.href='<?php echo base_url();?>admin/user/managejudges/'"/></span></td>
            <td width="4%" align="left">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
    </table>
	</form>
</div>
    </div>
  </div>
</div></td>
      </tr>
    </table>