<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<!-- Tooltip scripts -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.tooltip.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip_jquery.dimensions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tooltip_jquery.js"></script>

<script>
function refreshpage() { window.location.href = base_url+'competition/postResult/'; } // refresh this page
function backurl() { window.location.href = base_url+'competition/startedcompetitionlist'; } // go to back page

function checkMaxScore(val, minscore, maxscore, fieldname) // chaeck max secured score
{
	if(val != '')
	{
		if(Number(minscore) > 0)
		{
			if((Number(val) < Number(minscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}
		else
		{
			//alert('-ive');
			if((Number(val) > Number(minscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}

		if(Number(maxscore) > 0)
		{
			//alert('+ive');
			if((Number(val) > Number(maxscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}
		else
		{
			//alert('-ive');
			if((Number(val) < Number(maxscore)))
			{
				jAlert('Your points should be in given range.', 'Yombook', fieldname);
				$("#"+fieldname).val('');
				return false;
			}
		}
	}
}

// ENTER ONLY NUMBER IN TEXTBOX
/*function isNumberKey(evt)
 {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45 && charCode != 46)
  return false;
  return true;
 }*/
 // for tooltip
 $(function() {
$('.tooltip_popup').tooltip({
	track: true,
	delay: 0,
	showURL: false,
	extraClass: "right"
});
});

</script>
    <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <td><div class="box">
                <div class="heading">
                   
</div>
                <div>&nbsp;</div>
                <div class="content">
<table width="970" border="0">
  <tr>
    <td width="22%"> <h1 style="color:#AD2E76;">Judges</h1></td>
    <td> <h1 style="color:#AD2E76; padding-left:35px;">Competitions</h1>  
      <div style="float:right;"></div></td>
    </tr>
  <tr>
    <td height="23" valign="top">
      <table width="98%" border="0" style="background-color:#F3F3F3;">
        <tr>
          <td height="4"></td>
          </tr>
        <?php if(!empty($JudgesDetails)){ foreach($JudgesDetails as $v) {?>
        <tr>
          <td height="30" style="padding-left:5px;"><a href="<?php echo base_url();?>competition/alljudges/<?php echo $v['JudgesICode'];?>/" class="NameLink"><?php echo getMaxFieldLength(ucwords($v['FullName']), 22);?></a></td>
          </tr>
        <?php } }?>
         <tr>
          <td height="4"></td>
          </tr>
        </table></td>
    <td valign="top"><table width="90%" border="0" cellspacing="0" align="center">
  <tr>
    <td align="left"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
	<thead>
		<tr>
			<th width="56%" height="32" align="left">Competition Name</th>
			<th width="29%" align="left">Competition Date</th>
			<td width="15%" align="left" class="th_css">Action</th>
			</tr>
	</thead>
	<tbody>
		<?php 
		  	if(!empty($CompetitionDetails)){
			foreach($CompetitionDetails as $row){
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($row['CompetitionName']), 25);?></td>
              <td class="left"><?php echo getDateDisplay($row['CompetitionDate']);?></td>
              <td class="left" ><a href="<?php echo base_url();?>competition/judgeresult/<?php echo $row['CompetitionICode']; ?>/<?php echo $JICode; ?>/" class="tlink">View</a> </td>
			  </tr>
		<?php }} ?>
	</tbody>
</table></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
</div>
                </div>

                   </td>
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
			"aoColumns": [ null, { "sType": "uk_date" }, { "sType": "uk_date" } ]
	});
});
</script>

