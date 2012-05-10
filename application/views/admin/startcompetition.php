<?php
		$WhereFieldValue = "CompetitionICode = '".$this->uri->segment(4)."'";
		$CompetitionDetails = $this->home->getAllDetailsFromId('competition_master', $WhereFieldValue)
?>
<!-- date picker css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker_style.css">
<link href="<?php echo base_url(); ?>css/themes/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script >

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
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox() 
    })

// startCompetition	 validate
function startCompetitionValidate(CompetitionICode)
{

	if($('#StartCompetitionHour').val()==""){
   		jAlert('Please select start competition time.', 'Pole Dance', 'StartCompetitionHour');
		return false;
    }
	if($('#StartCompetitionMiniute').val()==""){
   		jAlert('Please select start competition time.', 'Pole Dance', 'StartCompetitionMiniute');
		return false;
    }
	
	if($('#EndCompetitionHour').val()==""){
   		jAlert('Please select end competition time.', 'Pole Dance', 'EndCompetitionHour');
		return false;
    }
	if($('#EndCompetitionMiniute').val()==""){
   		jAlert('Please select end competition time.', 'Pole Dance', 'EndCompetitionMiniute');
		return false;
    }
	
	var startTimeDate = new Date(2008, 0, 1, Number($('#StartCompetitionHour').val()) + ($('#StartCompetitionMeridian').val()=="1" ? 12:0), 
	$('#StartCompetitionMiniute').val(), 0, 0);

	var endTimeDate = new Date(2008, 0, 1, Number($('#EndCompetitionHour').val()) + ($('#EndCompetitionMeridian').val()=="1" ? 12:0), 
	$('#EndCompetitionMiniute').val(), 0, 0);
	
	if( startTimeDate > endTimeDate) 
	{
		jAlert('End Time should be greater than Start Time.', 'Pole Dance', 'EndCompetitionMiniute');
		return false;
	}
	if($('#CompetitionType').val()==""){
   		jAlert('Please select competition type.', 'Pole Dance', 'CompetitionType');
		return false;
    }
}
</script>
<form name="startcompetition" id="startcompetition" method="post" action="<?php echo base_url();?>admin/user/addstartcompetition/<?php echo $this->uri->segment(4);?>/"  onsubmit="return startCompetitionValidate('<?php echo $this->uri->segment(4);?>');" > 
<table width="90%" border="0" cellpadding="0" cellspacing="2" align="center">
<tr>
    <td width="26%" height="31" align="right">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td height="38" align="left"><span class="box_title">Competition Date </span></td>
  <td align="left">:</td>
  <td align="left"><input type="text" value="<?php echo getDateDisplay($CompetitionDetails['CompetitionDate']);?>" class="tb3" style="width:280px;" tabindex="1" name="StartCompetitionDate" id="StartCompetitionDate" maxlength="20"  onkeyup="trimFirstSpace('StartCompetitionDate');" onkeypress="enterPage('addnewcompetitionbutton', event);" readonly="readonly" /></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
    <td height="42" align="left"><span class="box_title">Start Time</span></td>
    <td align="left">:</td>
    <td width="63%" align="left">
      <select name="StartCompetitionHour" id="StartCompetitionHour" class="tb_drop" style="width:86px; height:32px; padding-left:8px; margin-top:8px;" tabindex="2" >
        <option value="" class="box_drop">Hour</option>
        <?php for($i=1; $i<=12; $i++){?>
        <option class="box_drop" value="<?php echo $i;?>"><?php echo $i;?></option>
        <?php } ?>
      </select>
      &nbsp;&nbsp;&nbsp;
      <select name="StartCompetitionMiniute" id="StartCompetitionMiniute" class="tb_drop" style="width:95px; height:32px; padding-left:8px;  margin-top:8px;" tabindex="3" >
        <option value="" class="box_drop">Miniutes</option>
        <?php for($k=1; $k<=59; $k++){?>
        <option class="box_drop" value="<?php echo $k;?>"><?php echo $k;?></option>
        <?php } ?>
      </select>
&nbsp;&nbsp;&nbsp;
<select name="StartCompetitionMeridian" id="StartCompetitionMeridian" class="tb_drop" style="width:70px; height:32px; padding-left:10px;margin-top:8px;" tabindex="4" >
  <option class="box_drop" value="0">AM</option>
  <option class="box_drop" value="1">PM</option>
</select></td>
    <td width="8%" align="left">&nbsp;</td>
</tr>

<tr>
  <td height="42" align="left"><span class="box_title">End Time</span></td>
  <td align="left">:</td>
  <td align="left"><select name="EndCompetitionHour" id="EndCompetitionHour" class="tb_drop" style="width:86px; height:32px; padding-left:8px; margin-top:8px;" tabindex="2" >
    <option value="" class="box_drop">Hour</option>
    <?php for($i=1; $i<=12; $i++){?>
    <option class="box_drop" value="<?php echo $i;?>"><?php echo $i;?></option>
    <?php } ?>
  </select>
&nbsp;&nbsp;&nbsp;
<select name="EndCompetitionMiniute" id="EndCompetitionMiniute" class="tb_drop" style="width:95px; height:32px; padding-left:8px;  margin-top:8px;" tabindex="3" >
  <option value="" class="box_drop">Miniutes</option>
  <?php for($k=1; $k<=59; $k++){?>
  <option class="box_drop" value="<?php echo $k;?>"><?php echo $k;?></option>
  <?php } ?>
</select>
&nbsp;&nbsp;&nbsp;
<select name="EndCompetitionMeridian" id="EndCompetitionMeridian" class="tb_drop" style="width:70px; height:32px; padding-left:10px;margin-top:8px;" tabindex="4" >
  <option class="box_drop" value="0">AM</option>
  <option class="box_drop" value="1">PM</option>
</select></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="42" align="left"><span class="box_title">Competition Type </span></td>
  <td align="left">:</td>
  <td align="left"><select name="CompetitionType" id="CompetitionType" class="tb_drop" style="width:288px; height:32px; padding-left:10px;margin-top:8px;" tabindex="4" >
    <option class="box_drop" value="">Select Type</option>
    <option class="box_drop" value="Pole Fit">Pole Fit</option>
	<option class="box_drop" value="Pole Art">Pole Art</option>
	<option class="box_drop" value="Ultimate Pole Champion">Ultimate Pole Champion</option>
  </select></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td height="59" align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left"><span class="btn_bx">
      <input type="submit" name="addstartcompetitionbutton" id="addstartcompetitionbutton" tabindex="5" value="Start Competition" class="text_box"/></span></td>
  <td align="left">&nbsp;</td>
</tr>
</table>
</form>
<script type="text/javascript">
$(document).ready(function()
{
	$('#EndCompetitionDate').datepicker({
		changeMonth: true,
		changeYear: true
	});
});
</script>
