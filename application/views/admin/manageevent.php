<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Manage Events </h1>
  </div>
  
  <div style="float:right; padding-top:10px; padding-right:100px;"><a href="<?php echo base_url();?>admin/user/adduser/"><img src="<?php echo base_url();?>images/add_new_user.png" width="32" height="32" border="0"  alt="Add New User" title="Add New User"/></a></div>
  
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
			<th width="25%" height="32" align="left">Event Name</th>
			<th width="24%" align="left">Contact Name</th>
			<th width="25%" align="left">Email Address</th>
			<th width="11%" align="left">Created Date</th>
			<td width="7%" align="center" class="th_css">Status</th>
			<td width="8%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(count($EventDetails) > 0 ){
			foreach($EventDetails as $row){
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo substr(ucwords($row['FirstName']), 0, 20);?></td>
              <td class="left"><?php echo substr(ucwords($row['LastName']), 0,20);?></td>
              <td class="left"><?php echo substr($row['EmailAddress'], 0, 30);?></td>
              <td class="center"><?php echo getDateDisplay($row['CreatedDate']);?></td>
			  <!--td class="center">07/06/2010</td-->
              <td class="center" id="status<?php echo $row['UserICode'];?>"><?php echo getUserStatus($row['IsActive'], 'user_master', $row['UserICode'], 'user', 'UserICode'); ?></td>
			  
              <td class="center"><a href="<?php echo base_url();?>admin/user/edituser/<?php echo $row['UserICode'];?>/"><img src="<?php echo base_url();?>images/edit.png" border="0" width="16" height="16" alt="Edit User" title="Edit User"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
			  <img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete User" title="Delete User" style="cursor:pointer;" onclick="deleteUser('<?php echo $row['UserICode'];?>');"/>			  </td>
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
			"aoColumns": [ null, null, null, null, { "sType": "uk_date" }, null ]
	});
});
</script>