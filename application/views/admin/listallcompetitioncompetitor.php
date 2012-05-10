<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<link href="<?php echo base_url(); ?>css/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>js/facebox.js" type="text/javascript"></script>
<script>
function updateTime(CompetitionCompetitorICode, CompetitionICode)
{
	if($('#CompetitionStartTimeHour'+CompetitionCompetitorICode).val()==""){
   		jAlert('Please select competition start time.', 'Pole Dance', 'CompetitionStartTimeHour'+CompetitionCompetitorICode);
		return false;
    }
	if($('#CompetitionStartTimeMiniute'+CompetitionCompetitorICode).val()==""){
   		jAlert('Please select competition start miniute.', 'Pole Dance', 'CompetitionStartTimeMiniute'+CompetitionCompetitorICode);
		return false;
    }
	if($('#CompetitionEndTimeHour'+CompetitionCompetitorICode).val()==""){
   		jAlert('Please select competition start time.', 'Pole Dance', 'CompetitionEndTimeHour'+CompetitionCompetitorICode);
		return false;
    }
	if($('#CompetitionEndTimeMiniute'+CompetitionCompetitorICode).val()==""){
   		jAlert('Please select competition start miniute.', 'Pole Dance', 'CompetitionEndTimeMiniute'+CompetitionCompetitorICode);
		return false;
    }
	
	var startTimeDate = new Date(2008, 0, 1, Number($('#CompetitionStartTimeHour'+CompetitionCompetitorICode).val()) + ($('#CompetitionStartTimeMeridian'+CompetitionCompetitorICode).val()=="1" ? 12:0), $('#CompetitionStartTimeMiniute'+CompetitionCompetitorICode).val(), 0, 0);

	var endTimeDate = new Date(2008, 0, 1, Number($('#CompetitionEndTimeHour'+CompetitionCompetitorICode).val()) + ($('#CompetitionEndTimeMeridian'+CompetitionCompetitorICode).val()=="1" ? 12:0),	$('#CompetitionEndTimeMiniute'+CompetitionCompetitorICode).val(), 0, 0);
	
	if( startTimeDate > endTimeDate) 
	{
		jAlert('End Time should be greater than Start Time.', 'Pole Dance', 'EndCompetitionMiniute'+CompetitionCompetitorICode);
		return false;
	}
	
	var updatecompstarttime = base_url+'admin/user/updatecompstarttime/';
	var CompetitionStartTimeHour = $('#CompetitionStartTimeHour'+CompetitionCompetitorICode).val();
	var CompetitionStartTimeMiniute = $('#CompetitionStartTimeMiniute'+CompetitionCompetitorICode).val();
	var CompetitionEndTimeHour = $('#CompetitionEndTimeHour'+CompetitionCompetitorICode).val();
	var CompetitionEndTimeMiniute = $('#CompetitionEndTimeMiniute'+CompetitionCompetitorICode).val();
	
	$.ajax({
		type: "POST",
		url: updatecompstarttime,  
		data: {"CompetitionCompetitorICode": CompetitionCompetitorICode, "CompetitionStartTimeHour": CompetitionStartTimeHour, "CompetitionStartTimeMiniute": CompetitionStartTimeMiniute, "CompetitionEndTimeHour": CompetitionEndTimeHour, "CompetitionEndTimeMiniute": CompetitionEndTimeMiniute },  
		success: function(msg)
		{ 
			//alert(msg); return false;
			window.location.href = base_url+'admin/user/listallcompetitioncompetitor/'+CompetitionICode+'/';
		}
	});
}
</script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Manage Competition Competitor </h1>
  </div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;">
<!--<div style="padding-left:93px;"><br /><span class="box_title">Competition Name :</span> <span style="font-size:15px;color:#AD2E76; font-weight:bold; "><?php echo $CompetitionName; ?></span><span style="padding-left:730px;"><img src="<?php echo base_url();?>images/back.png" title="Back" alt="Back" /></span><br /><br /></div>-->
<div><table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="47%" align="left"><span class="box_title">Competition Name :</span> <span style="font-size:15px;color:#AD2E76; font-weight:bold; "><?php echo $CompetitionName; ?></span></td>
    <td width="3%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="11%" align="left"><img src="<?php echo base_url();?>images/back.png" title="Back" alt="Back" style="cursor:pointer;" onclick="location.href='<?php echo base_url();?>admin/user/managestartcompetition/'"/></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</div>
