<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Event Admin List </h1>
  </div>
  
  <div style="float:right; padding-top:10px; padding-right:100px;"><a  style="color:black; font-weight:bold; text-decoration: none; padding-left: 8px;" href="<?php echo base_url();?>admin/user/addeventadmin/"><img src="<?php echo base_url();?>images/add_new_user.png" width="32" height="32" border="0"  alt="Add New Event Admin" title="Add New Event Admin"/> &nbsp;Add New Event Admin</a></div>
  
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
			<th width="20%" height="32" align="left">First Name</th>
			<th width="20%" align="left">Last Name</th>
			<th width="30%" align="left">Email Address</th>
			<th width="11%" align="left">Created Date</th>
			<td width="9%" align="center" class="th_css">Status</th>
			<td width="10%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(count($EventAdminDetails) > 0 ){
			foreach($EventAdminDetails as $row){
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($row['FirstName']), 20);?></td>
              <td class="left"><?php echo getMaxFieldLength(ucwords($row['LastName']), 20);?></td>
              <td class="left"><?php echo  getMaxFieldLength($row['EmailAddress'], 40);?></td>
              <td class="left"><?php echo getDateDisplay($row['CreatedDate']);?></td>
			  <!--td class="center">07/06/2010</td-->
              <td class="center" id="status<?php echo $row['EventAdminICode'];?>"><?php echo getUserStatus($row['IsActive'], 'event_admin_master', $row['EventAdminICode'], 'user', 'EventAdminICode'); ?></td>
			  
              <td class="center"><a href="<?php echo base_url();?>admin/user/editeventadmin/<?php echo $row['EventAdminICode'];?>/"><img src="<?php echo base_url();?>images/edit.png" border="0" width="16" height="16" alt="Edit Event Admin" title="Edit Event Admin"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
			  <img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete Event Admin" title="Delete Event Admin" style="cursor:pointer;" onclick="deleteEventAdmin('<?php echo $row['EventAdminICode'];?>');"/>			  </td>
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