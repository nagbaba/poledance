<style>
.tb1 {
	background-image:url(../../../images/form_bg.jpg);
	background-repeat:repeat-x;
	border:1px solid #d1c7ac;
	width: 230px;
	height:24px;
	color:#000;
	padding:5px;
	margin-right:4px;
	margin-bottom:8px;
	font-size:15px;
	font-family:Arial, Helvetica, sans-serif;
	line-height:25px;
}
.box_title {font-size:15px; color:#313131; margin:0px;  padding:0px 0px 0px 0px; letter-spacing:inherit;}
span.btn_bx      						{ background:url(../../../images/l_btn_left.jpg) no-repeat left top ; height:40px ; line-height:35px ; float:left ; padding:0 0 0 7px ; width:auto; cursor:pointer; text-decoration:none;}
span.btn_bx input 						{ background:url(../../../images/l_btn_right.jpg) no-repeat right top; height:40px; line-height:35px ; float:left ; color:#ffffff ; font-size:14px ; border:none ; width:auto; padding:0px 9px 0px 0px; cursor:pointer;text-decoration:none;}

</style>
<script language="JavaScript" src="<?php echo base_url(); ?>js/jquery-1.4.3.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/multiSelect_dropdown.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>css/multiSelect_dropdown.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>js/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox() 
    })

$(document).ready( function() {
	$("#SectionICode").multiSelect({ selectAllText: 'Select All' });
});
</script>
<form name="adddivisionform" id="adddivisionform" action="<?php echo base_url().'admin/user/mapsection/';?>" method="post">
<table width="90%" border="0" cellpadding="0" cellspacing="2" align="center">
<tr>
    <td width="23%" align="right">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td height="42" align="left"><span class="box_title">Division Name </span></td>
    <td align="left">:</td>
    <td width="65%" align="left"><input name="DivisionName" id="DivisionName" value="<?php echo $DivisionValue;?>" type="text" style="width:280px; margin-top:8px;" maxlength="40" onkeyup="trimFirstSpace('DivisionName');"  tabindex="1" class="tb1" onkeypress="enterPage('adddivisionbutton', event);" /></td>
    <td width="8%" align="left">&nbsp;</td>
</tr>
<tr>
  <td height="40" align="left"><span class="box_title">Select Section </span></td>
  <td align="left">:</td>
  <td align="left"><?php if(count($SectionDetails) > 0 ){ ?>
          <select name="SectionICode" id="SectionICode" style="width:264px;line-height:25px;" tabindex="2" multiple="multiple">
            <option class="box_drop" value="">Select </option>
            <?php foreach($SectionDetails as $row){
				if(in_array($row['SectionICode'], $SectionArray)){ $VSel = "selected";} else{  $VSel = "";}
			?>
            <option class="box_drop" value="<?php echo $row['SectionICode'];?>" <?php echo $VSel;?>><?php echo $row['SectionName'];?></option>
            <?php } ?>
      </select>
          <?php } ?>
		  
    <input type="hidden" name="DivisionICode" id="DivisionICode" value="<?php echo $this->uri->segment(5);?>" />
	</td>
  <td align="left"><span class="btn_bx">
      <input type="button" name="adddivisionbutton" id="adddivisionbutton" tabindex="3" value="<?PHP echo $ButtonValue; ?>" class="text_box" onclick="return addDivisionValidate();"/></span></td>
</tr>

  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</form>
