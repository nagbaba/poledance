<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<link href="<?php echo base_url(); ?>css/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>js/facebox.js" type="text/javascript"></script>

<table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="color:#AD2E76;">Manage Divisions </h1>
  </div>
  
  <div style="float:right; padding-top:10px; padding-right:200px;"><img src="<?php echo base_url();?>images/add.png" width="32" height="32" border="0"  alt="Add New Division" title="Add New Division" style="cursor:pointer;" onclick="openfaceboxfordivision('adddiv', '')"/><a href="#" onclick="openfaceboxfordivision('adddiv', '')" style="color:black; font-weight:bold; text-decoration: none; padding-left: 4px;">Add New Division</a></div>
  <div>  </div>
  <div class="content">
    <div style="display: inline-block; width: 100%; margin-bottom: 15px;
 clear: both;"></div>
    <div>
	
      <div style="background: none repeat scroll 0% 0% rgb(252, 252, 
252); border: 1px solid  #E8E8E8; padding: 10px;"><table width="68%" border="0" cellspacing="0" align="center">
  <tr>
    <td align="left"><table cellpadding="0" cellspacing="0" border="0" class="display" id="tablegrid1" width="103%">
	<thead>
		<tr>
			<th width="61%" height="32" align="left">Division Name</th>
			<th width="15%" align="left">Created Date</th>
			<td width="9%" align="center" class="th_css">Status</th>
			<td width="15%" align="center" class="th_css">Action</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		  	if(count($DivisionDetails) > 0 ){
			foreach($DivisionDetails as $row){
		  ?>
		<tr class="gradeC">
			<td class="left"><?php echo getMaxFieldLength(ucwords($row['DivisionName']), 45);?></td>
              <td class="center"><?php echo getDateDisplay($row['CreatedDate']);?></td>
			  <!--td class="center">07/06/2010</td-->
              <td class="center" id="status<?php echo $row['DivisionICode'];?>"><?php echo getUserStatus($row['IsActive'], 'division_master', $row['DivisionICode'], 'division', 'DivisionICode'); ?></td>
			  
              <td class="center">
			  <!--<img src="<?php echo base_url();?>images/add_image.png" onclick="openfaceboxfordivision('addsection', '<?php echo $row['DivisionICode'];?>')" border="0" width="16" height="16" alt="Add Section" title="Add Section" style="cursor:pointer;"/>
			  &nbsp;&nbsp;&nbsp;&nbsp;--><img src="<?php echo base_url();?>images/edit.png" onclick="openfaceboxfordivision('editdiv', '<?php echo $row['DivisionICode'];?>')" border="0" width="16" height="16" alt="Edit Division" title="Edit Division" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;&nbsp;
			  <img src="<?php echo base_url();?>images/delete.png" border="0" width="16" height="16" alt="Delete Division" title="Delete Division" style="cursor:pointer;" onclick="deleteDivision('<?php echo $row['DivisionICode'];?>');"/></td>
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
 function openfaceboxfordivision(actdiv, divid)
	{
		$.post("<?php echo base_url().'admin/user/adddivision/'; ?>"+actdiv+"/"+divid, 
		
		function(theResponse){
			jQuery.facebox(theResponse);								
		});
	}
	
$(document).ready(function() {
	oTable = $('#tablegrid1').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [ null, { "sType": "uk_date" } ]
	});
});
</script>