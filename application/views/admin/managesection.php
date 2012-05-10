<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<script>
//delete section from section_master and subsection_master table
function deleteSection(SectionICode)
{
	jConfirm('Do you want to delete this section?', 'Pole Dance', function(r) {
	if(r == true)
	{
		window.location.href = base_url+'admin/user/deleteSection/'+SectionICode+'/';
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
    <h1 style="color:#AD2E76;">Manage Sections</h1>
  </div>
  
  <div style="float:right; padding-top:10px; padding-right:200px;"><a href="<?php echo base_url().'admin/user/addsection/'?>"  style="color:black; font-weight:bold; text-decoration: none; padding-left: 8px;"><img src="<?php echo base_url();?>images/add.png" width="32" height="32" border="0"  alt="Add New Section" title="Add New Section" style="cursor:pointer;"/>&nbsp;Add New Section</a></div>
  
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
	
	
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;"><table width="80%" border="0" cellspacing="0" align="center">
  <tr>
    <td align="left"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="100%">
	<thead>
		<tr>
			<th width="38%" height="32" align="left">Section  Name</th>
			<th width="12%" align="left">Min Point</th>
			<th width="12%" align="left">Max Point</th>
			<th width="17%" align="left">Created Date</th>
			<td width="10%" align="center" class="th_css">Status</th>
			<td width="11%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(count($SectionDetails) > 0 ){
			foreach($SectionDetails as $row){
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($row['SectionName']), 22);?></td>
              <td class="left"><?php echo $row['MinPoint'];?></td>
              <td class="left"><?php echo $row['MaxPoint'];?></td>
              <td class="left"><?php echo getDateDisplay($row['CreatedDate']);?></td>
			  <td class="center" id="status<?php echo $row['SectionICode'];?>"><?php echo getUserStatus($row['IsActive'], 'section_master', $row['SectionICode'], 'section', 'SectionICode'); ?></td>
			  <td class="center"><a href="<?php echo base_url();?>admin/user/editsection/<?php echo $row['SectionICode'];?>/"><img src="<?php echo base_url();?>images/edit.png" border="0" width="16" height="16" alt="Edit Section" title="Edit Section" style="cursor:pointer;"/></a>
			  &nbsp;<img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete Section" title="Delete Section" style="cursor:pointer; padding-left:25px;" onclick="deleteSection('<?php echo $row['SectionICode'];?>');"/>			  </td>
		</tr>
		<?php }}?>
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
			"aoColumns": [ null, null, null, null, { "sType": "uk_date" } ]
	});
});
</script>