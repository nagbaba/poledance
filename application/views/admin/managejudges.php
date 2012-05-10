<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<?php if($this->session->flashdata('upload_error') != '') { ?>
<script type="text/javascript">
$(document).ready(function() {
  // Handler for .ready() called.
  jAlert('<?php echo $this->session->flashdata('upload_error');?>', 'Pole Dance', '');
});
	
</script>
<?php }?>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Manage Judges </h1>
  </div>
  
  <div style="float:right; padding-top:10px; padding-right:200px;"><a href="<?php echo base_url();?>admin/user/addjudges/"  style="color:black; font-weight:bold; text-decoration: none; padding-left: 8px;"><img src="<?php echo base_url();?>images/add.png" width="32" height="32" border="0"  alt="Add New Judge" title="Add New Judge"/>&nbsp;Add New Judge</a></div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
	
	
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;"><table width="95%" border="0" cellspacing="0" align="center">
  <tr>
    <td align="left"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
	<thead>
		<tr>
			<th width="21%" height="32" align="left">First Name</th>
			<th width="21%" align="left">Last Name</th>
			<th width="29%" align="left">Email Address</th>
			<th width="12%" align="left">Created Date</th>
			<td width="8%" align="center" class="th_css">Status</th>
			<td width="9%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(!empty($JudgesDetails)){
			foreach($JudgesDetails as $row){
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($row['FirstName']), 19);?></td>
              <td class="left"><?php echo getMaxFieldLength(ucwords($row['LastName']), 23);?></td>
              <td class="left"><?php echo getMaxFieldLength($row['EmailAddress'], 38);?></td>
              <td class="left"><?php echo getDateDisplay($row['CreatedDate']);?></td>
			  <!--td class="center">07/06/2010</td-->
              <td class="center" id="status<?php echo $row['JudgesICode'];?>"><?php echo getUserStatus($row['IsActive'], 'judges_master', $row['JudgesICode'], 'Judge', 'JudgesICode'); ?></td>
			  
              <td class="center"><a href="<?php echo base_url();?>admin/user/editjudges/<?php echo $row['JudgesICode'];?>/"><img src="<?php echo base_url();?>images/edit.png" border="0" width="16" height="16" alt="Edit Judge" title="Edit Judge"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
			  <img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete Judge" title="Delete Judge" style="cursor:pointer;" onclick="deleteJudges('<?php echo $row['JudgesICode'];?>');"/>			  </td>
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
			"aoColumns": [ null, null, null, { "sType": "uk_date" } ]
	});
});
</script>