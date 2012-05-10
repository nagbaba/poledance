<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;"><?php //if($this->session->userdata('UserType') == 'E'){echo "Event ";}?>Manage Start Competitions </h1>
  </div>
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 20px 0px 0px 141px; padding-bottom:60px;">
<table width="75%" border="0" cellspacing="0" align="center">
  <tr>
    <td align="left"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
	<thead>
		<tr>
			<th width="43%" height="32" align="left">Competition Name</th>
			<th width="26%" align="left">Competition Date</th>
			<th width="20%" align="left">Created Date
			<td width="11%" align="center" class="th_css">Action</td>
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
              <td class="left"><?php echo getDateDisplay($row['CreatedDate']);?></td>
			  <td class="center" id="ActionICon<?php echo $row['CompetitionICode']; ?>">
              <?php if($row['IsStarted'] == 1){?>
              <img src="<?php echo base_url();?>images/tick2.png" border="0" width="24" height="24" style="cursor:pointer;" title="Competition Started"/>
              <?php } else {?>
               <img src="<?php echo base_url();?>images/start.png" border="0" width="24" height="24" alt="Start Competition" title="Start Competition" style="cursor:pointer;" onclick="return startcompetition('<?php echo $row['CompetitionICode']; ?>');" />
              <?php } ?>
              </td>
		</tr>
		<?php }} ?>
	</tbody>
</table></td>
  </tr>
</table>
	</div>
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
			"aoColumns": [ null, { "sType": "uk_date" }, { "sType": "uk_date" } ]
	});
});
</script>