<table width="85%" border="0" cellspacing="0" align="center">
  <tr>
    <td align="left"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
	<thead>
		<tr>
			<th width="5%" height="32" align="left">Order</th>
			<th width="28%" align="left">Competitor Name</th>
			<th width="15%" align="left">Competition Date </th>
			<th width="20%" align="left">Start Time (HH : MM) </th>
			<th width="21%" align="left">End Time (HH : MM) </th>
			<td width="11%" align="center" class="th_css">Action<span class="center">
			  <input type="hidden" name="EditAction" id="EditAction" value="" />
			</span></td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(count($CompDetails) > 0 ){
			foreach($CompDetails as $row){
			
			//get competitor name
			//$CompetitorName = $this->home->getSingleFieldValue();
			$SingleWhere = "CompetitorICode = '".$row['CompetitorICode']."'";
			$CompetitorName = $this->home->getSingleFieldValue('competitor_master', 'FullName', $SingleWhere);
			
			$Starthour = date('G', strtotime($row['CompetitionStartTime']));
			$Startmin = date('i', strtotime($row['CompetitionStartTime']));
			
			$Endhour = date('G', strtotime($row['CompetitionEndTime']));
			$Endmin = date('i', strtotime($row['CompetitionEndTime']));
			
		  ?>
		<tr class="gradeC">
			<td height="39" class="left"><?php echo $row['CompetitorOrder'];?></td>
              <td height="39" class="left"><?php echo getMaxFieldLength(ucwords($CompetitorName), 25);?></td>
              <td height="39" class="left"><?php echo getDateDisplay($row['CompetitionDate']);?></td>
              <td class="left" id="StartTimeId<?php echo $row['CompetitionCompetitorICode']; ?>">
			  <select name='CompetitionStartTimeHour<?php echo $row['CompetitionCompetitorICode']; ?>' id='CompetitionStartTimeHour<?php echo $row['CompetitionCompetitorICode']; ?>' class='simpledrop'>
			  <option value=''>Hour</option><option value='0' <?php if(0 == $Starthour){echo 'selected';}?>>0</option><?php for($i=1; $i<=23; $i++){ ?>
			  <option value='<?php echo $i;?>' <?php if($i == $Starthour){echo 'selected';}?>><?php echo $i;?></option><?php } ?>
			  </select>                <strong>:</strong>&nbsp;
			  <select name='CompetitionStartTimeMiniute<?php echo $row['CompetitionCompetitorICode']; ?>' id='CompetitionStartTimeMiniute<?php echo $row['CompetitionCompetitorICode']; ?>' class='simpledrop'>
			  <option value=''>Miniute</option><option value='0' <?php if(0 == $Startmin){echo 'selected';}?>>0</option><?php for($k=1; $k<=59; $k++){?>
			  <option value='<?php echo $k;?>' <?php if($k == $Startmin){echo 'selected';}?>><?php echo $k;?></option><?php } ?>
			  </select>			  </td>
              <td class="left" id="EndTimeId<?php echo $row['CompetitionCompetitorICode']; ?>">
			  <select name='CompetitionEndTimeHour<?php echo $row['CompetitionCompetitorICode']; ?>' id='CompetitionEndTimeHour<?php echo $row['CompetitionCompetitorICode']; ?>' class='simpledrop'>
			  <option value=''>Hour</option><option value='0' <?php if(0 == $Endhour){echo 'selected';}?>>0</option><?php for($i=1; $i<=23; $i++){?>
			  <option value='<?php echo $i;?>' <?php if($i == $Endhour){echo 'selected';}?>><?php echo $i;?></option><?php } ?>
			  </select> 
			  &nbsp;<strong>:</strong>&nbsp;
			  <select name='CompetitionEndTimeMiniute<?php echo $row['CompetitionCompetitorICode']; ?>' id='CompetitionEndTimeMiniute<?php echo $row['CompetitionCompetitorICode']; ?>' class='simpledrop'>
			  <option value=''>Miniute</option><option value='0' <?php if(0 == $Endmin){echo 'selected';}?>>0</option><?php for($k=1; $k<=59; $k++){?>
			  <option value='<?php echo $k;?>' <?php if($k == $Endmin){echo 'selected';}?>><?php echo $k;?></option><?php } ?>
			  </select></td>
              <td class="center" id="ActionId<?php echo $row['CompetitionCompetitorICode']; ?>"><img src="<?php echo base_url();?>images/save.png" border="0" width="24" height="24" alt="Edit Time" title="Edit Time" style="cursor:pointer;" onclick="updateTime('<?php echo $row['CompetitionCompetitorICode']; ?>', '<?php echo $this->uri->segment(4);?>');" /></td>
		</tr>
		<?php }} ?>
	</tbody>
</table></td>
  </tr>
</table></div>
    </div>
  </div>
</div></td>
      </tr>
    </table>

<link href="<?php echo base_url(); ?>css/themes/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" >				
<link href="<?php echo base_url(); ?>css/demo_table_jui.css" rel="stylesheet" type="text/css" >	
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTable.js"></script>
	
<script language="javascript">
$(document).ready(function() {
	oTable = $('#tablegrid1').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [ null, null, null, { "sType": "uk_date" }, { "sType": "uk_date" } ]
	});
});
</script>